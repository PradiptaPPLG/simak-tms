import { spawn } from 'child_process';
import fs from 'fs';

const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const chrome = spawn(chromePath, [
  '--headless=new',
  '--remote-debugging-port=9222',
  '--window-size=1280,800',
  '--disable-gpu',
  '--no-sandbox'
]);

await new Promise(r => setTimeout(r, 1500));

const testUrls = [
  { role: 'siswa', url: 'http://127.0.0.1:8000/preview/dashboard' },
  { role: 'mentor', url: 'http://127.0.0.1:8000/preview/admin/mentor' },
  { role: 'admin', url: 'http://127.0.0.1:8000/preview/admin/siswa' },
];

try {
  for (const item of testUrls) {
    const newTabRes = await fetch(`http://127.0.0.1:9222/json/new?${item.url}`, { method: 'PUT' });
    const target = await newTabRes.json();
    const ws = new WebSocket(target.webSocketDebuggerUrl);
    await new Promise(r => ws.onopen = r);

    let id = 1;
    function send(method, params = {}) {
      return new Promise((resolve) => {
        const msgId = id++;
        const handler = (event) => {
          const msg = JSON.parse(event.data);
          if (msg.id === msgId) {
            ws.removeEventListener('message', handler);
            resolve(msg);
          }
        };
        ws.addEventListener('message', handler);
        ws.send(JSON.stringify({ id: msgId, method, params }));
      });
    }

    await send('Page.enable');
    await send('Runtime.enable');
    await new Promise(r => setTimeout(r, 1500));

    // Check before scroll
    const beforeRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const aside = document.querySelector('aside');
        const header = document.querySelector('header');
        const asideRect = aside.getBoundingClientRect();
        const headerRect = header.getBoundingClientRect();
        const asideStyle = window.getComputedStyle(aside);
        return {
          asidePosition: asideStyle.position,
          asideTop: asideRect.top,
          asideLeft: asideRect.left,
          asideWidth: asideRect.width,
          asideHeight: asideRect.height,
          headerTop: headerRect.top,
          headerLeft: headerRect.left,
          windowScrollY: window.scrollY
        };
      })()`,
      returnByValue: true
    });

    console.log(`[${item.role.toUpperCase()}] Initial state:`, beforeRes.result?.value);

    // Scroll down 600px
    await send('Runtime.evaluate', {
      expression: `window.scrollTo({ top: 600, behavior: 'instant' });`
    });
    await new Promise(r => setTimeout(r, 500));

    // Check after scroll
    const afterRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const aside = document.querySelector('aside');
        const header = document.querySelector('header');
        const asideRect = aside.getBoundingClientRect();
        const headerRect = header.getBoundingClientRect();
        return {
          windowScrollY: window.scrollY,
          asideTop: asideRect.top,
          asideLeft: asideRect.left,
          asideWidth: asideRect.width,
          asideHeight: asideRect.height,
          headerTop: headerRect.top,
          headerLeft: headerRect.left
        };
      })()`,
      returnByValue: true
    });

    console.log(`[${item.role.toUpperCase()}] Scrolled (600px) state:`, afterRes.result?.value);

    // Take screenshot of scrolled page
    const screenshot = await send('Page.captureScreenshot', { format: 'png' });
    const shotPath = `C:\\xampp\\htdocs\\simak-tms\\screenshots\\verify_fixed_sidebar_${item.role}.png`;
    fs.writeFileSync(shotPath, Buffer.from(screenshot.result.data, 'base64'));
    console.log(`Saved screenshot: ${shotPath}`);

    ws.close();
  }
} finally {
  chrome.kill();
}
