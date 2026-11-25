with open('scratch/maspkl_real_dashboard.html', encoding='utf-8') as f:
    text = f.read()

idx = text.find('hari_libur_rutin')
start = text.rfind('<form', 0, idx)
if start == -1:
    start = text.rfind('<div', 0, idx - 200)

end = text.find('</form>', idx)
if end == -1:
    end = text.find('</section>', idx)
if end == -1:
    end = idx + 2500

print(text[start:end+7])

# Also check for javascript related to routine-off-days or hari_libur
import re
js_matches = re.findall(r'<script[^>]*>.*?(?:hari_libur|routine-off).*?</script>', text, re.DOTALL | re.IGNORECASE)
print(f"\nFound {len(js_matches)} JS blocks:")
for j in js_matches:
    print(j[:1000])
