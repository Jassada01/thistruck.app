<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
    include 'system_config.php';
    $CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
    include 'check_cookie.php';
?>
<head>
    <title>ข้อมูลผู้ว่าจ้าง > เพิ่มข้อมูล</title>
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
        @media (min-width: 992px) {
            .text-end-pc {
                text-align: end;
            }
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
                                        <a href="020_clientIndex.php" class="text-muted text-hover-primary">ฐานข้อมูลผู้ว่าจ้าง</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">เพิ่มข้อมูลผู้ว่าจ้าง</li>
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
                                        <h1><i class="fa fa-user-tie fs-3"></i> เพิ่มข้อมูลผู้ว่าจ้าง</h1>
                                    </div>

                                </div>
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <form id="addClient" method="post" class="m-form m-form--fit m-form--label-align-right">
                                            <div class="mb-3 row">
                                                <label for="ClientCode" class="col-sm-3 col-form-label text-end-pc">รหัสผู้ว่าจ้าง<span class="text-danger">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control required" id="ClientCode" name="ClientCode" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="ClientName" class="col-sm-3 col-form-label text-end-pc">ชื่อผู้ว่าจ้าง<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control required" id="ClientName" name="ClientName" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="Branch" class="col-sm-3 col-form-label text-end-pc">สาขา<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control required" id="Branch" name="Branch" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="Address" class="col-sm-3 col-form-label text-end-pc">ที่อยู่<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control required" id="Address" name="Address" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="BillingAddress" class="col-sm-3 col-form-label text-end-pc">ที่อยู่สำหรับเรียกเก็บเงิน<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control required" id="BillingAddress" name="BillingAddress" rows="3" required></textarea>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-sm btn-secondary" id="copyAddress">คัดลอกจากที่อยู่</button>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="TaxID" class="col-sm-3 col-form-label text-end-pc">เลขประจำตัวผู้เสียภาษี</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="TaxID" name="TaxID">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="ContactPerson" class="col-sm-3 col-form-label text-end-pc">ผู้ติดต่อ<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control required" id="ContactPerson" name="ContactPerson" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="Phone" class="col-sm-3 col-form-label text-end-pc">เบอร์โทร<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="tel" class="form-control required" id="Phone" name="Phone" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="Email" class="col-sm-3 col-form-label text-end-pc">อีเมล</label>
                                                <div class="col-sm-4">
                                                    <input type="email" class="form-control" id="Email" name="Email">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('addClient').reset()">ล้างข้อมูล</button>
                                                    <button type="submit" class="btn btn-primary">
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


            $('#addClient').on('submit', function(e) {
                e.preventDefault(); // ไม่ให้รีเฟรชหน้าเว็บ

                let ajaxData = formToObject(this);
                ajaxData['f'] = 1;

                // ส่งข้อมูลไปบันทึก
                $.ajax({
                    type: 'POST',
                    url: 'function/02_clientMaster/mainFunction.php', // URL ของไฟล์ PHP ที่รับข้อมูลจาก Form
                    data: ajaxData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลผู้ว่าจ้างเรียบร้อยแล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Redirect ไปยังหน้า 022_clientDetail.php พร้อมกับส่งค่า client_id ที่ต้องการไปด้วย parameter
                            window.location.href = "022_clientDetail.php?client_id="+response;
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log(textStatus);
                        console.log(errorThrown);
                        console.log(xhr.responseText);
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