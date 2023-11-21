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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <!-- Data table CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        .editPriceList {
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">ราคาแผนการจัดส่ง</h1>
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
                                    <li class="breadcrumb-item text-dark">ราคาแผนการจัดส่ง</li>
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
                                <button type="button" class="btn  btn-sm  btn-primary" data-bs-toggle="modal" data-bs-target="#addPriceListModal">
                                    <i class="fas fa-plus"></i> เพิ่มเซตราคาแผนการจัดส่ง
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
                                            <h1><i class="bi bi-card-checklist fs-3"></i> รายการราคาแผนการจัดส่ง</h1>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped w-100 d-none" id="locationTable">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="font-weight-bold text-center">ชื่องาน</th>
                                                        <th class="font-weight-bold text-end">ราคา</th>
                                                        <th class="font-weight-bold text-end">ประเภทราคา</th>
                                                        <th class="font-weight-bold text-center">อัพเดท</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <!-- ใช้ PHP หรืออื่นๆในการดึงข้อมูลจากฐานข้อมูล -->
                                                    <?php

                                                    // ส่วนของการเชื่อมต่อฐานข้อมูล
                                                    include "function/connectionDb.php";

                                                    // ส่วนของการดึงข้อมูลจากฐานข้อมูล
                                                    $sql = "SELECT * FROM service_items";
                                                    $result = mysqli_query($conn, $sql);

                                                    // ส่วนของการแสดงข้อมูลผู้ว่าจ้างในตาราง
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $price_type = '<span class="badge badge-light-dark">ราคาคงที่</span>';
                                                        if ($row['dynamicPrice'] == '1') {
                                                            $price_type = '<span class="badge badge-light-danger">ราคาผกผัน</span>';
                                                        }
                                                        echo "<tr>";
                                                        echo "<td class='ml-5'><a class='editPriceList' value='" . $row['id'] . "' jobName='" . $row['item_name'] . "' price='" . $row['price'] . "' description='" . $row['description'] . "'  dynamicPrice='" . $row['dynamicPrice'] . "'>" . $row['item_name'] . "</a></td>";
                                                        echo "<td  class='text-end'>" . $row['price'] . "</td>";
                                                        echo '<td  class="text-end">' . $price_type . '</td>';
                                                        echo "<td  class='text-center'>" . $row['updated_at'] . "</td>";
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
    <!--begin::Modals-->
    <!-- Modal เพิ่มList ราคา -->
    <div class="modal fade" id="addPriceListModal" tabindex="-1" aria-labelledby="addPriceListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPriceListModalLabel">เพิ่มราคาแผนการจัดส่ง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="createPriceForm" method="post" class="m-form m-form--fit m-form--label-align-right">
                                    <div class="form-group mt-3 row">
                                        <label for="item_name" class="col-sm-3 col-form-label text-end-pc">ชื่องาน<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control m-input" id="item_name" name="item_name" required>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="description" class="col-sm-3 col-form-label text-end-pc">คำอธิบาย</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="description" name="description">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="price" class="col-sm-3 col-form-label text-end-pc">ราคา<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="price" name="price" required value=0>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveNewPrice">บันทึก</button>
                </div>
            </div>
            </form>

        </div>
    </div>

    <!-- Modal EditList ราคา -->
    <div class="modal fade" id="editPriceListModal" tabindex="-1" aria-labelledby="editPriceListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPriceListModalLabel">แก้ไขราคาแผนการจัดส่ง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form id="editPriceForm" method="post" class="m-form m-form--fit m-form--label-align-right">
                                    <div class="form-group mt-3 row">
                                        <label for="edit_item_name" class="col-sm-3 col-form-label text-end-pc">ชื่องาน<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control m-input" id="edit_item_name" name="item_name" required>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="edit_description" class="col-sm-3 col-form-label text-end-pc">คำอธิบาย</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control m-input" id="edit_description" name="description">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="edit_price" class="col-sm-3 col-form-label text-end-pc">ราคา<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control m-input" id="edit_price" name="price" required value=0>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 row">
                                        <label for="editDynamicPrice" class="col-sm-3 col-form-label text-end-pc">ราคาผกผัน</label>
                                        <div class="col-sm-3 ">
                                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid me-10 ">
                                                <input class="form-check-input h-30px w-50px align-items-center" type="checkbox" value="" id="editDynamicPrice" name="editDynamicPrice" checked />
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dynamicPricePanel" class="d-none">
                                        <div class="form-group mt-3 row">
                                            <label for="starter_price" class="col-sm-3 col-form-label text-end-pc">ราคาตั้งต้น<span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-5">
                                                    <input type="text" class="form-control" id="starter_price" name="starter_price" autocomplete="off" aria-describedby="basic-addon2" />
                                                    <span class="input-group-text" id="basic-addon2">บาท</span>
                                                </div>
                                            </div>
                                            <label class="col-sm-5 col-form-label text-end-pc">ณ. ขณะที่น้ำมันราคา 20 บาท</label>
                                        </div>
                                        <div class="form-group mt-3 row">
                                            <label for="dynamicChangePrice" class="col-sm-3 col-form-label text-end-pc">ราคาเพิ่ม<span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-5">
                                                    <input type="text" class="form-control" id="dynamicChangePrice" name="dynamicChangePrice" autocomplete="off" aria-describedby="basic-addon2" />
                                                    <span class="input-group-text" id="basic-addon2">บาท</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group mb-5">
                                                    <span class="input-group-text" id="basic-addon2">ต่อราคาน้ำมัน<span class="text-danger">*</span></span>
                                                    <input type="text" class="form-control" id="dynamicpriceStape" name="dynamicpriceStape" autocomplete="off" aria-describedby="basic-addon2" />
                                                    <span class="input-group-text" id="basic-addon2">บาท</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container mt-5">
                                            <B><span class="text-danger d-none" id="need-more-text">กรุณากรอกข้อมูลให้ครบถ้วน</span></B>
                                        </div>
                                        <div class="container mt-5">
                                            <div id="priceTable" class="table-responsive">
                                                <!-- ตารางราคาจะถูกแสดงที่นี่ -->
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveNewPrice">บันทึก</button>
                </div>
                </form>
            </div>

        </div>
    </div>
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
            // Global Var -------------------------------------
            let MAIN_EDIT_PRICELIST_ID = '';
            let MAIN_Oil_PRICE = 0.0;
            let priceDetails = [];






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

            let locationTable = $("#locationTable").DataTable({
                search: {
                    return: true,
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                },
                "autoWidth": false,
                "pageLength": 50,
                "columnDefs": [{
                        "targets": 0, // กำหนดให้ column ที่ 0 (นับจาก 0) มีการจัดรูปแบบ
                        "render": function(data, type, row, meta) {
                            // เพิ่มช่องว่างหน้าข้อมูล
                            return "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + data;
                        }
                    },
                    {
                        "targets": 1,
                        "render": function(data, type, row, meta) {
                            return new Intl.NumberFormat().format(data);
                        }
                    }
                ]
            });

            // Show Table 
            locationTable.on('draw', function() {
                $('#locationTable').removeClass('d-none');
            });

            // 
            $("#createPriceForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง
                $('#addPriceListModal').modal('hide');
                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let data = formToObject(this);
                data['f'] = 17;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/06_interface/mainFunction.php',
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

            // editPriceList
            $('body').on('click', '.editPriceList', function() {
                var target = ($(this).attr('value'));
                var jobName = ($(this).attr('jobName'));
                var description = ($(this).attr('description'));
                var price = ($(this).attr('price'));
                var dynamicPrice = ($(this).attr('dynamicPrice'));

                // editPriceListModal
                $('#editPriceListModal').modal('show');

                MAIN_EDIT_PRICELIST_ID = target;
                $("#edit_item_name").val(jobName);
                $("#edit_description").val(description);
                $("#edit_price").val(price);
                //console.log(dynamicPrice);
                if (dynamicPrice == '1') {
                    $("#editDynamicPrice").prop('checked', true);
                    $("#dynamicPricePanel").removeClass("d-none");
                    // Load request data------------
                    loadDynamic_Price();

                } else {
                    $("#editDynamicPrice").prop('checked', false);
                    $("#dynamicPricePanel").addClass("d-none");
                    priceDetails = [];
                    $('#priceTable').html("");
                    //#dynamicChangePrice, #dynamicpriceStape, #starter_price
                    $('#dynamicChangePrice').val("");
                    $('#dynamicpriceStape').val("");
                    $('#starter_price').val("");
                }
            });

            function loadDynamic_Price() {
                var ajaxData = {};
                ajaxData['f'] = '19';
                ajaxData['MAIN_EDIT_PRICELIST_ID'] = MAIN_EDIT_PRICELIST_ID;
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/06_interface/mainFunction.php',
                        data: (ajaxData)
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        $("#dynamicChangePrice").val(data_arr[0].priceStep);
                        $("#dynamicpriceStape").val(data_arr[0].Step);
                        $("#starter_price").val(data_arr[0].priceStart);
                        calculatePriceList();

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            // editDynamicPrice
            $('body').on('change', '#editDynamicPrice', function() {
                if ($(this).prop('checked')) {
                    $("#dynamicPricePanel").removeClass("d-none");
                    calculatePriceList();
                } else {
                    $("#dynamicPricePanel").addClass("d-none");
                    priceDetails = [];
                    $('#priceTable').html("");

                }
            });


            $('body').on('change', '#dynamicChangePrice, #dynamicpriceStape, #starter_price', function() {
                calculatePriceList();
            });

            function calculatePriceList() {
                var dynamicChangePrice = $("#dynamicChangePrice").val();
                var dynamicpriceStape = $("#dynamicpriceStape").val();
                var starter_price = $("#starter_price").val();
                var Current_Price = MAIN_Oil_PRICE;

                if ($.isNumeric(dynamicChangePrice) && $.isNumeric(dynamicpriceStape) && $.isNumeric(starter_price)) {
                    dynamicChangePrice = parseFloat(dynamicChangePrice);
                    dynamicpriceStape = parseFloat(dynamicpriceStape);
                    starter_price = parseFloat(starter_price);

                    let tableContent = `<table  class="table table-hover table-rounded table-striped border gy-2 gs-7"><thead class="thead-dark"><tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200" ><th><B>ราคาน้ำมัน (ปัจจุบัน ${Current_Price.toFixed(2)} บาท)</B></th><th><B>ราคา</B></th></tr></thead><tbody>`;
                    priceDetails = [];
                    for (let oilPrice = 20; oilPrice <= 50; oilPrice += dynamicpriceStape) {
                        let price = starter_price + ((oilPrice - 20) / dynamicpriceStape) * dynamicChangePrice;
                        let min = oilPrice;
                        let max = oilPrice + dynamicpriceStape - 0.01;

                        priceDetails.push({
                            Min: min,
                            Max: max,
                            Price: price
                        }); // สร้างและเพิ่ม object ใน array

                        let rowClass = '';
                        if (Current_Price >= min && Current_Price < max) {
                            rowClass = 'table-danger';
                            $("#edit_price").val(price);
                        }
                        tableContent += `<tr class="${rowClass}"><td>${min.toFixed(2)} - ${max.toFixed(2)}</td><td>${Intl.NumberFormat().format(price.toFixed(2))}</td></tr>`;
                    }

                    tableContent += '</tbody></table>';

                    $('#priceTable').html(tableContent);
                    //console.log(priceDetails); // แสดง array ของ objects ในคอนโซล
                } else {
                    //console.log("One or more values are not numbers.");
                    priceDetails = [];
                    $('#priceTable').html("");
                }
            }



            // Load C
            function loadOilPrice() {
                var ajaxData = {};
                ajaxData['f'] = '11';
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/00_systemManagement/mainFunction.php',
                        data: (ajaxData),
                    })
                    .done(function(data) {

                        var data_arr = JSON.parse(data);
                        var result = {};

                        data_arr.forEach(function(item) {
                            var key = item.type + '_data';
                            result[key] = item;
                        });
                        //console.log();
                        MAIN_Oil_PRICE = parseFloat(result.OilPrice_data.value);
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }

            function isNumericValue(value) {
                return !isNaN(parseFloat(value)) && isFinite(value);
            }


            // editPriceForm
            $("#editPriceForm").submit(function(e) {
                e.preventDefault(); // ปิดการทำงานปกติของฟอร์มเมื่อถูกส่ง
                // เก็บข้อมูลจากฟอร์มลงในตัวแปร formData
                let ajaxData = formToObject(this);
                ajaxData['f'] = 18;
                ajaxData['MAIN_EDIT_PRICELIST_ID'] = MAIN_EDIT_PRICELIST_ID;
                ajaxData['priceDetails'] = priceDetails;
                validate_check = true;
                $("#need-more-text").addClass("d-none");
                if (ajaxData.editDynamicPrice == "1") {
                    validate_check = (isNumericValue(ajaxData.starter_price) &&
                        isNumericValue(ajaxData.dynamicChangePrice) &&
                        isNumericValue(ajaxData.dynamicpriceStape));
                }
                //console.log(ajaxData);
                if (validate_check) {
                    $('#editPriceListModal').modal('hide');
                    $.ajax({
                            type: 'POST',
                            dataType: "text",
                            url: 'function/06_interface/mainFunction.php',
                            data: (ajaxData)
                        })
                        .done(function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        })
                        .fail(function() {
                            // just in case posting your form failed
                            alert("Posting failed.");
                        });
                } else {
                    $("#need-more-text").removeClass("d-none");
                }

            });



            // Initial Run Function =============================
            loadOilPrice();




        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>