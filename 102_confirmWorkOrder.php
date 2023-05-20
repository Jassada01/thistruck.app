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
                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="printJob"><i class="fa fa-file-pdf-o"></i>Export ใบงานเป็น PDF</button>
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
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-3 col-form-label text-end-pc">สถานะ</label>
                                                        <label id="jobStatusText" class="col-sm-3 col-form-label text-left fs-1"></label>
                                                        <label class="col-sm-3 col-form-label text-end-pc"></label>
                                                        <div class="col-sm-3  d-flex justify-content-between">
                                                            <button type="button" class="btn btn-primary d-none" id="confirmJob">
                                                                <i class="fas fa-check"></i> ยืนยันใบงาน
                                                            </button>

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
                                                                $sql = "SELECT * FROM job_order_template_header WHERE active = 1";
                                                                $result = mysqli_query($conn, $sql);

                                                                // Loop through data and create dropdown options
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo "<option value='" . $row['job_name']  . "' selectID='" . $row['id'] . "'>" . $row['job_name'] . "</option>";
                                                                }

                                                                // Close database connection
                                                                mysqli_close($conn);
                                                                ?>
                                                            </select>
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
                                                        <label for="remark" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ</label>
                                                        <div class="col-sm-6">
                                                            <textarea class="form-control" id="remark" name="remark"></textarea>
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
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack px-3" id="checkMapbtn">ตรวจสอบเส้นทาง</a>
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

                        var jobDetailTrips = data_arr.JobDetailTrip;
                        //console.log(jobDetailTrips);
                        targetTrip_id = jobDetailTrips[0].id;
                        // สร้างตาราง
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

                        }

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
                console.log(ajaxData);
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


            // END Process ===========================================



            // Load Data from Initail page load =======
            //loadJobTemplateDatafromJobTemplateID();
            loadJobdata();
            loadAttachedData();


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>