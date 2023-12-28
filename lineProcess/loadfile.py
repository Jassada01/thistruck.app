import os
import time
import random
import string
import requests
from datetime import datetime
import pymysql

def generate_random_filename():
    letters = string.ascii_lowercase
    random_filename = ''.join(random.choice(letters) for i in range(10))
    return random_filename

def download_image(message_id):
    access_token = '69Wn4DFUg+BnsFmiDlC/LNar3NarEaHIAOvQIKqKIeseUjTbcnpI0e3hhstuydCG2Jr/kAv5ce9io0eXXC7zqx8NFDV12jbNcgtF/gW1NF4HtkyPNYOJo3QuNmS/ZZUFfaSq2i9OeiqXMOSg6U7Y0QdB04t89/1O/w1cDnyilFU='
    url = f'https://api-data.line.me/v2/bot/message/{message_id}/content'
    headers = {
        'Authorization': f'Bearer {access_token}'
    }

    response = requests.get(url, headers=headers)
    if response.status_code == 200:
        random_filename = generate_random_filename()
        filename = f'{random_filename}.jpg'
        file_path = f'/var/www/thistruck.app/assets/media/uploadfile/linemedia/{filename}'
        

        with open(file_path, 'wb') as file:
            file.write(response.content)

        return file_path, filename
    else:
        return None, None

def update_line_attached_file(message_id, download_date, path, file_name):
    db_host = 'localhost'
    db_user = 'root'
    db_password = '}Ww]3v2CX<2mSH$7'
    db_database = 'mysystem'

    connection = pymysql.connect(
        host=db_host,
        user=db_user,
        password=db_password,
        database=db_database
    )
    cursor = connection.cursor()

    update_query = '''
    UPDATE line_attached_file 
    SET download_date = %s, path = %s, file_name = %s 
    WHERE message_id = %s
    '''

    values = (download_date, path, file_name, message_id)
    cursor.execute(update_query, values)

    connection.commit()

    cursor.close()
    connection.close()

def main(message_id):
    download_date = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    # สร้างค่าเวลา sleep แบบสุ่มระหว่าง 0.5 ถึง 5 วินาที
    sleep_time = random.uniform(0.5, 5)
    
    # ปัดเศษให้เหลือหนึ่งตำแหน่งทศนิยม
    sleep_time = round(sleep_time, 1)
    
    time.sleep(sleep_time)
    path, file_name = download_image(message_id)
    webpath = f'assets/media/uploadfile/linemedia/{file_name}'
    if path and file_name:
        update_line_attached_file(message_id, download_date, webpath, file_name)
        print('Data updated successfully.')
    else:
        print('Failed to download the image.')

if __name__ == '__main__':
    import sys

    if len(sys.argv) < 2:
        print('Please provide the message ID as a command line argument.')
        sys.exit(1)

    message_id = sys.argv[1]
    main(message_id)
