<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>บริหารจัดการรถ | บริษัทรถร่วม</title>
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

        .badge_pointer {
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
                                    <li class="breadcrumb-item text-dark">บริหารจัดการรถ | บริษัทรถร่วม</li>
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
                                <button type="button" class="btn  btn-sm  btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                    <i class="fas fa-plus"></i> เพิ่มบริษัทรถร่วม
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
                                            <h1><i class="bi bi-person fs-3"></i></i> รายการบริษัทรถร่วม</h1>
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
                                            <table class="table table-bordered table-hover table-striped w-100" id="driverTable">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="font-weight-bold text-center" style="width:5%"></th>
                                                        <th class="font-weight-bold text-center" style="white-space:nowrap">ชื่อบริษัท</th>
                                                        <th class="font-weight-bold text-center" style="white-space:nowrap">ผู้ติดต่อ</th>
                                                        <th class="font-weight-bold text-center" style="white-space:nowrap">เบอร์โทร</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <!-- ใช้ PHP หรืออื่นๆในการดึงข้อมูลจากฐานข้อมูล -->
                                                    <?php

                                                    // ส่วนของการเชื่อมต่อฐานข้อมูล
                                                    include "function/connectionDb.php";

                                                    // ส่วนของการดึงข้อมูลจากฐานข้อมูล
                                                    if ($inactive) {
                                                        $sql = "SELECT * FROM subcontractcarcompanies";
                                                    } else {
                                                        $sql = "SELECT * FROM subcontractcarcompanies where active = 1";
                                                    }
                                                    $result = mysqli_query($conn, $sql);

                                                    // ส่วนของการแสดงข้อมูลผู้ว่าจ้างในตาราง
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $nonActive = "";
                                                        if ($row["active"] != '1') {
                                                            $nonActive = ' <span class="badge badge-light-danger"> ไม่ใช้งาน </span>';
                                                        }

                                                        echo "<tr>";
                                                        echo '<td class="font-weight-bold text-center"><i class="bi bi-pencil-fill text-danger badge_pointer editsubContractBtn" k-value="' . $row['id'] . '"></i></td>';
                                                        echo "<td class='font-weight-bold text-center'>" . $row['companyName'] . $nonActive . "</td>";
                                                        echo "<td class='text-center'>{$row['contactPerson']}</td>";
                                                        echo "<td class='text-center'>{$row['phoneNumber']}</td>";
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
    <!-- Modal เพิ่มข้อมูล -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">เพิ่มบริษัทรถร่วม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form id="subContractCreateForm" method="post" enctype="multipart/form-data">
                                <!-- สำหรับกรอก companyName -->
                                <div class="form-group mt-3 row">
                                    <label for="companyName" class="col-sm-3 col-form-label text-end-pc">ชื่อบริษัท<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="create_companyName" name="companyName" autocomplete="off" required>
                                    </div>
                                </div>

                                <!-- สำหรับกรอก contactPerson -->
                                <div class="form-group mt-3 row">
                                    <label for="contactPerson" class="col-sm-3 col-form-label text-end-pc">ผู้ติดต่อ</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="create_contactPerson" name="contactPerson" autocomplete="off">
                                    </div>
                                </div>

                                <!-- สำหรับกรอก phoneNumber -->
                                <div class="form-group mt-3 row">
                                    <label for="phoneNumber" class="col-sm-3 col-form-label text-end-pc">เบอร์โทร</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="create_phoneNumber" name="phoneNumber" autocomplete="off">
                                    </div>
                                </div>

                                <!-- สำหรับกรอก email -->
                                <div class="form-group mt-3 row">
                                    <label for="email" class="col-sm-3 col-form-label text-end-pc">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="create_email" name="email" autocomplete="off">
                                    </div>
                                </div>

                                <!-- สำหรับกรอก line_group_id -->
                                <div class="form-group mt-3 row">
                                    <label for="line_group_id" class="col-sm-3 col-form-label text-end-pc">Line Group ID<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="กลุ่ม Line สำหรับส่งข้อมูลงาน"></i></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="create_line_group_id" name="line_group_id" autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn  btn-light-danger" id="createTestSendLineBTN">ทดสอบ</button>
                                    </div>
                                </div>

                                <div class="form-group mt-3 row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary" id="saveBTN">
                                            <span class="indicator-label">
                                                บันทึกข้อมูล
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


    <!-- Modal Edit ข้อมูล -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">แก้ไขบริษัทรถร่วม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form id="subContractEditForm" method="post" enctype="multipart/form-data">
                                <!-- สำหรับกรอก companyName -->
                                <div class="form-group mt-3 row">
                                    <label for="companyName" class="col-sm-3 col-form-label text-end-pc">ชื่อบริษัท<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="edit_companyName" name="companyName" autocomplete="off" required>
                                    </div>
                                </div>

                                <!-- สำหรับกรอก contactPerson -->
                                <div class="form-group mt-3 row">
                                    <label for="contactPerson" class="col-sm-3 col-form-label text-end-pc">ผู้ติดต่อ</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="edit_contactPerson" name="contactPerson" autocomplete="off">
                                    </div>
                                </div>

                                <!-- สำหรับกรอก phoneNumber -->
                                <div class="form-group mt-3 row">
                                    <label for="phoneNumber" class="col-sm-3 col-form-label text-end-pc">เบอร์โทร</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="edit_phoneNumber" name="phoneNumber" autocomplete="off">
                                    </div>
                                </div>

                                <!-- สำหรับกรอก email -->
                                <div class="form-group mt-3 row">
                                    <label for="email" class="col-sm-3 col-form-label text-end-pc">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="edit_email" name="email" autocomplete="off">
                                    </div>
                                </div>

                                <!-- สำหรับกรอก line_group_id -->
                                <div class="form-group mt-3 row">
                                    <label for="line_group_id" class="col-sm-3 col-form-label text-end-pc">Line Group ID<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="กลุ่ม Line สำหรับส่งข้อมูลงาน"></i></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="edit_line_group_id" name="line_group_id" autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn  btn-light-danger" id="EditTestSendLineBTN">ทดสอบ</button>
                                    </div>
                                </div>

                                <div class="form-group mt-3 row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary" id="editSaveBTN">
                                            <span class="indicator-label">
                                                บันทึกข้อมูล
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
            // Global Val================================
            let MAIN_EDIT_ID = "";

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



            $("#subContractCreateForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = '10';
                //console.log(data);
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

            $('body').on('click', '.editsubContractBtn', function() {
                let targetID = $(this).attr("k-value");
                //console.log(targetID);
                var ajaxData = {};
                ajaxData['f'] = '11';
                ajaxData['target_id'] = targetID;
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        let data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        var data = data_arr[0];

                        // ใช้ jQuery ในการกำหนดค่าของแต่ละ input field
                        MAIN_EDIT_ID = data.id;
                        $("#edit_companyName").val(data.companyName || "");
                        $("#edit_contactPerson").val(data.contactPerson || "");
                        $("#edit_phoneNumber").val(data.phoneNumber || "");
                        $("#edit_email").val(data.email || "");
                        $("#edit_line_group_id").val(data.line_group_id || "");
                        $('#editModal').modal('show');

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            });

            $('body').on('click', '#createTestSendLineBTN', function() {
                var target = $("#create_line_group_id").val();
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
            $('body').on('click', '#EditTestSendLineBTN', function() {
                var target = $("#edit_line_group_id").val();
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

            $("#subContractEditForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = '12';
                data['id'] = MAIN_EDIT_ID;
                //console.log(data);
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







        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>