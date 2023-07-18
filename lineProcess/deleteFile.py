import pymysql
from datetime import datetime, timedelta
import subprocess

# กำหนดการเชื่อมต่อฐานข้อมูล MySQL
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='}Ww]3v2CX<2mSH$7',
    database='mysystem',
    charset='utf8mb4',
    cursorclass=pymysql.cursors.DictCursor
)


def delete_file(file_path):
    try:
        subprocess.run(["rm", file_path])
        print("Deleted file:", file_path)
    except subprocess.CalledProcessError as e:
        print("Error deleting file:", file_path)
        print(e)


try:
    # สร้าง cursor object สำหรับการดำเนินการกับฐานข้อมูล
    with connection.cursor() as cursor:
        # กำหนดวันที่ที่ใช้ในการคำนวณ (วันที่ปัจจุบัน - 2 วัน)
        threshold_date = datetime.now() - timedelta(days=2)
        
        # คำสั่ง SQL สำหรับเลือกไฟล์ที่มี create_date มากกว่า 2 วัน และ delete_date เป็นค่าว่าง
        select_query = "SELECT path FROM line_attached_file WHERE create_date < %s AND deleted_date IS NULL"
        
        # ดึงข้อมูลไฟล์ที่ตรงเงื่อนไข
        cursor.execute(select_query, (threshold_date,))
        files_to_delete = cursor.fetchall()
        
        # ลบไฟล์และอัปเดต delete_date เป็นเวลาปัจจุบัน
        for file in files_to_delete:
            file_path = file['path']
            # ลบไฟล์จากเครื่อง

            delete_file("/var/www/thistruck.app/" + str(file_path))
            
            
            # อัปเดต delete_date เป็นเวลาปัจจุบัน
            update_query = "UPDATE line_attached_file SET deleted_date = %s WHERE path = %s"
            cursor.execute(update_query, (datetime.now(), file_path))
        
        # ยืนยันการเปลี่ยนแปลงในฐานข้อมูล
        connection.commit()
finally:
    # ปิดการเชื่อมต่อฐานข้อมูล
    connection.close()
