<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>บริหารจัดการรถ > รายละเอียดรถบรรทุก</title>
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
                                    <li class="breadcrumb-item text-muted">
                                        <a href="042_truckInfo.php" class="text-muted text-hover-primary">บริหารจัดการรถ | ข้อมูลรถบรรทุก</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <li class="breadcrumb-item text-dark">รายละเอียดรถบรรทุก</li>
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
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-truck fs-3"></i></i> รายละเอียดรถบรรทุก</h1>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">
                                                <form id="truckForm" method="post" enctype="multipart/form-data" class="d-none">

                                                    <div class="form-group mt-3 row">
                                                        <label for="truck_number" class="col-sm-3 col-form-label text-end-pc">ทะเบียนรถ<span class="text-danger">*</span></label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="truck_number" name="truck_number" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-3 row">
                                                        <label for="province" class="col-sm-3 col-form-label text-end-pc">จังหวัด</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" id="province" name="province" autocomplete="off"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3 row">
                                                        <label for="main_driver_id" class="col-sm-3 col-form-label text-end-pc">คนขับหลัก</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="main_driver_id" name="main_driver_id" autocomplete="off"></select>
                                                        </div>
                                                    </div>

                                                    <!--begin::separator-->
                                                    <div class="separator my-10"></div>

                                                    <div class="form-group mt-3 row">
                                                        <label for="manufacturer" class="col-sm-3 col-form-label text-end-pc">ผู้ผลิต</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="manufacturer" name="manufacturer" autocomplete="off">
                                                        </div>
                                                        <label for="model" class="col-sm-2 col-form-label text-end-pc">รุ่น</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="model" name="model" autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div class="form-group mt-3 row">
                                                        <label for="year" class="col-sm-3 col-form-label text-end-pc">ปี</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" id="year" name="year" autocomplete="off">
                                                        </div>
                                                        <label for="truck_type" class="col-sm-3 col-form-label text-end-pc">ประเภทรถบรรทุก</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-select" id="truck_type" name="truck_type" autocomplete="off">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-3 row">
                                                        <label for="capacity" class="col-sm-3 col-form-label text-end-pc">น้ำหนักบรรทุก</label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="capacity" name="capacity" autocomplete="off" />
                                                                <span class="input-group-text" id="basic-addon2">ตัน</span>
                                                            </div>
                                                        </div>
                                                        <label for="fuel_type" class="col-sm-2 col-form-label text-end-pc">เชื้อเพลง</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-select" id="fuel_type" name="fuel_type" autocomplete="off">
                                                                <option value="ดีเซล">ดีเซล</option>
                                                                <option value="เบนซิน">เบนซิน</option>
                                                                <option value="แก๊สธรรมชาติ (NGV)">แก๊สธรรมชาติ (NGV)</option>
                                                                <option value="อื่นๆ">อื่นๆ</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <!--begin::separator-->
                                                    <div class="separator my-10"></div>



                                                    <div class="form-group mt-3 row">
                                                        <label for="insurance_company" class="col-sm-3 col-form-label text-end-pc">บริษัทประกันภัย</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="insurance_company" name="insurance_company" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-3 row">
                                                        <label for="insurance_policy_number" class="col-sm-3 col-form-label text-end-pc">เลขที่กรมธรรม์</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="insurance_policy_number" name="insurance_policy_number" autocomplete="off">
                                                        </div>
                                                        <label for="insurance_expiry_date" class="col-sm-2 col-form-label text-end-pc">วัดหมดอายุประกัน</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" id="insurance_expiry_date" name="insurance_expiry_date" autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <!--begin::separator-->
                                                    <div class="separator my-10"></div>

                                                    <div class="form-group mt-3 row">
                                                        <label for="last_maintenance_date" class="col-sm-3 col-form-label text-end-pc">วันที่ซ่อมบำรุงล่าสุด</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date" autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div class="form-group mt-3 row">
                                                        <label for="next_maintenance_distance" class="col-sm-3 col-form-label text-end-pc">เช็คระยะรอบต่อไป (กิโลเมตร)</label>
                                                        <div class="col-sm-3">
                                                            <input type="number" class="form-control" id="next_maintenance_distance" name="next_maintenance_distance" autocomplete="off">
                                                        </div>
                                                        <label for="next_maintenance_date" class="col-sm-2 col-form-label text-end-pc">วันที่</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date" autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div class="form-group mt-3 row">
                                                        <label for="note" class="col-sm-3 col-form-label text-end-pc">หมายเหตุ</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-3 row">
                                                        <label for="active" class="col-sm-3 col-form-label text-end-pc">Activate</label>
                                                        <div class="col-sm-3 ">
                                                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                                                <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="active" name="active" checked />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3 row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-8">
                                                            <button type="reset" class="btn btn-secondary" onclick="location.reload();">Reset</button>
                                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>บันทึกข้อมูล</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!--begin::separator-->
                                        <div class="separator my-10"></div>
                                        <div class="container mt-3">
                                            <h1 class="mb-3"><i class="fas fa-file  fs-4"></i> ไฟล์ที่เกี่ยวข้อง</h1>
                                            <div class="container">
                                                <div class="row" id="rowAddFile">
                                                    <div class="col-sm-12 text-end">
                                                        <button id="addFileBtn" class="btn btn-success" type="button">เพิ่มไฟล์</button>
                                                    </div>
                                                </div>
                                                <div class="row mt-3" id="rowUploadProgress">
                                                    <div class="col-md-10">
                                                        <div class="progress">
                                                            <div id="uploadProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 align-items-center">
                                                        <span id="uploadProgress">./.</span>
                                                    </div>
                                                </div>
                                                <div class="row mt-3" id="rowSelectFile">
                                                    <div class="col-sm-6 mt-3">
                                                        <input type="text" class="form-control" id="newFileDesc" name="newFileDesc" placeholder="ประเภทไฟล์" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="uploadFile" name="uploadFiles[]" multiple>
                                                            <button class="btn btn-success" type="button" id="upload-btn">อัพโหลด</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-3">
                                                <table class="table table-striped table-rounded w-100">
                                                    <thead class="bg-success text-white">
                                                        <tr>
                                                            <th class="font-weight-bold text-center">ประเภทเอกสาร</th>
                                                            <th class="font-weight-bold text-center">ไฟล์</th>
                                                            <th class="font-weight-bold text-center">วันเวลา</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="AttachedFileList">
                                                        <!-- แสดงรายการไฟล์ที่ Upload -->
                                                    </tbody>
                                                </table>
                                            </div>
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
                <!--begin::Footer-->
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->
    <!-- Modal เพิ่มสถานที่ -->
    <!-- Modal -->
    <div class="modal fade" id="showImageModal" tabindex="-1" role="dialog" aria-labelledby="showImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="ImageShow" src="" alt="" style="display: block; margin: auto; max-width: 100%;">
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
    <!-- Moment JS -->
    <script src="assets/plugins/custom/moment/moment-with-locales.js"></script>
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

            $('#loading-spinner').show();

            // Set Moment 
            moment.locale('th');

            // Load Data from Paramitor 
            const urlParams = new URLSearchParams(window.location.search);
            const truck_id = urlParams.get('truck_id');

            var fileUploadOjb = [];


            var LOAD_PROCESS_COUNT = 0;




            // Thai date sorting plugin
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-th-pre": function(a) {
                    var thDate = moment(a, 'D MMMM YYYY', 'th');
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

            // Random String 
            function randomString(length) {
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                return result;
            }




            $("#truckForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = 9;
                data['truck_id'] = truck_id;
                //console.log(data);
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

            function loadProvinceForSelect() {
                var ajaxData = {};
                ajaxData['f'] = '5';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        // เลือก Select2
                        $('#province').select2({
                            placeholder: 'เลือกจังหวัด',
                            //width: 'resolve',
                            data: data_arr.map(function(item) {
                                return {
                                    id: item.name_in_thai,
                                    text: item.name_in_thai
                                };
                            })
                        });
                        count_load_process();
                        //$('#customer_id').val(customer_id).trigger('change');

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function loadDriverforSelect() {
                var ajaxData = {};
                ajaxData['f'] = '6';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        //console.log(data);
                        var data_arr = JSON.parse(retunrdata);
                        // สร้าง dropdown โดยใช้ Select2
                        $('#main_driver_id').select2({
                            placeholder: 'เลือกคนขับหลัก',
                            data: data_arr.map(item => ({
                                id: item.driver_id,
                                text: item.driver_name,
                                image: item.image_path
                            })),
                            templateResult: formatResult, // ใช้ function formatResult แสดงรูปภาพ
                            templateSelection: formatSelection // ใช้ function formatSelection เพื่อแสดงชื่อและ driver_id เมื่อเลือก
                        });
                        count_load_process();

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            function loadTruckTypeForSelect() {
                var ajaxData = {};
                ajaxData['f'] = '7';
                ajaxData['MasterType'] = 'Truck_Type';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        //console.log(data);
                        var data_arr = JSON.parse(retunrdata);
                        //console.log(data_arr);
                        var truckTypeSelect = $('#truck_type');
                        $.each(data_arr, function(index, truckType) {
                            truckTypeSelect.append($('<option>', {
                                value: truckType.name,
                                text: truckType.name
                            }));
                        });

                        count_load_process();

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            // function สำหรับแสดงรูปภาพใน dropdown
            function formatResult(result) {
                if (!result.id) {
                    return result.text;
                }
                return $(`<span><img src="assets/media/uploadfile/${result.image}"  class="rounded-circle" width="30px" height="30px" style="vertical-align: middle; object-fit: cover; margin-right: 10px;">${result.text}</span>`);
            }

            // function สำหรับแสดงชื่อและ driver_id เมื่อเลือก
            function formatSelection(result) {
                return result.text ? $(`<span><img src="assets/media/uploadfile/${result.image}"  class="rounded-circle" width="30px" height="30px" style="vertical-align: middle; object-fit: cover; margin-right: 10px;">${result.text}</span>`) : result.text;
            }


            // Load Data 

            function loadTruckDataByID() {
                var ajaxData = {};
                ajaxData['f'] = '8';
                ajaxData['truck_id'] = truck_id;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/04_truckMaster/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        var data_arr = JSON.parse(retunrdata);
                        //console.log(data_arr);
                        var keys = Object.keys(data_arr[0]); // ดึง Key ของ Object จากอ็อบเจ็กต์ตัวแรก

                        // วนลูปเพื่อนำค่าจาก Object ไปเติมในฟอร์ม
                        for (var i = 0; i < keys.length; i++) {
                            var value = data_arr[0][keys[i]]; // ดึงค่าจาก Object ตาม Key ปัจจุบัน
                            $('[name="' + keys[i] + '"]').val(value); // นำค่าไปใส่ใน Input ที่มี name เหมือนกับ Key
                        }

                        if (data_arr[0].active == 1) {
                            $('#active').attr('checked', true);
                        } else {
                            $('#active').removeAttr('checked');
                        }
                        $("#main_driver_id").val(data_arr[0].main_driver_id).trigger("change");
                        $("#province").val(data_arr[0].province).trigger("change");



                        // Generate Data Select
                        $("#insurance_expiry_date").flatpickr({
                            dateFormat: "Y-m-d",
                            locale: "th",
                            altInput: true,
                            altFormat: "j M Y",
                            thaiBuddhist: true,
                        });

                        //last_maintenance_date
                        $("#last_maintenance_date").flatpickr({
                            dateFormat: "Y-m-d",
                            locale: "th",
                            altInput: true,
                            altFormat: "j M Y",
                            thaiBuddhist: true,
                        });

                        $("#next_maintenance_date").flatpickr({
                            dateFormat: "Y-m-d",
                            locale: "th",
                            altInput: true,
                            altFormat: "j M Y",
                            thaiBuddhist: true,
                        });




                        $('#truckForm').removeClass('d-none');
                        $('#loading-spinner').addClass('d-none');


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }





            function count_load_process() {
                LOAD_PROCESS_COUNT++;
                if (LOAD_PROCESS_COUNT == 3) {
                    loadTruckDataByID();
                }
            }

            // Upload Process ===========================================

            var TOTAL_UPLOAD_FILE = 0;
            var CURRENT_UPLOAD_FILE = 0;
            const DOCUMENT_GROUP = "TRUCK";
            const DOCUMENT_GROUP_CODE = truck_id;
            const MAIN_FILE_PATH = "assets/media/uploadfile/uploadDoc/";


            $("#rowUploadProgress, #rowSelectFile").hide();
            // เมื่อคลิกปุ่ม "เพิ่มไฟล์"
            $("#addFileBtn").on("click", function() {
                // ซ่อนบรรทัดที่ 1
                $("#rowAddFile").hide();
                // แสดงบรรทัดที่ 2 และ 3
                $("#rowSelectFile").show("fast");
            });

            function fileToBlob(file) {
                return new Promise((resolve, reject) => {
                    var reader = new FileReader();
                    reader.readAsArrayBuffer(file);
                    reader.onloadend = function() {
                        resolve(new Blob([reader.result], {
                            type: file.type
                        }));
                    };
                    reader.onerror = function() {
                        reject(reader.error);
                    };
                });
            }


            $('#upload-btn').click(function() {
                var fileDesc = $('#newFileDesc').val();
                $('#newFileDesc').removeClass('is-invalid');
                var files = $('#uploadFile').prop('files');

                if (files.length == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกไฟล์ที่ต้องการอัพโหลด',
                    });

                    return false;
                }

                if (fileDesc == '') {
                    $('#newFileDesc').addClass('is-invalid');
                    return false;
                } else {
                    // Start process upload 
                    validateFile();
                }

                // ทำงานอื่นๆ เมื่อ input field มีข้อมูล
            });



            async function validateFile() {
                fileUploadOjb = []; // เตรียมตัวแปรเป็น Array
                var files = $("#uploadFile")[0].files;
                var DocumentRandomStr = randomString(10);
                var documentDesc = $("#newFileDesc").val();
                TOTAL_UPLOAD_FILE = files.length;
                CURRENT_UPLOAD_FILE = 0;
                uploadProgressUpdate();
                $("#rowUploadProgress").show("fast");
                $("#rowSelectFile").hide();
                for (var i = 0; i < files.length; i++) {
                    CURRENT_UPLOAD_FILE += 1;
                    var file = files[i];
                    var originalFileName = file.name;
                    var mimeType = file.type;
                    var fileExtension = originalFileName.substring(originalFileName.lastIndexOf('.'));
                    var fileRandomStr = randomString(2);
                    var fileNameWithoutExtension = originalFileName.substring(0, originalFileName.lastIndexOf('.'));
                    var fileName = fileNameWithoutExtension + "_" + fileRandomStr + fileExtension;
                    var isImage = /^image\//.test(mimeType); // ตรวจสอบว่าเป็นรูปภาพหรือไม่
                    var thumbnailName;

                    if (isImage) {
                        thumbnailName = fileNameWithoutExtension + "_" + fileRandomStr + "_thumbnail" + fileExtension;
                    } else {
                        thumbnailName = "";
                    }

                    // เพิ่ม Object ลงใน Array
                    fileUploadOjb.push({
                        'document_group': DOCUMENT_GROUP,
                        'document_group_code': DOCUMENT_GROUP_CODE,
                        'file_path': MAIN_FILE_PATH + fileName,
                        'document_type': documentDesc,
                        'description': "",
                        'file_type': mimeType,
                        'thumbnail_path': MAIN_FILE_PATH + thumbnailName,
                        'random_code': DocumentRandomStr,
                        'isImage': isImage,
                        'originalFileName': originalFileName,
                    });

                    if (isImage) {
                        if (file.size > 1000000) {
                            // Upload Resize file
                            try {
                                const resizedBlob = await resizeImage(file, 1500);
                                uploadFile(resizedBlob, mimeType, fileName);
                            } catch (error) {
                                console.error('Error resizing image: ', error);
                            }
                        } else {
                            // Upload Full file
                            try {
                                const blob = await fileToBlob(file);
                                uploadFile(blob, mimeType, fileName);
                            } catch (error) {
                                console.error('Error converting file to blob: ', error);
                            }
                        }

                        // Upload thumbnail
                        try {
                            const resizedBlob = await resizeImage(file, 250);
                            uploadFile(resizedBlob, mimeType, thumbnailName);
                        } catch (error) {
                            console.error('Error resizing image: ', error);
                        }
                    } else {
                        try {
                            const blob = await fileToBlob(file);
                            uploadFile(blob, mimeType, fileName);
                        } catch (error) {
                            console.error('Error converting file to blob: ', error);
                        }
                    }
                }
                InsertAttachedfileData();
            }



            function uploadFile(blob, mimeType, originalFileName) {
                const formData = new FormData();
                formData.append("file", blob, originalFileName);
                $.ajax({
                    type: 'POST',
                    url: 'function/uploadFileCommon.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(event) {
                            if (event.lengthComputable) {
                                var percentComplete = (event.loaded / event.total) * 100;
                                // Update the progress bar width
                                $('#uploadProgressBar').css('width', percentComplete.toFixed(2) + '%');
                                $('#uploadProgressBar').attr('aria-valuenow', percentComplete.toFixed(2));
                            }
                        }, false);
                        return xhr;
                    },
                    beforeSend: function() {
                        // Set the progress bar width to 0%
                        $('#uploadProgressBar').css('width', '0%');
                        $('#uploadProgressBar').attr('aria-valuenow', '0');
                    },
                    success: function(response) {
                        uploadProgressUpdate();
                    },
                    error: function(error) {
                        console.error('Error uploading file: ', error);
                    }
                });
            }

            function uploadProgressUpdate() {
                $("#uploadProgress").html(CURRENT_UPLOAD_FILE + "/" + TOTAL_UPLOAD_FILE);
                if (TOTAL_UPLOAD_FILE != 0) {
                    if (CURRENT_UPLOAD_FILE == TOTAL_UPLOAD_FILE) {
                        $('#uploadProgressBar').css('width', '0%');
                        $('#uploadProgressBar').attr('aria-valuenow', '0');
                        $("#rowUploadProgress, #rowSelectFile").hide();
                        $("#rowAddFile").show();

                    }
                }

            }




            function resizeImage(file, maxFileSize) {
                return new Promise((resolve, reject) => {
                    var reader = new FileReader();
                    reader.onload = function() {
                        var image = new Image();
                        image.onload = function() {
                            var canvas = document.createElement('canvas');
                            var width = image.width;
                            var height = image.height;
                            var ratio = 1;
                            if (width > height) {
                                if (width > maxFileSize) {
                                    ratio = maxFileSize / width;
                                }
                            } else {
                                if (height > maxFileSize) {
                                    ratio = maxFileSize / height;
                                }
                            }
                            width *= ratio;
                            height *= ratio;
                            canvas.width = width;
                            canvas.height = height;
                            var ctx = canvas.getContext('2d');
                            ctx.drawImage(image, 0, 0, width, height);
                            canvas.toBlob(function(blob) {
                                resolve(blob);
                            }, file.type);
                        };
                        image.src = reader.result;
                    };
                    reader.onerror = function() {
                        reject(reader.error);
                    };
                    reader.readAsDataURL(file);
                });
            }

            function InsertAttachedfileData() {
                var ajaxData = {};
                ajaxData['f'] = '5';
                ajaxData['fileUploadOjb'] = JSON.stringify(fileUploadOjb); // Convert the object to a JSON string
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/00_systemManagement/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(retunrdata) {
                        loadAttachedData();
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function loadAttachedData() {
                var ajaxData = {};
                ajaxData['f'] = '6';
                ajaxData['DOCUMENT_GROUP'] = DOCUMENT_GROUP;
                ajaxData['DOCUMENT_GROUP_CODE'] = DOCUMENT_GROUP_CODE;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/00_systemManagement/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        // เลือก Select2
                        // สร้างตัวแปรสำหรับ tbody ใน HTML
                        var tbody = document.getElementById('AttachedFileList');
                        // Reset tbody
                        tbody.innerHTML = '';
                        // วนลูปเพื่อสร้างแถวในตารางสำหรับแต่ละ Record ใน Object
                        for (var i = 0; i < data_arr.length; i++) {
                            // สร้างแถวใหม่
                            var row = document.createElement('tr');

                            if (i > 0 && data_arr[i].random_code === data_arr[i - 1].random_code) {
                                // กรณี random_code เหมือนกับแถวก่อนหน้า ไม่ต้องแสดง document_type
                                var col1 = document.createElement('td');
                                row.appendChild(col1);

                            } else {
                                // สร้างคอลัมน์สำหรับ document_type
                                var col1 = document.createElement('td');
                                col1.classList.add('text-center')
                                col1.textContent = data_arr[i].document_type;
                                row.appendChild(col1);

                            }

                            if (data_arr[i].isImage == "1") {
                                var col2 = document.createElement('td');
                                var img = document.createElement('img');
                                img.src = data_arr[i].file_path;
                                img.style.maxHeight = '50px';
                                img.setAttribute('class', 'img-thumbnail thumbnailclickable');
                                img.setAttribute('value', data_arr[i].file_path);
                                col2.innerHTML = img.outerHTML;
                                row.appendChild(col2);

                                var col3 = document.createElement('td');
                                col3.classList.add('text-center');
                                //console.log(data_arr[i].created_at);
                                var created_at = moment(data_arr[i].created_at);
                                col3.textContent = created_at.format('DD MMM YY  HH:mm');
                                row.appendChild(col3);


                            } else {
                                var col2 = document.createElement('td');
                                var icon = document.createElement('i');
                                icon.classList.add('fas'); // ใช้ font-awesome 5
                                icon.classList.add('fa-2x'); // ใช้ font-awesome 5
                                // กำหนดชื่อคลาสของ Icon ตามประเภทไฟล์
                                switch (data_arr[i].file_type) {
                                    case 'image/png':
                                    case 'image/jpeg':
                                    case 'image/gif':
                                        icon.classList.add('fa-file-image');
                                        break;
                                    case 'application/pdf':
                                        icon.classList.add('fa-file-pdf');
                                        break;
                                    case 'application/msword':
                                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                                        icon.classList.add('fa-file-word');
                                        break;
                                    case 'application/vnd.ms-excel':
                                    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                                        icon.classList.add('fa-file-excel');
                                        break;
                                    default:
                                        icon.classList.add('fa-file');
                                        break;
                                }
                                col2.appendChild(icon);
                                var link = document.createElement('a');
                                link.href = data_arr[i].file_path;
                                link.textContent = " " + data_arr[i].originalFileName;
                                link.setAttribute('target', '_blank'); // เพิ่ม code นี้
                                col2.appendChild(link);
                                row.appendChild(col2);

                                var col3 = document.createElement('td');
                                col3.classList.add('text-center');
                                //console.log(data_arr[i].created_at);
                                var created_at = moment(data_arr[i].created_at);
                                col3.textContent = created_at.format('DD MMM YY HH:mm');
                                row.appendChild(col3);

                            }

                            // เพิ่มแถวลงใน tbody
                            tbody.appendChild(row);
                        }


                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });

            }

            // thumbnailclickable
            $('body').on('click', '.thumbnailclickable', function() {
                var target = $(this).attr("value");
                $('#ImageShow').attr('src', target);
                $('#showImageModal').modal('show');
            });
            loadAttachedData();

            // END Process ===========================================




            // Initial Load =============================================================================================
            loadProvinceForSelect();
            loadDriverforSelect();
            loadTruckTypeForSelect();




        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>