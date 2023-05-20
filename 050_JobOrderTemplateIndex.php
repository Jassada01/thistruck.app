<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>รายการแผนการจัดส่ง</title>
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">ฐานข้อมูลสถานที่</h1>
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
                                    <li class="breadcrumb-item text-dark">แผนการจัดส่ง</li>
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

                                <a href="051_createJobOrderTemplate.php" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> เพิ่มแผนการจัดส่ง</a>
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
                                            <h1><i class="bi bi-card-checklist fs-3"></i> รายการแผนการจัดส่ง</h1>
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
                                            <table class="table table-bordered table-hover table-striped w-100 d-none" id="locationTable">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="font-weight-bold text-center">ชื่องาน</th>
                                                        <th class="font-weight-bold text-center">ผู้ว่าจ้าง</th>
                                                        <th class="font-weight-bold text-center">สาขา</th>
                                                        <th class="font-weight-bold text-center">ประเภทงาน</th>
                                                        <th class="font-weight-bold text-center">ผู้ติดต่อ</th>
                                                        <th class="font-weight-bold text-center">เบอร์โทร</th>
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
                                                        $sql = "Select a.id, a.job_name, a.job_type, a.active, b.ClientName, b.Branch, b.ContactPerson, b.Phone From job_order_template_header a Inner Join client_info b ON a.ClientID = b.ClientID Order By a.ClientID";
                                                    } else {
                                                        $sql = "Select a.id, a.job_name, a.job_type, a.active, b.ClientName, b.Branch, b.ContactPerson, b.Phone From job_order_template_header a Inner Join client_info b ON a.ClientID = b.ClientID Where a.active = 1 Order By a.ClientID";
                                                    }
                                                    $result = mysqli_query($conn, $sql);

                                                    // ส่วนของการแสดงข้อมูลผู้ว่าจ้างในตาราง
                                                    while ($row = mysqli_fetch_array($result)) {

                                                        $nonActive = "";
                                                        if ($row["active"] != '1') {
                                                            $nonActive = ' <span class="badge badge-light-danger"> ไม่ใช้งาน </span>';
                                                        }


                                                        echo "<tr>";
                                                        echo "<td>  " . $row['job_name'] . $nonActive  . "</td>";
                                                        echo "<td>" . $row['ClientName'] . "</td>";
                                                        echo "<td>" . $row['Branch'] . "</td>";
                                                        echo "<td  class='text-center' >" . $row['job_type'] . "</td>";
                                                        echo "<td>" . $row['ContactPerson'] . "</td>";
                                                        echo "<td>" . $row['Phone'] . "</td>";
                                                        echo "<td><a href=\"052_jobOrderTemplateDetail.php?jobTemplateID=" . $row['id'] . "\"><button type=\"button\" class=\"btn btn-sm btn-secondary\">ดูรายละเอียด</button></a></td>";
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
                                        <label for="location_code" class="col-sm-3 col-form-label">รหัสสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="location_code" name="location_code" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="location_name" class="col-sm-3 col-form-label">ชื่อสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="location_name" name="location_name" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="location_type" class="col-sm-3 col-form-label">ประเภท<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-select" id="location_type" name="location_type" required>
                                                <option value=>เลือกประเภท</option>
                                                <?php
                                                // Connect to database
                                                include "function/connectionDb.php";

                                                // Query data from master_data where type = 'Job_Type'
                                                $sql = "SELECT * FROM master_data WHERE type = 'location_type'";
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

                                    <div class="form-group mt-3 row d-none" id="selectCustomer_panel">
                                        <label for="customer_id" class="col-sm-3 col-form-label">ลูกค้า<span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <select class="form-control m-input" id="customer_id" name="customer_id" data-dropdown-parent="#addLocationModal" disabled></select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">ที่อยู่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="location_address" name="address" rows="3" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="map_url" class="col-sm-3 col-form-label">URL Google Map</label>
                                        <div class="col-sm-8">
                                            <input type="url" class="form-control m-input" id="map_url" name="map_url">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="latitude" class="col-sm-3 col-form-label">ละติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="latitude" name="latitude">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="longitude" class="col-sm-3 col-form-label">ลองติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="longitude" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="note" class="col-sm-3 col-form-label">หมายเหตุ</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="note" name="note" rows="3"></textarea>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveNewLocation">บันทึก</button>
                </div>
            </div>
            </form>

        </div>
    </div>

    <!-- Modal แก้ไขสถานที่ -->
    <div class="modal fade" id="EditLocationModal" tabindex="-1" aria-labelledby="EditLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditLocationModalLabel">แก้ไขสถานที่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="edit_locationForm" method="post" class="m-form m-form--fit m-form--label-align-right">
                                    <div class="form-group mt-3 row d-none">
                                        <label for="location_id" class="col-sm-3 col-form-label">location_id<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="location_id" name="location_id" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="location_code" class="col-sm-3 col-form-label">รหัสสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="edit_location_code" name="location_code" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="location_name" class="col-sm-3 col-form-label">ชื่อสถานที่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="edit_location_name" name="location_name" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="edit_location_type" class="col-sm-3 col-form-label">ประเภท<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-select" id="edit_location_type" name="location_type" required>
                                                <option value=>เลือกประเภท</option>
                                                <?php
                                                // Connect to database
                                                include "function/connectionDb.php";

                                                // Query data from master_data where type = 'Job_Type'
                                                $sql = "SELECT * FROM master_data WHERE type = 'location_type'";
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
                                    <div class="form-group mt-3 row" id="edit_customer_panel">
                                        <label for="customer_id" class="col-sm-3 col-form-label">ลูกค้า<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control m-input" id="edit_customer_id" name="customer_id" data-dropdown-parent="#EditLocationModal"></select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">ที่อยู่<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="edit_location_address" name="address" rows="3" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="map_url" class="col-sm-3 col-form-label">URL Google Map</label>
                                        <div class="col-sm-8">
                                            <input type="url" class="form-control m-input" id="edit_map_url" name="map_url">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="latitude" class="col-sm-3 col-form-label">ละติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="edit_latitude" name="latitude">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 row">
                                        <label for="longitude" class="col-sm-3 col-form-label">ลองติจูด</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="edit_longitude" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="note" class="col-sm-3 col-form-label">หมายเหตุ</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control m-input" id="edit_note" name="note" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="edit_active" class="col-sm-3 col-form-label">Active</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                                <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="edit_active" name="active" checked />
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="btnEditLocation">แก้ไขข้อมูล</button>
                </div>
                </form>
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



    <!--end::Page Custom Javascript-->
    <script>
        // เมื่อ Document โหลดเสร็จแล้ว
        $(document).ready(function() {
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
                    }
                });
                return data;
            }

            // Create Data Table 
            let locationTable = $("#locationTable").DataTable({
                search: {
                    return: true,
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                },
                "autoWidth": false,

            });
            // Show Table 
            locationTable.on('draw', function() {
                $('#locationTable').removeClass('d-none');
            });

            // ตรวจสอบการเปลี่ยนแปลงค่าของ checkbox
            $('#active').change(function() {
                if ($(this).is(":checked")) { // ถ้าถูกติ๊ก
                    window.location.href = '050_JobOrderTemplateIndex.php'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                } else { // ถ้าไม่ถูกติ๊ก
                    window.location.href = '050_JobOrderTemplateIndex.php?inactive=true'; // รีโหลดหน้าเว็บพร้อมกับส่งพารามิเตอร์ ?inactive=true
                }
            });


            // ฟังก์ชั่นแปลงค่า Google map URL to LatLon
            function convertGoogleMapUrlToLatLng(googleMapUrl) {
                const match = googleMapUrl.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
                if (match) {
                    const latitude = parseFloat(match[1]);
                    const longitude = parseFloat(match[2]);
                    return {
                        latitude,
                        longitude
                    };
                }
                return null;
            }

            function validateLocationForm() {
                let isValid = true;
                // ตรวจสอบฟิลด์ location_code
                const locationCode = document.getElementById("location_code");
                if (locationCode.value.trim() === "") {
                    locationCode.classList.add("is-invalid");
                    isValid = false;
                } else {
                    locationCode.classList.remove("is-invalid");
                }

                // ตรวจสอบฟิลด์ location_name
                const locationName = document.getElementById("location_name");
                if (locationName.value.trim() === "") {
                    locationName.classList.add("is-invalid");
                    isValid = false;
                } else {
                    locationName.classList.remove("is-invalid");
                }

                // ตรวจสอบฟิลด์ customer_id
                const customerId = document.getElementById("customer_id");
                if (customerId.value.trim() === "") {
                    customerId.classList.add("is-invalid");
                    isValid = false;
                } else {
                    customerId.classList.remove("is-invalid");
                }

                // ตรวจสอบฟิลด์ address
                const location_address = document.getElementById("location_address");
                if (location_address.value.trim() === "") {
                    location_address.classList.add("is-invalid");
                    isValid = false;
                } else {
                    location_address.classList.remove("is-invalid");
                }
                return isValid;
            }


            const googleMapUrlInput = document.getElementById("map_url");
            const latitudeInput = document.getElementById("latitude");
            const longitudeInput = document.getElementById("longitude");

            // เพิ่ม Event Listener ให้กับ input element ของ googleMapUrl
            googleMapUrlInput.addEventListener("input", function() {
                const url = googleMapUrlInput.value.trim();

                // ถ้า URL ไม่ว่างเปล่า ให้แปลงค่าและแสดงผลลัพธ์ใน input element ของ latitude และ longitude
                if (url !== "") {
                    const latLng = convertGoogleMapUrlToLatLng(url);
                    latitudeInput.value = latLng.latitude.toFixed(6);
                    longitudeInput.value = latLng.longitude.toFixed(6);
                } else {
                    // ถ้า URL ว่างเปล่า ให้ล้างค่าใน input element ของ latitude และ longitude
                    latitudeInput.value = "";
                    longitudeInput.value = "";
                }
            });

            $('#addLocationModal').on('show.bs.modal', function() {
                $('#locationForm').trigger('reset');
                loadCustomerForSelect();
            });

            function loadCustomerForSelect() {
                var add_data = {};
                add_data['f'] = '2';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (add_data)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        // เลือก Select2
                        $('#customer_id').select2({
                            placeholder: 'เลือกลูกค้า',
                            data: data_arr.map(function(item) {
                                return {
                                    id: item.customer_id,
                                    text: item.text
                                };
                            })
                        });
                        //$('#customer_id').val(customer_id).trigger('change');
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // location_type
            $('#location_type').on('change', function() {
                loadCustomerForSelect();
                if ($(this).val() == "ลูกค้า") {
                    $('#customer_id').prop('disabled', false);
                    $('#customer_id').prop('required', true);
                    //selectCustomer_panel
                    $('#selectCustomer_panel').removeClass('d-none');
                } else {
                    $('#customer_id').val('').prop('disabled', true);
                    $('#customer_id').prop('required', false);
                    $('#selectCustomer_panel').addClass('d-none');
                }
            });

            $('#btnSaveNewLocation').click(function() {
                if (validateLocationForm()) {
                    // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                    let add_data = formToObject('#locationForm');
                    // เพิ่มข้อมูลในตาราง locations ด้วย ajax
                    add_data['f'] = '3';
                    add_data['location_type'] = 'ลูกค้า';
                    //console.log(add_data);
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/01_customerMaster/mainFunction.php',
                            data: (add_data)
                        })
                        .done(function(data) {
                            //console.log(data);
                            //alert("Complete")
                            //loadCustomerLocation();
                            location.reload();
                            $('#addLocationModal').modal('hide');
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                }
            });


            $("#locationForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = '3';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (data)
                    })
                    .done(function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // รีเฟรชหน้าเพื่อแสดงข้อมูลล่าสุด
                            location.reload();
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });

            });
            // Edit Form Part =============================

            $('body').on('click', '.btnLocationView', function() {
                var target = ($(this).attr('value'));
                $('#edit_locationForm').trigger('reset');
                loadCustomerLocationID(target);
            });



            // สร้างเหตุการณ์เมื่อคลิกปุ่ม
            //$(".btnlinkGoogleMap").click(function() {
            $('body').on('click', '.btnlinkGoogleMap', function() {
                // ดึงค่าละติจูดและลองติจูดจากแอตทริบิวต์ของปุ่ม
                var lat = $(this).attr("lat");
                var lng = $(this).attr("lng");

                // สร้าง URL สำหรับ Google Maps
                var url = "https://www.google.com/maps?q=" + lat + "," + lng + "&z=15&output=embed";

                // เปิดหน้าต่าง Google Maps ในหน้าต่างใหม่
                window.open(url, "_blank");
            });

            function loadCustomerForSelectforEdit(customer_id) {
                var add_data = {};
                add_data['f'] = '2';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (add_data)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        // เลือก Select2
                        $('#edit_customer_id').select2({
                            placeholder: 'เลือกลูกค้า',
                            data: data_arr.map(function(item) {
                                return {
                                    id: item.customer_id,
                                    text: item.text
                                };
                            })
                        });
                        $('#edit_customer_id').val(customer_id).trigger('change');
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

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
                        let form = $('#edit_locationForm');
                        form.find('#location_id').val(data_arr[0].location_id);
                        form.find('#edit_location_code').val(data_arr[0].location_code);
                        form.find('#edit_location_name').val(data_arr[0].location_name);
                        form.find('#edit_customer_id').val(data_arr[0].customer_id);
                        form.find('#edit_location_address').val(data_arr[0].address);
                        form.find('#edit_map_url').val(data_arr[0].map_url);
                        form.find('#edit_latitude').val(data_arr[0].latitude);
                        form.find('#edit_longitude').val(data_arr[0].longitude);
                        form.find('#edit_note').val(data_arr[0].note);
                        form.find('#edit_location_type').val(data_arr[0].location_type);

                        if (data_arr[0].active == 1) {
                            form.find('#edit_active').attr('checked', true);
                        } else {
                            form.find('#edit_active').removeAttr('checked');
                        }


                        if (data_arr[0].location_type == "ลูกค้า") {
                            $('#edit_customer_panel').removeClass('d-none');
                        } else {
                            $('#edit_customer_panel').addClass('d-none');
                        }


                        loadCustomerForSelectforEdit(data_arr[0].customer_id);
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            $('#edit_location_type').on('change', function() {
                loadCustomerForSelectforEdit(null);
                if ($(this).val() == "ลูกค้า") {
                    $('#edit_customer_id').prop('disabled', false);
                    $('#edit_customer_id').prop('required', true);
                    //selectCustomer_panel
                    $('#edit_customer_panel').removeClass('d-none');
                } else {
                    $('#edit_customer_id').val('').prop('disabled', true);
                    $('#edit_customer_id').prop('required', false);
                    $('#edit_customer_panel').addClass('d-none');
                }
            });

            $("#edit_locationForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = '6';


                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/01_customerMaster/mainFunction.php',
                        data: (data)
                    })
                    .done(function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // รีเฟรชหน้าเพื่อแสดงข้อมูลล่าสุด
                            location.reload();
                        });
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });

            $('body').on('click', '.btnLocationDelete', function() {
                const locationId = $(this).val();

                Swal.fire({
                    title: 'คุณต้องการลบข้อมูลนี้หรือไม่?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ใช่, ลบเลย',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var ajaxData = {};
                        ajaxData['f'] = '7';
                        ajaxData['location_id'] = locationId;
                        //console.log(ajaxData);
                        $.ajax({
                                type: 'POST',
                                dataType: "text",
                                url: 'function/01_customerMaster/mainFunction.php',
                                data: (ajaxData)
                            })
                            .done(function(data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบข้อมูลสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    // รีเฟรชหน้าเพื่อแสดงข้อมูลล่าสุด
                                    location.reload();
                                });
                            })
                            .fail(function() {
                                // just in case posting your form failed
                                alert("Posting failed.");
                            });
                    }
                })
            });



        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>