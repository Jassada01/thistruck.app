<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
    include 'system_config.php';
    $CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
    include 'check_cookie.php';
?>
<head>
    <title>ข้อมูลลูกค้า</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-k9cPbgC07G16z+6Uf2n/lZi6uhgYbYzgBPOpUPP9dmO/M5ONPXHYKm3mJxEZiE+w5r5BzK5QdL5YSX9RbKMDaA==" crossorigin="anonymous" />
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">ฐานข้อมูลลูกค้า</h1>
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
                                    <li class="breadcrumb-item text-dark">ฐานข้อมูลลูกค้า</li>
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
                                <a href="012_customerAdd.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> เพิ่มข้อมูลลูกค้า</a>
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
                                            <h1><i class="bi bi-person-badge-fill fs-3"></i> รายการลูกค้า</h1>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?php echo $checkword; ?>>
                                                <label class="form-check-label" for="active">เฉพาะรายการที่ยังใช้งาน</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped w-100 d-none" id="customerTable">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="font-weight-bold text-center">รหัสลูกค้า</th>
                                                        <th class="font-weight-bold text-center">ชื่อลูกค้า</th>
                                                        <th class="font-weight-bold text-center">สาขา</th>
                                                        <th class="font-weight-bold text-center">ผู้ติดต่อ</th>
                                                        <th class="font-weight-bold text-center">เบอร์โทรผู้ติดต่อ</th>
                                                        <th class="font-weight-bold text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // เชื่อมต่อฐานข้อมูล
                                                    include "function/connectionDb.php";
                                                    // สร้างคำสั่ง SQL สำหรับดึงข้อมูลลูกค้าทั้งหมด


                                                    if ($inactive) {
                                                        $sql = "SELECT customer_id, customer_code, customer_name, branch, contact_1, phone_1, active FROM customers";
                                                    } else {
                                                        $sql = "SELECT customer_id, customer_code, customer_name, branch, contact_1, phone_1, active  FROM customers where active = 1";
                                                    }

                                                    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
                                                    $result = mysqli_query($conn, $sql);
                                                    // ปิดการเชื่อมต่อฐานข้อมูล
                                                    mysqli_close($conn);

                                                    // วนลูปเพื่อดึงข้อมูลและแสดงผลในตาราง
                                                    if ($result->num_rows > 0) {
                                                        // แสดงข้อมูลลูกค้าที่ดึงมาในแต่ละแถวของตาราง
                                                        while ($row = $result->fetch_assoc()) {

                                                            $nonActive = "";
                                                            if ($row["active"] != '1') {
                                                                $nonActive = ' <span class="badge badge-light-danger"> ไม่ใช้งาน </span>';
                                                            }

                                                            echo "<tr>";
                                                            echo "<td class='text-center'>" . $row["customer_code"] . "</td>";
                                                            echo "<td>" . $row["customer_name"] . $nonActive . "</td>";
                                                            echo "<td  class='text-center'>" . $row["branch"] . "</td>";
                                                            echo "<td  class='text-center'>" . $row["contact_1"] . "</td>";
                                                            echo "<td  class='text-center'>" . $row["phone_1"] . "</td>";
                                                            echo "<td  class='text-center'><a href='011_customerMasterView.php?customer_id=" . $row["customer_id"] . "' class='btn btn-sm btn-secondary'> รายละเอียด</a></td>";
                                                            echo "</tr>";
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


    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
            // สร้าง DataTable
            let customerDatatable = $("#customerTable").DataTable({
                search: {
                    return: true,
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                },
                "pageLength": 50 // กำหนดให้แสดงแถวต่อหน้าเริ่มต้นที่ 50 แถว

            });
            customerDatatable.on('draw', function() {
                $('#customerTable').removeClass('d-none');
            });

            // ตรวจสอบการเปลี่ยนแปลงค่าของ checkbox
            $('#active').change(function() {
                if ($(this).is(":checked")) { // ถ้าถูกติ๊ก
                    window.location.href = '010_customerIndex.php'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                } else { // ถ้าไม่ถูกติ๊ก
                    window.location.href = '010_customerIndex.php?inactive=true'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                }
            });


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>