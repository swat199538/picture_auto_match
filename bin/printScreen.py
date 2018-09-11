from PIL import ImageGrab
import sys

# 参数：要保存的图片位置
file_name = sys.argv[1]

im = ImageGrab.grab()
im.save(file_name)

print("完成截图！")