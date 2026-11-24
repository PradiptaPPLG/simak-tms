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

r23 = s.get('https://pkl.smkn1ciamis.id/siswa/jurnal/3553')
print('Jurnal 3553 status code:', r23.status_code)
print('Content snippet:', r23.text[:1000])

# Check if there is an edit page
r23_edit = s.get('https://pkl.smkn1ciamis.id/siswa/jurnal/3553/edit')
print('Jurnal 3553 edit status code:', r23_edit.status_code)

# Check what date 3553 is for
date_match = re.search(r'name="tanggal"[^>]*value="([^"]+)"', r23_edit.text)
print('Tanggal in 3553:', date_match.group(1) if date_match else 'None')

# Check kegiatan in 3553
kegiatan_match = re.search(r'name="kegiatan"[^>]*>([^<]*)<', r23_edit.text)
print('Kegiatan in 3553:', kegiatan_match.group(1) if kegiatan_match else 'None')

# Check date 24
r24 = s.get('https://pkl.smkn1ciamis.id/siswa/jurnal/create?date=2026-11-24')
print('Create 2026-11-24 status code:', r24.status_code)
