import os
import urllib.request

base_url = "https://koci.web.id"
dest_base = r"C:\xampp\htdocs\simak-tms\public"

assets = [
    "/assets/img/illustrations/cs-ilustration.svg",
    "/assets/img/images/hero2.jpeg",
    "/assets/img/images/hero2.webp",
    "/assets/img/images/hero-4.jpeg",
    "/assets/img/images/hero-4.webp",
    "/assets/img/images/hero3.jpg",
    "/assets/img/images/hero3.webp",
    "/assets/img/images/hero1.png",
    "/assets/img/images/koci-center.jpg",
    "/assets/img/images/koci.png",
    "/assets/img/images/koci-v6.png",
    "/assets/img/program/tms.png",
    "/assets/img/program/tms.webp",
    "/assets/img/program/jptm.png",
    "/assets/img/program/kresya.png",
    "/assets/img/program/tasya.png",
    "/assets/img/program/sasya.png",
    "/assets/img/program/insya.png",
    "/assets/img/program/komar2.png",
    "/assets/img/program/umkm.png",
    "/assets/img/program/ziskaf.png"
]

headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'}

for path in assets:
    url = base_url + path
    local_file = os.path.normpath(dest_base + path)
    os.makedirs(os.path.dirname(local_file), exist_ok=True)
    try:
        req = urllib.request.Request(url, headers=headers)
        with urllib.request.urlopen(req, timeout=10) as resp:
            data = resp.read()
            with open(local_file, 'wb') as f:
                f.write(data)
            print(f"Downloaded: {path} ({len(data)} bytes)")
    except Exception as e:
        print(f"Failed {path}: {e}")
