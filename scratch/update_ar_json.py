import json
import os

file_path = '/Users/yasminsaed/work/yasmina/lang/ar.json'

with open(file_path, 'r', encoding='utf-8') as f:
    data = json.load(f)

new_translations = {
    "View Store": "عرض المتجر"
}

data.update(new_translations)

with open(file_path, 'w', encoding='utf-8') as f:
    json.dump(data, f, ensure_ascii=False, indent=4)
