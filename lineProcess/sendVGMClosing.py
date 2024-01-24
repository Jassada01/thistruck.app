import pymysql
import pymysql.cursors
import json
import requests
from datetime import datetime
from babel.dates import format_datetime
import pytz

# ฟังก์ชันสำหรับแปลง datetime เป็นภาษาไทย
def format_to_thai(datetime_obj):
    if datetime_obj:
        tz = pytz.timezone('Asia/Bangkok')
        datetime_obj = datetime_obj.astimezone(tz)
        return format_datetime(datetime_obj, "EEEEที่ d MMMM yyyy เวลา HH:mm น.", locale='th')
    else:
        return "ไม่มีข้อมูลเวลา"

        

# ฟังก์ชันสำหรับสร้าง JSON จากข้อมูล
def create_json(data, base_time_str, name_header, main_type):
    trips = []
    cnt = 0
    for tripNo, driver_name, job_name, random_code in data:
        cnt += 1
        trip = {
            "type": "box",
            "layout": "vertical",
            "contents": [
                {
                    "type": "text",
                    "text": f"{cnt}) {job_name}",
                    "adjustMode": "shrink-to-fit"
                },
                {
                    "type": "box",
                    "layout": "horizontal",
                    "contents": [
                        {
                            "type": "text",
                            "text": tripNo,
                            "size": "xs",
                            "color": "#B4B4B3"
                        },
                        {
                            "type": "text",
                            "text": driver_name,
                            "size": "xs",
                            "color": "#B4B4B3",
                            "align": "end"
                        }
                    ]
                }
            ],
            "paddingBottom": "xl",
            "action": {
                "type": "uri",
                "label": "action",
                "uri": f"https://thistruck.app/tripDetail.php?r={random_code}"
            }
        }
        trips.append(trip)

    json_structure = {
        "type": "flex",
        "altText": name_header,
        "contents": {
            "type": "bubble",
            "size": "mega",
            "header": {
                "type": "box",
                "layout": "vertical",
                "contents": [
                    {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [
                            {
                                "type": "text",
                                "text": name_header,
                                "color": "#FBECB2",
                                "size": "sm"
                            },
                            {
                                "type": "text",
                                "text": main_type,
                                "color": "#ffffff",
                                "size": "xl",
                                "flex": 4,
                                "weight": "bold"
                            },
                            {
                                "type": "text",
                                "text": base_time_str,
                                "color": "#FF6969",
                                "size": "xs"
                            }
                        ]
                    }
                ],
                "paddingAll": "20px",
                "backgroundColor": "#072541",
                "spacing": "md",
                "paddingTop": "22px"
            },
            "body": {
                "type": "box",
                "layout": "vertical",
                "contents": trips
            }
        }
    }
    return json_structure

