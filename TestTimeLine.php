<!DOCTYPE html>
<html lang="en">

<head>
    <title>วิธีการ รับ System Line ID</title>
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
        .timeline {
            list-style-type: none;
            position: relative;
            overflow: auto;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 50%;
            width: 100%;
            height: 2px;
            background-color: #ddd;
            transform: translateY(-50%);
        }

        .timeline-node {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .timeline-node::before {
            content: '';
            position: absolute;
            top: 50%;
            width: 2px;
            height: 100%;
            background-color: #ddd;
            transform: translateY(-50%);
        }

        .timeline-node h4 {
            margin-top: 20px;
        }

        .fa-stack {
            transform: translateY(-50%);
        }
    </style>
</head>


<body>

    <div class="container">
        <ul class="timeline d-flex flex-row justify-content-around p-5">
            <li class="timeline-node">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                    <i class="fa fa-stack-1x text-white">1</i>
                </span>
                <h4 class="timeline-title">สถานะ 1</h4>
            </li>
            <li class="timeline-node">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x text-warning"></i>
                    <i class="fas fa-truck fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="timeline-title">สถานะ 2</h4>
            </li>
            <li class="timeline-node">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x text-info"></i>
                    <i class="fa fa-stack-1x text-white">3</i>
                </span>
                <h4 class="timeline-title">สถานะ 3</h4>
            </li>
            <li class="timeline-node">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                    <i class="fa fa-stack-1x text-white">4</i>
                </span>
                <h4 class="timeline-title">สถานะ 4</h4>
            </li>
        </ul>
    </div>

</body>


</html>