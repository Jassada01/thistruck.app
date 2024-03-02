<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>วางบิล > สร้างใบวางบิลใหม่</title>
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">สร้างใบวางบิลใหม่</h1>
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
                                        <a href="070_InvoiceIndex.php" class="text-muted text-hover-primary">วางบิล</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <li class="breadcrumb-item text-dark">สร้างใบวางบิลใหม่</li>
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
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-receipt-cutoff fs-3"></i></i> สร้างใบวางบิลใหม่</h1>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="input-group">
                                                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                                    <span>
                                                        <i class="fa fa-calendar"></i> เดือนนี้
                                                    </span>
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <div class="col-md-12 text-end">
                                                <button type="button" class="btn btn-primary" id="createNewBilling"><i class="fas fa-plus fs-3"></i>สร้างใบวางบิลใหม่</button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table  table-bordered" id="jobTable">
                                                        <thead class="bg-primary text-white">
                                                            <tr>
                                                                <th class="font-weight-bold text-center"><span class="badge badge-circle badge-danger" id="count_selected">-</span></th>
                                                                <th class="font-weight-bold text-center"><B>เลข Invoice</B></th>
                                                                <th class="font-weight-bold text-center"><B>วันที่</B></th>
                                                                <th class="font-weight-bold text-center"><B>รหัสลูกค้า</B></th>
                                                                <th class="font-weight-bold text-center"><B>ชื่อลูกค้า</B></th>
                                                                <th class="font-weight-bold text-center"><B>Duedate</B></th>
                                                                <th class="font-weight-bold text-center"><B>เอกสารอ้างอิง</B></th>
                                                                <th class="font-weight-bold text-center"><B>จำนวนเงินวางบิล</B></th>
                                                                <th class="font-weight-bold text-center"><B>หัก ณ ที่จ่าย</B></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data จะถูกใส่ในนี่ -->
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

        <div class="modal fade" id="conFirmCreateBillingModal" tabindex="-1" aria-labelledby="conFirmCreateBillingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="conFirmCreateBillingModalLabel">สร้างใบวางบิลใหม่</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="selected_billing_header">
                            <div class="row  mb-50">
                                <div class="col-md-4">
                                    <span class="fw-bolder text-gray-700 text-xxl-end">ชื่อลูกค้า</span><BR>
                                    <span class="text-gray-800" id="billing_customer_name"></span><BR>
                                    <span class="fw-bolder text-gray-700 text-xxl-end">สาขา : </span><span class="text-gray-800" id="billing_customer_branch"></span>
                                </div>
                                <div class="col-md-4">
                                    <span class="fw-bolder text-gray-700 text-xxl-end">ที่อยู่</span><BR>
                                    <span class="text-gray-800" id="billing_customer_address"></span><BR>
                                    <span class="fw-bolder text-gray-700 text-xxl-end">Tax ID : </span><span class="text-gray-800" id="billing_customer_taxID"></span>
                                </div>
                                <div class="col-md-4">
                                    <div class="row  mb-50">
                                        <div class="col-md-6">
                                            <span class="fw-bolder text-gray-700 text-xxl-end">วันที่ออกเอกสาร</span><BR>
                                            <span class="text-gray-800"><input class="form-control form-control-solid" placeholder="เลือก" id="new_billing_date" /></span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="fw-bolder text-gray-700 text-xxl-end">วันที่ครบกำหนด</span><BR>
                                            <span class="text-gray-800"><input class="form-control form-control-solid" placeholder="เลือก" id="new_billing_duedate" /></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800">
                                        <th>No.</th>
                                        <th>เลขอินวอยซ์</th>
                                        <th>วันที่เอกสาร</th>
                                        <th>Due Date</th>
                                        <th class="text-end">ราคารวม</th>
                                        <th class="text-end">หักภาษี ณ. ที่จ่าย</th>
                                        <th>เอกสารอ้างอิง</th>
                                    </tr>
                                </thead>
                                <tbody id="invoiceTableBody">
                                    <!-- Rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="container mt-10" id="Selected_Job_summary_Panal">
                            <div class="row">
                                <div class="col-md-7">
                                    <textarea class="form-control form-control-solid" placeholder="หมายเหตุ" id="new_billing_remark" ></textarea>
                                </div>
                                <div class="col-md-5">
                                    <table class="no-border" style="width: 100%;">
                                        <tr style="vertical-align: top;" class="py-5 fw-bold  border-bottom  border-gray-300 fs-4">
                                            <th class="text-end">ยอดรวมทุกรายการ:</th>
                                            <td class="text-end" id="Selected_Job_summary_Total"></td>
                                        </tr>
                                        <tr style="vertical-align: top;">
                                            <th class="text-end">หัก ณ ที่จ่าย</th>
                                            <td class="text-end" id="Selected_Job_summary_WHT_Total"></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary" id="confirmCreateNewBilling"><i class="bi bi-receipt-cutoff fs-3"></i>สร้างใบวางบิล</button>
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
        <!-- Moment JS -->
        <script src="assets/plugins/custom/moment/moment-with-locales.js"></script>
        <!-- Sweet Alert 2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

        <!-- Data table JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
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

                // Global Value ========================================================
                var _selected_InvoiceID = [];
                var _main_Invoice_List = [];
                var _select_Client = "";
                var _select_yearMonth = "";
                var _selected_client_data = {};
                var _selected_invoice_data = [];





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
                //Date range as a button
                $('#daterange-btn').daterangepicker({
                        ranges: {
                            'วันนี้': [moment(), moment()],
                            'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '7 วันล่าสุด': [moment().subtract(6, 'days'), moment()],
                            '30 วันล่าสุด': [moment().subtract(29, 'days'), moment()],
                            'เดือนนี้': [moment().startOf('month'), moment().endOf('month')],
                            'เดือนที่ผ่านมา': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                            '3 เดือนที่ผ่านมา': [moment().subtract(3, 'month'), moment()],
                            'ปีนี้': [moment().startOf('year'), moment().endOf('year')]
                        },
                        startDate: moment().startOf('month'),
                        endDate: moment().endOf('month'),
                        locale: {
                            "format": "MM/DD/YYYY",
                            "separator": " - ",
                            "applyLabel": "ยืนยัน",
                            "cancelLabel": "ยกเลิก",
                            "fromLabel": "จาก",
                            "toLabel": "ถึง",
                            "customRangeLabel": "เลือกเอง",
                        }

                    },
                    function(start, end) {
                        $('#daterange-btn span').html(start.format(' D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'))
                        loadJobHeader(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                        //get_page_data_from_range(start.format(' YYYY-MM-DD'), end.format(' YYYY-MM-DD'));
                    }
                )

                function loadJobHeader(startDate, endDate) {
                    var ajaxData = {};
                    ajaxData['f'] = '20';
                    ajaxData['startDate'] = startDate;
                    ajaxData['endDate'] = endDate;
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
                            _main_Invoice_List = data_arr;
                            $("#count_selected").html("-")
                            _select_Client = "";
                            _select_yearMonth = "";
                            _selected_InvoiceID = [];
                            $('#jobTable').DataTable().destroy();

                            $('#jobTable').DataTable({
                                data: data_arr,
                                columns: [{
                                        data: null,
                                        //title: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", // ใช้ class ที่เราสร้าง
                                        defaultContent: ""
                                    }, // คอลัมน์สำหรับ checkbox
                                    {
                                        data: 'document_number'
                                    },
                                    {
                                        data: 'document_date'
                                    },
                                    {
                                        data: 'ClientCode'
                                    },
                                    {
                                        data: 'ClientName'
                                    },
                                    {
                                        data: 'due_date'
                                    },
                                    {
                                        data: 'reference'
                                    },
                                    {
                                        data: 'total_price'
                                    },
                                    {
                                        data: 'wht'
                                    }
                                ],
                                columnDefs: [{
                                        targets: 0, // คอลัมน์ที่ 1 (สำหรับ checkbox)
                                        className: "center-checkbox", // ใช้ class ที่เราสร้าง
                                        render: function(data, type, row) {
                                            //console.log(row.job_date);
                                            return '<input type="checkbox" class=" form-check-input job-checkbox" value="' + row.id + '" document_date="' + row.document_date + '" ClientCode="' + row.ClientCode + '">';
                                        }
                                    }, {
                                        targets: 2, // สำหรับ column ที่ 2 (job_date)
                                        render: function(data, type, row) {
                                            return moment(data).format('DD MMM YY'); // จัดรูปแบบวันที่ตามที่คุณต้องการ
                                        }
                                    },
                                    {
                                        targets: 5, // สำหรับ column ที่ 4 (jobStartDateTime)
                                        render: function(data, type, row) {
                                            if (data == null) {
                                                return "-";
                                            } else {
                                                return moment(data).format('DD MMM YY'); // จัดรูปแบบวันที่และเวลาตามที่คุณต้องการ
                                            }

                                        }
                                    }, {
                                        targets: [7, 8],
                                        render: function(data, type, row) {

                                            // ตรวจสอบว่า data เป็นตัวเลขหรือไม่
                                            if (isNaN(data)) {
                                                // ไม่ใช่ตัวเลข ให้ return data กลับมา
                                                return data;
                                            } else {
                                                // เป็นตัวเลข ให้จัดรูปแบบทศนิยม 2 ตำแหน่งพร้อมคั่นหลักพัน
                                                return Number(data).toLocaleString('th-TH', {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2,
                                                });
                                            }
                                        },
                                        className: "text-end pe-10" // ชิดขวา
                                    },
                                ],
                                "language": {
                                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                                },
                                "pageLength": 50 // กำหนดให้แสดงแถวต่อหน้าเริ่มต้นที่ 50 แถว
                            });

                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }

                // เพิ่ม event listener ให้กับ checkbox ใน DataTable
                $('#jobTable').on('change', 'input[type="checkbox"].job-checkbox', function() {
                    var $row = $(this).closest('tr');
                    let job_YearMonth = moment($(this).attr('document_date')).format("YYYYMM");
                    let ClientCode = $(this).attr('ClientCode');
                    let invoiceID = $(this).val();
                    let validate = true;

                    validate_error_msg = "";
                    if (this.checked) {
                        if (_select_Client != "") {
                            if (_select_Client != ClientCode) {
                                validate = false;
                                validate_error_msg = "ไม่สามารถสร้างใบวางบิลซ์กับผู้ว่าจ้างหลายเจ้าพร้อมกันได้";
                            }
                        } else {
                            _select_Client = ClientCode;
                        }

                        // Check is same Month

                        if (_select_yearMonth != "") {
                            if (_select_yearMonth != job_YearMonth) {
                                validate = false;
                                validate_error_msg = "ใบวางบิลจำเป็นต้องเป็นอินวอยซ์ในเดือนเดียวกันเท่านั้น";
                            }
                        } else {
                            _select_yearMonth = job_YearMonth;
                        }


                        // If validate ========================
                        if (validate) {
                            _selected_InvoiceID.push(invoiceID);
                        } else {
                            // ตั้งค่า checkbox กลับเป็น Uncheck
                            toastr.error(validate_error_msg);
                            $(this).prop('checked', false);
                        }

                        //count_selected



                    } else {
                        _selected_InvoiceID = _selected_InvoiceID.filter(_selected_InvoiceID => _selected_InvoiceID !== invoiceID);
                    }
                    $("#count_selected").html(_selected_InvoiceID.length)

                    if (_selected_InvoiceID.length == 0) {
                        _select_Client = "";
                        _select_yearMonth = "";
                    }

                    //console.log(_selected_InvoiceID);
                });


                // createNewInvoice
                $('#createNewBilling').click(function() {
                    // Validate is selected 
                    if (_selected_InvoiceID.length == 0) {
                        Swal.fire({
                            title: 'กรุณาเลือกอินวอยซ์',
                            text: 'กรุณาเลือกอินวอยซ์ที่ต้องการวางบิล',
                            icon: 'warning',
                            confirmButtonText: 'ตกลง'
                        });
                    } else {
                        $("#new_billing_date").flatpickr({
                            dateFormat: "Y-m-d",
                            enableTime: false,
                            locale: "th",
                            altInput: true,
                            altFormat: "j M y",
                            thaiBuddhist: true,
                            defaultDate: "today" // ใส่ค่า "today" เพื่อให้เป็นวันนี้เป็นค่าเริ่มต้น
                        });

                        $("#new_billing_duedate").flatpickr({
                            dateFormat: "Y-m-d",
                            enableTime: false,
                            locale: "th",
                            altInput: true,
                            altFormat: "j M y",
                            thaiBuddhist: true,
                            defaultDate: "today" // ใส่ค่า "today" เพื่อให้เป็นวันนี้เป็นค่าเริ่มต้น
                        });
                        $('#conFirmCreateBillingModal').modal('show');
                        loadInvoiceHeaderOnlySelected();
                    }
                });

                function loadInvoiceHeaderOnlySelected() {
                    const selectedInvoices = _main_Invoice_List.filter(invoice => _selected_InvoiceID.includes(invoice.id));
                    _selected_invoice_data = selectedInvoices;
                    let total_amt = 0;
                    let total_wht_amt = 0;
                    let tableBody = document.getElementById('invoiceTableBody');
                    loadCustomerInfobyClientCode(selectedInvoices[0].ClientCode);
                    // Reset Inner HTML
                    tableBody.innerHTML = "";
                    let tableNo = 0;
                    selectedInvoices.forEach(function(invoice) {
                        total_amt += parseFloat(invoice.total_price);
                        total_wht_amt += parseFloat(invoice.wht);

                        let invoice_date_print = moment(invoice.document_date).format('D MMM YY');
                        let duedate_print = "-";

                        if (invoice.due_date != null) {
                            duedate_print = moment(invoice.duedate_print).format('D MMM YY');
                        }
                        tableNo += 1;
                        var row = `<tr>
                            <td>${tableNo}.</td>
                            <td>${invoice.document_number}</td>
                            <td>${invoice_date_print}</td>
                            <td>${duedate_print || '-'}</td>
                            <td class="text-end">${parseFloat(invoice.total_price).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            <td class="text-end">${parseFloat(invoice.wht).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            <td>${invoice.reference}</td>
                        </tr>`;
                        tableBody.innerHTML += row;
                    });

                    $("#Selected_Job_summary_Total").html(parseFloat(total_amt).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }))
                    $("#Selected_Job_summary_WHT_Total").html(parseFloat(total_wht_amt).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }))
                }

                function loadCustomerInfobyClientCode(ClientCode) {
                    let ajaxData = {};
                    ajaxData['f'] = '21';
                    ajaxData['ClientCode'] = ClientCode;
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData),
                        })
                        .done(function(data) {
                            const data_arr = JSON.parse(data);
                            const customerInfo = data_arr[0];
                            _selected_client_data = customerInfo;
                            $("#billing_customer_name").html(customerInfo.ClientName);
                            $("#billing_customer_branch").html(customerInfo.Branch);
                            $("#billing_customer_address").html(customerInfo.BillingAddress);
                            $("#billing_customer_taxID").html(customerInfo.TaxID);
                        })
                        .fail(function(data) {
                            console.log(data);
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }

                $('#confirmCreateNewBilling').click(function() {
                    $('#confirmCreateNewBilling').prop('disabled', true);
                    // Create New Billing ======================
                    _selected_client_data["billing_date"] = $('#new_billing_date').val();
                    _selected_client_data["due_date"] = $('#new_billing_duedate').val();
                    _selected_client_data["billing_remark"] = $('#new_billing_remark').val();

                    var ajaxData = {};
                    ajaxData['f'] = '22';
                    ajaxData['header'] = _selected_client_data;
                    ajaxData['detail'] = _selected_invoice_data;
                    ajaxData['create_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
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
                            //window.location.href = '072_preformInvoice.php?invoice_id=' + data.match(/\d+/g).join("");;
                        })
                        .fail(function(data) {
                            console.log(data);
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                });


                // Initial Load =====
                loadJobHeader(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));





            });
        </script>
        <!--end::Javascript-->
</body>
<!--end::Body-->

</html>