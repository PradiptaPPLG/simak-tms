import requests, re

s = requests.Session()
r = s.get('https://pkl.smkn1ciamis.id/login')
m = re.search(r'name="_token" value="([^"]+)"', r.text)
token = m.group(1) if m else ''

s.post('https://pkl.smkn1ciamis.id/login', data={
    '_token': token,
    'username': '242510639',
    'password': '@Pra02032009'
})

r_dash = s.get('https://pkl.smkn1ciamis.id/dashboard')
with open('scratch/maspkl_real_dashboard.html', 'w', encoding='utf-8') as f:
    f.write(r_dash.text)

print("Saved dashboard. Finding 'hari_libur_rutin':")
idx = r_dash.text.find('hari_libur_rutin')
if idx != -1:
    print(r_dash.text[max(0, idx-300):min(len(r_dash.text), idx+1500)])
else:
    print("Not found")

# Also find modals in dashboard
modals = re.findall(r'<div[^>]*id="[^"]*modal[^"]*"[^>]*>.*?</div>', r_dash.text, re.DOTALL | re.IGNORECASE)
print(f"Found {len(modals)} modal divs")
