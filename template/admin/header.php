<?php defined('WERUA') or include('../bad.php');

?><!DOCTYPE html>
<html>
    <head>
        <title><?WRA::e($this->wf->cp->pagehead);?></title>
        <link href="<?WRA::e(WRA::base_url());?>images/favicon.png" type="image/ico" rel="icon">
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta property="og:image" content="<?WRA::e(WRA::base_url());?>images/post.png" />
        <link rel="image_src" href="<?WRA::e(WRA::base_url());?>images/post.png" />
        <meta name="keywords" content="<?php WRA::e(WRA_CONF::$keywords);?>" />
        <meta name="description" content="<?php WRA::e(WRA_CONF::$description);?>" /> 
        <?php for($i=0;$i<count($this->wf->cp->styles);$i++){?><link href="<?php WRA::e($this->wf->cp->styles[$i]); ?>ed" type="text/css" rel="Stylesheet" /><?} ?>
        <?php for($i=0;$i<count($this->wf->cp->scripts);$i++){?><script src="<?php WRA::e($this->wf->cp->scripts[$i]); ?>ed" type="text/javascript"></script><?} ?>
    </head>
    <body<? if($this->cp->bodyclass!=''){?> class="<?php WRA::e($this->wf->cp->bodyclass); ?>"<?} ?>><div id="fb-root"></div>
  <script type="text/javascript">wwwpath='<?WRA::e(WRA::base_url());?>';</script>
        <form id="frmadmin" method="post" enctype="multipart/form-data">
  <input type="hidden" id="btnclicked" name="btnclicked" value="" />
	
		<div class="header" align="center">
			<div class="time"><a class="logotiplink" href="<? WRA::e(WRA::base_url()); ?>"></a></div>
			<div class="time_colored_select">
                Администрирование сайта
			</div>

			<div class="data_time_calendar">
                            Текущий пользователь: <?php WRA::e($this->wf->user->namei); ?>
                            <?if($this->noticecount>0){?>
                            <a href="<? WRA::e(WRA::base_url()); ?>admin/adminnotices">  уведомления: <?WRA::e($this->noticecount);?></a><?}?>
						</div>
			<div class="remembers"><a href="<? WRA::e(WRA::base_url()); ?>admin/?clearcache=true">очистить кеш</a></div>
			<div class="Today"><a href="<? WRA::e(WRA::base_url()); ?>admin/login?act=logout">Выход</a></div>
		</div>
		<div class="header2" align="center"></div>
		<div class="main">
			<div class="reserved_to_menu"></div>
<div class="right_menu">
				<div class="prn_img" style="margin-top:50px; width:97px; margin-left:35px;float:left; top:20px; margin-top: 13px; margin-left: 5px;"></div>
                               <?if(false){?> <div style="padding-left:11px;"><input type="button" id="btnsave" name="btnsave" value="Сохранить"   /></div><?}?>
    <div class="data_text"><a href="<? WRA::e(WRA::base_url()); ?>admin">Настройки</a></div>
    <?php foreach ($this->adminnodes as $a0) { ?>
        <div class="data_text"><a href="<? WRA::e(WRA::base_url()); ?><?WRA::e($a0->link); ?>"><?WRA::e($a0->name); ?></a></div>
    <? } ?>
	</div>
            <div class="content">

