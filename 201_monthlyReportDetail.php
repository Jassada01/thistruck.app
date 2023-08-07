<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
$selectMonth = date('mY');
if (isset($_GET['selectMonth'])) {
    $selectMonth = $_GET['selectMonth'];
}
?>

<head>
    <title>รายงานประจำเดือน(รายทริป) <?php echo $selectMonth; ?></title>
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
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

    <!--end::Global Stylesheets Bundle-->
    <style>
        th {
            white-space: nowrap;
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">รายงานประจำเดือน(รายทริป) </h1>
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
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">รายงานประจำเดือน(รายทริป) </li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">
                                <select class="form-select form-select-solid" id="selectMonth">
                                </select>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid d-flex align-items-stretch justify-content-between" >
                            <!--begin::Row-->
                            <div class="row gy-5 g-xl-8">
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-layers fs-3"></i> รายงานประจำเดือน(รายทริป) - <?php echo $selectMonth; ?></h1>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php
                                            // เชื่อมต่อฐานข้อมูล
                                            include "function/connectionDb.php";

                                            // ส่วนของการดึงข้อมูลจากฐานข้อมูล
                                            /*
                                                    if ($inactive) {
                                                        $sql = "SELECT a.id, a.job_no, a.job_date, a.job_type, a.job_name, a.client_name, a.status FROM job_order_header a Order By id DESC";
                                                    } else {
                                                        $sql = "SELECT a.id, a.job_no, a.job_date, a.job_type, a.job_name, a.client_name, a.status 
                                                        FROM job_order_header a 
                                                        WHERE a.status NOT IN ('ยกเลิก', 'เสร็จสิ้น')
                                                        ORDER BY a.id DESC
                                                        ";
                                                    }
                                                    */
                                                $sql = "SELECT 
                                                a.id AS Job_id,
                                                a.job_no AS 'เลข Job', 
                                                a.job_date as 'วันที่', 
                                                a.job_type as 'ประเภทงาน', 
                                                a.job_name as 'ชื่องาน', 
                                                a.client_name as 'ผู้ว่าจ้าง', 
                                                a.customer_name as 'ชื่อลูกค้า', 
                                                a.customer_job_no as 'Job NO ของลูกค้า', 
                                                a.customer_po_no as 'PO No.', 
                                                a.customer_invoice_no as 'Invoice No.', 
                                                a.goods as 'ชื่อสินค้า', 
                                                a.booking as 'Booking (บุ๊กกิ้ง)', 
                                                a.bill_of_lading as 'B/L(ใบขน)', 
                                                a.agent as 'Agent(เอเย่นต์)', 
                                                a.quantity as 'QTY/No. of Package', 
                                                a.remark as 'หมายเหตุ', 
                                                a.status as 'สถานะ', 
                                                b.tripSeq AS 'ทริป',
                                                b.id AS Trip_id,
                                                b.tripNo AS 'เลขที่งาน', 
                                                b.truck_licenseNo AS 'ทะเบียน', 
                                                b.driver_name AS 'พขร', 
                                                b.containerID AS 'เลขตู้', 
                                                b.seal_no AS 'เลขซีล', 
                                                b.containerWeight AS 'น้ำหนักตู้', 
                                                CASE WHEN b.subcontrackCheckbox = 1 THEN '/' ELSE '' END AS 'ซับ', 
                                                b.truckType AS 'ประเภทรถ', 
                                                c.hire_price AS 'ราคางาน', 
                                                c.overtime_fee AS 'ค่าล่วงเวลา', 
                                                c.port_charge AS 'ค่าผ่านท่า', 
                                                c.yard_charge AS 'ค่าผ่านลาน', 
                                                c.container_return AS 'ค่ารับตู้/คืนตู้', 
                                                c.container_cleaning_repair AS 'ค่าซ่อมตู้', 
                                                c.container_drop_lift AS 'ค่าล้างตู้', 
                                                c.expenses_1 AS 'ค่าชอร์(SHORE)', 
                                                c.other_charge AS 'ค่าใช้จ่ายอื่นๆ', 
                                                c.remark AS 'คำอธิบายค่าใช้จ่ายอื่นๆ', 
                                                c.deduction_note AS 'ใบหัก ณ ที่จ่ายกระทำแทน', 
                                                c.total_expenses AS 'ค่าใช้จ่ายรวมทั้งหมด', 
                                                c.wage_travel_cost AS 'ค่าเดินทาง/ค่าเที่ยว', 
                                                c.vehicle_expenses AS 'ค่าใช้จ่ายรถ', 
                                                b.jobStartDateTime AS 'เวลาเริ่มงาน', 
                                                b.status AS 'สถานะทริป' 
                                              FROM 
                                                job_order_header a 
                                                LEFT JOIN job_order_detail_trip_info b ON a.id = b.job_id 
                                                LEFT JOIN job_order_detail_trip_cost c ON b.id = c.trip_id 
                                              WHERE 
                                              a.id in (SELECT za.job_id FROM job_order_detail_trip_info za
                                                        WHERE DATE_FORMAT(za.jobStartDateTime, '%m%Y') = '$selectMonth'
                                                        AND za.status <> 'ยกเลิก'
                                                        GROUP BY za.job_id)
                                                AND a.status <> 'ยกเลิก' 
                                              Order By 
                                                a.id;";



                                            // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
                                            $result = mysqli_query($conn, $sql);


                                            // ปิดการเชื่อมต่อฐานข้อมูล
                                            mysqli_close($conn);

                                            if ($result->num_rows > 0) {
                                                echo "<table class='table table-bordered table-hover table-striped w-100  gy-1 gs-1 ' id='dataTable'>";

                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    // create table header only for the first row (where the table is not yet created)
                                                    if (!isset($tableHeaderCreated)) {
                                                        echo "<thead class='bg-primary text-white'>";
                                                        echo "<tr>";
                                                        foreach ($row as $header => $value) {
                                                            echo "<th>" . htmlspecialchars($header) . "</th>";
                                                        }
                                                        echo "</tr>";
                                                        echo "</thead>";
                                                        echo "<tbody>";
                                                        $tableHeaderCreated = true;
                                                    }

                                                    echo "<tr>";
                                                    foreach ($row as $header => $value) {
                                                        if ($header == "เลข Job") {
                                                            echo "<td><a href='102_confirmWorkOrder.php?job_id=" . $row['Job_id'] . "'>" . htmlspecialchars($value) . "</a></td>";
                                                        } 
                                                        else if ($header == "เลขที่งาน") {
                                                            echo "<td><a href='103_tripDetail.php?job_id=" . $row['Job_id'] . "&trip_id=" . $row['Trip_id'] . "'>" . htmlspecialchars($value) . "</a></td>";
                                                        }else {
                                                            if ($value == 0 || $value == "0.00") {
                                                                echo "<td>" . "" . "</td>";
                                                            } else {
                                                                echo "<td>" . htmlspecialchars($value) . "</td>";
                                                            }
                                                        }
                                                    }
                                                    echo "</tr>";
                                                }
                                                echo "</tbody>";
                                                echo "</table>";
                                            } else {
                                                echo "0 results";
                                            }

                                            ?>

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

    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
            // Set Moment 
            moment.locale('th');
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
                },
            });


            var selectMonth = $("#selectMonth");
            var selectedValue = "<?php echo $selectMonth; ?>";

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
                    selectMonth.append(option);

                    if (year === 2023 && month === 1) {
                        break;
                    }
                }

                if (year === 2023 && month === 1) {
                    break;
                }
            }

            if (selectedValue && selectedValue !== "") {
                // เลือกตัวเลือกที่มีค่าตรงกับ SelectedValue
                selectMonth.val(selectedValue);
            }

            // เมื่อมีการเปลี่ยนค่าใน Select
            selectMonth.on("change", function() {
                var selectedValue = $(this).val();

                // เปลี่ยนหน้าเพจไปที่ 200_monthlyReport.php พร้อมกับส่งพารามิเตอร์ selectMonth
                window.location.href = "201_monthlyReportDetail.php?selectMonth=" + selectedValue;
            });




            //$("#dataTable").DataTable();
            var datatable = $('#dataTable').DataTable({
                "info": false,
                autoWidth: false,
                wrap: false,
                'order': [],
                'pageLength': 10,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'Export Excel',
                    className: 'btn btn-success',
                    init: function(api, node, config) {
                        $(node).removeClass('dt-button').html('<i class="far fa-file-excel"></i> ' + config.text);
                    }
                }],

                lengthMenu: [10, 25, 50, 100], // ตัวเลือกในการกำหนดจำนวนแถวที่แสดงในหน้าเดียว
            });

            // selectMonth





            $('.dateFormatter').each(function() {
                var dateString = $(this).text();
                //var formattedDate = moment(dateString, 'D MMM YYYY', 'th').format('D MMM YYYY');
                var formattedDate = moment(dateString).format('D MMM YYYY');
                var diffDays = moment().diff(moment(formattedDate, 'D MMM YYYY', 'th'), 'days');
                //if (Math.abs(diffDays) < 90) {
                //    $(this).addClass('text-danger fw-bold');
                //}
                $(this).text(formattedDate);
            });

            $('.datetimeFormatter').each(function() {
                var dateString = $(this).text();
                //var formattedDate = moment(dateString, 'D MMM YYYY', 'th').format('D MMM YYYY');
                var formattedDate = moment(dateString).format('D MMM YY HH:mm');
                //if (Math.abs(diffDays) < 90) {
                //    $(this).addClass('text-danger fw-bold');
                //}
                $(this).text(formattedDate);
            });






        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>