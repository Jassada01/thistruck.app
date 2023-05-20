<?php
//sleep(5);


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getFileExtension($mimeType) {
    $extensions = array(
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'application/vnd.ms-powerpoint' => 'ppt',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'video/mp4' => 'mp4'
    );

    return isset($extensions[$mimeType]) ? $extensions[$mimeType] : null;
}

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../assets/media/uploadfile/';
    $mimeType = mime_content_type($_FILES['file']['tmp_name']);
    $extension = getFileExtension($mimeType);

    if ($extension === null) {
        http_response_code(415);
        echo 'Unsupported file type';
        exit;
    }

    if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
        // Generate a random file name for images
        $filename = generateRandomString() . '.' . $extension;
    } else {
        // Use the original file name for other file types
        $filename = basename($_FILES['file']['name']);
    }

    $target_file = $upload_dir . $filename;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        echo $filename; // Return the filename to the AJAX request
        //$full_path = realpath($target_file);
        //$full_path = $target_file;
        //echo $full_path; 
    } else {
        http_response_code(500);
        echo 'Error uploading file';
    }
} else {
    http_response_code(400);
    echo 'Invalid file data';
}
