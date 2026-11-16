import re
import os
import urllib.request

with open(r'C:\xampp\htdocs\simak-tms\koci_source.html', 'r', encoding='utf-8', errors='ignore') as f:
    text = f.read()

pattern = r'(?:src|srcset)=["\'](/assets/img/[^"\'\s\?]+)'
matches = set(re.findall(pattern, text))
print("Found images:", len(matches))
for m in sorted(matches):
    print(m)
