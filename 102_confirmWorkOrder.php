<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>ใบงาน > ตรวจสอบใบงาน</title>
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

        .trip-link {
            cursor: pointer;
            text-decoration: underline;
        }


        /* ----------timelineAttachedFile------------ */
        .timelineAttachedFile {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;

        }

        .timelineAttachedFile img {
            width: 75px;
            height: 75px;
            max-width: 100%;
            object-fit: cover;
            margin-right: 6px;
        }

        .selected {
            outline: 4px solid #42bd41;
        }



        /* ----------track------------ */
        .track {
            position: relative;
            background-color: #ddd;
            height: 4px;
            /* ปรับสูงตามต้องการ */
            display: flex;
            margin-bottom: 60px;
            /* ปรับตามต้องการ */
            margin-top: 10px;
        }

        .track .step {
            flex-grow: 1;
            width: 20%;
            /* ปรับความกว้างตามต้องการ */
            margin-top: -12px;
            /* ปรับตำแหน่งบนตามต้องการ */
            text-align: center;
            position: relative;
        }

        .track .step.active:before {
            background: #4CAF50;
        }

        .track .step::before {
            height: 4px;
            /* ปรับสูงตามต้องการ */
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 12px;
            /* ปรับตำแหน่งบนตามต้องการ */
        }

        .track .step.active .icon {
            background: #4CAF50;
            color: #000;
        }

        .track .icon {
            display: inline-block;
            width: 30px;
            /* ปรับขนาดตามต้องการ */
            height: 30px;
            /* ปรับขนาดตามต้องการ */
            line-height: 30px;
            /* ปรับตำแหน่งกลางตามต้องการ */
            position: relative;
            border-radius: 100%;
            background: #ddd;
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000;
        }

        .track .text {
            display: block;
            margin-top: 4px;
            /* ปรับตำแหน่งบนตามต้องการ */
            font-size: 12px;
            /* ปรับขนาดตามต้องการ */
            color: #AAA;
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">ใบงาน</h1>
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
                                        <a href="100_jobOrderIndex.php" class="text-muted text-hover-primary">รายการใบงาน</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>

                                    <li class="breadcrumb-item text-dark">ตรวจสอบใบงาน</li>
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
                                            <h1><i class="bi bi-file-text fs-3"></i></i> เลขที่เอกสาร</h1>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="printJob"><i class="fas fa-file-pdf fs-3"></i>ใบงาน</button>
                                            <button type="button" class="btn btn-sm btn-color-success btn-active-light-success" id="LineUpdateStatus"><i class="fab fa-line fs-3"></i>ส่งLine</button>
                                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" id="cancelJob" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                                                        Option</div>
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack px-3" id="cancelJobBtn">ยกเลิกใบงาน
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="กรณียกเลิกใบงาน จะไม่สามารถย้อนกระบวนการและจะยกเลิก Trip ที่ยังไม่เสร็จด้วย"></i></a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="container">
                                                <form id="jobHeaderMainForm">

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-3 col-form-label text-end-pc"></label>
                                                        <label id="jobStatusText" class="col-sm-3 col-form-label text-left fs-1"></label>
                                                        <label class="col-sm-3 col-form-label text-end-pc"></label>

                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="main_book_no" class="col-sm-3 col-form-label text-end-pc">เล่มที่</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="main_book_no" name="main_book_no" placeholder="เลขอัตโนมัติ" disabled>
                                                        </div>
                                                        <label for="main_no" class="col-sm-3 col-form-label text-end-pc">เลขที่</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="main_no" name="main_no" placeholder="เลขอัตโนมัติ" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="job_id" class="col-sm-3 col-form-label text-end-pc">Job No.</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="job_no" name="job_no" placeholder="เลขอัตโนมัติ" disabled>
                                                        </div>
                                                        <label for="job_date" class="col-sm-3 col-form-label text-end-pc">วันที่</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" id="job_date" name="job_date" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row text-end">
                                                        <div class="col-sm-12">
                                                            <button type="button" class="btn  btn-sm  btn-success d-none me-1" id="confirmClient">
                                                                <i class="fas  fa-check-circle"></i> ยืนยันให้ผู้ว่าจ้างก่อน
                                                            </button>
                                                            <button type="button" class="btn  btn-sm  btn-info me-1 d-none" id="confirmsubContract">
                                                                <i class="fas  fa-check-circle"></i> ยืนยันงานให้กับรถร่วม
                                                            </button>
                                                            <div class="btn-group btn-group-sm d-none" role="group" id="confirmJobGroup">
                                                                <button type="button" class="btn btn-sm btn-primary d-none " id="confirmJob">
                                                                    <i class="fas fa-check"></i> ยืนยันใบงาน
                                                                </button>
                                                                <div class="btn-group" role="group">
                                                                    <button id="btnGroupDrop1" type="button" class="btn  btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                        <li><a class="dropdown-item" id="confirmJobbyTrip">เลือกยืนยันรายทริป</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <!--end::Menu 3-->
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-card-checklist fs-3"></i></i> รายละเอียดใบงาน</h1>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="container">
                                                <form id="jobHeaderForm">
                                                    <div class="mb-3 row">
                                                        <label for="job_name" class="col-sm-3 col-form-label text-end-pc">ชื่องาน<span class="text-danger">*</span></label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control" id="job_name" name="job_name" disabled>
                                                                <option value="">กรุณาเลือกชื่องาน</option>
                                                                <?php
                                                                // Connect to database
                                                                include "function/connectionDb.php";

                                                                // Query data from master_data where type = 'Job_Type'
                                                                //$sql = "SELECT * FROM job_order_template_header WHERE active = 1";
                                                                $sql = "SELECT a.* FROM job_order_template_header a 
                                                                INNER JOIN job_order_header b ON a.ClientID = b.ClientID AND a.customer_id = b.customer_id AND b.id = " . $_GET["job_id"];

                                                                $result = mysqli_query($conn, $sql);

                                                                // Loop through data and create dropdown options
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo "<option value='" . $row['job_name']  . "' selectID='" . $row['id'] . "' jobType='" . $row['job_type'] . "' >" . $row['job_name'] . "</option>";
                                                                }

                                                                // Close database connection
                                                                mysqli_close($conn);
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button type="button" class="btn  btn-light-danger" id="btnChangeJobName" data-bs-toggle="tooltip" data-bs-placement="top" title="เปลี่ยนเฉพาะชื่องานและประเภทงานเท่านั้น">เปลี่ยนชื่องาน</button>
                                                        </div>

                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="ClientID" class="col-sm-3 col-form-label text-end-pc"> ผู้ว่าจ้าง <span class="text-danger">*</span></label>
                                                        <div class="col-sm-5">

                                                            <select class="form-control" id="ClientID" name="ClientID" disabled>
                                                                <option value="">กรุณาเลือกผู้ว่าจ้าง</option>
                                                                <?php
                                                                // Connect to database
                                                                include "function/connectionDb.php";

                                                                // Query data from master_data where type = 'Job_Type'
                                                                $sql = "SELECT * FROM client_info WHERE Active = 1";
                                                                $result = mysqli_query($conn, $sql);

                                                                // Loop through data and create dropdown options
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo "<option value='" . $row['ClientID'] . "' ClientCode='" . $row['ClientCode'] . "'>" . $row['ClientName'] . "</option>";
                                                                }

                                                                // Close database connection
                                                                mysqli_close($conn);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="customerID" class="col-sm-3 col-form-label text-end-pc"> ลูกค้า <span class="text-danger">*</span></label>
                                                        <div class="col-sm-5">

                                                            <select class="form-control" id="customerID" name="customerID" disabled>
                                                                <option value="">กรุณาเลือกลูกค้า</option>
                                                                <?php
                                                                // Connect to database
                                                                include "function/connectionDb.php";

                                                                // Query data from master_data where type = 'Job_Type'
                                                                $sql = "SELECT * FROM customers WHERE active = 1";
                                                                $result = mysqli_query($conn, $sql);

                                                                // Loop through data and create dropdown options
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo "<option value='" . $row['customer_id'] . "'>" . $row['customer_name'] . "(" . $row['branch'] . ")</option>";
                                                                }

                                                                // Close database connection
                                                                mysqli_close($conn);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="job_type" class="col-sm-3 col-form-label text-end-pc">ประเภทงาน<span class="text-danger">*</span></label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control required" id="job_type" name="job_type" disabled>
                                                                <option value="">กรุณาเลือกประเภทงาน</option>
                                                                <?php
                                                                // Connect to database
                                                                include "function/connectionDb.php";

                                                                // Query data from master_data where type = 'Job_Type'
                                                                $sql = "SELECT * FROM master_data WHERE type = 'Job_Type'";
                                                                $result = mysqli_query($conn, $sql);

                                                                // Loop through data and create dropdown options
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                                }

                                                                // Close database connection
                                                                mysqli_close($conn);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="separator border-secondary my-5"></div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-5 col-form-label">
                                                            <h3>ข้อมูลเอกสารลูกค้า</h3>
                                                        </label>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="customer_job_no" class="col-sm-3 col-form-label text-end-pc">Job NO ของลูกค้า</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="customer_job_no" name="customer_job_no">
                                                        </div>
                                                        <label for="booking" class="col-sm-3 col-form-label text-end-pc">Booking (บุ๊กกิ้ง)</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="booking" name="booking">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="customer_po_no" class="col-sm-3 col-form-label text-end-pc">PO No.</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="customer_po_no" name="customer_po_no">
                                                        </div>
                                                        <label for="bill_of_lading" class="col-sm-3 col-form-label text-end-pc">B/L(ใบขน)</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="bill_of_lading" name="bill_of_lading">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="customer_invoice_no" class="col-sm-3 col-form-label text-end-pc">Invoice No.</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="customer_invoice_no" name="customer_invoice_no">
                                                        </div>
                                                        <label for="agent" class="col-sm-3 col-form-label text-end-pc">Agent(เอเย่นต์)</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="agent" name="agent">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="goods" class="col-sm-3 col-form-label text-end-pc">ชื่อสินค้า</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="goods" name="goods">
                                                        </div>
                                                        <label for="quantity" class="col-sm-3 col-form-label text-end-pc">QTY/No. of Package</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="quantity" name="quantity">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="remark" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ<BR><small class="text-muted">สูงสุด 4 บรรทัด</small></label>
                                                        <div class="col-sm-6">
                                                            <textarea class="form-control" id="remark" name="remark" style="resize:none;" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3 row d-none">
                                                        <label for="active" class="col-sm-3 col-form-label text-end-pc">Activate</label>
                                                        <div class="col-sm-3 ">
                                                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                                                <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="active" name="active" checked />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="remark" class="col-sm-3 col-form-label text-end-pc"></label>
                                                        <div class="col-sm-6">
                                                            <!-- 
                                                            <button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
                                                            -->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- จบ Card -->
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-card-checklist fs-3"></i></i> รายการทริปในใบงาน</h1>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" id="cancelJob" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                                                        Option</div>
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                                    <!--begin::Menu item-->
                                                    <a href="#" class="menu-link px-3">
                                                        <span class="menu-title">เปลี่ยนแผนการเดินทาง</span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu sub-->
                                                    <div class="menu-sub menu-sub-dropdown w-175px py-4" id="changeLocationMenuList">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" JobDESC="{JobDESC}" location_id="{location_id}">
                                                                {JobDESC}
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu sub-->
                                                </div>
                                                <!--end::Menu item-->
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack px-3" id="checkMapbtn">ตรวจสอบเส้นทาง</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack px-3" id="setVGMClosingbtn">ตั้งแจ้งเตือน VGM/Closing</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack px-3" id="addtripBtn">เพิ่มทริปในใบงาน</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table id="tripTable" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"><strong>หมายเลขทริป</strong></th>
                                                            <th scope="col"><strong>ทะเบียนรถบรรทุก</strong></th>
                                                            <th scope="col"><strong>ชื่อคนขับ</strong></th>
                                                            <th scope="col"><strong>หมายเลขตู้สินค้า</strong></th>
                                                            <th scope="col"><strong>สถานะ</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- รายการที่จะถูกสร้างโดย jQuery -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- จบ Card -->

                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1 class="mb-3"><i class="fas fa-file  fs-4"></i> ไฟล์ที่เกี่ยวข้อง</h1>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row" id="rowAddFile">
                                                <div class="col-sm-12 text-end">
                                                    <button id="addFileBtn" class="btn btn-success" type="button">เพิ่มไฟล์</button>
                                                </div>
                                            </div>
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
                                                        <th class="font-weight-bold text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="AttachedFileList">
                                                    <!-- แสดงรายการไฟล์ที่ Upload -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- จบ Card -->


                                <div class="row  mt-3">
                                    <div class=" col-sm-6 mt-3">
                                    </div>
                                    <div class="col-sm-6 mt-3 text-end">
                                        <button type="button" class="btn btn-secondary" style="margin-right: 10px;" onclick="location.reload();">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>
                                        <button type="button" class="btn btn-primary" id="saveDatabtn">
                                            <i class="fas fa-road"></i> บันทึกข้อมูล
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
                <!--begin::Footer-->
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->
    <!-- Modal -->
    <div class="modal fade" id="showImageModal" tabindex="-1" role="dialog" aria-labelledby="showImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="ImageShow" src="" alt="" style="display: block; margin: auto; max-width: 100%;">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="LineNotificationMSG" tabindex="-1" aria-labelledby="LineNotificationMSGLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="LineNotificationMSGLabel">การแจ้งเตือนผ่าน Line</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                            <h6 class="mb-3">ส่งหา:</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="sendToCustomer">
                                    <label class="form-check-label ms-1" for="sendToCustomer">ลูกค้า</label>
                                </div>
                                <div class="col-6 mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="sendToEmployer">
                                    <label class="form-check-label ms-1" for="sendToEmployer">ผู้ว่าจ้าง</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">ข้อความที่ต้องการส่ง</label>
                                <textarea class="form-control" id="line_message" rows="10"></textarea>
                            </div>
                        </form>
                        <br>
                        <h6 class="mb-3">ส่งรูป</h6>
                        <div id="sekectImageforSendLine" style="max-height: 400px; overflow-y: auto;">

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="sendLineMsgBtn">ส่งข้อความ</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal แผนที่ -->
    <div class="modal fade" id="showGoogleMapModal" tabindex="-1" aria-labelledby="showGoogleMapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showGoogleMapModalLabel">แผนการเดินทาง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary text-end" id="openMapButton_2"> <i class="bi bi-geo-alt-fill"></i> เปิด Google Maps
                                </button>
                            </div>
                        </div>
                        <div id="map" style="width: 100%; height: 500px;"></div>

                        <table class="table  table-bordered  table-striped w-100 mt-3">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th scope="col">แผนการเดินทาง</th>
                                    <th scope="col">ระยะทาง</th>
                                    <th scope="col">เวลา</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                        <p class=" fs-5 text-end">ระยะทางทั้งหมด: <span id="totalDistance"></span></p>
                        <p class=" fs-5 text-end">เวลาทั้งหมด: <span id="totalTime"></span></p>
                        <p class=" fs-2 text-danger text-end"><i>*ระยะทางและเวลาเป็นการคำนวนเบื้องต้นโดยยึดจากระยะทางที่ใกล้ที่สุดในและไม่คำนึงถึงสภาพการจราจร</i><span id="totalTime"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal แก้ไขแผนการเดินทาง -->
    <div class="modal fade" id="changlocationModal" tabindex="-1" aria-labelledby="changlocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changlocationModalLabel">เลือกสถานที่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="locationForm" method="post" class="m-form m-form--fit m-form--label-align-right">

                                    <div class="form-group mt-3 row">
                                        <label for="location_select" class="col-sm-3 col-form-label">เลือกสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select type="text" class="form-control m-input" id="location_select" name="location_select" data-dropdown-parent="#changlocationModal"></select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="job_characteristic" class="col-sm-3 col-form-label">ลักษณะงาน<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select type="text" class="form-control m-input" id="job_characteristic" name="job_characteristic" data-dropdown-parent="#changlocationModal">
                                                <option value="">กรุณาเลือกลักษณะงาน</option>
                                                <optgroup label="Pick Up">
                                                    <?php
                                                    // Connect to database
                                                    include "function/connectionDb.php";
                                                    // Query data from master_data where type = 'Job_Type'
                                                    $sql = "SELECT * FROM master_data WHERE type = 'job_characteristic' AND name LIKE 'Pick Up%'";
                                                    $result = mysqli_query($conn, $sql);

                                                    // Loop through data and create dropdown options
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['name'] . "' data-job_characteristic_id='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                    ?>
                                                </optgroup>
                                                <optgroup label="Return">
                                                    <?php
                                                    // Query data from master_data where type = 'Job_Type'
                                                    $sql = "SELECT * FROM master_data WHERE type = 'job_characteristic' AND name LIKE 'Return%'";
                                                    $result = mysqli_query($conn, $sql);

                                                    // Loop through data and create dropdown options
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['name'] . "'  data-job_characteristic_id='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                    ?>
                                                </optgroup>
                                                <optgroup label="Delivery">
                                                    <?php


                                                    // Query data from master_data where type = 'Job_Type'
                                                    $sql = "SELECT * FROM master_data WHERE type = 'job_characteristic' AND name LIKE 'Delivery%'";
                                                    $result = mysqli_query($conn, $sql);

                                                    // Loop through data and create dropdown options
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['name'] . "'  data-job_characteristic_id='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                    ?>
                                                </optgroup>
                                                <optgroup label="Loading">
                                                    <?php
                                                    // Query data from master_data where type = 'Job_Type'
                                                    $sql = "SELECT * FROM master_data WHERE type = 'job_characteristic' AND name = 'Loading (รับสินค้า)'";
                                                    $result = mysqli_query($conn, $sql);

                                                    // Loop through data and create dropdown options
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['name'] . "' data-job_characteristic_id='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                    ?>
                                                </optgroup>

                                                <optgroup label="Other">
                                                    <?php
                                                    // Query data from master_data where type = 'Job_Type'
                                                    $sql = "SELECT * FROM master_data WHERE type = 'job_characteristic' AND name LIKE 'Other%'";
                                                    $result = mysqli_query($conn, $sql);

                                                    // Loop through data and create dropdown options
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['name'] . "' data-job_characteristic_id='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }

                                                    // ปิดการเชื่อมต่อฐานข้อมูล
                                                    $conn->close();
                                                    ?>
                                                </optgroup>
                                            </select>
                                            <label class="col-sm-6 col-form-label d-none fs-1" id="job_characteristic_Panel"></label>
                                        </div>
                                    </div>


                                    <div class="form-group mt-3 row">
                                        <label for="job_note" class="col-sm-3 col-form-label">รายละเอียด</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="job_note" name="job_note" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="separator border-secondary my-10"></div>

                                    <h2>รายละเอียดสถานที่</h2>
                                    <div class="form-group mt-3 row">
                                        <label for="location_code" class="col-sm-3 col-form-label">รหัสสถานที่</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="location_code" name="location_code" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="location_name" class="col-sm-3 col-form-label">ชื่อสถานที่</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="location_name" name="location_name" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="location_type" class="col-sm-3 col-form-label">ประเภท</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="location_type" name="location_type" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row" id="edit_customer_panel">
                                        <label for="customer_id" class="col-sm-3 col-form-label">ลูกค้า</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="customer_id" name="customer_id" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">ที่อยู่</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="location_address" name="address" rows="3" readonly></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="map_url" class="col-sm-3 col-form-label">URL Google Map</label>
                                        <div class="col-sm-8">
                                            <input type="url" class="form-control m-input" id="map_url" name="map_url" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="latitude" class="col-sm-3 col-form-label">ละติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="latitude" name="latitude" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="longitude" class="col-sm-3 col-form-label">ลองติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="longitude" name="longitude" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="note" class="col-sm-3 col-form-label">หมายเหตุ</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="note" name="note" rows="3" readonly></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="btnAddNewLocation">เพิ่ม</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เลือก Confirm ราย Trip -->
    <div class="modal fade" id="selectTripforconfirm" tabindex="-1" aria-labelledby="selectTripforconfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectTripforconfirmLabel">เลือกทริปเพื่อคอนเฟิร์ม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover">
                        <thead class="bg-success text-white">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">หมายเลขทริป</th>
                                <th scope="col">ชื่อคนขับ</th>
                                <th scope="col">เวลาเริ่มงาน</th>
                                <th scope="col">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody id="tripTableBody">
                            <!-- เราจะแทรกข้อมูลตารางตรงนี้โดยใช้ JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmbyTrip">ยืนยันงาน</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เลือก Confirm ราย Trip -->
    <div class="modal fade" id="selectSubcontracttoConFirm" tabindex="-1" aria-labelledby="selectSubcontracttoConFirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectSubcontracttoConFirmLabel">คอนเฟิร์มงานไปยังรถร่วม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="checkboxContainerforSelectPartner" class="form-group">
                        <!-- ที่นี่จะเป็นที่วาง checkbox -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="confirmtoSubBtn">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เลือก Add new trip -->
    <div class="modal fade" id="modalAddnewTrip" tabindex="-1" aria-labelledby="modalAddnewTripLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddnewTripLabel">เพิ่มปริปในใบงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="DriverList">
                        <!--begin::Form group-->
                        <span class="text-danger d-none" id="showInaddTripIfalreadyProcess">ใบงานที่มีการเริ่มดำเนินการแล้วสามารถเลือกเพิ่มได้แค่ SONE888 ก่อน จากนั้นเข้าไปที่ใบงานเลือกเปลี่ยนคนขับรถอีกครั้ง</span>
                        <div class="form-group">
                            <div data-repeater-list="DriverList">
                                <div data-repeater-item>

                                    <div class="row">
                                        <div class="col-12">
                                            <h3 class="triptNo"></h3>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">รถ</label>
                                                    <select class="form-control mb-2 mb-md-2 truckinJob" name="truckinJob">
                                                        <?php
                                                        // Connect to database
                                                        include "function/connectionDb.php";

                                                        // Query data from master_data where type = 'Job_Type'
                                                        $sql = "SELECT a.truck_id, a.truck_type, a.truck_number, a.province, b.driver_name , b.driver_id, b.image_path, b.type as driver_type FROM truck_info a left join truck_driver_info b ON a.main_driver_id = b.driver_id WHERE a.active = 1";
                                                        $result = mysqli_query($conn, $sql);

                                                        // Loop through data and create dropdown options
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                            echo "<option value='" . $row['truck_id'] . "' driverName='" . $row['driver_name'] . "' driverImg='assets/media/uploadfile/" . $row['image_path'] . "' license='" . $row['truck_number'] . "' province='" . $row['province'] . "' driver_id='" . $row['driver_id'] . "' data-driver_id='" . $row['driver_id'] . "' data-truck_type='" . $row['truck_type'] . "'  data-driver_type='" . $row['driver_type'] . "'>" . $row['truck_number'] . " - " . $row['province'] . "</option>";
                                                        }
                                                        // Close database connection
                                                        mysqli_close($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <select class="form-control mb-2 mb-md-0 truckDriver" name="truckDriver">
                                                        <?php
                                                        // Connect to database
                                                        include "function/connectionDb.php";

                                                        // Query data from master_data where type = 'Job_Type'
                                                        $sql = "SELECT * From truck_driver_info WHERE active = 1";
                                                        $result = mysqli_query($conn, $sql);

                                                        // Loop through data and create dropdown options
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                            echo "<option value='" . $row['driver_id'] . "' driverName='" . $row['driver_name'] . "' driverImg='assets/media/uploadfile/" . $row['image_path'] . "' data-driver_type='" . $row['type'] . "' >" . $row['driver_name'] . "</option>";
                                                        }
                                                        // Close database connection
                                                        mysqli_close($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">ประเภทรถ</label>
                                                    <select class="form-control mb-2 mb-md-0 truckType" name="truckType">
                                                        <option></option>
                                                        <?php
                                                        // Connect to database
                                                        include "function/connectionDb.php";

                                                        // Query data from master_data where type = 'Job_Type'
                                                        $sql = "SELECT * FROM master_data where type = 'Truck_typeInJob' order by id;";
                                                        $result = mysqli_query($conn, $sql);

                                                        // Loop through data and create dropdown options
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                        }

                                                        // Close database connection
                                                        mysqli_close($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">เข้า</label>
                                                    <input type="date" class="form-control jobStartDateTime" name="jobStartDateTime" autocomplete="off">
                                                </div>

                                                <div class="col-md-2  text-end">
                                                    <div class="form-check form-check-custom form-check-solid mt-2 mt-md-10">
                                                        <input class="form-check-input subcontrackCheckbox" type="checkbox" value="" name="subcontrackCheckbox" />
                                                        <label class="form-check-label" for="subcontrackCheckbox">
                                                            รถร่วม
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-5">
                                                <div class="col-md-3">
                                                    <label class="form-label">หมายเลขตู้ 1</label>
                                                    <input class="form-control mb-2 mb-md-0 containerID" name="containerID" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">ขนาดตู้(Type)</label>
                                                    <select class="form-control mb-2 mb-md-0 containersize" name="containersize">
                                                        <option></option>
                                                        <?php
                                                        // Connect to database
                                                        include "function/connectionDb.php";

                                                        // Query data from master_data where type = 'Job_Type'
                                                        $sql = "SELECT * FROM master_data where type = 'container_size' order by id;";
                                                        $result = mysqli_query($conn, $sql);

                                                        // Loop through data and create dropdown options
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                            echo "<option value='" . $row['value'] . "'>" . $row['name'] . "</option>";
                                                        }

                                                        // Close database connection
                                                        mysqli_close($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">หมายเลขซีล</label>
                                                    <input class="form-control mb-2 mb-md-0 sealNo" name="sealNo" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">น้ำหนักตู้</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control containerWeight" name="containerWeight" autocomplete="off" />
                                                        <span class="input-group-text" id="basic-addon2">กก.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-5 d-none">
                                                <div class="col-md-3">
                                                    <label class="form-label">หมายเลขตู้ 2</label>
                                                    <input class="form-control mb-2 mb-md-0 containerID2" name="containerID2" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">ขนาดตู้(Type)</label>
                                                    <select class="form-control mb-2 mb-md-0 containersize2" name="containersize2">
                                                        <option></option>
                                                        <?php
                                                        // Connect to database
                                                        include "function/connectionDb.php";

                                                        // Query data from master_data where type = 'Job_Type'
                                                        $sql = "SELECT * FROM master_data where type = 'container_size' order by id;";
                                                        $result = mysqli_query($conn, $sql);

                                                        // Loop through data and create dropdown options
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                            echo "<option value='" . $row['value'] . "'>" . $row['name'] . "</option>";
                                                        }

                                                        // Close database connection
                                                        mysqli_close($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">หมายเลขซีล</label>
                                                    <input class="form-control mb-2 mb-md-0 sealNo2" name="sealNo2" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">น้ำหนักตู้</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control containerWeight2" name="containerWeight2" autocomplete="off" />
                                                        <span class="input-group-text" id="basic-addon2">กก.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Form group-->
                    </div>
                    <!--end::Repeater-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="confirmAddNewTrip">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Set VFGM Closing Clock -->
    <div class="modal fade" id="selectTripforVGMorClosing" tabindex="-1" aria-labelledby="selectTripforVGMorClosingLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectTripforVGMorClosingLabel">เลือกทริปและตั้งค่า VGM/Closing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="selectDateTimeforVGM" class="form-label">VGM</label>
                            <input class="form-control form-control-solid" placeholder="เลือกวันเวลา" id="selectDateTimeforVGM" />
                        </div>
                        <div class="col-md-6">
                            <label for="selectDateTimeforClosing" class="form-label">Closing</label>
                            <input class="form-control form-control-solid" placeholder="เลือกวันเวลา" id="selectDateTimeforClosing" />
                        </div>
                    </div>
                    <div class="row mb-10">
                        <div class="col-md-6">
                            <div class="form-check form-check-custom form-check-solid  form-check-danger">
                                <input type="checkbox" class="form-check-input" id="cbVGMClosingNotice3Hr">
                                <label class="form-check-label" for="flexCheckDefault">
                                    แจ้งเตือนก่อน 3 ชั่วโมง
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-custom form-check-solid  form-check-danger">
                                <input type="checkbox" class="form-check-input" id="cbVGMClosingNotice6Hr" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    แจ้งเตือนก่อน 6 ชั่วโมง
                                </label>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="bg-success text-white">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">หมายเลขทริป</th>
                                <th scope="col">ชื่อคนขับ</th>
                                <th scope="col">เวลาเริ่มงาน</th>
                                <th scope="col">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody id="tripTableBodyVGMClosing">
                            <!-- เราจะแทรกข้อมูลตารางตรงนี้โดยใช้ JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmsetVGMClosing">ตั้งเวลา</button>
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

    <!--Date Picker ภาษาไทย -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>



    <!-- Drag and Drop -->
    <script src="assets/plugins/custom/draggable/draggable.bundle.js"></script>
    <script src="https://unpkg.com/sortablejs@1.14.0/Sortable.min.js"></script>

    <!-- Google Map-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-qmWmKTeZYf9ohc7WqHP_8WUsK-DjIBI&libraries=places" async defer></script>

    <!-- Repeater-->
    <script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

    <script>
        // Google Map 
        function initMap(coordinates) {
            const carAndTruckRatio = 1.0;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: coordinates[0],
                language: 'th',
            });

            var bounds = new google.maps.LatLngBounds();

            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                polylineOptions: {
                    strokeColor: 'blue',
                    strokeOpacity: 0.8,
                    strokeWeight: 8,
                },
            });

            var waypoints = coordinates.slice(1, -1).map(function(coordinate) {
                return {
                    location: coordinate,
                    stopover: true,
                };
            });

            directionsService.route({
                    origin: coordinates[0],
                    destination: coordinates[coordinates.length - 1],
                    waypoints: waypoints,
                    optimizeWaypoints: true,
                    travelMode: google.maps.TravelMode.DRIVING,
                    language: 'th',
                },
                function(response, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        directionsRenderer.setDirections(response);
                        var route = response.routes[0];
                        route.overview_path.forEach(function(coordinate) {
                            bounds.extend(coordinate);
                        });
                        map.fitBounds(bounds);

                        var totalDistance = 0;
                        var totalTime = 0;
                        var tableBody = document.getElementById("tableBody");
                        tableBody.innerHTML = '';
                        route.legs.forEach(function(leg, index) {
                            totalDistance += leg.distance.value;
                            totalTime += (leg.duration.value * carAndTruckRatio);

                            // สร้างแถวใหม่ในตาราง
                            var newRow = document.createElement('tr');
                            var travelPlanCell = document.createElement('td');
                            var distanceCell = document.createElement('td');
                            var timeCell = document.createElement('td');

                            travelPlanCell.innerHTML = coordinates[index].name.substring(3) + " <i class='fas fa-arrow-right'></i> " + coordinates[index + 1].name.substring(3);
                            distanceCell.innerHTML = (leg.distance.value / 1000).toFixed(2) + " ก.ม.";
                            //timeCell.innerHTML = (leg.duration.value / 60).toFixed(0) + " นาที";
                            if ((leg.duration.value * carAndTruckRatio) <= 3600) {
                                timeCell.innerHTML = ((leg.duration.value * carAndTruckRatio) / 60).toFixed(0) + " นาที";
                            } else {
                                timeCell.innerHTML = Math.floor((leg.duration.value * carAndTruckRatio) / 3600) + " ชั่วโมง " + Math.floor(((leg.duration.value * carAndTruckRatio) % 3600) / 60) + " นาที";
                            }

                            newRow.appendChild(travelPlanCell);
                            newRow.appendChild(distanceCell);
                            newRow.appendChild(timeCell);

                            tableBody.appendChild(newRow);
                        });

                        // แสดงระยะทางและเวลาทั้งหมด
                        var distanceElement = document.getElementById('totalDistance');
                        var timeElement = document.getElementById('totalTime');
                        distanceElement.innerHTML = (totalDistance / 1000).toFixed(2) + ' ก.ม.';
                        //timeElement.innerHTML = (totalTime / 60).toFixed(0) + ' นาที';
                        if (totalTime >= 3600) {
                            timeElement.innerHTML = Math.floor(totalTime / 3600) + ' ชั่วโมง ' + Math.floor((totalTime % 3600) / 60) + ' นาที';
                        } else {
                            timeElement.innerHTML = Math.floor(totalTime / 60) + ' นาที';
                        }

                        // สร้างหมุดของแต่ละจุดในเส้นทาง
                        coordinates.forEach(function(coordinate) {
                            var marker = new google.maps.Marker({
                                position: {
                                    lat: coordinate.lat,
                                    lng: coordinate.lng
                                },
                                map: map,
                                title: coordinate.name,
                                // เพิ่ม option สำหรับภาษาไทยและแก้ไข font และเพิ่ม inline style สำหรับสีพื้นหลังและขอบ


                            });

                            // สร้าง InfoWindow สำหรับแต่ละหมุด
                            var infoWindow = new google.maps.InfoWindow({
                                content: coordinate.name,
                            });



                            // แสดง InfoWindow เมื่อคลิกที่หมุด
                            marker.addListener('click', function() {
                                infoWindow.open(map, marker);
                            });
                        });
                    } else {
                        window.alert("Directions request failed due to " + status);
                    }
                }
            );
        }
    </script>


    <script defer>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {

            //$('#loading-spinner').show();

            // Set Moment 
            moment.locale('th');

            // Load Data from Paramitor 
            const urlParams = new URLSearchParams(window.location.search);
            const MAIN_job_id = urlParams.get('job_id');
            let MAIN_job_no = "";
            //var LOAD_PROCESS_COUNT = 0;

            //alert(MAIN_job_id);

            // Main data from dran and drop
            let MAIN_DATA = [];
            var TEMP_MAIN_DATA = {};
            let swappable = null;
            let JobCodeTEXT = "";
            let generateJobCodeFlg = false;
            let tempGooglrMapRoute = [];
            let targetTrip_id = "";
            let MAIN_LINE_MSG = "";
            let MAIN_LINE_CUS = "";
            let MAIN_LINE_CLI = "";
            let EditLocation_ID = "";
            let EDITjob_characteristic = "";
            let EDITjob_SEQ = "";

            let MAIN_JobName = "";
            let MAIN_JobselectID = "";
            let MAIN_jobType = "";
            let trigerChangeJobName = false;

            let selectImageforSendArray = [];
            let allTrip_data = [];

            let isClientConfirmed = false;
            let subContractJob = [];

            let CURRENT_JOB_STATUS = "";


            // Set Initial Select 2
            //ClientID
            $('#ClientID').select2({
                placeholder: 'เลือกผู้ว่าจ้าง'
            });

            //job_name
            $('#job_name').select2({
                placeholder: 'เลือกประเภทงาน'
            });

            //customer_id
            $('#customerID').select2({
                placeholder: 'เลือกลูกค้า'
            });

            // job_date
            var job_date_picker = $("#job_date").flatpickr({
                dateFormat: "Y-m-d",
                locale: "th",
                altInput: true,
                altFormat: "j M Y",
                thaiBuddhist: true,
                defaultDate: "today" // ใส่ค่า "today" เพื่อให้เป็นวันนี้เป็นค่าเริ่มต้น
            });



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
                        if (name == "ClientID") {
                            var selectedOption = $(this).find(":selected");
                            var clientName = selectedOption.text();
                            data.client_name = clientName;
                        }
                        if (name == "customerID") {
                            var selectedOption = $(this).find(":selected");
                            var customerName = selectedOption.text();
                            data.customer_name = customerName;
                        }
                    }
                });
                return data;
            }

            function generateRandomString(length) {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }




            function loadJobdata() {
                var ajaxData = {};
                ajaxData['f'] = '2';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        //var jobHeaderForm = document.querySelector('#jobHeaderForm');
                        //var jobHeaderMainForm = document.querySelector('#jobHeaderMainForm');

                        var jobHeaderForm = data_arr.jobHeader[0];
                        $('#job_name').val(jobHeaderForm.job_name).trigger('change');
                        $('#ClientID').val(jobHeaderForm.ClientID).trigger('change');
                        $('#customerID').val(jobHeaderForm.customer_id).trigger('change');
                        // Set the values of the form inputs using jQuery
                        //$('#job_name').val(jobHeaderForm.job_name);
                        //$('#ClientID').val(jobHeaderForm.ClientID);
                        $('#job_type').val(jobHeaderForm.job_type);



                        $('#main_book_no').val(jobHeaderForm.main_book_no);
                        $('#main_no').val(jobHeaderForm.main_book_no);
                        $('#job_no').val(jobHeaderForm.job_no);
                        MAIN_job_no = jobHeaderForm.job_no;
                        //console.log(jobHeaderForm.job_date);
                        //$('#job_date').val(jobHeaderForm.job_date);
                        job_date_picker.setDate(jobHeaderForm.job_date);

                        // ใส่ข้อมูลลงใน input element โดยใช้คำสั่ง .val()
                        $("#customer_job_no").val(jobHeaderForm.customer_job_no);
                        $("#booking").val(jobHeaderForm.booking);
                        $("#customer_po_no").val(jobHeaderForm.customer_po_no);
                        $("#bill_of_lading").val(jobHeaderForm.bill_of_lading);
                        $("#customer_invoice_no").val(jobHeaderForm.customer_invoice_no);
                        $("#agent").val(jobHeaderForm.agent);
                        $("#goods").val(jobHeaderForm.goods);
                        $("#quantity").val(jobHeaderForm.quantity);
                        $("#remark").val(jobHeaderForm.remark);

                        MAIN_LINE_CUS = jobHeaderForm.CsutomerLine;
                        MAIN_LINE_CLI = jobHeaderForm.ClientLine;

                        var jobDetailTrips = data_arr.JobDetailTrip;
                        //console.log(jobDetailTrips);
                        targetTrip_id = jobDetailTrips[0].id;
                        // สร้างตาราง
                        /*
                        var tripTable = $('#tripTable').DataTable({
                            data: jobDetailTrips,
                            columns: [{
                                    data: "tripNo",
                                    className: "trip-link"
                                },
                                {
                                    data: "truck_licenseNo"
                                },
                                {
                                    data: "driver_name"
                                },
                                {
                                    data: "container_show"
                                },
                                {
                                    data: "status",
                                    render: function(data, type, row) {
                                        var statusBadgeClass = "";
                                        var statusText = "";

                                        switch (data) {
                                            case "รับตู้หนัก : เข้าสถานที่แล้ว":
                                            case "รับตู้เปล่า : เข้าสถานที่แล้ว":
                                            case "คืนตู้หนัก : เข้าสถานที่แล้ว":
                                            case "คืนตู้เปล่า : เข้าสถานที่แล้ว":
                                            case "ส่งสินค้า : เข้าสถานที่แล้ว":
                                            case "รับสินค้า : เข้าสถานที่แล้ว":
                                            case "อื่นๆ : เข้าสถานที่แล้ว":
                                                statusBadgeClass = "badge badge-primary";
                                                break;
                                            case "รับตู้หนัก : กำลังดำเนินการ":
                                            case "รับตู้เปล่า : กำลังดำเนินการ":
                                            case "คืนตู้หนัก : กำลังดำเนินการ":
                                            case "คืนตู้เปล่า : เริ่มดำเนินการ":
                                            case "ส่งสินค้า : กำลังดำเนินการ":
                                            case "รับสินค้า : กำลังดำเนินการ":
                                            case "อื่นๆ : เริ่มดำเนินการ":
                                                statusBadgeClass = "badge badge-warning";
                                                break;
                                            case "รับตู้หนัก : ดำเนินการเสร็จ":
                                            case "รับตู้เปล่า : ดำเนินการเสร็จ":
                                            case "คืนตู้หนัก : ดำเนินการเสร็จ":
                                            case "คืนตู้เปล่า : ดำเนินการเสร็จ":
                                            case "ส่งสินค้า : ดำเนินการเสร็จแล้ว":
                                            case "รับสินค้า : ดำเนินการเสร็จ":
                                            case "อื่นๆ : ดำเนินการเสร็จ":
                                                statusBadgeClass = "badge badge-info";
                                                break;
                                            case "รับตู้หนัก : ออกจากสถานที่แล้ว":
                                            case "รับตู้เปล่า : ออกจากสถานที่แล้ว":
                                            case "คืนตู้หนัก : ออกจากสถานที่แล้ว":
                                            case "คืนตู้เปล่า : ออกจากสถานที่แล้ว":
                                            case "ส่งสินค้า : ออกจากสถานที่แล้ว":
                                            case "รับสินค้า : ออกจากสถานที่แล้ว":
                                            case "อื่นๆ : ออกจากสถานที่แล้ว":
                                                statusBadgeClass = "badge badge-secondary";
                                                break;
                                            case "เจ้าหน้าที่ยืนยันแล้ว":
                                            case "คนขับยืนยันแล้ว":
                                            case "ยืนยันเริ่มงานแล้ว":
                                            case "คนขับยืนยันจบงานแล้ว":
                                            case "จบงาน":
                                                statusBadgeClass = "badge badge-success";
                                                break;
                                            default:
                                                statusBadgeClass = "badge badge-danger";
                                                break;
                                        }
                                        return '<span class="' + statusBadgeClass + '">' + data + '</span>';
                                    }
                                }
                            ],
                            paging: false,
                            searching: false,
                            info: false
                        });

                        // ดักเหตุการณ์คลิกที่ตาราง
                        $('#tripTable tbody').on('click', '.trip-link', function() {
                            // ดึงข้อมูลของแถวนั้น ๆ จากตาราง DataTable
                            var data = tripTable.row($(this).closest('tr')).data();
                            // สร้าง URL สำหรับเปิดหน้าใหม่โดยใช้ id ของ JobDetailTrip
                            var url = '103_tripDetail.php?job_id=' + MAIN_job_id + '&trip_id=' + data.id;
                            // เปิดหน้าต่างใหม่
                            window.open(url);
                        });
                        */
                        //jobStatusText
                        var jobHeader = data_arr.jobHeader[0];
                        var statusText = jobHeader.status === 'Draft' ? 'รอการยืนยัน' : jobHeader.status;
                        $('#jobStatusText').text(statusText);

                        var jobStatusText = $('#jobStatusText');

                        // เปลี่ยนสีตัวหนังสือตามสถานะ
                        if (statusText === 'รอการยืนยัน') {
                            jobStatusText.addClass('text-info');
                        } else if (statusText === 'กำลังดำเนินการ') {
                            jobStatusText.addClass('text-primary');
                        } else if (statusText === 'เสร็จสิ้น') {
                            jobStatusText.addClass('text-success');
                        }
                        if (statusText === 'ยกเลิก') {
                            jobStatusText.addClass('text-danger');
                        }
                        if (jobHeader.status === 'Draft') {
                            $('#confirmJob').removeClass('d-none');
                            $('#cancelJob').removeClass('d-none');
                            $('#confirmJobGroup').removeClass('d-none');

                            if (jobHeader.client_confirmed != "1") {
                                $('#confirmClient').removeClass('d-none');
                                // เลือกปุ่ม confirmClient จาก ID
                                var confirmClientBtn = $("#confirmClient");
                                // ตรวจสอบค่าตัวแปร MAIN_LINE_CLI และ MAIN_LINE_CUS
                                //cousole.log(MAIN_LINE_CLI === "" || MAIN_LINE_CUS === "")
                                if (MAIN_LINE_CLI === "" && MAIN_LINE_CUS === "") {
                                    // ปิดใช้งานปุ่ม confirmClient
                                    confirmClientBtn.prop("disabled", true);
                                    isClientConfirmed = true;
                                    // เพิ่ม Tooltip และเมื่อนำเมาส์ไปชี้ที่ปุ่ม ให้แสดงข้อความ
                                    confirmClientBtn.attr("data-bs-toggle", "tooltip");
                                    confirmClientBtn.attr("data-bs-placement", "top");
                                    confirmClientBtn.attr("title", "ยังไม่มีข้อมูลของ Line ของลูกค้าและผู้ว่าจ้าง");

                                    // ให้กำหนด Tooltip ให้ทำงาน
                                    confirmClientBtn.tooltip();
                                }
                            } else {
                                isClientConfirmed = true;
                            }


                        }

                        //sub_confirmed
                        //confirmsubContract

                        CURRENT_JOB_STATUS = jobHeader.status;
                        if (jobHeader.status === 'ยกเลิก') {
                            // Disable cancelJob button
                            $('#cancelJob').prop('disabled', true);

                            // Disable addFileBtn button
                            $('#addFileBtn').prop('disabled', true);

                            // Disable saveDatabtn button
                            $('#saveDatabtn').prop('disabled', true);

                            Swal.fire({
                                title: 'ใบงานนี้ถูกยกเลิกแล้ว',
                                icon: 'warning',
                                confirmButtonText: 'ตกลง'
                            });
                        }

                        // Generate Line Msg to customer/Client ====================================

                        var tripDetails = data_arr.JobDetailTrip; // ดึงข้อมูล JobDetailTrip จาก Object
                        var tripText = "\n";
                        $.each(tripDetails, function(index, trip) {
                            var tripNumber = trip.tripSeq;
                            var driverName = trip.driver_name;
                            var driverPhone = trip.Driver_Phone_no;
                            var licenseNo = trip.truck_licenseNo;
                            var containerID = trip.containerID;
                            var sealNo = trip.seal_no;
                            var containerWeight = trip.containerWeight;
                            var status = trip.status;

                            tripText += "\nทริปที่ " + tripNumber + " ";
                            tripText += "พขร. " + driverName + "\n";
                            tripText += "เบอร์โทร " + driverPhone + "\n";
                            tripText += "ทะเบียน " + licenseNo + "\n";

                            // เพิ่มเงื่อนไขเช็คค่าข้อมูลก่อนการสร้างข้อความ
                            if (containerID !== "" && containerID !== undefined) {
                                tripText += "เบอร์ตู้ " + containerID + "\n";
                            }

                            if (sealNo !== "" && sealNo !== undefined) {
                                tripText += "เบอร์ซีล " + sealNo + "\n";
                            }

                            if (containerWeight !== "" && containerWeight !== undefined && containerWeight !== "0.00") {
                                tripText += "น้ำหนักตู้ " + containerWeight + "\n";
                            }

                            if (trip.CURRENT_MAIN_ORDER == '3') {
                                switch (trip.CURRENT_MINOR_ORDER) {
                                    case '1':
                                        status = 'ถึง' + trip.CURRENT_LOCATION_NAME + ' แล้ว' + 'รอ' + trip.NEXT_ACTION
                                        break;
                                    case '3':
                                        status = 'กำลัง' + trip.CURRENT_ACTION + 'ที่' + trip.CURRENT_LOCATION_NAME
                                        break;
                                    case '7':
                                        status = trip.CURRENT_ACTION + 'เสร็จแล้วรอออกจาก' + trip.CURRENT_LOCATION_NAME
                                        break;
                                    case '9':
                                        if (trip.NEXT_MAIN_ORDER == '3') {
                                            status = 'กำลังเดินทางไป' + trip.NEXT_ACTION + 'ที่ ' + trip.NEXT_LOCATION_NAME
                                        } else {
                                            status = trip.CURRENT_ACTION + "เสร็จแล้ว";
                                        }
                                        break;

                                }
                            }
                            if ((trip.CURRENT_MAIN_ORDER == '1') && (trip.CURRENT_MINOR_ORDER == '5')) {
                                status = 'กำลังเดินทางไป' + trip.NEXT_ACTION + 'ที่ ' + trip.NEXT_LOCATION_NAME
                            }

                            tripText += "สถานะ " + status + "\n";

                            //console.log(tripText); // แสดงข้อความในคอนโซล
                            // หรือสามารถนำข้อความไปแสดงในส่วนอื่นของเว็บไซต์ได้ตามต้องการ
                        });
                        MAIN_LINE_MSG = "";
                        MAIN_LINE_MSG += "วันที่ " + jobHeaderForm.job_date;
                        MAIN_LINE_MSG += "\nชื่องาน " + jobHeaderForm.job_name;
                        MAIN_LINE_MSG += "\nเลขที่อ้างอิง:\n" + jobHeaderForm.refDoc_Data;
                        MAIN_LINE_MSG += data_arr.jobActionLog;
                        MAIN_LINE_MSG += tripText;

                        //console.log(MAIN_LINE_MSG);

                        // Sub Contract Handel
                        subContractJob = data_arr.jobforSubContract;
                        if (jobHeader.sub_confirmed == null) {
                            if (subContractJob.length > 0) {
                                $("#confirmsubContract").removeClass("d-none");
                            }
                        }

                        $('#loading-spinner').hide();
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // saveDatabtn
            $('#saveDatabtn').click(function() {
                let ajaxData = formToObject($("#jobHeaderForm"));
                ajaxData['f'] = 3;
                ajaxData['job_id'] = MAIN_job_id;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';

                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {
                        //console.log(data)
                        $('#loading-spinner').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });

            $('#confirmJob').on('click', function() {
                Swal.fire({
                    title: 'ยืนยันใบงาน',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ทำงานเมื่อ user กด "ยืนยัน"
                        confirm_data();
                    }
                });
            });

            function confirm_data() {
                $('#confirmJob').prop('disabled', true);
                var ajaxData = {};
                ajaxData['f'] = '7';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {
                        //console.log(data);
                        $('#loading-spinner').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'ยืนยันแผนการดำเนินการ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            $('#confirmClient').on('click', function() {
                Swal.fire({
                    title: 'ยืนยันใบงานให้ผู้ว่าจ้าง/ลูกค้าก่อน',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ทำงานเมื่อ user กด "ยืนยัน"
                        confirm_dataOnlyClient();
                    }
                });
            });


            function confirm_dataOnlyClient() {
                $('#confirmClient').prop('disabled', true);
                var ajaxData = {};
                ajaxData['f'] = '19';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {
                        //console.log(data);
                        $('#loading-spinner').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'ยืนยันใบงานให้กับผู้จ้าง/ลูกค้า',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // Upload Process ===========================================

            var TOTAL_UPLOAD_FILE = 0;
            var CURRENT_UPLOAD_FILE = 0;
            const DOCUMENT_GROUP = "JOB";
            const DOCUMENT_GROUP_CODE = MAIN_job_id;
            const MAIN_FILE_PATH = "assets/media/uploadfile/uploadDoc/";

            // Random String 
            function randomString(length) {
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                return result;
            }

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

                            var col4 = document.createElement('td');
                            col4.classList.add('text-center');
                            //console.log(data_arr[i].created_at);
                            var created_at = moment(data_arr[i].created_at);
                            col4.innerHTML = '<span class="btn btn-icon btn-sm btn-active-color-danger pe-0 me-2 deleteAttachedImage" doc_type="' + data_arr[i].document_type + '" fileName="' + data_arr[i].originalFileName + '" rnd="' + data_arr[i].random_code + '"><i class="fa fa-trash fs-3 mb-3"></i>				</span>';
                            row.appendChild(col4);

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


            $('#cancelJobBtn').click(function() {
                Swal.fire({
                    title: "ยืนยันการยกเลิกใบงาน",
                    text: "คุณต้องการยกเลิกใบงานนี้จริงหรือไม่?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "ยืนยันยกเลิกใบงาน",
                    cancelButtonText: "ปิดหน้าต่างนี้",
                    confirmButtonColor: '#d33',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed) {
                        cancelJob();
                    }
                });
            });


            function cancelJob() {
                $('#confirmJob').prop('disabled', true);
                var ajaxData = {};
                ajaxData['f'] = '11';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {
                        //console.log(data);
                        $('#loading-spinner').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'ยกเลิกใบงานสำเร็จ',
                            text: "ใบงานถูกยกเลิกแล้ว",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('#printJob').click(function() {
                window.open(`PDF_jobCard.php?job_id=${MAIN_job_id}`, '_blank');
            });

            $("#checkMapbtn").click(function() {
                var ajaxData = {};
                ajaxData['f'] = '12';
                ajaxData['trip_id'] = targetTrip_id; // targetTrip_id
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        var data_arr = JSON.parse(retunrdata);

                        var formattedData = data_arr.map(function(item, index) {
                            var name = (index + 1) + ". " + item.location_code + " [" + item.job_characteristic + "]";
                            var lat = parseFloat(item.latitude);
                            var lng = parseFloat(item.longitude);

                            return {
                                "name": name,
                                "lat": lat,
                                "lng": lng
                            };
                        });

                        $('#showGoogleMapModal').modal('show');
                        tempGooglrMapRoute = formattedData;
                        initMap(formattedData);
                        //console.log(formattedData);
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            })

            // เมื่อคลิกปุ่ม "เปิด Google Maps"
            $("#openMapButton_2").click(function() {
                var latLngArray = tempGooglrMapRoute.map(function(coordinate) {
                    return coordinate.lat + ',' + coordinate.lng;
                });

                var googleMapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + latLngArray[latLngArray.length - 1] + '&waypoints=' + latLngArray.slice(0, -1).join('|');


                window.open(googleMapsUrl, '_blank');
            });

            $('#LineUpdateStatus').click(function() {
                selectImageforSendArray = [];
                loadImageForSelect();
                $("#LineNotificationMSG").modal('show');
                // Disabling the checkboxes if the values are empty
                if (!MAIN_LINE_CUS) {
                    $("#sendToCustomer").prop('disabled', true);
                } else {
                    $("#sendToCustomer").prop('checked', true);
                }
                if (!MAIN_LINE_CLI) {
                    $("#sendToEmployer").prop('disabled', true);
                } else {
                    $("#sendToEmployer").prop('checked', true);
                }

                $("#line_message").val(MAIN_LINE_MSG);


                /*
                Swal.fire({
                    title: "ส่งไลน์หาลูกค้า/ผู้จ้าง",
                    html: '<div class="swal2-lg"><input type="checkbox" id="customerCheckbox" ' + (MAIN_LINE_CUS == "" ? "disabled" : "checked") + '> <label for="customerCheckbox">ส่งหาลูกค้า</label></div><div class="swal2-lg"><input type="checkbox" id="clientCheckbox" ' + (MAIN_LINE_CLI == "" ? "disabled" : "checked") + '> <label for="clientCheckbox">ส่งหาผู้จ้าง</label></div><textarea id="messageTextarea" class="form-control" rows="5">' + MAIN_LINE_MSG + '</textarea>',
                    showCancelButton: true,
                    confirmButtonText: "ส่ง",
                    cancelButtonText: "ยกเลิก",
                    reverseButtons: true,
                    confirmButtonColor: "#28a745",
                    preConfirm: function() {
                        var message = $('#messageTextarea').val();
                        var customerChecked = $('#customerCheckbox').prop('checked');
                        var clientChecked = $('#clientCheckbox').prop('checked');

                        //console.log("ข้อความที่ส่งไลน์: " + message);
                        //console.log("ส่งหาลูกค้า: " + customerChecked);
                        if (customerChecked) {
                            SendLineMSG(message, MAIN_LINE_CUS, "ส่งข้อความหาลูกค้าสำเร็จ");
                        }
                        //console.log("ส่งหาผู้จ้าง: " + clientChecked);
                        if (clientChecked) {
                            SendLineMSG(message, MAIN_LINE_CLI, "ส่งข้อความหาผู้ว่าจ้างสำเร็จ");
                        }
                    }


                });
                */


            });



            function SendLineMSG(Message, LineToken, completeType) {
                var ajaxData = {};
                ajaxData['f'] = '9';
                ajaxData['line_id'] = LineToken;
                ajaxData['message'] = Message;
                ajaxData['attachedImage'] = selectImageforSendArray.join();
                //console.log(ajaxData);

                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/00_systemManagement/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        //console.log(data);
                        toastr.success(completeType);

                    })
                    .fail(function() {
                        toastr.options.positionClass = 'toast-top-right';
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });

            }


            $('#sendLineMsgBtn').click(function() {
                var line_message = $('#line_message').val(); // Read the message from the textarea
                var sendToCustomer = $('#sendToCustomer').prop('checked'); // Check if the checkbox is checked
                var sendToEmployer = $('#sendToEmployer').prop('checked'); // Check if the checkbox is checked

                // Now you can use these variables
                if (sendToCustomer) {
                    SendLineMSG(line_message, MAIN_LINE_CUS, "ส่งข้อความหาลูกค้าสำเร็จ");
                }
                //console.sendToEmployer("ส่งหาผู้จ้าง: " + clientChecked);
                if (sendToEmployer) {
                    SendLineMSG(line_message, MAIN_LINE_CLI, "ส่งข้อความหาผู้ว่าจ้างสำเร็จ");
                }
                // Close the modal
                $('#LineNotificationMSG').modal('hide');

                // Here you could make an AJAX request or do whatever you want with these variables
            });

            // END Process ===========================================


            //changeLocationbtn
            //changelocationModal

            $('body').on('change', '#location_select', function() {
                var target = $(this).val()
                var ajaxData = {};
                ajaxData['f'] = '2';
                ajaxData['location_id'] = target;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/05_jobOrderTemplate/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {

                        var data_arr = JSON.parse(data);
                        TEMP_MAIN_DATA = data_arr[0];
                        let form = $('#locationForm');
                        form.find('#location_code').val(data_arr[0].location_code);
                        form.find('#location_name').val(data_arr[0].location_name);
                        form.find('#customer_id').val(data_arr[0].customer_name);
                        form.find('#location_address').val(data_arr[0].address);
                        form.find('#map_url').val(data_arr[0].map_url);
                        form.find('#latitude').val(data_arr[0].latitude);
                        form.find('#longitude').val(data_arr[0].longitude);
                        form.find('#note').val(data_arr[0].note);
                        form.find('#location_type').val(data_arr[0].location_type);
                        if (data_arr[0].location_type == "ลูกค้า") {
                            $('#edit_customer_panel').removeClass('d-none');
                        } else {
                            $('#edit_customer_panel').addClass('d-none');
                        }


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });


            //$(".changeLocationbtn").click(function() {
            $('body').on('click', '.changeLocationbtn', function() {
                EditLocation_ID = $(this).attr('location_id');
                EDITjob_characteristic = $(this).attr('JobDESC');
                EDITjob_SEQ = $(this).attr('Job_SEQ');
                loadLocationForSelect();
                $('#changlocationModal').modal('show');
                $('#locationForm').trigger('reset');
                //$("#job_note").val(Editjob_Note);
                //loadLocationForSelect();
                TEMP_MAIN_DATA = {};
            });



            function loadLocationForSelect() {
                var ajaxData = {};
                ajaxData['f'] = '1';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/05_jobOrderTemplate/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        //console.log(retunrdata);
                        var data_arr = JSON.parse(retunrdata);
                        //console.log(data_arr);
                        var location_select = $('#location_select');
                        location_select.empty();
                        location_select.append($('< >', {
                            value: "null",
                            text: "เลือกสถานที่",
                            disabled: true, // ตั้งค่า disabled เพื่อให้ไม่สามารถเลือ
                            selected: true, // ตั้งค่า selected เพื่อให้ถูกเลือก
                        }));
                        let show_name = "";
                        $.each(data_arr, function(index, val) {
                            show_name = val.location_code + " : " + val.location_name;

                            if (val.location_type == "ลูกค้า") {
                                //show_name = val.location_code + " : " + val.customer_name + "(" + val.branch + ")" + " - " + val.location_name;
                                show_name = val.location_code + " : " + val.customer_name + (val.branch ? "(" + val.branch + ")" : "") + " - " + val.location_name;

                            }
                            location_select.append($('<option>', {
                                value: val.location_id,
                                text: show_name
                            }));
                        });
                        $('#location_select').select2({
                            placeholder: 'เลือกสถานที่',

                        });

                        if (EditLocation_ID != "") {
                            $('#location_select').val(EditLocation_ID).trigger('change');
                            $("#job_characteristic").val(EDITjob_characteristic);
                            $("#btnAddNewLocation").html("เปลี่ยน")

                        } else {
                            $("#btnAddNewLocation").html("เพิ่ม")
                        }

                        if (1) {
                            $("#job_characteristic_Panel").html(EDITjob_characteristic);
                            $("#job_characteristic_Panel").removeClass("d-none");
                            $("#job_characteristic").addClass("d-none");
                        } else {
                            $("#job_characteristic").removeClass("d-none");
                            $("#job_characteristic_Panel").addClass("d-none");
                        }




                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            //changeLocationMenuList
            function load_jobDescforSelectCgangeLocation() {
                var ajaxData = {};
                ajaxData['f'] = '22';
                ajaxData['job_id'] = MAIN_job_id; // targetTrip_id
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        var data_arr = JSON.parse(retunrdata);
                        //console.log(data_arr);
                        //changeLocationMenuList
                        // สร้างตัวแปรเก็บ HTML ของเมนู
                        var menuHTML = '';

                        // วนลูปเพื่อสร้างเมนูสำหรับแต่ละ Object ใน data_arr
                        for (var i = 0; i < data_arr.length; i++) {
                            var item = data_arr[i];
                            var jobDesc = item.JobDESC;
                            var locationId = item.location_id;
                            var plan_order = item.plan_order;

                            // เพิ่ม HTML สำหรับเมนูแต่ละรายการ
                            menuHTML += '<div class="menu-item px-3">';
                            menuHTML += '<a  class="menu-link px-3 changeLocationbtn" JobDESC="' + jobDesc + '" location_id="' + locationId + '" Job_SEQ="' + plan_order + '">';
                            menuHTML += jobDesc;
                            menuHTML += '</a>';
                            menuHTML += '</div>';
                        }


                        // เพิ่ม HTML ลงใน DOM (เช่นใส่ในตัวแปรที่มี id เป็น "menuContainer")
                        $("#changeLocationMenuList").html(menuHTML);

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // btnAddNewLocation
            $('body').on('click', '#btnAddNewLocation', function() {

                $('#addLocationModal').modal('hide');
                if (TEMP_MAIN_DATA.location_type == "ลูกค้า") {
                    //TEMP_MAIN_DATA['showName'] = TEMP_MAIN_DATA.customer_name + "(" + TEMP_MAIN_DATA.branch + ")" + " - " + TEMP_MAIN_DATA.location_name
                    TEMP_MAIN_DATA['showName'] = TEMP_MAIN_DATA.location_code + "<BR>" + TEMP_MAIN_DATA.customer_name + (TEMP_MAIN_DATA.branch ? "(" + TEMP_MAIN_DATA.branch + ")" : "") + " - " + TEMP_MAIN_DATA.location_name;
                } else {
                    TEMP_MAIN_DATA['showName'] = TEMP_MAIN_DATA.location_code + "<BR>" + TEMP_MAIN_DATA.location_name;

                }
                //TEMP_MAIN_DATA['job_characteristic'] = $("#job_characteristic").val();
                //TEMP_MAIN_DATA['job_characteristic_id'] = $("#job_characteristic").find(':selected').data("job_characteristic_id");
                TEMP_MAIN_DATA['job_note'] = $("#job_note").val();
                TEMP_MAIN_DATA['unique_key'] = generateRandomString(10);
                //TEMP_MAIN_DATA['cardColor'] = getcardColor(TEMP_MAIN_DATA.location_type);
                //TEMP_MAIN_DATA['job_characteristicShow'] = '<span class="badge ' + getBadgeColor(TEMP_MAIN_DATA.job_characteristic) + '" style="text-transform: uppercase; font-weight: bold; font-size: 1.2rem;" >' + TEMP_MAIN_DATA.job_characteristic + '</span>';

                //console.log(TEMP_MAIN_DATA);
                var ajaxData = TEMP_MAIN_DATA;
                ajaxData['f'] = '23';
                ajaxData['job_id'] = MAIN_job_id;
                ajaxData['job_no'] = MAIN_job_no;
                ajaxData['plan_order'] = EDITjob_SEQ;
                //console.log(ajaxData);

                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        //console.log(data);
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });


            });



            $('body').on('change', '#job_name', function() {
                if (trigerChangeJobName) {
                    MAIN_JobName = $(this).val();
                    MAIN_JobselectID = $("#job_name").find(":selected").attr("selectID");
                    MAIN_jobType = $("#job_name").find(":selected").attr("jobType");
                    $('#job_type').val(MAIN_jobType);


                    Swal.fire({
                        title: 'ยืนยันเปลี่ยนชื่อ Job เป็น <BR>' + MAIN_JobName,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // ทำงานเมื่อ user กด "ยืนยัน"
                            confirmedChangeJobName();
                        } else {
                            location.reload();
                        }
                    });
                }
            });

            //btnChangeJobName
            $('body').on('click', '#btnChangeJobName', function() {
                toastr.success("ปลดล๊อคเปลี่ยนชื่องานแล้ว");
                $("#job_name").prop("disabled", false);
                trigerChangeJobName = true;
            });


            function confirmedChangeJobName() {
                var ajaxData = {};
                ajaxData['f'] = '25';
                ajaxData['job_id'] = MAIN_job_id; // targetTrip_id
                ajaxData['MAIN_JobName'] = MAIN_JobName;
                ajaxData['MAIN_JobselectID'] = MAIN_JobselectID;
                ajaxData['MAIN_jobType'] = MAIN_jobType;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function loadTrip_DetailforViewIndex() {
                var ajaxData = {};
                ajaxData['f'] = '17';
                ajaxData['job_id'] = MAIN_job_id;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        allTrip_data = data_arr;
                        //console.log(allTrip_data);

                        // สร้าง div สำหรับการแสดงผลตาราง
                        var tableContainer = $('<div class="table-responsive"></div>');

                        // สร้างตาราง
                        var table = $('<table class="table table-rounded table-striped gy-4 gs-4"></table>');

                        // สร้าง thead
                        var thead = $('<thead class="bg-success text-white"></thead>');

                        // สร้างแถวของส่วนหัวของตาราง
                        var headerRow = $('<tr class="fw-semibold fs-6 border-bottom border-gray-200"></tr>');

                        // สร้างคอลัมน์ของส่วนหัวตาราง
                        var headers = ['หมายเลขทริป', 'ทะเบียนรถบรรทุก', 'ชื่อคนขับ', 'เวลาเริ่มงาน', 'หมายเลขตู้สินค้า', 'สถานะ'];
                        for (var i = 0; i < headers.length; i++) {
                            var th = $('<th></th>').text(headers[i]);
                            th.css('font-weight', 'bold'); // เพิ่มการกำหนดคุณสมบัติ font-weight
                            headerRow.append(th);
                        }

                        // เพิ่มแถวของส่วนหัวใน thead
                        thead.append(headerRow);

                        // สร้าง tbody
                        var tbody = $('<tbody></tbody>');

                        // สร้างแถวและเพิ่มข้อมูลในตาราง
                        for (var j = 0; j < data_arr.length; j++) {
                            var rowData = data_arr[j];
                            var statusBadgeClass = "";
                            var statusText = "";

                            switch (rowData.status) {
                                case "รับตู้หนัก : เข้าสถานที่แล้ว":
                                case "รับตู้เปล่า : เข้าสถานที่แล้ว":
                                case "คืนตู้หนัก : เข้าสถานที่แล้ว":
                                case "คืนตู้เปล่า : เข้าสถานที่แล้ว":
                                case "ส่งสินค้า : เข้าสถานที่แล้ว":
                                case "รับสินค้า : เข้าสถานที่แล้ว":
                                case "อื่นๆ : เข้าสถานที่แล้ว":
                                    statusBadgeClass = "badge badge-primary";
                                    break;
                                case "รับตู้หนัก : กำลังดำเนินการ":
                                case "รับตู้เปล่า : กำลังดำเนินการ":
                                case "คืนตู้หนัก : กำลังดำเนินการ":
                                case "คืนตู้เปล่า : เริ่มดำเนินการ":
                                case "ส่งสินค้า : กำลังดำเนินการ":
                                case "รับสินค้า : กำลังดำเนินการ":
                                case "อื่นๆ : เริ่มดำเนินการ":
                                    statusBadgeClass = "badge badge-warning";
                                    break;
                                case "รับตู้หนัก : ดำเนินการเสร็จ":
                                case "รับตู้เปล่า : ดำเนินการเสร็จ":
                                case "คืนตู้หนัก : ดำเนินการเสร็จ":
                                case "คืนตู้เปล่า : ดำเนินการเสร็จ":
                                case "ส่งสินค้า : ดำเนินการเสร็จแล้ว":
                                case "รับสินค้า : ดำเนินการเสร็จ":
                                case "อื่นๆ : ดำเนินการเสร็จ":
                                    statusBadgeClass = "badge badge-info";
                                    break;
                                case "รับตู้หนัก : ออกจากสถานที่แล้ว":
                                case "รับตู้เปล่า : ออกจากสถานที่แล้ว":
                                case "คืนตู้หนัก : ออกจากสถานที่แล้ว":
                                case "คืนตู้เปล่า : ออกจากสถานที่แล้ว":
                                case "ส่งสินค้า : ออกจากสถานที่แล้ว":
                                case "รับสินค้า : ออกจากสถานที่แล้ว":
                                case "อื่นๆ : ออกจากสถานที่แล้ว":
                                    statusBadgeClass = "badge badge-secondary";
                                    break;
                                case "เจ้าหน้าที่ยืนยันแล้ว":
                                case "คนขับยืนยันแล้ว":
                                case "ยืนยันเริ่มงานแล้ว":
                                case "คนขับยืนยันจบงานแล้ว":
                                case "จบงาน":
                                    statusBadgeClass = "badge badge-success";
                                    break;
                                default:
                                    statusBadgeClass = "badge badge-danger";
                                    break;
                            }
                            statusText = '<span class="' + statusBadgeClass + '">' + rowData.status + '</span>'

                            var row = $('<tr></tr>');

                            // เพิ่มข้อมูลลงในแถว
                            //Generate Closing And VGM
                            printVGMClosing = "";
                            $.each(rowData.trip_VGMClosing, function(index, object) {
                                printVGMClosing += "<BR><span class='text-danger'>" + object.alert_type +" : "+ moment(object.base_time).format("Do MMM H:mm น.") + "</span>";
                            });

                            var tripNo = $('<td></td>').html('<a href="103_tripDetail.php?job_id=' + rowData.job_id + '&trip_id=' + rowData.id + '">' + rowData.tripNo + '</a>' + printVGMClosing);
                            row.append(tripNo);


                            var truck_licenseNo = $('<td></td>').text(rowData.truck_licenseNo);
                            row.append(truck_licenseNo);

                            var driver_name = $('<td></td>').text(rowData.driver_name);
                            row.append(driver_name);

                            var jobStartDate = $('<td></td>').text(moment(rowData.jobStartDateTime).format("Do MMM H:mm น."));
                            row.append(jobStartDate);

                            var containerID = $('<td></td>').text(rowData.containerID);
                            row.append(containerID);

                            var status = $('<td></td>').html(statusText);
                            row.append(status);

                            // เพิ่มแถวลงใน tbody
                            tbody.append(row);



                            // Trip Detail ============================================================
                            var tripTimelineHTML = '<div class="track">';

                            // วนลูปผ่านรายการข้อมูลใน data_arr
                            var trip_data_arr = data_arr[j].trip_data;
                            //console.log(trip_data_arr)
                            for (var i = 0; i < trip_data_arr.length; i++) {
                                var step = trip_data_arr[i];
                                var stepDesc = step.step_desc;
                                var locationCode = step.location_code;
                                var locationName = step.location_name;
                                var completeFlag = step.complete_flag;
                                var plan_order = step.plan_order;

                                // ตรวจสอบสถานะการเสร็จสิ้นของขั้นตอน
                                var isActiveStep = completeFlag === "1";

                                var stepHTML = '<div class="step' + (isActiveStep ? ' active' : ' completeplan_order') + '" value="' + plan_order + '"  stepDesc="' + stepDesc + '" locationCode="' + locationCode + '" >';
                                stepHTML += '<span class="icon">';
                                stepHTML += getStepIcon(stepDesc, isActiveStep);
                                stepHTML += '</span>';
                                stepHTML += '<span class="text"><B>' + stepDesc + '<BR>' + locationCode + '</B></span>';
                                stepHTML += '</div>';

                                tripTimelineHTML += stepHTML;

                            }

                            tripTimelineHTML += '</div>';

                            //console.log(tripTimelineHTML);
                            row2 = $('<tr></tr>');
                            tripDetail = $('<td colspan="6"></td>').html(tripTimelineHTML);
                            row2.append(tripDetail);
                            // เพิ่มแถวลงใน tbody
                            tbody.append(row2);


                        }

                        // เพิ่ม thead และ tbody ลงในตาราง
                        table.append(thead);
                        table.append(tbody);

                        // เพิ่มตารางลงใน div สำหรับการแสดงผล
                        tableContainer.append(table);

                        // เพิ่ม div ที่มีตารางลงในหน้าเอกสาร
                        //$("#" + target_div).html(tableContainer);
                        $("#tripTable").html(tableContainer);

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // ฟังก์ชันสำหรับรับไอคอนของขั้นตอน
            function getStepIcon(stepDesc, isActiveStep) {
                var iconClass = '';
                if (isActiveStep) {
                    switch (stepDesc) {
                        case 'รับตู้หนัก':
                            iconClass = 'fas fa-truck text-white';
                            break;
                        case 'รับตู้เปล่า':
                            iconClass = 'fas fa-truck text-white';
                            break;
                        case 'คืนตู้หนัก':
                            iconClass = 'fas fa-truck text-white';
                            break;
                        case 'คืนตู้เปล่า':
                            iconClass = 'fas fa-truck text-white';
                            break;
                        case 'ส่งสินค้า':
                            iconClass = 'fas fa-shipping-fast text-white';
                            break;
                        case 'รับสินค้า':
                            iconClass = 'fas fa-box-open text-white';
                            break;
                        default:
                            iconClass = 'fas fa-question-circle text-white';
                            break;
                    }
                } else {
                    switch (stepDesc) {
                        case 'รับตู้หนัก':
                            iconClass = 'fas fa-truck text-black';
                            break;
                        case 'รับตู้เปล่า':
                            iconClass = 'fas fa-truck text-black';
                            break;
                        case 'คืนตู้หนัก':
                            iconClass = 'fas fa-truck text-black';
                            break;
                        case 'คืนตู้เปล่า':
                            iconClass = 'fas fa-truck text-black';
                            break;
                        case 'ส่งสินค้า':
                            iconClass = 'fas fa-shipping-fast text-black';
                            break;
                        case 'รับสินค้า':
                            iconClass = 'fas fa-box-open text-black';
                            break;
                        default:
                            iconClass = 'fas fa-question-circle text-black';
                            break;
                    }
                }
                return '<i class="' + iconClass + '"></i>';
            }


            function loadImageForSelect() {
                var ajaxData = {};
                ajaxData['f'] = '26';
                ajaxData['job_id'] = MAIN_job_id; // targetJobID

                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: ajaxData,
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //var divTimelineAttachedFile = $("<div>").addClass("timelineAttachedFile");
                        var currentDriverName = "";
                        var currentTripNo = "";

                        imageforSelectHTML = "<div>";

                        $.each(data_arr, function(index, val) {
                            var thumbnailPath = val.thumbnail_path;
                            var filePath = val.file_path;
                            var driverName = val.driver_name;
                            var tripNo = val.tripNo;
                            var create_date = val.create_date;

                            // ตรวจสอบเมื่อ driver_name หรือ tripNo เปลี่ยนแปลง
                            if (driverName !== currentDriverName || tripNo !== currentTripNo) {
                                if (currentDriverName != "") {
                                    imageforSelectHTML += "</div>";
                                }

                                imageforSelectHTML += "<span><h6>" + driverName + ": " + tripNo + " ส่งรูปเมื่อ " + moment(create_date).fromNow(); + "</h6></span>";
                                imageforSelectHTML += "<div class='timelineAttachedFile mb-5'>";
                                imageforSelectHTML += "<img src='" + thumbnailPath + "' class='imageforsendLine' filepath='" + filePath + "'></img>";
                                currentDriverName = driverName;
                                currentTripNo = tripNo;
                            } else {
                                imageforSelectHTML += "<img src='" + thumbnailPath + "' class='imageforsendLine' filepath='" + filePath + "'></img>";
                            }

                        });
                        imageforSelectHTML += "</div>";
                        imageforSelectHTML += "</div>";
                        $("#sekectImageforSendLine").html(imageforSelectHTML);
                    })
                    .fail(function() {
                        alert("Posting failed.");
                    });
            }


            $('body').on('click', '.imageforsendLine', function() {
                filepath = $(this).attr('filepath');
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    selectImageforSendArray = selectImageforSendArray.filter(function(item) {
                        return item !== filepath;
                    });

                } else {
                    if (selectImageforSendArray.length >= 10) {
                        toastr.warning("ส่งรูปได้สูงสุดครั้งละ 10 รูป");
                    } else {
                        $(this).addClass('selected');
                        selectImageforSendArray.push(filepath);
                    }

                }

                //console.log(selectImageforSendArray);
            });



            // confirmJobbyTrip
            $('body').on('click', '#confirmJobbyTrip', function() {
                //selectTripforconfirm
                if (isClientConfirmed) {

                    $('#selectTripforconfirm').modal('show');
                    //console.log(allTrip_data);
                    let tableRows = allTrip_data.map(generateTableRow).join("");
                    $('#tripTableBody').html(tableRows);
                } else {
                    Swal.fire({
                        title: 'กรุณายืนยันข้อมูลให้ผู้ว่าจ้างก่อน',
                        icon: 'warning',
                        confirmButtonText: 'ตกลง'
                    });
                }
            });

            // สร้างแถวตารางจากข้อมูลใน Object
            // สร้างแถวตารางจากข้อมูลใน Object
            function generateTableRow(tripData) {
                let checkboxDisabled = tripData.status !== "รอเจ้าหน้าที่ยืนยัน" ? "disabled" : "";
                if (tripData.status == "รอเจ้าหน้าที่ยืนยัน") {
                    return `
            <tr>
                <td class="text-center"><div class="form-check form-check-custom form-check-solid ms-6 me-4"><input type="checkbox" class="form-check-input" ${checkboxDisabled} value="${tripData.id}"></div></td>
                <td>${tripData.tripNo}</td>
                <td>${tripData.driver_name}</td>
                <td>${moment(tripData.jobStartDateTime).format("Do MMM H:mm น.")}</td>
                <td>${tripData.status}</td>
            </tr>
                `;
                } else {
                    return "";
                }

            }




            //btnConfirmbyTrip
            $('body').on('click', '#btnConfirmbyTrip', function() {
                let selectedTrips = [];

                // ค้นหา checkbox ที่ถูก check ใน #tripTableBody
                $('#tripTableBody input[type="checkbox"]:checked').each(function() {
                    selectedTrips.push($(this).val());
                });
                let countStatusPending = allTrip_data.filter(trip => trip.status === "รอเจ้าหน้าที่ยืนยัน").length;
                if (selectedTrips.length == 0) {
                    $('#selectTripforconfirm').modal('hide');
                } else if (countStatusPending == selectedTrips.length) {
                    $('#btnConfirmbyTrip').prop('disabled', true);
                    var ajaxData = {};
                    ajaxData['f'] = '7';
                    ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                    ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                    //console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/10_workOrder/mainFunction.php',
                            data: (ajaxData),
                            beforeSend: function() {
                                // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                                $('#loading-spinner').show();
                            },
                        })
                        .done(function(data) {
                            //console.log(data);
                            $('#loading-spinner').hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'ยืนยันแผนการดำเนินการ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                                //null
                            });
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                } else {
                    $('#btnConfirmbyTrip').prop('disabled', true);
                    var ajaxData = {};
                    ajaxData['f'] = '27';
                    ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                    ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                    ajaxData['selectTrip'] = selectedTrips.join(", ").toString();
                    //console.log(ajaxData);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/10_workOrder/mainFunction.php',
                            data: (ajaxData),
                            beforeSend: function() {
                                // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                                $('#loading-spinner').show();
                            },
                        })
                        .done(function(data) {
                            //console.log(data);
                            $('#loading-spinner').hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'ยืนยันแผนการดำเนินการ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                                //null
                            });
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }


                //alert('Trips ที่ถูกเลือก: ' + selectedTrips.join(", "));
            });

            // deleteAttachedImage
            $('body').on('click', '.deleteAttachedImage', function() {
                let doc_type = $(this).attr('doc_type');
                let fileName = $(this).attr('fileName');
                let rnd = $(this).attr('rnd')

                Swal.fire({
                    title: 'ลบไฟล์' + doc_type,
                    text: 'ต้องการลบ' + doc_type + ' (' + fileName + ') ใช่หรือไม่',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ลบ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ทำงานเมื่อ user กด "ยืนยัน"
                        //confirm_data();
                        var ajaxData = {};
                        ajaxData['f'] = '29';
                        ajaxData['random_code'] = rnd;
                        //console.log(ajaxData);
                        $.ajax({
                                type: 'POST',
                                dataType: "text",
                                url: 'function/10_workOrder/mainFunction.php',
                                data: (ajaxData),
                            })
                            .done(function(data) {
                                loadAttachedData();
                            })
                            .fail(function() {
                                // just in case posting your form failed
                                alert("Posting failed.");
                            });
                    }
                });

            });

            //selectSubcontracttoConFirm
            //
            $('body').on('click', '#confirmsubContract', function() {
                //selectSubcontracttoConFirm
                //console.log(subContractJob);
                // ใช้ Object เพื่อจัดเก็บ id ที่ปรากฏแล้ว เพื่อหลีกเลี่ยงการซ้ำซ้อน
                let seenIds = {};
                $('#checkboxContainerforSelectPartner').html("");
                if (subContractJob.length > 0) {
                    for (let i = 0; i < subContractJob.length; i++) {
                        const job = subContractJob[i];
                        const {
                            id,
                            companyName,
                            line_group_id
                        } = job;

                        if (!seenIds[id]) {
                            seenIds[id] = true;
                            disableText = "disabled";
                            checkText = "checked"
                            if (line_group_id == "") {
                                disableText = "disabled"
                                checkText = "";
                            }
                            const checkboxHtml = `
                        <div class="form-check mb-2 ms-10">
                            <input class="form-check-input" type="checkbox" value="${id}" id="checkbox-${id}" ${disableText} ${checkText}>
                            <label class="form-check-label" for="checkbox-${id}">
                                ${companyName}
                            </label>
                        </div>
                        `;

                            $('#checkboxContainerforSelectPartner').append(checkboxHtml);
                        }
                    }
                } else {
                    $('#checkboxContainerforSelectPartner').append("<h3 class='text-danger'>ไม่มีรถร่วมในใบงานนี้</h3>");
                }


                $('#selectSubcontracttoConFirm').modal('show');

            });

            function sendNotificationtoSubCar(subContractID) {
                var ajaxData = {};
                ajaxData['f'] = '30';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['subContractID'] = subContractID;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                    })
                    .done(function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ส่งไลน์ไปยังบริษัทซับแล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // confirmtoSubBtn
            $('body').on('click', '#confirmtoSubBtn', function() {
                $('#selectSubcontracttoConFirm').modal('hide');
                let checkedIds = [];

                // หา checkbox ที่ถูก check
                $("#checkboxContainerforSelectPartner input[type='checkbox']:checked").each(function() {
                    checkedIds.push($(this).val());
                });
                $.each(checkedIds, function(index, val) {
                    //console.log(val);
                    sendNotificationtoSubCar(val);
                });
            });
            // Format options
            const select2OptionFormat = (item) => {
                if (!item.id) {
                    return item.text;
                }

                var span = document.createElement('span');
                var template = '';

                template += '<div class="d-flex align-items-center">';
                //template += '<img src="' + item.element.getAttribute('driverImg') + '" class="rounded-circle h-30px me-3"/>';
                template += '<div class="d-flex flex-column">'
                template += '<span class="fs-4 fw-bold lh-1">' + item.element.getAttribute('license') + '</span>';
                template += '<span class="text-muted fs-6">' + item.element.getAttribute('province') + '</span>';
                template += '</div>';
                template += '</div>';

                span.innerHTML = template;

                return $(span);
            }

            // Format options
            const select2OptionFormatforDriver = (item) => {
                if (!item.id) {
                    return item.text;
                }

                var span = document.createElement('span');
                var template = '';

                template += '<div class="d-flex align-items-center">';
                template += '<img src="' + item.element.getAttribute('driverImg') + '" class="rounded-circle h-30px me-3"/>';
                template += '<div class="d-flex flex-column">'
                template += '<span class="fs-4 fw-bold lh-1">' + item.element.getAttribute('driverName') + '</span>';
                //template += '<span class="text-muted fs-6">' + item.element.getAttribute('province') + '</span>';
                template += '</div>';
                template += '</div>';

                span.innerHTML = template;

                return $(span);
            }
            let dropdownTruckAddNewTrip = $('.truckinJob').select2({
                placeholder: 'เลือกรถบรรทุก',
                templateResult: select2OptionFormat, // ใช้ function formatResult แสดงรูปภาพ
                templateSelection: select2OptionFormat, // ใช้ function formatSelection เพื่อแสดงชื่อและ driver_id เมื่อเลือก
                dropdownParent: $("#modalAddnewTrip"),
            });

            let dropdownDriverAddNewTrip = $('.truckDriver').select2({
                placeholder: 'เลือกคนขับ',
                templateResult: select2OptionFormatforDriver, // ใช้ function formatResult แสดงรูปภาพ
                templateSelection: select2OptionFormatforDriver, // ใช้ function formatSelection เพื่อแสดงชื่อและ driver_id เมื่อเลือก
                dropdownParent: $("#modalAddnewTrip"),
            });
            //addtripBtn
            $('body').on('click', '#addtripBtn', function() {
                // modalAddnewTrip
                //console.log(CURRENT_JOB_STATUS)
                if (CURRENT_JOB_STATUS == "กำลังดำเนินการ") {
                    $('.truckinJob').val('61').trigger('change'); // Force to select S-One
                    $('.truckDriver').val('60').trigger('change'); // Force to select S-One
                    // การ Disable dropdown สำหรับรถบรรทุก
                    $('.truckinJob').prop('disabled', true);
                    // อัพเดท Select2 เพื่อให้แสดงการเปลี่ยนแปลง
                    $('.truckinJob').select2();

                    // การ Disable dropdown สำหรับคนขับ
                    $('.truckDriver').prop('disabled', true);
                    // อัพเดท Select2 เพื่อให้แสดงการเปลี่ยนแปลง
                    $('.truckDriver').select2();

                    $("#showInaddTripIfalreadyProcess").removeClass("d-none");

                }

                $('#modalAddnewTrip').modal('show');

            });



            $('body').on('change', '.truckDriver', function() {
                var driver_type = $(this).find(':selected').data('driver_type');

                if (typeof driver_type !== 'undefined') {
                    if (driver_type === "ซับ คอนแทรค") {
                        $('.subcontrackCheckbox').prop('checked', true);

                    } else {
                        $('.subcontrackCheckbox').prop('checked', false);
                    }
                }
            });

            $('body').on('change', '.truckinJob', function() {
                var driver_id = $(this).find(':selected').data('driver_id');
                $('.truckDriver').val(driver_id).trigger('change');
            });

            $('.jobStartDateTime').flatpickr({
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                time_24hr: true,
                locale: "th",
                altInput: true,
                altFormat: "j M y เวลา H:i",
                thaiBuddhist: true,
            });

            $('body').on('change', '.jobStartDateTime', function() {
                var firstDate_time = $('#DriverList').find('.jobStartDateTime:first').val();
                var currentDate = moment(); // ได้เวลาปัจจุบัน
                var firstDate = moment(firstDate_time, "YYYY-MM-DD HH:mm");
                if (currentDate.isAfter(firstDate)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เวลาเข้างานเลยมาแล้ว',
                        text: 'คุณเลือกวันที่และเวลาที่เลยมาแล้ว กรุณาตรวจสอบความถูกต้อง',

                    });
                    workOrder_Jobdate.setDate(now());
                }

            });

            // confirmAddNewTrip
            $('body').on('click', '#confirmAddNewTrip', function() {
                var ajaxData = {
                    'truckinJob': $('.truckinJob').val(),
                    'truck_licenseNo': $('.truckinJob').find(":selected").text(),
                    'truckDriver': $('.truckDriver').val(),
                    'truckDriverName': $('.truckDriver').find(":selected").text(),
                    'truckType': $('.truckType').val(),
                    'jobStartDateTime': $('.jobStartDateTime').val(),
                    'subcontrackCheckbox': $('.subcontrackCheckbox').prop('checked') ? '1' : '0',
                    'containerID': $('.containerID').val(),
                    'containersize': $('.containersize').val(),
                    'sealNo': $('.sealNo').val(),
                    'containerWeight': $('.containerWeight').val(),
                    'containerID2': $('.containerID2').val(),
                    'containersize2': $('.containersize2').val(),
                    'sealNo2': $('.sealNo2').val(),
                    'containerWeight2': $('.containerWeight2').val(),
                    // เพิ่มฟิลด์อื่นๆ ที่คุณต้องการจัดเก็บ
                };

                //console.log(ajaxData);
                ajaxData['f'] = '31';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                    })
                    .done(function(data) {
                        console.log(data);

                        Swal.fire({
                            icon: 'success',
                            title: 'เพิ่มทริปใหม่สำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });

            function generateTableRowforVGMClosing(tripData) {
                let checkboxDisabled = "";
                return `
            <tr>
                <td class="text-center"><div class="form-check form-check-custom form-check-solid ms-6 me-4"><input type="checkbox" class="form-check-input" checked value="${tripData.id}"></div></td>
                <td>${tripData.tripNo}</td>
                <td>${tripData.driver_name}</td>
                <td>${moment(tripData.jobStartDateTime).format("Do MMM H:mm น.")}</td>
                <td>${tripData.status}</td>
            </tr>
                `;
            }

            //setVGMClosing
            $('#setVGMClosingbtn').on('click', function() {
                let tableRows = allTrip_data.map(generateTableRowforVGMClosing).join("");
                $('#tripTableBodyVGMClosing').html(tableRows);
                $('#selectTripforVGMorClosing').modal('show');
            });

            //selectDateTimeforVGMClosing
            $("#selectDateTimeforVGM").flatpickr({
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                locale: "th",
                altInput: true,
                altFormat: "j M y เวลา H:i น.",
                thaiBuddhist: true,
            });

            $("#selectDateTimeforClosing").flatpickr({
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                locale: "th",
                altInput: true,
                altFormat: "j M y เวลา H:i น.",
                thaiBuddhist: true,
            });

            //btnConfirmsetVGMClosing
            $('#btnConfirmsetVGMClosing').on('click', function() {
                let selectedTrips = [];

                // ค้นหา checkbox ที่ถูก check ใน #tripTableBody
                $('#tripTableBodyVGMClosing input[type="checkbox"]:checked').each(function() {
                    selectedTrips.push($(this).val());
                });
                var ajaxData = {
                    'DateTimeforVGM': $('#selectDateTimeforVGM').val(),
                    'DateTimeforClosing': $('#selectDateTimeforClosing').val(),
                    'cbVGMClosingNotice3Hr': $('#cbVGMClosingNotice3Hr').prop('checked') ? '1' : '0',
                    'cbVGMClosingNotice6Hr': $('#cbVGMClosingNotice6Hr').prop('checked') ? '1' : '0',
                    'SelectTrip': selectedTrips,
                    'MAIN_JOB_ID': MAIN_job_id,
                    'update_user': '<?php echo $MAIN_USER_DATA->name; ?>'
                };
                ajaxData['f'] = '32';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                    })
                    .done(function(data) {
                        //console.log(data);
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'ตั้งค่าสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                            //null
                        });
                        

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });







            // Load Data from Initail page load =======
            //loadJobTemplateDatafromJobTemplateID();
            loadJobdata();
            loadTrip_DetailforViewIndex();
            loadAttachedData();
            load_jobDescforSelectCgangeLocation();


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>