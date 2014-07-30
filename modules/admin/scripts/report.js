$(document).ready(function () {


    $("#ctl00_cp1_admin_login").focus(function () {
        if ($(this).val() == "E-mail") $(this).val('');

    });
    $("#ctl00_cp1_admin_login").blur(function () {

        if ($(this).val() == "") $(this).val('E-mail');
    });


    $("#ctl00_cp1_admin_ulogin").focus(function () {
        if ($(this).val() == "Ваш e-mail") $(this).val('');

    });
    $("#ctl00_cp1_admin_ulogin").blur(function () {

        if ($(this).val() == "") $(this).val('Ваш e-mail');
    });
    $("#ctl00_cp1_admin_upage").focus(function () {
        if ($(this).val() == "Страница") $(this).val('');

    });
    $("#ctl00_cp1_admin_upage").blur(function () {

        if ($(this).val() == "") $(this).val('Страница');
    });

});