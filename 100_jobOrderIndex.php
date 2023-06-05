<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>รายการใบงาน</title>
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
                                            <table class="table table-bordered table-hover table-striped w-100 d-none" id="jobTable">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                    <tr>
                                                        <th class="font-weight-bold text-center">เลข Job</th>
                                                        <th class="font-weight-bold text-center">วันที่</th>
                                                        <th class="font-weight-bold text-center" data-bs-toggle="tooltip" title="แสดงข้อมูลเวลาเริ่มของของทริปแรกของใบงาน">วันปฏิบัติงาน</th>
                                                        <th class="font-weight-bold text-center">ประเภทงาน</th>
                                                        <th class="font-weight-bold text-center">ชื่องาน</th>
                                                        <th class="font-weight-bold text-center">ชื่อลูกค้า</th>
                                                        <th class="font-weight-bold text-center">เอกสารอ้างอิง</th>
                                                        <th class="font-weight-bold text-center">สถานะ</th>
                                                        <th class="font-weight-bold text-center"></th>
                                                    </tr>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                    $sql = "SELECT a.*, b.jobStartDateTime FROM job_order_header a 
                                                    Left Join (SELECT a.job_id, a.jobStartDateTime FROM job_order_detail_trip_info a
                                                    group By a.job_id) b ON a.id = b.job_id
                                                    Order By a.id DESC";



                                                    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
                                                    $result = mysqli_query($conn, $sql);
                                                    // ปิดการเชื่อมต่อฐานข้อมูล
                                                    mysqli_close($conn);

                                                    // ถ้ามีข้อมูล
                                                    if ($result->num_rows > 0) {
                                                        // วนลูปผ่านแต่ละแถวของผลลัพธ์
                                                        while ($row = $result->fetch_assoc()) {


                                                            $refDoc_Data = ""; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
                                                            // ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
                                                            $customerJobNo = $row['customer_job_no'];
                                                            if (!empty($customerJobNo)) {
                                                                $refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "<br>";
                                                            }

                                                            $booking = $row['booking'];
                                                            if (!empty($booking)) {
                                                                $refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "<br>";
                                                            }

                                                            $customerPoNo = $row['customer_po_no'];
                                                            if (!empty($customerPoNo)) {
                                                                $refDoc_Data .= "PO No.: " . $customerPoNo . "<br>";
                                                            }

                                                            $billOfLading = $row['bill_of_lading'];
                                                            if (!empty($billOfLading)) {
                                                                $refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "<br>";
                                                            }

                                                            $customerInvoiceNo = $row['customer_invoice_no'];
                                                            if (!empty($customerInvoiceNo)) {
                                                                $refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "<br>";
                                                            }

                                                            $agent = $row['agent'];
                                                            if (!empty($agent)) {
                                                                $refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "<br>";
                                                            }

                                                            $goods = $row['goods'];
                                                            if (!empty($goods)) {
                                                                $refDoc_Data .= "ชื่อสินค้า: " . $goods . "<br>";
                                                            }

                                                            $quantity = $row['quantity'];
                                                            if (!empty($quantity)) {
                                                                $refDoc_Data .= "QTY/No. of Package: " . $quantity . "<br>";
                                                            }

                                                            // แสดงผลลงในแต่ละ <td> ด้วยการใช้ echo
                                                            echo '<tr>';
                                                            echo '<td class="font-weight-bold text-center">' . $row["job_no"] . '</td>';
                                                            //echo '<td class="font-weight-bold text-center">' . $row["job_date"] . '</td>';
                                                            echo "<td class='text-center'><span class='dateFormatter'>{$row['job_date']}</span></td>";
                                                            echo "<td class='text-center'><span class='datetimeFormatter'>{$row['jobStartDateTime']}</span></td>";
                                                            echo '<td class="font-weight-bold text-center">' . $row["job_type"] . '</td>';
                                                            echo '<td>' . $row["job_name"] . '</td>';
                                                            echo '<td>' . $row["client_name"] . '</td>';
                                                            echo '<td>' . $refDoc_Data . '</td>';
                                                            // ตรวจสอบสถานะ
                                                            $status = $row["status"];
                                                            $statusBadge = "";
                                                            $statusColor = "";

                                                            switch ($status) {
                                                                case "Draft":
                                                                    $statusBadge = "รอเจ้าหน้าที่ยืนยัน";
                                                                    $statusColor = "badge bg-primary";
                                                                    break;
                                                                case "กำลังดำเนินการ":
                                                                    $statusBadge = "กำลังดำเนินการ";
                                                                    $statusColor = "badge bg-warning text-dark";
                                                                    break;
                                                                case "เสร็จสิ้น":
                                                                    $statusBadge = "เสร็จสิ้น";
                                                                    $statusColor = "badge bg-success";
                                                                    break;
                                                                case "ยกเลิก":
                                                                    $statusBadge = "ยกเลิก";
                                                                    $statusColor = "badge bg-danger";
                                                                    break;
                                                                default:
                                                                    $statusBadge = $status;
                                                                    $statusColor = "badge bg-primary";
                                                                    break;
                                                            }

                                                            echo '<td class="text-center"><span class="badge ' . $statusColor . '">' . $statusBadge . '</span></td>';

                                                            echo '<td class="text-center">';
                                                            echo '<div class="btn-group">';
                                                            echo '<a type="button" href="102_confirmWorkOrder.php?job_id=' . $row['id'] . '" class="btn btn-sm btn-secondary btnDriverView"><i class="fa fa-eye"> </i> รายละเอียด</a>';
                                                            echo '</div>';
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
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