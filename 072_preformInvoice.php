<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>อินวอยซ์ > จัดการอินวอยซ์</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" crossorigin="anonymous" />
    <!-- Data table CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- daterangepicker table CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!--end::Global Stylesheets Bundle-->
    <!--Page CSS-->
    <style>
        @media (min-width: 992px) {
            .text-end-pc {
                text-align: end;
            }
        }

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

        .center-checkbox {
            text-align: center;
        }

        .highlighted {
            background-color: "#aaaaaa";
            /* หรือสีที่คุณต้องการ */
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

        .badge_pointer {
            cursor: pointer;
        }

        .badge_pointer_job {
            cursor: pointer;
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
                $checkword = " checked";
                $inactive = isset($_GET['inactive']) && $_GET['inactive'] == 'true';
                if ($inactive) {
                    $checkword = "";
                }
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">จัดการอินวอยซ์</h1>
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
                                    <li class="breadcrumb-item text-muted">
                                        <a href="070_InvoiceIndex.php" class="text-muted text-hover-primary">อินวอยซ์</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <li class="breadcrumb-item text-dark">จัดการอินวอยซ์</li>
                                </ul>
                                <!--end::Breadcrumb-->
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">
                                <!--begin::Wrapper-->
                                <!--end::Wrapper-->
                                <!--begin::Button-->
                                <!--end::Button-->
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
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header ribbon ribbon ribbon-top ribbon-vertical">
                                        <div class="ribbon-label bg-danger cc_ribbon d-none">
                                            ยกเลิก
                                        </div>

                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-receipt-cutoff fs-3"></i> จัดการอินวอยซ์</h1>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="linktoSummary"><i class="bi bi-box-arrow-up-right fs-3"></i>สรุปอินวอยซ์</button>
                                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
                                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                            <!--begin::Menu 3-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                                <div class="menu-item px-3 printPDFInvoice">
                                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                        <i class="fas fa-file-pdf fs-3"> </i> Export to PDF
                                                    </div>

                                                    <div class="menu-item px-3">
                                                        <a class="menu-link flex-stack px-3" id="exportInvoicePDF">ใบแจ้งหนี้</a>
                                                    </div>
                                                </div>
                                                <!--begin::Heading-->
                                                <div class="menu-item px-3">
                                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                        <i class="fas fa-file-excel fs-3"> </i> Export to PEAK
                                                    </div>
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack px-3" id="exportInvoice">ใบแจ้งหนี้</a>
                                                    <a class="menu-link flex-stack px-3" id="exportPurchase">ใบบันทึกค่าใช้จ่าย</a>
                                                </div>
                                                <div class="separator border-gray-200"></div>
                                                <div class="menu-item px-3">
                                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                        <i class="bi bi-x-circle-fill"></i> </i> Cancel Invoice
                                                    </div>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack px-3" id="CanCel_Invoice">ยกเลิก Invoice</a>
                                                </div>
                                                <!--end::Menu item-->

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-9 mb-3 d-flex align-items-center px-6">
                                                <h3> เปิดอินวอยซ์ไปยัง : <span id="INVclientName"></span></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="container">
                                                <form id="headerForm">
                                                    <div class="row">
                                                        <div class="col-sm-2">

                                                            <div class="form-floating mb-7">
                                                                <input type="text" class="form-control" id="documentNumber" placeholder="เลขที่ Invoice จากระบบ PEAK" />
                                                                <label for="documentNumber">เลขที่ Invoice</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">

                                                            <div class="form-floating mb-7">
                                                                <input type="text" class="form-control" id="reference" placeholder="เอกสารอ้างอิง" />
                                                                <label for="reference">เอกสารอ้างอิง</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <a href="#" class="btn btn-light-success" id="btnSaveHeader">บันทึกข้อมูล</a>
                                                            <a href="#" class="btn btn-light-primary d-none" id="btnconfirmInvoice">สร้าง Invoice บนระบบ Thistruck</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-sm-9 mt-9 d-flex align-items-center px-3">
                                                    <h3><i class="bi bi-receipt-cutoff fs-3"></i> รายการค่าใช้จ่าย</h3>
                                                    <div class="form-check form-check-custom form-check-solid  px-3">
                                                        <input class="form-check-input" type="checkbox" value="1" checked="checked" id="Onlyhavevalue" />
                                                        <label class="form-check-label" for="Onlyhavevalue">
                                                            เฉพาะรายการที่มีการบันทึกค่าใช้จ่าย
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mt-9 text-end px-9">
                                                    <i class="text-danger">**รายการค่าใช้จ่ายจะบันทึกอัตโนมัติเมื่อมีการแก้ไข</i>
                                                </div>

                                            </div>

                                            <div class="container mt-5 table-responsive">
                                                <table class="table table-rounded border gs-7 border-gray-300">
                                                    <thead>
                                                        <tr class="fw-semibold fs-6 border-bottom border-gray-200 bg-opacity-50 bg-primary">
                                                            <th><B></B></th>
                                                            <th><B></B></th>
                                                            <th><B>รายการ</B></th>
                                                            <th><B>ราคา</B></th>
                                                            <th><B>บันทึกลงอินวอยซ์</B></th>
                                                            <th><B>บันทึกลงค่าใช้จ่าย</B></th>
                                                            <th class="text-center"><B>จ่ายให้กับ</B></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detailTable">
                                                        <!-- JavaScript will populate this area -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row d-none">
                                            <table id="ExportInvoiceTable">
                                                <thead>
                                                    <tr>
                                                        <TH>ลำดับที่*</TH>
                                                        <TH>วันที่เอกสาร</TH>
                                                        <TH>เลขที่เอกสาร</TH>
                                                        <TH>อ้างอิงถึง</TH>
                                                        <TH>ลูกค้า</TH>
                                                        <TH>เลขทะเบียน 13 หลัก</TH>
                                                        <TH>เลขสาขา 5 หลัก</TH>
                                                        <TH>เป็นใบกำกับภาษี</TH>
                                                        <TH>ประเภทราคา</TH>
                                                        <TH>สินค้า/บริการ</TH>
                                                        <TH>บัญชี</TH>
                                                        <TH>คำอธิบาย</TH>
                                                        <TH>จำนวน</TH>
                                                        <TH>ราคาต่อหน่วย</TH>
                                                        <TH>ส่วนลดต่อหน่วย</TH>
                                                        <TH>อัตราภาษี</TH>
                                                        <TH>ถูกหัก ณ ที่จ่าย(ถ้ามี)</TH>
                                                        <TH>หมายเหตุ</TH>
                                                        <TH>กลุ่มจัดประเภท</TH>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="row d-none">
                                            <table id="ExportPurchaseNote">
                                                <thead>
                                                    <tr>
                                                        <TH>ลำดับที่*</TH>
                                                        <TH>วันที่เอกสาร</TH>
                                                        <TH>อ้างอิงถึง</TH>
                                                        <TH>ผู้รับเงิน/คู่ค้า</TH>
                                                        <TH>เลขทะเบียน 13 หลัก</TH>
                                                        <TH>เลขสาขา 5 หลัก</TH>
                                                        <TH>เลขที่ใบกำกับฯ (ถ้ามี)</TH>
                                                        <TH>วันที่ใบกำกับฯ (ถ้ามี)</TH>
                                                        <TH>ประเภทราคา</TH>
                                                        <TH>สินค้า/บริการ</TH>
                                                        <TH>บัญชี</TH>
                                                        <TH>คำอธิบาย</TH>
                                                        <TH>จำนวน</TH>
                                                        <TH>ราคาต่อหน่วย</TH>
                                                        <TH>อัตราภาษี</TH>
                                                        <TH>หัก ณ ที่จ่าย (ถ้ามี)</TH>
                                                        <TH>ชำระโดย</TH>
                                                        <TH>จำนวนเงินที่ชำระ</TH>
                                                        <TH>ภ.ง.ด. (ถ้ามี)</TH>
                                                        <TH>หมายเหตุ</TH>
                                                        <TH>กลุ่มจัดประเภท</TH>

                                                    </tr>
                                                </thead>
                                            </table>
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
        <!-- Modalแก้ไขข้อมูลคนขับ -->
        <div class="modal fade" id="UpdatePayto" tabindex="-1" aria-labelledby="UpdatePaytoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="UpdatePaytoLabel">เลือกจ่ายให้กับ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="edit_driverForm" method="post" enctype="multipart/form-data">
                                    <div class="form-group mt-3 row">
                                        <label for="type" class="col-sm-3 col-form-label text-end-pc">จ่ายให้กับ</label>
                                        <div class="col-sm-8">
                                            <select class="form-control mb-2 mb-md-0 payto" name="payto" id="paytoEdit">
                                                <option></option>
                                                <?php
                                                // Connect to database
                                                include "function/connectionDb.php";

                                                // Query Payto 
                                                $sql = "SELECT * FROM contacts";
                                                $result = mysqli_query($conn, $sql);

                                                // Loop through data and create dropdown options
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                    echo "<option value='" . $row['ContactID'] . "'>" . $row['ContactID'] . " : " . $row['ContactName'] . "</option>";
                                                }

                                                // Close database connection
                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <div class="col-sm-9 offset-sm-3 text-end">
                                            <button type="button" class="btn btn-primary" id="save_new_payto">
                                                <span class="indicator-label">
                                                    บันทึกข้อมูล
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--end::Main-->
        <script>
            var hostUrl = "assets/";
        </script>
        <!--begin::Javascript-->
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->
        <!-- Moment JS -->
        <script src="assets/plugins/custom/moment/moment-with-locales.js"></script>
        <!-- Sweet Alert 2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

        <!-- Data table JS -->
        <!-- เรียกใช้งานไลบรารี DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <!-- เรียกใช้งานไลบรารี DataTables Buttons -->
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"></script>

        <!--Date Picker ภาษาไทย -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>


        <!--daterangepicker ภาษาไทย -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>






        <!--end::Page Custom Javascript-->
        <script defer>
            // เมื่อ Document โหลดเสร็จแล้ว
            $(document).ready(function() {
                // Set Moment 
                moment.locale('th');

                // Get  Paramitor Data ============================
                const urlParams = new URLSearchParams(window.location.search);
                const _invoice_id = urlParams.get('invoice_id');

                // Global Value ========================================================
                var _selected_JobID = [];
                var _select_Client = "";
                var _select_yearMonth = "";
                let detailData = {};

                let MAIN_DOC_DATE = "";

                // TEMP DATA
                let TEMP_data_type = "";
                let TEMP_data_id = "";
                let TEMP_data_value = "";
                let TEMP_updatePaytoMode = "";
                let TEMP_job_id = "";
                let TEMP_trip_id = "";


                // Function =============================================================

                // Form to Object 
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
                        if (type == "number") {
                            // Check if value is empty string ('') or not a number
                            if (value === '' || isNaN(parseFloat(value))) {
                                value = "0";
                            }
                        }
                        if (type == "radio" && $(this).is(":checked") || tag == "select" || tag == "textarea" || type != "radio") {
                            data[name] = value;
                        }
                    });
                    return data;
                }


                // Load Data ====================
                function loadInvoiceData() {
                    var ajaxData = {};
                    // Onlyhavevalue
                    ajaxData['f'] = '4';
                    ajaxData['invoice_id'] = _invoice_id;
                    ajaxData['Onlyhavevalue'] = $("#Onlyhavevalue").is(":checked") ? "1" : "0";
                    //console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            var data_arr = JSON.parse(data);
                            //console.log(data_arr);


                            //console.log(data_arr);

                            // Header Process ===============
                            const headerData = data_arr.header[0];

                            MAIN_DOC_DATE = headerData.document_date;

                            if (headerData.attr1 === 'ยกเลิก') {
                                // cc_ribbon
                                $('.cc_ribbon').removeClass('d-none');
                                Swal.fire({
                                    title: 'อินวอยซ์ใบนี้ถูกยกเลิกแล้ว',
                                    icon: 'warning',
                                    confirmButtonText: 'ตกลง'
                                });
                            }

                            if (headerData.document_number == "" || headerData.document_number == "null") {
                                //btnconfirmInvoice
                                $("#btnconfirmInvoice").removeClass('d-none')
                            } else {
                                if (headerData.document_number.substring(0, 3) == "INV") {
                                    $("#documentNumber").attr("disabled", "disabled");
                                    
                                    $(".printPDFInvoice").removeClass('d-none')
                                }

                            }
                            // นำข้อมูลไปใส่ใน input box
                            $('#documentNumber').val(headerData.document_number);
                            $('#reference').val(headerData.reference);
                            $('#INVclientName').html(headerData.customer_code + " - " + headerData.ClientName);
                            //INVclientName




                            $('#detailTable').html("");
                            // Detail Process 
                            detailData = data_arr.detail;
                            let current_job_no = "";
                            let current_trip_no = "";
                            detailData.forEach(function(item) {
                                //console.log(item);
                                // Show Job No
                                if (item.job_no !== current_job_no) {
                                    current_job_no = item.job_no;
                                    $('#detailTable').append(`
                                    <tr class="bg-opacity-50 bg-success">
                                        <td colspan="4"><a href="102_confirmWorkOrder.php?job_id=${item.job_id}" target="_blank"><B>${item.job_no ? item.job_no + ' : '+item.job_name : ''}</B></a></td>
                                        <td>
                                            <select class="form-select form-select-transparent form-select-sm  w-50 bg-opacity-25 bg-success text-dark select_allData" d-job_id="${item.job_id}" d-trip_id="" d-type="pay_invoice">
                                                <option disabled selected>เลือกทั้งใบงาน</option>
                                                <option value="1">บันทึกทั้งหมด</option>
                                                <option value="0">ไม่บันทึกทั้งหมด</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-transparent form-select-sm  w-50 bg-opacity-25 bg-success text-dark select_allData" d-job_id="${item.job_id}" d-trip_id="" d-type="pay_purchase">
                                                <option disabled selected>เลือกทั้งใบงาน</option>
                                                <option value="1">บันทึกทั้งหมด</option>
                                                <option value="0">ไม่บันทึกทั้งหมด</option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                `);
                                }
                                // Show Trip No
                                if (item.tripNo !== current_trip_no) {
                                    current_trip_no = item.tripNo;
                                    // moment(rowData.jobStartDateTime).format("Do MMM H:mm น.")
                                    show_jobTime = moment(item.jobStartDateTime).format("Do MMM H:mm น.");
                                    $('#detailTable').append(`
                                    <tr class="bg-opacity-15 bg-info">
                                        <td class="bg-opacity-20 bg-success"></td>
                                        <td colspan="3"><a  href="103_tripDetail.php?job_id=${item.job_id}&trip_id=${item.trip_id}" target="_blank"><B>${item.tripNo ? item.tripNo + ' : ' + item.realDriverName + "     " + show_jobTime : ''}</B></a></td>
                                        <td>
                                            <select class="form-select form-select-transparent form-select-sm  w-50 bg-opacity-15 bg-info text-dark select_allData" d-job_id="${item.job_id}" d-trip_id="${item.trip_id}" d-type="pay_invoice">
                                                <option disabled selected>เลือกทั้งทริป</option>
                                                <option value="1">บันทึกทั้งหมด</option>
                                                <option value="0">ไม่บันทึกทั้งหมด</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-transparent form-select-sm  w-50 bg-opacity-15 bg-info text-dark select_allData" d-job_id="${item.job_id}" d-trip_id="${item.trip_id}" d-type="pay_purchase">
                                                <option disabled selected>เลือกทั้งทริป</option>
                                                <option value="1">บันทึกทั้งหมด</option>
                                                <option value="0">ไม่บันทึกทั้งหมด</option>
                                            </select>
                                        </td>
                                        <td class="text-center"><span class="badge badge-light-info badge_pointer_job" d-value="" d-job_id="${item.job_id}" d-trip_id="${item.trip_id}">กำหนดทั้งทริป</span></td>
                                    </tr>
                                `);
                                }

                                if (item.cost_type == "job_price") {
                                    $('#detailTable').append(`
                                    <tr>
                                        <td class="bg-opacity-10 bg-success"></td>
                                        <td class="bg-opacity-5 bg-info"></td>
                                        <td><textarea class="form-control form-control-sm tableINVInput" d-type="description" d-id="${item.id}" value="${item.description}">${item.description}</textarea></td>
                                        <td><input type="text" class="form-control form-control-sm tableINVInput" d-type="unit_price" d-id="${item.id}"  value="${item.unit_price}"></td>
                                        <td><div class="form-check  form-check-solid"><input type="checkbox" class="form-check-input tableINVInputCB" d-type="pay_invoice" d-id="${item.id}"  ${item.pay_invoice === "1" ? "checked" : ""}></div></td>
                                        <td><div class="form-check  form-check-custom form-check-danger form-check-solid"><input type="checkbox" class="form-check-input tableINVInputCB" d-type="pay_purchase" d-id="${item.id}"  ${item.pay_purchase === "1" ? "checked" : ""}></div></td>
                                        <td class="text-center">${item.ContactName ? '<span class="badge badge-light-success badge_pointer" d-value="'+item.payto+'" d-id='+item.id+' d-type="payto">'+item.ContactName+"</span>" : '<span class="badge badge-light badge_pointer" d-value="" d-id='+item.id+' d-type="payto">ไม่กำหนด</span>'}</td>
                                    </tr>
                                `);
                                } else {
                                    $('#detailTable').append(`
                                    <tr>
                                        <td class="bg-opacity-10 bg-success"></td>
                                        <td class="bg-opacity-5 bg-info"></td>
                                        <td><input type="text" class="form-control form-control-sm tableINVInput" d-type="description" d-id="${item.id}" value="${item.description}"></td>
                                        <td><input type="text" class="form-control form-control-sm tableINVInput" d-type="unit_price" d-id="${item.id}"  value="${item.unit_price}"></td>
                                        <td><div class="form-check  form-check-solid"><input type="checkbox" class="form-check-input tableINVInputCB" d-type="pay_invoice" d-id="${item.id}"  ${item.pay_invoice === "1" ? "checked" : ""}></div></td>
                                        <td><div class="form-check  form-check-custom form-check-danger form-check-solid"><input type="checkbox" class="form-check-input tableINVInputCB" d-type="pay_purchase" d-id="${item.id}"  ${item.pay_purchase === "1" ? "checked" : ""}></div></td>
                                        <td class="text-center">${item.ContactName ? '<span class="badge badge-light-success badge_pointer" d-value="'+item.payto+'" d-id='+item.id+' d-type="payto">'+item.ContactName+"</span>" : '<span class="badge badge-light badge_pointer" d-value="" d-id='+item.id+' d-type="payto">ไม่กำหนด</span>'}</td>
                                    </tr>
                                `);
                                }

                            });
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }

                function checkData(data_type, data_id, data_value) {
                    // หา object ใน detailData ที่มี id ตรงกับ data_id
                    let foundItem = detailData.find(item => item.id === data_id);

                    // ถ้าไม่เจอ object ที่มี id ตรงกับ data_id
                    if (!foundItem) {
                        return false;
                    }

                    // ตรวจสอบว่าค่าของ data_type ใน object ที่เจอตรงกับ data_value หรือไม่
                    return foundItem[data_type] === data_value;
                }


                $('body').on('focusout', '.tableINVInput', function() {
                    let data_type = $(this).attr("d-type");
                    let data_id = $(this).attr("d-id");
                    let data_value = $(this).val();
                    if (!checkData(data_type, data_id, data_value)) {
                        updateDatabyID(data_type, data_id, data_value);
                    }
                });

                $('body').on('change', '.tableINVInputCB', function() {
                    let data_type = $(this).attr("d-type");
                    let data_id = $(this).attr("d-id");
                    let data_value = $(this).is(":checked") ? "1" : "0";
                    updateDatabyID(data_type, data_id, data_value);
                });


                //save_new_payto
                $('body').on('click', '#save_new_payto', function() {
                    $('#UpdatePayto').modal('hide');
                    //console.log(TEMP_data_type);
                    //console.log(TEMP_data_id);
                    TEMP_data_value = $('#paytoEdit').val()
                    //console.log(TEMP_updatePaytoMode);
                    if (TEMP_updatePaytoMode === 0) {
                        updateDatabyID(TEMP_data_type, TEMP_data_id, TEMP_data_value);
                    }
                    if (TEMP_updatePaytoMode === 1) {
                        var ajaxData = {};
                        ajaxData['f'] = '8';
                        ajaxData['invoice_id'] = _invoice_id;
                        ajaxData['data_type'] = TEMP_data_type;
                        ajaxData['job_id'] = TEMP_job_id;
                        ajaxData['trip_id'] = TEMP_trip_id;
                        ajaxData['data_value'] = TEMP_data_value;
                        //console.log(ajaxData);
                        $.ajax({
                                type: 'POST',
                                dataType: "text",
                                url: 'function/06_interface/mainFunction.php',
                                data: (ajaxData)
                            })
                            .done(function(data) {
                                //console.log(data);
                                // When finished
                                toastr.success("Update ข้อมูลแล้ว");
                                loadInvoiceData();
                            })
                            .fail(function() {
                                // just in case posting your form failed
                                alert("Posting failed.");
                            });
                    }

                    //
                });

                //badge_pointer
                $('body').on('click', '.badge_pointer', function() {
                    let data_type = $(this).attr("d-type");
                    let data_id = $(this).attr("d-id");
                    let data_value = $(this).attr("d-value");
                    //UpdatePayto
                    let foundItem = detailData.find(item => item.id === data_id);
                    if (foundItem['pay_purchase'] === '1') {

                        TEMP_data_type = data_type;
                        TEMP_data_id = data_id;
                        TEMP_data_value = data_value;
                        TEMP_updatePaytoMode = 0
                        $('#paytoEdit').val(data_value).trigger('change');
                        $('#UpdatePayto').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'รายการนี้ไม่ได้บันทึกลงค่าใช้จ่าย',
                        });
                    }
                });

                //badge_pointer_job
                $('body').on('click', '.badge_pointer_job', function() {
                    let data_type = 'payto';
                    let data_job_id = $(this).attr("d-job_id");
                    let data_trip_id = $(this).attr("d-trip_id");
                    let data_value = "";

                    TEMP_data_type = data_type;
                    TEMP_job_id = data_job_id;
                    TEMP_trip_id = data_trip_id;
                    TEMP_data_value = data_value;
                    TEMP_updatePaytoMode = 1;
                    $('#paytoEdit').val(data_value).trigger('change');
                    $('#UpdatePayto').modal('show');
                });

                //paytoEdit
                $('#paytoEdit').select2({
                    placeholder: 'เลือกจ่ายให้กับ',
                    dropdownParent: $("#UpdatePayto"),
                });

                $('body').on('change', '.select_allData', function() {
                    let data_job_id = $(this).attr('d-job_id');
                    let data_trip_id = $(this).attr('d-trip_id');
                    let data_type = $(this).attr('d-type');
                    let data_value = $(this).val();
                    var ajaxData = {};
                    ajaxData['f'] = '8';
                    ajaxData['invoice_id'] = _invoice_id;
                    ajaxData['data_type'] = data_type;
                    ajaxData['job_id'] = data_job_id;
                    ajaxData['trip_id'] = data_trip_id;
                    ajaxData['data_value'] = data_value;
                    //console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data);
                            // When finished
                            toastr.success("Update ข้อมูลแล้ว");
                            loadInvoiceData();
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });

                });




                function updateDatabyID(data_type, data_id, data_value) {
                    var ajaxData = {};
                    ajaxData['f'] = '7';
                    ajaxData['invoice_id'] = _invoice_id;
                    ajaxData['data_type'] = data_type;
                    ajaxData['data_id'] = data_id;
                    ajaxData['data_value'] = data_value;
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            // When finished
                            toastr.success("Update ข้อมูลแล้ว");
                            loadInvoiceData();
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }

                $('body').on('change', '#Onlyhavevalue', function() {
                    loadInvoiceData();
                });

                //btnSaveHeader
                $('body').on('click', '#btnSaveHeader', function() {
                    let ajaxData = {};
                    ajaxData['f'] = '10';
                    ajaxData['invoice_id'] = _invoice_id;
                    ajaxData['documentNumber'] = $('#documentNumber').val();
                    ajaxData['reference'] = $('#reference').val();
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data);
                            // When finished
                            toastr.success("Update ข้อมูลแล้ว");
                            loadInvoiceData();
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                });

                //exportInvoice
                $('body').on('click', '#exportInvoice', function() {
                    let ajaxData = {};
                    ajaxData['f'] = '13';
                    ajaxData['invoice_id'] = _invoice_id;
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data);
                            var data_arr = JSON.parse(data);
                            //console.log(data_arr);

                            exportToExcel(data_arr, `ใบแจ้งหนี้_${_invoice_id}.xlsx`);
                            /*
                            if ($.fn.dataTable.isDataTable('#ExportInvoiceTable')) {
                                // ถ้ามีการ Set DataTable แล้ว จะทำการ Destroy มัน
                                $('#ExportInvoiceTable').DataTable().destroy();
                            }
                            $('#ExportInvoiceTable').DataTable({
                                data: data_arr,
                                columns: [{
                                        data: 'ลำดับที่*'
                                    },
                                    {
                                        data: 'วันที่เอกสาร'
                                    },
                                    {
                                        data: 'เลขที่เอกสาร'
                                    },
                                    {
                                        data: 'อ้างอิงถึง'
                                    },
                                    {
                                        data: 'ลูกค้า'
                                    },
                                    {
                                        data: 'เลขทะเบียน 13 หลัก'
                                    },
                                    {
                                        data: 'เลขสาขา 5 หลัก'
                                    },
                                    {
                                        data: 'เป็นใบกำกับภาษี'
                                    },
                                    {
                                        data: 'ประเภทราคา'
                                    },
                                    {
                                        data: 'สินค้า/บริการ'
                                    },
                                    {
                                        data: 'บัญชี'
                                    },
                                    {
                                        data: 'คำอธิบาย'
                                    },
                                    {
                                        data: 'จำนวน'
                                    },
                                    {
                                        data: 'ราคาต่อหน่วย'
                                    },
                                    {
                                        data: 'ส่วนลดต่อหน่วย'
                                    },
                                    {
                                        data: 'อัตราภาษี'
                                    },
                                    {
                                        data: 'ถูกหัก ณ ที่จ่าย(ถ้ามี)'
                                    },
                                    {
                                        data: 'หมายเหตุ'
                                    },
                                    {
                                        data: 'กลุ่มจัดประเภท'
                                    },

                                ],
                                "info": false,
                                autoWidth: false,
                                wrap: true,
                                'order': [],
                                'pageLength': 10,
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'excelHtml5',
                                    title: '',
                                    text: 'Export Excel',
                                    filename: `ใบแจ้งหนี้_${_invoice_id}`,
                                    className: 'btn btn-success btnExport_file',
                                    /*
                                    exportOptions: {
                                        format: {
                                            footer: function(data, row, column, node) {
                                                // `column` contains the footer node, apply the concat function and char(10) if its newline class
                                                if ($(column).hasClass('newline')) {
                                                    //need to change double quotes to single
                                                    data = data.replace(/"/g, "'");
                                                    //split at each new line
                                                    splitData = data.split('<br>');
                                                    data = '';
                                                    for (i = 0; i < splitData.length; i++) {
                                                        //add escaped double quotes around each line
                                                        data += '\"' + splitData[i] + '\"';
                                                        //if its not the last line add CHAR(13)
                                                        if (i + 1 < splitData.length) {
                                                            data += ', CHAR(10), ';
                                                        }
                                                    }
                                                    //Add concat function
                                                    data = 'CONCATENATE(' + data + ')';
                                                    return data;
                                                }
                                                return data;
                                            }
                                        }

                                    },
                                    customize: function(xlsx) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                        // ค้นหาและปรับเปลี่ยนข้อมูลในคอลัมน์ "คำอธิบาย"
                                        $('row c[r^="L"]', sheet).each(function() { // สมมติว่า "คำอธิบาย" อยู่ในคอลัมน์ L ของ Excel
                                            var text = $('is t', this).text();
                                            if (text.includes('<br>')) {
                                                // แยกข้อมูลด้วย <br>
                                                var splitText = text.split('<br>');
                                                var newText = '';

                                                for (var i = 0; i < splitText.length; i++) {
                                                    newText += '\"' + splitText[i].trim() + '\"';
                                                    if (i + 1 < splitText.length) {
                                                        newText += ', CHAR(10), ';
                                                    }
                                                }

                                                // แปลงเป็นฟอร์มูลา Excel
                                                newText = 'CONCATENATE(' + newText + ')';
                                                $(this).attr('t', 'str').children().remove(); // ลบข้อมูลเดิมออก
                                                $(this).append('<f>' + newText + '</f>'); // เพิ่มฟอร์มูลาใหม่เข้าไป
                                            }
                                        });
                                    },

                                    init: function(api, node, config) {
                                        $(node).removeClass('dt-button').html('<i class="far fa-file-excel"></i> ' + config.text);
                                    }

                                    

                                    
                                }],

                            });

                            $(".btnExport_file").trigger("click");
                            
                            
                                    */
                            //ExportInvoiceTable
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                });

                // exportPurchase
                $('body').on('click', '#exportPurchase', function() {
                    let ajaxData = {};
                    ajaxData['f'] = '14';
                    ajaxData['invoice_id'] = _invoice_id;
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data);
                            var data_arr = JSON.parse(data);
                            //console.log(data_arr);
                            exportToExcel(data_arr, `บันทึกค่าใช้จ่าย_${_invoice_id}.xlsx`);
                            /*
                            if ($.fn.dataTable.isDataTable('#ExportPurchaseNote')) {
                                // ถ้ามีการ Set DataTable แล้ว จะทำการ Destroy มัน
                                $('#ExportPurchaseNote').DataTable().destroy();
                            }
                            $('#ExportPurchaseNote').DataTable({
                                data: data_arr,
                                columns: [{
                                        data: 'ลำดับที่*'
                                    },
                                    {
                                        data: 'วันที่เอกสาร'
                                    },
                                    {
                                        data: 'อ้างอิงถึง'
                                    },
                                    {
                                        data: 'ผู้รับเงิน/คู่ค้า'
                                    },
                                    {
                                        data: 'เลขทะเบียน 13 หลัก'
                                    },
                                    {
                                        data: 'เลขสาขา 5 หลัก'
                                    },
                                    {
                                        data: 'เลขที่ใบกำกับฯ (ถ้ามี)'
                                    },
                                    {
                                        data: 'วันที่ใบกำกับฯ (ถ้ามี)'
                                    },
                                    {
                                        data: 'ประเภทราคา'
                                    },
                                    {
                                        data: 'สินค้า/บริการ'
                                    },
                                    {
                                        data: 'บัญชี'
                                    },
                                    {
                                        data: 'คำอธิบาย'
                                    },
                                    {
                                        data: 'จำนวน'
                                    },
                                    {
                                        data: 'ราคาต่อหน่วย'
                                    },
                                    {
                                        data: 'อัตราภาษี'
                                    },
                                    {
                                        data: 'หัก ณ ที่จ่าย (ถ้ามี)'
                                    },
                                    {
                                        data: 'ชำระโดย'
                                    },
                                    {
                                        data: 'จำนวนเงินที่ชำระ'
                                    },
                                    {
                                        data: 'PNG'
                                    },
                                    {
                                        data: 'หมายเหตุ'
                                    },
                                    {
                                        data: 'กลุ่มจัดประเภท'
                                    },

                                ],
                                "info": false,
                                autoWidth: false,
                                wrap: false,
                                'order': [],
                                'pageLength': 10,
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'excelHtml5',
                                    title: '',
                                    text: 'Export Excel',
                                    filename: `บันทึกค่าใช้จ่าย_${_invoice_id}`,
                                    className: 'btn btn-success btnExport_file2',
                                    init: function(api, node, config) {
                                        $(node).removeClass('dt-button').html('<i class="far fa-file-excel"></i> ' + config.text);
                                    },


                                }],

                            });

                            $(".btnExport_file2").trigger("click");
                            //ExportInvoiceTable
                            */

                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                });


                // linktoSummary
                $('body').on('click', '#linktoSummary', function() {
                    window.location.href = '073_InvoiceResult.php?invoice_id=' + _invoice_id;
                });


                // CanCel_Invoice
                $('body').on('click', '#CanCel_Invoice', function() {
                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: "คุณต้องการยกเลิอกอินวอยซ์นี้ใช่หรือไม่?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'ยืนยันยกเลิกอินวอยซ์',
                        cancelButtonText: 'เปลี่ยนใจ >.<'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let ajaxData = {};
                            ajaxData['f'] = '15';
                            ajaxData['invoice_id'] = _invoice_id;
                            $.ajax({
                                    type: 'POST',
                                    dataType: "text",
                                    url: 'function/06_interface/mainFunction.php',
                                    data: (ajaxData)
                                })
                                .done(function(data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ยกเลิกอินวอยซ์แล้ว',
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

                function exportToExcel(data, fileName) {
                    // สร้าง workbook
                    var wb = XLSX.utils.book_new();

                    // แปลงข้อมูลเป็น worksheet
                    var ws = XLSX.utils.json_to_sheet(data);

                    // เพิ่ม worksheet เข้าไปใน workbook
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

                    // บันทึกเป็นไฟล์ .xlsx
                    var wbout = XLSX.write(wb, {
                        bookType: 'xlsx',
                        type: 'binary'
                    });

                    // ใช้งาน FileSaver เพื่อบันทึกไฟล์
                    //saveAs(new Blob([s2ab(wbout)], {
                    //    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                    //}), 'output.xlsx');
                    // การใช้งาน:
                    let blob = new Blob([s2ab(wbout)], {
                        type: "application/octet-stream"
                    });
                    openBlobWithName(blob, fileName);

                }

                function openBlobWithName(blob, filename) {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename; // ตั้งชื่อไฟล์
                    a.target = "_blank"; // เปิดในแท็บใหม่
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                }

                function s2ab(s) {
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                }

                // btnconfirmInvoice
                $('body').on('click', '#btnconfirmInvoice', function() {
                    Swal.fire({
                        title: 'สร้างอินวอยซ์',
                        text: "ยืนยันสร้างอินวอยซ์บนระบบ Thistruck",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#3085d6d33',
                        confirmButtonText: 'ยืนยันสร้างอินวอยซ์',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let ajaxData = {};
                            ajaxData['f'] = '16';
                            ajaxData['invoice_id'] = _invoice_id;
                            ajaxData['doc_date'] = MAIN_DOC_DATE;
                            $.ajax({
                                    type: 'POST',
                                    dataType: "text",
                                    url: 'function/06_interface/mainFunction.php',
                                    data: (ajaxData)
                                })
                                .done(function(data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'สร้างอินวอยซ์สำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                })
                                .fail(function() {
                                    // just in case posting your form failed
                                    alert("Posting failed.");
                                });

                        }
                    });
                });
                // exportInvoicePDF
                $('body').on('click', '#exportInvoicePDF', function() {
                    //window.open = "PDF_invoice.php?invoiceID=" + _invoice_id, '_blank';
                    window.open( "PDF_invoice.php?invoiceID=" + _invoice_id, '_blank');

                });
                // Initial Run ===================================================================
                loadInvoiceData();
            });
        </script>
        <!--end::Javascript-->
</body>
<!--end::Body-->

</html>