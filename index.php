<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>Dashboard</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <!-- Data table CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- pivotJS -->
    <link href="assets/plugins/custom/pivot/pivot.css" rel="stylesheet" type="text/css" />

    <!-- github_contribution_graph -->
    <link href="assets/plugins/custom/Github-Contribution-Graph/css/github_contribution_graph.css" rel="stylesheet" type="text/css" />


    <!--end::Global Stylesheets Bundle-->
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

        #jobCountChart {
            width: 100%;
            height: 500px;
            max-width: 100%;
            overflow: hidden;
        }

        .mouse_pointer {
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard</h1>
                                <!--end::Title-->
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start mx-4"></span>
                                <!--end::Separator-->
                                <!--begin::Breadcrumb-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">Dashboard</li>
                                    <!--end::Item-->
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
                            <div class="row gy-5 g-xl-8 mb-5">
                                <div class="col-md-4">
                                    <!--begin::Timeline widget 3-->
                                    <div class="card h-md-100">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1" onclick="window.location.href = '100_jobOrderIndex.php';">ใบงานประจำวัน</span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body pt-7 px-0">
                                            <!--begin::Nav-->
                                            <ul class="nav selectdateJob nav-stretch nav-pills nav-pills-custom nav-pills-active-custom d-flex justify-content-between mb-8 px-5">


                                            </ul>
                                            <!--end::Nav-->

                                            <!--begin::Tab Content (ishlamayabdi)-->
                                            <div class="tab-content mb-2 px-9" style="max-height: 300px; overflow-y: auto;">
                                                <!--begin::Tap pane-->
                                                <div class="tab-pane fade show active" id="show_DailyJob_panel">

                                                </div>
                                                <!--end::Tap pane-->

                                            </div>
                                            <!--end::Tab Content-->

                                            <!--begin::Action-->
                                            <div class="float-end d-none">
                                                <a href="#" class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">Add Lesson</a>

                                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Call Sick for Today</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end: Card Body-->
                                    </div>
                                    <!--end::Timeline widget 3-->
                                </div>

                                <div class="col-sm-8">
                                    <!--begin::Tables Widget 9-->
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1" onclick="window.location.href = '100_jobOrderIndex.php';">รายการใบงานวันนี้</span>
                                                <span class="text-muted mt-1 fw-bold fs-7">เฉพาะงานที่กำลังดำเนินการ</span>
                                            </h3>

                                            <div class="card-toolbar">
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                                        <span>
                                                            <i class="fa fa-calendar"></i> <span id="calendarLabel">เลือกระยะเวลา</span>
                                                        </span>
                                                        <i class="fa fa-caret-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3" style="max-height: 400px; overflow-y: auto;">
                                            <!--begin::Table container-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr class="fw-bolder text-muted">
                                                            <th class="min-w-140px">ชื่องาน</th>
                                                            <th class="min-w-140px">ขนาด</th>
                                                            <th class="min-w-140px">น้ำหนัก</th>
                                                            <th class="min-w-60px">Progress</th>
                                                        </tr>
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody id="่JobDailyProgressTable">
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table container-->
                                        </div>
                                        <!--begin::Body-->
                                    </div>
                                    <!--end::Tables Widget 9-->
                                </div>
                                <div class="col-sm-8 d-none">
                                    <!--begin::Tables Widget 9-->
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1" onclick="window.location.href = '100_jobOrderIndex.php';">รายการใบงาน</span>
                                                <span class="text-muted mt-1 fw-bold fs-7">เฉพาะงานที่กำลังดำเนินการ</span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3" style="max-height: 400px; overflow-y: auto;">
                                            <!--begin::Table container-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr class="fw-bolder text-muted">
                                                            <th class="min-w-120px">รถ-พขร</th>
                                                            <th class="min-w-140px">Job ID</th>
                                                            <th class="min-w-140px">ชื่องาน</th>
                                                            <th class="min-w-140px">เริ่มงาน/สถานะ</th>
                                                            <th class="min-w-60px">Progress</th>
                                                        </tr>
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody id="jobProgressTable">
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table container-->
                                        </div>
                                        <!--begin::Body-->
                                    </div>
                                    <!--end::Tables Widget 9-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row gy-5 g-xl-8">
                                <div class="col-sm-8">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Workload คนขับ</span>
                                            </h3>
                                            <div class="card-toolbar">

                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3 d-flex justify-content-center"> <!-- เพิ่ม class ที่นี่ -->
                                            <div id="chartDailyGrantt" style="width: 100%; height: 500px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!--begin::Tables Widget 9-->
                                    <div class="card card-xl-stretch mb-20 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Trip Timeline </span>
                                                <span class="text-muted mt-1 fw-bold fs-7" id="currentTimelineTripID"></span>
                                            </h3>
                                            <div class="card-toolbar">
                                                <!--begin::Menu-->
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
                                                <!--begin::Menu 1-->
                                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_615c3caa96379">
                                                    <!--begin::Header-->
                                                    <div class="px-7 py-5">
                                                        <div class="fs-5 text-dark fw-bolder">Trip ID</div>
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Menu separator-->
                                                    <div class="separator border-gray-200"></div>
                                                    <!--end::Menu separator-->
                                                    <!--begin::Form-->
                                                    <div class="px-7 py-5">
                                                        <!--begin::Input group-->
                                                        <div class="mb-10">
                                                            <!--begin::Input-->
                                                            <div>
                                                                <select class="form-select form-select-solid" id="select_tripTimeline">
                                                                    <?php
                                                                    // Connect to database
                                                                    include "function/connectionDb.php";

                                                                    // Query data from master_data where type = 'Job_Type'
                                                                    //$sql = "SELECT id as trip_id, job_id, tripNo FROM job_order_detail_trip_info Order By create_date DESC Limit 100";
                                                                    $sql = "SELECT id as trip_id, job_id, tripNo
                                                                    FROM job_order_detail_trip_info
                                                                    WHERE create_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                                                                    ORDER BY create_date DESC  ";
                                                                    $result = mysqli_query($conn, $sql);

                                                                    // Loop through data and create dropdown options
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<option value='" . $row['tripNo'] . "' data-trip_id='" . $row['trip_id'] . "' data-job_id='" . $row['job_id'] . "'>" . $row['tripNo'] . "</option>\n";
                                                                    }

                                                                    // Close database connection
                                                                    mysqli_close($conn);
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" class="btn btn-sm btn-primary d-none" id="select_Trip_no" data-kt-menu-dismiss="true">Apply</button>
                                                        </div>
                                                        <!--begin::Input group-->
                                                    </div>
                                                    <!--end::Form-->
                                                </div>
                                                <!--end::Menu 1-->
                                                <!--end::Menu-->
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3" style="max-height: 400px; overflow-y: auto;">
                                            <div class="timeline-label mb-5">
                                            </div>
                                        </div>
                                        <!--begin::Body-->
                                    </div>
                                    <!--end::Tables Widget 9-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--begin::Row-->
                            <div class="row gy-5 g-xl-8">
                                <div class="col-sm-6">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Trip ในแต่ละวัน</span>
                                            </h3>
                                            <div class="card-toolbar">

                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3 d-flex justify-content-center"> <!-- เพิ่ม class ที่นี่ -->
                                            <div id="github_chart_1" style="width: auto; overflow-x: scroll;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Trip ในแต่ละเดือน</span>
                                            </h3>
                                            <div class="card-toolbar">

                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3 d-flex justify-content-center"> <!-- เพิ่ม class ที่นี่ -->
                                            <div id="chart_Month" style="width: 100%; overflow-x: scroll;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row gy-5 g-xl-8">
                                <div class="col-sm-4">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Workload คนขับรถในเดือนนี้</span>
                                            </h3>
                                            <div class="card-toolbar">

                                            </div>
                                        </div>

                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3">
                                            <div id="DriverCountChart" style="width: 100%; height: 500px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">สรุปงานรายเดือน</span>
                                                <span class="text-muted mt-1 fw-bold fs-7" id="ReportShartShowName">รายใบงาน</span>
                                            </h3>
                                            <div class="card-toolbar">
                                                <!--begin::Menu-->
                                                <div class="d-flex align-items-center py-1 me-3">
                                                    <select class="form-select form-select-solid" id="selectTypeGraph">
                                                        <option d-name="รายใบงาน" value="job">รายใบงาน</option>
                                                        <option d-name="รายทริป" value="trip">รายทริป</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex align-items-center py-1">
                                                    <select class="form-select form-select-solid" id="selectMonthGraph">
                                                    </select>
                                                </div>
                                                <!--end::Menu-->
                                            </div>
                                        </div>

                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3">
                                            <div id="jobCountChart" style="width: 100%; height: 500px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Row-->
                            <div class="row gy-5 g-xl-8">
                                <div class="col-sm-8">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">ค่าจ้าง พขร.ในเดือนนี้</span>
                                                <span class="text-muted mt-1 fw-bold fs-7"></span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3">
                                            <div id="graphworkpayment" style="width: 100%; height: 500px;"></div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">สรุปงานในเดือนนี้</span>
                                                <span class="text-muted mt-1 fw-bold fs-7"></span>
                                            </h3>
                                            <div class="card-toolbar">
                                                
                                                <button type="button" class="btn btn-default pull-right" id="daterange-btn2">
                                                    <span>
                                                        <i class="fa fa-calendar"></i> <span id="calendarLabel2">เลือกระยะเวลา</span>
                                                    </span>
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                                <!--begin::Menu-->
                                                <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" id="btnOpenPivotTablePanel">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                    <i class="bi bi-arrows-angle-expand"></i>
                                                    <!--end::Svg Icon-->
                                                </button>
                                                <!--end::Menu 1-->
                                                <!--end::Menu-->
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3" style="max-height: 500px; overflow-y: auto;">
                                            <div id="output" style="width: 100%;"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--begin::Row-->
                            <div class="row gy-5 g-xl-8">
                                <div class="col-sm-12">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">ตารางงาน</span>
                                                <span class="text-muted mt-1 fw-bold fs-7"></span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3">
                                            <div id="kt_docs_fullcalendar_locales"></div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
                <?php
                include 'footer.php';
                ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->


    <!-- Modal แก้ไขสถานที่ -->
    <div class="modal fade" id="showPivotModal" tabindex="-1" aria-labelledby="showPivotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showPivotModalLabel">Pivot Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div id="myPivot" style="height: 100%; overflow-y: auto;"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
                </form>
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
    <!-- Sweet Alert 2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <!-- Data table JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"></script>

    <!--Date Picker ภาษาไทย -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>

    <!--Amchart -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/plugins/timeline.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/plugins/bullets.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>


    <!--pivottable -->
    <script src="assets/plugins/custom/pivot/pivot.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="assets/plugins/custom/pivot/export_renderers.js"></script>



    <!--github_contribution_graph -->
    <script src="assets/plugins/custom/Github-Contribution-Graph/js/github_contribution.js"></script>

    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
            // Set Moment 
            moment.locale('th');

            function am4themes_myTheme(target) {
                if (target instanceof am4core.ColorSet) {
                    target.list = [
                        am4core.color("#9EC3E6"),
                        am4core.color("#A8E6CF"),
                        am4core.color("#FFCC80"),
                        am4core.color("#FFABAB"),
                        am4core.color("#BAABD0"),
                        am4core.color("#D0F0C0"),
                        am4core.color("#F4C2C2"),
                        am4core.color("#CBD5E8"),
                        am4core.color("#FEDCD2")
                    ];
                }
            }



            // Initial Setting =======================
            am4core.useTheme(am4themes_myTheme);


            // Global Var 
            var selectMonthGraph = $("#selectMonthGraph");


            // สร้าง Option สำหรับเดือนตั้งแต่ 07-2022 จนถึง 01-2023
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();
            var currentMonth = currentDate.getMonth() + 1;

            for (var year = currentYear; year >= 2000; year--) {
                var startMonth = (year === currentYear) ? currentMonth : 12;
                var endMonth = (year === 2000) ? 7 : 1;

                for (var month = startMonth; month >= endMonth; month--) {
                    var monthString = month.toString().padStart(2, "0");
                    var option = $("<option></option>")
                        .attr("value", monthString + year)
                        .text(monthString + "-" + year);
                    selectMonthGraph.append(option);

                    if (year === 2023 && month === 1) {
                        break;
                    }
                }

                if (year === 2023 && month === 1) {
                    break;
                }
            }


            // เมื่อมีการเปลี่ยนค่าใน Select
            selectMonthGraph.on("change", function() {
                LoadMonthlyByClient()
            });


            $('#selectTypeGraph').change(function() {
                var selectedOption = $(this).find('option:selected');

                $("#ReportShartShowName").html(selectedOption.attr('d-name'));

                LoadMonthlyByClient();

                // ทำสิ่งอื่น ๆ ที่ต้องการกับข้อมูล name และ type ที่ได้
            });

            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'วันนี้': [moment(), moment()],
                        'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'พรุ่งนี้': [moment().subtract(-1, 'days'), moment().subtract(-1, 'days')],
                    },
                    startDate: moment(),
                    endDate: moment(),
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
                function(start, end, ranges) {
                    $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));

                    loadDailyBoard(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
                    //window.location.href = '100_jobOrderIndex.php?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD');
                }
            )

            $('#daterange-btn2').daterangepicker({
                    ranges: {
                        '30 วันล่าสุด': [moment().subtract(29, 'days'), moment()],
                        'เดือนนี้': [moment().startOf('month'), moment().endOf('month')],
                        'เดือนหน้า': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
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
                function(start, end, ranges) {
                    //loadDailyBoard(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                    $('#daterange-btn2 span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
                    LoadDataforPrivotTable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                    //window.location.href = '100_jobOrderIndex.php?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD');
                }
            )








            // Thai date sorting plugin
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-th-pre": function(a) {
                    var thDate = moment(a, 'D MMM YYYY', 'th');
                    //console.log(thDate);
                    if (thDate.isValid()) {
                        return thDate.unix();
                    } else {
                        return 0;
                    }
                },

                "date-th-asc": function(a, b) {
                    return a - b;
                },

                "date-th-desc": function(a, b) {
                    return b - a;
                }
            });

            let jobTable = $("#jobTable").DataTable({

                search: {
                    return: true,
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                },
                order: [
                    [0, "desc"]
                ] // เรียงลำดับตามคอลัมน์แรก (index 0) ในลำดับ DESC

            });
            jobTable.on('draw', function() {
                $('#jobTable').removeClass('d-none');
            });

            // ตรวจสอบการเปลี่ยนแปลงค่าของ checkbox
            $('#active').change(function() {
                if ($(this).is(":checked")) { // ถ้าถูกติ๊ก
                    window.location.href = '100_jobOrderIndex.php'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                } else { // ถ้าไม่ถูกติ๊ก
                    window.location.href = '100_jobOrderIndex.php?inactive=true'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                }
            });

            $('.dateFormatter').each(function() {
                var dateString = $(this).text();
                var formattedDate = moment(dateString).format('D MMM YYYY');
                var diffDays = moment().diff(moment(formattedDate, 'D MMM YYYY', 'th'), 'days');
                $(this).text(formattedDate);
            });

            /*
            $('.gpsTimestamp').each(function() {
                var dateString = $(this).text();
                var formattedDate = moment(dateString).fromNow();
                $(this).text(formattedDate);
            });
            */

            function loadProgress() {
                var ajaxData = {};
                ajaxData['f'] = '1';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        var maxLength = 30; // กำหนดความยาวสูงสุดที่ต้องการ

                        // เลือก tbody ของตาราง
                        var tbody = $('#jobProgressTable');
                        var initial_tripNo = "";
                        data_arr.forEach(function(data) {
                            if (initial_tripNo == "") {
                                initial_tripNo = data.tripNo;
                            }


                            var row = $('<tr></tr>');

                            // เพิ่มข้อมูลรถ-พขร
                            var truckDriverCell = $('<td></td>');
                            var truckDriverDiv = $('<div class="d-flex align-items-center"></div>');
                            var truckDriverSymbol = $('<div class="symbol symbol-45px me-5"><img src="' + data.image_path + '" alt="" /></div>');
                            var truckDriverInfo = $('<div class="d-flex justify-content-start flex-column"></div>');
                            var truckDriverName = $('<a href="#" class="text-dark fw-bolder text-hover-primary fs-6">' + data.driver_name + '</a>');
                            var truckDriverDesc = $('<span class="text-muted fw-bold text-muted d-block fs-7">' + data.truck_licenseNo + '</span>');

                            truckDriverInfo.append(truckDriverName);
                            truckDriverInfo.append(truckDriverDesc);
                            truckDriverDiv.append(truckDriverSymbol);
                            truckDriverDiv.append(truckDriverInfo);
                            truckDriverCell.append(truckDriverDiv);
                            row.append(truckDriverCell);

                            // เพิ่มข้อมูล Job ID (job_no และ tripNo)
                            var jobIDCell = $('<td></td>');
                            var jobIDLink = $('<a href="103_tripDetail.php?job_id=' + data.job_id + '&trip_id=' + data.trip_ID + '" class="text-dark fw-bolder text-hover-primary d-block fs-7">' + data.tripNo + '</a>');
                            var tripNo = $('<a href="102_confirmWorkOrder.php?job_id=' + data.job_id + '" class="text-muted fw-bold text-muted d-block fs-7">' + data.job_no + '</a>');
                            jobIDCell.append(jobIDLink);
                            jobIDCell.append(tripNo);
                            row.append(jobIDCell);

                            // เพิ่มข้อมูลชื่องาน
                            var jobNameCell = $('<td></td>');
                            var jobNameLink = $('<a href="#" class="text-dark fw-bolder text-hover-primary d-block fs-6">' + data.job_name + '</a>');
                            var customerName = $('<span class="text-muted fw-bold text-muted d-block fs-7">' + truncateText(data.customer_name, maxLength) + '</span>');
                            jobNameCell.append(jobNameLink);
                            jobNameCell.append(customerName);
                            row.append(jobNameCell);

                            // เพิ่มข้อมูลสถานะ
                            var jobNameCell = $('<td></td>');
                            var jobNameLink = $('<a href="#" class="text-dark fw-bolder text-hover-primary d-block fs-6 Jobtime">' + data.jobStartDateTime + '</a>');
                            var customerName = $('<span class="text-muted fw-bold text-muted d-block fs-7">' + data.status + '</span>');
                            jobNameCell.append(jobNameLink);
                            jobNameCell.append(customerName);
                            row.append(jobNameCell);

                            // เพิ่มข้อมูลProgress
                            var statusCell = $('<td class="text-end"></td>');
                            var statusDiv = $('<div class="d-flex flex-column w-100 me-2"></div>');
                            var statusStackDiv = $('<div class="d-flex flex-stack mb-2"></div>');
                            var statusPercent = $('<span class="text-muted me-2 fs-7 fw-bold">' + Math.round((parseFloat(data.PCT) * 100)) + '%</span>');
                            var progressBarDiv = $('<div class="progress h-6px w-100"></div>');
                            var progressBar = $('<div class="progress-bar" role="progressbar" style="background-color: ' + getColorByPercentage(parseFloat(data.PCT)) + '; width: ' + (parseFloat(data.PCT) * 100) + '%" aria-valuenow="' + (parseFloat(data.PCT) * 100) + '" aria-valuemin="0" aria-valuemax="100"></div>');

                            statusStackDiv.append(statusPercent);
                            progressBarDiv.append(progressBar);
                            statusDiv.append(statusStackDiv);
                            statusDiv.append(progressBarDiv);
                            statusCell.append(statusDiv);
                            row.append(statusCell);

                            tbody.append(row);
                        });
                        //console.log(initial_tripNo);
                        $('#select_tripTimeline').select2({});
                        $('#select_tripTimeline').val(initial_tripNo).trigger('change');
                        $('.Jobtime').each(function() {
                            var dateString = $(this).text();
                            var formattedDate = moment(dateString).format('D MMM HH:mm');
                            var diffDays = moment().diff(moment(formattedDate, 'D MMM YYYY', 'th'), 'days');
                            $(this).text(formattedDate);
                        });


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // ฟังก์ชันสำหรับตัดข้อความ
            function truncateText(text, maxLength) {
                if (text.length > maxLength) {
                    return text.slice(0, maxLength) + '...';
                }
                return text;
            }

            // ฟังก์ชันสำหรับเรียกคืนสีของ progress-bar ตามเปอร์เซ็นต์
            function getColorByPercentage(percentage) {
                var startColor = [255, 110, 127]; // #FFABAB (สีแดง)
                var endColor = [191, 233, 255]; // #A8E6CF

                var r = Math.round(startColor[0] + (endColor[0] - startColor[0]) * percentage);
                var g = Math.round(startColor[1] + (endColor[1] - startColor[1]) * percentage);
                var b = Math.round(startColor[2] + (endColor[2] - startColor[2]) * percentage);

                return 'rgb(' + r + ', ' + g + ', ' + b + ')';
            }


            function loadtripTimeLine(MAIN_job_id, MAIN_trip_id) {
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

                            // เพิ่ม timeline item ปกติ
                            timelineItems += '<div class="timeline-item">';
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
                                timelineItems += item.step_desc;
                                if (item.location_name) {
                                    timelineItems += '<B> (' + item.button_name + ')</B> - <span class="locationclickBTN" location_name="' + item.location_name + '" latitude="' + item.latitude + '" longitude="' + item.longitude + '" location_id="' + item.location_id + '"><span>' + item.location_name + "</span></span>";
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
                                    timelineItems += ' - <span class="locationclickBTN" location_name="' + item.location_name + '" latitude="' + item.latitude + '" longitude="' + item.longitude + '" location_id="' + item.location_id + '"><U>' + item.location_name + "</U></span>";
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

            $('body').on('change', '#select_tripTimeline', function() {
                $('#select_Trip_no').trigger('click').attr('data-kt-menu-dismiss', 'true');
                var trip_id = $(this).find(':selected').data('trip_id');
                var job_id = $(this).find(':selected').data('job_id');
                //console.log(trip_no);
                //console.log(trip_id);
                //console.log(job_id);
                var trip_no = $(this).find(':selected').val();
                $("#currentTimelineTripID").html(trip_no);
                if (typeof trip_id !== "undefined" && trip_id !== "") {
                    loadtripTimeLine(job_id, trip_id);
                }

            });



            function loadCalendar() {
                var ajaxData = {};
                ajaxData['f'] = '2';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);

                        var calendarEl = document.getElementById("kt_docs_fullcalendar_locales");

                        var events = [];
                        var dayCount = {};


                        // สร้าง events จาก data_arr
                        for (var i = 0; i < data_arr.length; i++) {
                            var startDate = data_arr[i].start.split(" ")[0]; // Assuming the format is "YYYY-MM-DD HH:MM:SS"

                            if (dayCount[startDate] === undefined) {
                                dayCount[startDate] = 0;
                            }
                            dayCount[startDate]++;


                            var completeFlag = data_arr[i].complete_flag;

                            var event = {
                                title: data_arr[i].title,
                                start: data_arr[i].start,
                                end: data_arr[i].start,
                                //end: data_arr[i].end,
                                url: data_arr[i].url,
                                color: null // เพิ่ม property color เพื่อกำหนดสี
                            };

                            if (completeFlag === null) {
                                event.color = "#9EC3E6"; // กำหนดสีน้ำเงินเข้ม หาก complete_flag เป็น null
                            } else if (completeFlag === -1) {
                                event.color = "#F4C2C2"; // กำหนดสีแดงเข้ม หาก complete_flag เป็น -1
                            } else {
                                event.color = "#2ECC71"; // กำหนดสีเขียวเข้ม หาก complete_flag ไม่ใช่ null และไม่ใช่ -1
                            }

                            events.push(event);
                        }

                        // initialize the calendar
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            headerToolbar: {
                                left: "prev,next today",
                                center: "title",
                                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                            },
                            initialDate: new Date(), // ใช้คำสั่ง new Date() เพื่อสร้างวันที่ปัจจุบัน
                            locale: "th",
                            buttonIcons: true,
                            weekNumbers: false,
                            navLinks: true,
                            editable: true,
                            dayMaxEvents: true,
                            dayCellDidMount: function(info) {
                                var dateStr = FullCalendar.formatDate(info.date, {
                                    month: 'numeric',
                                    day: 'numeric',
                                    year: 'numeric',
                                    delimiter: '-'
                                });
                                if (dayCount[dateStr]) {
                                    var cell = info.el;
                                    var countDiv = document.createElement("div");
                                    countDiv.className = "day-count";
                                    countDiv.innerHTML = "Count: " + dayCount[dateStr];
                                    cell.appendChild(countDiv);
                                }
                            },
                            events: events // ใช้ events ที่สร้างจาก data_arr
                        });

                        calendar.render();

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            function LoadMonthlyByClient() {
                var ajaxData = {};
                ajaxData['f'] = '3';
                ajaxData['type'] = $('#selectTypeGraph').val();
                ajaxData['selectMonth'] = $('#selectMonthGraph').val();
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log();
                        // สร้างตัวแปรสำหรับเก็บข้อมูลในรูปแบบที่ AmChart รองรับ
                        var chartData = [];
                        for (var i = 0; i < data_arr.length; i++) {
                            var dataItem = data_arr[i];
                            var chartItem = {
                                "category": dataItem.Category,
                                "value": parseInt(dataItem.count)
                            };
                            chartData.push(chartItem);
                        }


                        if (jobCountChart) {
                            jobCountChart.dispose();
                        }

                        var jobCountChart = am4core.create("jobCountChart", am4charts.PieChart);
                        jobCountChart.data = chartData;

                        var pieSeries = jobCountChart.series.push(new am4charts.PieSeries());
                        pieSeries.dataFields.value = "value";
                        pieSeries.dataFields.category = "category";

                        // ซ่อน Label ที่แสดงบน Pie Chart
                        pieSeries.labels.template.disabled = true;

                        // กำหนดให้ Legend แสดง Category และ Value
                        pieSeries.legendSettings.valueText = "{value}";

                        jobCountChart.legend = new am4charts.Legend();
                        jobCountChart.legend.position = "left";

                        jobCountChart.exporting.menu = new am4core.ExportMenu();
                        //chart.exporting.menu = new am4core.ExportMenu();



                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function LoadJobWorkLoad() {
                var ajaxData = {};
                ajaxData['f'] = '4';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);

                        var DriverLoadchart = am4core.create("DriverCountChart", am4charts.XYChart);
                        DriverLoadchart.data = data_arr;

                        var categoryAxis = DriverLoadchart.yAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "Category";
                        categoryAxis.renderer.grid.template.location = 0;
                        categoryAxis.renderer.inversed = true;

                        var valueAxis = DriverLoadchart.xAxes.push(new am4charts.ValueAxis());

                        var series = DriverLoadchart.series.push(new am4charts.ColumnSeries());
                        series.dataFields.categoryY = "Category";
                        series.dataFields.valueX = "count";
                        series.tooltipText = "{valueX.value}";
                        series.columns.template.strokeOpacity = 0;
                        series.columns.template.column.cornerRadiusTopRight = 10;
                        series.columns.template.column.cornerRadiusBottomRight = 10;

                        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                        labelBullet.label.horizontalCenter = "left";
                        labelBullet.label.dx = 10;
                        labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.')}";

                        DriverLoadchart.exporting.menu = new am4core.ExportMenu();

                        DriverLoadchart.cursor = new am4charts.XYCursor();

                        // เพิ่ม scrollbar
                        //var scrollbarY = new am4core.Scrollbar();
                        //DriverLoadchart.scrollbarY = scrollbarY;





                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            function getThisMonthPaymenteachDriver() {
                var ajaxData = {};
                ajaxData['f'] = '5';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.create("graphworkpayment", am4charts.XYChart);
                        am4core.useTheme(am4themes_myTheme);
                        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                        chart.paddingBottom = 30;

                        chart.data = data_arr;

                        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "driver_name";
                        categoryAxis.renderer.grid.template.strokeOpacity = 0;
                        categoryAxis.renderer.minGridDistance = 10;
                        categoryAxis.renderer.labels.template.dy = 35;
                        categoryAxis.renderer.tooltip.dy = 35;

                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        valueAxis.renderer.inside = true;
                        valueAxis.renderer.labels.template.fillOpacity = 0.3;
                        valueAxis.renderer.grid.template.strokeOpacity = 0;
                        valueAxis.min = 0;
                        valueAxis.cursorTooltipEnabled = false;
                        valueAxis.renderer.baseGrid.strokeOpacity = 0;

                        var series = chart.series.push(new am4charts.ColumnSeries());
                        series.dataFields.valueY = "hire_price";
                        series.dataFields.categoryX = "driver_name";
                        series.tooltipText = "{valueY.value}";
                        series.tooltip.pointerOrientation = "vertical";
                        series.tooltip.dy = -6;
                        series.columnsContainer.zIndex = 100;

                        var columnTemplate = series.columns.template;
                        columnTemplate.width = am4core.percent(35);
                        columnTemplate.maxWidth = 66;
                        columnTemplate.column.cornerRadius(60, 60, 60, 60);
                        columnTemplate.strokeOpacity = 0;
                        columnTemplate.height = 30; // กำหนดความสูงของแท่งให้น้อยลงเหลือ 30

                        series.heatRules.push({
                            target: columnTemplate,
                            property: "fill",
                            dataField: "valueY",
                            min: am4core.color("#FEDCD2"),
                            max: am4core.color("#A8E6CF")
                        });
                        series.mainContainer.mask = undefined;

                        var cursor = new am4charts.XYCursor();
                        chart.cursor = cursor;
                        cursor.lineX.disabled = true;
                        cursor.lineY.disabled = true;
                        cursor.behavior = "none";

                        var bullet = columnTemplate.createChild(am4charts.CircleBullet);
                        bullet.circle.radius = 20;
                        bullet.valign = "bottom";
                        bullet.align = "center";
                        bullet.isMeasured = true;
                        bullet.mouseEnabled = false;
                        bullet.verticalCenter = "bottom";
                        bullet.interactionsEnabled = false;

                        var hoverState = bullet.states.create("hover");
                        var outlineCircle = bullet.createChild(am4core.Circle);
                        outlineCircle.adapter.add("radius", function(radius, target) {
                            var circleBullet = target.parent;
                            return circleBullet.circle.pixelRadius + 10;
                        })

                        var image = bullet.createChild(am4core.Image);
                        image.width = 60;
                        image.height = 60;
                        image.horizontalCenter = "middle";
                        image.verticalCenter = "middle";
                        image.propertyFields.href = "image_path";

                        image.adapter.add("mask", function(mask, target) {
                            var circleBullet = target.parent;
                            return circleBullet.circle;
                        })

                        var previousBullet;
                        chart.cursor.events.on("cursorpositionchanged", function(event) {
                            var dataItem = series.tooltipDataItem;

                            if (dataItem.column) {
                                var bullet = dataItem.column.children.getIndex(1);

                                if (previousBullet && previousBullet != bullet) {
                                    previousBullet.isHover = false;
                                }

                                if (previousBullet != bullet) {

                                    var hs = bullet.states.getKey("hover");
                                    hs.properties.dy = -bullet.parent.pixelHeight + 30;
                                    bullet.isHover = true;

                                    previousBullet = bullet;
                                }
                            }
                        });



                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function LoadDataforPrivotTable(startDate, endDate) {
                var ajaxData = {};
                ajaxData['f'] = '6';
                ajaxData['startDate'] = startDate;
                ajaxData['endDate'] = endDate;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        
                        var data_arr = JSON.parse(data);

                        for (let i = 0; i < data_arr.length; i++) {
                            const oldDate = data_arr[i]['วันที่'];
                            const newDate = moment(oldDate, 'YYYY-MM-DD').format('DD MMM');
                            data_arr[i]['วันที่'] = newDate;
                            data_arr[i]['จำนวน'] = parseInt(data_arr[i]['จำนวน']);
                        }

                        var sum = $.pivotUtilities.aggregatorTemplates.sum;
                        var numberFormat = $.pivotUtilities.numberFormat;
                        var intFormat = numberFormat({
                            digitsAfterDecimal: 0
                        });
                        try {
                            // คอนฟิกของ Pivot Table
                            $(function() {


                                $("#output").pivot(data_arr, {
                                    rows: ["วันที่"],
                                    cols: ["ประเภทงาน"],
                                    vals: ["จำนวน"],
                                    aggregatorName: "Integer Sum",
                                });
                                var renderers = $.extend($.pivotUtilities.renderers,
                                    $.pivotUtilities.export_renderers);
                                //myPivot
                                $("#myPivot").pivotUI(data_arr, {
                                    rows: ["วันที่", "สถานะทริป"],
                                    cols: ["ประเภทงาน"],
                                    vals: ["จำนวน"],
                                    aggregatorName: "Integer Sum",
                                    renderers: renderers,
                                    rendererName: "Table"
                                });




                            });
                        } catch (e) {
                            console.error("An error occurred: ", e);
                        }


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            //btnOpenPivotTablePanel
            //$('#addLocationModal').modal('hide');
            $('body').on('click', '#btnOpenPivotTablePanel', function() {
                //console.log(TEMP_MAIN_DATA);
                $('#showPivotModal').modal('show');
            });

            function randomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1) + min);
            }

            function getRandomTimeStamps(min, max, fromDate, isObject) {
                var return_list = [];

                var entries = randomInt(min, max);
                for (var i = 0; i < entries; i++) {
                    var day = fromDate ? new Date(fromDate.getTime()) : new Date();

                    //Genrate random
                    var previous_date = randomInt(0, 365);
                    if (!fromDate) {
                        previous_date = -previous_date;
                    }
                    day.setDate(day.getDate() + previous_date);

                    if (isObject) {
                        var count = randomInt(1, 20);
                        return_list.push({
                            timestamp: day.getTime(),
                            count: count
                        });
                    } else {
                        return_list.push(day.getTime());
                    }
                }

                return return_list;

            }

            function loadDJobPerDate() {
                var ajaxData = {};
                ajaxData['f'] = '7';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        const transformedData = data_arr.map(item => {
                            return {
                                timestamp: parseInt(item.timestamp),
                                count: parseInt(item.count)
                            };
                        });
                        //console.log(transformedData);
                        //console.log(getRandomTimeStamps(50, 20, null, true));
                        $('#github_chart_1').github_graph({
                            //Generate random entries from 50-> 200 entries
                            data: transformedData,
                            texts: ['งาน', 'งาน'],
                            month_names: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                            h_days: ['จ.', 'พ.', 'ศ.'],
                            colors: [
                                'rgba(240,240,240,1)', // สีเทาอ่อน
                                'rgba(228,239,228,1)',
                                'rgba(217,238,217,1)',
                                'rgba(205,236,205,1)',
                                'rgba(194,235,194,1)',
                                'rgba(182,233,182,1)',
                                'rgba(171,232,171,1)',
                                'rgba(159,230,159,1)',
                                'rgba(148,229,148,1)',
                                'rgba(136,227,136,1)',
                                'rgba(125,226,125,1)',
                                'rgba(113,224,113,1)',
                                'rgba(102,223,102,1)',
                                'rgba(91,222,91,1)',
                                'rgba(79,220,79,1)',
                                'rgba(68,219,68,1)',
                                'rgba(56,217,56,1)',
                                'rgba(45,216,45,1)',
                                'rgba(33,214,33,1)',
                                'rgba(22,213,22,1)',
                                'rgba(10,211,10,1)' // สีเขียวเข้ม
                            ]
                        });

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            function loadDJobPerMonth() {
                var ajaxData = {};
                ajaxData['f'] = '8';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        data_arr.forEach(function(item) {
                            item.formattedYM = moment(item.YM, "YYYYMM").format("MMM YY");
                        });
                        //console.log(data_arr);

                        // chart_Month
                        var chart = am4core.create("chart_Month", am4charts.XYChart);

                        // ใส่ข้อมูล
                        chart.data = data_arr;

                        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "formattedYM";
                        categoryAxis.renderer.grid.template.location = 0;
                        categoryAxis.renderer.minGridDistance = 30;

                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                        var series = chart.series.push(new am4charts.ColumnSeries());
                        series.dataFields.valueY = "CNT";
                        series.dataFields.categoryX = "formattedYM";
                        series.name = "CNT";
                        series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
                        series.columns.template.fillOpacity = .8;
                        series.columns.template.fill = am4core.color("#A8E6CF");
                        series.columns.template.stroke = am4core.color("#A8E6CF");
                        series.columns.template.column.cornerRadiusTopLeft = 10;
                        series.columns.template.column.cornerRadiusTopRight = 10;

                        series.columns.template.column.fillOpacity = 0.8;

                        //var hoverState = series.columns.template.states.create("hover");
                        //hoverState.properties.scale = 1.1;


                        var columnTemplate = series.columns.template;
                        columnTemplate.strokeWidth = 2;
                        columnTemplate.strokeOpacity = 1;

                        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                        labelBullet.label.verticalCenter = "bottom";
                        labelBullet.label.dy = -10;
                        labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function Create_JobDailaPanelSeletion() {
                // กำหนดวันปัจจุบัน
                var currentDate = new Date();

                // สร้าง HTML สำหรับ 6 วันก่อนหน้าและ 4 วันล่วงหน้า
                var html = ""
                var activeWord = "";
                for (var i = -6; i <= 2; i++) {
                    var date = new Date(currentDate);
                    date.setDate(date.getDate() + i);

                    var dayNumber = date.getDate(); // e.g., 20
                    activeWord = "";
                    if (i == 0) {
                        activeWord = "active";
                    }
                    var day = moment(date).format('dd');
                    var dateValue = moment(date).format('YYYY-MM-DD');
                    // สร้าง HTML element สำหรับแต่ละวันที่
                    html += '<li class="nav-item p-0 ms-0">' +
                        '<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger selectJobdatebtn ' + activeWord + '" data-bs-toggle="tab" href="#show_DailyJob_panel" value=' + dateValue + '>' +
                        '<span class="fs-7 fw-semibold">' + day + '</span>' +
                        '<span class="fs-6 fw-bold">' + dayNumber + '</span>' +
                        '</a>' +
                        '</li>';

                }

                // เพิ่มลงใน UL element ใน DOM
                $('.selectdateJob').html(html);
                LoadJobDaily(moment().format('YYYY-MM-DD'))
            }

            // selectJobdatebtn
            $('body').on('click', '.selectJobdatebtn', function() {
                var target_date = $(this).attr('value');
                LoadJobDaily(target_date);
            });

            function LoadJobDaily(target_date) {
                var ajaxData = {};
                ajaxData['f'] = '9';
                ajaxData['target_date'] = target_date;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        var html = "";
                        if (data_arr.length > 0) {
                            data_arr.forEach(function(item) {
                                var jobStartTime = moment(item.jobStartDateTime).format('HH:mm');
                                var statusColor = " bg-primary";
                                if (['คนขับยืนยันจบงานแล้ว', 'จบงาน'].includes(item.status)) {
                                    statusColor = " bg-success";
                                }
                                if (['รอเจ้าหน้าที่ยืนยัน'].includes(item.status)) {
                                    statusColor = " bg-info";
                                }
                                html += `
                                    <div class="d-flex align-items-center mb-6">
                                        <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 ${statusColor}"></span>
                                        <div class="flex-grow-1 me-5">
                                            <div class="text-gray-800 fw-semibold fs-2">
                                                ${jobStartTime} <span class="text-gray-500 fw-semibold fs-7"> น. </span>
                                            </div>
                                            <div class="text-gray-700 fw-semibold fs-6">
                                                <a href="102_confirmWorkOrder.php?job_id=${item.job_id}" class="text-gray-700 fw-bold fs-5 mouse_pointer"> ${item.job_no} </a> :
                                                <span>${item.job_name}</span>
                                            </div>
                                            <div class="text-gray-500 fw-semibold fs-7">
                                                ${item.status}
                                                <a href="#" class="text-primary opacity-75-hover fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top" title="${item.contact_number}">${item.driver_name} (${item.type})</a>
                                            </div>
                                        </div>
                                        <a href="103_tripDetail.php?job_id=${item.job_id}&trip_id=${item.trip_no}" class="btn btn-sm  btn-active-primary">${item.tripNo}</a>
                                    </div>
                                `;
                            });
                        } else {
                            html = `
                                <div class="alert alert-primary d-flex align-items-center p-5">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <span>ยังไม่มีข้อมูลใบงานบันทึกลงในวันที่เลือก</span>
                                    </div>
                                </div>
                                `;
                        }


                        $('#show_DailyJob_panel').html(html);


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function generatePastelColorWithOpacity() {
                // กำหนดค่าสีพื้นฐานที่มีความสว่างสูง
                const baseLight = 170; // ค่าสีพื้นฐานที่มีความสว่างสูง
                const range = 85; // การสุ่มค่าที่จะเพิ่มเข้ากับค่าพื้นฐาน

                // สุ่มค่าสี RGB
                const r = baseLight + Math.floor(Math.random() * range);
                const g = baseLight + Math.floor(Math.random() * range);
                const b = baseLight + Math.floor(Math.random() * range);
                const opacity = 0.8; // ตั้งค่าความโปร่งแสง

                // แปลงค่าเป็นรูปแบบ rgba
                return `rgba(${r}, ${g}, ${b}, ${opacity})`;
            }


            function loadJoobDialyforGraph() {
                var ajaxData = {};
                ajaxData['f'] = '10';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        //chartDailyGrantt


                        var chart = am4core.create("chartDailyGrantt", am4charts.XYChart);
                        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                        chart.paddingRight = 30;
                        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm:ss";

                        var colorSet = new am4core.ColorSet();
                        colorSet.saturation = 0.4;
                        // ใช้ฟังก์ชัน map ของ JavaScript เพื่อเพิ่มคุณสมบัติสีให้กับแต่ละออบเจกต์ใน array
                        var chartData = data_arr.map((item, index) => {
                            // สร้างสีใหม่จาก ColorSet สำหรับแต่ละออบเจกต์ โดยใช้ index
                            var color = generatePastelColorWithOpacity();
                            // คืนค่าออบเจกต์ใหม่ที่มีคุณสมบัติ color
                            return {
                                ...item, // แพร่กระจายคุณสมบัติเดิมของออบเจกต์
                                color: color, // เพิ่มคุณสมบัติ color
                                category: item.driver_name + " (" + item.type + ")",
                            };
                        });
                        //console.log(chartData);

                        chart.data = chartData;

                        //chart.dateFormatter.dateFormat = "yyyy-MM-dd";
                        //chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

                        chart.dateFormatter.dateFormat = "yyyy-MM-dd HH:mm:ss";
                        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm:ss";

                        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "category";
                        categoryAxis.renderer.grid.template.location = 0;
                        categoryAxis.renderer.inversed = true;

                        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                        dateAxis.renderer.minGridDistance = 70;
                        dateAxis.baseInterval = {
                            count: 1,



                            timeUnit: "hour"
                        };
                        // dateAxis.max = new Date(2018, 0, 1, 24, 0, 0, 0).getTime();
                        //dateAxis.strictMinMax = true;
                        dateAxis.renderer.tooltipLocation = 0;

                        var series1 = chart.series.push(new am4charts.ColumnSeries());
                        series1.columns.template.height = am4core.percent(70);
                        //series1.columns.template.tooltipText = "{tripNo}: [bold]{openDateX}[/] - [bold]{dateX}[/]";
                        series1.columns.template.tooltipText = "{tripNo} : [bold]{jobStartDateTime.formatDate('เริ่มงาน HH:mm น.')}[/]";

                        series1.dataFields.openDateX = "Job_START";
                        series1.dataFields.dateX = "Job_END";
                        series1.dataFields.categoryY = "category";
                        series1.columns.template.propertyFields.fill = "color"; // get color from data
                        series1.columns.template.propertyFields.stroke = "color";
                        series1.columns.template.strokeOpacity = 1;

                        chart.scrollbarX = new am4core.Scrollbar();
                        // เพิ่ม event listener สำหรับคลิกคอลัมน์
                        series1.columns.template.events.on("hit", function(ev) {
                            // ดึงข้อมูลจาก data item ที่ถูกคลิก
                            var dataItem = ev.target.dataItem.dataContext;
                            var jobId = dataItem.job_id;
                            var tripId = dataItem.trip_id;

                            // สร้าง URL ที่จะนำทางไป
                            var url = `103_tripDetail.php?job_id=${jobId}&trip_id=${tripId}`;

                            // ใช้ window.open เพื่อเปิด URL ในหน้าต่างใหม่ หรือคุณสามารถใช้ window.location.href = url; เพื่อเปลี่ยนหน้าปัจจุบัน
                            window.open(url, '_blank');
                        }, this);



                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function summarizeContainerSizes(tripData) {
                var containerSummary = {};

                tripData.forEach(function(trip) {
                    var containerSize = trip.containersize;
                    if (!containerSummary[containerSize]) {
                        containerSummary[containerSize] = 0;
                    }
                    containerSummary[containerSize] += 1;
                });

                var summaryText = Object.keys(containerSummary).map(function(size) {
                    return containerSummary[size] + 'x' + size;
                }).join(', ');

                return summaryText;
            }

            function sumContainerWeight(trip_data) {
                const totalWeight = trip_data.reduce((sum, trip) => {
                    const weight = parseFloat(trip.containerWeight);
                    return sum + (isNaN(weight) ? 0 : weight);
                }, 0);

                // Format number to not have decimals and include comma as thousand separator
                return totalWeight.toLocaleString('en-US', {
                    maximumFractionDigits: 0
                });
            }


            function loadDailyBoard(startDate, endDate) {
                var ajaxData = {};
                ajaxData['f'] = '11';
                ajaxData['startDate'] = startDate;
                ajaxData['endDate'] = endDate;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/index/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        print_text = "";
                        data_arr.forEach(function(item) {
                            let sizeOfJob = summarizeContainerSizes(item.trip_data);
                            let weightOfJob = sumContainerWeight(item.trip_data);
                            print_text += "<TR>";
                            print_text += "<TD><a href='102_confirmWorkOrder.php?job_id=" + item.id + "'>" + item.job_name + "</a></TD>";
                            print_text += "<TD>" + sizeOfJob + "</TD>";
                            print_text += '<TD> <div class="text-danger fw-semibold fs-7">' + weightOfJob + '</div></TD>';

                            // Generate Trip Text
                            let tripText = "";
                            item.trip_data.forEach(function(tripData) {
                                let driver_name = tripData.driver_name;
                                if (tripData.driver_name.length > 8) {
                                    driver_name = tripData.driver_name.substring(0, 8) + "..";
                                }

                                let badge_color = " badge-light-primary";
                                if (tripData.PCT == 0) {
                                    badge_color = " badge-light-danger";
                                } else if (tripData.PCT == 100) {
                                    badge_color = " badge-light-success";
                                } else {
                                    driver_name += "" + Intl.NumberFormat().format(tripData.PCT) + "%"
                                }
                                tripText += '<span class="badgeTrip_Daily mouse_pointer badge ' + badge_color + ' badge me-2" job_id="' + tripData.job_id + '" trip_id="' + tripData.trip_id + '">' + driver_name + '</span>';
                            });
                            print_text += "<TD>" + tripText + "</TD>";
                            print_text += "</TR>";
                        });
                        //่JobDailyProgressTable
                        $("#่JobDailyProgressTable").html(print_text);

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // badgeTrip_Daily
            $('body').on('click', '.badgeTrip_Daily', function() {
                var job_id = $(this).attr('job_id');
                var trip_id = $(this).attr('trip_id');
                window.open("103_tripDetail.php?job_id=" + job_id + "&trip_id=" + trip_id + "", "_blank");
            });




            // Initial Run When start ===============================================================
            //Initialcalendar();
            loadProgress();
            loadCalendar();
            LoadMonthlyByClient();
            LoadJobWorkLoad();
            getThisMonthPaymenteachDriver();
            LoadDataforPrivotTable(moment().startOf('month').format("YYYY-MM-DD"),moment().endOf('month').format("YYYY-MM-DD"));
            loadDJobPerDate();
            loadDJobPerMonth();
            Create_JobDailaPanelSeletion();
            loadJoobDialyforGraph();
            loadDailyBoard(moment().format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>