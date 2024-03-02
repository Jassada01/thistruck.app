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
                                                <!--end::Menu item-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
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


                // Initial Run ===================================================================

            });
        </script>
        <!--end::Javascript-->
</body>
<!--end::Body-->

</html>