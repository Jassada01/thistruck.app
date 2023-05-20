

$("#rowUploadProgress, #rowSelectFile").hide();
// เมื่อคลิกปุ่ม "เพิ่มไฟล์"
$("#addFileBtn").on("click", function() {
    // ซ่อนบรรทัดที่ 1
    $("#rowAddFile").hide();
    // แสดงบรรทัดที่ 2 และ 3
    $("#rowSelectFile").show("fast");
});

function fileToBlob(file) {
    return new Promise((resolve, reject) => {
        var reader = new FileReader();
        reader.readAsArrayBuffer(file);
        reader.onloadend = function() {
            resolve(new Blob([reader.result], {
                type: file.type
            }));
        };
        reader.onerror = function() {
            reject(reader.error);
        };
    });
}


$('#upload-btn').click(function() {
    var fileDesc = $('#newFileDesc').val();
    $('#newFileDesc').removeClass('is-invalid');
    var files = $('#uploadFile').prop('files');

    if (files.length == 0) {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเลือกไฟล์ที่ต้องการอัพโหลด',
        });

        return false;
    }

    if (fileDesc == '') {
        $('#newFileDesc').addClass('is-invalid');
        return false;
    } else {
        // Start process upload 
        validateFile();
    }

    // ทำงานอื่นๆ เมื่อ input field มีข้อมูล


});



async function validateFile() {
    fileUploadOjb = []; // เตรียมตัวแปรเป็น Array
    var files = $("#uploadFile")[0].files;
    var DocumentRandomStr = randomString(10);
    var documentDesc = $("#newFileDesc").val();
    TOTAL_UPLOAD_FILE = files.length;
    CURRENT_UPLOAD_FILE = 0;
    uploadProgressUpdate();
    $("#rowUploadProgress").show("fast");
    $("#rowSelectFile").hide();
    for (var i = 0; i < files.length; i++) {
        CURRENT_UPLOAD_FILE += 1;
        var file = files[i];
        var originalFileName = file.name;
        var mimeType = file.type;
        var fileExtension = originalFileName.substring(originalFileName.lastIndexOf('.'));
        var fileRandomStr = randomString(2);
        var fileNameWithoutExtension = originalFileName.substring(0, originalFileName.lastIndexOf('.'));
        var fileName = fileNameWithoutExtension + "_" + fileRandomStr + fileExtension;
        var isImage = /^image\//.test(mimeType); // ตรวจสอบว่าเป็นรูปภาพหรือไม่
        var thumbnailName;

        if (isImage) {
            thumbnailName = fileNameWithoutExtension + "_" + fileRandomStr + "_thumbnail" + fileExtension;
        } else {
            thumbnailName = "";
        }

        // เพิ่ม Object ลงใน Array
        fileUploadOjb.push({
            'document_group': DOCUMENT_GROUP,
            'document_group_code': DOCUMENT_GROUP_CODE,
            'file_path': MAIN_FILE_PATH + fileName,
            'document_type': documentDesc,
            'description': "",
            'file_type': mimeType,
            'thumbnail_path': MAIN_FILE_PATH + thumbnailName,
            'random_code': DocumentRandomStr,
            'isImage': isImage,
            'originalFileName': originalFileName,
        });

        if (isImage) {
            if (file.size > 1000000) {
                // Upload Resize file
                try {
                    const resizedBlob = await resizeImage(file, 1500);
                    uploadFile(resizedBlob, mimeType, fileName);
                } catch (error) {
                    console.error('Error resizing image: ', error);
                }
            } else {
                // Upload Full file
                try {
                    const blob = await fileToBlob(file);
                    uploadFile(blob, mimeType, fileName);
                } catch (error) {
                    console.error('Error converting file to blob: ', error);
                }
            }

            // Upload thumbnail
            try {
                const resizedBlob = await resizeImage(file, 250);
                uploadFile(resizedBlob, mimeType, thumbnailName);
            } catch (error) {
                console.error('Error resizing image: ', error);
            }
        } else {
            try {
                const blob = await fileToBlob(file);
                uploadFile(blob, mimeType, fileName);
            } catch (error) {
                console.error('Error converting file to blob: ', error);
            }
        }
    }
    InsertAttachedfileData();
}



function uploadFile(blob, mimeType, originalFileName) {
    const formData = new FormData();
    formData.append("file", blob, originalFileName);
    $.ajax({
        type: 'POST',
        url: 'function/uploadFileCommon.php',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(event) {
                if (event.lengthComputable) {
                    var percentComplete = (event.loaded / event.total) * 100;
                    // Update the progress bar width
                    $('#uploadProgressBar').css('width', percentComplete.toFixed(2) + '%');
                    $('#uploadProgressBar').attr('aria-valuenow', percentComplete.toFixed(2));
                }
            }, false);
            return xhr;
        },
        beforeSend: function() {
            // Set the progress bar width to 0%
            $('#uploadProgressBar').css('width', '0%');
            $('#uploadProgressBar').attr('aria-valuenow', '0');
        },
        success: function(response) {
            uploadProgressUpdate();
        },
        error: function(error) {
            console.error('Error uploading file: ', error);
        }
    });
}

function uploadProgressUpdate() {
    $("#uploadProgress").html(CURRENT_UPLOAD_FILE + "/" + TOTAL_UPLOAD_FILE);
    if (TOTAL_UPLOAD_FILE != 0) {
        if (CURRENT_UPLOAD_FILE == TOTAL_UPLOAD_FILE) {
            $('#uploadProgressBar').css('width', '0%');
            $('#uploadProgressBar').attr('aria-valuenow', '0');
            $("#rowUploadProgress, #rowSelectFile").hide();
            $("#rowAddFile").show();

        }
    }

}




