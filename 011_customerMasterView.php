<!DOCTYPE html>
<html lang="en">
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>
<!--begin::Head-->

<head>
    <title>ข้อมูลลูกค้า > รายละเอียด</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-k9cPbgC07G16z+6Uf2n/lZi6uhgYbYzgBPOpUPP9dmO/M5ONPXHYKm3mJxEZiE+w5r5BzK5QdL5YSX9RbKMDaA==" crossorigin="anonymous" />

    <!--end::Global Stylesheets Bundle-->
    <!--Page CSS-->
    <style>
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
                                    <li class="breadcrumb-item text-dark">รายละเอียดข้อมูลลูกค้า</li>
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
                                        <div class="col-sm-6 mt-3  d-flex align-items-center px-3">
                                            <h1><i class="bi bi-person-badge-fill fs-3"></i> รายละเอียดลูกค้า</h1>
                                        </div>
                                        <div class="col-sm-6 mt-3  d-flex align-items-center px-3 text-end">
                                            <button type="button" class="btn ms-auto edit-btn btn-transparent"><i class="fas fa-edit"></i> แก้ไขข้อมูล</button>
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
                                                <div class="col-sm-4">
                                                    <label for="customer_code" class="col-sm-12 col-form-label text-danger"><i><span class="text-danger d-none">ไม่สามารถแก้ไขได้</span></i></label>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="customer_name" class="col-sm-3 col-form-label text-end-pc">ชื่อลูกค้า<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control m-input" id="customer_name" name="customer_name" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="branch" class="col-sm-3 col-form-label text-end-pc">สาขา<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control m-input" id="branch" name="branch" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="address" class="col-sm-3 col-form-label text-end-pc">ที่อยู่<span class="text-danger">*</span></label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control m-input" id="address" name="address" autocomplete="off" required></textarea>
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
                                                <label for="line_token" class="col-sm-3 col-form-label text-end-pc"><a href="addLineManual.php" target="_blank">System Line ID</a></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control m-input" id="line_token" name="line_token" autocomplete="off">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn  btn-light-danger" id="TestSendLineBTN">ทดสอบ</button>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="remark" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control m-input" id="remark" name="remark" autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="active" class="col-sm-3 col-form-label text-end-pc">Activate</label>
                                                <div class="col-sm-3 ">
                                                    <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                                        <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="active" name="active" checked />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="email" class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row d-none" id="savebtnGroup">
                                                <div class="col-sm-9 offset-sm-3 text-end">
                                                    <button type="button" class="btn btn-secondary" onclick="location.reload();">Reset</button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="far fa-save mr-1"></i> บันทึกการเปลี่ยนแปลง
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- จบฟอร์ม -->
                                    </div>
                                </div>
                                <!-- จบ Card -->

                                <!-- เริ่ม Card สถานที่ -->
                                <div class="card">
                                    <div class="card-header mt-3">
                                        <div class=" col-sm-6 mt-3">
                                            <h1><i class="fas fa-map fa-1x"></i> สถานที่ของลูกค้า</h1>
                                        </div>
                                        <div class="col-sm-6 mt-3 text-end">
                                            <!-- ปุ่มเพิ่มสถานที่ -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                                                <i class="fas fa-plus"></i> เพิ่มสถานที่
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover table-checkable" id="locationTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px;" class="text-center">No.</th>
                                                        <th>รหัสสถานที่</th>
                                                        <th>ชื่อสถานที่</th>
                                                        <th style="width: 150px;">ลิ้งแผนที่</th>
                                                        <th style="width: 100px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="locationTable_tbody"></tbody>
                                            </table>
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
    <!-- Modal เพิ่มสถานที่ -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLocationModalLabel">เพิ่มสถานที่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="locationForm" method="post" class="m-form m-form--fit m-form--label-align-right">

                                    <div class="form-group mt-3 row">
                                        <label for="location_code" class="col-sm-3 col-form-label">รหัสสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="location_code" name="location_code" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="location_name" class="col-sm-3 col-form-label">ชื่อสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="location_name" name="location_name" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="customer_id" class="col-sm-3 col-form-label">ลูกค้า<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <select class="form-control m-input" id="customer_id" name="customer_id" data-dropdown-parent="#addLocationModal" required></select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">ที่อยู่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="location_address" name="address" rows="3" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="map_url" class="col-sm-3 col-form-label">URL Google Map</label>
                                        <div class="col-sm-8">
                                            <input type="url" class="form-control m-input" id="map_url" name="map_url">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="latitude" class="col-sm-3 col-form-label">ละติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="latitude" name="latitude">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="longitude" class="col-sm-3 col-form-label">ลองติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="longitude" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="note" class="col-sm-3 col-form-label">หมายเหตุ</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="note" name="note" rows="3"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="btnSaveNewLocation">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal แก้ไขสถานที่ -->
    <div class="modal fade" id="EditLocationModal" tabindex="-1" aria-labelledby="EditLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditLocationModalLabel">แก้ไขสถานที่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="edit_locationForm" method="post" class="m-form m-form--fit m-form--label-align-right">
                                    <div class="form-group mt-3 row d-none">
                                        <label for="location_id" class="col-sm-3 col-form-label">location_id<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="location_id" name="location_id" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="location_code" class="col-sm-3 col-form-label">รหัสสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="edit_location_code" name="location_code" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="location_name" class="col-sm-3 col-form-label">ชื่อสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="edit_location_name" name="location_name" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="customer_id" class="col-sm-3 col-form-label">ลูกค้า<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <select class="form-control m-input" id="edit_customer_id" name="customer_id" data-dropdown-parent="#EditLocationModal" required></select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">ที่อยู่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="edit_location_address" name="address" rows="3" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="map_url" class="col-sm-3 col-form-label">URL Google Map</label>
                                        <div class="col-sm-8">
                                            <input type="url" class="form-control m-input" id="edit_map_url" name="map_url">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="latitude" class="col-sm-3 col-form-label">ละติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="edit_latitude" name="latitude">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="longitude" class="col-sm-3 col-form-label">ลองติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="edit_longitude" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="note" class="col-sm-3 col-form-label">หมายเหตุ</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="edit_note" name="note" rows="3"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="btnEditLocation">แก้ไขข้อมูล</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--end::Global Javascript Bundle-->
    <!-- Sweet Alert 2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
            // Load Data from Paramitor 
            const urlParams = new URLSearchParams(window.location.search);
            const customer_id = urlParams.get('customer_id');
            // --------------- Form to Object 
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
            // Page Function ----------------------------------------------

            function loadcustomerDatafromDB() {
                //var customer_id = $(this).data('id'); // ดึง Customer ID จาก data attribute
                //var customer_id = '1'; // ดึง Customer ID จาก data attribute
                //var customer_id = $_GET['customer_id'];; // ดึง Customer ID จาก data attribute
                $('#loading-spinner').show();
                let form = $('#addCustomerForm');
                // Disable Form
                form.find('input, select, textarea').prop('disabled', true);
                // ส่ง Customer ID ไปขอข้อมูลลูกค้าจากฐานข้อมูล
                $.getJSON('function/01_customerMaster/load_customer.php?id=' + customer_id, function(customer) {
                    // ใส่ข้อมูลลูกค้าลงใน Form
                    form.find('#customer_code').val(customer.customer_code);
                    form.find('#customer_name').val(customer.customer_name);
                    form.find('#address').val(customer.address);
                    form.find('#branch').val(customer.branch);
                    form.find('#tax_id').val(customer.tax_id);
                    form.find('#contact_1').val(customer.contact_1);
                    form.find('#phone_1').val(customer.phone_1);
                    form.find('#contact_2').val(customer.contact_2);
                    form.find('#phone_2').val(customer.phone_2);
                    form.find('#email').val(customer.email);
                    form.find('#attr1').val(customer.attr1);
                    form.find('#attr2').val(customer.attr2);
                    form.find('#attr3').val(customer.attr3);
                    form.find('#attr4').val(customer.attr4);
                    form.find('#attr5').val(customer.attr5);
                    form.find('#line_token').val(customer.line_token);
                    form.find('#remark').val(customer.remark);
                    if (customer.active == 1) {
                        form.find('#active').attr('checked', true);
                    } else {
                        form.find('#active').removeAttr('checked');
                    }
                    $('#loading-spinner').hide();
                });
            }

            $(".edit-btn").click(function() {
                $(this).addClass('d-none');
                $('#savebtnGroup').removeClass('d-none');
                $('#addCustomerForm input, #addCustomerForm textarea').prop('disabled', false);
            });


            // กำหนดเหตุการณ์ submit ข้อมูล
            $("#addCustomerForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                console.log(data);
                data['f'] = 1;
                data['customer_id'] = customer_id;
                // function/01_customerMaster/update_customer.php
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (data)
                    })
                    .done(function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // รีเฟรชหน้าเพื่อแสดงข้อมูลล่าสุด
                            location.reload();
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });

            // ฟังก์ชั่นแปลงค่า Google map URL to LatLon
            function convertGoogleMapUrlToLatLng(googleMapUrl) {
                const match = googleMapUrl.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
                if (match) {
                    const latitude = parseFloat(match[1]);
                    const longitude = parseFloat(match[2]);
                    return {
                        latitude,
                        longitude
                    };
                }
                return null;
            }

            // เพิ่ม Event Listener ให้กับ input element ของ googleMapUrl
            $('#map_url').on('change', function() {
                let googleMapUrlInput = document.getElementById("map_url");
                let latitudeInput = document.getElementById("latitude");
                let longitudeInput = document.getElementById("longitude");
                const url = googleMapUrlInput.value.trim();

                // ถ้า URL ไม่ว่างเปล่า ให้แปลงค่าและแสดงผลลัพธ์ใน input element ของ latitude และ longitude
                if (url !== "") {
                    const latLng = convertGoogleMapUrlToLatLng(url);
                    latitudeInput.value = latLng.latitude.toFixed(6);
                    longitudeInput.value = latLng.longitude.toFixed(6);
                } else {
                    // ถ้า URL ว่างเปล่า ให้ล้างค่าใน input element ของ latitude และ longitude
                    latitudeInput.value = "";
                    longitudeInput.value = "";
                }
            });

            $('#edit_map_url').on('change', function() {
                let googleMapUrlInput = document.getElementById("edit_map_url");
                let latitudeInput = document.getElementById("edit_latitude");
                let longitudeInput = document.getElementById("edit_longitude");
                const url = googleMapUrlInput.value.trim();

                // ถ้า URL ไม่ว่างเปล่า ให้แปลงค่าและแสดงผลลัพธ์ใน input element ของ latitude และ longitude
                if (url !== "") {
                    const latLng = convertGoogleMapUrlToLatLng(url);
                    latitudeInput.value = latLng.latitude.toFixed(6);
                    longitudeInput.value = latLng.longitude.toFixed(6);
                } else {
                    // ถ้า URL ว่างเปล่า ให้ล้างค่าใน input element ของ latitude และ longitude
                    latitudeInput.value = "";
                    longitudeInput.value = "";
                }
            });

            $('#addLocationModal').on('show.bs.modal', function() {
                $('#locationForm').trigger('reset');
                loadCustomerForSelect();
            });

            function loadCustomerForSelect() {
                var add_data = {};
                add_data['f'] = '2';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (add_data)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        // เลือก Select2
                        $('#customer_id').select2({
                            placeholder: 'เลือกลูกค้า',
                            data: data_arr.map(function(item) {
                                return {
                                    id: item.customer_id,
                                    text: item.text
                                };
                            })
                        });
                        $('#customer_id').val(customer_id).trigger('change');
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function loadCustomerForSelectforEdit() {
                var add_data = {};
                add_data['f'] = '2';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (add_data)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        // เลือก Select2
                        $('#edit_customer_id').select2({
                            placeholder: 'เลือกลูกค้า',
                            data: data_arr.map(function(item) {
                                return {
                                    id: item.customer_id,
                                    text: item.text
                                };
                            })
                        });
                        $('#edit_customer_id').val(customer_id).trigger('change');
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('#btnSaveNewLocation').click(function() {
                if (validateLocationForm()) {
                    // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                    let add_data = formToObject('#locationForm');
                    // เพิ่มข้อมูลในตาราง locations ด้วย ajax
                    add_data['f'] = '3';
                    add_data['location_type'] = 'ลูกค้า';
                    //console.log(add_data);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/01_customerMaster/mainFunction.php',
                            data: (add_data)
                        })
                        .done(function(data) {
                            //console.log(data);
                            //alert("Complete")
                            loadCustomerLocation();
                            $('#addLocationModal').modal('hide');
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }
            });

            function loadCustomerLocation() {
                var ajaxData = {};
                ajaxData['f'] = '4';
                ajaxData['customer_id'] = customer_id;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {

                        var tBodyHTML = "";
                        if (data == "[]") {
                            tBodyHTML = "<TR><TD colspan='5' style='font-style: italic; color: red;'>ยังไม่ได้มีการเพิ่มข้อมูลสถานที่ของลูกค้ารายนี้</TD></TR>";
                        } else {
                            //console.log(data);
                            var data_arr = JSON.parse(data);
                            //console.log(data_arr);
                            jQuery.each(data_arr, function(i, val) {
                                tBodyHTML += "<TR>";
                                tBodyHTML += "<TD class='text-center'>" + (i + 1) + "</TD>";
                                tBodyHTML += "<TD>" + val.location_code + "</TD>";
                                tBodyHTML += "<TD>" + val.location_name + "</TD>";
                                if (val.map_url != "") {
                                    tBodyHTML += "<TD>" + '<a href="' + val.map_url + '" target="_blank">แผนที่</a>' + "</TD>";
                                } else {
                                    tBodyHTML += "<TD></TD>";
                                }
                                tBodyHTML += '<TD><div class="btn-group">';
                                tBodyHTML += '        <button type="button" class="btn btn-sm btn-secondary btnLocationView" data-bs-toggle="modal" data-bs-target="#EditLocationModal" value="' + val.location_id + '">';
                                tBodyHTML += '            <i class="fa fa-eye"></i>';
                                tBodyHTML += '        </button>';
                                tBodyHTML += '        <button type="button" class="btn btn-sm btn-light btnLocationDelete"   value="' + val.location_id + '">';
                                tBodyHTML += '            <i class="fa fa-trash"></i>';
                                tBodyHTML += '        </button>';
                                tBodyHTML += '        </div></TD>';
                                tBodyHTML += "</TR>";
                            });
                        }
                        $("#locationTable_tbody").html(tBodyHTML);



                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function validateLocationForm() {
                let isValid = true;
                // ตรวจสอบฟิลด์ location_code
                const locationCode = document.getElementById("location_code");
                if (locationCode.value.trim() === "") {
                    locationCode.classList.add("is-invalid");
                    isValid = false;
                } else {
                    locationCode.classList.remove("is-invalid");
                }

                // ตรวจสอบฟิลด์ location_name
                const locationName = document.getElementById("location_name");
                if (locationName.value.trim() === "") {
                    locationName.classList.add("is-invalid");
                    isValid = false;
                } else {
                    locationName.classList.remove("is-invalid");
                }

                // ตรวจสอบฟิลด์ customer_id
                const customerId = document.getElementById("customer_id");
                if (customerId.value.trim() === "") {
                    customerId.classList.add("is-invalid");
                    isValid = false;
                } else {
                    customerId.classList.remove("is-invalid");
                }

                // ตรวจสอบฟิลด์ address
                const location_address = document.getElementById("location_address");
                if (location_address.value.trim() === "") {
                    location_address.classList.add("is-invalid");
                    isValid = false;
                } else {
                    location_address.classList.remove("is-invalid");
                }
                return isValid;
            }

            // View Location Data 
            // btnLocationView

            $('body').on('click', '.btnLocationView', function() {
                var target = ($(this).attr('value'));
                loadCustomerLocationID(target);
            });

            $('#EditLocationModal').on('show.bs.modal', function() {
                $('#edit_locationForm').trigger('reset');
                loadCustomerForSelectforEdit();
            });

            function loadCustomerLocationID(location_id) {
                var ajaxData = {};
                ajaxData['f'] = '5';
                ajaxData['location_id'] = location_id;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {

                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        let form = $('#edit_locationForm');
                        form.find('#location_id').val(data_arr[0].location_id);
                        form.find('#edit_location_code').val(data_arr[0].location_code);
                        form.find('#edit_location_name').val(data_arr[0].location_name);
                        form.find('#edit_customer_id').val(data_arr[0].customer_id);
                        form.find('#edit_location_address').val(data_arr[0].address);
                        form.find('#edit_map_url').val(data_arr[0].map_url);
                        form.find('#edit_latitude').val(data_arr[0].latitude);
                        form.find('#edit_longitude').val(data_arr[0].longitude);
                        form.find('#edit_note').val(data_arr[0].note);

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function validateRequiredFieldsforLocationEditForm() {
                let isValid = true;

                // ตรวจสอบฟิลด์ location_name
                const locationName = $("#edit_location_name");
                if (locationName.val().trim() === "") {
                    locationName.addClass("is-invalid");
                    isValid = false;
                } else {
                    locationName.removeClass("is-invalid");
                }

                // ตรวจสอบฟิลด์ customer_id
                const customerId = $("#edit_customer_id");
                if (customerId.val().trim() === "") {
                    customerId.addClass("is-invalid");
                    isValid = false;
                } else {
                    customerId.removeClass("is-invalid");
                }

                // ตรวจสอบฟิลด์ address
                const address = $("#edit_location_address");
                if (address.val().trim() === "") {
                    address.addClass("is-invalid");
                    isValid = false;
                } else {
                    address.removeClass("is-invalid");
                }

                // คืนค่า isValid
                return isValid;
            }

            $('#btnEditLocation').click(function() {

                if (validateRequiredFieldsforLocationEditForm()) {
                    // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                    let add_data = formToObject('#edit_locationForm');
                    // เพิ่มข้อมูลในตาราง locations ด้วย ajax
                    add_data['f'] = '6';
                    add_data['location_type'] = 'ลูกค้า';
                    add_data['active'] = '1';
                    //console.log(add_data);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/01_customerMaster/mainFunction.php',
                            data: (add_data)
                        })
                        .done(function(data) {
                            console.log(data);
                            //alert("Complete")
                            Swal.fire({
                                icon: 'success',
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            loadCustomerLocation();
                            $('#EditLocationModal').modal('hide');
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }
            });
            $('body').on('click', '.btnLocationDelete', function() {
                const locationId = $(this).val();

                Swal.fire({
                    title: 'คุณต้องการลบข้อมูลนี้หรือไม่?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ใช่, ลบเลย',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var ajaxData = {};
                        ajaxData['f'] = '7';
                        ajaxData['location_id'] = locationId;
                        //console.log(ajaxData);
                        $.ajax({
                                type: 'POST',
                                dataType: "text",
                                url: 'function/01_customerMaster/mainFunction.php',
                                data: (ajaxData)
                            })
                            .done(function(data) {
                                loadCustomerLocation();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบข้อมูลสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            })
                            .fail(function() {
                                // just in case posting your form failed
                                alert("Posting failed.");
                            });
                    }
                })
            });

            $('body').on('click', '#TestSendLineBTN', function() {
                var target = $("#line_token").val();
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


            // Run when start page ===========================
            loadcustomerDatafromDB();
            loadCustomerLocation();

        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>