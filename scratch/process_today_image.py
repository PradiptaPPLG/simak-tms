from PIL import Image
import base64
import io
import os

img_path = r"C:\Users\user\.gemini\antigravity\brain\eb78f14d-88c1-4cfe-a5fa-d68cc4706ba2\.user_uploaded\media_1795511264487_b9fc6692.jpg"

img = Image.open(img_path)
print("Original size:", img.size)

# Crop to 1:1 centered or focused on the content
w, h = img.size
min_dim = min(w, h)

# Center crop or slightly biased towards the main dashboard content
left = (w - min_dim) // 2
top = 0
right = left + min_dim
bottom = min_dim

cropped = img.crop((left, top, right, bottom))
cropped = cropped.resize((800, 800), Image.Resampling.LANCZOS)
print("Cropped size:", cropped.size)

# Save to public/uploads/journals/ in SIMAK-TMS
simak_dir = r"C:\xampp\htdocs\simak-tms\public\uploads\journals"
os.makedirs(simak_dir, exist_ok=True)
simak_file = os.path.join(simak_dir, "jurnal_20261124_pradipta.jpg")
cropped.save(simak_file, "JPEG", quality=90)
print("Saved to SIMAK-TMS:", simak_file)

# Convert to data URL for MAS-PKL
buf = io.BytesIO()
cropped.save(buf, format="JPEG", quality=85)
b64_str = base64.b64encode(buf.getvalue()).decode('utf-8')
data_url = "data:image/jpeg;base64," + b64_str

data_url_path = r"C:\xampp\htdocs\simak-tms\scratch\today_photo_data_url.txt"
with open(data_url_path, "w") as f:
    f.write(data_url)
print("Saved data URL length:", len(data_url))
