<?php 
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');
define('column_type_id',0);
define('column_type_text',1);

define('column_type_pic',2);
define('column_type_date',3);
define('column_type_bigtext',4);
define('column_type_check',5);
define('column_type_int',6);
define('column_type_dropdown',7);
define('column_type_file',8);
define('column_type_textsource',9);
define('column_type_password',10);
define('column_type_hidden',11);
define('column_type_nothing',16);
define('column_type_h2header',17);
define('column_type_doubletext',12);
define('column_type_label',13);
define('column_type_datetime',14);
define('column_type_link',15);
define('column_type_multiselect',18);
define('column_type_customfield',19);
define('column_type_textsource_label',20);
define('column_type_groupit',21);
define('column_type_images',22);
// class wra_lang{
//    var $alias='ru';
//    static function getlist(){
//        $result=array();
//        $nw=new wra_lang();
//        array_push($result,$nw);
//        return $result;
       
//    }
//       static function getnone(){
//         return new wra_lang();
//    }
//    static function getdefault(){
//         return new wra_lang();
//    }
// }
class wra_minicolumn{
    var $header;
    var $field;
    var $type;
    var $width;
    var $dropdown;
    function wra_minicolumn($header,$field,$type,$width='170px',$dropdown=array()){
        $this->header=$header;
        $this->field=$field;
        $this->type=$type;
        $this->width=$width;
        $this->dropdown=$dropdown;
    }
}
class wra_column{
	var $name;
	var $table;
	var $header;
	var $type;
	var $dropdown_query;
	var $href;
	var $issortable=false;
	var $thumbpic;
	var $items=array();
	var $isparent;
	var $headerstyle;
	var $tdstyle;
	var $itemstyle;
	var $prefix='';
	var $sufix='';
	var $readonly;
	var $canbenull=false;
	var $defaultvalue='';
	var $inpprop='';
	var $uselanguages=false;
	var $classes='';
	var $description='';
	var $culstomfieldpage='';
	function wra_column($name,$type,$fieldname=""){
		$this->header=$name;
		$this->type=$type;
		$this->name=$fieldname;
	}
	function loaddropdownto($query){
		$wd=new wra_db();
		$wd->query  = $query;
		$wd->executereader();
	$result=array();
		while($u0=$wd->read()){
                   
			$kp = new wra_key_value_pair();
			$kp->key=$u0[0];
			$kp->value=$u0[1];
			if(trim($kp->value)!=""){
			$result[count($result)]=$kp;}
		}
		$wd->close() ;unset($wd);
                return $result;
		
	}
	function loaddropdown(){
		$wd=new wra_db();
		$wd->query  = $this->dropdown_query;
		$wd->executereader();
		
		while($u0=$wd->read()){
			$kp = new wra_key_value_pair();
			$kp->key=$u0[0];
			$kp->value=$u0[1];
			if(trim($kp->value)!=""){
			$this->items[count($this->items)]=$kp;}
		}
		$wd->close() ;unset($wd);		
	}

	function loadimages($lang="ru"){
		// WRA::debug("aaaa");
		// WRA::debug($this->defaultvalue);
		$infoid= $this->defaultvalue;
		$waslist=array();
		if($infoid!=-1){
        	$waslist=wra_image::getlistfull($infoid,100,0,$lang);
		}
		foreach ($waslist as $value) {
			$this->items[count($this->items)] = $value;
		}
		// WRA::debug($waslist);
	}
}

class wra_admintable{
	var $id="";
	var $headertext="";
	var $subtypeedit=false;
	var $subtable=false;
	var $classes="";
	var $query="";
	var $deleteeditclass;
	var $rows=array();
	var $columns=array();
	var $emptywidth="";
	var $rowstyle="";
	var $headerrowstyle="";
	var $link="";
	var $candelete=true;
	var $canedit=true;
	var $pid=0;
	var $page=0;
	var $parent_parentid=0;
	var $useheader=true;
	var $useendtable=true;
	var $usebegintable=true;
	var $idprefix="";
	var $usesavelink=true;
	var $isadd=false;
	var $dontrepost=false;//не вставлять значения POST
	var $info="";
	var $subtables=array();
	var $lang = "ru";

	static function getpost($fieldname){		
		return addslashes($_POST[$fieldname]);
	}

