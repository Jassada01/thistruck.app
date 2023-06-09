<?php

$channelAccessToken = '69Wn4DFUg+BnsFmiDlC/LNar3NarEaHIAOvQIKqKIeseUjTbcnpI0e3hhstuydCG2Jr/kAv5ce9io0eXXC7zqx8NFDV12jbNcgtF/gW1NF4HtkyPNYOJo3QuNmS/ZZUFfaSq2i9OeiqXMOSg6U7Y0QdB04t89/1O/w1cDnyilFU=';

$request = file_get_contents('php://input');
$events = json_decode($request, true);

foreach ($events['events'] as $event) {
    $eventType = $event['type'];

    if ($eventType == 'message') {
        $messageType = $event['message']['type'];
        $replyToken = $event['replyToken'];

        if ($messageType == 'text') {
            $text = trim($event['message']['text']);

            // Check if the trimmed text is 'id'
            if (strcasecmp($text, 'id') == 0) {
                $userId = $event['source']['userId'];
                replyTextMessage($replyToken, $userId);
            } 
            else if (strcasecmp($text, 'group') == 0) {
                $groupID = $event['source']['groupId'];
                replyTextMessage($replyToken, $groupID);
            }
            else {
                // Do nothing
                //replyTextMessage($replyToken, "นี่เป็นช่องทางสำหรับการส่งข้อมูลแจ้งเตือนเท่านั้น ถ้าคุณมีคำถามหรือต้องการข้อมูลเพิ่มเติม, กรุณาติดต่อเราที่หมายเลข 063-914-4536 นะคะ");
            }
        }
    }
}

function replyTextMessage($replyToken, $text)
{
    global $channelAccessToken;

    $url = 'https://api.line.me/v2/bot/message/reply';
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $channelAccessToken
    );

    $data = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );

    $options = array(
        'http' => array(
            'header' => implode("\r\n", $headers),
            'method' => 'POST',
            'content' => json_encode($data)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
}
