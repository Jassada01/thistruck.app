<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>ข้อมูลผู้ว่าจ้าง > รายละเอียด</title>
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
                                    <li class="breadcrumb-item text-dark">รายละเอียดผู้ว่าจ้าง</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
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
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-6 mt-3">
                                            <h1><i class="fa fa-user-tie fs-3"></i> รายละเอียดผู้ว่าจ้าง</h1>
                                        </div>
                                        <div class="col-sm-6 mt-3 text-end-pc">
                                            <button type="button" class="btn ms-auto edit-btn btn-transparent"><i class="fas fa-edit"></i> แก้ไขข้อมูล</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="editClient" method="post" class="m-form m-form--fit m-form--label-align-right">
                                            <div class="mb-3 row">
                                                <label for="ClientCode" class="col-sm-3 col-form-label text-end-pc">รหัสผู้ว่าจ้าง<span class="text-danger">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control required" id="ClientCode" name="ClientCode" required>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="ClientCode" class="col-form-label"><i><span class="text-danger d-none">ไม่สามารถแก้ไขได้</span></i></label>
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
                                                    <button type="button" class="btn btn-sm btn-secondary d-none" id="copyAddress">คัดลอกจากที่อยู่</button>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="TaxID" class="col-sm-3 col-form-label text-end-pc">เลขประจำตัวผู้เสียภาษี</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="TaxID" name="TaxID">
                                                </div>
                                                <label for="Attr1" class="col-sm-1 col-form-label text-end-pc">เครดิต</label>
                                                <div class="col-sm-2">
                                                    <div class="input-group mb-5">
                                                        <input type="text" class="form-control" aria-describedby="basic-addon2" id="Attr1" name="Attr1" />
                                                        <span class="input-group-text" id="basic-addon2">วัน</span>
                                                    </div>
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
                                            <div class="form-group mt-3 row">
                                                <label for="Line_token" class="col-sm-3 col-form-label text-end-pc"><a href="addLineManual.php" target="_blank">System Line ID</a></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control m-input" id="Line_token" name="Line_token" autocomplete="off">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn  btn-light-danger" id="TestSendLineBTN">ทดสอบ</button>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="Remark" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control m-input" id="Remark" name="Remark" autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 row">
                                                <label for="Active" class="col-sm-3 col-form-label text-end-pc">Activate</label>
                                                <div class="col-sm-3 ">
                                                    <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                                        <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="Active" name="Active" checked />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row d-none" id="savebtnGroup">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9 offset-sm-3 text-end">
                                                    <button type="button" class="btn btn-secondary" onclick="location.reload();">Reset</button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save me-2"></i>บันทึกการเปลี่ยนแปลง
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- จบ Card -->
                                <!-- เริ่ม Card สถานที่ -->
                                <div class="card">
                                    <div class="card-header mt-3">
                                        <div class=" col-sm-6 mt-3">
                                            <h1><i class="bi bi-person-badge-fill fs-3"></i> รายชื่อลูกค้า</h1>
                                        </div>
                                        <div class="col-sm-6 mt-3 text-end">
                                            <!-- ปุ่มเพิ่มสถานที่ -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRelationModal">
                                                <i class="fas fa-plus"></i> เพิ่มลูกค้าของผู้ว่าจ้างรายนี้
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover table-checkable" id="locationTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px;" class="text-center">No.</th>
                                                        <th>รหัสลูกค้า</th>
                                                        <th>ชื่อสถานที่</th>
                                                        <th>สาขา</th>
                                                        <th>ผู้ติดต่อ</th>
                                                        <th>เบอร์โทรผู้ติดต่อ</th>
                                                        <th style="width: 100px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="customerTable_tbody"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- จบ Card -->

                                <!-- เริ่ม Card Attached File -->
                                <div class="card">
                                    <div class="card-header mt-3">
                                        <div class=" col-sm-6 mt-3">
                                            <h1><i class="fas fa-file  fs-4"></i> ไฟล์ที่เกี่ยวข้อง</h1>
                                        </div>
                                        <div class="col-sm-6 mt-3 text-end" id="rowAddFile">
                                            <!-- ปุ่มเพิ่มสถานที่ -->
                                            <button id="addFileBtn" class="btn btn-success" type="button">เพิ่มไฟล์</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="container mt-3">
                                            <div class="container">
                                                <div class="row mt-3" id="rowUploadProgress">
                                                    <div class="col-md-10">
                                                        <div class="progress">
                                                            <div id="uploadProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 align-items-center">
                                                        <span id="uploadProgress">./.</span>
                                                    </div>
                                                </div>
                                                <div class="row mt-3" id="rowSelectFile">
                                                    <div class="col-sm-6 mt-3">
                                                        <input type="text" class="form-control" id="newFileDesc" name="newFileDesc" placeholder="ประเภทไฟล์" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="uploadFile" name="uploadFiles[]" multiple>
                                                            <button class="btn btn-success" type="button" id="upload-btn">อัพโหลด</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-3">
                                                <table class="table table-striped table-rounded w-100">
                                                    <thead class="bg-success text-white">
                                                        <tr>
                                                            <th class="font-weight-bold text-center">ประเภทเอกสาร</th>
                                                            <th class="font-weight-bold text-center">ไฟล์</th>
                                                            <th class="font-weight-bold text-center">วันเวลา</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="AttachedFileList">
                                                        <!-- แสดงรายการไฟล์ที่ Upload -->
                                                    </tbody>
                                                </table>
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
    <!--begin::Modals-->
    <!-- Modal เพิ่มลูกค้า -->
    <div class="modal fade" id="addRelationModal" tabindex="-1" aria-labelledby="addRelationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRelationModalLabel">เพิ่มลูกค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="locationForm" method="post" class="m-form m-form--fit m-form--label-align-right">
                                    <div class="form-group mt-3 row">
                                        <label for="customer_id" class="col-sm-3 col-form-label">ลูกค้า<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <select class="form-control m-input" style="width: 100%" id="customer_id" name="customer_id" data-dropdown-parent="#addRelationModal" required></select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="btnaddCustomer">เพิ่ม</button>
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
    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
            // Get Data From paramitor 
            const urlParams = new URLSearchParams(window.location.search);
            const ClientID = urlParams.get('client_id');

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


            $('#editClient').on('submit', function(e) {
                e.preventDefault(); // ไม่ให้รีเฟรชหน้าเว็บ

                let ajaxData = formToObject(this);
                ajaxData['f'] = '3';
                ajaxData['ClientID'] = ClientID;

                // ส่งข้อมูลไปบันทึก
                $.ajax({
                    type: 'POST',
                    url: 'function/02_clientMaster/mainFunction.php', // URL ของไฟล์ PHP ที่รับข้อมูลจาก Form
                    data: ajaxData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกการเปลี่ยนแปลงสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // รีเฟรชหน้าเพื่อแสดงข้อมูลล่าสุด
                            location.reload();
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

            function loadCliantDatafromClientID() {
                let form = $('#editClient');
                // Disable Form
                form.find('input, select, textarea').prop('disabled', true);

                var ajaxData = {};
                ajaxData['f'] = '2';
                ajaxData['ClientID'] = ClientID;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/02_clientMaster/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {
                        //console.log(data);
                        let data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        let form = $('#editClient');
                        form.find('#ClientCode').val(data_arr[0].ClientCode);
                        form.find('#ClientName').val(data_arr[0].ClientName);
                        form.find('#Branch').val(data_arr[0].Branch);
                        form.find('#Address').val(data_arr[0].Address);
                        form.find('#BillingAddress').val(data_arr[0].BillingAddress);
                        form.find('#TaxID').val(data_arr[0].TaxID);
                        form.find('#ContactPerson').val(data_arr[0].ContactPerson);
                        form.find('#Phone').val(data_arr[0].Phone);
                        form.find('#Email').val(data_arr[0].Email);
                        form.find('#Line_token').val(data_arr[0].Line_token);
                        form.find('#Remark').val(data_arr[0].Remark);
                        form.find('#Attr1').val(data_arr[0].Attr1);
                        if (data_arr[0].Active == 1) {
                            form.find('#Active').attr('checked', true);
                        } else {
                            form.find('#Active').removeAttr('checked');
                        }
                        $('#loading-spinner').hide();


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $(".edit-btn").click(function() {
                $(this).addClass('d-none');
                $('#savebtnGroup').removeClass('d-none');
                $('#copyAddress').removeClass('d-none');
                $('#editClient input, #editClient textarea').prop('disabled', false);
            });

            function loadRelateCustomerbyClientID() {
                var ajaxData = {};
                ajaxData['f'] = '4';
                ajaxData['ClientID'] = ClientID;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/02_clientMaster/mainFunction.php',
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
                                tBodyHTML += "<td><a href='011_customerMasterView.php?customer_id=" + val.customer_id + "' target='_blank'>" + val.customer_code + "</a></td>";
                                tBodyHTML += "<TD>" + val.customer_name + "</TD>";
                                tBodyHTML += "<TD>" + val.branch + "</TD>";
                                tBodyHTML += "<TD>" + val.contact_1 + "</TD>";
                                tBodyHTML += "<TD>" + val.phone_1 + "</TD>";
                                tBodyHTML += '<TD><button type="button" class="btn btn-sm btn-outline-secondary deleteRelationbtn" value="' + val.customer_id + '"><i class="bi bi-trash"></i> </button></TD>';
                                tBodyHTML += "</TR>";
                            });
                        }
                        $("#customerTable_tbody").html(tBodyHTML);
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('body').on('click', '.deleteRelationbtn', function() {
                var ajaxData = {};
                ajaxData['f'] = '5';
                ajaxData['client_id'] = ClientID;
                ajaxData['customer_id'] = $(this).val();
                //console.log(ajaxData);
                // แสดง Sweetalert2 เพื่อยืนยันการลบความสัมพันธ์
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "คุณต้องการลบความสัมพันธ์นี้จริงหรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ลบ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ส่งค่า customerId ไปยังหน้า php ที่จะลบความสัมพันธ์
                        $.ajax({
                                type: 'POST',
                                dataType: "text",
                                url: 'function/02_clientMaster/mainFunction.php',
                                data: (ajaxData)
                            })
                            .done(function(data) {
                                loadRelateCustomerbyClientID();
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
                });
            });

            $('#addRelationModal').on('show.bs.modal', function() {
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
                            width: 'resolve',
                            data: data_arr.map(function(item) {
                                return {
                                    id: item.customer_id,
                                    text: item.text
                                };
                            })
                        });
                        //$('#customer_id').val(customer_id).trigger('change');
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            //btnaddCustomer
            $('body').on('click', '#btnaddCustomer', function() {
                var ajaxData = {};
                ajaxData['f'] = '6';
                ajaxData['client_id'] = ClientID;
                ajaxData['customer_id'] = $("#customer_id").val();
                $('#addRelationModal').modal('hide');
                //console.log(ajaxData);
                // แสดง Sweetalert2 เพื่อยืนยันการลบความสัมพันธ์
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/02_clientMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        console.log(data);
                        loadRelateCustomerbyClientID();
                        Swal.fire({
                            icon: 'success',
                            title: 'เพิ่มลูกค้าสำหรับผู้ว่าจ้างนี้สำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });

            // Upload Process ===========================================

            var TOTAL_UPLOAD_FILE = 0;
            var CURRENT_UPLOAD_FILE = 0;
            const DOCUMENT_GROUP = "CLIENT";
            const DOCUMENT_GROUP_CODE = ClientID;
            const MAIN_FILE_PATH = "assets/media/uploadfile/uploadDoc/";


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
                        //console.log(data_arr);
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
                                //console.log(data_arr[i].created_at);
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
                                //console.log(data_arr[i].created_at);
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

            $('body').on('click', '#TestSendLineBTN', function() {
                var target = $("#Line_token").val();
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

            // END Process ===========================================

            // Run from Start --------------
            loadCliantDatafromClientID();
            loadRelateCustomerbyClientID();
            
            loadAttachedData();


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>