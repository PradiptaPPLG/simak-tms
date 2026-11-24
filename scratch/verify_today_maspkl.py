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

r = s.get('https://pkl.smkn1ciamis.id/siswa/jurnal')

# Find 2026-11-24 in the calendar
m24 = re.search(r'(<button[^>]*2026-11-24[^>]*>.*?</button>)', r.text, re.DOTALL)
if m24:
    print('Button 24 in MAS-PKL:')
    print(m24.group(1))

m24_div = re.search(r'(<div x-show="selectedDate === \'2026-11-24\'".*?</div>\s*</div>)', r.text, re.DOTALL)
if m24_div:
    print('\nDiv 24 in MAS-PKL:')
    print(m24_div.group(1)[:600])
