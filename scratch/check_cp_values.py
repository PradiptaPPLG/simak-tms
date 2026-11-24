import urllib.request
import urllib.parse
import http.cookiejar
import ssl
import re

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE
cj = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj), urllib.request.HTTPSHandler(context=ctx))

resp = opener.open('https://pkl.smkn1ciamis.id/login')
token = re.search(r'name="_token"\s+value="([^"]+)"', resp.read().decode('utf-8')).group(1)
data = urllib.parse.urlencode({'_token': token, 'username': '242510639', 'password': '@Pra02032009'}).encode('utf-8')
opener.open('https://pkl.smkn1ciamis.id/login', data=data)

create_url = "https://pkl.smkn1ciamis.id/siswa/jurnal/create?date=2026-11-24"
html = opener.open(create_url).read().decode('utf-8')

for tag in ['kompetensi_id', 'cp', 'cp_id', 'tanggal']:
    m = re.search(rf'name="{tag}"[^>]*value="([^"]*)"', html)
    if m:
        print(f"Default {tag}:", m.group(1))
    else:
        # Check if select or textarea
        m2 = re.search(rf'name="{tag}"[^>]*>(.*?)</', html, re.DOTALL)
        if m2:
            print(f"Content {tag}:", m2.group(1)[:80])
        else:
            print(f"{tag}: not found by value")
