import requests, re

s = requests.Session()
r_login = s.get('http://127.0.0.1:8000/login')
m = re.search(r'name="_token" value="([^"]+)"', r_login.text)
csrf = m.group(1) if m else ''

# Login with login_id = 20239, password = tmshebatsukses
r_post = s.post('http://127.0.0.1:8000/login', data={
    '_token': csrf,
    'login_id': '20239',
    'password': 'tmshebatsukses'
}, allow_redirects=True)

print('Post URL:', r_post.url)

r_jurnal = s.get('http://127.0.0.1:8000/jurnal?date=2026-11-21')
print('Jurnal URL:', r_jurnal.url)
print('/jurnal status code:', r_jurnal.status_code)

checks = [
    'Atur Hari Libur',
    'modal-jadwal-libur',
    'routine_off_days[]',
    'user-x',
    'Libur Akhir Pekan (Sabtu &amp; Minggu)',
    '2026-11-21',
    '2026-11-22'
]

for check in checks:
    if check in r_jurnal.text:
        print(f"  [OK] Found '{check}'")
    else:
        print(f"  [MISSING] Did not find '{check}'")

# Find tiles 21 & 22
matches = re.findall(r'<a[^>]*2026-11-(?:21|22)[^>]*>.*?</a>', r_jurnal.text, re.DOTALL)
for m in matches:
    print("\n--- Tile Match ---")
    print(m)
