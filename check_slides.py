import re

with open(r'C:\xampp\htdocs\simak-tms\koci_source.html', 'r', encoding='utf-8', errors='ignore') as f:
    text = f.read()

pattern = r'<div class="swiper-slide">(.*?)</div>\s*</div>'
slides = re.findall(pattern, text, re.DOTALL)
print("Slides found:", len(slides))
for i, s in enumerate(slides):
    imgs = re.findall(r'src="([^"]+)"', s)
    alt = re.findall(r'alt="([^"]+)"', s)
    print(f"Slide {i}: {imgs} | {alt}")
