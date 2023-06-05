<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
?>

<head>
    <title>บริหารจัดการรถ > เพิ่มข้อมูล</title>
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
                                    <li class="breadcrumb-item text-muted">
                                        <a href="042_truckInfo.php" class="text-muted text-hover-primary">บริหารจัดการรถ | ข้อมูลรถบรรทุก</a>
                                    </li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"> </span>
                                    </li>
                                    <li class="breadcrumb-item text-dark">เพิ่มข้อมูลรถบรรทุก</li>
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
                                            <h1><i class="bi bi-truck fs-3"></i></i> เพิ่มข้อมูลรถบรรทุก</h1>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">
                                                <form id="truckForm" method="post" enctype="multipart/form-data">

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
                                                                <input type="text" class="form-control" id="capacity" name="capacity" autocomplete="off" />
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
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-8">
                                                            <button type="reset" class="btn btn-secondary" onclick="location.reload();">ล้างข้อมูล</button>
                                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>บันทึกข้อมูล</button>
                                                        </div>
                                                    </div>





                                                </form>
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
                <!--end::Footer-->
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
            // Set Moment 
            moment.locale('th');



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

            $('.dateFormatter').each(function() {
                var dateString = $(this).text();
                if (moment(dateString).isValid()) {
                    var formattedDate = moment(dateString).format('D MMM YYYY');
                    var diffDays = moment().diff(moment(formattedDate, 'D MMM YYYY', 'th'), 'days');
                    if (diffDays < 90) {
                        $(this).addClass('text-danger');
                    }
                    $(this).text(formattedDate);
                } else {
                    $(this).text('');
                }
            });

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

            $("#truckForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง

                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = 4;
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
                            // Redirect ไปยังหน้า 042B_truckInfoDetail.php พร้อมกับส่งค่า truck_id ที่ต้องการไปด้วย parameter
                            window.location.href = "042B_truckInfoDetail.php?truck_id=" + data;
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



            // Initial Load =====
            loadProvinceForSelect();
            loadDriverforSelect();
            loadTruckTypeForSelect();




        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>