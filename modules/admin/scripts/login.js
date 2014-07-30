$(document).ready(function() {
       $("#admin_login").focus(function () {
        if ($(this).val() == "Логин") $(this).val('');

    });
    $("#admin_login").blur(function () {

        if ($(this).val() == "") $(this).val('Логин');
    });
    try {

        $('#admin_login').focus();
    } catch (e) { }
    $("#remembbutton").click(function() {


    });

    $("#remember-password-link").click(function() {

    $("#rememberdiv").css("display", "none");
    $("#logindiv").css("display", "block");
    });

    $("#forget-password-link").click(function() {
        $("#logindiv").css("display", "none");
        $("#rememberdiv").css("display", "block");
    });
});