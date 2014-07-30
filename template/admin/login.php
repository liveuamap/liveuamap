<?defined('WERUA') or include('../bad.php');?>
<div class="top_line_index_all"><img src="../modules/admin/images/bg_top_all.jpg" width="100%" height="5"></div>

<!--content-->
<div class="content_all">



    <div class="right_block_header">
        <table width="100%" >
            <tr>
                <td><div class="left_top_link"><a class="logotiplink" href="<? WRA::e(WRA::base_url()); ?>">&larr; Сайт</a> <span>Панель администрирования</span></div></td>
            </tr>
        </table></div>




    <!--login-->
    <table width="100%" height="80%" >
        <tr>
            <td align="center">
                <div class="login_bg_out">
                    <div class="login_block" >


                        <div class="form_login">
                            <form name="loginform" id="loginform" action="<?php WRA::e(WRA::base_url()); ?>admin/login" method="post"> 
                                <input type="text" name="admin_login" id="admin_login" class="input" tabindex="10" value="Логин"><br>
                                <input type="password" name="admin_pass" id="admin_pass" class="input" value="" tabindex="20"><br>

                                <div class="remember_login" align="right"><br>
                                    <div class="remember_me"><label><input name="rememberme" type="checkbox" id="rememberme" value="rembme" tabindex="90"> Запомнить меня</label></div>
                                </div>

<?php if ($this->wfitem->enter_try != 0) { ?> 
                                    <div id="login_error">
                                    <?php
                                    switch ($this->wfitem->enter_try) {
                                        case 1:
                                            WRA::e("Такого пользователя не существует");
                                            break;
                                        case 2:
                                            WRA::e("Пароль введен неправильно!");
                                            break;
                                        case 3:

                                            WRA::e("У вас нет прав Администратора");

                                            break;
                                    }
                                    ?>
                                    </div>
                                    <? } ?>

                                <input type="submit" name="loginbutton" id="loginbutton" class="submitbutton" value="Войти" tabindex="100">

                            </form>


                        </div>




                    </div>
                </div>
            </td>
        </tr>
    </table>


    <!--end login-->



</div>

<!--end content-->
