<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>ใบงาน > รายละเอียดทริป</title>
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

        .timelineAttachedFile {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;

        }

        .timelineAttachedFile img {
            width: 50px;
            height: 50px;
            max-width: 100%;
            object-fit: cover;
            margin-right: 5px;
        }

        .image-slider {
            max-height: 100vh;
            /* กำหนดความสูงสูงสุดเท่ากับความสูงของหน้าจอ */
            overflow: hidden;
            /* ซ่อนส่วนที่เกินขอบเขตของ Slider */
        }

        .image-slider img {
            max-height: 100%;
            /* กำหนดความสูงสูงสุดเท่ากับความสูงของ Slider */
            width: auto;
            /* ปรับขนาดความกว้างอัตโนมัติ */
        }

        .image-slider-nav {
            position: absolute;
            /* กำหนดตำแหน่งเป็น absolute */
            bottom: 10px;
            /* กำหนดระยะห่างจากด้านล่าง */
            left: 50%;
            /* จัดแถบนำไปที่ตำแหน่งกึ่งกลางซ้ายของ Slider */
            transform: translateX(-50%);
            /* จัดแถบนำให้อยู่ตรงกลางของ Slider */
        }

        .image-slider-nav button {
            display: inline-block;
            /* แสดงเป็น inline-block เพื่อให้ปุ่มอยู่ในแถบนำในแนวนอน */
            margin: 0 5px;
            /* กำหนดระยะห่างระหว่างปุ่ม */
        }

        .dotted-line {
            border-bottom: 2px dotted black;
        }

        .timeline-item-custom {
            border-top: 1px solid #CCC;
            border-top-style: dashed;
            padding-top: 10px;
        }

        /* ----------track */
        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 70px;
            margin-top: 10px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #4CAF50
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #4CAF50;
            color: #000
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px;
            color: #AAA
        }

        .mapOpenModal {
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
                                    <li class="breadcrumb-item text-muted">
                                        <a class="text-muted text-hover-primary" id="jobOrderbreadcrumb"></a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>

                                    <li class="breadcrumb-item text-dark" id="tripbreadcrumb"></li>
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
                                        <div class="card-toolbar text-end">
                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="driverLink">
                                                <i class="fas fa-link fs-4"></i> ลิ้งของคนขับ
                                            </button>

                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="printJob">
                                                <i class="fas fa-file-pdf fs-3"></i> ใบงาน
                                            </button>

                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="closeJob">
                                                <i class="fas fa-check-circle fs-4"></i> จบงาน
                                            </button>
                                            <button type="button" class="btn btn-sm btn-color-primary btn-active-light-primary" id="setAlarmVGMClosing">
                                                <i class="fas fa-bell fs-4"></i> ตั้งเวลาแจ้งเตือน
                                            </button>
                                            <span id="VGMandClosingPanel"></span>


                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="container">
                                                <form id="jobHeaderMainForm">
                                                    <div class="row d-none">
                                                        <label for="main_book_no" class="col-sm-3 col-form-label text-end-pc">เล่มที่</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="main_book_no" name="main_book_no" placeholder="เลขอัตโนมัติ" disabled>
                                                        </div>
                                                        <label for="main_no" class="col-sm-3 col-form-label text-end-pc">เลขที่</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="main_no" name="main_no" placeholder="เลขอัตโนมัติ" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="mb-5 row">
                                                        <div class="col-12">
                                                            <div class="track" id="tripTimeLineOverAll">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="job_no" class="col-sm-1 col-form-label text-end-pc">Job No.</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="job_no" name="job_no" placeholder="เลขอัตโนมัติ" disabled>
                                                        </div>
                                                        <label for="tripNo" class="col-sm-1 col-form-label text-end-pc">Trip No.</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="tripNo" name="tripNo" placeholder="เลขอัตโนมัติ" disabled>
                                                        </div>
                                                        <label for="job_date" class="col-sm-1 col-form-label text-end-pc">วันที่</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" id="job_date" name="job_date" disabled>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#panel_1"><i class="bi bi-truck fs-3"></i>&nbsp&nbsp&nbspรถบรรทุก</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#panel_2"><i class="bi bi-card-checklist fs-3"></i></i>&nbsp&nbsp&nbspรายละเอียดใบงาน</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#panel_3"><i class="fas fa-file fs-3"></i></i>&nbsp&nbsp&nbspไฟล์</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="panel_1" role="tabpanel">
                                                <div class="card">
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
                                                                        <form id="DriverListForm">
                                                                            <div class="form-group row mb-2">
                                                                                <div class="col-md-3">
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <label class="form-label">รถ</label>
                                                                                            <select class="form-control mb-2 mb-md-2 truckinJob" id="truckinJob" name="truckinJob">
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
                                                                                            <select class="form-control mb-2 mb-md-0 truckDriver" id="truckDriver" name="truckDriver">
                                                                                                <?php
                                                                                                // Connect to database
                                                                                                include "function/connectionDb.php";

                                                                                                // Query data from master_data where type = 'Job_Type'
                                                                                                $sql = "SELECT * From truck_driver_info WHERE active = 1";
                                                                                                $result = mysqli_query($conn, $sql);

                                                                                                // Loop through data and create dropdown options
                                                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                                                    //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                                                                    echo "<option value='" . $row['driver_id'] . "' driverName='" . $row['driver_name'] . "' driverImg='assets/media/uploadfile/" . $row['image_path'] . "' data-driver_type='" . $row['type'] . "' data-line_id='" . $row['line_id'] .  "'>" . $row['driver_name'] . "</option>";
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
                                                                                            <select class="form-control mb-2 mb-md-0 truckType" name="truckType" id="truckType">
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
                                                                                            <input type="date" class="form-control jobStartDateTime" name="jobStartDateTime" id="jobStartDateTime" autocomplete="off">
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
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Form group-->

                                                        </div>
                                                        <!--end::Repeater-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="panel_2" role="tabpanel">
                                                <div class="card">
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
                                                                            <textarea class="form-control" id="remark" name="remark" disabled></textarea>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="panel_3" role="tabpanel">
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
                                </div>

                                <!-- จบ Card -->
                                <!-- เริ่มต้น Card -->
                                <div class="row mt-10">
                                    <div class="col-sm-6" id="cardTimeline">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="col-sm-6 mt-3 d-flex align-items-center px-3">
                                                    <h1> รายละเอียด Trip <span class='mapOpenModal d-none'><i class='fas fa-map fs-3'></i></span></h1>
                                                </div>


                                                <div class="card-toolbar">
                                                    <button type="button" class="btn btn-lg btn-success px-3  me-3" data-bs-toggle="modal" data-bs-target="#addAttachedFileModal">
                                                        แนบไฟล์/รูปภาพ
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                                                            <a class="menu-link flex-stack px-3" id="sednMSGtoDriver">ส่งข้อความถึงคนขับ</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a class="menu-link flex-stack px-3" id="checkMapbtn">ตรวจสอบเส้นทาง</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a class="menu-link flex-stack px-3" id="changeRoute">เปลี่ยนแผนการเดินรถ <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="สามารถเปลี่ยนแปลงเส้นทางได้เฉพาะยังไม่ได้ยืนยันงานเท่านั้น"></i></a></a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a class="menu-link flex-stack px-3" id="attachedFileBtn" data-bs-toggle="modal" data-bs-target="#addAttachedFileModal">แนบไฟล์/รูป
                                                            </a>
                                                        </div>
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a class="menu-link flex-stack px-3" id="cancelJobBtn">ยกเลิกทริป
                                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="กรณียกเลิกใบงาน จะไม่สามารถย้อนกระบวนการ"></i></a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--end::Menu item-->
                                                    </div>
                                                </div>


                                            </div>
                                            <!--begin::Body-->
                                            <div class="card-body pt-5">
                                                <div class="row mb-5">
                                                    <div class="col-sm-12 text-end-pc">
                                                        <label class=" fs-1">สถานะปัจจุบัน: </label> <label id="jobStatusText" class=" fs-1"></label>
                                                    </div>
                                                </div>
                                                <div class="timeline-label">
                                                    กำลังโหลดข้อมูล...
                                                </div>
                                            </div>
                                            <!--end: Card Body-->
                                            <div class="card-footer d-flex justify-content-between">
                                                <div class="col-8">
                                                    <div class="row">
                                                        <label id="jobStatusNext" class="fs-3"></label>
                                                    </div>
                                                    <div class="row">
                                                        <label id="jobStatusNextLocation" class="fs-6 text-gray-500"></label>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">

                                                    <button type="button" class="btn btn-primary" id="status_update">
                                                        Action
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 d-none" id="classEditTimeLine">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="col-auto mt-3 d-flex align-items-center px-3">
                                                    <h1><i class="bi bi-map fs-3"></i> เปลี่ยนแปลงแผนการเดินทาง</h1>
                                                </div>
                                            </div>
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <!--begin::Row-->
                                                <div class="row row-cols-1 g-10">
                                                    <div class="col-sm-12 text-end">
                                                        <!-- ปุ่มเพิ่มสถานที่ -->
                                                        <button type="button" class="btn btn-primary  mt-1" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                                                            <i class="fas fa-plus"></i> เพิ่มสถานที่ในเส้นทาง
                                                        </button>
                                                    </div>
                                                </div>
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
                                            <!--end: Card Body-->
                                            <div class="card-footer d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary" id="cancelCreateNewRoute">
                                                    ยกเลิก
                                                </button>

                                                <button type="button" class="btn btn-primary" id="saveNewRoute">
                                                    <i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลงเส้นทาง
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
                                                                        <input type="text" class="form-control" id="hire_price" name="hire_price" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="overtime_fee" class="col-sm-5 col-form-label  text-end-pc">ค่าล่วงเวลา</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="overtime_fee" name="overtime_fee" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="port_charge" class="col-sm-5 col-form-label  text-end-pc">ค่าผ่านท่า</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="port_charge" name="port_charge" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="yard_charge" class="col-sm-5 col-form-label  text-end-pc">ค่าผ่านลาน</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="yard_charge" name="yard_charge" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="container_return" class="col-sm-5 col-form-label  text-end-pc">ค่ารับตู้/คืนตู้</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="container_return" name="container_return" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="container_cleaning_repair" class="col-sm-5 col-form-label  text-end-pc">ค่าซ่อมตู้</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="container_cleaning_repair" name="container_cleaning_repair" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="container_drop_lift" class="col-sm-5 col-form-label  text-end-pc">ค่าล้างตู้</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="container_drop_lift" name="container_drop_lift" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="expenses_1" class="col-sm-5 col-form-label  text-end-pc">ค่าชอร์(SHORE)</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="expenses_1" name="expenses_1" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="other_charge" class="col-sm-5 col-form-label  text-end-pc">ค่าใช้จ่ายอื่นๆ</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="other_charge" name="other_charge" required>
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
                                                                        <input type="text" class="form-control" id="deduction_note" name="deduction_note" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3 d-none">
                                                                    <label for="total_expenses" class="col-sm-5 col-form-label  text-end-pc">รวมค่าใช้จ่าย</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="total_expenses" name="total_expenses" required>
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
                                                                        <input type="text" class="form-control" id="wage_travel_cost" name="wage_travel_cost" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="vehicle_expenses" class="col-sm-5 col-form-label  text-end-pc">ค่าใช้จ่ายรถ</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="vehicle_expenses" name="vehicle_expenses" required>
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
    <!-- Modal Attached File -->
    <div class="modal fade" id="addAttachedFileModal" tabindex="-1" aria-labelledby="addAttachedFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAttachedFileModalLabel">เพิ่มไฟล์แนบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                        <div class="col-md-6 mt-3">
                            <input type="text" class="form-control" id="newFileDesc" name="newFileDesc" placeholder="ประเภทไฟล์" autocomplete="off">
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="input-group">
                                <input type="file" class="form-control" id="uploadFile" name="uploadFiles[]" multiple>
                                <button class="btn btn-success" type="button" id="upload-btn">อัพโหลด</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>

    <!-- Modal Show image  -->
    <div class="modal fade" id="showImageModal" tabindex="-1" aria-labelledby="showImageModallLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg clear-modal-dialog">
            <div class="modal-content clear-modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body clear-modal-body">
                    <div class="tns" style="direction: ltr">
                        <div data-tns="true" data-tns-nav-position="bottom" data-tns-mouse-drag="true" data-tns-controls="false" id="showImagePanel">
                            <!--begin::Item-->
                            <!--end::Item-->
                            ...
                        </div>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="showImageModal2" tabindex="-1" role="dialog" aria-labelledby="showImageModal2Label" aria-hidden="true">
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

    <!-- Modal pinMapModal -->
    <div class="modal fade" id="pinMapModal" tabindex="-1" aria-labelledby="pinMapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinMapModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#GGmap">แผนที่</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Expen">ข้อมูลสถานที่ค่าใช้จ่าย</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="GGmap" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div id="pinMap" style="height: 500px;"></div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-auto mt-3">
                                    <button id="openMapButton" class="btn btn-primary">
                                        <i class="bi bi-geo-alt-fill"></i> เปิด Google Maps
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Expen" role="tabpanel">
                            <div id="locationDetailPanel" class="container">

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h5>รหัสสถานที่:</h5>
                                        <p id="locationCode"></p>

                                        <h5>ที่อยู่:</h5>
                                        <p id="address"></p>

                                        <h5>ประเภทสถานที่:</h5>
                                        <p id="locationType"></p>

                                        <h5>ค่ารับตู้สั้น:</h5>
                                        <p id="shortHaulFee"></p>

                                        <h5>ค่ารับตู้ยาว:</h5>
                                        <p id="longHaulFee"></p>
                                    </div>

                                    <div class="col-md-6">
                                        <h5>ค่าคืนตู้สั้น:</h5>
                                        <p id="shortHaulReturnFee"></p>

                                        <h5>ค่าคืนตู้ยาว:</h5>
                                        <p id="longHaulReturnFee"></p>

                                        <h5>ค่าผ่านลาน:</h5>
                                        <p id="yardFee"></p>

                                        <h5>เวลาเปิด-ปิด:</h5>
                                        <p id="openingHours"></p>

                                        <h5>เบอร์ติดต่อ:</h5>
                                        <p id="contactNumber"></p>

                                        <h5>หมายเหตุ:</h5>
                                        <p id="note"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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


    <!-- Modal เพิ่มสถานที่ -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLocationModalLabel">เลือกสถานที่</h5>
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
                                            <label class="col-sm-6 col-form-label d-none" id="job_characteristic_Panel"></label>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmsetVGMClosing">ตั้งเวลา</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เลือก Confirm ราย Trip -->
    <div class="modal fade" id="modalMapeachTrip" tabindex="-1" aria-labelledby="modalMapeachTripLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMapeachTripLabel">ทริปการเดินทางจริง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="mapeachTrip" style="height: 800px; width: 100%;"></div>
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

        // ฟังก์ชันเริ่มต้นแผนที่
        function initMap2(latitude, longitude) {
            // ตำแหน่งเริ่มต้นของแผนที่
            var myLatLng = {
                lat: parseFloat(latitude),
                lng: parseFloat(longitude)
            };

            // สร้างแผนที่
            var map = new google.maps.Map(document.getElementById('pinMap'), {
                zoom: 10, // ระดับการซูมของแผนที่ (สามารถแก้ไขตามความต้องการ)
                center: myLatLng // ตำแหน่งเริ่มต้นของแผนที่
            });

            // สร้างปักหมุด
            var marker = new google.maps.Marker({
                position: myLatLng, // ใช้ตำแหน่งที่ได้จากพารามิเตอร์
                map: map,
                title: 'ตำแหน่งที่คลิก'
            });
        }

        function initMapeachMap(tripGPS) {
            var map = new google.maps.Map(document.getElementById('mapeachTrip'), {
                zoom: 8,
                center: {
                    lat: parseFloat(tripGPS[0].lat),
                    lng: parseFloat(tripGPS[0].lon)
                }
            });

            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true // ปิดการแสดงหมุดอัตโนมัติ
            });

            var origin = tripGPS[0];
            var destination = tripGPS[tripGPS.length - 1];

            // เพิ่มจุดทางผ่าน (waypoints) และ InfoWindow สำหรับ timestamp
            var waypoints = tripGPS.slice(1, -1).map(function(gpsPoint) {
                var waypointMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(parseFloat(gpsPoint.lat), parseFloat(gpsPoint.lon)),
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 3 // ขนาดของจุดเล็กๆ
                    }
                });

                var waypointInfowindow = new google.maps.InfoWindow({
                    content: moment(gpsPoint.timestamp).fromNow()
                });

                waypointMarker.addListener('click', function() {
                    waypointInfowindow.open(map, waypointMarker);
                });

                return {
                    location: waypointMarker.position,
                    stopover: true
                };
            });

            // คำนวณเส้นทาง
            directionsService.route({
                origin: new google.maps.LatLng(parseFloat(origin.lat), parseFloat(origin.lon)),
                destination: new google.maps.LatLng(parseFloat(destination.lat), parseFloat(destination.lon)),
                waypoints: waypoints,
                travelMode: 'DRIVING',
                optimizeWaypoints: true // เพื่อการเรียงลำดับจุดทางผ่านที่เหมาะสมที่สุด
            }, function(response, status) {
                if (status === 'OK') {
                    //console.log(destination);
                    directionsRenderer.setDirections(response);

                    // สร้างหมุดและ InfoWindow สำหรับจุดปลายทาง
                    var destinationMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat(destination.lat), parseFloat(destination.lon)),
                        map: map,
                        title: 'Destination'
                    });

                    var destinationInfowindow = new google.maps.InfoWindow({
                        content: moment(destination.timestamp).fromNow() + "<BR>" + destination.Description
                    });

                    destinationMarker.addListener('click', function() {
                        destinationInfowindow.open(map, destinationMarker);
                    });
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
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
            const MAIN_trip_id = urlParams.get('trip_id');
            const OPEN_GPS_MODAL = urlParams.get('opengpsmodal');
            let MAIN_trip_no = "";
            let MAIN_job_no = "";
            let updatePlan_no = "";
            let MAIN_TRIP_RANDOMCODE = "";
            let MAINRANDOMCODE = "";
            let TIMELINE_MAIN_ORDER = "";
            //var LOAD_PROCESS_COUNT = 0;

            //alert(MAIN_job_id);

            // Main data from dran and drop
            let MAIN_DATA = [];
            var TEMP_MAIN_DATA = {};
            let MAIN_TIMELINE_DATA = {};
            let swappable = null;
            let JobCodeTEXT = "";
            let generateJobCodeFlg = false;
            let MAIN_TRIP_STATUS = "";
            let MAIN_CONFIRM_BTN = "";
            let MAIN_STAGE = "";
            let tempGooglrMapRoute = [];
            let EditLocation_seq = "";
            let EditLocation_ID = "";
            let Editjob_characteristic = "";
            let Editjob_Note = "";
            let changeActionMode = 0;

            // Change Status BTN =======================
            let STC_Title = "";
            let STC_Text = "";
            let STC_btn = "";

            // Validate Driver
            // ==========================================
            let current_diriver_id = "";
            let current_diriver_name = "";

            let initialWordforAttached = "";


            let gps_allTripArray = [];


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

            $('.truckinJob').select2({
                placeholder: 'เลือกรถบรรทุก',
                templateResult: select2OptionFormat, // ใช้ function formatResult แสดงรูปภาพ
                templateSelection: select2OptionFormat // ใช้ function formatSelection เพื่อแสดงชื่อและ driver_id เมื่อเลือก
            });

            //truckDriver
            $('.truckDriver').select2({
                placeholder: 'เลือกคนขับ',
                templateResult: select2OptionFormatforDriver, // ใช้ function formatResult แสดงรูปภาพ
                templateSelection: select2OptionFormatforDriver // ใช้ function formatSelection เพื่อแสดงชื่อและ driver_id เมื่อเลือก
            });

            //jobStartDateTime
            var jobStartDateTime_picker = $('.jobStartDateTime').flatpickr({
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                time_24hr: true,
                locale: "th",
                altInput: true,
                altFormat: "j M y เวลา H:i",
                thaiBuddhist: true,
                //defaultDate: firstJobStartDateTime.val() // กำหนดค่าเริ่มต้นของ input field ใหม่จากค่าของ input field แรก
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
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }




            function loadJobdata() {
                var ajaxData = {};
                ajaxData['f'] = '4';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['MAIN_trip_id'] = MAIN_trip_id;
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
                        document.querySelectorAll('#jobHeaderForm input').forEach(input => {
                            input.disabled = true;
                        });
                        //console.log(data_arr);
                        //var jobHeaderForm = document.querySelector('#jobHeaderForm');
                        //var jobHeaderMainForm = document.querySelector('#jobHeaderMainForm');

                        var jobHeaderForm = data_arr.jobHeader[0];
                        // Backup Driver Data =============
                        current_diriver_id = data_arr.JobDetailTrip[0].driver_id;
                        current_diriver_name = data_arr.JobDetailTrip[0].driver_name;



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


                        // กำหนดค่าใน element ของฟอร์มด้วย jQuery
                        $('#truckinJob').val(data_arr.JobDetailTrip[0].truck_id).trigger('change'); // ตัวอย่างการกำหนดค่าใน select element
                        $('#truckDriver').val(data_arr.JobDetailTrip[0].driver_id).trigger('change');
                        $('#truckType').val(data_arr.JobDetailTrip[0].truckType);
                        //$('#jobStartDateTime').val(data_arr.JobDetailTrip[0].jobStartDateTime);
                        $('.containerID').val(data_arr.JobDetailTrip[0].containerID);
                        $('.containersize').val(data_arr.JobDetailTrip[0].containersize);
                        $('.sealNo').val(data_arr.JobDetailTrip[0].seal_no);
                        $('.containerWeight').val(data_arr.JobDetailTrip[0].containerWeight);
                        $('.containerID2').val(data_arr.JobDetailTrip[0].containerID2);
                        $('.containersize2').val(data_arr.JobDetailTrip[0].containersize2);
                        $('.sealNo2').val(data_arr.JobDetailTrip[0].seal_no2);
                        $('.containerWeight2').val(data_arr.JobDetailTrip[0].containerWeight2);
                        $('.subcontrackCheckbox').prop('checked', data_arr.JobDetailTrip[0].subcontrackCheckbox == '1'); // ตัวอย่างการกำหนดค่าใน checkbox element


                        jobStartDateTime_picker.setDate(data_arr.JobDetailTrip[0].jobStartDateTime);

                        $(".triptNo").html("ทริปที่ " + data_arr.JobDetailTrip[0].tripSeq)

                        $("#jobOrderbreadcrumb").attr("href", "102_confirmWorkOrder.php?job_id=" + MAIN_job_id);
                        $("#jobOrderbreadcrumb").text(jobHeaderForm.job_no);
                        $("#tripbreadcrumb").text(data_arr.JobDetailTrip[0].tripNo);
                        $('#tripNo').val(data_arr.JobDetailTrip[0].tripNo);
                        MAIN_trip_no = data_arr.JobDetailTrip[0].tripNo;
                        MAIN_TRIP_RANDOMCODE = data_arr.JobDetailTrip[0].random_code;
                        MAIN_TRIP_STATUS = data_arr.JobDetailTrip[0].status;
                        // Set job status text and apply styles
                        var jobStatusText = $('#jobStatusText');
                        jobStatusText.text(MAIN_TRIP_STATUS);

                        if (data_arr.tripGPS.length > 0) {
                            $(".mapOpenModal").removeClass('d-none');
                            gps_allTripArray = data_arr.tripGPS;
                        }



                        if (MAIN_TRIP_STATUS === 'ยกเลิก') {
                            // Disable cancelJob button
                            $('#status_update').prop('disabled', true);

                            // Disable addFileBtn button
                            $('#attachedFileBtn').prop('disabled', true);

                            // Disable saveDatabtn button
                            $('#saveDatabtn').prop('disabled', true);

                            // Disable jobHeaderMainForm
                            $('#jobHeaderMainForm input, #jobHeaderMainForm select, #jobHeaderMainForm textarea, #jobHeaderMainForm button').attr('disabled', true);

                            // Disable DriverListForm
                            $('#DriverListForm input, #DriverListForm select, #DriverListForm textarea, #DriverListForm button').attr('disabled', true);

                            // Disable jobHeaderForm
                            $('#jobHeaderForm input, #jobHeaderForm select, #jobHeaderForm textarea, #jobHeaderForm button').attr('disabled', true);

                            // Disable jobDetailCostForm
                            $('#jobDetailCostForm input, #jobDetailCostForm select, #jobDetailCostForm textarea, #jobDetailCostForm button').attr('disabled', true);

                            // Disable jobDetailinvAddForm
                            $('#jobDetailinvAddForm input, #jobDetailinvAddForm select, #jobDetailinvAddForm textarea, #jobDetailinvAddForm button').attr('disabled', true);


                            Swal.fire({
                                title: 'ทริปนี้ถูกยกเลิกแล้ว',
                                icon: 'warning',
                                confirmButtonText: 'ตกลง'
                            });
                            jobStatusText.addClass('text-danger fw-bold');
                        } else if (MAIN_TRIP_STATUS === 'จบงาน') {
                            jobStatusText.addClass('text-success fw-bold');
                        } else {
                            jobStatusText.addClass('text-primary fw-bold');
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
                        form.find('#expenses_1').val(jobDetailCostForm.expenses_1);
                        form.find('#remark').val(jobDetailCostForm.remark);

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

                        printVGMClosing = "";
                        $.each(data_arr.trip_VGMClosing, function(index, object) {
                            printVGMClosing += "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class='text-danger'><B>" + object.alert_type + " : </B>" + moment(object.base_time).format("Do MMM H:mm น.") + "</span>";
                        });
                        //VGMandClosingPanel
                        $("#VGMandClosingPanel").html(printVGMClosing);



                        loadtripTimeLine();
                        $('#loading-spinner').hide();
                        // 1 second delay
                        setTimeout(function() {
                            if (OPEN_GPS_MODAL == 'true') {
                                initMapeachMap(gps_allTripArray);
                                $('#modalMapeachTrip').modal('show');
                            }
                        }, 1300);


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('body').on('change', '#truckinJob', function() {
                var driver_id = $(this).find(':selected').data('driver_id');
                //var truck_type = $(this).find(':selected').data('truck_type');
                $('#truckDriver').val(driver_id).trigger('change');
                //$(this).closest('[data-repeater-item]').find('.truckType').val(truck_type);

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

            $("#jobDetailCostForm input").on("keyup", function() {
                if ($(this).attr("id") == "deduction_note") {
                    check_value = $(this).val();
                    if ((check_value.trim() != "") && (check_value.charAt(0) != "-")) {
                        $(this).val("-" + check_value);
                    }
                }
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


            $('#saveDatabtn').click(function() {
                //let ajaxData = formToObject($("#DriverListForm"));
                let ajaxData = {
                    DriverListForm: formToObject($("#DriverListForm")),
                    jobDetailCostForm: Object.assign(formToObject($("#jobDetailCostForm")), formToObject($("#jobDetailinvAddForm"))),

                };
                ajaxData['f'] = 5;
                ajaxData['job_id'] = MAIN_job_id;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['MAIN_trip_id'] = MAIN_trip_id;
                ajaxData['driver_name'] = $('.truckDriver').find(":selected").text();;
                ajaxData['truck_licenseNo'] = $('.truckinJob').find(":selected").text();;
                // data.driver_name = $(this).find('.truckDriver').find(":selected").text(); truckinJob
                console.log(ajaxData);

                if (ajaxData.DriverListForm.truckDriver != current_diriver_id) {
                    Swal.fire({
                        title: 'เปลี่ยนคนขับรถ',
                        text: "คุณต้องการเปลี่ยนคนขับรถจาก " + current_diriver_name + " เป็น " + ajaxData.driver_name + " ใช่หรือไม่?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'ใช่, เปลี่ยน!',
                        cancelButtonText: 'ยกเลิก',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
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

                                    if (MAIN_TRIP_STATUS != "รอเจ้าหน้าที่ยืนยัน") {
                                        var ajaxData2 = {};
                                        ajaxData2['f'] = 28;
                                        ajaxData2['oldDriverID'] = current_diriver_id;
                                        ajaxData2['NewDriverID'] = ajaxData.DriverListForm.truckDriver;
                                        ajaxData2['MAIN_JOB_ID'] = MAIN_job_id;
                                        ajaxData2['MAIN_trip_id'] = MAIN_trip_id;
                                        ajaxData2['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                                        // Send notification to confirm new Driver
                                        $.ajax({
                                                type: 'POST',
                                                dataType: "text",
                                                url: 'function/10_workOrder/mainFunction.php',
                                                data: (ajaxData2),
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
                                    } else {
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
                                    }



                                })
                                .fail(function() {
                                    // just in case posting your form failed
                                    alert("Posting failed.");
                                });
                        } else if (
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            // รหัสสำหรับการยกเลิกการเปลี่ยนคนขับรถ
                        }
                    });

                } else {
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
                }


            });


            function loadtripTimeLine() {
                var ajaxData = {};
                ajaxData['f'] = '6';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['MAIN_trip_id'] = MAIN_trip_id;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData),
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        MAIN_TIMELINE_DATA = data_arr;
                        //console.log(data_arr);


                        // ==================================================

                        // สร้าง HTML element สำหรับแต่ละ item
                        var timelineItems = "";
                        // สร้างตัวแปรเก็บวันที่ก่อนหน้า
                        var prevDate = '';

                        for (var i = 0; i < data_arr.length; i++) {
                            var item = data_arr[i];
                            var timestamp_text = "";
                            var content_color = "text-muted";

                            if (item.timestamp != null) {
                                var timestamp = moment(item.timestamp);
                                var date = timestamp.format('D MMM');
                                timestamp_text = timestamp.format('HH:mm')

                                // ถ้าวันที่ไม่เท่ากับกับวันที่ก่อนหน้าให้เพิ่ม timeline item ใหม่
                                if (date != prevDate) {
                                    prevDate = date;
                                    timelineItems += '<div class="timeline-item">';
                                    timelineItems += '<div class="timeline-label fw-bolder text-gray-800 fs-6"></div>';
                                    timelineItems += '<span class="timeline-badge fw-bolder text-gray-800 fs-4"  style="white-space: nowrap;">';
                                    timelineItems += date;
                                    timelineItems += '</span>';
                                    timelineItems += '</div>';
                                }
                            }
                            bg_class = "";
                            if (item.main_order == "3") {
                                if (item.minor_order == "1") {
                                    item.step_desc = "<span class='fw-bolder fs-3'>" + item.step_desc + "</span>";
                                    bg_class = "timeline-item-custom";

                                } else {
                                    item.step_desc = "<span class=''>" + item.step_desc + "</span>";
                                }

                            }

                            // เพิ่ม timeline item ปกติ
                            timelineItems += '<div class="timeline-item ' + bg_class + ' ">';
                            timelineItems += '<div class="timeline-label fw-bolder text-gray-800 fs-6">' + timestamp_text + '</div>';
                            timelineItems += '<div class="timeline-badge">';
                            if (item.complete_flag !== null) {
                                if (item.main_order == "1") {
                                    timelineItems += '<i class="fas fa-circle text-primary fs-xs"></i>';
                                } else if (item.main_order == "3") {
                                    if (item.minor_order == "9") {
                                        timelineItems += '<i class="fas fa-circle text-success fs-xs"></i>';
                                    } else {
                                        timelineItems += '<i class="fa fa-genderless text-warning fs-1"></i>';
                                    }
                                } else if (item.main_order == "7") {
                                    timelineItems += '<i class="fas fa-circle text-success fs-xs"></i>';
                                } else if (item.main_order == "99") {
                                    timelineItems += '<i class="far fa-dot-circle text-danger fs-xs"></i>';
                                } else {
                                    timelineItems += '<i class="far fa-circle text-danger fs-xs"></i>';
                                }
                            } else {
                                timelineItems += '<i class="far fa-circle text-secondary fs-xs"></i>';
                            }

                            timelineItems += '</div>';

                            // กำหนดสีของเนื้อหาตามเงื่อนไข
                            if (item.complete_flag !== null) {
                                content_color = "text-muted";
                            } else {
                                content_color = "text-gray-500";
                            }

                            // แสดงข้อความของ step_desc และ location_name
                            if (item.step_desc && item.complete_flag !== null) {
                                timelineItems += '<div class="fw-mormal timeline-content ps-3">';
                                //console.log(item);

                                if (item.location_name) {
                                    switch (item.minor_order) {
                                        case "1":
                                            //timelineItems += item.step_desc;
                                            timelineItems += '<span class="text-danger fw-bolder">ถึงที่ </span>' + item.step_desc + ' ที่ <span class="locationclickBTN fw-bolder fs-3" location_name="' + item.location_name + '" latitude="' + item.latitude + '" longitude="' + item.longitude + '" location_id="' + item.location_id + '"><U>' + item.location_name + "</U></span>";
                                            break;
                                        case "3":
                                            timelineItems += '<span class="text-danger fw-bolder">เริ่ม </span>' + item.step_desc;
                                            break;
                                        case "7":
                                            timelineItems += '<span class="text-danger fw-bolder">เสร็จแล้ว </span>' + item.step_desc;
                                            break;
                                        case "9":
                                            timelineItems += '<span class="text-danger fw-bolder">ออกจากที่ </span>' + item.step_desc;
                                            break;
                                        default:
                                            // code block
                                    }
                                    //timelineItems += item.step_desc;
                                    //timelineItems += '<B> (' + item.button_name + ')</B> - <span class="locationclickBTN" location_name="' + item.location_name + '" latitude="' + item.latitude + '" longitude="' + item.longitude + '" location_id="' + item.location_id + '"><U>' + item.location_name + "</U></span>";
                                } else {
                                    timelineItems += item.step_desc;
                                }
                                if (item.main_order == '99') {
                                    var attachedFiles = item.attached_file;
                                    if (attachedFiles.length > 0) {
                                        timelineItems += '<div class="timelineAttachedFile" id="' + item.random_code + '">';
                                        for (var j = 0; j < attachedFiles.length; j++) {
                                            var file = attachedFiles[j];
                                            if (file.isImage === "1") {
                                                timelineItems += '<img src="' + file.thumbnail_path + '" class="imageInTimeLine" value = "' + item.random_code + '"  startIndex="' + j + '">';
                                            } else {
                                                timelineItems += '<a href="' + file.file_path + '" download>';
                                                timelineItems += '<i class="fa fa-file"></i> ' + file.originalFileName;
                                                timelineItems += '</a>&nbsp;&nbsp;&nbsp;';
                                            }
                                        }
                                        timelineItems += '</div>';
                                    }
                                }
                                timelineItems += '</div>';

                            } else {
                                timelineItems += '<div class="fw-mormal timeline-content ' + content_color + ' ps-3 ">' + item.step_desc;
                                if (item.location_name) {
                                    timelineItems += ' - <span class="locationclickBTN fw-bolder fs-3" location_name="' + item.location_name + '" latitude="' + item.latitude + '" longitude="' + item.longitude + '" location_id="' + item.location_id + '"><U>' + item.location_name + "</U></span>";
                                    if (MAIN_TRIP_STATUS != "รอเจ้าหน้าที่ยืนยัน") {
                                        timelineItems += '    <span class="badge badge-circle badge-light locationChangeBtn" data-plan_order="' + item.plan_order + '" data-location_id="' + item.location_id + '" data-job_characteristic="' + item.step_desc + '" data-job_note="' + item.job_note + '"><i class="fas fa-sync-alt"></i></span>';
                                    }
                                }
                                timelineItems += '</div>';
                            }


                            timelineItems += '</div>';
                        }



                        //console.log(timelineItems);

                        // เพิ่ม HTML element ลงใน timeline container
                        $('.timeline-label').html(timelineItems);




                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function get_status_and_button() {
                var ajaxData = {};
                ajaxData['f'] = '8';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['MAIN_trip_id'] = MAIN_trip_id;
                ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        if (data != "[]") {
                            //console.log(data);
                            var data_arr = JSON.parse(data);
                            //console.log(data_arr);
                            if (data_arr[0].stage != "รอเจ้าหน้าที่ยืนยัน") {

                                // ดึงข้อมูล step_desc และ button_name จาก Object
                                //var step_desc = data_arr[0].step_desc;
                                var button_name = data_arr[0].button_name;

                                // เปลี่ยนข้อความใน label และ button ด้วยข้อมูลที่ดึงมา

                                $('#status_update').text(button_name);
                                MAIN_CONFIRM_BTN = button_name;
                                MAIN_STAGE = data_arr[0].stage;
                                var stageColors = {
                                    "กำลังเดินทาง": "darkred",
                                    "รอเริ่มดำเนินการ": "darkblue",
                                    "รอดำเนินการเสร็จ": "darkgreen",
                                    "รอออกจากสถานที่": "darkorange",
                                    "รอเจ้าหน้าที่ยืนยัน": "darkviolet",
                                    "รอคนขับยืนยัน": "darkgoldenrod",
                                    "รอเริ่มงาน": "saddlebrown",
                                    "รอคนขับยืนยันจบงาน": "deeppink",
                                    "รอตรวจเอกสาร": "dimgray"
                                };

                                $('#jobStatusNext').text(MAIN_STAGE).css("color", stageColors[MAIN_STAGE]);

                                if (MAIN_STAGE == "รอเริ่มดำเนินการ") {
                                    $('#jobStatusNextLocation').text(data_arr[0].step_desc + "ที่" + data_arr[0].location_name);

                                } else if (MAIN_STAGE == "รอดำเนินการเสร็จ") {
                                    $('#jobStatusNextLocation').text(data_arr[0].step_desc + "ที่" + data_arr[0].location_name);

                                } else {
                                    $('#jobStatusNextLocation').text(data_arr[0].location_name);
                                }

                            } else {

                                $('#jobStatusNext').hide();
                                $('#status_update').hide();
                            }
                            TIMELINE_MAIN_ORDER = data_arr[0].main_order;
                        } else {

                            $('#jobStatusNext').hide();
                            $('#status_update').hide();
                        }

                        initialWordforAttached = "";
                        // Change Status BTN
                        if (data_arr[0].main_order == "3") {
                            initialWordforAttached = data_arr[0].stage + " " + data_arr[0].location_name;
                            switch (data_arr[0].minor_order) {
                                case "1":
                                    STC_Title = "ถึงที่หมาย";
                                    STC_Text = data_arr[0].location_name;
                                    STC_btn = "ยืนยัน" + MAIN_CONFIRM_BTN;
                                    break;
                                case "3":
                                    STC_Title = "เริ่มดำเนินการ" + data_arr[0].step_desc;
                                    STC_Text = data_arr[0].location_name;
                                    STC_btn = "ยืนยัน" + MAIN_CONFIRM_BTN;
                                    break;
                                case "7":
                                    STC_Title = data_arr[0].step_desc + "เสร็จ";
                                    STC_Text = data_arr[0].location_name;
                                    STC_btn = "ยืนยัน" + MAIN_CONFIRM_BTN;
                                    break;
                                case "9":
                                    STC_Title = "ออกจาก";
                                    STC_Text = data_arr[0].location_name;
                                    STC_btn = "ยืนยัน" + MAIN_CONFIRM_BTN;
                                    break;
                                default:
                            }
                        } else {
                            STC_Title = MAIN_STAGE;
                            STC_Text = "";
                            STC_btn = "ยืนยัน";
                        }
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('#addAttachedFileModal').on('show.bs.modal', function() {
                $("#newFileDesc").val(initialWordforAttached);
            });

            // status_update
            $('#status_update').on('click', function() {
                Swal.fire({
                    title: STC_Title,
                    text: STC_Text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: STC_btn,
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ทำงานเมื่อ user กด "ยืนยัน"
                        update_status();
                    }
                });
            });


            function update_status() {
                var ajaxData = {};
                ajaxData['f'] = '9';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['MAIN_trip_id'] = MAIN_trip_id;
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


            // Upload Process ===========================================

            var TOTAL_UPLOAD_FILE = 0;
            var CURRENT_UPLOAD_FILE = 0;
            const DOCUMENT_GROUP = "TRIP";
            const DOCUMENT_GROUP_CODE = MAIN_trip_id;
            const MAIN_FILE_PATH = "assets/media/uploadfile/uploadDoc/";
            let DocumentRandomStr = "";


            //$("#rowUploadProgress, #rowSelectFile").hide();
            $("#rowUploadProgress").hide();
            // เมื่อคลิกปุ่ม "เพิ่มไฟล์"

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
                DocumentRandomStr = generateRandomString(10);
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
                    var fileRandomStr = generateRandomString(2);
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
                        InsertAttachedfileDataTripLog()
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function InsertAttachedfileDataTripLog() {
                var ajaxData = {};
                ajaxData['f'] = '10';
                ajaxData['trip_id'] = MAIN_trip_id;
                ajaxData['file_desc'] = $("#newFileDesc").val();;
                ajaxData['random_code'] = DocumentRandomStr;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        //location.reload();
                        //$("#addAttachedFileModal").modal.hide();
                        $('#addAttachedFileModal').modal('hide');
                        loadtripTimeLine();
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            //imageInTimeLine
            $('body').on('click', '.imageInTimeLine', function() {
                var target = $(this).attr("value");
                var startIndex = $(this).attr("startIndex");
                // MAIN_TIMELINE_DATA
                //console.log(MAIN_TIMELINE_DATA);
                var attachedFiles = MAIN_TIMELINE_DATA.filter(function(item) {
                    return item.random_code === target;
                })[0].attached_file;

                var imagePanel = $('#showImagePanel');
                imagePanel.empty();

                var sliderHTML = '<div  class="image-slider" id="imageSlider">';
                for (var i = 0; i < attachedFiles.length; i++) {
                    var file = attachedFiles[i];
                    if (file.file_type.startsWith('image/')) {
                        var imagePath = file.file_path;
                        sliderHTML += '<div class="text-center ">';
                        sliderHTML += '<img src="' + imagePath + '" class="card-rounded shadow mw-100" alt="" />';
                        sliderHTML += '</div>';
                    }

                }
                sliderHTML += '</div>';

                imagePanel.html(sliderHTML);

                // เรียกใช้งาน Tiny Slider
                var imageSlider = tns({
                    container: '#imageSlider',
                    loop: true,
                    nav: true,
                    mouseDrag: true,
                    controls: false,
                    navPosition: "bottom",
                    lazyload: true,
                    startIndex: startIndex,
                });

                $('#showImageModal').modal('show');
            });

            function loadAttachedData() {
                var ajaxData = {};
                ajaxData['f'] = '6';
                ajaxData['DOCUMENT_GROUP'] = "JOB";
                ajaxData['DOCUMENT_GROUP_CODE'] = MAIN_job_id;
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
                $('#showImageModal2').modal('show');
            });

            $('body').on('click', '.locationclickBTN', function() {
                var latitude = $(this).attr("latitude");
                var longitude = $(this).attr("longitude");
                var location_name = $(this).attr("location_name");
                var location_id = $(this).attr("location_id");
                loadCustomerLocationID(location_id);
                $("#pinMapModalLabel").html(location_name);
                $('#pinMapModal').modal('show');
                initMap2(latitude, longitude);

                // แสดงค่า latitude และ longitude ในปุ่ม "เปิด Google Maps"
                var openMapButton = $("#openMapButton");
                openMapButton.data("latitude", latitude);
                openMapButton.data("longitude", longitude);
            });

            // เมื่อคลิกปุ่ม "เปิด Google Maps"
            $("#openMapButton").click(function() {
                var latitude = $(this).data("latitude");
                var longitude = $(this).data("longitude");

                // สร้าง URL ของ Google Maps ด้วย latitude และ longitude
                var mapUrl = "https://www.google.com/maps/search/?api=1&query=" + latitude + "," + longitude;

                // เปิด URL ในแท็บหน้าต่างใหม่
                window.open(mapUrl);
            });

            // checkMapbtn
            $("#checkMapbtn").click(function() {
                var ajaxData = {};
                ajaxData['f'] = '12';
                ajaxData['trip_id'] = MAIN_trip_id; // Convert the object to a JSON string
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
            });


            //openMapButton_2

            // เมื่อคลิกปุ่ม "เปิด Google Maps"
            $("#openMapButton_2").click(function() {
                var latLngArray = tempGooglrMapRoute.map(function(coordinate) {
                    return coordinate.lat + ',' + coordinate.lng;
                });

                var googleMapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + latLngArray[latLngArray.length - 1] + '&waypoints=' + latLngArray.slice(0, -1).join('|');

                window.open(googleMapsUrl, '_blank');
            });

            $('#printJob').click(function() {
                window.open(`PDF_jobCard.php?job_id=${MAIN_job_id}&trip_id=${MAIN_trip_id}`, '_blank');
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

                        var location = data_arr[0];

                        $("#locationCode").text(location.location_code);
                        $("#address").text(location.address);
                        $("#locationType").text(location.location_type);
                        $("#shortHaulFee").text(location.short_haul_fee && parseFloat(location.short_haul_fee) !== 0 ? location.short_haul_fee + " บาท" : "-");
                        $("#longHaulFee").text(location.long_haul_fee && parseFloat(location.long_haul_fee) !== 0 ? location.long_haul_fee + " บาท" : "-");
                        $("#shortHaulReturnFee").text(location.short_haul_return_fee && parseFloat(location.short_haul_return_fee) !== 0 ? location.short_haul_return_fee + " บาท" : "-");
                        $("#longHaulReturnFee").text(location.long_haul_return_fee && parseFloat(location.long_haul_return_fee) !== 0 ? location.long_haul_return_fee + " บาท" : "-");
                        $("#yardFee").text(location.yard_fee && parseFloat(location.yard_fee) !== 0 ? location.yard_fee + " บาท" : "-");

                        $("#openingHours").text(location.opening_hours ? location.opening_hours + " น." : "-");
                        $("#contactNumber").text(location.contact_number);

                        var urlPattern = /(https?:\/\/[^\s]+)/g;
                        var url = location.note.match(urlPattern);
                        if (url) {
                            // If a URL is found, create a link that opens in a new tab
                            var link = '<a href="' + url[0] + '" target="_blank">' + url[0] + '</a>';

                            // Replace the URL in the data with the new link
                            location.note = location.note.replace(urlPattern, link);
                        }
                        $("#note").html(location.note ? location.note : "-");
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // changeRoute
            // classEditTimeLine
            // classTimeLine
            // เมื่อคลิกที่ปุ่ม "changeRoute"
            $("#changeRoute").click(function() {
                if (MAIN_TRIP_STATUS == "รอเจ้าหน้าที่ยืนยัน") {
                    // saveDatabtn
                    $('#saveDatabtn').prop('disabled', true);
                    // ซ่อนส่วน "cardTimeline" โดยเพิ่มคลาส "d-none"
                    $("#cardTimeline").addClass("d-none");

                    // แสดงส่วน "classEditTimeLine" โดยลบคลาส "d-none"
                    $("#classEditTimeLine").removeClass("d-none");
                    loadTripDetailforEdit();
                } else {
                    Swal.fire({
                        title: 'ไม่สามารถเปลี่ยนแผนการเดินรถได้',
                        text: 'แต่คุณยังสามารถเปลี่ยนสถานที่ได้โดยคลิกที่สถานที่ เลือกเปลี่ยนสถานที่',
                        icon: 'warning',
                        confirmButtonText: 'ตกลง'
                    })

                }
            });

            // Loca tripplan for exit
            function loadTripDetailforEdit() {
                var ajaxData = {};
                ajaxData['f'] = '14';
                ajaxData['job_id'] = MAIN_job_id;
                ajaxData['trip_id'] = MAIN_trip_id;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/10_workOrder/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        MAIN_DATA = data_arr;
                        //console.log(MAIN_DATA);
                        createContainer();
                        generateJobCodeFlg = true;
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
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
                if (changeActionMode == 1) {

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
                    ajaxData['f'] = '16';
                    ajaxData['job_id'] = MAIN_job_id;
                    ajaxData['job_no'] = MAIN_job_no;
                    ajaxData['trip_id'] = MAIN_trip_id;
                    ajaxData['tripNo'] = MAIN_trip_no;
                    ajaxData['plan_order'] = EditLocation_seq;
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

                } else {
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
                                <a class="btn btn-link btn-color-muted btn-active-color-primary mb-2 changeLocation" location_id="${item.location_id}" job_characteristic="${item.job_characteristic}" job_note="${item.job_note}" value="${idx}">เปลี่ยนสถานที่</a>
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
                //generateJobCode();
                if (MAIN_DATA.length >= 2) {
                    $('#btnGoogleRoute').removeClass('d-none');
                } else {
                    $('#btnGoogleRoute').addClass('d-none');
                }
            }

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
                var tmpjob_note = ($(this).attr('job_note'));

                //console.log(tmpjob_characteristic);
                EditLocation_seq = target;
                EditLocation_ID = location_id;
                EDITjob_characteristic = tmpjob_characteristic.trim();
                Editjob_Note = tmpjob_note.trim();

                $('#addLocationModal').modal('show');
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

                        if (changeActionMode == 1) {
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

            $('#addLocationModal').on('show.bs.modal', function() {
                $('#locationForm').trigger('reset');
                $("#job_note").val(Editjob_Note);
                loadLocationForSelect();
                TEMP_MAIN_DATA = {};
            });

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

            $('#addLocationModal').on('hidden.bs.modal', function() {
                EditLocation_seq = "";
                EditLocation_ID = "";
                Editjob_characteristic = "";
                changeActionMode = 0;
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


            // 
            // 

            $("#cancelCreateNewRoute").click(function() {
                // ซ่อนส่วน "cardTimeline" โดยเพิ่มคลาส "d-none"
                $("#classEditTimeLine").addClass("d-none");

                // แสดงส่วน "classEditTimeLine" โดยลบคลาส "d-none"
                $("#cardTimeline").removeClass("d-none");
                $('#saveDatabtn').prop('disabled', false);
                //loadTripDetailforEdit();
            });

            // saveNewRoute
            $("#saveNewRoute").click(function() {
                var ajaxData = {
                    jobDetailPlan: MAIN_DATA.map((item, index) => ({
                        ...item,
                        plan_order: index
                    }))
                };
                ajaxData['f'] = '15';
                ajaxData['job_id'] = MAIN_job_id;
                ajaxData['job_no'] = MAIN_job_no;
                ajaxData['trip_id'] = MAIN_trip_id;
                ajaxData['tripNo'] = MAIN_trip_no;

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

            //locationChangeBtn
            $('body').on('click', '.locationChangeBtn', function() {
                var target = $(this).data('plan_order');
                var tmpjob_characteristic = $(this).data('job_characteristic');
                var location_id = $(this).data('location_id');
                var tmp_job_note = $(this).data('job_note');

                //console.log(tmpjob_characteristic);
                EditLocation_seq = target;
                EditLocation_ID = location_id;
                EDITjob_characteristic = tmpjob_characteristic.trim();
                Editjob_Note = tmp_job_note.trim();

                changeActionMode = 1;
                $('#addLocationModal').modal('show');
            });





            //sednMSGtoDriver
            //var driver_type = $(this).find(':selected').data('driver_type');
            $('body').on('click', '#sednMSGtoDriver', function() {
                var line_id_target = $(".truckDriver").find(':selected').data('line_id');
                if (line_id_target.trim() == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่พบข้อมูล Line',
                        text: 'ยังไม่ได้บันทึกข้อมูล System Line ID ของพนักงานขับรถเข้าสู่ระบบ',
                    });
                } else {
                    Swal.fire({
                        title: 'ข้อความที่ต้องการส่ง',
                        input: 'text',
                        inputPlaceholder: 'กรอกข้อความของคุณที่นี่',
                        showCancelButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let Message = result.value;
                            var ajaxData = {};
                            ajaxData['f'] = '8';
                            ajaxData['line_id'] = line_id_target;
                            ajaxData['message'] = Message;
                            ajaxData['link'] = "tripDetail.php?r=" + MAIN_TRIP_RANDOMCODE; //MAIN_TRIP_RANDOMCODE
                            $.ajax({
                                    type: 'POST',
                                    dataType: "text",
                                    url: 'function/00_systemManagement/mainFunction.php',
                                    data: (ajaxData)
                                })
                                .done(function(data) {
                                    //console.log(data);
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

                }
            });

            $('body').on('click', '#driverLink', function() {
                window.open("tripDetail.php?r=" + MAIN_TRIP_RANDOMCODE);
            });

            function loadTripTimeLineOverAll() {
                var ajaxData = {};
                ajaxData['f'] = '18';
                ajaxData['trip_id'] = MAIN_trip_id;
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
                        // สร้างตัวแปรสำหรับเก็บ HTML ของ Div tripTimeLineOverAll
                        var tripTimelineHTML = '';

                        // วนลูปผ่านรายการข้อมูลใน data_arr
                        for (var i = 0; i < data_arr.length; i++) {
                            var step = data_arr[i];
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

                        $('#tripTimeLineOverAll').html(tripTimelineHTML);



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

            $('body').on('mousedown touchstart', '.completeplan_order', function(event) {
                var planOrder_target = ($(this).attr('value'));
                var stepDesc = $(this).attr("stepDesc");
                var locationCode = ($(this).attr('locationCode'));


                if (event.type === 'mousedown' || event.type === 'touchstart') {
                    // Set timeout
                    pressTimer = window.setTimeout(function() {
                        //console.log(planOrder_target);
                        if (TIMELINE_MAIN_ORDER != '3') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'กรุณายืนยันและกดเริ่มงานก่อน',
                            })
                        } else {
                            Swal.fire({
                                title: "ยืนยัน" + stepDesc + "เสร็จแล้ว?",
                                text: "สถานที่ :" + locationCode,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "ยืนยัน",
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var ajaxData = {};
                                    ajaxData['f'] = '20';
                                    ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                                    ajaxData['MAIN_trip_id'] = MAIN_trip_id;
                                    ajaxData['update_user'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                                    ajaxData['planOrder'] = planOrder_target;
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
                            });
                        }

                    }, 500);

                    return false;
                }
            }).on('mouseup touchend', '.completeplan_order', function(event) {
                if (event.type === 'mouseup' || event.type === 'touchend') {
                    // โค้ดที่ต้องการทำเมื่อปล่อยมือหลังจากคลิกและกดค้างหรือสัมผัสหน้าจอ
                    clearTimeout(pressTimer);
                }
            });

            $('#closeJob').click(function() {
                Swal.fire({
                    title: "ยืนยันจบงาน",
                    text: "ต้องการยืนยันจบงานให้คนขับ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var ajaxData = {};
                        ajaxData['f'] = '21';
                        ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                        ajaxData['MAIN_trip_id'] = MAIN_trip_id;
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
                                //console.log(data);
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
                    }
                });
            });


            $('#cancelJobBtn').click(function() {
                Swal.fire({
                    title: "ยืนยันการยกเลิกทริป",
                    text: "คุณต้องการยกเลิกทรืปนี้จริงหรือไม่?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "ยืนยันยกเลิกทริป",
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
                var ajaxData = {};
                ajaxData['f'] = '24';
                ajaxData['MAIN_JOB_ID'] = MAIN_job_id;
                ajaxData['MAIN_TRIP_ID'] = MAIN_trip_id;
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
                            text: "ทริปถูกยกเลิกแล้ว",
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

            $('#setAlarmVGMClosing').on('click', function() {
                //let tableRows = allTrip_data.map(generateTableRowforVGMClosing).join("");
                //$('#tripTableBodyVGMClosing').html(tableRows);
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
                minuteIncrement: 1, // ตั้งค่านี้เพื่อให้เวลาเพิ่มขึ้นทีละ 1 นาที
            });

            $("#selectDateTimeforClosing").flatpickr({
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                locale: "th",
                altInput: true,
                altFormat: "j M y เวลา H:i น.",
                thaiBuddhist: true,
                minuteIncrement: 1, // ตั้งค่านี้เพื่อให้เวลาเพิ่มขึ้นทีละ 1 นาที
            });

            $('#btnConfirmsetVGMClosing').on('click', function() {
                let selectedTrips = [];
                selectedTrips.push(MAIN_trip_id);

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

            $('body').on('click', '.mapOpenModal', function() {
                //let target = $(this).attr('value');
                //console.log(gps_allTripArray[target]);
                //modalMapeachTrip
                initMapeachMap(gps_allTripArray);
                $('#modalMapeachTrip').modal('show');
            });







            // Load Data from Initail page load =======
            //loadJobTemplateDatafromJobTemplateID();
            loadJobdata();
            get_status_and_button();
            loadAttachedData();
            loadTripTimeLineOverAll();


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>