function resizeImage(file, maxFileSize) {
    return new Promise((resolve, reject) => {
        var reader = new FileReader();
        reader.onload = function() {
            var image = new Image();
            image.onload = function() {
                var canvas = document.createElement('canvas');
                var width = image.width;
                var height = image.height;
                var ratio = 1;
                if (width > height) {
                    if (width > maxFileSize) {
                        ratio = maxFileSize / width;
                    }
                } else {
                    if (height > maxFileSize) {
                        ratio = maxFileSize / height;
                    }
                }
                width *= ratio;
                height *= ratio;
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(image, 0, 0, width, height);
                canvas.toBlob(function(blob) {
                    resolve(blob);
                }, file.type);
            };
            image.src = reader.result;
        };
        reader.onerror = function() {
            reject(reader.error);
        };
        reader.readAsDataURL(file);
    });
}

function InsertAttachedfileData() {
    var ajaxData = {};
    ajaxData['f'] = '5';
    ajaxData['fileUploadOjb'] = JSON.stringify(fileUploadOjb); // Convert the object to a JSON string
    $.ajax({
            type: 'POST',
            dataType: "text",
            url: 'function/00_systemManagement/mainFunction.php',
            data: (ajaxData)
        })
        .done(function(retunrdata) {
            loadAttachedData();
        })
        .fail(function() {
            // just in case posting your form failed
            alert("Posting failed.");
        });
}

function loadAttachedData() {
    var ajaxData = {};
    ajaxData['f'] = '6';
    ajaxData['DOCUMENT_GROUP'] = DOCUMENT_GROUP;
    ajaxData['DOCUMENT_GROUP_CODE'] = DOCUMENT_GROUP_CODE;
    $.ajax({
            type: 'POST',
            dataType: "text",
            url: 'function/00_systemManagement/mainFunction.php',
            data: (ajaxData)
        })
        .done(function(data) {
            var data_arr = JSON.parse(data);
            console.log(data_arr);
            // เลือก Select2
            // สร้างตัวแปรสำหรับ tbody ใน HTML
            var tbody = document.getElementById('AttachedFileList');
            // Reset tbody
            tbody.innerHTML = '';
            // วนลูปเพื่อสร้างแถวในตารางสำหรับแต่ละ Record ใน Object
            for (var i = 0; i < data_arr.length; i++) {
                // สร้างแถวใหม่
                var row = document.createElement('tr');

                if (i > 0 && data_arr[i].random_code === data_arr[i - 1].random_code) {
                    // กรณี random_code เหมือนกับแถวก่อนหน้า ไม่ต้องแสดง document_type
                    var col1 = document.createElement('td');
                    row.appendChild(col1);
                    
                } else {
                    // สร้างคอลัมน์สำหรับ document_type
                    var col1 = document.createElement('td');
                    col1.classList.add('text-center')
                    col1.textContent = data_arr[i].document_type;
                    row.appendChild(col1);
                    
                }

                if (data_arr[i].isImage == "1") {
                    var col2 = document.createElement('td');
                    var img = document.createElement('img');
                    img.src = data_arr[i].file_path;
                    img.style.maxHeight = '50px';
                    img.setAttribute('class', 'img-thumbnail thumbnailclickable');
                    img.setAttribute('value', data_arr[i].file_path);
                    col2.innerHTML = img.outerHTML;
                    row.appendChild(col2);

                    var col3 = document.createElement('td');
                    col3.classList.add('text-center');
                    console.log(data_arr[i].created_at);
                    var created_at = moment(data_arr[i].created_at);
                    col3.textContent = created_at.format('DD MMM YY  HH:mm');
                    row.appendChild(col3);
                    

                } else {
                    var col2 = document.createElement('td');
                    var icon = document.createElement('i');
                    icon.classList.add('fas'); // ใช้ font-awesome 5
                    icon.classList.add('fa-2x'); // ใช้ font-awesome 5
                    // กำหนดชื่อคลาสของ Icon ตามประเภทไฟล์
                    switch (data_arr[i].file_type) {
                        case 'image/png':
                        case 'image/jpeg':
                        case 'image/gif':
                            icon.classList.add('fa-file-image');
                            break;
                        case 'application/pdf':
                            icon.classList.add('fa-file-pdf');
                            break;
                        case 'application/msword':
                        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                            icon.classList.add('fa-file-word');
                            break;
                        case 'application/vnd.ms-excel':
                        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                            icon.classList.add('fa-file-excel');
                            break;
                        default:
                            icon.classList.add('fa-file');
                            break;
                    }
                    col2.appendChild(icon);
                    var link = document.createElement('a');
                    link.href = data_arr[i].file_path;
                    link.textContent = " " + data_arr[i].originalFileName;
                    link.setAttribute('target', '_blank'); // เพิ่ม code นี้
                    col2.appendChild(link);
                    row.appendChild(col2);

                    var col3 = document.createElement('td');
                    col3.classList.add('text-center');
                    console.log(data_arr[i].created_at);
                    var created_at = moment(data_arr[i].created_at);
                    col3.textContent = created_at.format('DD MMM YY HH:mm');
                    row.appendChild(col3);
                    
                }

                // เพิ่มแถวลงใน tbody
                tbody.appendChild(row);
            }


        })
        .fail(function() {
            // just in case posting your form failed
            alert("Posting failed.");
        });

}

// thumbnailclickable
$('body').on('click', '.thumbnailclickable', function() {
    var target = $(this).attr("value");
    $('#ImageShow').attr('src', target);
    $('#showImageModal').modal('show');
});

loadAttachedData();