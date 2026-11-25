from PIL import Image

im = Image.open(r"C:\xampp\htdocs\simak-tms\scratch\preview_login.png")
print("Original size:", im.size)

# The login card is centered. Crop around center top
w, h = im.size
crop_area = (w // 2 - 150, 80, w // 2 + 150, 320)
cropped = im.crop(crop_area)
cropped.save(r"C:\xampp\htdocs\simak-tms\scratch\preview_login_logo_crop.png")
print("Cropped logo preview saved. Size:", cropped.size)
