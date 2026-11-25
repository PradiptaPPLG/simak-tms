import re

with open('scratch/jurnal_page.html', encoding='utf-8') as f:
    text = f.read()

# Find the button for 2026-11-21 and 2026-11-22
for date in ['2026-11-21', '2026-11-22']:
    m = re.search(r'(<button[^>]*' + date + r'[^>]*>.*?</button>)', text, re.DOTALL)
    if m:
        print(f"Button for {date}:")
        print(m.group(1))
    
    # Also find corresponding detail div
    m_div = re.search(r'(<div x-show="selectedDate === \'' + date + r'\'".*?</div>\s*</div>)', text, re.DOTALL)
    if m_div:
        print(f"Detail div for {date}:")
        print(m_div.group(1)[:1000])
