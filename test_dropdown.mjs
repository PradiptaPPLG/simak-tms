import { spawn } from 'child_process';
import fs from 'fs';

const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const chrome = spawn(chromePath, [
  '--headless=new',
  '--remote-debugging-port=9222',
  '--window-size=1280,900',
  '--disable-gpu',
  '--no-sandbox'
]);

await new Promise(r => setTimeout(r, 1500));

try {
  const versionRes = await fetch('http://127.0.0.1:9222/json/version');
  const versionData = await versionRes.json();
  const browserWs = versionData.webSocketDebuggerUrl;

  const newTabRes = await fetch('http://127.0.0.1:9222/json/new?http://127.0.0.1:8000/preview/admin/mentor');
  const target = await newTabRes.json();
  const wsUrl = target.webSocketDebuggerUrl;

  const ws = new WebSocket(wsUrl);
  await new Promise(r => ws.onopen = r);

  let id = 1;
  function send(method, params = {}) {
    return new Promise((resolve) => {
      const msgId = id++;
      const handler = (event) => {
        const msg = JSON.parse(event.data);
        if (msg.id === msgId) {
          ws.removeEventListener('message', handler);
          resolve(msg.result);
        }
      };
      ws.addEventListener('message', handler);
      ws.send(JSON.stringify({ id: msgId, method, params }));
    });
  }

  await send('Page.enable');
  await send('Runtime.enable');

  await new Promise(r => setTimeout(r, 2000));

  // Click the 3-dots button
  const evalResult = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const btn = document.querySelector('button[title="Opsi Aksi Mentor"]');
        if (btn) {
          btn.click();
          const dd = document.querySelector('.action-dropdown:not(.hidden)');
          if (dd) {
            const rect = dd.getBoundingClientRect();
            const computed = window.getComputedStyle(dd);
            return {
              found: true,
              pos: computed.position,
              zIndex: computed.zIndex,
              rect: { top: rect.top, bottom: rect.bottom, left: rect.left, right: rect.right, width: rect.width, height: rect.height }
            };
          }
          return { found: false, error: 'dropdown still hidden' };
        }
        return { found: false, error: 'button not found' };
      })()
    `,
    returnByValue: true
  });

  console.log('Eval result:', JSON.stringify(evalResult.result.value, null, 2));

  // Take screenshot
  const screenshot = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync('C:\\xampp\\htdocs\\simak-tms\\screenshots\\test_dropdown_open.png', Buffer.from(screenshot.data, 'base64'));
  console.log('Screenshot saved to screenshots/test_dropdown_open.png');

  ws.close();
} finally {
  chrome.kill();
}
