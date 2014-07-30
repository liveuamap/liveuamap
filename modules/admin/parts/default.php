<?php
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');
$this->wf->cp->add_script("../modules/admin/scripts/options.js");
$this->wf->cp->add_script("../modules/admin/scripts/default.js");
if (isset($_REQUEST['clearcache'])) {

        wra_cacheflow::clearcache();       
    
}
if (isset($_POST['googleanalytics'])) {

        wra_options::updatevalue("googleanal", WRA::getpost('googleanalytics'));
    
}
if (isset($_POST['yandexmetrics'])) {

        wra_options::updatevalue("yandexmetrics", WRA::getpost('yandexmetrics'));
    
}
if (isset($_POST['facebook'])) {

        wra_options::updatevalue("facebook", WRA::getpost('facebook'));
    
}
if (isset($_POST['vkontakte'])) {

        wra_options::updatevalue("vkontakte", WRA::getpost('vkontakte'));

}
function flushpage($currentlink, $cap) {
    ?><div><h1>Администрирование сайта. Общие настройки</h1></br></div>
<div class="content_edit">
    <div class="input_edit">
        <table id="" width="100%" class="adminedittbl table_edit" cellpadding="0" cellspacing="0">
            <tbody>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td colspan="2"><b>Общие настройки</b></td>
                </tr>
                <tr >
                    <td style="width:120px"><?$googleanal=wra_options::getvalue('googleanal');?>
                        <label>Код Google-Analytics</label></td>
                    <td><textarea name="googleanalytics" style="height:300px"><?WRA::e($googleanal);?></textarea></td>
                </tr>
                <tr >
                    <td style="width:120px"><?$googleanal=wra_options::getvalue('yandexmetrics');?>
                        <label>Код Яндекс-Метрики</label></td>
                    <td><textarea name="yandexmetrics" style="height:300px"><?WRA::e($googleanal);?></textarea></td>
                </tr>
                <tr >  <td style="width:120px"><?$googleanal=wra_options::getvalue('banner330');?>
                        <label>Баннер справа(330x128)</label></td>
                    <td><textarea name="banner330" style="height:200px"><?WRA::e($googleanal);?></textarea></td>
                </tr>
              
                <tr >  <td style="width:120px"><?$googleanal=wra_options::getvalue('facebook');?>
                        <label>Like Box Facebook</label></td>
                    <td><textarea name="facebook" style="height:200px"><?WRA::e($googleanal);?></textarea></td>
                </tr>
                <tr >  <td style="width:120px"><?$googleanal=wra_options::getvalue('vkontakte');?>
                        <label>Like Box Vkontakte</label></td>
                    <td><textarea name="vkontakte" style="height:200px"><?WRA::e($googleanal);?></textarea></td>
                </tr>
              
                <tr >  <td style="width:120px">
                        <label>Кеширование</label></td>
                    <td><input type="button" value="Очистить Кеш" id="clearbutton"/></td></tr>
                <tr><td><br><a href="#" class="link_save" id="link-save">Сохранить</a></td><td></td></tr>
            </tbody></table></div>
</div>


    <?
}
?>