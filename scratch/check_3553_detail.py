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

r_edit = s.get('https://pkl.smkn1ciamis.id/siswa/jurnal/3553/edit')
with open('scratch/edit_3553.html', 'w', encoding='utf-8') as f:
    f.write(r_edit.text)

print('Status code:', r_edit.status_code)

# Find all form fields and values
inputs = re.findall(r'<input[^>]+name="([^"]+)"[^>]*value="([^"]*)"', r_edit.text)
print('Inputs:', inputs)

textareas = re.findall(r'<textarea[^>]+name="([^"]+)"[^>]*>(.*?)</textarea>', r_edit.text, re.DOTALL)
print('Textareas:')
for name, val in textareas:
    print(f"  {name}: {repr(val.strip())}")

# Check image in 3553
img_matches = re.findall(r'<img[^>]+src="([^"]+)"', r_edit.text)
print('Images in edit 3553:', img_matches)
