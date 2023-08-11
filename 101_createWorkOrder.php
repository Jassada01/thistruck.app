<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>ใบงาน > สร้างใบงาน</title>
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
                                        <a href="050_JobOrderTemplateIndex.php" class="text-muted text-hover-primary">รายการใบงาน</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>

                                    <li class="breadcrumb-item text-dark">สร้างใบงาน</li>
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
                                                            <input type="date" class="form-control" id="job_date" name="job_date">
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
                                                            <select class="form-control" id="job_name" name="job_name">
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

                                                            <select class="form-control" id="ClientID" name="ClientID">
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

                                                            <select class="form-control" id="customerID" name="customerID">
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
                                                            <select class="form-control required" id="job_type" name="job_type" required>
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
                                                            <input type="text" class="form-control" id="customer_job_no" name="customer_job_no" autocomplete="off">
                                                        </div>
                                                        <label for="booking" class="col-sm-3 col-form-label text-end-pc">Booking (บุ๊กกิ้ง)</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="booking" name="booking" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="customer_po_no" class="col-sm-3 col-form-label text-end-pc">PO No.</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="customer_po_no" name="customer_po_no" autocomplete="off">
                                                        </div>
                                                        <label for="bill_of_lading" class="col-sm-3 col-form-label text-end-pc">B/L(ใบขน)</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="bill_of_lading" name="bill_of_lading" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="customer_invoice_no" class="col-sm-3 col-form-label text-end-pc">Invoice No.</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="customer_invoice_no" name="customer_invoice_no" autocomplete="off">
                                                        </div>
                                                        <label for="agent" class="col-sm-3 col-form-label text-end-pc">Agent(เอเย่นต์)</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="agent" name="agent" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="goods" class="col-sm-3 col-form-label text-end-pc">ชื่อสินค้า</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="goods" name="goods" autocomplete="off">
                                                        </div>
                                                        <label for="quantity" class="col-sm-3 col-form-label text-end-pc">QTY/No. of Package</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="quantity" name="quantity" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="remark" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ</label>
                                                        <div class="col-sm-6">
                                                            <textarea class="form-control" id="remark" name="remark" autocomplete="off"></textarea>
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

                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-truck fs-3"></i> รถบรรทุก</h1>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Repeater-->
                                        <div id="DriverList">
                                            <!--begin::Form group-->
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
                                                            <div class="col-md-1">
                                                                <a href="javascript:;" data-repeater-delete class="btn btn-active-light-danger mt-3 mt-md-8">
                                                                    <i class="fas fa-trash fs-5"></i>
                                                                    ลบ
                                                                </a>
                                                            </div>

                                                        </div>
                                                        <div class="separator my-10"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Form group-->

                                            <!--begin::Form group-->
                                            <div class="form-group mt-5">
                                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                    <i class="ki-duotone ki-plus fs-3"></i>
                                                    เพิ่มรถ
                                                </a>
                                            </div>
                                            <!--end::Form group-->
                                        </div>
                                        <!--end::Repeater-->
                                    </div>
                                </div>

                                <!-- จบ Card -->
                                <!-- เริ่ม Card สถานที่ -->
                                <div class="card">
                                    <div class="card-header mt-3">
                                        <div class=" col-sm-6 mt-3">
                                            <h1><i class="fas fa-route fa-1x"></i> แผนการเดินทางและค่าใช้จ่าย</h1>
                                        </div>
                                        <div class="col-sm-6 mt-3 text-end">
                                            <!-- ปุ่มเพิ่มสถานที่ -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                                                <i class="fas fa-plus"></i> เพิ่มสถานที่ในเส้นทาง
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Col-->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!--begin::Card-->
                                                <div class="card card-bordered">
                                                    <!--begin::Card header-->
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <h3 class="card-label" id="jobNamePanel"></h3>
                                                        </div>

                                                        <button type="button" class="btn btn-sm btn-floating d-none" id="btnGoogleRoute" data-bs-toggle="modal" data-bs-target="#showGoogleMapModal">
                                                            <i class="fas fa-route"></i> ตรวจสอบแผนการเดินทาง
                                                        </button>
                                                    </div>
                                                    <!--end::Card header-->

                                                    <!--begin::Card body-->
                                                    <div class="card-body">
                                                        <!--begin::Row-->
                                                        <div class="row row-cols-1 g-10">
                                                            <div class="col text-center">
                                                                <span class="badge badge-primary fs-5">
                                                                    เริ่มงาน
                                                                </span>
                                                                </BR>
                                                                <i class="fas fa-arrow-down fa-5x" style="color: #EFEFEF;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="row row-cols-1 g-10 min-h-100px draggable-zone" id="dragandDropZone">
                                                        </div>
                                                        <div class="row row-cols-1 g-10">
                                                            <div class="col text-center">
                                                                <span class="badge badge-success fs-5">
                                                                    จบงาน
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                                <!--end::Card-->
                                            </div>
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <div class="card card-bordered">
                                                    <!--begin::Card header-->
                                                    <div class="card-header">
                                                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" data-bs-toggle="tab" href="#relateCostTab">ค่าใช้จ่ายที่เกี่ยวข้อง</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#issueInvoiceAddressTab">ที่อยู่ออกใบเสร็จ</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!--end::Card header-->

                                                    <!--begin::Card body-->
                                                    <div class="card-body">
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="relateCostTab" role="tabpanel">
                                                                <!--begin::Row-->
                                                                <div class="row row-cols-1 g-10">
                                                                    <form id="jobDetailCostForm">
                                                                        <div class="row mb-3">
                                                                            <label for="hire_price" class="col-sm-5 col-form-label  text-end-pc">ราคางาน</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="hire_price" name="hire_price" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="overtime_fee" class="col-sm-5 col-form-label  text-end-pc">ค่าล่วงเวลา</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="overtime_fee" name="overtime_fee" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="port_charge" class="col-sm-5 col-form-label  text-end-pc">ค่าผ่านท่า</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="port_charge" name="port_charge" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="yard_charge" class="col-sm-5 col-form-label  text-end-pc">ค่าผ่านลาน</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="yard_charge" name="yard_charge" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="container_return" class="col-sm-5 col-form-label  text-end-pc">ค่ารับตู้/คืนตู้</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="container_return" name="container_return" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="container_cleaning_repair" class="col-sm-5 col-form-label  text-end-pc">ค่าซ่อมตู้</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="container_cleaning_repair" name="container_cleaning_repair" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="container_drop_lift" class="col-sm-5 col-form-label  text-end-pc">ค่าล้างตู้</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="container_drop_lift" name="container_drop_lift" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="expenses_1" class="col-sm-5 col-form-label  text-end-pc">ค่าชอร์(SHORE)</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="expenses_1" name="expenses_1" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="other_charge" class="col-sm-5 col-form-label  text-end-pc">ค่าใช้จ่ายอื่นๆ</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="other_charge" name="other_charge" required>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="remark" class="col-sm-5 col-form-label  text-end-pc"></label>
                                                                            <div class="col-sm-7">
                                                                                <textarea type="text" row='2' class="form-control" id="remark" name="remark" placeholder="กรุณาระบุกรณีมีค่าใช้จ่ายอื่นๆ"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="deduction_note" class="col-sm-5 col-form-label  text-end-pc">ใบหัก ณ ที่จ่ายกระทำแทน</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="deduction_note" name="deduction_note" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3 d-none">
                                                                            <label for="total_expenses" class="col-sm-5 col-form-label  text-end-pc">รวมค่าใช้จ่าย</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="total_expenses" name="total_expenses" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="totalCostPanel" class="col-sm-5 col-form-label text-end-pc">รวมค่าใช้จ่าย</label>
                                                                            <div class="col-sm-7  d-flex align-items-center">
                                                                                <span class="text-success  fw-bolder fs-1 mb-1" id="totalCostPanel">- บาท</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="wage_travel_cost" class="col-sm-5 col-form-label  text-end-pc">ค่าเดินทาง/ค่าเที่ยว</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="wage_travel_cost" name="wage_travel_cost" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="vehicle_expenses" class="col-sm-5 col-form-label  text-end-pc">ค่าใช้จ่ายรถ</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number" step="0.01" class="form-control" id="vehicle_expenses" name="vehicle_expenses" required>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <!--end::Row-->
                                                            </div>
                                                            <div class="tab-pane fade" id="issueInvoiceAddressTab" role="tabpanel">
                                                                <!--begin::Row-->
                                                                <div class="row row-cols-1 g-10">
                                                                    <form id="jobDetailinvAddForm">
                                                                        <div class="row mb-3">
                                                                            <label for="insInvAdd1" class="col-sm-3 col-form-label  text-end-pc">ที่อยู่ออกใบเสร็จ 1</label>
                                                                            <div class="col-sm-9">
                                                                                <textarea class="form-control " id="insInvAdd1" name="insInvAdd1" rows="5" required></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="insInvAdd2" class="col-sm-3 col-form-label  text-end-pc">ที่อยู่ออกใบเสร็จ 2</label>
                                                                            <div class="col-sm-9">
                                                                                <textarea class="form-control " id="insInvAdd2" name="insInvAdd2" rows="5" required></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="insInvAdd3" class="col-sm-3 col-form-label  text-end-pc">ที่อยู่ออกใบเสร็จ 3</label>
                                                                            <div class="col-sm-9">
                                                                                <textarea class="form-control " id="insInvAdd3" name="insInvAdd3" rows="5" required></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                            </div>

                                        </div>
                                        <!--end::Row-->
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
                                            <i class="fas fa-file-alt"></i> สร้างใบงาน
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
                                        <label for="location_select" class="col-sm-3 col-form-label">เลือกสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select type="text" class="form-control m-input" id="location_select" name="location_select" data-dropdown-parent="#addLocationModal"></select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="job_characteristic" class="col-sm-3 col-form-label">ลักษณะงาน<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select type="text" class="form-control m-input" id="job_characteristic" name="job_characteristic" data-dropdown-parent="#addLocationModal">
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


    <!-- Modal เพิ่มสถานที่ -->
    <div class="modal fade" id="showGoogleMapModal" tabindex="-1" aria-labelledby="showGoogleMapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showGoogleMapModalLabel">แผนการเดินทาง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
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



    <!--end::Page Custom Javascript-->
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
            //const urlParams = new URLSearchParams(window.location.search);
            //const jobTemplateID = urlParams.get('jobTemplateID');
            //var LOAD_PROCESS_COUNT = 0;

            //alert(jobTemplateID);

            // Main data from dran and drop
            let MAIN_DATA = [];
            var TEMP_MAIN_DATA = {};
            let swappable = null;
            let JobCodeTEXT = "";
            let generateJobCodeFlg = false;
            let EditLocation_seq = "";
            let EditLocation_ID = "";
            let Editjob_characteristic = "";



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
            let  workOrder_Jobdate =  $("#job_date").flatpickr({
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
                        location_select.append($('<option>', {
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



                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('#addLocationModal').on('show.bs.modal', function() {
                $('#locationForm').trigger('reset');
                loadLocationForSelect();
                TEMP_MAIN_DATA = {};
            });

            $('#addLocationModal').on('hidden.bs.modal', function() {
                EditLocation_seq = "";
                EditLocation_ID = "";
                Editjob_characteristic = "";
            });

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



            /*
            Function ชื่อ checkInputsNewLocation() ทำหน้าที่ตรวจสอบความถูกต้องของข้อมูลที่กรอกเพื่อสร้างสถานที่ใหม่
            ตัวแปร location_select คือ ค่าที่ได้จากการเลือกสถานที่
            ตัวแปร job_characteristic คือ ค่าที่ได้จากการกรอกลักษณะงาน
            ถ้าค่าทั้งสองตัวมีค่าไม่เป็นค่าว่าง ให้ส่งค่า true กลับ
            ถ้าค่ามีค่าว่าง ให้แสดงข้อความแจ้งเตือนและส่งค่า false กลับ
            */
            // ตรวจสอบความถูกต้องของข้อมูลที่กรอกเข้ามาใหม่ในฟอร์มสร้างสถานที่
            function checkInputsNewLocation() {
                // ดึงค่าจาก input สถานที่และลักษณะงาน
                const location_select = $('#location_select').val();
                const job_characteristic = $('#job_characteristic').val();

                // ตรวจสอบว่าค่า input สถานที่และลักษณะงานถูกกรอกครบหรือไม่
                if (location_select && job_characteristic) {
                    return true;
                } else {
                    // แสดงข้อความแจ้งเตือนกรณีไม่กรอกครบ
                    Swal.fire({
                        title: 'กรุณากรอก สถานที่ และลักษณะงานให้ครบ',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
            }






            function getBadgeColor(jobCharacteristic) {
                if (jobCharacteristic.includes("Delivery")) {
                    return "badge-primary";
                } else if (jobCharacteristic.includes("Loading")) {
                    return "badge-success";
                } else if (jobCharacteristic.includes("Pick Up")) {
                    return "badge-info";
                } else if (jobCharacteristic.includes("Return")) {
                    return "badge-danger";
                } else {
                    return "badge-secondary";
                }
            }

            function getcardColor(action) {
                let color = "";
                if (action === "ลูกค้า") {
                    color = "";
                } else {
                    color = "";
                }
                return color;
            }

            // btnAddNewLocation
            $('body').on('click', '#btnAddNewLocation', function() {
                //console.log(TEMP_MAIN_DATA);
                if (checkInputsNewLocation()) {
                    $('#addLocationModal').modal('hide');
                    if (TEMP_MAIN_DATA.location_type == "ลูกค้า") {
                        //TEMP_MAIN_DATA['showName'] = TEMP_MAIN_DATA.customer_name + "(" + TEMP_MAIN_DATA.branch + ")" + " - " + TEMP_MAIN_DATA.location_name
                        TEMP_MAIN_DATA['showName'] = TEMP_MAIN_DATA.location_code + "<BR>" + TEMP_MAIN_DATA.customer_name + (TEMP_MAIN_DATA.branch ? "(" + TEMP_MAIN_DATA.branch + ")" : "") + " - " + TEMP_MAIN_DATA.location_name;
                    } else {
                        TEMP_MAIN_DATA['showName'] = TEMP_MAIN_DATA.location_code + "<BR>" + TEMP_MAIN_DATA.location_name;

                    }
                    TEMP_MAIN_DATA['job_characteristic'] = $("#job_characteristic").val();
                    TEMP_MAIN_DATA['job_characteristic_id'] = $("#job_characteristic").find(':selected').data("job_characteristic_id");
                    TEMP_MAIN_DATA['job_note'] = $("#job_note").val();
                    TEMP_MAIN_DATA['unique_key'] = generateRandomString(10);
                    TEMP_MAIN_DATA['cardColor'] = getcardColor(TEMP_MAIN_DATA.location_type);
                    TEMP_MAIN_DATA['job_characteristicShow'] = '<span class="badge ' + getBadgeColor(TEMP_MAIN_DATA.job_characteristic) + '" style="text-transform: uppercase; font-weight: bold; font-size: 1.2rem;" >' + TEMP_MAIN_DATA.job_characteristic + '</span>';

                    if (EditLocation_seq != "") {
                        MAIN_DATA[EditLocation_seq] = TEMP_MAIN_DATA

                    } else {
                        MAIN_DATA.push(TEMP_MAIN_DATA);
                    }

                    //console.log(MAIN_DATA);
                    createContainer();
                }

            });



            function Refresh_DragDrop() {
                var container = document.querySelector(".draggable-zone");
                if (!container) {
                    return;
                } else {
                    //console.log(container);
                }

                if (!swappable) {
                    swappable = new Sortable(container, {
                        draggable: ".draggable",
                        handle: '.draggable .draggable-handle',
                        forceFallback: true,
                        fallbackTolerance: 0,
                        mirror: {
                            appendTo: "body",
                            constrainDimensions: true,
                            xAxis: false,
                            yAxis: true
                        },
                        onUpdate: () => {
                            updateMainData();
                        }
                    });
                }
            }

            function removeItemByUniqueKey(arr, uniqueKey) {
                return arr.filter(item => item.unique_key !== uniqueKey);
            }



            function createContainer() {
                //console.log(MAIN_DATA);
                let mainContent = MAIN_DATA.map((item, idx) => {
                    return `
                    <div class="col draggable" data-idx="${idx}">
                        <div class="card border-3 border-gray card-bordered card-rounded ${item.cardColor}">
                            <div class="card-header">
                            <div class="card-title">
                                <div>
                                <a href="#" class="btn btn-icon btn-hover-light-primary draggable-handle">
                                    <i class="fas fa-bars fs-2x"><span class="path1"></span><span class="path2"></span></i> 
                                </a>
                                </div>
                                <h4 class="card-label">${item.job_characteristicShow}</h4>
                            </div>
                                <a class="btn btn-link btn-color-muted btn-active-color-primary mb-2 changeLocation" location_id="${item.location_id}" job_characteristic="${item.job_characteristic}" value="${idx}">เปลี่ยนสถานที่</a>
                                <a class="btn btn-link btn-color-muted btn-active-color-primary mb-2 delete_item_box" value="${item.unique_key}">x</a>
                            </div>
                            <div class="card-body">
                            <h4>${item.showName}</h4>
                            ${item.address} 
                            </div>
                            <div class="card-footer">
                            <div class="row">
                                <div class="col-6 text-right">
                                    <strong>Note:</strong> ${item.job_note || "-"}
                                </div>
                                <div class="col-6 text-left">
                                    <strong>Map URL:</strong> <a href="#" class="btn btn-sm btnlinkGoogleMap" lat="${item.latitude}" lng="${item.longitude}">
                                    <i class="bi bi-geo-alt fa-1x"><span class="path1"></span><span class="path2"></span></i> แผนที่</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col text-center">
                            <i class="fas fa-arrow-down fa-5x" style="color: #EFEFEF;"></i>
                        </div>
                        </div>
                        `;
                });

                $("#dragandDropZone").html(mainContent);
                // Action After MAIN_DATA Changed  ==========================
                Refresh_DragDrop();
                generateJobCode();
                if (MAIN_DATA.length >= 2) {
                    $('#btnGoogleRoute').removeClass('d-none');
                } else {
                    $('#btnGoogleRoute').addClass('d-none');
                }


            }

            function generateJobCode() {
                if (false) {

                    JobCodeTEXT = "";
                    if (MAIN_DATA.length > 0) {
                        const joined_location_code = MAIN_DATA.map(data => data.location_code).join("-");
                        JobCodeTEXT = joined_location_code;
                        // ClientID
                        const selectedOption = $("#ClientID option:selected");
                        let clientCode = selectedOption.attr("ClientCode");
                        if (!clientCode) {
                            clientCode = "";
                        }
                        JobCodeTEXT = clientCode + " : " + JobCodeTEXT;
                        // Add Job Type 
                        JobCodeTEXT = JobCodeTEXT + " (" + $("#job_type").val() + ")";
                    }
                    $("#jobNamePanel").html(JobCodeTEXT);
                    $("#job_name").val(JobCodeTEXT);
                }
            }

            $('body').on('change', '#ClientID', function() {
                generateJobCode();
            });

            $('body').on('change', '#job_type', function() {
                generateJobCode();
            });

            $('body').on('click', '.btnlinkGoogleMap', function() {
                // ดึงค่าละติจูดและลองติจูดจากแอตทริบิวต์ของปุ่ม
                var lat = $(this).attr("lat");
                var lng = $(this).attr("lng");

                // สร้าง URL สำหรับ Google Maps
                var url = "https://www.google.com/maps?q=" + lat + "," + lng + "&z=15&output=embed";

                // เปิดหน้าต่าง Google Maps ในหน้าต่างใหม่
                window.open(url, "_blank");
            });




            $('body').on('click', '.delete_item_box', function() {
                var target = ($(this).attr('value'));
                MAIN_DATA = removeItemByUniqueKey(MAIN_DATA, target);
                createContainer();
                //console.log(MAIN_DATA);
            });

            // changeLocation
            $('body').on('click', '.changeLocation', function() {
                var target = ($(this).attr('value'));
                var location_id = ($(this).attr('location_id'));
                var tmpjob_characteristic = ($(this).attr('job_characteristic'));

                //console.log(tmpjob_characteristic);
                EditLocation_seq = target;
                EditLocation_ID = location_id;
                EDITjob_characteristic = tmpjob_characteristic.trim();

                $('#addLocationModal').modal('show');
            });



            // สร้าง Function เพื่ออัปเดตลำดับข้อมูลใน MAIN_DATA
            function updateMainData() {
                const sortedEls = document.querySelectorAll('.draggable');
                const newMainData = [];
                sortedEls.forEach((el) => {
                    const idx = el.dataset.idx;
                    //console.log(idx);
                    //console.log(el.dataset.value);
                    //console.log(MAIN_DATA[idx]);
                    newMainData.push(MAIN_DATA[idx]);
                });
                MAIN_DATA = newMainData;
                //console.log(MAIN_DATA);
                createContainer();
            }
            $("#jobDetailCostForm input").on("keyup", function() {
                var total = 0;
                $("#jobDetailCostForm input").each(function() {
                    if (($(this).attr("id") != "total_expenses")) {
                        var value = parseFloat($(this).val());
                        if (!isNaN(value)) {
                            total += value;
                        }
                    }
                });
                $("#total_expenses").val(total.toFixed(2));
                if (total === 0) {
                    $("#totalCostPanel").html("- บาท");
                } else {
                    var formattedTotal = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $("#totalCostPanel").html(formattedTotal + " บาท");
                }

            });


            // 
            $('#showGoogleMapModal').on('show.bs.modal', function() {
                //console.log(MAIN_DATA);
                const coordinates = MAIN_DATA.map((item, index) => {
                    return {
                        //name: `${index + 1}. ${item.showName} (${item.job_characteristic})`,
                        name: `${index + 1}. ${item.location_code} [${item.job_characteristic}]`,
                        lat: parseFloat(item.latitude),
                        lng: parseFloat(item.longitude),
                    };
                });

                initMap(coordinates);
            });
            // Save Process -------------------------- 
            function validateFormBeforeSave() {
                // ตรวจสอบการเลือก ClientID
                var clientId = $("#ClientID").val();
                if (!clientId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกผู้ว่าจ้าง',
                    });
                    return false;
                }

                // ตรวจสอบการเลือก job_type
                var jobType = $("#job_type").val();
                if (!jobType) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกประเภทงาน',
                    });
                    return false;
                }

                // ตรวจสอบจำนวนสมาชิกของ MAIN_DATA
                if (MAIN_DATA.length < 2) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกสถานที่อย่างน้อย 2 จุด',
                    });
                    return false;
                }

                // ถ้าผ่านการตรวจสอบทั้งหมด ส่งค่า true
                return true;
            }


            //updatePlanTemplate
            $('body').on('click', '#updatePlanTemplate', function() {
                if (validateFormBeforeSave()) {
                    // Pass validate the save process ------------------------
                    // jobHeaderForm
                    var ajaxData = {
                        jobHeaderForm: formToObject($("#jobHeaderForm")),
                        jobDetailCostForm: Object.assign(formToObject($("#jobDetailCostForm")), formToObject($("#jobDetailinvAddForm"))),
                        jobDetailPlan: MAIN_DATA.map((item, index) => ({
                            ...item,
                            plan_order: index
                        }))
                    };

                    ajaxData['f'] = '5';
                    ajaxData['jobTemplateID'] = jobTemplateID;

                    //console.log(ajaxData);

                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/05_jobOrderTemplate/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Redirect to jobOrderTemplateDetail page with jobTemplateID parameter
                                window.location.href = `052_jobOrderTemplateDetail.php?jobTemplateID=${data}`;
                            });


                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });



                }
            });


            $('body').on('change', '#job_name', function() {
                let target = $(this).val();
                let selectID = $("#job_name").find(":selected").attr("selectID");
                $("#jobNamePanel").html(target);
                loadJobTemplateDatafromJobTemplateID(selectID);
            });



            // Load Job Data
            function loadJobTemplateDatafromJobTemplateID(selectID) {
                var ajaxData = {};
                ajaxData['f'] = '4';
                ajaxData['jobTemplateID'] = selectID;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/05_jobOrderTemplate/mainFunction.php',
                        data: (ajaxData),
                        beforeSend: function() {
                            // แสดง loading spinner หรือเป็นตัวอื่นๆที่เหมาะสม
                            $('#loading-spinner').show();
                        },
                    })
                    .done(function(data) {

                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);

                        // Process jobHeaderForm =================================================
                        // Assuming the JSON response is stored in a variable called jsonData
                        const jobHeaderForm = data_arr.jobHeaderForm[0];
                        $('#ClientID').val(jobHeaderForm.ClientID).trigger('change');
                        $('#customerID').val(jobHeaderForm.customer_id).trigger('change');
                        // Set the values of the form inputs using jQuery
                        //$('#job_name').val(jobHeaderForm.job_name);
                        //$('#ClientID').val(jobHeaderForm.ClientID);
                        $('#job_type').val(jobHeaderForm.job_type);
                        $('#remark').val(jobHeaderForm.remark);
                        $("#jobNamePanel").html(jobHeaderForm.job_name);

                        if (jobHeaderForm.active == 1) {
                            $('#active').attr('checked', true);
                        } else {
                            $('#active').removeAttr('checked');
                        }



                        // Process jobDetailCostForm =================================================
                        // เลือก form ที่ต้องการเติมค่า
                        var form = $('#jobDetailCostForm');

                        // กำหนดตัวแปรเก็บข้อมูลที่ต้องการนำมาเติมใน form
                        Object.keys(data_arr.jobDetailCostForm[0]).forEach(function(key) {
                            if (data_arr.jobDetailCostForm[0][key] === "0.00") {
                                data_arr.jobDetailCostForm[0][key] = "";
                            }
                        });
                        var jobDetailCostForm = data_arr.jobDetailCostForm[0];

                        // เติมค่าจากตัวแปร jobDetailCostForm ลงใน form
                        form.find('#hire_price').val(jobDetailCostForm.hire_price);
                        form.find('#overtime_fee').val(jobDetailCostForm.overtime_fee);
                        form.find('#port_charge').val(jobDetailCostForm.port_charge);
                        form.find('#yard_charge').val(jobDetailCostForm.yard_charge);
                        form.find('#container_return').val(jobDetailCostForm.container_return);
                        form.find('#container_cleaning_repair').val(jobDetailCostForm.container_cleaning_repair);
                        form.find('#container_drop_lift').val(jobDetailCostForm.container_drop_lift);
                        form.find('#other_charge').val(jobDetailCostForm.other_charge);
                        form.find('#deduction_note').val(jobDetailCostForm.deduction_note);
                        form.find('#wage_travel_cost').val(jobDetailCostForm.wage_travel_cost);
                        form.find('#vehicle_expenses').val(jobDetailCostForm.vehicle_expenses);
                        form.find('#total_expenses').val(jobDetailCostForm.total_expenses);
                        form.find('#remark').val(jobDetailCostForm.remark);
                        form.find('#expenses_1').val(jobDetailCostForm.expenses_1);

                        // เลือก form issue Invoice 
                        var form = $('#jobDetailinvAddForm');
                        form.find('#insInvAdd1').val(jobDetailCostForm.insInvAdd1);
                        form.find('#insInvAdd2').val(jobDetailCostForm.insInvAdd2);
                        form.find('#insInvAdd3').val(jobDetailCostForm.insInvAdd3);

                        // แสดงค่ารวมค่าใช้จ่ายใน Panel ด้านบน
                        //form.find('#totalCostPanel').text(jobDetailCostForm.total_expenses + ' บาท');
                        var total = 0;
                        $("#jobDetailCostForm input").each(function() {
                            if (($(this).attr("id") != "total_expenses")) {
                                var value = parseFloat($(this).val());
                                if (!isNaN(value)) {
                                    total += value;
                                }
                            }
                        });
                        $("#total_expenses").val(total.toFixed(2));
                        if (total === 0) {
                            $("#totalCostPanel").html("- บาท");
                        } else {
                            var formattedTotal = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            $("#totalCostPanel").html(formattedTotal + " บาท");
                        }


                        // Process jobDetailPlan =================================================
                        MAIN_DATA = data_arr.jobDetailPlan;
                        //console.log(MAIN_DATA);
                        createContainer();
                        generateJobCodeFlg = true;
                        $('#loading-spinner').hide();
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

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


            // Initialize Select2 for the existing item
            //$('.truckinJob').select2({
            //    placeholder: 'เลือกรถบรรทุก',
            //});
            $('#DriverList').repeater({
                initEmpty: true,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    var index = $(this).index() + 1; // ดึงค่า index ของ element ใน repeater นี้
                    var tripLabel = 'ทริปที่ ' + index; // สร้างคำว่า "ทริป" และนำค่า index มาเพิ่มต่อท้าย
                    //console.log($(this).html());
                    // Initialize Select2 for the newly added item
                    $(this).find('.truckinJob').select2({
                        placeholder: 'เลือกรถบรรทุก',
                        templateResult: select2OptionFormat, // ใช้ function formatResult แสดงรูปภาพ
                        templateSelection: select2OptionFormat // ใช้ function formatSelection เพื่อแสดงชื่อและ driver_id เมื่อเลือก
                    });

                    //truckDriver
                    $(this).find('.truckDriver').select2({
                        placeholder: 'เลือกคนขับ',
                        templateResult: select2OptionFormatforDriver, // ใช้ function formatResult แสดงรูปภาพ
                        templateSelection: select2OptionFormatforDriver // ใช้ function formatSelection เพื่อแสดงชื่อและ driver_id เมื่อเลือก
                    });

                    //jobStartDateTime
                    var firstJobStartDateTime = $('#DriverList').find('.jobStartDateTime:first');
                    $(this).find('.jobStartDateTime').flatpickr({
                        dateFormat: "Y-m-d H:i",
                        enableTime: true,
                        time_24hr: true,
                        locale: "th",
                        altInput: true,
                        altFormat: "j M y เวลา H:i",
                        thaiBuddhist: true,
                        defaultDate: firstJobStartDateTime.val() // กำหนดค่าเริ่มต้นของ input field ใหม่จากค่าของ input field แรก
                    });
                    //console.log(tripLabel);
                    $(this).find('.triptNo').html(tripLabel);
                    $(this).slideDown();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            $('body').on('change', '.truckinJob', function() {
                var driver_id = $(this).find(':selected').data('driver_id');
                //var truck_type = $(this).find(':selected').data('truck_type');
                $(this).closest('[data-repeater-item]').find('.truckDriver').val(driver_id).trigger('change');
                //$(this).closest('[data-repeater-item]').find('.truckType').val(truck_type);

            });

            $('body').on('change', '.jobStartDateTime', function() {
                var firstDate_time = $('#DriverList').find('.jobStartDateTime:first').val();
                workOrder_Jobdate.setDate(firstDate_time);

            });

            $('body').on('change', '.truckDriver', function() {
                var driver_type = $(this).find(':selected').data('driver_type');

                if (typeof driver_type !== 'undefined') {
                    if (driver_type === "ซับ คอนแทรค") {
                        $(this).parents('[data-repeater-item]').find('.subcontrackCheckbox').prop('checked', true);

                    } else {
                        $(this).parents('[data-repeater-item]').find('.subcontrackCheckbox').prop('checked', false);
                    }
                }
            });

            function validateData(data) {
                // ตรวจสอบว่า jobDetailPlan เป็น array หรือไม่
                if (data.jobDetailPlan.length < 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'ต้องมีแผนการเดินทาง'
                    });
                    return false;
                }

                // ตรวจสอบว่า jobDetailTrip เป็น array หรือไม่
                if (data.jobDetailTrip.length < 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'ต้องมีรถที่ออกปฏิบัติงานอย่างน้อย 1 คัน'
                    });
                    return false;
                }

                // ตรวจสอบว่า jobStartDateTime, driver_id, truck_id ใน jobDetailTrip มีข้อมูลหรือไม่
                for (let i = 0; i < data.jobDetailTrip.length; i++) {
                    if (!data.jobDetailTrip[i].jobStartDateTime || !data.jobDetailTrip[i].driver_id || !data.jobDetailTrip[i].truck_id) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'รถทุกคันจำเป็นต้องมีข้อมูล ทะเบียนรถ คนขับ และเวลาเริ่มงาน'
                        });
                        return false;
                    }
                }

                // ตรวจสอบว่า customerID, ClientID, job_name, job_date, job_type ใน jobHeaderForm มีข้อมูลหรือไม่
                const jobHeader = data.jobHeaderForm;
                if (!jobHeader.customerID || !jobHeader.ClientID || !jobHeader.job_name || !jobHeader.job_date || !jobHeader.job_type) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'ลูกค้า, ผู้จ้าง ชื่องาน วันที่ และ ประเภทงาน จำเป็นต้องมีข้อมูล!'
                    });
                    return false;
                }

                return true;
            }



            $('#saveDatabtn').click(function() {
                var jobDetailTrip = [];
                $('#DriverList [data-repeater-item]').each(function(index) {
                    var data = {};
                    data.tripSeq = index + 1; // เพิ่ม repeaterNo โดยใช้ index ของ repeater และเพิ่ม 1 เพื่อให้เริ่มต้นที่ 1

                    //var selectedOption = $(this).find(":selected");
                    //var clientName = selectedOption.text();
                    //data.client_name = clientName;

                    data.truck_id = $(this).find('.truckinJob').val();
                    data.truck_licenseNo = $(this).find('.truckinJob').find(":selected").text();
                    data.driver_id = $(this).find('.truckDriver').val();
                    data.driver_name = $(this).find('.truckDriver').find(":selected").text();

                    // Cont 1
                    data.containerID = $(this).find('.containerID').val();
                    data.sealNo = $(this).find('.sealNo').val();
                    data.containerWeight = $(this).find('.containerWeight').val();
                    data.subcontrackCheckbox = $(this).find('.subcontrackCheckbox').prop('checked') ? '1' : '0';
                    data.containersize = $(this).find('.containersize').val();

                    // Cont 2
                    data.containerID2 = $(this).find('.containerID2').val();
                    data.seal_no2 = $(this).find('.sealNo2').val();
                    data.containerWeight2 = $(this).find('.containerWeight2').val();
                    data.containersize2 = $(this).find('.containersize2').val();

                    data.truckType = $(this).find('.truckType').val();
                    data.jobStartDateTime = $(this).find('.jobStartDateTime').val();
                    jobDetailTrip.push(data);
                });
                var ajaxData = {
                    jobHeaderForm: Object.assign(formToObject($("#jobHeaderForm")), formToObject($("#jobHeaderMainForm"))),
                    jobDetailCostForm: Object.assign(formToObject($("#jobDetailCostForm")), formToObject($("#jobDetailinvAddForm"))),
                    jobDetailTrip: jobDetailTrip,
                    jobDetailPlan: MAIN_DATA.map((item, index) => ({
                        ...item,
                        plan_order: index
                    }))
                };
                // jobHeaderMainForm

                if (validateData(ajaxData)) {
                    $('#saveDatabtn').prop('disabled', true);
                    ajaxData['f'] = '1';
                    ajaxData['create_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                    ajaxData['job_template_id'] = $("#job_name").find(":selected").attr("selectID");
                    //console.log(ajaxData);


                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/10_workOrder/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            //console.log(data);
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Redirect to jobOrderTemplateDetail page with jobTemplateID parameter
                                window.location.href = '102_confirmWorkOrder.php?job_id=' + data.match(/\d+/g).join("");;
                            });

                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });


                }
                // ส่งข้อมูลไปยัง API หรือส่วนอื่น ๆ ต่อไปได้ที่นี่
            });



            // Load Data from Initail page load =======
            //loadJobTemplateDatafromJobTemplateID();



        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>