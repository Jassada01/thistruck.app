<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>วางบิล > ใบวางบิล</title>
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">จัดการใบวางบิล</h1>
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
                                        <a href="075_billingIndex.php" class="text-muted text-hover-primary">รายการใบวางบิล</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <li class="breadcrumb-item text-dark">ใบวางบิล</li>
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
                                            <h1><i class="bi bi-receipt-cutoff fs-3"></i> ใบวางบิล</h1>
                                        </div>
                                        <div class="card-toolbar">
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
                                                        <a class="menu-link flex-stack px-3" id="exportBillingPDF">ใบวางบิล</a>
                                                    </div>
                                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                        ตั้งค่า
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a class="menu-link flex-stack px-3" id="cancelBillingBtn">ยกเลิกใบวางบิล
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="กรณียกเลิกใบวางบิล จะไม่สามารถย้อนกระบวนการ"></i></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="card  card-bordered shadow-sm">
                                            <div class="card-body  ribbon ribbon-top ribbon-vertical">
                                                <div class="ribbon-label bg-danger">
                                                    ใบวางบิล
                                                </div>
                                                <div class="row">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h1 class="text-center">ใบวางบิล</h1>
                                                                <h2 class="text-center" id="billingNo"></h2>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h3>ข้อมูลลูกค้า</h3>
                                                                <p>
                                                                    <strong><span id="client_name"></span></strong><br>
                                                                    <span id="billing_address"></span><br>
                                                                    เลขประจำตัวผู้เสีภาษี : <span id="tax_id">
                                                                </p>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th><strong>วันที่ออก</strong></th>
                                                                                    <th><strong>วันที่ครบกำหนด</strong></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><span class="text-gray-800"><input class="form-control form-control-solid" placeholder="เลือก" id="billing_date" disabled /></span></td>
                                                                                    <td> <span class="text-gray-800"><input class="form-control form-control-solid" placeholder="เลือก" id="due_date" /></span></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><strong>อ้างอิง</strong></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><textarea class="form-control form-control-solid" placeholder="อ้างอิง" id="billingRef"></textarea></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-sm-9 mt-9 d-flex align-items-center px-3">
                                                            <h3><i class="bi bi-receipt-cutoff fs-3"></i> รายการวางบิล</h3>

                                                        </div>

                                                    </div>

                                                    <div class="container mt-5 table-responsive">
                                                        <table class="table table-rounded border gs-7 border-gray-300">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 border-bottom border-gray-200 bg-opacity-50 bg-primary">
                                                                    <th><B>ลำดับที่</B></th>
                                                                    <th><B>เลขที่เอกสาร</B></th>
                                                                    <th><B>วันที่ออก</B></th>
                                                                    <th><B>วันที่ครบกำหนด</B></th>
                                                                    <th class="text-end"><B>มูลค่าสุทธิ</B></th>
                                                                    <th class="text-end"><B>จำนวนเงินวางบิล</B></th>
                                                                    <th class="text-end"><B>หัก ณ ที่จ่าย</B></th>
                                                                    <th><B>เอกสารอ้างอิง</B></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="detailBilling">
                                                                <!-- JavaScript will populate this area -->
                                                            </tbody>
                                                        </table>
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <textarea class="form-control form-control-solid mt-5" placeholder="หมายเหตุ" id="billingRemark"></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- Card Start -->
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="d-flex justify-content-between">
                                                                                <div>จำนวนเอกสาร <span id="totalItem"></span> รายการ</div>
                                                                                <div>
                                                                                    <div class="card card-flush" style="background-color: #060051;">
                                                                                        <!--begin::Header-->
                                                                                        <div class="card-header pt-1">
                                                                                            <!--begin::Title-->
                                                                                            <div class="card-title d-flex flex-column">
                                                                                                <!--begin::Amount-->
                                                                                                <span class="fs-2hx fw-bold text-white lh-1 ls-n2"><span id="total_amount"></span> <span class="text-white opacity-75 pt-1 fw-semibold fs-6">บาท</span></span>
                                                                                                <!--end::Amount-->

                                                                                                <!--begin::Subtitle-->
                                                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">มูลค่าสุทธิรวม</span>
                                                                                                <!--end::Subtitle-->
                                                                                            </div>
                                                                                            <!--end::Title-->
                                                                                        </div>
                                                                                        <!--end::Header-->

                                                                                        <!--begin::Card body-->
                                                                                        <!--end::Card body-->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between mt-5">
                                                                                <div>จำนวนเงินที่ถูกหัก ณ ที่จ่าย</div>
                                                                                <div><span id="wht_amt"></span> บาท</div>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <div>จำนวนเงินที่จะต้องชำระ</div>
                                                                                <div><span id="total_pay_amount"></span> บาท</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Card End -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- จบ Card -->

                                    <div class="row  me-10">
                                        <div class=" col-sm-6">
                                        </div>
                                        <div class="col-sm-6 text-end">
                                            <button type="button" class="btn btn-secondary" style="margin-right: 10px;" onclick="location.reload();">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                            <button type="button" class="btn btn-primary" id="saveDatabtn">
                                                <i class="fas fa-save"></i> บันทึกข้อมูล
                                            </button>

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

                // Get  Parameter Data ============================
                const urlParams = new URLSearchParams(window.location.search);
                const _billingID = urlParams.get('billingID');
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

                function loadBillingData() {
                    var ajaxData = {};
                    ajaxData['f'] = '23';
                    ajaxData['billingID'] = _billingID;
                    //console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data)
                            let dataArr = JSON.parse(data);
                            //console.log(dataArr);
                            $('#client_name').html(`<a href='022_clientDetail.php?client_id=${dataArr.header.clientID}' target='_blank'>${dataArr.header.client_name}</a>`);
                            $('#billing_address').text(dataArr.header.billing_address);
                            $('#tax_id').html(`${dataArr.header.tax_id} (${dataArr.header.branch})`);
                            $('#billingNo').html(`${dataArr.header.billing_no}`);
                            $('#billingRef').html(`${dataArr.header.ref}`);
                            $('#billingRemark').html(`${dataArr.header.remark}`);

                            if (dataArr.header.status === '4') {
                                // cc_ribbon
                                $('.cc_ribbon').removeClass('d-none');
                                Swal.fire({
                                    title: 'ใบวางบิลนี้ถูกยกเลิกแล้ว',
                                    icon: 'warning',
                                    confirmButtonText: 'ตกลง'
                                });
                            }


                            const {
                                total_amount,
                                wht_amt,
                                grand_total
                            } = dataArr.header;

                            // อัปเดตจำนวนรายการ ในกรณีนี้จะนับจำนวนรายการจาก dataArr.detail
                            $('#totalItem').text(dataArr.detail.length);
                            $('#total_amount').text(parseFloat(total_amount).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                            $('#wht_amt').text(parseFloat(wht_amt).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                            $('#total_pay_amount').text(parseFloat(total_amount - wht_amt).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));

                            // อัปเดตข้อมูลวันที่
                            $('#billing_date').val(dataArr.header.billing_date);
                            $('#due_date').val(dataArr.header.due_date);


                            $("#billing_date").flatpickr({
                                dateFormat: "Y-m-d",
                                enableTime: false,
                                locale: "th",
                                altInput: true,
                                altFormat: "j M y",
                                thaiBuddhist: true,
                            });

                            $("#due_date").flatpickr({
                                dateFormat: "Y-m-d",
                                enableTime: false,
                                locale: "th",
                                altInput: true,
                                altFormat: "j M y",
                                thaiBuddhist: true,
                            });

                            // Create Detail 
                            const detailRows = dataArr.detail.map((item, index) => {
                                const formattedDocumentDate = item.document_date && item.document_date !== '0000-00-00' ? moment(item.document_date).format('D MMM YYYY') : "-";
                                const formattedDueDate = item.due_date && item.due_date !== '0000-00-00' ? moment(item.due_date).format('D MMM YYYY') : "-";

                                // จัดรูปแบบ total_amount และ wht_amount
                                const formattedTotalAmount = parseFloat(item.total_amount).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                const formattedWHTAmount = parseFloat(item.wht_amount).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });

                                return `<tr>
                                        <td>${index + 1}</td>
                                        <td><a href="073_InvoiceResult.php?invoice_id=${item.invoice_id}" target="_blank">${item.invoice_no}</td>
                                        <td>${formattedDocumentDate}</td>
                                        <td>${formattedDueDate}</td>
                                        <td class="text-end">${formattedTotalAmount}</td>
                                        <td class="text-end">${formattedTotalAmount}</td>
                                        <td class="text-end">${formattedWHTAmount}</td>
                                        <td>${item.reference_doc}</td>
                                    </tr>`;
                            }).join('');

                            $('#detailBilling').html(detailRows); // ใส่ rows ที่สร้างไว้ลงใน tbody ของตาราง



                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }

                // saveDatabtn
                $('#saveDatabtn').click(function() {
                    $('#saveDatabtn').prop('disabled', true);
                    var ajaxData = {};
                    ajaxData['f'] = '24';
                    ajaxData['billing_id'] = _billingID;
                    ajaxData['due_date'] = $('#due_date').val();
                    ajaxData['ref'] = $('#billingRef').val();
                    ajaxData['remark'] = $('#billingRemark').val();
                    ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                    console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData),
                            beforeSend: function() {
                                // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม

                                $('#loading-spinner').show();
                                $('#conFirmCreateBillingModal').modal('hide');
                            },
                        })
                        .done(function(data) {
                            //console.log(data);
                            location.reload();
                        })
                        .fail(function(data) {
                            console.log(data);
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });

                });

                // exportBillingPDF
                $('body').on('click', '#exportBillingPDF', function() {
                    //window.open = "PDF_invoice.php?invoiceID=" + _invoice_id, '_blank';
                    window.open("PDF_billing.php?billingID=" + _billingID, '_blank');

                });

                //cancelBillingBtn
                $('body').on('click', '#cancelBillingBtn', function() {
                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: "คุณต้องการยกเลิกใบวางบิลใช่หรือไม่?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่, ฉันต้องการยกเลิก!',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var ajaxData = {};
                            ajaxData['f'] = '25';
                            ajaxData['billing_id'] = _billingID;
                            ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                            console.log(ajaxData);
                            $.ajax({
                                    type: 'POST',
                                    dataType: "text",
                                    url: 'function/06_interface/mainFunction.php',
                                    data: (ajaxData),
                                })
                                .done(function(data) {
                                    setTimeout(function() {
                                        // Refresh หน้าเว็บ
                                        location.reload();
                                    }, 2000);

                                    // แสดงข้อความยืนยัน
                                    Swal.fire(
                                        'ยกเลิกเรียบร้อย!',
                                        'ใบวางบิลของคุณถูกยกเลิกแล้ว',
                                        'success'
                                    );
                                })
                                .fail(function(data) {
                                    console.log(data);
                                    // just in case posting your form failed
                                    alert("Posting failed.");
                                });

                        }
                    });
                });

                // Initial Run ===================================================================
                loadBillingData();
            });
        </script>
        <!--end::Javascript-->
</body>
<!--end::Body-->

</html>