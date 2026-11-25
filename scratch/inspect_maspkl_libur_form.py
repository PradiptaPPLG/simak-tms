import re

with open('scratch/dashboard_maspkl.html', encoding='utf-8') as f:
    text = f.read()

# Find the form or section containing hari_libur_rutin
idx = text.find('hari_libur_rutin')
if idx != -1:
    print('Found in dashboard_maspkl.html:')
    print(text[max(0, idx-400):min(len(text), idx+1200)])
else:
    print('Not found in dashboard_maspkl.html')

with open('scratch/profil_maspkl.html', encoding='utf-8') as f:
    text_prof = f.read()

idx_prof = text_prof.find('hari_libur_rutin')
if idx_prof != -1:
    print('Found in profil_maspkl.html:')
    print(text_prof[max(0, idx_prof-400):min(len(text_prof), idx_prof+1200)])