	static function getimages($fieldname,$lang){
		// WRA::debug($fieldname);
		// WRA::debug($lang);
		
		$img = array();
            
		foreach ($_POST as $key => $value) {
			// WRA::debug($key);
			$fname = $fieldname.'_path_'.$lang.'_';
            // WRA::debug($fname);
            // WRA::debug($key);
                    
			$pos = strpos($key, $fname);
			if ($pos === 0) {
				$len = strlen($fname);
				$index = substr($key, $len, strlen($key));
                if($index=='old')continue;
				$img[$index][$lang]['id'] = $index;
				$img[$index][$lang]['header'] = addslashes($_POST[$fieldname.'_header_'.$lang.'_'.$index]);
                $img[$index][$lang]['description'] = addslashes($_POST[$fieldname.'_description_'.$lang.'_'.$index]);
                $img[$index][$lang]['sortorder'] = addslashes($_POST[$fieldname.'_sortorder_'.$lang.'_'.$index]);
                $img[$index][$lang]['morevisual'] = self::getcheck($fieldname.'_morevisual_'.$lang.'_'.$index);
                $img[$index][$lang]['htmlcontent'] = addslashes($_POST[$fieldname.'_htmlcontent_'.$lang.'_'.$index]);
                $img[$index][$lang]['filename'] = addslashes($_POST[$fieldname.'_path_'.$lang.'_'.$index]);
                $img[$index][$lang]['link'] = addslashes($_POST[$fieldname.'_link_'.$lang.'_'.$index]);
			}                      
		}
		// WRA::debug($img);
		// die();
		return $img;
	}

	static function getpic(&$picfield,&$tmbpic,&$ismessage,&$adminmessage,$updir,$tmbwidth,$fieldname,$crop=false,$createava=true,$cropheight=false,$height=300){
		
           
            if($_POST['delpicvalue-'.$fieldname]=="delete"){
			$tmbpic="";
			$picfield="";
			return;
		}
        $xhr=false;
    	if(isset($_GET[$fieldname])&&!isset($_FILES[$fieldname])){
        	$xhr=true;
		} else {
			if(isset($_FILES[$fieldname])){
				if($_FILES[$fieldname]['size']==0){ 
					return;
		        }
	        } else {
	            return;
	        }
        }
		$wf=new wra_uploadedfile(WRA_Path);
		$wf->uploaddir.=$updir;
	
		$wf->addvalidtype("jpg");
		$wf->addvalidtype("gif");
		$wf->addvalidtype("png");
		$wf->tmbwidth=$tmbwidth;
		$wf->upload($fieldname,true,$xhr);
		$wf->getimageinfo();
		//	print_r($wf->fileext!="gif");	
		if($crop){
			if(!$cropheight){
				if($createava)
				$wf->createcropedavatar();
			} else {
                $wf->tmbwidth=$tmbwidth;
                $wf->tmbheight=$height;
                if($createava)
					$wf->createcropedavatarfull();
            }                        
		} elseif($wf->fileext!="gif") {
			if($createava){
				$wf->createavatar();
			}
		}
		//echo $wf->pic."@";
		
		if($wf->error==""){
			$picfield='upload/'.$updir.$wf->filename;
			if($tmbwidth!=0)
			$tmbpic='upload/'.$updir.$wf->tmbfilename;
		} else {
			$ismessage=true;				
			switch($wf->error){
				case "sizeimage":
					$adminmessage="Неправильные пропорции картинки";
					break;
				case "maxsize":
					$adminmessage="Слишком большая картинка";
					break;
				case "fileext":
					$adminmessage="Это расширение не подходит, могут быть загружены файлы JPG,PNG,GIF";
					break;					
				default: 	
					$adminmessage="Ошибка загрузки картинки";
					break;
			}				
		}		
		return $wf;
	}

	static function getfile(&$picfield, $updir, $fieldname) {
		// WRA::debug($fieldname);
        if ($_POST['delpicvalue-' . $fieldname] == "delete") {       
            $picfield = "";
            return;
        }
        $xhr = false;
        // WRA::debug($_FILES[$fieldname]);
        if (isset($_GET[$fieldname]) && !isset($_FILES[$fieldname])) {
            $xhr = true;
        } else {
            if (isset($_FILES[$fieldname])) {
                if ($_FILES[$fieldname]['size'] == 0) {
                    return;
                }
            } else {
                return;
            }
        }
        $wf = new wra_uploadedfile(WRA_Path);
        $wf->uploaddir.=$updir;
        $wf->addvalidtype("mp3");
        $wf->addvalidtype("wav");
        $wf->addvalidtype("ogg");
        $wf->addvalidtype("zip");
     	// WRA::debug($uploaddir);
        // WRA::debug("adsasdsadasd");
        $wf->upload($fieldname, true, $xhr);
        // WRA::debug($wf);

        if ($wf->error == "") {
            $picfield = 'upload/' . $updir . $wf->filename;
            // WRA::debug($wf);
        }


        return $wf;
    }
	
