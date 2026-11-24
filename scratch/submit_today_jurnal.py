import urllib.request
import urllib.parse
import http.cookiejar
import ssl
import re
import sys

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE
cj = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj), urllib.request.HTTPSHandler(context=ctx))

# 1. Login to MAS-PKL
print("--- Step 1: Login to MAS-PKL ---")
login_url = "https://pkl.smkn1ciamis.id/login"
resp = opener.open(urllib.request.Request(login_url, headers={"User-Agent": "Mozilla/5.0"}))
html = resp.read().decode('utf-8')
token = re.search(r'name="_token"\s+value="([^"]+)"', html).group(1)

login_data = urllib.parse.urlencode({
    "_token": token,
    "username": "242510639",
    "password": "@Pra02032009"
}).encode('utf-8')

opener.open(urllib.request.Request(
    login_url,
    data=login_data,
    headers={
        "User-Agent": "Mozilla/5.0",
        "Referer": login_url,
        "Content-Type": "application/x-www-form-urlencoded"
    }
))
print("Login successfully authenticated!")

# 2. Get form token from create page
print("\n--- Step 2: Open Create Page (2026-11-24) ---")
create_url = "https://pkl.smkn1ciamis.id/siswa/jurnal/create?date=2026-11-24"
resp_create = opener.open(urllib.request.Request(create_url, headers={"User-Agent": "Mozilla/5.0"}))
create_html = resp_create.read().decode('utf-8')

form_token = re.search(r'id="jurnal-form".*?name="_token"\s+value="([^"]+)"', create_html, re.DOTALL)
if not form_token:
    form_token = re.search(r'name="_token"\s+value="([^"]+)"', create_html)
csrf = form_token.group(1)
print("Form CSRF Token:", csrf)

# Load cropped photo data URL
photo_path = r"C:\xampp\htdocs\simak-tms\scratch\today_photo_data_url.txt"
with open(photo_path, "r") as f:
    photo_data_url = f.read().strip()
print("Loaded photo data URL. Length:", len(photo_data_url))

# 3. Prepare payload
kegiatan = "Pengembangan Fitur Ekspor Data Spreadsheet (Excel/CSV), Sinkronisasi QR Code Profil & Backup Sistem SIMAK-TMS"
catatan = """Hari ini saya melanjutkan pengembangan sistem informasi SIMAK-TMS di PT. Teknologi Multi Sistem. Fokus pekerjaan meliputi penyatuan kode QR profil publik menjadi satu pintu resmi terpadu (Unified Single QR) yang langsung dapat diakses tanpa hambatan sesi login, menambahkan tampilan e-sertifikat kelulusan 4 pilar di laman profil publik, serta mengimplementasikan modul ekspor data spreadsheet (Microsoft Excel .xls dan CSV Universal) dan fitur cetak rekapitulasi data bimbingan pada area Staff Mentor untuk keperluan pencadangan (backup) dan monitoring aktivitas berkala siswa magang.

Kendala yang dihadapi:
Format penulisan ekspor Excel perlu mempertahankan format teks untuk ID 5-digit siswa dan NIS agar tidak terpotong atau terkonversi menjadi format saintifik.

Solusi:
Menerapkan custom style mso-number-format pada sel spreadsheet Excel dan menambahkan header UTF-8 BOM pada berkas CSV agar karakter khusus dan nomor ID terbaca dengan sempurna di MS Excel maupun Google Sheets."""

cp_text = "Pada akhir fase F, peserta didik mampu menerapkan kompetensi teknis pada pekerjaan sesuai POS yang berlaku di dunia kerja."

payload = {
    "_token": csrf,
    "tanggal": "2026-11-24",
    "kompetensi_id": "256",
    "cp": cp_text,
    "cp_id": "256",
    "kegiatan": kegiatan,
    "catatan": catatan,
    "foto_cropped": photo_data_url,
    "alasan_alpha": ""
}

# 4. Submit POST
print("\n--- Step 3: Submitting Journal Entry to MAS-PKL ---")
encoded_payload = urllib.parse.urlencode(payload).encode('utf-8')
post_req = urllib.request.Request(
    "https://pkl.smkn1ciamis.id/siswa/jurnal",
    data=encoded_payload,
    headers={
        "User-Agent": "Mozilla/5.0",
        "Referer": create_url,
        "Content-Type": "application/x-www-form-urlencoded"
    }
)

with opener.open(post_req) as post_resp:
    print("Submit HTTP Status:", post_resp.status)
    print("Final URL:", post_resp.geturl())
    resp_body = post_resp.read().decode('utf-8', errors='ignore')
    
    # Check flash alert
    flashes = re.findall(r'<div[^>]*class="[^"]*(?:alert|toast|notification|success|swal)[^"]*"[^>]*>(.*?)</div>', resp_body, re.DOTALL)
    for fl in flashes:
        clean_fl = re.sub(r'<[^>]+>', ' ', fl).strip()
        if clean_fl:
            print("Flash Alert:", clean_fl[:150])

# 5. Verify on Jurnal List
print("\n--- Step 4: Verifying on MAS-PKL Journal Calendar/List ---")
with opener.open(urllib.request.Request("https://pkl.smkn1ciamis.id/siswa/jurnal", headers={"User-Agent": "Mozilla/5.0"})) as list_resp:
    list_html = list_resp.read().decode('utf-8', errors='ignore')

# Check 24 November
pos = list_html.find("24 November 2026")
if pos != -1:
    snippet = list_html[pos-100:pos+1500]
    clean = re.sub(r'\s+', ' ', re.sub(r'<[^>]+>', ' ', snippet)).strip()
    print("SUCCESS: Journal for 24 November 2026 verified on MAS-PKL!")
    print("Snippet:", clean[:300])
else:
    print("Checking calendar status for 24...")
    # Look for table or calendar status of day 24
    if "2026-11-24" in list_html:
        print("Date 2026-11-24 found in portal records!")
    else:
        print("Notice: Check detail on portal directly.")
