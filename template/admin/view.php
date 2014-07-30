<?php defined('WERUA') or include('../bad.php');
?>
<div class="plan_top">
    <a class="backlink" href="<?php WRA::e(WRA::base_url().$this->curnode->link); ?>">← к списку</a>
<div class="plan_top_header"><span><?php WRA::e($this->curnode->name); ?></span><div class="controls"> 
	<a href="<?php WRA::e(WRA::base_url() . $this->curnode->link . "/edit?id=" . $this->curadmin->curid); ?>">редактировать</a>
</div></div>
<?if($this->curadmin->multilanguages){?>
    <div class="lang_height">
        <div class="lang_block_menu">
            <?foreach($this->wf->languages as $l0){
            	?>
	            <div <?if(wra_lang::getdefault()!=$l0->alias){?>style="display:none"<?}?> id="spla-text-<? WRA::e($l0->alias);?>" class="over_lang spla sptext sp<? WRA::e($l0->alias);?>"><? WRA::e($l0->name);?></div>
	            <div <?if(wra_lang::getdefault()==$l0->alias){?>style="display:none"<?}?> class="lila li<? WRA::e($l0->alias);?>" id="lang-change-<? WRA::e($l0->alias);?>"><a href="#" ><? WRA::e($l0->name);?></a></div>
            <?}?>
        </div>
   </div>
<?}?>
<?php  foreach($this->wf->languages as $v){                      
    $currow=$this->currow[$v->alias];                  
    ?>
    <table class="plan_top_header_table">
	<tbody>
    	<?php foreach($this->curadmin->columns as $ac){
          if ($ac->editstatus == admincolumntype::none) continue;
            if (($this->curadmin->multilanguages)or ($v->alias == wra_lang::getdefault())) {?>
    <tr>
		<td class="td_info td_info_1"><?php WRA::e($ac->header); ?></td>
		<td class="td_patient"><?php 
            //curadmin.currow.values[ac.field]
            $tdcontent=$currow->values[$ac->field];
         
            $curid="txt".$ac->field;
		if($this->info!="")
		    $curid=$this->info."-".$curid;                             
		// form for all languages now must have lagv-index in all fileds
		// not olnly for uselanguages fields
		// if($ac->uselanguages){
        if($this->curadmin->multilanguages)
			if (($ac->editstatus != admincolumntype::images)&&($ac->editstatus != admincolumntype::dropdown)) {	
				$curid.="-".$ac->lang;
			}
		// }                                 
		switch($ac->editstatus){
            case admincolumntype::groupit:
                ?><?
                break;
			case admincolumntype::id:
				?><? WRA::e($tdcontent); ?><input type="hidden" <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" readonly="readonly" value="<? WRA::e($tdcontent); ?>"><?	
				break;
            case admincolumntype::tinymce:
				WRA::e($tdcontent);
            break;
			case admincolumntype::bigtext:
				WRA::e($tdcontent);
				if($ac->classes=="fieldcontent"){
					?>
					<!-- <a href="#" class="uploadpic" id="upic-<? WRA::e($curid); ?>">Загрузить картинку</a> -->
					<div class="uploadedpics" id="upepic-<? WRA::e($curid); ?>">
					<strong >Загруженные картинки</strong><br/>
					<table>
					<tr><td>Картинка</td><td>Путь</td></tr>
					</table>
					</div>
					<br/>
					<!-- <a href="javascript:toggleEditor('<? WRA::e($curid); ?>');">Вкл/Выкл редактор</a> -->
					<?
				}
				break;
			case admincolumntype::check:
				if($tdcontent==""){							
				    $tdcontent=$ac->defaultvalue;
				}
				?><input <? WRA::e($ac->inpprop); ?> <?							
				if($tdcontent==1){							
					WRA::e('checked="checked"');
				}
				?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" type="checkbox" value="ON"/><?
				break;
			case admincolumntype::textsource:
				$subrowi=0;
				?>
				<input <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>"  name="<? WRA::e($curid); ?>" readonly="readonly" value="<? WRA::e($tdcontent);?>" type="hidden"/>
				<input <? WRA::e($ac->inpprop); ?> id="fieldview<? WRA::e($ac->name); ?>"  name="<? WRA::e($curid); ?>" readonly="readonly" value="<?
				while($subrowi<count($ac->items)){
					
					if($ac->items[$subrowi]->key==$tdcontent){
						
						?><? WRA::e($ac->items[$subrowi]->value); ?><?
					}
					
					$subrowi++;	
				}?>"><?
				break;
           	case admincolumntype::textsource_label:
				$subrowi=0;
				?>
				<input <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>"  name="<? WRA::e($curid); ?>" readonly="readonly" value="<? WRA::e($tdcontent);?>" type="hidden"/>
                                        <label><?
				while($subrowi<count($ac->items)){								
					if($ac->items[$subrowi]->key==$tdcontent){									
						?><? WRA::e($ac->items[$subrowi]->value); ?><?
					}
					
					$subrowi++;	
				}?></label><?
				break;
			case admincolumntype::customfield:
				include $ac->customfieldpage;
			break;
			case admincolumntype::multiselect:					
				$subrowi=0;                                                 
				if($tdcontent==""){
				    $tdcontent=$ac->defaultvalue;
				}          
				?><select multiple="multiple" <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>multiple" name="<? WRA::e($curid); ?>multiple[]">
				<?      
				if($ac->canbenull){
					?><option value="0"></option><?		
				}
                foreach($ac->dropdown as $dk=>$dv){                                                          
                    ?><option <?
					if(in_array(intval($dk),$ac->items)){
						WRA::e('selected="selected"');
					}
					?> value="<? WRA::e($dk);?>"><? WRA::e($dv);   ?></option><?								
                }
				?></select><?
				break;
				
			case admincolumntype::dropdown:
				$subrowi=0;                
				if($tdcontent==""){
					$tdcontent=$ac->defaultvalue;
				}                                                         
				?><select <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>">					
				<?                                                       
				if($ac->canbenull){
					?><option value="0"></option><?								
				}                                                 
                foreach($ac->dropdown as $dk=>$dv){                   
                    ?><option <?
					if(intval($dk)==intval($tdcontent)){
						WRA::e('selected="selected"');
					}
					?> value="<? WRA::e($dk);?>"><? WRA::e($dv);   ?></option><?
                }
				?></select><?
				break;
			case admincolumntype::password:				
				?>
				<!-- <input type="password" <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" value=""> -->
				<?	
				break;
			case admincolumntype::pic:
				if($tdcontent!=""){
					?><img src="<? WRA::e(WRA::base_url().$tdcontent); ?>" style="max-width:120px" id="img-<? WRA::e($curid); ?>"/>	<br/>
					<input type="hidden" value="" name="delpicvalue-<? WRA::e($curid); ?>" id="delpicvalue-<? WRA::e($curid); ?>"/>
					<a href="#" class="delpic" id="delpic-<? WRA::e($curid); ?>" >удалить</a><br/>
					<?
				
				}
				?>
				<!-- <input type="file" <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" > -->
				<?	
				break;
			case admincolumntype::file:
				if($tdcontent!=""){
					?><? WRA::e($tdcontent); ?><br/>
					<?
				}else{
					?>
					<!-- <input type="file" <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" > -->
					<?
				}
				break;
			case admincolumntype::doubletext:
				$splitnames=explode(" ",$ac->name);
				$columnbonus=1;
				$val0=$this->rows[$rowi][$splitnames[0]];
				$val1=$this->rows[$rowi][$splitnames[1]]; ?>
				<label><? WRA::e($val0); ?></label>
				<label><? WRA::e($val1); ?></label>
				<?	
				break;
			case admincolumntype::hidden:
				if($tdcontent==""){							
				    $tdcontent=$ac->defaultvalue;
				}
				?><input type="hidden" <? WRA::e($ac->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" value="<? WRA::e($tdcontent); ?>"><?	
				break;
			case admincolumntype::label:				
				?><label><? WRA::e($tdcontent); ?></label><?	
				break;				
			case admincolumntype::datetime:
				$timestamp=$tdcontent;
				if($tdcontent==""){
					$timestamp=date(WRA_CONF::$formattime,time());
				}
				?>
                <input type="text" id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" class="datepicker" value="<?WRA::e($timestamp);?>"/>
                <?	
				break;
			case admincolumntype::images:
				// WRA::debug($tdcontent);
				if($ac->lang==wra_lang::getdefault()){
                    ?>
					<!-- <div class="linkadd bal" target="table_<?php WRA::e($curid);?>_<?php WRA::e($ac->lang);?>" id="linkadd_<?php WRA::e($ac->lang);?>_<?php WRA::e($curid);?>">Добавить фотографию</div>
                    <!-- <div class="linkaddempty bal" target="table_<?php WRA::e($curid);?>_<?php WRA::e($ac->lang);?>" id="linkaddempty_<?php WRA::e($ac->lang);?>_<?php WRA::e($curid);?>">Добавить строку</div> -->
                    <div class="linktable bal" target="table_<?php WRA::e($curid);?>_<?php WRA::e($ac->lang);?>" id="linktabl_<?php WRA::e($ac->lang);?>_<?php WRA::e($curid);?>">Плиткой</div>
                    <br/><br/>
                <?}?>
				<div id="table_<?php WRA::e($curid);?>_<?php WRA::e($ac->lang);?>" class="imgstable" style="width:100%">
					<?php
					// WRA::debug($ac->);
					// empty pic line
					// $imgcount = count($ac->items);
					?>
					<div class="row new empty-img-pattern" id="infopic-new-00" style="display:none;">
						<div class="photo"><img src="" width="120px"/></div>
						<div class="imginfo">
                            <div><span>Id:</span><span  class="id00"  ></span></div>
                            <div><span>Название:</span><input type="text" name="<?php WRA::e($curid);?>_header_<?php WRA::e($ac->lang);?>_old" id="<?php WRA::e($curid);?>_header_<?php WRA::e($ac->lang);?>_old" class="<?php WRA::e($curid);?>_header" value=""/>     
                                <input type="hidden" class="path00" name="<?php WRA::e($curid);?>_path_<?php WRA::e($ac->lang);?>_old" id="<?php WRA::e($curid);?>_path_<?php WRA::e($ac->lang);?>_old" value=""/></div>
                            <div><span>Ссылка</span><textarea  name="<?php WRA::e($curid);?>_link_<?php WRA::e($ac->lang);?>_old" id="<?php WRA::e($curid);?>_link_<?php WRA::e($ac->lang);?>_old" class="<?php WRA::e($curid);?>_link"></textarea></div>
                            <div><span>Описание</span><textarea  name="<?php WRA::e($curid);?>_description_<?php WRA::e($ac->lang);?>_old" id="<?php WRA::e($curid);?>_description_<?php WRA::e($ac->lang);?>_old" class="<?php WRA::e($curid);?>_description"></textarea></div>
                            <div><span>Порядок сортировки</span><input type="text" style="width:50px" name="<?php WRA::e($curid);?>_sortorder_<?php WRA::e($ac->lang);?>_old" id="<?php WRA::e($curid);?>_sortorder_<?php WRA::e($ac->lang);?>_old" class="<?php WRA::e($curid);?>_sortorder" value=""/></div>
                            <div><span>Рамка</span><input type="checkbox"  name="<?php WRA::e($curid);?>_morevisual_<?php WRA::e($ac->lang);?>_old" id="<?php WRA::e($curid);?>_morevisual_<?php WRA::e($ac->lang);?>_old" class="<?php WRA::e($curid);?>_morevisual" value="1"/></div>
                            <div><span>HTML</span><textarea placeholder="HTML"  name="<?php WRA::e($curid);?>_htmlcontent_<?php WRA::e($ac->lang);?>_old" id="<?php WRA::e($curid);?>_htmlcontent_<?php WRA::e($ac->lang);?>_old"  class="<?php WRA::e($curid);?>_htmlcontent"></textarea></div>
                        </div>
						<div class="imginfo">
							<!-- <a href="#" class="deleteinfoimage">удалить</a> -->
						</div>
					</div>
			        <?php
					// end of empty pic line
					foreach ($ac->items as $w0) {
						?>
                        <div class="row old" id="infopic-old-<?WRA::e($w0->id);?>-<?WRA::e($ac->lang);?>">
							<div><img src="<?= WRA::base_url() ?><?WRA::e($w0->tmbpic);?>" width="120px"/></div>
							<div class="imginfo">
                                 <div><span>Id:</span><span class="id00" ><?php WRA::e($w0->id);?></span></div>
                                <div><span>Название:</span><input type="text" name="<?php WRA::e($curid);?>_header_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" id="<?php WRA::e($curid);?>_header_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" class="<?php WRA::e($curid);?>_header" value="<?php WRA::e($w0->header);?>"/>     
                                    <input type="hidden" class="path00" name="<?php WRA::e($curid);?>_path_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" id="<?php WRA::e($curid);?>_path_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" value="<?php WRA::e($w0->header);?>"/></div>
                                <div><span>Ссылка</span><textarea  name="<?php WRA::e($curid);?>_link_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" id="<?php WRA::e($curid);?>_link_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" class="<?php WRA::e($curid);?>_link"><?php WRA::e($w0->link);?></textarea></div>
                                <div><span>Описание</span><textarea  name="<?php WRA::e($curid);?>_description_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" id="<?php WRA::e($curid);?>_description_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" class="<?php WRA::e($curid);?>_description"><?php WRA::e($w0->description);?></textarea></div>
                                <div><span>Порядок сортировки</span><input type="text" style="width:50px" name="<?php WRA::e($curid);?>_sortorder_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" id="<?php WRA::e($curid);?>_sortorder_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" class="<?php WRA::e($curid);?>_sortorder" value="<?php WRA::e($w0->sortorder);?>"/></div>
                                <div><span>Рамка</span><input type="checkbox"  name="<?php WRA::e($curid);?>_morevisual_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" id="<?php WRA::e($curid);?>_morevisual_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" class="<?php WRA::e($curid);?>_morevisual" value="1" <?php if($w0->morevisual==1){?>checked="checked"<? }?>/></div>
                                <div><span>HTML</span><textarea placeholder="HTML"  name="<?php WRA::e($curid);?>_htmlcontent_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>" id="<?php WRA::e($curid);?>_htmlcontent_<?php WRA::e($ac->lang);?>_<?WRA::e($w0->id);?>"  class="<?php WRA::e($curid);?>_htmlcontent"><?php WRA::e($w0->htmlcontent);?></textarea></div>
                            </div>
							<div class="imginfo">
								<!-- <a href="#" class="deleteinfoimage">удалить</a> -->
							</div>
						</div>
						<?php
						// WRA::debug($item);
					}
					// WRA::debug($this);
					// WRA::debug($cap);
					?>							
				</div>
				<!-- <input type="hidden" name="delete-<?php WRA::e($curid);?>" value="" id="delete-<?php WRA::e($curid);?>"/> -->
				<!-- <input type="hidden" name="new-<?php WRA::e($curid);?>" value="" id="new-<?php WRA::e($curid);?>"/> -->
				<?php
				break;
			default:
				?><label><? WRA::e(htmlspecialchars( $tdcontent)); ?></label><?	
		}
		}   
		?></td>
        <td style="width:60px;"></td>
	</tr><?php } ?>               
</tbody></table>
<?}?>
</div>