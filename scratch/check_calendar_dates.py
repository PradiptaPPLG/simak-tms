import requests, re

s = requests.Session()
r = s.get('https://pkl.smkn1ciamis.id/login')
m = re.search(r'name="_token" value="([^"]+)"', r.text)
token = m.group(1) if m else ''

r = s.post('https://pkl.smkn1ciamis.id/login', data={
    '_token': token,
    'username': '242510639',
    'password': '@Pra02032009'
})

r = s.get('https://pkl.smkn1ciamis.id/siswa/jurnal')

with open('scratch/jurnal_page.html', 'w', encoding='utf-8') as f:
    f.write(r.text)

print('Logged in successfully.')

# Check links to /siswa/jurnal/create?date=... or /siswa/jurnal/...
dates = re.findall(r'/siswa/jurnal[^\s"\'<>]+', r.text)
print('Found journal URLs:')
for u in set(dates):
    print(u)

# Also check for 2026-11-20, 2026-11-23, 2026-11-24
for d in ['2026-11-20', '2026-11-21', '2026-11-22', '2026-11-23', '2026-11-24']:
    if d in r.text:
        print(f"Date {d} appears in HTML")
    else:
        print(f"Date {d} NOT in HTML")
