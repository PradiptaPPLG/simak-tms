import os, subprocess
from PIL import Image

# 1. Run generate_new_logo.py
import generate_new_logo

# Read the SVG
svg_path = r"C:\xampp\htdocs\simak-tms\public\images\logo\simak-icon.svg"
with open(svg_path, "r", encoding="utf-8") as f:
    svg_content = f.read()

# Create HTML for Chrome rendering
html_content = f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  * {{ margin: 0; padding: 0; box-sizing: border-box; }}
  html, body {{ width: 512px; height: 512px; overflow: hidden; background: transparent; }}
  svg {{ display: block; width: 512px; height: 512px; }}
</style>
</head>
<body>
{svg_content}
</body>
</html>"""

html_path = r"C:\xampp\htdocs\simak-tms\scratch\render_icon.html"
with open(html_path, "w", encoding="utf-8") as f:
    f.write(html_content)

# Chrome path
chrome_path = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
if not os.path.exists(chrome_path):
    chrome_path = r"C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"

out_512 = r"C:\xampp\htdocs\simak-tms\public\images\logo\simak-icon.png"

# Execute headless browser screenshot
cmd = [
    chrome_path,
    "--headless",
    "--disable-gpu",
    "--force-device-scale-factor=1",
    "--hide-scrollbars",
    "--window-size=512,512",
    f"--screenshot={out_512}",
    f"file:///{html_path.replace(os.sep, '/')}"
]

print("Running command:", " ".join(cmd))
res = subprocess.run(cmd, capture_output=True, text=True)
print("Chrome exit code:", res.returncode)

if os.path.exists(out_512):
    print("512px PNG generated successfully. Size:", os.path.getsize(out_512))
    
    # Generate 128x128 and 64x64 with PIL Lanczos
    im = Image.open(out_512)
    # Ensure 512x512
    if im.size != (512, 512):
        im = im.crop((0, 0, 512, 512))
        im.save(out_512)
    
    im_128 = im.resize((128, 128), Image.Resampling.LANCZOS)
    out_128 = r"C:\xampp\htdocs\simak-tms\public\images\logo\simak-icon-128.png"
    im_128.save(out_128)
    print("128px PNG generated successfully. Size:", os.path.getsize(out_128))

    im_64 = im.resize((64, 64), Image.Resampling.LANCZOS)
    out_64 = r"C:\xampp\htdocs\simak-tms\public\images\logo\simak-icon-64.png"
    im_64.save(out_64)
    print("64px PNG generated successfully. Size:", os.path.getsize(out_64))

    # Also save to public/favicon.ico
    im_32 = im.resize((32, 32), Image.Resampling.LANCZOS)
    out_ico = r"C:\xampp\htdocs\simak-tms\public\favicon.ico"
    im_32.save(out_ico)
    print("Favicon.ico generated successfully.")
else:
    print("Error: 512px PNG not found!")
