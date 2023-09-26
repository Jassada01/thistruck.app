<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>อินวอยซ์ > สรุปอินวอยซ์</title>
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
                                    <li class="breadcrumb-item text-dark">สรุปอินวอยซ์</li>
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
                                    <div class="card-header  ribbon ribbon ribbon-top ribbon-vertical">
                                        <div class="ribbon-label bg-danger cc_ribbon d-none">
                                            ยกเลิก
                                        </div>
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-receipt-cutoff fs-3"></i> สรุปอินวอยซ์</h1>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="linktoPreform"><i class="bi bi-box-arrow-up-right fs-3"></i>จัดการอินวอยซ์</button>
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
                                                <!--end::Menu item-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#tabInvoiceList">รายการอินวอยซ์</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#tabPaymentList">รายการค่าใช้จ่าย</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="tabInvoiceList" role="tabpanel">
                                                <div class="card  card-bordered shadow-sm">
                                                    <div class="card-body  ribbon ribbon-top ribbon-vertical">
                                                        <div class="ribbon-label bg-danger">
                                                            1
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-9 mb-3 d-flex align-items-center px-6">
                                                                <h3> เปิดอินวอยซ์ไปยัง : <span id="INVclientName"></span></h3>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="container">
                                                                <form id="headerForm">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <h3> เลขที่ Invoice : <span id="INV_no"></span></h3>

                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <h3> เอกสารอ้างอิง : <span id="INV_ref"></span></h3>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="row">
                                                                <div class="col-sm-9 mt-9 d-flex align-items-center px-3">
                                                                    <h3><i class="bi bi-receipt-cutoff fs-3"></i> รายการค่าใช้จ่าย</h3>

                                                                </div>

                                                            </div>

                                                            <div class="container mt-5 table-responsive">
                                                                <table class="table table-rounded border gs-7 border-gray-300">
                                                                    <thead>
                                                                        <tr class="fw-semibold fs-6 border-bottom border-gray-200 bg-opacity-50 bg-primary">
                                                                            <th><B>สินค้า/บริการ</B></th>
                                                                            <th><B>บัญชี</B></th>
                                                                            <th><B>คำอธิบายรายการ</B></th>
                                                                            <th class="text-end"><B>จำนวน</B></th>
                                                                            <th class="text-end"><B>ราคา/หน่วย</B></th>
                                                                            <th class="text-end"><B>มูลค่าก่อนภาษี</B></th>
                                                                            <th class="text-end"><B>หัก ณ ที่จ่าย</B></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="detailTableINV">
                                                                        <!-- JavaScript will populate this area -->
                                                                    </tbody>
                                                                    <tfoot id="footerTableINV">
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tabPaymentList" role="tabpanel">

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


                // Function =============================================================
                function formatNumber(num, decimalPlaces = 2) {
                    return num ? parseFloat(num).toLocaleString(undefined, {
                        minimumFractionDigits: decimalPlaces,
                        maximumFractionDigits: decimalPlaces
                    }) : '-';
                }

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
                    ajaxData['f'] = '9';
                    ajaxData['invoice_id'] = _invoice_id;
                    //console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data)
                            var data_arr = JSON.parse(data);

                            console.log(data_arr);

                            // Header Process ===============
                            const headerData = data_arr.header[0];
                            if (headerData.attr1 === 'ยกเลิก') {
                                // cc_ribbon
                                $('.cc_ribbon').removeClass('d-none');
                                Swal.fire({
                                    title: 'อินวอยซ์ใบนี้ถูกยกเลิกแล้ว',
                                    icon: 'warning',
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                            // นำข้อมูลไปใส่ใน input box
                            $('#INV_no').html(headerData.document_number);
                            $('#INV_ref').html(headerData.reference);
                            $('#INVclientName').html(headerData.customer_code + " - " + headerData.ClientName);
                            //INVclientName


                            $('#detailTableINV').html("");
                            const details = data_arr.detail;
                            let sum_amt = 0;
                            let sum_WHT = 0;
                            $.each(details, function(index, item) {
                                let withHoldingtaxText = "<span class='text-gray-400'>ไม่ระบุ</span>"
                                if (item.withHoldingtax != "0") {
                                    withHoldingtaxText = formatNumber((item.withHoldingtax / 100) * item.AMT);
                                    sum_WHT = sum_WHT + ((item.withHoldingtax / 100) * item.AMT)
                                }
                                sum_amt = sum_amt + parseFloat(item.AMT);
                                $('#detailTableINV').append(`
                                <tr>
                                    <td>${item.ProductCode || '-'}</td>
                                    <td>${item.accounting_type || '-'}</td>
                                    <td>${item.description || '-'}</td>
                                    <td class="text-end">${formatNumber(item.QTY, 0)}</td>
                                    <td class="text-end">${formatNumber(item.unit_price)}</td>
                                    <td class="text-end">${formatNumber(item.AMT)}</td>
                                    <td class="text-end">${withHoldingtaxText}</td>
                                </tr>
                                `);
                            });
                            $('#footerTableINV').append(`
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><B>ราคารวม</B></td>
                                    <td class="text-end"><B>${formatNumber(sum_amt)}</B></td>
                                    <td></td>
                                </tr>
                                `);

                            $('#footerTableINV').append(`
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><B>หัก ณ ที่จ่ายรวม</B></td>
                                    <td class="text-end"><B>${formatNumber(sum_WHT)}</B></td>
                                    <td></td>
                                </tr>
                                `);

                            $('#footerTableINV').append(`
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><B>จำนวนเงินที่จะต้องชำระ</B></td>
                                    <td class="text-end"><B>${formatNumber(sum_amt - sum_WHT)}</B></td>
                                    <td></td>
                                </tr>
                                `);


                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }

                function loadPaymentData() {
                    var ajaxData = {};
                    // Onlyhavevalue
                    ajaxData['f'] = '11';
                    ajaxData['invoice_id'] = _invoice_id;
                    //console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data)
                            let data_arr = JSON.parse(data);
                            console.log(data_arr);
                            let result = {};

                            for (let i = 0; i < data_arr.length; i++) {
                                let item = data_arr[i];
                                let payto = item.payto;

                                if (!result[payto]) {
                                    result[payto] = [];
                                }

                                result[payto].push(item);
                            }
                            let sum_amt = 0;
                            let sum_WHT = 0;
                            let count_payment = 0;
                            $.each(result, function(key, value) {
                                sum_amt = 0;
                                sum_WHT = 0;
                                count_payment = count_payment + 1;
                                let tableHtml = "";
                                tableHtml += '<div class="card card-bordered shadow-sm mt-10">';
                                tableHtml += '<div class="card-body  ribbon ribbon-top ribbon-vertical">';
                                tableHtml += `<div class="ribbon-label bg-danger"> ${count_payment} </div>`;
                                tableHtml += `<h3>${key} : ${result[key][0]['ContactName']}</h3>
                                    <table class="table table-rounded table-striped border gs-7 border-gray-300">
                                        <thead>
                                        <tr class="fw-semibold fs-6 border-bottom border-gray-200 bg-opacity-50 bg-primary">
                                            <th><B>สินค้า/บริการ</B></th>
                                            <th><B>บัญชี</B></th>
                                            <th><B>คำอธิบายรายการ</B></th>
                                            <th class="text-end"><B>จำนวน</B></th>
                                            <th class="text-end"><B>ราคา/หน่วย</B></th>
                                            <th  class="text-end"><B>มูลค่าก่อนภาษี</B></th>
                                            <th  class="text-end"><B>หัก ณ ที่จ่าย</B></th>
                                        </tr>
                                        </thead>
                                        <tbody>`;

                                value.forEach(function(row) {
                                    price_bfTAX = row.QTY * row.unit_price;

                                    let withHoldingtaxText = "<span class='text-gray-400'>ไม่ระบุ</span>"
                                    if (row.WHT_rate != "0") {
                                        withHoldingtaxText = formatNumber((row.WHT_rate / 100) * (row.QTY * row.unit_price));
                                        sum_WHT = sum_WHT + ((row.WHT_rate / 100) * (row.QTY * row.unit_price))
                                    }
                                    sum_amt = sum_amt + parseFloat(row.QTY * row.unit_price);
                                    tableHtml += `
                                        <tr>
                                        <td>${row.Job_Name || '-' }</td>
                                        <td>${row.Accounting_No}</td>
                                        <td>${row.description}</td>
                                        <td  class="text-end">${formatNumber(row.QTY, 0)}</td>
                                        <td  class="text-end">${formatNumber(row.unit_price)}</td>
                                        <td  class="text-end">${formatNumber(price_bfTAX)}</td>
                                        <td  class="text-end">${withHoldingtaxText}</td>
                                        </tr>`;
                                });

                                tableHtml += `</tbody>`;
                                tableHtml += `<tfoot>`;
                                tableHtml += `<tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end"><B>ราคารวม</B></td>
                                                <td class="text-end"><B>${formatNumber(sum_amt)}</B></td>
                                                <td></td>
                                            </tr>`;

                                tableHtml += `<tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end"><B>หัก ณ ที่จ่ายรวม</B></td>
                                                <td class="text-end"><B>${formatNumber(sum_WHT)}</B></td>
                                                <td></td>
                                            </tr>`;
                                tableHtml += `<tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end"><B>จำนวนเงินที่จะต้องชำระ</B></td>
                                                <td class="text-end"><B>${formatNumber(sum_amt - sum_WHT)}</B></td>
                                                <td></td>
                                            </tr>`;

                                tableHtml += `</tfoot>`;
                                tableHtml += `</table>`;
                                tableHtml += '</div>';
                                tableHtml += '</div>';

                                $('#tabPaymentList').append(tableHtml);
                            });


                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }

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
                                wrap: false,
                                'order': [],
                                'pageLength': 10,
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'excel',
                                    title: '',
                                    text: 'Export Excel',
                                    filename: `ใบแจ้งหนี้_${_invoice_id}`,
                                    className: 'btn btn-success btnExport_file',
                                    init: function(api, node, config) {
                                        $(node).removeClass('dt-button').html('<i class="far fa-file-excel"></i> ' + config.text);
                                    }
                                }],

                            });

                            $(".btnExport_file").trigger("click");
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
                                    extend: 'excel',
                                    title: '',
                                    text: 'Export Excel',
                                    filename: `บันทึกค่าใช้จ่าย_${_invoice_id}`,
                                    className: 'btn btn-success btnExport_file2',
                                    init: function(api, node, config) {
                                        $(node).removeClass('dt-button').html('<i class="far fa-file-excel"></i> ' + config.text);
                                    }
                                }],

                            });

                            $(".btnExport_file2").trigger("click");
                            //ExportInvoiceTable
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                });

                $('body').on('click', '#linktoPreform', function() {
                    window.location.href = '072_preformInvoice.php?invoice_id=' + _invoice_id;
                });


                // Initial Run ===================================================================
                loadInvoiceData();
                loadPaymentData();
            });
        </script>
        <!--end::Javascript-->
</body>
<!--end::Body-->

</html>