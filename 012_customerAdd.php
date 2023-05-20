<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
    include 'system_config.php';
    $CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
    include 'check_cookie.php';
?>
<head>
    <title>ข้อมูลลูกค้า > เพิ่มข้อมูล</title>
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">ฐานข้อมูลลูกค้า</h1>
                                <!--end::Title-->
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start mx-4"></span>
                                <!--end::Separator-->
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
                                    <li class="breadcrumb-item text-muted">
                                        <a href="010_customerIndex.php" class="text-muted text-hover-primary">ฐานข้อมูลลูกค้า</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">เพิ่มข้อมูลลูกค้า</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
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

                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-6 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-person-badge-fill fs-3"></i> เพิ่มข้อมูลลูกค้า</h1>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- เริ่มต้นฟอร์ม -->
                                        <form id="addCustomerForm" method="post" class="m-form m-form--fit m-form--label-align-right">

                                            <div class="form-group mt-3 row">
                                                <label for="customer_code" class="col-sm-3 col-form-label text-end-pc">รหัสลูกค้า<span class="text-danger">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control m-input" id="customer_code" name="customer_code" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="customer_name" class="col-sm-3 col-form-label text-end-pc">ชื่อลูกค้า<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control m-input" id="customer_name" name="customer_name" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="address" class="col-sm-3 col-form-label text-end-pc">ที่อยู่<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control m-input" id="address" name="address" autocomplete="off" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="branch" class="col-sm-3 col-form-label text-end-pc">สาขา<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control m-input" id="branch" name="branch" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="tax_id" class="col-sm-3 col-form-label text-end-pc">Tax ID</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control m-input" id="tax_id" name="tax_id" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="contact_1" class="col-sm-3 col-form-label text-end-pc">ผู้ติดต่อ<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control m-input" id="contact_1" name="contact_1" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="phone_1" class="col-sm-3 col-form-label text-end-pc">เบอร์โทรผู้ติดต่อ</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control m-input" id="phone_1" name="phone_1" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="contact_2" class="col-sm-3 col-form-label text-end-pc">ผู้ติดต่อ(สำรอง)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control m-input" id="contact_2" name="contact_2" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="phone_2" class="col-sm-3 col-form-label text-end-pc">เบอร์โทรผู้ติดต่อ(สำรอง)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control m-input" id="phone_2" name="phone_2" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="email" class="col-sm-3 col-form-label text-end-pc">Email</label>
                                                <div class="col-sm-3">
                                                    <input type="email" class="form-control m-input" id="email" name="email" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <div class="col-sm-6 offset-sm-3">
                                                    <button type="submit" class="btn btn-primary">เพิ่มข้อมูลลูกค้า</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- จบฟอร์ม -->
                                    </div>
                                </div>


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
            // เมื่อ Submit Form
            $('form').on('submit', function(e) {
                e.preventDefault(); // ไม่ให้รีเฟรชหน้าเว็บ

                // ตรวจสอบข้อมูลก่อนส่งขึ้นเซิร์ฟเวอร์
                if ($('#customer_name').val() == '' || $('#address').val() == '' || $('#branch').val() == '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return false;
                }

                // ส่งข้อมูลไปบันทึก
                $.ajax({
                    type: 'POST',
                    url: 'function/01_customerMaster/save_customer.php', // URL ของไฟล์ PHP ที่รับข้อมูลจาก Form
                    data: $('form').serialize(), // ดึงข้อมูลจาก Form แล้วส่งไป
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลลูกค้าเรียบร้อยแล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Redirect ไปยังหน้า 011_customerMasterView.php พร้อมกับส่งค่า customer_id ที่ต้องการไปด้วย parameter
                            window.location.href = "011_customerMasterView.php?customer_id="+response;
                        });

                        // เคลียร์ Form
                        //$('form')[0].reset();
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