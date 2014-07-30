<?php
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

?>
<div class="right_block_header">
    <table width="100%" >
        <tr>
            <td><div class="left_top_link"><a href="<?= WRA::base_url() ?>">&larr; Сайт</a> <span>Панель администрирования</span></div></td>
            <td width="35%" valign="bottom">
                <a href="?clearcache=true">Очистить кеширование</a>
            </td>
            <td valign="bottom"></td>
            <td valign="bottom"><div class="exit_user" align="right"><span><? if (isset($cp->currentuser)) {
    WRA::e($cp->currentuser->namei . ' ' . $cp->currentuser->namef);
} ?></span> <img src="<?WRA::e(WRA::base_url());?>modules/admin/images/exit_ico.png" width="13" height="14" align="absmiddle"> <a href="<?WRA::e(WRA::base_url());?>admin/exit">Выйти</a></div></td>
        </tr>
    </table></div>

