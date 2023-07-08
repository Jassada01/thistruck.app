<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php
include 'system_config.php';
$CURRENT_URL = str_replace($SERVERDIRNAME, "", $_SERVER['REQUEST_URI']);
include 'check_cookie.php';
$selectMonth = date('mY');
if (isset($_GET['selectMonth'])) {
    $selectMonth = $_GET['selectMonth'];
}
?>

<head>
    <title>รายงานประจำเดือน(รายทริป) <?php echo $selectMonth; ?></title>
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
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

    <!--end::Global Stylesheets Bundle-->
    <style>
        th {
            white-space: nowrap;
        }

        /* ไฮไลต์แถว */
        .highlight-row {
            background-color: #ffffcc;
        }

        /* ไฮไลต์คอลัมน์ */
        .highlight-column {
            background-color: #dddddd;
        }

        .no-border {
            flex-grow: 1;
            width: auto;
            border: none;
            outline: none;
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
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">รายงานประจำเดือน(รายทริป) </h1>
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
                                    <li class="breadcrumb-item text-dark">รายงานประจำเดือน(รายทริป) </li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">
                                <select class="form-select form-select-solid" id="selectMonth">
                                </select>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid d-flex align-items-stretch justify-content-between">
                            <!--begin::Row-->
                            <div class="row gy-5 g-xl-8">
                                <!-- เริ่มต้น Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-sm-9 mt-3 d-flex align-items-center px-3">
                                            <h1><i class="bi bi-layers fs-3"></i> รายงานประจำเดือน(รายทริป) - <?php echo $selectMonth; ?></h1>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="dataTable" class=" table-hover table-rounded  table-bordered gy-7 gs-7" cellspacing="0" width="100%">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>job_id</th>
                                                    <th>เลขจ๊อบ</th>
                                                    <th>ชื่องาน</th>
                                                    <th>วันที่</th>
                                                    <th>trip_id</th>
                                                    <th>เลขทริป</th>
                                                    <th>ลำดับทริปในจ๊อบ</th>
                                                    <th>ทะเบียน</th>
                                                    <th>พขร</th>
                                                    <th>ราคางาน</th>
                                                    <th>ค่าล่วงเวลา</th>
                                                    <th>ค่าผ่านท่า</th>
                                                    <th>ค่าผ่านลาน</th>
                                                    <th>ค่ารับตู้/คืนตู้</th>
                                                    <th>ค่าซ่อมตู้</th>
                                                    <th>ค่าล้างตู้</th>
                                                    <th>ค่าใช้จ่ายอื่นๆ</th>
                                                    <th>remark</th>
                                                    <th>ใบหัก ณ ที่จ่ายกระทำแทน</th>
                                                    <th>ค่าชอร์(SHORE)</th>
                                                    <th>รวมค่าใช้จ่าย</th>
                                                    <th>ค่าเดินทาง/ค่าเที่ยว</th>
                                                    <th>ค่าใช้จ่ายรถ</th>
                                                </tr>
                                            </thead>
                                        </table>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>

    <!-- Data table JS -->
    <!-- เรียกใช้งานไลบรารี DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- เรียกใช้งานไลบรารี DataTables Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
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


            var selectMonth = $("#selectMonth");
            var selectedValue = "<?php echo $selectMonth; ?>";

            // สร้าง Option สำหรับเดือนตั้งแต่ 07-2022 จนถึง 01-2023
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();
            var currentMonth = currentDate.getMonth() + 1;

            for (var year = currentYear; year >= 2000; year--) {
                var startMonth = (year === currentYear) ? currentMonth : 12;
                var endMonth = (year === 2000) ? 7 : 1;

                for (var month = startMonth; month >= endMonth; month--) {
                    var monthString = month.toString().padStart(2, "0");
                    var option = $("<option></option>")
                        .attr("value", monthString + year)
                        .text(monthString + "-" + year);
                    selectMonth.append(option);

                    if (year === 2023 && month === 1) {
                        break;
                    }
                }

                if (year === 2023 && month === 1) {
                    break;
                }
            }

            if (selectedValue && selectedValue !== "") {
                // เลือกตัวเลือกที่มีค่าตรงกับ SelectedValue
                selectMonth.val(selectedValue);
            }

            // เมื่อมีการเปลี่ยนค่าใน Select
            selectMonth.on("change", function() {
                var selectedValue = $(this).val();

                // เปลี่ยนหน้าเพจไปที่ 200_monthlyReport.php พร้อมกับส่งพารามิเตอร์ selectMonth
                window.location.href = "202_monthlyReportDetailEdit.php?selectMonth=" + selectedValue;
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

            let table; // ประกาศตัวแปร table นอกฟังก์ชัน


            function loadMonthlyReportDetail() {
                var ajaxData = {};
                ajaxData['f'] = '1';
                ajaxData['selectMonth'] = '<?php echo $selectMonth; ?>';
                console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/20_report/mainFunction.php',
                        data: (ajaxData),
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        table = new DataTable('#dataTable', {
                            data: data_arr,
                            columns: [{
                                    data: 'job_id',
                                    columnName: 'job_id',
                                    editable: false,

                                },
                                {
                                    data: 'job_no',
                                    columnName: 'job_no',
                                    editable: false
                                },
                                {
                                    data: 'job_name',
                                    columnName: 'job_name',
                                    editable: false
                                },
                                {
                                    data: 'job_date',
                                    columnName: 'job_date',
                                    editable: false
                                },
                                {
                                    data: 'trip_id',
                                    columnName: 'trip_id',
                                    editable: false,

                                },
                                {
                                    data: 'tripNo',
                                    columnName: 'tripNo',
                                    editable: false
                                },
                                {
                                    data: 'tripSeq',
                                    columnName: 'tripSeq',
                                    editable: false
                                },
                                {
                                    data: 'truck_licenseNo',
                                    columnName: 'truck_licenseNo',
                                    editable: false
                                },
                                {
                                    data: 'driver_name',
                                    columnName: 'driver_name',
                                    editable: false
                                },
                                {
                                    data: 'hire_price',
                                    columnName: 'hire_price',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'overtime_fee',
                                    columnName: 'overtime_fee',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'port_charge',
                                    columnName: 'port_charge',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'yard_charge',
                                    columnName: 'yard_charge',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'container_return',
                                    columnName: 'container_return',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'container_cleaning_repair',
                                    columnName: 'container_cleaning_repair',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'container_drop_lift',
                                    columnName: 'container_drop_lift',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'other_charge',
                                    columnName: 'other_charge',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'remark',
                                    columnName: 'remark',
                                    editable: true
                                },
                                {
                                    data: 'deduction_note',
                                    columnName: 'deduction_note',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'expenses_1',
                                    columnName: 'expenses_1',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'total_expenses',
                                    columnName: 'total_expenses',
                                    editable: false,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'wage_travel_cost',
                                    columnName: 'wage_travel_cost',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                },
                                {
                                    data: 'vehicle_expenses',
                                    columnName: 'vehicle_expenses',
                                    editable: true,
                                    render: function(data, type, row) {
                                        if (type === 'display' && $.isNumeric(data)) {
                                            return $.number(data, 2); // ใช้ jQuery Number Plugin เพื่อแสดงผลในรูปแบบที่กำหนด
                                        }
                                        return data;
                                    }
                                }
                            ],
                            search: {
                                return: true,
                            },
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
                            },
                            "pageLength": 25 // กำหนดให้แสดงแถวต่อหน้าเริ่มต้นที่ 50 แ
                        });


                        table.on('click', 'tbody td', function() {
                            var cell = $(this);
                            var columnIdx = cell.index();
                            var columnTitle = table.column(columnIdx).settings().init().columns[columnIdx].columnName;
                            var rowIdx = table.cell(cell).index().row;
                            var rowData = table.row(rowIdx).data();
                            var jobID = rowData.job_id;
                            var tripID = rowData.trip_id;

                            var columnNode = table.column(cell).nodes();






                            //console.log('Column:', columnTitle);
                            //console.log('job_id:', jobID);
                            //console.log('trip_id:', tripID);

                            if (!table.column(columnIdx).settings().init().columns[columnIdx].editable) {
                                cell.addClass('not-editable');
                            } else if (!cell.hasClass('editing')) {
                                cell.addClass('editing');

                                var originalContent = cell.text();
                                if (columnTitle != "remark") {
                                    originalContent = parseFloat(originalContent.replace(/,/g, ''));
                                }


                                var input = $('<input type="text" class="editable-cell no-border " value="' + originalContent + '">');
                                cell.html(input);

                                // เพิ่มไฮไลต์ให้คอลัมน์ที่คลิก
                                $(columnNode).addClass('highlight-column');

                                input.on('keypress blur', function(e) {
                                    if (e.which === 13 || e.type === 'blur') {
                                        e.preventDefault();
                                        if (!cell.hasClass('not-editable')) {
                                            var newContent = input.val();

                                            // ตรวจสอบว่าเป็นตัวเลขหรือไม่ (ยกเว้นคอลัมน์ 'remark')
                                            //console.log(columnTitle)
                                            if (columnTitle !== 'remark' && !$.isNumeric(newContent)) {
                                                Swal.fire({
                                                    title: 'กรุณากรอกข้อมูลเฉพาะตัวเลขเท่านั้น',
                                                    icon: 'warning',
                                                    confirmButtonColor: '#3085d6',
                                                    confirmButtonText: 'ตกลง'
                                                }).then(function() {
                                                    cell.html(originalContent);
                                                    cell.removeClass('editing');
                                                    cell.blur();
                                                });
                                                return;
                                            } else {
                                                if ($.isNumeric(newContent))
                                                {
                                                    cell.html($.number(newContent, 2));
                                                }
                                                else
                                                {
                                                    cell.html(newContent);
                                                }
                                                
                                                if (newContent != originalContent) {
                                                    updateCostValue(jobID, tripID, columnTitle, newContent, rowIdx, columnIdx);
                                                }

                                                // ทำการบันทึกข้อมูลที่อัพเดตเพิ่มเติม
                                                // คุณสามารถใช้ Ajax เพื่อส่งข้อมูลที่อัพเดตไปยังเซิร์ฟเวอร์เพื่อบันทึกได้ตามต้องการ
                                            }


                                        }

                                        cell.removeClass('editing');
                                        $(columnNode).removeClass('highlight-column');
                                    }
                                });

                                input.focus();
                            }
                        });

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }


            function updateCostValue(jobID, trip_id, columnTitle, newContent, rowIdx, columnIdx) {
                var ajaxData = {};
                ajaxData['f'] = '2';
                ajaxData['jobID'] = jobID;
                ajaxData['trip_id'] = trip_id;
                ajaxData['columnTitle'] = columnTitle;
                ajaxData['newContent'] = newContent;
                ajaxData['updateName'] = '<?php echo $MAIN_USER_DATA->name; ?>';
                //console.log(ajaxData);
                $.ajax({
                        type: 'POST',
                        dataType: "text",
                        url: 'function/20_report/mainFunction.php',
                        data: (ajaxData),
                    })
                    .done(function(data) {
                        //console.log(data);
                        var data_arr = JSON.parse(data);
                        //console.log(data_arr);
                        //console.log(data_arr[0].total_expenses)
                        //location.reload();
                        // ตัวอย่างการอัปเดตข้อมูลในเซลล์แถวแรกคอลัมน์ที่สอง
                        table.cell(rowIdx, 20).data(data_arr[0].total_expenses).draw();

                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert("Posting failed.");
                    });
            }





            // Load Data from Initail page load =======
            loadMonthlyReportDetail();


        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>