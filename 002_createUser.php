<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>ผู้ใช้งานระบบ > เพิ่มข้อมูล</title>
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">ฐานข้อมูลผู้ว่าจ้าง</h1>
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
                                    <li class="breadcrumb-item text-muted">
                                        <a href="001_userIndex.php" class="text-muted text-hover-primary">ข้อมูลผู้ใช้งานระบบ</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">เพิ่มผู้ใช้งานระบบ</li>
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
                                        <h1><i class="fa fa-user-tie fs-3"></i> เพิ่มผู้ใช้งานระบบ</h1>
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
                                                        <input type="text" class="form-control" id="user_id" name="user_id" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group  mb-3 row">
                                                    <label for="password" class="col-sm-3 col-form-label text-end-pc">รหัสผ่าน<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
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
                                                        <select class="form-select" id="user_level" name="user_level" required>
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

                                                <div class="mb-3 row">
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-9">
                                                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('addUser').reset()">ล้างข้อมูล</button>
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
            // Disable Auto Complete
            $('input[type="text"], input[type="tel"], input[type="email"], textarea').attr('autocomplete', 'off');

            // Copy Data from Address to  BillingAddress
            $('#copyAddress').on('click', function() {
                $('#BillingAddress').val($('#Address').val());
            });

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
                ajaxData['password'] = CryptoJS.MD5(ajaxData['password']).toString()
                ajaxData['f'] = 1;
                //console.log(ajaxData);


                // ส่งข้อมูลไปบันทึก
                $.ajax({
                    type: 'POST',
                    url: 'function/00_systemManagement/mainFunction.php', // URL ของไฟล์ PHP ที่รับข้อมูลจาก Form
                    data: ajaxData,
                    success: function(response) {
                        console.log(response)
                        Swal.fire({
                            icon: 'success',
                            title: 'เพิ่มข้อมูล User แล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Redirect ไปยังหน้า 022_clientDetail.php พร้อมกับส่งค่า client_id ที่ต้องการไปด้วย parameter
                            //window.location.href = "022_clientDetail.php?client_id=" + response;
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

        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>