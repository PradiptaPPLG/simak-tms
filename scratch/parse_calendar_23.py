import re

with open('scratch/jurnal_page.html', encoding='utf-8') as f:
    html = f.read()

# Find the button for 2026-11-23 and surrounding HTML
m = re.search(r'(<button[^>]*2026-11-23[^>]*>.*?</button>)', html, re.DOTALL)
if m:
    print('Button HTML for 23:')
    print(m.group(1))

# Find the div for 2026-11-23
m2 = re.search(r'(<div x-show="selectedDate === \'2026-11-23\'".*?</div>\s*</div>)', html, re.DOTALL)
if m2:
    print('Div HTML for 23:')
    print(m2.group(1)[:1500])
