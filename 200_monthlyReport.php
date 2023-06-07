<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>รายงานประจำเดือน</title>
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

    <!--end::Global Stylesheets Bundle-->
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">รายการใบงาน</h1>
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
                                    <li class="breadcrumb-item text-dark">รายการใบงาน</li>
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
                                <a href="101_createWorkOrder.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> สร้างใบงาน</a>
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
                                            <h1><i class="bi bi-layers fs-3"></i> รายการใบงาน</h1>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="form-check d-none">
                                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?php echo $checkword; ?>>
                                                <label class="form-check-label" for="active">เฉพาะรายการที่ยังใช้งาน</label>
                                            </div>
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
                                            // Query to get all container_sizes
                                            $container_sizes = "SELECT name FROM master_data WHERE type = 'container_size'";
                                            $result = $conn->query($container_sizes);

                                            if ($result->num_rows > 0) {
                                                // Create SQL script with dynamic SUM(CASE WHEN containersize = '...' THEN 1 ELSE 0 END) AS '...' fields
                                                $sum_cases = "";
                                                while ($row = $result->fetch_assoc()) {
                                                    $container_size = $row["name"];
                                                    $sum_cases .= "SUM(CASE WHEN containersize = '$container_size' THEN 1 ELSE 0 END) AS `$container_size`, ";
                                                }

                                                // Add SUM(CASE WHEN ...) for 'ไม่ระบุ' after all container_sizes
                                                $sum_cases .= "SUM(CASE WHEN containersize IS NULL OR containersize = '' THEN 1 ELSE 0 END) AS `ไม่ระบุ`, ";

                                                // Add count for all containersize (including 'ไม่ระบุ')
                                                $sum_cases .= "COUNT(containersize) AS `รวมทั้งหมด`";
                                                $sumCasesql = "
                                                            SELECT 
                                                                job_id, 
                                                                job_no, 
                                                                $sum_cases
                                                            FROM 
                                                                job_order_detail_trip_info
                                                            GROUP BY 
                                                                job_id, job_no ";

                                                $sql = "SELECT 
                                                    b.*, 
                                                    a.job_date as 'วันที่', 
                                                    a.job_type as 'ประเภทงาน', 
                                                    a.job_name  as 'ชื่องาน', 
                                                    a.client_name  as 'ผู้ว่าจ้าง', 
                                                    a.customer_name  as 'ชื่อลูกค้า', 
                                                    a.customer_job_no  as 'Job NO ของลูกค้า', 
                                                    a.customer_po_no as 'PO No.', 
                                                    a.customer_invoice_no as 'Invoice No.', 
                                                    a.goods  as 'ชื่อสินค้า', 
                                                    a.booking  as 'Booking (บุ๊กกิ้ง)', 
                                                    a.bill_of_lading  as 'B/L(ใบขน)', 
                                                    a.agent  as 'Agent(เอเย่นต์)', 
                                                    a.quantity  as 'QTY/No. of Package', 
                                                    a.remark  as 'หมายเหตุ', 
                                                    a.status  as 'สถานะ', 
                                                    c.* 
                                                  FROM 
                                                    job_order_header a 
                                                    Left join ($sumCasesql) b ON a.id = b.job_id 
                                                    Left Join (
                                                      SELECT 
                                                        job_id, 
                                                        SUM(hire_price) AS 'ราคางาน', 
                                                        SUM(overtime_fee) AS 'ค่าล่วงเวลา', 
                                                        SUM(port_charge) AS 'ค่าผ่านท่า', 
                                                        SUM(yard_charge) AS 'ค่าผ่านลาน', 
                                                        SUM(container_return) AS 'ค่ารับตู้/คืนตู้', 
                                                        SUM(container_cleaning_repair) AS 'ค่าซ่อมตู้', 
                                                        SUM(container_drop_lift) AS 'ค่าล้างตู้', 
                                                        SUM(other_charge) AS 'ค่าใช้จ่ายอื่นๆ', 
                                                        SUM(deduction_note) AS 'ใบหัก ณ ที่จ่ายกระทำแทน', 
                                                        SUM(total_expenses) AS 'ค่าใช้จ่ายรวมทั้งหมด', 
                                                        SUM(wage_travel_cost) AS 'ค่าเดินทาง/ค่าเที่ยว', 
                                                        SUM(vehicle_expenses) AS 'ค่าใช้จ่ายรถ' 
                                                      FROM 
                                                        job_order_detail_trip_cost 
                                                      GROUP BY 
                                                        job_id
                                                    ) c ON a.id = c.job_id 
                                                  Where 
                                                    DATE_FORMAT(a.job_date, '%m%Y') = '062023' 
                                                    AND a.status <> 'ยกเลิก' 
                                                  Order By 
                                                    a.id LIMIT 1 ";

                                                //echo  $sql;
                                            } else {
                                                echo "0 results";
                                            }


                                            // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
                                            $result = mysqli_query($conn, $sql);

                                            echo "<table class='table table-bordered table-hover table-striped w-100' id='reportDable'>";

                                            // Fetch the result of the query
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                // If we haven't printed the header row yet, do so
                                                if (!isset($headerPrinted)) {
                                                    echo "<tr>";
                                                    foreach ($row as $fieldName => $value) {
                                                        echo "<th>$fieldName</th>";
                                                    }
                                                    echo "</tr>";
                                                    $headerPrinted = true;
                                                }

                                                // Print each data row
                                                echo "<tr>";
                                                foreach ($row as $value) {
                                                    echo "<td>$value</td>";
                                                }
                                                echo "</tr>";
                                            }

                                            echo "</table>";

                                            // ปิดการเชื่อมต่อฐานข้อมูล
                                            mysqli_close($conn);



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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
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


            let clientTable = $("#reportDable").DataTable({
                search: {
                    return: true,
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                },
                "pageLength": 50 // กำหนดให้แสดงแถวต่อหน้าเริ่มต้นที่ 50 แถว
            });



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