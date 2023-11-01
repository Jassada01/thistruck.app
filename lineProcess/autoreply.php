<?php

$channelAccessToken = '69Wn4DFUg+BnsFmiDlC/LNar3NarEaHIAOvQIKqKIeseUjTbcnpI0e3hhstuydCG2Jr/kAv5ce9io0eXXC7zqx8NFDV12jbNcgtF/gW1NF4HtkyPNYOJo3QuNmS/ZZUFfaSq2i9OeiqXMOSg6U7Y0QdB04t89/1O/w1cDnyilFU=';
$companyGroupID = array("Ca820e972e675bf390f6cb51b271f8ef5", "C6ab5ea08288c56727d0287f72cb1c975", "Cb08a5ce1479af3c3195b15404cf47893", "C4de6b687342c9e3d94983cf9ae4ef7a2", "C663987287d0a279a79708845b20f0c19", "C58088b249240a0aa6abb4b513c922703", "C0a4cc6b3985334c561562353b27fe62a"); // COMPANY Group Code ['S ONE'. 'S1 CHORTIP', 'จองงาน HSS', '']
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
            else if($text == "ขอข้อมูลงานของวันนี้"){
                $userId = $event['source']['userId'];
                getreplyfromRichMenu($userId, '1');
                // Do nothing
            }
            else if($text == "ขอข้อมูลงานค้าง"){
                $userId = $event['source']['userId'];
                getreplyfromRichMenu($userId, '2');
                // Do nothing
            }
            else {
                // Do nothing
                //replyTextMessage($replyToken, "นี่เป็นช่องทางสำหรับการส่งข้อมูลแจ้งเตือนเท่านั้น ถ้าคุณมีคำถามหรือต้องการข้อมูลเพิ่มเติม, กรุณาติดต่อเราที่หมายเลข 063-914-4536 นะคะ");
            }
        }
        else if ($messageType == 'image') {
            $groupId = $event['source']['groupId'];
            if (in_array($groupId, $companyGroupID)) {
                $userId = $event['source']['userId'];
                $messageId = $event['message']['id'];
                $createDate = date('Y-m-d H:i:s');
                $fileType = 'image';

                insertLineAttachedFile($groupId, $userId, $messageId, $createDate, $fileType);
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

function insertLineAttachedFile($groupId, $userId, $messageId, $createDate, $fileType)
{
    $server_name = "localhost";
    $UID = "root";
    $Pass = "}Ww]3v2CX<2mSH$7";
    $DB_name = "mysystem";
    $conn = new mysqli($server_name,$UID,$Pass,$DB_name);
    
    // Setting for support Thai
    mysqli_set_charset($conn, "utf8");

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare('INSERT INTO line_attached_file (group_id, user_id, message_id, create_date, file_type) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $groupId, $userId, $messageId, $createDate, $fileType);

    // Execute the SQL statement
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Call PythonScript
    $pythonCommand = ' python3 /var/www/thistruck.app/lineProcess/loadfile.py '.$messageId;
    shell_exec($pythonCommand);
}

function getreplyfromRichMenu($userId, $menuID)
{

    // Call PythonScript
    $pythonCommand = ' python3 /var/www/thistruck.app/lineProcess/reply_job_pending_list.py '.$userId.' '.$menuID;
    shell_exec($pythonCommand);
}
