import re

with open('scratch/jurnal_page.html', encoding='utf-8') as f:
    text = f.read()

links = re.findall(r'<a[^>]+href="([^"]+)"[^>]*>(.*?)</a>', text, re.DOTALL)
print('Jurnal Page Links:')
for href, label in set([(h, re.sub(r'<[^>]+>', '', l).strip()) for h, l in links]):
    if label and ('http' in href or '/' in href):
        print(f"  {label} -> {href}")

# Also search for forms or modals in jurnal_page.html
forms = re.findall(r'<form[^>]+action="([^"]*)"[^>]*>', text)
print('Forms on page:')
for form in forms:
    print(f"  {form}")

# Search for "libur" case insensitive in the whole HTML
matches = re.finditer(r'(.{0,100}libur.{0,100})', text, re.IGNORECASE)
print('\nOccurrences of libur in jurnal_page.html:')
for m in list(matches)[:10]:
    print("MATCH:", m.group(1).strip())
