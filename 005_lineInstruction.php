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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">แก้ไขข้อมูลระบบ</h1>
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
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">แก้ไขข้อมูลระบบ</li>
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
                                        <h1><i class="fa fa-cogs fs-3"></i> แก้ไขข้อมูลระบบ</h1>
                                    </div>

                                </div>
                                <!-- เริ่มต้น Card -->

                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">ราคาน้ำมัน</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Line Group บริษัท</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-gray-900">ราคาน้ำมันขณะนี้</span><Br />
                                                    <div class="mb-2">
                                                        <!--begin::Statistics-->
                                                        <span class="fs-2hx fw-bold  text-gray-800 me-2 mb-2 lh-1 ls-n2" id="oilPricePanel"></span>
                                                        <!--end::Statistics-->

                                                        <!--begin::Description-->
                                                        <span class="fs-6 fw-semibold text-gray-500">บาทต่อลิตร</span>
                                                        <!--end::Description-->
                                                    </div>
                                                    <span class="text-gray-500 mt-1 fw-semibold fs-6" id="oilPriceLastUpdate">Update เมื่อ</span>
                                                </h3>
                                                <form id="updateCurrentOilPrice" method="post" class="m-form m-form--fit m-form--label-align-right">
                                                    <div class="form-group  mb-3 row">
                                                        <label for="currentOilPrice" class="col-sm-3 col-form-label text-end-pc">แก้ไขราคาน้ำมันปัจจุบัน</label>
                                                        <div class="col-sm-4">

                                                            <div class="input-group mb-5">
                                                                <input type="text" class="form-control" id="currentOilPrice" name="currentOilPrice" required autocomplete="off" aria-describedby="basic-addon2" />
                                                                <span class="input-group-text" id="basic-addon2">บาทต่อลิตร</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" class="btn btn-primary" id="btnUpdateOilPrice">
                                                                <i class="fas fa-save me-2"></i>บันทึกข้อมูล
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                                <form id="updateValueSystem" method="post" class="m-form m-form--fit m-form--label-align-right">
                                                    <div class="form-group  mb-3 row">
                                                        <label for="lineGroupID" class="col-sm-3 col-form-label text-end-pc">Line Group บริษัท</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="lineGroupID" name="lineGroupID" required autocomplete="off">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button type="button" class="btn  btn-light-danger" id="TestSendLineBTN">ทดสอบ</button>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" class="btn btn-primary" id="btnUpdateData">
                                                                <i class="fas fa-save me-2"></i>บันทึกข้อมูล
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

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
    <!-- Moment JS -->
    <script src="assets/plugins/custom/moment/moment-with-locales.js"></script>
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {

            // Set Moment 
            moment.locale('th');

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

            $('#updateValueSystem').on('submit', function(e) {
                e.preventDefault(); // ไม่ให้รีเฟรชหน้าเว็บ

                let ajaxData = formToObject(this);
                ajaxData['f'] = 10;
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
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
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


            function loadInitialData() {
                var ajaxData = {};
                ajaxData['f'] = '11';
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
                        var result = {};

                        data_arr.forEach(function(item) {
                            var key = item.type + '_data';
                            result[key] = item;
                        });

                        // lineGroupID
                        $('#lineGroupID').val(result.companyGroupLine_data.value);
                        

                        // Oil Price
                        $("#oilPricePanel").html(result.OilPrice_data.value)
                        $("#oilPriceLastUpdate").html("อัพเดทล่าสุดเมื่อ " + moment(result.OilPrice_data.attr1, "YYYY-MM-DD HH:mm").calendar());
                        $('#currentOilPrice').val(result.OilPrice_data.value);
                        $('#loading-spinner').hide();

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('body').on('click', '#TestSendLineBTN', function() {
                var target = $("#lineGroupID").val();
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

            $('#updateValueSystem').on('submit', function(e) {
                e.preventDefault(); // ไม่ให้รีเฟรชหน้าเว็บ

                let ajaxData = formToObject(this);
                ajaxData['f'] = 10;
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
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
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


            $('#updateCurrentOilPrice').on('submit', function(e) {
                e.preventDefault(); // ไม่ให้รีเฟรชหน้าเว็บ

                let ajaxData = formToObject(this);
                ajaxData['f'] = 12;
                console.log(ajaxData);
                
                // ส่งข้อมูลไปบันทึก
                $.ajax({
                    type: 'POST',
                    url: 'function/00_systemManagement/mainFunction.php', // URL ของไฟล์ PHP ที่รับข้อมูลจาก Form
                    data: ajaxData,
                    success: function(response) {
                        //console.log(response)
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
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

            // Load Initial Data ========================================================
            loadInitialData();


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>