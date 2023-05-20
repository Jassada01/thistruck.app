<?php

$accessToken = '69Wn4DFUg+BnsFmiDlC/LNar3NarEaHIAOvQIKqKIeseUjTbcnpI0e3hhstuydCG2Jr/kAv5ce9io0eXXC7zqx8NFDV12jbNcgtF/gW1NF4HtkyPNYOJo3QuNmS/ZZUFfaSq2i9OeiqXMOSg6U7Y0QdB04t89/1O/w1cDnyilFU=';
$userId = 'U38628cc494b3d32e8f67f1860da8cf5e'; // เปลี่ยนเป็น User ID ของผู้รับข้อความ



$message = "มีงานใหม่เข้า
Job ID : J-2305-056
Trip ID : T-2305-094
ชื่องาน : IMC 1234 12
เวลาเริ่มงาน : 13 พ.ค. 23 เวลา 08:00";

$link = 'http://192.168.1.63/system_2/tripDetail.php?r=hEuRDfIcQk';

$data = [
    'to' => $userId,
    'messages' => [
        [
            'type' => 'flex',
            'altText' => 'มีงานใหม่เข้า',
            'contents' => [
                'type' => 'bubble',
                'body' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => $message,
                            'wrap' => true
                        ],
                        [
                            'type' => 'separator',
                            'margin' => 'xl'
                        ],
                        [
                            'type' => 'button',
                            'style' => 'primary',
                            'action' => [
                                'type' => 'uri',
                                'label' => 'ดูรายละเอียด',
                                'uri' => $link
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$url = 'https://api.line.me/v2/bot/message/push';

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

if ($result === false) {
    echo 'เกิดข้อผิดพลาดในการส่งข้อความ: ' . curl_error($ch);
} else {
    echo 'ส่งข้อความและลิงก์ Line Message API สำเร็จ!';
}
?>