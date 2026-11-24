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

# Login
resp = opener.open('https://pkl.smkn1ciamis.id/login')
token = re.search(r'name="_token"\s+value="([^"]+)"', resp.read().decode('utf-8')).group(1)
data = urllib.parse.urlencode({'_token': token, 'username': '242510639', 'password': '@Pra02032009'}).encode('utf-8')
opener.open('https://pkl.smkn1ciamis.id/login', data=data)

# Open create
create_url = "https://pkl.smkn1ciamis.id/siswa/jurnal/create?date=2026-11-24"
resp_create = opener.open(create_url)
html = resp_create.read().decode('utf-8')

# Search for csrf token in form id="jurnal-form"
form_token = re.search(r'id="jurnal-form".*?name="_token"\s+value="([^"]+)"', html, re.DOTALL)
if not form_token:
    form_token = re.search(r'name="_token"\s+value="([^"]+)"', html)
print("CSRF:", form_token.group(1))

# Find textarea/inputs
for tag in re.findall(r'<(?:input|textarea|select)[^>]+name="([^"]+)"[^>]*>', html):
    print("Field:", tag)

# Find cp options or hidden values
for m in re.findall(r'<option[^>]+value="([^"]*)"[^>]*>(.*?)</option>', html):
    print("Option:", m[0], "->", m[1].strip()[:70])
