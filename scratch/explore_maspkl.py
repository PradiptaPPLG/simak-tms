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

r = s.get('https://pkl.smkn1ciamis.id/siswa/dashboard')
print('Dashboard status:', r.status_code)
with open('scratch/dashboard_maspkl.html', 'w', encoding='utf-8') as f:
    f.write(r.text)

# Search all hrefs in dashboard
links = re.findall(r'<a[^>]+href="([^"]+)"[^>]*>(.*?)</a>', r.text, re.DOTALL)
print('Dashboard Links:')
for href, label in set([(h, re.sub(r'<[^>]+>', '', l).strip()) for h, l in links]):
    if label:
        print(f"  {label} -> {href}")

# Check profile page or settings
r_prof = s.get('https://pkl.smkn1ciamis.id/siswa/profil')
print('Profil status:', r_prof.status_code)
if r_prof.status_code == 200:
    with open('scratch/profil_maspkl.html', 'w', encoding='utf-8') as f:
        f.write(r_prof.text)

# Check daftar hadir
r_hadir = s.get('https://pkl.smkn1ciamis.id/siswa/daftar-hadir')
print('Daftar hadir status:', r_hadir.status_code)
if r_hadir.status_code == 200:
    with open('scratch/daftar_hadir_maspkl.html', 'w', encoding='utf-8') as f:
        f.write(r_hadir.text)
