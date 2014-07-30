<?php
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');
?>
<td valign="top"> <div class="block_main_content_cn">
<?
switch($useleftmenu){
case 0:

$topmenu=wra_adminmenu::getlist0();?>
            <div>
              
                
                <? 
                $createltblock=1;
                $curp=WRA::getcurpage();
                foreach($topmenu as $t0){
                $level1=wra_adminmenu::getlist1nosub($t0->id);
                    $useblock=false;
                     
                    foreach($level1 as $l1){
                       
                        if($l1->link."edit"==$curp||$l1->link==$curp||wra_adminmenu::getassoc($curp)==$l1->link){
                        $useblock=true;
                      
                        if($createltblock==2){?>
                        </ul>
                        <?
                         $createltblock=1;}
                        }else{
                        ?><?
                        $levelsub=wra_adminmenu::getlistsub($t0->id,$l1->id);
                         foreach($levelsub as $ls0){
                                if($ls0->link."edit"==$curp||$ls0->link==$curp||wra_adminmenu::getassoc($curp)==$ls0->link){
                                $useblock=true;
                                if($createltblock==2){?>
                                </ul>
                                <?
                                 $createltblock=1;
                                 }
                                
                             }
                        }//конец форич левелсаб
                       
                       
   
                        }//конец элса
                    
                    }
                if(!$useblock){
                if($createltblock==1){
                
                ?><ul class="all_menu_lt_block"><?
                $createltblock=2;
                }
                
                
                ?>
                <li><a href="<? WRA::e($t0->link);?>"><? WRA::e($t0->name);?></a></li>
                
                <?}else{?>
                <h1><span><? WRA::e($t0->name);?></span></h1>
            <ul class="menu_left_sub">
            <? 
 
             foreach($level1 as $l1){
             $levelsub=wra_adminmenu::getlistsub($t0->id,$l1->id);
             $inlevel=false;
             foreach($levelsub as $ls0){
                    if($ls0->link."edit"==$curp||$ls0->link==$curp||wra_adminmenu::getassoc($curp)==$ls0->link){
                    $inlevel=true;
                    
                    }
             }
             if($l1->link."edit"==$curp||$l1->link==$curp||wra_adminmenu::getassoc($curp)==$l1->link){
             
             ?><li class="over_menu"><a href="<? WRA::e($l1->link);?>"><? WRA::e($l1->name);?></a></li><?
             if(count($levelsub)>0){
             ?><div class="menu_sub_main">
                <ul>
                <?foreach($levelsub as $l2){
                 if($l2->link."edit"==$curp||$l2->link==$curp||wra_adminmenu::getassoc($curp)==$l2->link){?><li class="over_sub_main"><a href="<? WRA::e($l2->link);?>"><? WRA::e($l2->name);?></a></li><?

                }else{
                             ?><li><a href="<? WRA::e($l2->link);?>"><? WRA::e($l2->name);?></a></li><?
                
                }
                }?>
                </ul>
                </div><?}
             }else{
             if(!$inlevel){
             ?><li><a href="<? WRA::e($l1->link);?>"><? WRA::e($l1->name);?></a></li><?
             }else{
               ?><li class="over_menu"><a href="<? WRA::e($l1->link);?>"><? WRA::e($l1->name);?></a></li><?
             ?><div class="menu_sub_main">
                <ul>
                <?foreach($levelsub as $l2){
                 if($l2->link==$curp||wra_adminmenu::getassoc($curp)==$l2->link){?><li class="over_sub_main"><a href="<? WRA::e($l2->link);?>"><? WRA::e($l2->name);?></a></li><?

                }else{
                             ?><li><a href="<? WRA::e($l2->link);?>"><? WRA::e($l2->name);?></a></li><?
                
                }
                }?>
                </ul>
                </div><?
             }
             }
             
             }
            ?>
            </ul>
                
                <?}?>
                <?}
                

                
                if($createltblock){?>
                </ul><?}?>
               

            </div>

<?

break;
case 1:

break;
}?>
    </div></td>