<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <!-- เรียกใช้ CSS ของ Admin LTE CSS HTML Framework -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/dev/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/dev/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/dev/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/dev/AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- เรียกใช้ Navbar ของ Admin LTE CSS HTML Framework -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>

        <!-- เรียกใช้ Sidebar ของ Admin LTE CSS HTML Framework -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">Add Customer</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">User Name</a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- เรียกใช้ Content ของ Admin LTE CSS HTML Framework -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Add Customer</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Customer Information</h3>
                                </div>
                                <form>
                                <div class="card-body">
    <div class="form-group">
        <label for="customer-name">Customer Name</label>
        <input type="text" class="form-control" id="customer-name" placeholder="Enter customer name">
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <textarea class="form-control" id="address" rows="3" placeholder="Enter address"></textarea>
    </div>
    <div class="form-group">
        <label for="contact-person">Contact Person</label>
        <input type="text" class="form-control" id="contact-person" placeholder="Enter contact person name">
    </div>
    <div class="form-group">
        <label for="phone-number">Phone Number</label>
        <input type="text" class="form-control" id="phone-number" placeholder="Enter phone number">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="line-token">Line Token</label>
        <input type="text" class="form-control" id="line-token" placeholder="Enter Line token">
    </div>
    <div class="form-group">
        <label for="attr1">Attr1</label>
        <input type="text" class="form-control" id="attr1" placeholder="Enter Attr1">
    </div>
    <div class="form-group">
        <label for="attr2">Attr2</label>
        <input type="text" class="form-control" id="attr2" placeholder="Enter Attr2">
    </div>
    <div class="form-group">
        <label for="attr3">Attr3</label>
        <input type="text" class="form-control" id="attr3" placeholder="Enter Attr3">
    </div>
    <div class="form-group">
        <label for="attr4">Attr4</label>
        <input type="text" class="form-control" id="attr4" placeholder="Enter Attr4">
    </div>
    <div class="form-group">
        <label for="attr5">Attr5</label>
        <input type="text" class="form-control" id="attr5" placeholder="Enter Attr5">
    </div>
    <div class="form-group">
        <label for="create-datetime">Create Datetime</label>
        <input type="datetime-local" class="form-control" id="create-datetime">
    </div>
    <div class="form-group">
        <label for="update-datetime">Update Datetime</label>
        <input type="datetime-local" class="form-control" id="update-datetime">
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>
</div>
</div>
</div>
</section>
</div>

<!-- เรียกใช้ Script ของ Admin LTE CSS HTML Framework -->
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/moment/moment.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/dist/js/adminlte.min.js"></script>
<script>
    $(function() {
        // Validate form inputs
        $("form").validate({
            rules: {
                "customer-name": {
                    required: true
                },
                "address": {
                    required: true
                },
                "contact-person": {
                    required: true
                },
                "phone-number": {
                    required: true,
                    digits: true
                },
                "email": {
                    required: true,
                    email: true
                },
                "line-token": {
                    required: true
                }
            },
            messages: {
                "customer-name": {
                    required: "Please enter customer name"
                },
                "address": {
                    required: "Please enter address"
                },
                "contact-person": {
                    required: "Please enter contact person name"
                },
                "phone-number": {
                    required: "Please enter phone number",
                    digits: "Please enter only digits"
                },
                "email": {
                    required: "Please enter email",
                    email: "Please enter valid email"
                },
                "line-token": {
                    required: "Please enter Line token"
                }
            },
            submitHandler: function() {
                // Serialize form data to JSON
                var formData = JSON.stringify($("form").serializeArray());
                // Send AJAX request to server
                $.ajax({
                    url: "process.php",
                    method: "POST",
                    data: {
                        data: formData
                    },
                    success: function(response) {
                        // Show success message and clear form inputs
                        alert(response);
                        $("form")[0].reset();
                    },
                    error: function(xhr, status, error) {
                        // Show error message
                        alert("An error occurred while processing request: " + error);
                    }
                });
                return false;
            }
        });
    });
</script>
</body>
</html>

