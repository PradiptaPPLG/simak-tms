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

# 1. Login
resp = opener.open('https://pkl.smkn1ciamis.id/login')
html = resp.read().decode('utf-8')
token = re.search(r'name="_token"\s+value="([^"]+)"', html).group(1)

data = urllib.parse.urlencode({'_token': token, 'username': '242510639', 'password': '@Pra02032009'}).encode('utf-8')
opener.open('https://pkl.smkn1ciamis.id/login', data=data)
print("Logged in successfully!")

# 2. Check Jurnal list / calendar
resp = opener.open('https://pkl.smkn1ciamis.id/siswa/jurnal')
content = resp.read().decode('utf-8')

print("Page title or heading:")
for h in re.findall(r'<h[1-3][^>]*>(.*?)</h[1-3]>', content):
    print(" -", re.sub(r'<[^>]+>', '', h).strip())

# Check for 24 November
if "24" in content:
    matches = re.findall(r'href="([^"]*(?:2026-11-24|24)[^"]*)"', content)
    print("Matches for 24 in hrefs:", matches)

# Check if there is already a journal for 2026-11-24
dates = re.findall(r'(\d{1,2}\s+[A-Za-z]+\s+2026)', content)
print("Dates found in page:", set(dates))

# Try accessing create page for 2026-11-24
create_url = "https://pkl.smkn1ciamis.id/siswa/jurnal/create?date=2026-11-24"
try:
    resp_create = opener.open(create_url)
    create_html = resp_create.read().decode('utf-8')
    print("\nCreate URL:", create_url, "Status:", resp_create.status)
    print("Form action in create page:", re.findall(r'<form[^>]+action="([^"]+)"', create_html))
    
    # Check fields in form
    inputs = re.findall(r'<input[^>]+name="([^"]+)"[^>]*>', create_html)
    print("Inputs in create form:", inputs)
    
    # Check select options (kompetensi / cp)
    selects = re.findall(r'<select[^>]+name="([^"]+)"[^>]*>(.*?)</select>', create_html, re.DOTALL)
    for s_name, s_opts in selects:
        print(f"Select '{s_name}' options:")
        for opt in re.findall(r'<option[^>]+value="([^"]*)"[^>]*>(.*?)</option>', s_opts):
            print("   value:", opt[0], "label:", opt[1].strip()[:80])
            
except Exception as e:
    print("Error opening create URL:", e)