        static function getcheck($name){
		if(isset($_POST[$name]))
			return 1;
		else return 0;
		
		
	}
	static function getdate($name){
		$temp=date(DATE_ATOM, mktime($_POST[$name.'hour'], $_POST[$name.'minute'], 0, $_POST[$name.'month'], $_POST[$name.'day'], $_POST[$name.'year']));

		return $temp;
		
	
	}
static function savemultipleclass($fieldname,$saveid,$classname,$field){
  
		$temp="";
$cattour=explode(";",wra_admintable::getmultiple($fieldname));

$cattourwas=array();
	eval('$curar='.$classname.'::getlist($saveid);');
	//print_r($cattour);
	foreach($curar as $c0){
		eval('$inar0=in_array($c0->'.$field.',$cattour);');
		if($inar0){
			
			eval('$cattourwas[count($cattourwas)]=$c0->'.$field.';');
		}else{
			
			$c0->delete();
		}
	
	}
	
	foreach($cattour as $c0){
		if($c0!="")
		if(!in_array($c0,$cattourwas)){
			//echo "da";
			eval($classname.'::addinlist($saveid,$c0);');

		}
		
	}
		
	
	}
	static function getmultiple($name){
		return WRA::getmultiple($name);
		
	
	}
	function wra_admintable($info=""){
		
		$this->info=$info;
		
		}
	function addcolumn($column){//добавить колонку
		
		$this->columns[count($this->columns)]=$column;
	}
	function load($wf=null,$saveid=-1,$pid=-1,$page=0){
		if($this->query==""){
			
			return;	
		}
		$this->pid=$pid;
		
		$this->page=$page;
		$wd=new wra_db($wf);
		
		$wd->query  = $this->query;
		$wd->executereader();
		while($u0=$wd->read()){
			
			
			$this->rows[count($this->rows)]=$u0;
		}
		
		$wd->close() ;unset($wd);
	}
	function addnew($pid=0,$page=0){
		$this->pid=$pid;
	
		$this->page=$page;
		$icounter=0;
		$this->rows[0]="";
		while($icounter<count($this->columns)){			
			$this->rows[0][$this->columns[$icounter]->name]=$this->columns[$icounter]->defaultvalue;
			$this->rows[0][$icounter]=$this->columns[$icounter]->defaultvalue;
			$icounter++;
		}
		
	}

	static function flusheditHead($cap) { // вывод редактирования (верх всех страниц с edit)
		$backlink='admin?mod='.$cap->mod;
		?>
		<div class="text_header_edit">
			<?
			if(WRA::r('id')!=-1)
				WRA::e($cap->editheader);
			else
				WRA::e($cap->addheader);
			?>
		</div>
		<div class="back_link">
			<a href="<? WRA::e($backlink); ?>">← <? WRA::e($cap->backtoitemlist); ?></a>
		</div>
		<?
	}


