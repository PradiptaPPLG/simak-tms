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

for url in [
    'https://pkl.smkn1ciamis.id/dashboard',
    'https://pkl.smkn1ciamis.id/siswa/profile',
    'https://pkl.smkn1ciamis.id/siswa/absensi'
]:
    res = s.get(url)
    print(url, res.status_code)
    # search for libur
    matches = re.findall(r'.{0,60}libur.{0,60}', res.text, re.IGNORECASE)
    if matches:
        print(f"  Found 'libur' in {url}:")
        for m in matches[:5]:
            print("   *", m.strip())
    # search for shift
    matches_shift = re.findall(r'.{0,60}shift.{0,60}', res.text, re.IGNORECASE)
    if matches_shift:
        print(f"  Found 'shift' in {url}:")
        for m in matches_shift[:5]:
            print("   *", m.strip())
