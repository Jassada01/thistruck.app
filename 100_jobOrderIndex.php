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
                $dateStart = "";
                $dateEnd = "";

                if (isset($_GET['start'])) {
                    $dateStart = $_GET['start'];
                }
                if (isset($_GET['end'])) {
                    $dateEnd = $_GET['end'];
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
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped w-100 d-none" id="jobTable">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="font-weight-bold text-center"></th>
                                                        <th class="font-weight-bold text-center"><B>เลข Job</B></th>
                                                        <th class="font-weight-bold text-center"><B>สถานะ</B></th>
                                                        <th class="font-weight-bold text-center"><B>วันที่</B></th>
                                                        <th class="font-weight-bold text-center"><B>ชื่องาน</B></th>
                                                        <th class="font-weight-bold text-center" data-bs-toggle="tooltip" title="แสดงข้อมูลเวลาเริ่มของของทริปแรกของใบงาน"><B>วันปฏิบัติงาน</B></th>
                                                        <th class="font-weight-bold text-center"><B>ประเภทงาน</B></th>
                                                        <th class="font-weight-bold text-center"><B>ชื่อลูกค้า</B></th>
                                                        <th class="font-weight-bold text-center"><B>เอกสารอ้างอิง</B></th>
                                                        <th class="font-weight-bold text-center"><B>Size</B></th>
                                                        <th class="font-weight-bold text-center"><B>หมายเลขตู้สินค้า</B></th>
                                                        <th class="font-weight-bold text-center"><B>เลขที่อินวอยซ์</B></th>
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
                                                    /*
                                                    $sql = "SELECT 
                                                    a.*, 
                                                    b.jobStartDateTime, 
                                                    b.containerID 
                                                  FROM 
                                                    job_order_header a 
                                                    Left Join (
                                                      SELECT 
                                                        a.job_id, 
                                                        a.jobStartDateTime, 
                                                        REPLACE(
                                                          GROUP_CONCAT(
                                                            IF(
                                                              a.containerID = '', NULL, a.containerID
                                                            ) SEPARATOR ','
                                                          ), 
                                                          ',', 
                                                          '<br>'
                                                        ) AS containerID 
                                                      FROM 
                                                        job_order_detail_trip_info a 
                                                      GROUP BY 
                                                        a.job_id
                                                    ) b ON a.id = b.job_id 
                                                  Order By 
                                                    a.id DESC;
                                                  ";
                                                  */
                                                    if ($dateStart == "") {
                                                        $sql = "SELECT 
                                                            a.*, 
                                                            b.jobStartDateTime, 
                                                            b.containerID, 
                                                            CASE WHEN d.document_number IS NULL 
                                                            AND d.id IS NOT NULL THEN 'ยังไม่กำหนด' WHEN d.id IS NULL THEN '' ELSE d.document_number END AS invoiceNo,
                                                            d.id as INVID,
                                                            e.size
                                                        FROM 
                                                            job_order_header a 
                                                            Left Join (
                                                            SELECT 
                                                                a.job_id, 
                                                                a.jobStartDateTime, 
                                                                REPLACE(
                                                                GROUP_CONCAT(
                                                                    IF(
                                                                    a.containerID = '', NULL, a.containerID
                                                                    ) SEPARATOR ','
                                                                ), 
                                                                ',', 
                                                                '<br>'
                                                                ) AS containerID 
                                                            FROM 
                                                                job_order_detail_trip_info a 
                                                            GROUP BY 
                                                                a.job_id
                                                            ) b ON a.id = b.job_id 
                                                            LEFT JOIN invoice_job_mapping c ON a.id = c.job_id AND c.attr = 'ใช้งาน'
                                                            LEFT JOIN invoice_header d ON c.invoice_id = d.id AND d.attr1 = 'ใช้งาน'
                                                            LEFT Join job_order_summary_view  e ON a.id = e.id
                                                        Order By 
                                                            a.id DESC;
                                                        ";
                                                    } else {
                                                        $sql = "SELECT 
                                                            a.*, 
                                                            b.jobStartDateTime, 
                                                            b.containerID, 
                                                            CASE WHEN d.document_number IS NULL 
                                                            AND d.id IS NOT NULL THEN 'ยังไม่กำหนด' WHEN d.id IS NULL THEN '' ELSE d.document_number END AS invoiceNo,
                                                            d.id as INVID,
                                                            e.size
                                                        FROM 
                                                            job_order_header a 
                                                            Left Join (
                                                            SELECT 
                                                                a.job_id, 
                                                                a.jobStartDateTime, 
                                                                REPLACE(
                                                                GROUP_CONCAT(
                                                                    IF(
                                                                    a.containerID = '', NULL, a.containerID
                                                                    ) SEPARATOR ','
                                                                ), 
                                                                ',', 
                                                                '<br>'
                                                                ) AS containerID 
                                                            FROM 
                                                                job_order_detail_trip_info a 
                                                            GROUP BY 
                                                                a.job_id
                                                            ) b ON a.id = b.job_id 
                                                            LEFT JOIN invoice_job_mapping c ON a.id = c.job_id AND c.attr = 'ใช้งาน'
                                                            LEFT JOIN invoice_header d ON c.invoice_id = d.id AND d.attr1 = 'ใช้งาน'
                                                            LEFT Join job_order_summary_view  e ON a.id = e.id
                                                            WHERE b.jobStartDateTime BETWEEN '$dateStart 00:00' AND '$dateEnd 23:59'
                                                        Order By 
                                                            a.id DESC;
                                                        ";
                                                    }




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

                                                            // แสดงผลลงในแต่ละ <td> ด้วยการใช้ echo
                                                            echo '<tr>';
                                                            echo '<td class="text-center dt-control" data-jobID="' . $row['id'] . '"></td>';
                                                            //echo '<td class="font-weight-bold text-center">' . $row["job_no"] . '</td>';
                                                            echo '<td class="font-weight-bold text-center"><a href="102_confirmWorkOrder.php?job_id=' . $row['id'] . '">' . $row["job_no"] . '</a></td>';


                                                            echo '<td class="text-center"><span class="badge ' . $statusColor . '">' . $statusBadge . '</span></td>';
                                                            //echo '<td class="font-weight-bold text-center">' . $row["job_date"] . '</td>';

                                                            echo "<td class='text-center'><span class='dateFormatter'>{$row['job_date']}</span></td>";

                                                            echo '<td>' . $row["job_name"] . '</td>';
                                                            echo "<td class='text-center'><span class='datetimeFormatter'>{$row['jobStartDateTime']}</span></td>";
                                                            echo '<td class="font-weight-bold text-center">' . $row["job_type"] . '</td>';
                                                            echo '<td>' . $row["client_name"] . '</td>';
                                                            echo '<td>' . $refDoc_Data . '</td>';
                                                            echo '<td class="font-weight-bold text-center">' . $row["size"] . '</td>';
                                                            echo '<td class="font-weight-bold text-center">' . $row["containerID"] . '</td>';
                                                            echo '<td class="font-weight-bold text-center"><a href="072_preformInvoice.php?invoice_id=' . $row['INVID'] . '" target="_blank">' . $row["invoiceNo"] . '</a></td>';

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

            let startDate = "<?php echo $dateStart;?>";
            let endDate = "<?php echo $dateEnd;?>";
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

            function generateRandomString(length) {
                var result = '';
                var characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                var charactersLength = characters.length;

                for (var i = 0; i < length; i++) {
                    var randomIndex = Math.floor(Math.random() * charactersLength);
                    result += characters.charAt(randomIndex);
                }

                return result;
            }




            function formatDetailTable(rndStr) {
                // `d` is the original data object for the row
                var temp = '';
                temp += '<div class="table-responsive table-loading mt-1 ms-10 me-1 mb-3" id="' + rndStr + '">';
                temp += '<i class="fas fa-circle-notch fa-spin"></i>';
                temp += '<span class="loading-text  ms-2">กำลังโหลดข้อมูล...</span>';
                temp += '</div>';
                return (temp);
            }

            let jobTable = $("#jobTable").DataTable({

                search: {
                    return: true,
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                },
                order: [
                        [1, "desc"]
                    ] // เรียงลำดับตามคอลัมน์แรก (index 0) ในลำดับ DESC
                    ,

                "pageLength": 50 // กำหนดให้แสดงแถวต่อหน้าเริ่มต้นที่ 50 แถว

            });
            jobTable.on('draw', function() {
                $('#jobTable').removeClass('d-none');
            });

            // Add event listener for opening and closing details
            $('#jobTable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = jobTable.row(tr);
                var jobId = tr.find('td:nth-child(1)').data('jobid');
                //console.log(jobId);
                var randomStr = generateRandomString(10);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(formatDetailTable(randomStr)).show();
                    loadTrip_DetailforViewIndex(jobId, randomStr);
                    tr.addClass('shown');
                }
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
                var formattedDate = moment(dateString).format('D MMM');
                var diffDays = moment().diff(moment(formattedDate, 'D MMM', 'th'), 'days');
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


            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'วันนี้': [moment(), moment()],
                        'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'พรุ่งนี้': [moment().subtract(-1, 'days'), moment().subtract(-1, 'days')],
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
                function(start, end, ranges) {
                    //$('#daterange-btn span').html(start.format(' D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'))
                    //loadJobHeader(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                    //console.log(start.format('YYYY-MM-DD'));
                    //console.log(end.format('YYYY-MM-DD'));
                    window.location.href = '100_jobOrderIndex.php?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD');
                    //get_page_data_from_range(start.format(' YYYY-MM-DD'), end.format(' YYYY-MM-DD'));
                }
            )

            if (startDate != "")
            {
                $("#calendarLabel").html(moment(startDate).format('D MMMM YYYY') + " - " + moment(endDate).format('D MMMM YYYY'))
            }

            function loadTrip_DetailforViewIndex(job_id, target_div) {
                var ajaxData = {};
                ajaxData['f'] = '17';
                ajaxData['job_id'] = job_id;
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
                            var tripNo = $('<td></td>').html('<a href="103_tripDetail.php?job_id=' + rowData.job_id + '&trip_id=' + rowData.id + '">' + rowData.tripNo + '</a>');
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
                        }

                        // เพิ่ม thead และ tbody ลงในตาราง
                        table.append(thead);
                        table.append(tbody);

                        // เพิ่มตารางลงใน div สำหรับการแสดงผล
                        tableContainer.append(table);

                        // เพิ่ม div ที่มีตารางลงในหน้าเอกสาร
                        $("#" + target_div).html(tableContainer);

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }





        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>