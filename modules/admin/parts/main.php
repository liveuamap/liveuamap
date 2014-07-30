<?php defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>'); ?>
<?
$currentlink="index";



function flushpage($currentlink,$cap){
$topmenu=wra_adminmenu::getlist0();


	?>
<div class="block_main_content_cn">
    <?foreach($topmenu as $t0){
    if($t0->showmain){
    ?>
      	    	<div>
    	    <h1><span><?WRA::e($t0->name);?></span></h1>
            <ul>
            <? $level1=wra_adminmenu::getlist1($t0->id);
            foreach($level1 as $t1){
            ?>
            <li><a href="<?WRA::e($t1->link);?>"><?WRA::e($t1->name);?></a></li>
            <?}?>
            </ul>
            </div>
    
    <?
    
    }


}
?> </div><?}?>