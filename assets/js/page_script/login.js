$(document).ready(function () {
    // Initial Page Setting ===============================
    // Load Data from Paramitor 
    const urlParams = new URLSearchParams(window.location.search);
    const redirect = urlParams.get('redirect');


    // Global Var ========================================




    // Page Function =====================================

    function objectifyForm(form_name) {
        //serialize data function
        formArray = form_name.serializeArray();
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++) {
            returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
    }


    function load_login_form_data() {

        data = objectifyForm($("#login_form"));
        data['password'] = CryptoJS.MD5(data['password']).toString()
        // Login Disable 
        $("#error_alert_box").hide();
        $("#login_form input").prop("disabled", true);
        $("#login_form button").prop("disabled", true);

        var add_data = data;
        add_data['f'] = '1';
        //console.log(add_data);
        $.ajax({
            type: 'POST',
            dataType: "text",
            url: 'function/f_login.php',
            data: (add_data)
        })
            .done(function (data) {
                console.log(data);

                $("#login_form input").prop("disabled", false);
                $("#login_form button").prop("disabled", false);
                if (data == "1") {
                    $("#error_alert_box").hide();
                    if ($.trim(redirect) != "") {

                        window.location.href = redirect;
                    }
                    else {

                        window.location.href = "index.php";
                    }
                } else {
                    $("#error_alert_box").show();
                }

            })
            .fail(function () {
                // just in case posting your form failed
                alert("Posting failed.");
            });


    }

    $('#kt_sign_in_submit').on('click', function () {
        load_login_form_data();
    })



    // Initial Run on startup================================







});