# การเชื่อมต่อกับฐานข้อมูลและการส่งข้อความ
try:
    conn = pymysql.connect(host="localhost", user="root", password='}Ww]3v2CX<2mSH$7', db="mysystem")
    with conn.cursor() as cursor:
        # คำสั่ง SQL สำหรับเลือก LINE_TOKEN และ USER_ID
        sql_select_token = "SELECT value FROM master_data WHERE name = 'Line Token'"
        cursor.execute(sql_select_token)

        row = cursor.fetchone()
        if row:
            LINE_TOKEN = row[0]
        else:
            raise ValueError("LINE_TOKEN not found in master_data table")

        # คำสั่ง SQL สำหรับเลือก USER_ID จากตาราง master_data ที่มี type เป็น 'companyGroupLine'
        sql_select_user_id = "SELECT value FROM master_data WHERE type = 'companyGroupLine'"
        cursor.execute(sql_select_user_id)

        row = cursor.fetchone()
        if row:
            USER_ID = row[0]
        else:
            raise ValueError("USER_ID not found in master_data table")

        sql_commands = [
            {
                "sql": """
                    SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
                    WHERE a.6hr_time <= NOW()
                    AND alert_type = 'VGM'
                    AND a.6hr_alert = 1;
                """,
                "Notifyname": "แจ้งเตือน 6 ชั่วโมงก่อน VGM",
                "Notifytype": "VGM",
                "updateSQL": """
                UPDATE vgm_closing_notification_time SET 6hr_alert = 2
                WHERE 6hr_time <= NOW()
                    AND alert_type = 'VGM'
                    AND 6hr_alert = 1;
                """,
                "driverSQL":"""
                SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code, d.line_id
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
					Inner Join truck_driver_info d ON d.driver_id = c.driver_id
                    WHERE a.6hr_time <= NOW()
                    AND alert_type = 'VGM'
                    AND a.6hr_alert = 1
                    AND c.status NOT IN ('คนขับยืนยันจบงานแล้ว', 'จบงาน', 'ยกเลิก');
                """
            },
            {
                "sql": """
                    SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
                    WHERE a.3hr_time <= NOW()
                    AND alert_type = 'VGM'
                    AND a.3hr_alert = 1;
                """,
                "Notifyname": "แจ้งเตือน 3 ชั่วโมงก่อน VGM",
                "Notifytype": "VGM",
                "updateSQL": """
                UPDATE vgm_closing_notification_time SET 3hr_alert = 2
                WHERE 3hr_time <= NOW()
                    AND alert_type = 'VGM'
                    AND 3hr_alert = 1;
                """,
                "driverSQL":"""
                SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code, d.line_id
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
					Inner Join truck_driver_info d ON d.driver_id = c.driver_id
                    WHERE 3hr_time <= NOW()
                    AND alert_type = 'VGM'
                    AND 3hr_alert = 1
                    AND c.status NOT IN ('คนขับยืนยันจบงานแล้ว', 'จบงาน', 'ยกเลิก');
                """
                
            },
            {
                "sql": """
                    SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
                    WHERE a.6hr_time <= NOW()
                    AND alert_type = 'Closing'
                    AND a.6hr_alert = 1;
                """,
                "Notifyname": "แจ้งเตือน 6 ชั่วโมงก่อน Closing",
                "Notifytype": "Closing",
                "updateSQL": """
                UPDATE vgm_closing_notification_time SET 6hr_alert = 2
                WHERE 6hr_time <= NOW()
                    AND alert_type = 'Closing'
                    AND 6hr_alert = 1;
                """,
                "driverSQL":"""
                SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code, d.line_id
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
					Inner Join truck_driver_info d ON d.driver_id = c.driver_id
                    WHERE 6hr_time <= NOW()
                    AND alert_type = 'Closing'
                    AND 6hr_alert = 1
                    AND c.status NOT IN ('คนขับยืนยันจบงานแล้ว', 'จบงาน', 'ยกเลิก');
                """
            },
            {
                "sql": """
                    SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
                    WHERE a.3hr_time <= NOW()
                    AND alert_type = 'Closing'
                    AND a.3hr_alert = 1;
                """,
                "Notifyname": "แจ้งเตือน 3 ชั่วโมงก่อน Closing",
                "Notifytype": "Closing",
                "updateSQL": """
                UPDATE vgm_closing_notification_time SET 3hr_alert = 2
                WHERE 3hr_time <= NOW()
                    AND alert_type = 'Closing'
                    AND 3hr_alert = 1;
                """,
                "driverSQL":"""
                SELECT a.id, a.alert_type, b.job_name, c.tripNo, c.driver_name, a.base_time, c.random_code, d.line_id
                    FROM vgm_closing_notification_time a
                    INNER JOIN job_order_header b ON a.job_id = b.id
                    INNER JOIN job_order_detail_trip_info c ON a.job_id = c.job_id AND a.trip_id = c.id
					Inner Join truck_driver_info d ON d.driver_id = c.driver_id
                    WHERE 3hr_time <= NOW()
                    AND alert_type = 'Closing'
                    AND 3hr_alert = 1
                    AND c.status NOT IN ('คนขับยืนยันจบงานแล้ว', 'จบงาน', 'ยกเลิก');
                """
            },
            # ... dictionary ของคำสั่ง SQL อื่นๆ ...
        ]


        for command in sql_commands:
            name_header = command["Notifyname"]
            main_type = command["Notifytype"]
            cursor.execute(command["sql"])
            #cursor.execute(sql)
            result = cursor.fetchall()
            # ส่งข้อความไปยัง Line Messaging API
            LINE_API_URL = "https://api.line.me/v2/bot/message/push"
            headers = {
                'Content-Type': 'application/json',
                'Authorization': f'Bearer {LINE_TOKEN}'
            }

            # จัดกลุ่มข้อมูลตาม base_time
            grouped_by_base_time = {}
            for id, alert_type, job_name, tripNo, driver_name, base_time, random_code in result:
                #base_time_str = base_time.strftime("%Y-%m-%d %H:%M:%S") if base_time else "ไม่มีข้อมูลเวลา"
                base_time_str = format_to_thai(base_time)
                if base_time_str not in grouped_by_base_time:
                    grouped_by_base_time[base_time_str] = []
                grouped_by_base_time[base_time_str].append((tripNo, driver_name, job_name, random_code))

            # ส่งข้อความสำหรับแต่ละกลุ่ม base_time
            for base_time_str, data in grouped_by_base_time.items():
                json_result = create_json(data, base_time_str, name_header, main_type)
                payload = {
                    "to": USER_ID,
                    "messages": [json_result]
                }
                response = requests.post(LINE_API_URL, data=json.dumps(payload), headers=headers)

                if response.status_code != 200:
                    print(f"Error for {base_time_str}: {response.status_code}, {response.text}")
                else:
                    print(f"Message sent successfully for {base_time_str}")
            
            # Send to Driver ====================
            cursor.execute(command["driverSQL"])
            #cursor.execute(sql)
            result2 = cursor.fetchall()
            for id, alert_type, job_name, tripNo, driver_name, base_time, random_code,line_id in result2:
                #base_time_str = base_time.strftime("%Y-%m-%d %H:%M:%S") if base_time else "ไม่มีข้อมูลเวลา"
                base_time_str = format_to_thai(base_time)
                if (line_id != ""):
                    json_structure = {
                    "type": "flex",
                    "altText": name_header,
                    "contents": {
                        "type": "bubble",
                        "size": "mega",
                        "header": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": name_header,
                                            "color": "#FBECB2",
                                            "size": "sm"
                                        },
                                        {
                                            "type": "text",
                                            "text": main_type,
                                            "color": "#ffffff",
                                            "size": "xl",
                                            "flex": 4,
                                            "weight": "bold"
                                        },
                                        {
                                            "type": "text",
                                            "text": base_time_str,
                                            "color": "#FF6969",
                                            "size": "xs"
                                        }
                                    ]
                                }
                            ],
                            "paddingAll": "20px",
                            "backgroundColor": "#072541",
                            "spacing": "md",
                            "paddingTop": "22px"
                        },
                        "body": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [{
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "text",
                                    "text": f"{job_name}",
                                    "adjustMode": "shrink-to-fit"
                                },
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": tripNo,
                                            "size": "xs",
                                            "color": "#B4B4B3"
                                        },
                                        {
                                            "type": "text",
                                            "text": driver_name,
                                            "size": "xs",
                                            "color": "#B4B4B3",
                                            "align": "end"
                                        }
                                    ]
                                }
                            ],
                            "paddingBottom": "xl",
                            "action": {
                                "type": "uri",
                                "label": "action",
                                "uri": f"https://thistruck.app/tripDetail.php?r={random_code}"
                            }
                        }]
                        }
                    }
                }
                    payload = {
                        "to": line_id,
                        "messages": [json_structure]
                    }
                    response = requests.post(LINE_API_URL, data=json.dumps(payload), headers=headers)

                    if response.status_code != 200:
                        print(f"Error for {base_time_str}: {response.status_code}, {response.text}")
                    else:
                        print(f"Message sent successfully for {base_time_str}")



            # Update Complete Send
            cursor.execute(command["updateSQL"])
            conn.commit()

except Exception as e:
    print(f"An error occurred: {e}")

finally:
    if conn:
        conn.close()
