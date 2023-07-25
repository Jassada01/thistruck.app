import pymysql
import requests
import json
from datetime import datetime
import sys


if len(sys.argv) != 3:
    print("Usage: python script.py <USER_ID> <COMMAND_ID>")
    sys.exit(1)

# Retrieve the USER_ID and COMMAND_ID from command-line arguments
USER_ID = sys.argv[1]
COMMAND_ID = sys.argv[2]


# ข้อมูลในการเชื่อมต่อฐานข้อมูล
host = "localhost"
username = "root"
password = '}Ww]3v2CX<2mSH$7'
dbname = "mysystem"




#USER_ID = "U38628cc494b3d32e8f67f1860da8cf5e"
#COMMAND_ID = "1"

JOB_HEADER = "รายการงานวันนี้"
# สร้างการเชื่อมต่อฐานข้อมูล
conn = pymysql.connect(host=host, user=username, password=password, db=dbname)

try:
    # สร้าง Cursor สำหรับประมวลผลคำสั่ง SQL
    with conn.cursor() as cursor:
        # คำสั่ง SQL สำหรับเลือก LINE_TOKEN จากตาราง master_data ที่มี name เป็น 'Line Token'
        sql_select_token = "SELECT value FROM master_data WHERE name = 'Line Token'"
        cursor.execute(sql_select_token)

        # ดึงข้อมูล LINE_TOKEN ที่ได้จากการ Select
        row = cursor.fetchone()
        if row:
            LINE_TOKEN = row[0]
        else:
            # หากไม่พบ LINE_TOKEN ในตาราง master_data ให้ระดับขั้นความจำเป็น
            raise ValueError("LINE_TOKEN not found in master_data table")
        
        sql_select_data = ""
        if (COMMAND_ID == "1"):
            JOB_HEADER = "รายการงานวันนี้"
            sql_select_data = f"""
              SELECT 
                  b.job_no, 
                  a.tripNo, 
                  b.job_name, 
                  a.driver_name, 
                  a.jobStartDateTime, 
                  a.random_code, 
                  a.status
                FROM 
                  job_order_detail_trip_info a 
                  Inner Join job_order_header b ON a.job_id = b.id 
                Where 
                  a.id in (
                    SELECT a.id FROM job_order_detail_trip_info a 
                        Inner Join truck_driver_info b ON a.driver_id = b.driver_id
                        WHERE a.jobStartDateTime >= CURRENT_DATE
                        AND a.status != 'ยกเลิก'
                        AND a.complete_flag IS NULL
                        AND b.line_id = '{USER_ID}'
                    Order By 
                        a.id
                  )
            """
        if (COMMAND_ID == "2"):
            JOB_HEADER = "รายการงานที่ค้างอยู่"
            sql_select_data = f"""
              SELECT 
                  b.job_no, 
                  a.tripNo, 
                  b.job_name, 
                  a.driver_name, 
                  a.jobStartDateTime, 
                  a.random_code, 
                  a.status
                FROM 
                  job_order_detail_trip_info a 
                  Inner Join job_order_header b ON a.job_id = b.id 
                Where 
                  a.id in (
                    SELECT a.id FROM job_order_detail_trip_info a 
                        Inner Join truck_driver_info b ON a.driver_id = b.driver_id
                        WHERE a.status != 'ยกเลิก'
                        AND a.complete_flag IS NULL
                        AND b.line_id = '{USER_ID}'
                    Order By 
                        a.id
                  )
            """
            
            
        cursor.execute(sql_select_data)

        # ดึงข้อมูลทั้งหมดที่ได้จากการ Select
        results = cursor.fetchall()
        if len(results) >0 :
            # สร้าง flex message ตามข้อมูลที่ได้รับ
            
            flex_contents = []
            total_trips = len(results)
            if (COMMAND_ID == "1"):
                JOB_HEADER = f"รายการงานวันนี้ (มี {total_trips} ทริป)"
            if (COMMAND_ID == "2"):
                JOB_HEADER = f"รายการงานที่ค้างอยู่ (มี {total_trips} ทริป)"
            for row in results:
                job_no = row[0]
                tripNo = row[1]
                job_name = row[2]
                driver_name = row[3]
                job_start_datetime = row[4]
                random_code = row[5]
                status = row[6]

                flex_contents.append(
                    {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [
                         {
                                "type": "separator",
                                "margin": "xxl",
                                "color": "#FFFFFF"
                            },
                            {
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": "ชื่องาน",
                                        "size": "sm",
                                        "color": "#222222",
                                        "wrap": True,
                                        "flex": 1
                                    },
                                    {
                                        "type": "text",
                                        "text": f"{job_name}",
                                        "size": "sm",
                                        "color": "#999999",
                                        "wrap": True,
                                        "flex": 2,
                                        "align": "start"
                                    }
                                ]
                            },
                            {
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": "เลขจ๊อบ",
                                        "size": "sm",
                                        "color": "#222222",
                                        "wrap": True,
                                        "flex": 1
                                    },
                                    {
                                        "type": "text",
                                        "text": f"{job_no}",
                                        "size": "sm",
                                        "color": "#999999",
                                        "wrap": True,
                                        "flex": 2,
                                        "align": "start"
                                    }
                                ]
                            },
                            {
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": "เลขทริป",
                                        "size": "sm",
                                        "color": "#222222",
                                        "wrap": True,
                                        "flex": 1
                                    },
                                    {
                                        "type": "text",
                                        "text": f"{tripNo}",
                                        "size": "sm",
                                        "color": "#999999",
                                        "wrap": True,
                                        "flex": 2,
                                        "align": "start"
                                    }
                                ]
                            },
                            {
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": "ชื่อคนขับ",
                                        "size": "sm",
                                        "color": "#222222",
                                        "wrap": True,
                                        "flex": 1
                                    },
                                    {
                                        "type": "text",
                                        "text": f"{driver_name}",
                                        "size": "sm",
                                        "color": "#999999",
                                        "wrap": True,
                                        "flex": 2,
                                        "align": "start"
                                    }
                                ]
                            },
                            {
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": "เวลาเริ่มงาน",
                                        "size": "sm",
                                        "color": "#222222",
                                        "wrap": True,
                                        "flex": 1
                                    },
                                    {
                                        "type": "text",
                                        "text": f"{job_start_datetime.strftime('%d %b %Y, %H:%M')}",
                                        "size": "sm",
                                        "color": "#999999",
                                        "wrap": True,
                                        "flex": 2,
                                        "align": "start"
                                    }
                                ]
                            },{
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": "สถานะ",
                                        "size": "sm",
                                        "color": "#222222",
                                        "wrap": True,
                                        "flex": 1
                                    },
                                    {
                                        "type": "text",
                                        "text": f"{status}",
                                        "size": "sm",
                                        "color": "#999999",
                                        "wrap": True,
                                        "flex": 2,
                                        "align": "start"
                                    }
                                ]
                            },
                             {
                                "type": "separator",
                                "margin": "lg",
                                "color": "#FFFFFF"
                            },
                            {
                                "type": "button",
                                "action": {
                                    "type": "uri",
                                    "label": "รายละเอียด",
                                    "uri": f"https://thistruck.app/tripDetail.php?r={random_code}"
                                },
                                "style": "primary",
                                "height": "sm",
                            },
                            {
                                "type": "separator",
                                "margin": "xxl",
                                "color": "#FFFFFF"
                            }
                        ]
                    }
                )


            # ส่งข้อความไปยัง Line Messaging API
            LINE_API_URL = "https://api.line.me/v2/bot/message/push"

            payload = {
                "to": USER_ID,
                "messages": [
                    {
                        "type": "flex",
                        "altText": f"{JOB_HEADER}",
                        "contents": {
                            "type": "bubble",
                            "header": {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": f"{JOB_HEADER}",
                                        "size": "lg",
                                        "weight": "bold"
                                    }
                                ]
                            },
                            "body": {
                                "type": "box",
                                "layout": "vertical",
                                "contents": flex_contents
                            },
                            "styles": {
                                "footer": {
                                    "separator": True
                                }
                            }
                        }
                    }
                ]
            }


            headers = {
                'Content-Type': 'application/json',
                'Authorization': f'Bearer {LINE_TOKEN}'
            }

            response = requests.post(LINE_API_URL, data=json.dumps(payload), headers=headers)

            if response.status_code != 200:
                print(f"Error: {response.status_code}, {response.text}")
            else:
                print("Message sent successfully")
        else :
             # ส่งข้อความไปยัง Line Messaging API
            LINE_API_URL = "https://api.line.me/v2/bot/message/push"
            print(LINE_API_URL)
    
            payload = {
                "to": USER_ID,
                "messages": [
                    {
                        "type": "flex",
                        "altText": f"{JOB_HEADER}",
                        "contents": {
                            "type": "bubble",
                            "header": {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": f"{JOB_HEADER}",
                                        "size": "lg",
                                        "weight": "bold"
                                    }
                                ]
                            },
                            "body": {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [
                                    {
                                        "type": "text",
                                        "text": "ไม่พบข้อมูล",
                                        "size": "md",
                                        "color": "#ff5551",
                                        "weight": "bold"
                                    }
                                ]
                            },
                            "styles": {
                                "footer": {
                                    "separator": True
                                }
                            }
                        }
                    }
                ]
            }


            headers = {
                'Content-Type': 'application/json',
                'Authorization': f'Bearer {LINE_TOKEN}'
            }

            response = requests.post(LINE_API_URL, data=json.dumps(payload), headers=headers)

            if response.status_code != 200:
                print(f"Error: {response.status_code}, {response.text}")
            else:
                print("Message sent successfully")
            


finally:
    # ปิดการเชื่อมต่อฐานข้อมูล
    conn.close()
