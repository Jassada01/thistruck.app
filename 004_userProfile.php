<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>ข้อมูลผู้ใช้งาน</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!-- Sweet Alert 2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert 2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <!-- Font Awsome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!--end::Global Stylesheets Bundle-->
    <!--Page CSS-->
    <style>
        .avatar-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 50%;
            cursor: pointer;
        }

        .avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-wrapper input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .spinner-border {
            width: 4rem;
            height: 4rem;
            border-width: 0.5em;
        }

        @media (min-width: 992px) {
            .text-end-pc {
                text-align: end;
            }
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-floating {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
        }

        #map {
            height: 400px;
            width: 100%;
        }

        #info {
            display: flex;
            justify-content: space-around;
            margin: 10px 0;
        }
    </style>

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <?php
                $fn = basename($_SERVER['PHP_SELF']);
                include 'menu.php';
                ?>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">ข้อมูลผู้ใช้งานระบบ</h1>
                                <!--end::Title-->
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start mx-4"></span>
                                <!--end::Separator-->
                                <!--begin::Breadcrumb-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a href="index.php" class="text-muted text-hover-primary">Dashboard</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">ข้อมูลผู้ใช้งาน</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            <!--begin::Row-->
                            <div class="row gy-5 g-xl-8">
                                <div class="row gy-5 g-xl-8">
                                    <div class="col-6">
                                        <h1><i class="fa fa-user-tie fs-3"></i> ข้อมูลผู้ใช้งาน</h1>
                                    </div>

                                </div>
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <form id="addUser" method="post" class="m-form m-form--fit m-form--label-align-right">
                                            <form method="post">
                                                <div class="form-group mt-3 row">
                                                    <label for="image_path_select" class="col-sm-4 col-form-label text-end-pc"></label>
                                                    <div class="col-sm-4 text-center">
                                                        <div class="avatar-wrapper" onclick="document.getElementById('image_path_select').click();">
                                                            <img id="avatar_preview" src="assets/media/avatars/default_avatar.jpg" alt="avatar">
                                                            <input type="file" class="form-control" id="image_path_select" name="image_path_select" accept="image/*">
                                                        </div>
                                                    </div>
                                                </div>
                                                </br>
                                                <div class="form-group  mb-3 row">
                                                    <label for="user_id" class="col-sm-3 col-form-label text-end-pc">ชื่อสำหรับเข้าระบบ<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="user_id" name="user_id" required autocomplete="off" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group  mb-3 row">
                                                    <label for="password" class="col-sm-3 col-form-label text-end-pc">รหัสผ่าน<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="password" name="password" required autocomplete="off" disabled>
                                                            <button type="button" class="btn btn-secondary" id="btnResetPassword" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">รีเซ็ตรหัสผ่าน</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="name" class="col-sm-3 col-form-label text-end-pc">ชื่อ<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="name" name="name" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="position_name" class="col-sm-3 col-form-label text-end-pc">ตำแหน่ง</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="position_name" name="position_name" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="email" class="col-sm-3 col-form-label text-end-pc">อีเมล</label>
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="line_id" class="col-sm-3 col-form-label text-end-pc"><a href="addLineManual.php" target="_blank">System Line ID</a></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="line_id" name="line_id" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn  btn-light-danger" id="TestSendLineBTN">ทดสอบ</button>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row d-none">
                                                    <label for="picture" class="col-sm-3 col-form-label text-end-pc">รูปภาพ</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="picture" name="picture" value="default_avatar.jpg">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="user_level" class="col-sm-3 col-form-label text-end-pc">ระดับผู้ใช้งาน<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select class="form-select" id="user_level" name="user_level" required disabled>
                                                            <option value="">-- เลือกระดับผู้ใช้งาน --</option>
                                                            <?php
                                                            // Connect to database
                                                            include "function/connectionDb.php";

                                                            // Query data from master_data where type = 'Job_Type'
                                                            $sql = "SELECT * FROM master_data WHERE type = 'user_level'";
                                                            $result = mysqli_query($conn, $sql);

                                                            // Loop through data and create dropdown options
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo "<option value='" . $row['value'] . "'>" . $row['name'] . "</option>";
                                                            }

                                                            // Close database connection
                                                            mysqli_close($conn);
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group mt-3 row d-none">
                                                    <label for="active" class="col-sm-3 col-form-label text-end-pc">Activate</label>
                                                    <div class="col-sm-3 ">
                                                        <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                                            <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="active" name="active" checked />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-9">
                                                        <button type="button" class="btn btn-secondary" onclick="location.reload()">ล้างข้อมูล</button>
                                                        <button type="submit" class="btn btn-primary" id="btnSaveNewUser">
                                                            <i class="fas fa-save me-2"></i>บันทึกข้อมูล
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                                <!-- จบ Card -->


                            </div>
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <?php
                include 'footer.php';
                ?>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->
    <!--begin::Modals-->
    <!-- Modal Reset Password  -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="resetPassword" method="post" class="m-form m-form--fit m-form--label-align-right">
                                    <div class="form-group  mb-3 row">
                                        <label for="newPassword" class="col-sm-3 col-form-label text-end-pc">รหัสผ่านใหม่<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group  mb-3 row">
                                        <label for="newPasswordConfirm" class="col-sm-3 col-form-label text-end-pc">ยืนยันรหัสผ่าน<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" id="newPasswordConfirm" name="newPasswordConfirm" required autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="btnChangePassword">เปลี่ยนรหัสผ่าน</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!-- Sweet Alert 2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <!-- MD5 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"> </script>
    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {


            // Load Data from Paramitor 
            //const urlParams = new URLSearchParams(window.location.search);
            const USER_ID = <?php echo $MAIN_USER_DATA->user_MAIN_id; ?>


            function formToObject(form) {
                var data = {};
                $(form).find("input, select, textarea").each(function(i, element) {
                    var type = $(this).attr('type');
                    var tag = $(this).prop('tagName').toLowerCase();
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    if (type == "checkbox") {
                        value = $(this).is(":checked") ? "1" : "0";
                    }
                    if (type == "radio" && $(this).is(":checked") || tag == "select" || tag == "textarea" || type != "radio") {
                        data[name] = value;
                    }
                });
                return data;
            }



            $('#image_path_select').on('change', function(event) {
                loadFile(event);
            });




            function loadFile(event) {
                const output = $('#avatar_preview');
                output.attr('src', URL.createObjectURL(event.target.files[0]));
                output.on('load', function() {
                    URL.revokeObjectURL(output.attr('src')); // free memory
                });

                const file = event.target.files[0];
                const reader = new FileReader();

                reader.addEventListener("load", function() {
                    const image = new Image();
                    image.src = reader.result;
                    image.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        const MAX_WIDTH = 500;
                        let width = image.width;
                        let height = image.height;

                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(image, 0, 0, width, height);

                        const resizedImageDataURL = canvas.toDataURL("image/jpeg");
                        uploadFile(resizedImageDataURL, "image/jpeg", "image.jpeg");

                        // resizedImageDataURL คือข้อมูลรูปภาพที่ถูกย่อขนาดแล้ว
                        // คุณสามารถใช้ resizedImageDataURL ในการแสดงผลหรือส่งข้อมูลไปยังเซิร์ฟเวอร์
                    };
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            }

            var $btnSaveNewUser = $("#btnSaveNewUser");


            function uploadFile(imageDataURL, mimeType, originalFileName) {
                // Disable Save Button
                const byteString = atob(imageDataURL.split(',')[1]);
                const arrayBuffer = new ArrayBuffer(byteString.length);
                const uint8Array = new Uint8Array(arrayBuffer);
                for (let i = 0; i < byteString.length; i++) {
                    uint8Array[i] = byteString.charCodeAt(i);
                }
                const blob = new Blob([arrayBuffer], {
                    type: mimeType
                });

                const formData = new FormData();
                if (mimeType.startsWith("image/")) {
                    formData.append("file", blob);
                } else {
                    formData.append("file", blob, originalFileName);
                }
                $.ajax({
                    type: 'POST',
                    url: 'function/uploadFile.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $btnSaveNewUser.attr("data-kt-indicator", "on");
                        $("#btnSaveNewUser").prop("disabled", true);
                    },
                    success: function(response) {
                        $btnSaveNewUser.removeAttr("data-kt-indicator");
                        $("#btnSaveNewUser").prop("disabled", false);
                        $('#picture').val(response);
                        $("#avatar_preview").attr("src", "assets/media/uploadfile/" + response);
                        //alert('Uploaded file name: ' + response);
                    },
                    error: function(error) {
                        $btnSaveNewUser.removeAttr("data-kt-indicator");
                        $("#btnSaveNewUser").prop("disabled", false);
                        console.error('Error uploading file: ', error);
                    }
                });
            }






            $('#addUser').on('submit', function(e) {
                e.preventDefault(); // ไม่ให้รีเฟรชหน้าเว็บ

                let ajaxData = formToObject(this);
                ajaxData['f'] = 3;
                ajaxData['USER_ID'] = USER_ID;
                //console.log(ajaxData);


                // ส่งข้อมูลไปบันทึก
                $.ajax({
                    type: 'POST',
                    url: 'function/00_systemManagement/mainFunction.php', // URL ของไฟล์ PHP ที่รับข้อมูลจาก Form
                    data: ajaxData,
                    success: function(response) {
                        //console.log(response)
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จกรุณาเข้าสู่ระบบใหม่อีกครั้ง',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "signout.php";
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                            text: xhr.responseText
                        });
                    }
                });

            });



            // Load User Data
            function loaduserInfobyID() {
                var ajaxData = {};
                ajaxData['f'] = '2';
                ajaxData['USER_ID'] = USER_ID;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/00_systemManagement/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {

                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        // Set values to form elements
                        $('#user_id').val(data_arr[0].user_id);
                        $('#name').val(data_arr[0].name);
                        $('#position_name').val(data_arr[0].position_name);
                        $('#email').val(data_arr[0].email);
                        $('#line_id').val(data_arr[0].line_id);
                        $('#picture').val(data_arr[0].picture);
                        $('#user_level').val(data_arr[0].user_level);
                        if (data_arr[0].active == 1) {
                            $('#active').attr('checked', true);
                        } else {
                            $('#active').removeAttr('checked');
                        }

                        $("#avatar_preview").attr("src", "assets/media/uploadfile/" + data_arr[0].picture);



                        $('#loading-spinner').hide();
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            // Get DOM elements
            const newPasswordInput = document.getElementById('newPassword');
            const newPasswordConfirmInput = document.getElementById('newPasswordConfirm');
            const btnChangePassword = document.getElementById('btnChangePassword');

            // Add event listeners to input fields
            newPasswordInput.addEventListener('input', validatePasswords);
            newPasswordConfirmInput.addEventListener('input', validatePasswords);

            // Function to validate passwords
            function validatePasswords() {
                // Get password values
                const newPassword = newPasswordInput.value;
                const newPasswordConfirm = newPasswordConfirmInput.value;

                // Get validation message element
                const validationMessage = document.getElementById('passwordValidation');

                // Check if passwords match and are not empty
                if (newPassword === newPasswordConfirm && newPassword !== '') {
                    // Enable the button
                    btnChangePassword.disabled = false;
                    // Hide validation message if it was shown
                    if (validationMessage) {
                        validationMessage.style.display = 'none';
                    }
                } else {
                    // Disable the button
                    btnChangePassword.disabled = true;
                    // Show validation message
                    if (validationMessage) {
                        validationMessage.style.display = 'block';
                    } else {
                        // Create validation message if it doesn't exist
                        const messageContainer = newPasswordConfirmInput.parentElement;
                        const message = document.createElement('div');
                        message.setAttribute('id', 'passwordValidation');
                        message.setAttribute('class', 'text-danger');
                        message.textContent = 'รหัสผ่านไม่ตรงกัน';
                        messageContainer.appendChild(message);
                    }
                }
            }

            // resetPassword

            $('#resetPasswordModal').on('show.bs.modal', function() {
                $('#resetPassword').trigger('reset');
            });


            $('body').on('click', '#btnChangePassword', function() {

                let ajaxData = {};
                ajaxData['f'] = 4;
                ajaxData['USER_ID'] = USER_ID;
                ajaxData['password'] = CryptoJS.MD5($("#newPassword").val()).toString()
                //console.log(ajaxData);


                // ส่งข้อมูลไปบันทึก
                $.ajax({
                    type: 'POST',
                    url: 'function/00_systemManagement/mainFunction.php', // URL ของไฟล์ PHP ที่รับข้อมูลจาก Form
                    data: ajaxData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จกรุณาเข้าสู่ระบบใหม่อีกครั้ง',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "signout.php";
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                            text: xhr.responseText
                        });
                    }
                });


            });

            $('body').on('click', '#TestSendLineBTN', function() {
                var target = $("#line_id").val();
                if (target.trim() != "") {
                    var ajaxData = {};
                    ajaxData['f'] = '7';
                    ajaxData['line_id'] = target;
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/00_systemManagement/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            console.log(data);
                            Swal.fire({
                                icon: 'success',
                                title: 'ส่งข้อความแล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }
            });





            // Load Data from Initail page load =======
            loaduserInfobyID();



        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>