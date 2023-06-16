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
    <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />


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
                            <div class="row gy-5 g-xl-8">
                                <div class="col-sm-8">
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
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>



    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
            // Set Moment 
            moment.locale('th');



            // Initial Setting =======================
            am4core.useTheme(am4themes_animated);


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
                            initial_tripNo = data.tripNo;

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
                var startColor = [255, 110, 127]; // #ff6e7f (สีแดง)
                var endColor = [191, 233, 255]; // #2948ff

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

                        // สร้าง events จาก data_arr
                        for (var i = 0; i < data_arr.length; i++) {
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
                                event.color = "#4287f5"; // กำหนดสีน้ำเงินเข้ม หาก complete_flag เป็น null
                            } else if (completeFlag === -1) {
                                event.color = "#f54242"; // กำหนดสีแดงเข้ม หาก complete_flag เป็น -1
                            } else {
                                event.color = "#5ac25a"; // กำหนดสีเขียวเข้ม หาก complete_flag ไม่ใช่ null และไม่ใช่ -1
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
                        console.log(data_arr);

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
                        series.columns.template.column.cornerRadiusBottomRight  = 10;

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
            // Initial Run When start ===============================================================
            //Initialcalendar();
            loadProgress();
            loadCalendar();
            LoadMonthlyByClient();
            LoadJobWorkLoad();


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>