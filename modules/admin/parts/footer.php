<?php
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

?>
<!--footer-->
<div class="footer">
<table width="100%">
  <tr>
    <td><div class="logo"><img src="<?WRA::e(WRA::base_url());?>modules/admin/images/logo_workflower.png" width="201" height="44"></div></td>
    <td><div class="link_footer" align="center"><?if (!wra_userscontext::isloged ($this->wf)) {?><a href="/admin/login">Вход</a><?}?></div></td>
    <td><div class="copy" style="text-align:right">&copy; <? WRA::e(WRA::getcuryear($this->wf)); ?> WorkFlower</div></td>
  </tr>
</table>
</div>