	function flushedit($cap){//вывод редактирования (все страницы с edit)
	$languages=wra_lang::getlist();
        
      	// WRA::debug($cap);
      	// WRA::debug($this);
		?>
		<input type="hidden" value="<?
                if(isset($_POST['id']))
                WRA::e($_POST['id']);else WRA::e($_REQUEST['id']);?>" id="curID" name="curID" />
		    <div class="content_edit content_edit_<?php WRA::e($this->lang); ?>"
		    	<?php if ($this->lang != wra_lang::getdefault()) WRA::e("style=display:none;"); ?> 
		    	>
		    <div class="lang_height">
                <div class="lang_block_menu">
                <?foreach($languages as $l0){
                ?>
    	            <div <?if(wra_lang::getdefault()!=$l0->alias){?>style="display:none"<?}?> id="spla-text-<? WRA::e($l0->alias);?>" class="over_lang spla sptext sp<? WRA::e($l0->alias);?>"><? WRA::e($l0->name);?></div>
    	            <div <?if(wra_lang::getdefault()==$l0->alias){?>style="display:none"<?}?> class="lila li<? WRA::e($l0->alias);?>" id="lang-change-<? WRA::e($l0->alias);?>"><a href="#" ><? WRA::e($l0->name);?></a></div>
    	            
    	            <?}?>
                </div>
            </div>
		    <div class="input_edit">
			<table id="<? WRA::e($this->id);?>" width="100%" class="adminedittbl table_edit <? WRA::e($this->classes);?> " cellpadding="0" cellspacing="0">
		<?//}
		$rowi=0;
		$columni=0;
		$columnbonus=0;
		while($columni<count($this->columns)){
		//$this->columns[$columni]->uselanguages=false;
		   if($this->columns[$columni]->type==column_type_nothing){
		   $columni++;
		   continue;
		   }
			$columnbonus=0;
			// $languages=wra_lang::getnone();
			if($this->columns[$columni]->uselanguages){				
				// $languages=wra_lang::getlist();
			}
			// wra_langed::loadlangeddict();
			// foreach($languages as $l0){
				$this->headerrowstyle=str_replace(";display:none;","",$this->headerrowstyle);
			    // if($l0->alias!=wra_lang::getdefault()&&$l0->alias!=""){
			      // $this->headerrowstyle.=";display:none;";
			    // }
				?>
				<tr id="trla-<? WRA::e($this->columns[$columni]->name);?>-<? WRA::e($this->lang);?>" <? if($this->columns[$columni]->uselanguages){?>class="trjust tr<? WRA::e($this->columns[$columni]->name);?> tr<? WRA::e($this->lang);?>"<?}?> <?  if($this->headerrowstyle!=""){					
						WRA::e(' style="'.$this->headerrowstyle.'"');
					}
				?>><?php
			    if (($this->columns[$columni]->uselanguages )or($this->lang == wra_lang::getdefault())) {
					?><td <? if($this->columns[$columni]->headerstyle!=""){
						WRA::e('  width="150"');
						WRA::e(' style="'.$this->columns[$columni]->headerstyle.'"');
					}
					?>><? 	
					WRA::e('<label>'.$this->columns[$columni]->header.'</label>');
					?></td><?php
				}				
				
				$tdcontent="";
				$tdcontent=$this->rows[$rowi][$columni];

				//получаем языковое значение
				// if($this->columns[$columni]->uselanguages){
				    
				// 	$temp=wra_langed::getvalue($this->columns[$columni]->table,$this->columns[$columni]->name,$l0->alias,$this->rows[0]['id']);
				// 	$temp = wra_dictionary::getword($tdcontent ,$l0->alias);
				// 	if($temp!="")
				// 	$tdcontent=$temp;
				// }
				
				$curid="field".$this->columns[$columni]->name;
				if($this->info!="")
				    $curid=$this->info."-".$curid;

				// form for all languages now must have lagv-index in all fileds
				// not olnly for uselanguages fields
				// if($this->columns[$columni]->uselanguages){
					if (($this->columns[$columni]->type != column_type_images)&&($this->columns[$columni]->type != column_type_dropdown)) {	
						$curid.="-".$this->lang;
					}
				// }
				if(isset($_POST["id"])&&(!$this->dontrepost)){
					if(isset($_POST[$curid])){
						if($tdcontent=="")
							$tdcontent=$_POST[$curid];						
						}
				}
				?><td><?
				if(WRA::r('id')==-1)
				$tdcontent="";
				if (is_array($tdcontent)){
                	$tdcontent=array_map("stripslashes",$tdcontent);
                } else {
                	$tdcontent=stripslashes($tdcontent);
                }
                if (($this->columns[$columni]->uselanguages )or ($this->lang == wra_lang::getdefault())) {
					switch($this->columns[$columni]->type){
	                    case "column_type_groupit":
	                        ?><?
	                        break;
						case column_type_id:
							?><? WRA::e($tdcontent); ?><input type="hidden" <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" readonly="readonly" value="<? WRA::e($tdcontent); ?>"><?	
							break;
						case column_type_bigtext:
							?><textarea <?
							if($this->columns[$columni]->classes!=""){
								WRA::e('class="'.$this->columns[$columni]->classes.'"');	
								
							}
							
							?> <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" <? if($this->columns[$columni]->itemstyle!=""){
								
								WRA::e(' style="'.$this->columns[$columni]->itemstyle.'"');
							}
							?>><? WRA::e($tdcontent); ?></textarea><br/><?
							if($this->columns[$columni]->classes=="fieldcontent"){
							?>
							<a href="#" class="uploadpic" id="upic-<? WRA::e($curid); ?>">Загрузить картинку</a>
							<div class="uploadedpics" id="upepic-<? WRA::e($curid); ?>">
							<strong >Загруженные картинки</strong><br/>
							<table>
							<tr><td>Картинка</td><td>Путь</td></tr>
							</table>
							</div>
							<br/><a href="javascript:toggleEditor('<? WRA::e($curid); ?>');">Вкл/Выкл редактор</a><?}
							break;
						case column_type_check:
							if($tdcontent==""){
							
							    $tdcontent=$this->columns[$columni]->defaultvalue;
							}
							?><input <? WRA::e($this->columns[$columni]->inpprop); ?> <?
							
							if($tdcontent==1){
								
								WRA::e('checked="checked"');
							}
							?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" type="checkbox" value="ON"/><?
							break;
						case column_type_textsource:
							$subrowi=0;
							?>
							<input <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>"  name="<? WRA::e($curid); ?>" readonly="readonly" value="<? WRA::e($tdcontent);?>" type="hidden"/>
							<input <? WRA::e($this->columns[$columni]->inpprop); ?> id="fieldview<? WRA::e($this->columns[$columni]->name); ?>"  name="<? WRA::e($curid); ?>" readonly="readonly" value="<?
							while($subrowi<count($this->columns[$columni]->items)){
								
								if($this->columns[$columni]->items[$subrowi]->key==$tdcontent){
									
									?><? WRA::e($this->columns[$columni]->items[$subrowi]->value); ?><?
								}
								
								$subrowi++;	
							}?>"><?
							break;
	                                       case column_type_textsource_label:
							$subrowi=0;
							?>
							<input <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>"  name="<? WRA::e($curid); ?>" readonly="readonly" value="<? WRA::e($tdcontent);?>" type="hidden"/>
	                                                <label><?
							while($subrowi<count($this->columns[$columni]->items)){
								
								if($this->columns[$columni]->items[$subrowi]->key==$tdcontent){
									
									?><? WRA::e($this->columns[$columni]->items[$subrowi]->value); ?><?
								}
								
								$subrowi++;	
							}?></label><?
							break;
						case column_type_customfield:
							include $this->columns[$columni]->customfieldpage;
						break;
						case column_type_multiselect:
							$subrowi=0;
							
							
							if($tdcontent==''||$tdcontent=='Array'){
							
							    $tdcontent=$this->columns[$columni]->defaultvalue;
							}
							
							if(!is_array($tdcontent)){
							$tdar=explode(";",$tdcontent);}else{
								$tdar=$tdcontent;
							}
							$size=10;
	                                                //print_r($tdar);die();
							if(count($tdar)<$size)$size=count($tdar);
							?><select style="width:85%" size="<?php WRA::e($size);?>" multiple="multiple" <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>[]">
							
							
							<?
							if($this->columns[$columni]->canbenull){
								?><option value="0"></option><?	
								
							}
							while($subrowi<count($this->columns[$columni]->items)){
								if($this->columns[$columni]->isparent&&($this->columns[$columni]->items[$subrowi]->key==$this->rows[0]['id'])){
									$subrowi++;
								continue;}
								
								?><option <?
								
								if(in_array($this->columns[$columni]->items[$subrowi]->key,$tdar)){
									WRA::e('selected="selected"');
								}
								?> value="<? WRA::e($this->columns[$columni]->items[$subrowi]->key);   ?>"><? WRA::e($this->columns[$columni]->items[$subrowi]->value);   ?></option><?
								
								$subrowi++;	
							}
							?></select><?
							break;
							
						case column_type_dropdown:
							$subrowi=0;
							if($tdcontent==""){
							
							    $tdcontent=$this->columns[$columni]->defaultvalue;
							}
							?><select <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>">
							
							
							<?
							if($this->columns[$columni]->canbenull){
								?><option value="0"></option><?	
								
							}
							while($subrowi<count($this->columns[$columni]->items)){
								if($this->columns[$columni]->isparent&&($this->columns[$columni]->items[$subrowi]->key==$this->rows[0]['id'])){
									$subrowi++;
								continue;}
								
								?><option <?
								
								if($this->columns[$columni]->items[$subrowi]->key==$tdcontent){
									WRA::e('selected="selected"');
								}
								?> value="<? WRA::e($this->columns[$columni]->items[$subrowi]->key);   ?>"><? WRA::e($this->columns[$columni]->items[$subrowi]->value);   ?></option><?
								
								$subrowi++;	
							}
							?></select><?
							break;
						case column_type_password:
							
							?><input type="password" <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" value=""><?	
							break;
						case column_type_pic:
							if($tdcontent!=""){
								?><img src="<? WRA::e(WRA::base_url().$tdcontent); ?>" style="max-width:120px" id="img-<? WRA::e($curid); ?>"/>	<br/>
								<input type="hidden" value="" name="delpicvalue-<? WRA::e($curid); ?>" id="delpicvalue-<? WRA::e($curid); ?>"/>
								<a href="#" class="delpic" id="delpic-<? WRA::e($curid); ?>" >удалить</a><br/>
								<?
							
							}
							?><input type="file" <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" ><?	
							
							break;
						case column_type_file:
							if($tdcontent!=""){
								?><? WRA::e($tdcontent); ?><br/>
								<?
							}else{
								?><input type="file" <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" ><?	
							}
							break;
						case column_type_doubletext:
							$splitnames=explode(" ",$this->columns[$columni]->name);
							$columnbonus=1;
							$val0=$this->rows[$rowi][$splitnames[0]];
							$val1=$this->rows[$rowi][$splitnames[1]];
							?><input type="text" <? WRA::e($this->columns[$columni]->inpprop); ?> id="field<? WRA::e($splitnames[0]); ?>" name="field<? WRA::e($splitnames[0]); ?>" value="<? WRA::e($val0); ?>">
							<input type="text" <? WRA::e($this->columns[$columni]->inpprop); ?> id="field<? WRA::e($splitnames[1]); ?>" name="field<? WRA::e($splitnames[1]); ?>" value="<? WRA::e($val1); ?>"><?	
							break;
						case column_type_hidden:
							if($tdcontent==""){
							
							    $tdcontent=$this->columns[$columni]->defaultvalue;
							}
							?><input type="hidden" <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" value="<? WRA::e($tdcontent); ?>"><?	
							break;
						case column_type_label:
							
							?><label><? WRA::e($tdcontent); ?></label><?	
							break;
							
						case column_type_datetime:
							$timestamp=strtotime($tdcontent);
							if($tdcontent==""){
								$timestamp=time();
							}
							?>
							<select id="<? WRA::e($curid); ?>day" name="<? WRA::e($curid); ?>day">
							<?for($i=1;$i<=31;$i++){?>
								<option <?
								if($i==date("j",$timestamp)) WRA::e('selected="selected"');
								?> value="<? WRA::e($i); ?>"><? WRA::e($i); ?></option>
							<?}?> 
							</select>
							<? $monthes=wra_time::getmonthesrp("ru");?>
							
							<select id="<? WRA::e($curid); ?>month" name="<? WRA::e($curid); ?>month">
							<?for($i=1;$i<=12;$i++){?>
								<option <?
								if($i==date("m",$timestamp)) WRA::e('selected="selected"');
								?> value="<? WRA::e($i); ?>"><? WRA::e($monthes[$i]); ?></option>
							<?}?> 
							</select>
							<select id="<? WRA::e($curid); ?>year" name="<? WRA::e($curid); ?>year">
							<?for($i=wra_time::$beginyear;$i<=wra_time::$endyear;$i++){?>
								<option <?
								if($i==date("Y",$timestamp)) WRA::e('selected="selected"');
								?> value="<? WRA::e($i); ?>"><? WRA::e($i); ?></option>
							<?}?> 
							</select>
							&nbsp;
							<select id="<? WRA::e($curid); ?>hour" name="<? WRA::e($curid); ?>hour">
							<?for($i=0;$i<=23;$i++){?>
								<option <?
								if($i==date("H",$timestamp)) WRA::e('selected="selected"');
								?> value="<? WRA::e($i); ?>"><? WRA::e($i); ?></option>
							<?}?> 
							</select>:<select id="<? WRA::e($curid); ?>minute" name="<? WRA::e($curid); ?>minute">
							<?for($i=0;$i<=59;$i++){?>
								<option <?
								if($i==date("i",$timestamp)) WRA::e('selected="selected"');
								?> value="<? WRA::e($i); ?>"><? WRA::e($i); ?></option>
							<?}?> 
							</select>						
							<?	
							break;
						case column_type_images:
							// WRA::debug($tdcontent);
							if($this->lang==wra_lang::getdefault()){
	                                            ?>
							<div class="linkadd" target="table_<?php WRA::e($curid);?>_<?php WRA::e($this->lang);?>" id="linkadd_<?php WRA::e($this->lang);?>_<?php WRA::e($curid);?>">Добавить фотографию</div><br/><br/><?}?>
							<table id="table_<?php WRA::e($curid);?>_<?php WRA::e($this->lang);?>" class="imgstable" style="width:100%">
								<thead>  
									<tr>
	        							<td style="width:120px">Фотография</td>
	        							<td style="width:120px">Ссылка</td>
	        							<td>Описание</td><td>Порядок</td>
	        							<td>Рамочка</td>
	        							<td></td>
	        						</tr>
	        					</thead>
	        					<tbody>
									<?php
									// WRA::debug($this->columns[$columni]);
									// empty pic line
										// $imgcount = count($this->columns[$columni]->items);
										?>
										<tr class="new empty-img-pattern" id="infopic-new-00" style="display:none;">
											<td><img src="" width="120px"/></td>
											<td><input type="text" class="picheader<?php WRA::e($curid);?>" value=""/>     <input type="hidden" class="path00" name="infopic-path-00" value=""/></td>
											<td class="old trjust trimage tr<?php WRA::e($this->lang);?>">
												<textarea alias="description_<?php WRA::e($this->lang);?>" id= "description_<?php WRA::e($this->lang);?>_<?php WRA::e($curid);?>" name="fielddescription_<?php WRA::e($this->lang);?>" class="pidescription<?php WRA::e($curid);?>"></textarea>
											</td>
											<td><input type="text" style="width:50px" class="pisortorder<?php WRA::e($curid);?>" value=""/></td>
											<td><input type="checkbox"  class="pimorevisual<?php WRA::e($curid);?>" value="1"/></td>
										</tr>
										<tr id="infopicsec-new-00" class="empty-img-pattern" style="display:none;">
											<td colspan="4"  class="old trjust trimage">
												<textarea placeholder="HTML" style="width:490px" alias="htmlcontent"  class="pihtmlcontent<?php WRA::e($curid);?>"></textarea>
											</td>
											<td><a href="#" class="deleteinfoimage">удалить</a></td>
										</tr>
								        <?php
									// end of empty pic line
									foreach ($this->columns[$columni]->items as $w0) {
										?>
										<tr id="infopic-old-<?WRA::e($w0->id);?>-<?WRA::e($this->lang);?>" class="old">
	        								<td>
	        									<img src="<?= WRA::base_url() ?><?WRA::e($w0->tmbpic);?>" width="120px"/>
	        								</td>
	        								<td>
	        									<input type="text" style="width:120px" class="picheader<?php WRA::e($curid);?>" value="<?php WRA::e($w0->header);?>" name="<?php WRA::e($curid);?>_pichead_<?WRA::e($w0->id);?>_<?php WRA::e($this->lang);?>"/>
	                                            <input type="hidden" name="<?php WRA::e($curid);?>_picfilename_<?WRA::e($w0->id);?>_<?php WRA::e($this->lang);?>" value="<?WRA::e($w0->tmbpic);?>"/>
	        								</td>
	        								<td  class="old trjust trimage tr<?php WRA::e($this->lang);?>" >
	              								<textarea alias="description_<?php WRA::e($this->lang);?>" id= "description_<?php WRA::e($this->lang.'_'.$w0->id);?>" name="<?php WRA::e($curid);?>_description_<?WRA::e($w0->id);?>_<?php WRA::e($this->lang);?>" class="pidescription<?php WRA::e($curid);?>"><?php WRA::e($w0->description);?></textarea>
	            							</td>
	                						<td>
	                							<input type="text" style="width:50px" class="pisortorder<?php WRA::e($curid);?>" value="<?php WRA::e($w0->sortorder);?>" name="<?php WRA::e($curid);?>_picsortorder_<?WRA::e($w0->id);?>_<?php WRA::e($this->lang);?>" />
	                						</td>   
	              							<td>
	              								<input type="checkbox"  class="pimorevisual<?php WRA::e($curid);?>" value="1" <?php if($w0->morevisual==1){?>checked="checked"<? }?> name="<?php WRA::e($curid);?>_morevisual_<?WRA::e($w0->id);?>_<?php WRA::e($this->lang);?>" />
	              							</td>   
	    								</tr>
	    								<tr id="infopic-secold-<?WRA::e($w0->id);?>-<?WRA::e($this->lang);?>" class="old">
								            <td colspan="4"  class="old trjust trimage"  >
									            <textarea placeholder="HTML" style="width:490px" alias="htmlcontent_<?php WRA::e($this->lang);?>" id= "<?php WRA::e($curid);?>_pichtmlcontent_<?WRA::e($w0->id);?>_<?php WRA::e($this->lang);?>" name="<?php WRA::e($curid);?>_pichtmlcontent_<?WRA::e($w0->id);?>_<?php WRA::e($this->lang);?>" class="pihtmlcontent<?php WRA::e($curid);?>"><?php WRA::e($w0->htmlcontent);?></textarea>
								            </td>							            
								            <td>
								            	<a href="#" class="deleteinfoimage">удалить</a>
								            </td> 
								        </tr>
										<?php
										// WRA::debug($item);
									}
									// WRA::debug($this);
									// WRA::debug($cap);
								?>
								</tbody>
							</table>
							<input type="hidden" name="delete-<?php WRA::e($curid);?>" value="" id="delete-<?php WRA::e($curid);?>"/>
							<input type="hidden" name="new-<?php WRA::e($curid);?>" value="" id="new-<?php WRA::e($curid);?>"/>
							<?php
							break;
						default:
							?><input <? WRA::e($this->columns[$columni]->inpprop); ?> id="<? WRA::e($curid); ?>" name="<? WRA::e($curid); ?>" value="<? WRA::e(htmlspecialchars( $tdcontent)); ?>"><?	
					}
				}

				if($this->columns[$columni]->description!=""){
				?><br/><span style="color:#cc0000;"><?	
					WRA::e($this->columns[$columni]->description);?></span><?
				}
				?>
				
				</td><td<? if($this->columns[$columni]->tdstyle!=""){
					
					WRA::e(' style="'.$this->columns[$columni]->tdstyle.'"');
				}
				?> width="<? 
				if($this->emptywidth!="")
				WRA::e($this->emptywidth);
				else WRA::e("0");?>"></td></tr>
				
			<?

			// }
			$columni=$columni+$columnbonus;
			$columni++;

		}

	
		if($this->useendtable){
			?>
	    <tr><td><?	if($this->rows[0]['id']!=-1&&$this->info==""){?><br/><a href="#" class="link_save" id="link-save">Сохранить</a><?}else{
		?><br/><a href="#" class="link_save" id="link-save<?if($this->info!="")WRA::e("-".$this->info);?>">Добавить</a><?
		
	}?></td><td></td></tr>
		</table></div>
		</div>

		<?}?>
	<?}
	function flush(){
	//есть шанс погибнуть разобравшись в этом коде
	//вывод таблицы
	?>

	    <?if($this->subtable){?>
	    <br/>
	    <div class="text_header_edit">
		    <? WRA::e($this->headertext);?>
		</div>
		<?}?>
		<?
		$rowi=0;
		$columni=0;

		if(($this->pid!="-1"&&$this->pid!="0"&&$this->pid!="")&&$this->useheader){
			?>	
			<div><a href="<? WRA::e(WRA::getcurpage().'&pid='.$this->parent_parentid);?>">&larr;вверх</a></div>	
		<?}
	    if(count($this->rows)==0){?>
	    <div class="sub_text">
	     <center>Нет ни одной записи</center>
	    </div><?
	    }else{
                
                ?><div><input type="text" id="filternow" value="Поиск"></div><?
                
            }
		while($rowi<count($this->rows)){
		
			$columni=0;
			?><div class="sub_text" id="sub_text-<? WRA::e($this->rows[$rowi]["id"]); ?>"><?
		while($columni<count($this->columns)){
               if($this->columns[$columni]->header=="id"||$this->columns[$columni]->header=="Ключевые слова"){
			    $columni++;
			    continue;
			    }

				
				$tdcontent="";
				$tdcontent=$this->columns[$columni]->prefix.$this->rows[$rowi][$columni].$this->columns[$columni]->sufix;

				switch($this->columns[$columni]->type){
				case column_type_h2header:
				    if(!$this->columns[$columni]->isparent){
				            WRA::e('<h2>'.$tdcontent.'</h2>');
				    }else{
				    if($this->info=="")
						WRA::e('<h2><a href="'.WRA::getcurpage().'&pid='.$this->rows[$rowi]["id"].'">'.$tdcontent."</a></h2>");
				    else
				        WRA::e('<h2><a href="'.WRA::getcurpage().'&pid='.$this->rows[$rowi]["id"].'&type='.$this->info.'">'.$tdcontent."</a></h2>");

				    }
				break;
				    case column_type_date:
				    
				    WRA::e('<span class="date_content">'.$this->columns[$columni]->header.': '.$tdcontent.'</span>');
				    break;
					case column_type_link:
						WRA::e('<a target="_blank"  href="'.$tdcontent.'">'.$tdcontent."</a>");
						
						break;
				case column_type_check:
				WRA::e('<p>'.$this->columns[$columni]->header.': ');
						if($tdcontent==1){
							WRA::e('Да');
							
						}else{
							
							WRA::e('Нет');
						}
						WRA::e('</p>');
				break;
					case column_type_pic:
						if($tdcontent!=""){
							WRA::e('<p><img src="'.WRA::base_url().$tdcontent.'"/></p>');
						}else{
							
							WRA::e($tdcontent);
						}break;
                case column_type_id:
                    
                break;
				case column_type_text:
				default:
				?><p<? if($this->rowstyle!=""){
					
					WRA::e(' style="'.$this->rowstyle.'"');
				}
				?>><?
				if($tdcontent!="")
				WRA::e($this->columns[$columni]->header.'');
				if($this->columns[$columni]->isparent){
					WRA::e('<h2><a href="'.WRA::getcurpage().'&pid='.$this->rows[$rowi]["id"].'">'.$tdcontent."</a></h2>");
				}else{
					
					WRA::e( $tdcontent);
				}
				?></p><?
				break;}
				
			
			$columni++;
		}
		?><div class="red_del"><?
			if($this->candelete){
				?><a href="<?WRA::e(WRA::getcurpage());?>&id=<?WRA::e($this->rows[$rowi]["id"]);?>" class="delete_link deletetd  <? WRA::e($this->deleteeditclass); ?>" style="display:none" id="del-<? WRA::e($this->rows[$rowi]["id"]); if($this->info!="") WRA::e("-".$this->info); ?>">Удалить</a><?	
			}
			if($this->canedit){
				?><a href="<?WRA::e(WRA::getcurpage());?>&id=<?WRA::e($this->rows[$rowi]["id"]);?>" class="edit_link edittd  <? WRA::e($this->deleteeditclass); ?>" style="display:none" id="ed-<? WRA::e($this->rows[$rowi]["id"]); if($this->info!="") WRA::e("-".$this->info); ?>">Редактировать</a><?	
			}

			?></div><?
			$rowi++;
			
			?></div>
			
			<?
			
		}

    }
	}?>