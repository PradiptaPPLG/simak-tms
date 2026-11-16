import os
import subprocess
import time

chrome = r'C:\Program Files\Google\Chrome\Application\chrome.exe'
output_dir = r'C:\xampp\htdocs\simak-tms\screenshots'
os.makedirs(output_dir, exist_ok=True)

pages = [
    ('1_login.png', 'http://localhost/simak-tms/public/'),
    ('2_dashboard.png', 'http://localhost/simak-tms/public/preview/dashboard'),
    ('3_jurnal_kalender.png', 'http://localhost/simak-tms/public/preview/jurnal'),
    ('4_tugas_lms.png', 'http://localhost/simak-tms/public/preview/tugas'),
    ('5_showcase_arsip.png', 'http://localhost/simak-tms/public/preview/arsip'),
    ('6_evaluasi_rapor.png', 'http://localhost/simak-tms/public/preview/evaluasi'),
    ('7_mentor_review.png', 'http://localhost/simak-tms/public/preview/review'),
    ('8_bantuan_faq.png', 'http://localhost/simak-tms/public/preview/informasi'),
]

for name, url in pages:
    target = os.path.join(output_dir, name)
    cmd = [chrome, '--headless=new', f'--screenshot={target}', '--window-size=1280,800', url]
    subprocess.run(cmd)
    print("Saved:", name)

print("All MAS-PKL style screenshots captured successfully!")
