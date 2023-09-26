<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>บริหารจัดการรถ | ข้อมูลคนขับ</title>
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
        @media (min-width: 992px) {
            .text-end-pc {
                text-align: end;
            }
        }

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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">บริหารจัดการรถ</h1>
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
                                    <li class="breadcrumb-item text-dark">บริหารจัดการรถ | ข้อมูลคนขับ</li>
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
                                <button type="button" class="btn  btn-sm  btn-primary" data-bs-toggle="modal" data-bs-target="#driverModal">
                                    <i class="fas fa-plus"></i> เพิ่มข้อมูลคนขับ
                                </button>
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
                                            <h1><i class="bi bi-person fs-3"></i></i> รายการคนขับรถ</h1>
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
                                            <table class="table table-bordered table-hover table-striped w-100 d-none" id="driverTable">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="font-weight-bold text-center"></th>
                                                        <th class="font-weight-bold text-center">ชื่อ</th>
                                                        <th class="font-weight-bold text-center">เบอร์โทร</th>
                                                        <th class="font-weight-bold text-center">ประเภท</th>
                                                        <th class="font-weight-bold text-center">จ่ายให้กับ</th>
                                                        <th class="font-weight-bold text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <!-- ใช้ PHP หรืออื่นๆในการดึงข้อมูลจากฐานข้อมูล -->
                                                    <?php

                                                    // ส่วนของการเชื่อมต่อฐานข้อมูล
                                                    include "function/connectionDb.php";

                                                    // ส่วนของการดึงข้อมูลจากฐานข้อมูล
                                                    if ($inactive) {
                                                        $sql = "Select a.*, b.ContactName From truck_driver_info a  Left Join contacts b ON a.payto = b.ContactID";
                                                    } else {
                                                        $sql = "Select a.*, b.ContactName From truck_driver_info a  Left Join contacts b ON a.payto = b.ContactID Where a.active = 1";
                                                    }
                                                    $result = mysqli_query($conn, $sql);

                                                    // ส่วนของการแสดงข้อมูลผู้ว่าจ้างในตาราง
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $nonActive = "";
                                                        if ($row["active"] != '1') {
                                                            $nonActive = ' <span class="badge badge-light-danger"> ไม่ใช้งาน </span>';
                                                        }

                                                        echo "<tr>";
                                                        //echo "<td><img src='assets/media/uploadfile/{$row['image_path']}' width='100'></td>";
                                                        echo '<td class="text-center"><img class="rounded-circle" src="assets/media/uploadfile/' . $row['image_path'] . '" alt="' . $row['driver_name'] . '" style="width: 60px; height: 60px; object-fit: cover;"></td>';
                                                        echo "<td>" . $row['driver_name'] . $nonActive . "</td>";
                                                        echo "<td class='text-center'>{$row['contact_number']}</td>";
                                                        echo "<td class='text-center'>{$row['type']}</td>";
                                                        echo "<td class='text-center'>{$row['ContactName']}</td>";
                                                        echo '<td class="text-center">';
                                                        echo '<div class="btn-group">';
                                                        echo '<button type="button" class="btn btn-sm btn-secondary btnDriverView" data-bs-toggle="modal" data-bs-target="#EditdriverModal" value="' . $row['driver_id'] . '"><i class="fa fa-eye"></i></button>';
                                                        echo '</div>';
                                                        echo '</td>';
                                                        echo "</tr>";
                                                    }

                                                    // ปิดการเชื่อมต่อฐานข้อมูล
                                                    mysqli_close($conn);

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
                <!--begin::Footer-->
                <?php
                include 'footer.php';
                ?>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->
    <!--begin::Modals-->
    <!-- Modal เพิ่มข้อมูลคนขับ -->
    <div class="modal fade" id="driverModal" tabindex="-1" aria-labelledby="driverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="driverModalLabel">เพิ่มข้อมูลคนขับ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form id="driverForm" method="post" enctype="multipart/form-data">

                                <div class="form-group mt-3 row">
                                    <label for="image_path_select" class="col-sm-5 col-form-label text-end-pc"></label>
                                    <div class="col-sm-6 text-center">
                                        <div class="avatar-wrapper" onclick="document.getElementById('image_path_select').click();">
                                            <img id="avatar_preview" src="assets/media/avatars/default_avatar.jpg" alt="avatar">
                                            <input type="file" class="form-control" id="image_path_select" name="image_path_select" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="driver_name" class="col-sm-3 col-form-label text-end-pc">ชื่อคนขับ<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="driver_name" name="driver_name" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row d-none">
                                    <label for="image_path" class="col-sm-3 col-form-label text-end-pc">Path Image</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="image_path" name="image_path" autocomplete="off" value="default_avatar.jpg">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="driver_license_number" class="col-sm-3 col-form-label text-end-pc">หมายเลขใบขับขี่</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="driver_license_number" name="driver_license_number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="driver_license_expiry_date" class="col-sm-3 col-form-label text-end-pc">วันหมดอายุใบขับขี่</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" id="driver_license_expiry_date" name="driver_license_expiry_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="contact_number" class="col-sm-3 col-form-label text-end-pc">หมายเลขโทรศัพท์</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="line_id" class="col-sm-3 col-form-label text-end-pc"><a href="addLineManual.php" target="_blank">System Line ID</a></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="line_id" name="line_id" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="type" class="col-sm-3 col-form-label text-end-pc">ประเภท</label>
                                    <div class="col-sm-6">
                                        <select class="form-select" id="type" name="type">
                                            <option value="พนักงานบริษัท">พนักงานบริษัท</option>
                                            <option value="ซับ คอนแทรค">ซับคอนแทรค</option>
                                            <option value="อื่นๆ">อื่นๆ</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="type" class="col-sm-3 col-form-label text-end-pc">จ่ายให้กับ</label>
                                    <div class="col-sm-8">
                                        <select class="form-control mb-2 mb-md-0 payto" name="payto" id="paytoCreate">
                                            <option></option>
                                            <?php
                                            // Connect to database
                                            include "function/connectionDb.php";

                                            // Query Payto 
                                            $sql = "SELECT * FROM contacts";
                                            $result = mysqli_query($conn, $sql);

                                            // Loop through data and create dropdown options
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                echo "<option value='" . $row['ContactID'] . "'>" . $row['ContactID'] . " : " . $row['ContactName'] . "</option>";
                                            }

                                            // Close database connection
                                            mysqli_close($conn);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="note" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" id="note" name="note" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary" id="saveDriver">
                                            <span class="indicator-label">
                                                บันทึกข้อมูล
                                            </span>
                                            <span class="indicator-progress">
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span> กำลัง Upload รูปภาพ
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Modalแก้ไขข้อมูลคนขับ -->
    <div class="modal fade" id="EditdriverModal" tabindex="-1" aria-labelledby="EditdriverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditdriverModalLabel">ตรวจสอบ/แก้ไข ข้อมูลคนขับ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form id="edit_driverForm" method="post" enctype="multipart/form-data">

                                <div class="form-group mt-3 row">
                                    <label for="image_path_select" class="col-sm-5 col-form-label text-end-pc"></label>
                                    <div class="col-sm-6 text-center">
                                        <div class="avatar-wrapper" onclick="document.getElementById('edit_image_path_select').click();">
                                            <img id="edit_avatar_preview" src="assets/media/avatars/default_avatar.jpg" alt="avatar">
                                            <input type="file" class="form-control" id="edit_image_path_select" name="image_path_select" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="driver_name" class="col-sm-3 col-form-label text-end-pc">ชื่อคนขับ<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="edit_driver_name" name="driver_name" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row d-none">
                                    <label for="image_path" class="col-sm-3 col-form-label text-end-pc">Path Image</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="edit_image_path" name="image_path" autocomplete="off" value="default_avatar.jpg">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="driver_license_number" class="col-sm-3 col-form-label text-end-pc">หมายเลขใบขับขี่</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="edit_driver_license_number" name="driver_license_number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="driver_license_expiry_date" class="col-sm-3 col-form-label text-end-pc">วันหมดอายุใบขับขี่</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" id="edit_driver_license_expiry_date" name="driver_license_expiry_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="contact_number" class="col-sm-3 col-form-label text-end-pc">หมายเลขโทรศัพท์</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="edit_contact_number" name="contact_number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="line_id" class="col-sm-3 col-form-label text-end-pc"><a href="addLineManual.php" target="_blank">System Line ID</a></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="edit_line_id" name="line_id" autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn  btn-light-danger" id="TestSendLineBTN">ทดสอบ</button>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="type" class="col-sm-3 col-form-label text-end-pc">ประเภท</label>
                                    <div class="col-sm-6">
                                        <select class="form-select" id="edit_type" name="type">
                                            <option value="พนักงานบริษัท">พนักงานบริษัท</option>
                                            <option value="ซับ คอนแทรค">ซับคอนแทรค</option>
                                            <option value="อื่นๆ">อื่นๆ</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="type" class="col-sm-3 col-form-label text-end-pc">จ่ายให้กับ</label>
                                    <div class="col-sm-8">
                                        <select class="form-control mb-2 mb-md-0 payto" name="payto" id="paytoEdit">
                                            <option></option>
                                            <?php
                                            // Connect to database
                                            include "function/connectionDb.php";

                                            // Query Payto 
                                            $sql = "SELECT * FROM contacts";
                                            $result = mysqli_query($conn, $sql);

                                            // Loop through data and create dropdown options
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                //echo "<option value='" . $row['truck_id'] . "'> " . $row['truck_number']  . $row['driver_name']  . "</option>";
                                                echo "<option value='" . $row['ContactID'] . "'>" . $row['ContactID'] . " : " . $row['ContactName'] . "</option>";
                                            }

                                            // Close database connection
                                            mysqli_close($conn);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-3 row">
                                    <label for="note" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" id="edit_note" name="note" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="editNameVisable" class="col-sm-3 col-form-label text-end-pc">รายชื่อบนใบงาน</label>
                                    <div class="col-sm-3 ">
                                        <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                            <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="editNameVisable" name="NameVisable" checked />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <label for="edit_active" class="col-sm-3 col-form-label text-end-pc">Activate</label>
                                    <div class="col-sm-3 ">
                                        <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                            <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="edit_active" name="active" checked />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3 row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary" id="edit_saveDriver">
                                            <span class="indicator-label">
                                                บันทึกข้อมูล
                                            </span>
                                            <span class="indicator-progress">
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span> กำลัง Upload รูปภาพ
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    <!-- Sweet Alert 2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

    <!-- Data table JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"></script>

    <!--Date Picker ภาษาไทย -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>





    <!--end::Page Custom Javascript-->
    <script defer>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
            var $saveDriverButton = $("#saveDriver");
            var $edit_saveDriverButton = $("#edit_saveDriver");
            var CURRENT_DRIVER_ID = "";

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
                    if (type == "radio" && $(this).is(":checked") || tag == "select" || tag == "textarea" || type != "radio") {
                        data[name] = value;
                    }
                });
                return data;
            }

            $("#driver_license_expiry_date").flatpickr({
                dateFormat: "Y-m-d",
                locale: "th",
                altInput: true,
                altFormat: "j M Y",
                thaiBuddhist: true,
            });

            var flatpickr_edit_driver_license_expiry_date = $("#edit_driver_license_expiry_date").flatpickr({
                dateFormat: "Y-m-d",
                locale: "th",
                altInput: true,
                altFormat: "j M Y",
                thaiBuddhist: true,
            });

             //paytoCreate
             $('#paytoCreate').select2({
                placeholder: 'เลือกจ่ายให้กับ',
                dropdownParent: $("#driverModal"),
            });

            //paytoEdit
            $('#paytoEdit').select2({
                placeholder: 'เลือกจ่ายให้กับ',
                dropdownParent: $("#EditdriverModal"),
            });

            // Create Data Table 
            let locationTable = $("#driverTable").DataTable({
                search: {
                    return: true,
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                },
                "autoWidth": false,
                "pageLength": 50 // กำหนดให้แสดงแถวต่อหน้าเริ่มต้นที่ 50 แถว

            });
            // Show Table 
            locationTable.on('draw', function() {
                $('#driverTable').removeClass('d-none');
            });

            // ตรวจสอบการเปลี่ยนแปลงค่าของ checkbox
            $('#active').change(function() {
                if ($(this).is(":checked")) { // ถ้าถูกติ๊ก
                    window.location.href = '041_truckDriverInfo.php'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                } else { // ถ้าไม่ถูกติ๊ก
                    window.location.href = '041_truckDriverInfo.php?inactive=true'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                }
            });

            $('#image_path_select').on('change', function(event) {
                loadFile(event);
            });




            function loadFile(event) {
                const output = $('#avatar_preview');
                output.attr('src', URL.createObjectURL(event.target.files[0]));
                output.on('load', function() {
                    URL.revokeObjectURL(output.attr('src')); // free memory
                });

                const file = event.target.files[0];
                const reader = new FileReader();

                reader.addEventListener("load", function() {
                    const image = new Image();
                    image.src = reader.result;
                    image.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        const MAX_WIDTH = 500;
                        let width = image.width;
                        let height = image.height;

                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(image, 0, 0, width, height);

                        const resizedImageDataURL = canvas.toDataURL("image/jpeg");
                        uploadFile(resizedImageDataURL, "image/jpeg", "image.jpeg");

                        // resizedImageDataURL คือข้อมูลรูปภาพที่ถูกย่อขนาดแล้ว
                        // คุณสามารถใช้ resizedImageDataURL ในการแสดงผลหรือส่งข้อมูลไปยังเซิร์ฟเวอร์
                    };
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            }

            function uploadFile(imageDataURL, mimeType, originalFileName) {
                // Disable Save Button
                const byteString = atob(imageDataURL.split(',')[1]);
                const arrayBuffer = new ArrayBuffer(byteString.length);
                const uint8Array = new Uint8Array(arrayBuffer);
                for (let i = 0; i < byteString.length; i++) {
                    uint8Array[i] = byteString.charCodeAt(i);
                }
                const blob = new Blob([arrayBuffer], {
                    type: mimeType
                });

                const formData = new FormData();
                if (mimeType.startsWith("image/")) {
                    formData.append("file", blob);
                } else {
                    formData.append("file", blob, originalFileName);
                }
                $.ajax({
                    type: 'POST',
                    url: 'function/uploadFile.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $saveDriverButton.attr("data-kt-indicator", "on");
                        $("#saveDriver").prop("disabled", true);
                    },
                    success: function(response) {
                        $saveDriverButton.removeAttr("data-kt-indicator");
                        $("#saveDriver").prop("disabled", false);
                        $('#image_path').val(response);
                        $("#avatar_preview").attr("src", "assets/media/uploadfile/" + response);
                        //alert('Uploaded file name: ' + response);
                    },
                    error: function(error) {
                        $saveDriverButton.removeAttr("data-kt-indicator");
                        $("#saveDriver").prop("disabled", false);
                        console.error('Error uploading file: ', error);
                    }
                });
            }

            $('#driverModal').on('show.bs.modal', function() {
                $('#driverForm').trigger('reset');
                $("#avatar_preview").attr("src", "assets/media/uploadfile/default_avatar.jpg");
                //avatar_preview
                //assets/media/avatars/default_avatar.jpg
            });

            // กำหนดเหตุการณ์ submit ข้อมูล
            $("#driverForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = 1;
                // function/01_customerMaster/update_customer.php

                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (data)
                    })
                    .done(function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });

            });


            // Edit Data ==============================================================================================================

            $('body').on('click', '.btnDriverView', function() {
                var target = ($(this).attr('value'));
                //alert (target);
                CURRENT_DRIVER_ID = target;
                loadDriverInfoByID(target);
            });


            function loadDriverInfoByID(driver_id) {
                var ajaxData = {};
                ajaxData['f'] = '2';
                ajaxData['driver_id'] = driver_id;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {

                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);


                        let form = $('#edit_driverForm');
                        form.find('#edit_driver_name').val(data_arr[0].driver_name);
                        form.find('#edit_image_path').val(data_arr[0].image_path);
                        form.find('#edit_driver_license_number').val(data_arr[0].driver_license_number);

                        form.find('#edit_contact_number').val(data_arr[0].contact_number);
                        form.find('#edit_line_id').val(data_arr[0].line_id);
                        form.find('#edit_note').val(data_arr[0].note);
                        form.find('#edit_type').val(data_arr[0].type);
                        flatpickr_edit_driver_license_expiry_date.setDate(data_arr[0].driver_license_expiry_date);

                        if (data_arr[0].active == 1) {
                            form.find('#edit_active').attr('checked', true);
                        } else {
                            form.find('#edit_active').removeAttr('checked');
                        }

                        if (data_arr[0].nameVisable == 1) {
                            form.find('#editNameVisable').attr('checked', true);
                        } else {
                            form.find('#editNameVisable').removeAttr('checked');
                        }

                        $('#paytoEdit').val(data_arr[0].payto).trigger('change');

                        $("#edit_avatar_preview").attr("src", "assets/media/uploadfile/" + data_arr[0].image_path);

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('#EditdriverModal').on('show.bs.modal', function() {
                $('#edit_driverForm').trigger('reset');
                $("#edit_avatar_preview").attr("src", "assets/media/uploadfile/default_avatar.jpg");
            });

            $('#edit_image_path_select').on('change', function(event) {
                edit_loadFile(event);
            });

            function edit_loadFile(event) {
                const output = $('#edit_avatar_preview');
                output.attr('src', URL.createObjectURL(event.target.files[0]));
                output.on('load', function() {
                    URL.revokeObjectURL(output.attr('src')); // free memory
                });

                const file = event.target.files[0];
                const reader = new FileReader();

                reader.addEventListener("load", function() {
                    const image = new Image();
                    image.src = reader.result;
                    image.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        const MAX_WIDTH = 500;
                        let width = image.width;
                        let height = image.height;

                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(image, 0, 0, width, height);

                        const resizedImageDataURL = canvas.toDataURL("image/jpeg");
                        edit_uploadFile(resizedImageDataURL, "image/jpeg", "image.jpeg");

                        // resizedImageDataURL คือข้อมูลรูปภาพที่ถูกย่อขนาดแล้ว
                        // คุณสามารถใช้ resizedImageDataURL ในการแสดงผลหรือส่งข้อมูลไปยังเซิร์ฟเวอร์
                    };
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            }

            function edit_uploadFile(imageDataURL, mimeType, originalFileName) {
                // Disable Save Button
                const byteString = atob(imageDataURL.split(',')[1]);
                const arrayBuffer = new ArrayBuffer(byteString.length);
                const uint8Array = new Uint8Array(arrayBuffer);
                for (let i = 0; i < byteString.length; i++) {
                    uint8Array[i] = byteString.charCodeAt(i);
                }
                const blob = new Blob([arrayBuffer], {
                    type: mimeType
                });

                const formData = new FormData();
                if (mimeType.startsWith("image/")) {
                    formData.append("file", blob);
                } else {
                    formData.append("file", blob, originalFileName);
                }
                $.ajax({
                    type: 'POST',
                    url: 'function/uploadFile.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $edit_saveDriverButton.attr("data-kt-indicator", "on");
                        $("#edit_saveDriver").prop("disabled", true);
                    },
                    success: function(response) {
                        $edit_saveDriverButton.removeAttr("data-kt-indicator");
                        $("#edit_saveDriver").prop("disabled", false);
                        $('#edit_image_path').val(response);
                        $("#edit_avatar_preview").attr("src", "assets/media/uploadfile/" + response);
                        //alert('Uploaded file name: ' + response);
                    },
                    error: function(error) {
                        $edit_saveDriverButton.removeAttr("data-kt-indicator");
                        $("#edit_saveDriver").prop("disabled", false);
                        console.error('Error uploading file: ', error);
                    }
                });
            }

            // กำหนดเหตุการณ์ submit ข้อมูล
            $("#edit_driverForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = 3;
                data['driver_id'] = CURRENT_DRIVER_ID;
                //console.log(data);
                // function/01_customerMaster/update_customer.php

                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (data)
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
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });

            });


            // TestSendLineBTN
            // edit_line_id
            $('body').on('click', '#TestSendLineBTN', function() {
                var target = $("#edit_line_id").val();
                if (target.trim() != "") {
                    var ajaxData = {};
                    ajaxData['f'] = '7';
                    ajaxData['line_id'] = target;
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





        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>