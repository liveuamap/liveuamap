<?
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact rdx.dnipro@gmail.com</div>');

class wra_lang  extends wfbaseclass{
	var $id;
	var $alias;
	var $name;
	var $shortvisual;
	var $sortorder=0;
	static function deletecase($dcase,$did){
    	 switch($dcase){
        default:
	    return true;

	    
	    }

	    return false;
    }
    
    static function edittable($saveid=-1,$pid=-1){ 
        $wt=new wra_admintable();
        $wt->link=WRA::getcurpage();
        	$wt->query="select `id`,`name`,`alias`,`shortvisual`,`sortorder` from `".WRA_CONF::$db_prefix."languages` WHERE `id`='$saveid'";
	
	//columns
	$c0=new wra_column("id",column_type_id,'id');
	$c0->defaultvalue=$saveid;
	$c0->headerstyle="font-weight:bold;width:100px;";
	
	$wt->addcolumn($c0);
	$c0=new wra_column("Язык",column_type_text,'name');
		
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
	
	$c0=new wra_column("Системное обозначение",column_type_text,'alias');
	
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
	
	
	$c0=new wra_column("Отображать как",column_type_text,'shortvisual');
	
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
		
	$c0=new wra_column("Порядок сортировки",column_type_text,'sortorder');
	
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
	
	if($saveid!=-1){
		$wt->load($saveid,$pid);
	}else{
		
		$wt->addnew($saveid,$pid);
	}
       return $wt;
    }
    
    static function admintable($saveid=-1,$pid=-1){ 
        $wt=new wra_admintable();
        $wt->link=WRA::getcurpage();
        $wt->query="select `id`,`name`,`shortvisual` from `".WRA_CONF::$db_prefix."languages` ORDER BY `name`";

	//columns
	$c0=new wra_column("id",column_type_id);
	$c0->headerstyle="width:50px;text-align:center;font-weight:bold;";

	$wt->addcolumn($c0);
	$c0=new wra_column("Язык",column_type_text);
	$wt->addcolumn($c0);

	$c0=new wra_column("Отображать как",column_type_text);
	$wt->addcolumn($c0);
	$wt->load($saveid,$pid);
        return $wt;
    
    }

     static function adminit($wfadmin){
		$wfadmin->table='languages';
		$wfadmin->multilanguages=false;
		$wfadmin->columns[]=new admincolumn("String", "name", "Язык", admincolumntype::text, admincolumntype::text, 2);
		$wfadmin->columns[]=new admincolumn("String", "alias", "Системное обозначение", admincolumntype::text, admincolumntype::text, 3);
		$wfadmin->columns[]=new admincolumn("String", "shortvisual", "Отображать как", admincolumntype::none, admincolumntype::text, 5);
		$wfadmin->columns[]=new admincolumn("String", "sortorder", "Порядок сортировки", admincolumntype::none, admincolumntype::text, 5);
		$wfadmin->order = " order by `sortorder` asc";

    }
    
   static function save($saveid=-1,$pid=-1,$adminedit=""){

	switch($adminedit){
	default:
			$savepc = new wra_lang();
		if($saveid!=-1){
			$savepc->load($saveid);
		}
		$savepc->name=htmlspecialchars($_POST['fieldname']);
		$savepc->alias=htmlspecialchars($_POST['fieldalias']);
	$savepc->shortvisual=htmlspecialchars($_POST['fieldshortvisual']);
	$savepc->sortorder=htmlspecialchars($_POST['fieldsortorder']);
	if($saveid!=-1){
		$savepc->update();
	}else{
		
		$savepc->add();

	}
	return $savepc->id;
	
	}
    return $saveid;
    }
	static function getdefault(){
		return "ru";
	}
	function wra_lang ()
	{
	}
	static function setcurlang($lang){

		@setcookie("wralang".WRA::base_url(), $lang, time() + WRA_CONF::$remembertime, "/");
		
	}
	static function getcurlang(){
		if (isset($_COOKIE['wralang'.WRA::base_url()])){
			return 	$_COOKIE['wralang'.WRA::base_url()];	
		}else{
			$lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
			if ($lang == 'ru'||$lang=='uk') {
				$lang = WRA_CONF::$language;
			} else {
				$lang = 'en';
			}
			// die($lang);
			@setcookie("wralang".WRA::base_url(), $lang, time() + WRA_CONF::$remembertime, "/");
			// @setcookie("wralang", WRA_CONF::$language, time() + WRA_CONF::$remembertime, "/");
			return $lang;	
			// return WRA_CONF::$language;	
		}		
	}
	function add()
	{
		$wd=new wra_db();             
		$this->id=WRA::getnewkey("".WRA_CONF::$db_prefix.'languages');
		$wd->query= "INSERT INTO `".WRA_CONF::$db_prefix."languages` (
				`id`,
				`alias`,
				`name`,`shortvisual`,`sortorder`
				)VALUES(
				'$this->id',
				'$this->alias',
				'$this->name','$this->shortvisual','$this->sortorder'
				)";
		$wd->execute();	
		if(!WRA_CONF::$usegetkey) $this->id=$wd->getlastkey();
		$wd->close() ;unset($wd);
		
		$this->createdir();
		
	}
	function createdir(){
		
		//wra_dir::slash()
		//die(WRA_Path."\\lang\\".$this->alias);
		//WRA_Path.wra_dir::slash()."lang".wra_dir::slash().$this->alias
		if(!file_exists(WRA_Path."\\lang\\".$this->alias))
			mkdir(WRA_Path."\\lang\\".$this->alias);	
	}
	function update()
	{
		
		
		$wd=new wra_db();
		$wd->query = "UPDATE `".WRA_CONF::$db_prefix."languages`
				SET 
				`id`='$this->id',
				`alias`='$this->alias',
				`name`='$this->name',`shortvisual`='$this->shortvisual',`sortorder`='$this->sortorder'
				WHERE `id`='$this->id'";
		$wd->execute();	
		$wd->close() ;unset($wd);
		$this->createdir();
	}
	static function isexist($wf, $id)
	{
		$result=false;
		$wd=new wra_db();
		
		
		$wd->query= "SELECT id FROM `".WRA_CONF::$db_prefix."languages` WHERE `id` = '$id'";
		
		$wd->executereader();
		
		$result=($u0=$wd->read());
		
		$wd->close() ;unset($wd);
		return $result;
	}
	function delete()
	{
		$wd=new wra_db();
		
		$wd->query =  "DELETE FROM `".WRA_CONF::$db_prefix."languages`  where `id`='$this->id'";
		$wd->execute();
		$wd->close() ;unset($wd);
		return true;
	}
	function getnone()
	{
		$result=array();
			$r0=new wra_lang();
			$r0->id =-1;
			$r0->alias = "";
			$r0->name = "";
			$r0->shortvisual= "";
			$r0->sortorder= 0;
			$result[count($result)]=$r0;

		return $result;
	}
	static function getlist($count=255,$page=0)
	{
		$result=array();
		$wd=new wra_db();
		
		$wd->query  = "SELECT 
				`id`,
				`alias`,
				`name`,`shortvisual`,`sortorder`
				FROM `".WRA_CONF::$db_prefix."languages` ORDER by `sortorder`";
		// WRA::debug($wd->query);
		$wd->executereader();
		while($u0=$wd->read()){
			$r0=new wra_lang();
			$r0->id = $u0[0];
			$r0->alias = $u0[1];
			$r0->name = $u0[2];
			$r0->shortvisual= $u0[3];
			$r0->sortorder= $u0[4];
			$result[count($result)]=$r0;
		}
		$wd->close() ;
		unset($wd);
		return $result;
	}
    function loadid($id){
    $this->id=$id;
    }
    function loadmore(){
        $this->load($this->id);
    }
	function load($id)
	{
		$wd=new wra_db();
		$this->id = $id;
		
		$wd->query  = "SELECT 
				`id`,
				`alias`,
				`name`,`shortvisual`,`sortorder`
				FROM `".WRA_CONF::$db_prefix."languages` where `id`='$this->id'";
		$wd->executereader();
		if($u0=$wd->read()){
			
			$this->id = $u0[0];
			
			$this->alias = $u0[1];
			
			$this->name = $u0[2];
			$r0->shortvisual= $u0[3];
			$r0->sortorder= $u0[4];
		}
		$wd->close() ;unset($wd);
		
	}
}


class wra_langed{
	var $id;
	var $table;
	var $field;
	var $lang;
	var $value;
	var $rowid;
	var $key;
	function wra_langed ()
	{
	}

    static function edittable($saveid=-1,$pid=-1){ 
        $wt=new wra_admintable();
        $wt->link=WRA::getcurpage();
        	$wt->query="SELECT 
				`id`,
				`table`,
				`field`,
				`lang`,
				`value`,`rowid`
				FROM `".WRA_CONF::$db_prefix."langed` WHERE `id`='$saveid'";
	
	//columns
	$c0=new wra_column("id",column_type_id,'id');
	$c0->defaultvalue=$saveid;
	$c0->headerstyle="font-weight:bold;width:100px;";
	
	$wt->addcolumn($c0);
	$c0=new wra_column("table",column_type_text,'table');		
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
	
	$c0=new wra_column("field",column_type_text,'field');	
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
	
	
	$c0=new wra_column("lang",column_type_text,'lang');	
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
		
	$c0=new wra_column("value",column_type_text,'value');
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$c0->uselanguages=true;
	$wt->addcolumn($c0);

	$c0=new wra_column("rowid",column_type_text,'rowid');
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);

	$c0=new wra_column("Ключ перевода",column_type_text,'key');
	$c0->itemstyle="width:250px;padding:3px;height:50px;";
	$wt->addcolumn($c0);
	
	if($saveid!=-1){
		$wt->load($saveid,$pid);
	}else{
		
		$wt->addnew($saveid,$pid);
	}
       return $wt;
    }
	
	static function admintable($saveid=-1,$pid=-1){
		$wt=new wra_admintable();
		$wt->link=WRA::getcurpage();
		$wt->query="SELECT 
		ne0.id,
		ne0.value
		FROM `".WRA_CONF::$db_prefix."langed` as ne0 WHERE ne0.value <> '' and lang='ru'";

		$c0=new wra_column("id",column_type_id);
		$c0->defaultvalue=$saveid;
		$wt->addcolumn($c0);

		$c0=new wra_column("value",column_type_h2header);
		$wt->addcolumn($c0);	

		$wt->load($saveid,$pid);
		return $wt;
	}

	static function save($saveid=-1,$pid=-1,$adminedit=""){
		$savepc = new wra_langed();
		if($saveid!=-1){
			$savepc->load($saveid);
		}
		$savepc->table = wra_admintable::getpost('fieldtable'.wra_lang::getdefault());
		$savepc->field = wra_admintable::getpost('fieldfield'.wra_lang::getdefault());
		$savepc->lang = wra_admintable::getpost('fieldlang'.wra_lang::getdefault());
		$savepc->value = wra_admintable::getpost('fieldvalue'.wra_lang::getdefault());
		$savepc->rowid = wra_admintable::getpost('fieldrowid'.wra_lang::getdefault());
		$savepc->key = wra_admintable::getpost('fieldkey'.wra_lang::getdefault());

		if($saveid!=-1){
			// $savepc->update();
		}else{
			// $savepc->add();
		}
		//echo $savepc->id;
		//die();
		$languages=wra_lang::getlist();
		foreach($languages as $l0){
			if ($l0->alias != wra_lang::getdefault()){
				wra_langed::setvalue('site','table',$l0->alias,$savepc->id,WRA::getpost('fieldtable-'.$l0->alias),WRA::getpost('fieldkey-'.$l0->alias));
				wra_langed::setvalue('site','field',$l0->alias,$savepc->id,WRA::getpost('fieldfield-'.$l0->alias),WRA::getpost('fieldkey-'.$l0->alias));
				wra_langed::setvalue('site','lang',$l0->alias,$savepc->id,WRA::getpost('fieldlang-'.$l0->alias),WRA::getpost('fieldkey-'.$l0->alias));
				wra_langed::setvalue('site','value',$l0->alias,$savepc->id,WRA::getpost('fieldvalue-'.$l0->alias),WRA::getpost('fieldkey-'.$l0->alias));
				wra_langed::setvalue('site','rowid',$l0->alias,$savepc->id,WRA::getpost('fieldrowid-'.$l0->alias),WRA::getpost('fieldkey-'.$l0->alias));			
				wra_langed::setvalue('site','key',$l0->alias,$savepc->id,WRA::getpost('fieldkey-'.$l0->alias),WRA::getpost('fieldkey-'.$l0->alias));	
			}		
		}

		return $savepc->id;
	}

	function add()
	{
		$wd=new wra_db();            
		$this->id=WRA::getnewkey("".WRA_CONF::$db_prefix.'langed');
		$wd->query= "INSERT INTO `".WRA_CONF::$db_prefix."langed` (
				`id`,
				`table`,
				`field`,
				`lang`,
				`value`,`rowid`,`key`
				)VALUES(
				'$this->id',
				'$this->table',
				'$this->field',
				'$this->lang',
				'$this->value',
				'$this->rowid',
				'$this->key'
				)";
		$wd->execute();	
		$this->id=$wd->getlastkey();
		$wd->close() ;unset($wd);
	}
	function update()
	{	
		$wd=new wra_db();
		$wd->query = "UPDATE `".WRA_CONF::$db_prefix."langed`
				SET 
				`value`='$this->value',
				`key`='$this->key'
				WHERE `id`='$this->id'";
		//echo $wd->query."<br/>";
		$wd->execute();	
		$wd->close() ;unset($wd);
		
	}
	function ifexist($id)
	{
		$result=false;
		$wd=new wra_db();		
		$wd->query= "SELECT id FROM `".WRA_CONF::$db_prefix."langed` WHERE `id` = '$id'";		
		$wd->executereader();		
		$result=($u0=$wd->read());		
		$wd->close() ;unset($wd);
		return $result;
	}

	static function isexist($wf, $id){//возвращает true, если объект с запрашиваемым id существует
		$result=false;
		$wd=new wra_db();
		$wd->query= "SELECT id FROM `".WRA_CONF::$db_prefix."langed` WHERE `id` = '$id'";
		$wd->executereader();
		$result=($u0=$wd->read());
		$wd->close();
		unset($wd);
		return $result;
	}

	function delete()
	{
		$wd=new wra_db();
		
		$wd->query =  "DELETE FROM `".WRA_CONF::$db_prefix."langed`  where `id`='$this->id'";
		$wd->execute();
		$wd->close() ;unset($wd);
		return true;
	}
	function setvalue($table,$field,$lang,$rowid,$value,$key="")
	{
	//	echo $table."-".$field."-".$lang."-".$rowid.'<br/>';
		$result="";
		$wd=new wra_db();
		$oldid=-1;
		$wd->query  = "SELECT 
				`id`
				FROM `".WRA_CONF::$db_prefix."langed` where `rowid`='$rowid' and `table`='$table' and `field`='$field' and `lang`='$lang' order by id";
		$wd->executereader();
		if($u0=$wd->read()){
			$oldid=$u0[0];
		}
		// print_r($u0);
		// die();
		$wd->close() ;unset($wd);
		if($oldid==-1){
			$langv=new wra_langed();
			$langv->table=$table;
			$langv->field=$field;
			$langv->lang=$lang;
			$langv->value=$value;
			$langv->rowid=$rowid;
			$langv->key=$key;
			$langv->add();
		}else{
			$langv=new wra_langed();
			$langv->load($oldid);
			$langv->value=$value;
			$langv->key=$key;
			$langv->update();
		}
		return $result;
	}
	static function getvalue($table,$field,$lang,$rowid, $key="")
	{
	    
		$result="";
		$wd=new wra_db();

		$wd->query  = "SELECT 
				`value`
				FROM `".WRA_CONF::$db_prefix."langed` where `rowid`='".$rowid."' and `table`='$table' and `field`='$field' and `lang`='$lang'  and `key`='$key' order by id";
		
		$wd->executereader();
		if($u0=$wd->read()){
			if($u0[0]!=""){
				$result=$u0[0];
				
			}else{
				if($lang!=wra_lang::getdefault()){
					//$t0=wra_langed::getvalue($table,$field,wra_lang::getdefault(),$rowid);
					/*if($t0!="")*/$result=$t0;
				}

			}
		}
		$wd->close() ;unset($wd);
        if($cached){
            $fp = fopen($path, 'w'); 
            fwrite($fp, $result); 
            fclose($fp); 
        
        }
		return $result;
	}
	function loadid($id){
    $this->id=$id;
    }
    function loadmore(){
        $this->load($this->id);
    }
	function load($id)
	{
		$wd=new wra_db();
		$this->id = $id;
		
		$wd->query  = "SELECT 
				`id`,
				`table`,
				`field`,
				`lang`,
				`value`,`rowid`,`key`
				FROM `".WRA_CONF::$db_prefix."langed` where `id`='$this->id'";
		$wd->executereader();
		if($u0=$wd->read()){			
			$this->id = $u0[0];			
			$this->table = $u0[1];			
			$this->field = $u0[2];			
			$this->lang = $u0[3];			
			$this->value = $u0[4];			
			$this->rowid=$u0[5];
			$this->key=$u0[6];
		}
		$wd->close() ;unset($wd);
		
	}

	static function loadlangeddict(){
		$wd = new wra_db();
		$wd->query  = "SELECT 
				`id`,
				`table`,
				`field`,
				`lang`,
				`value`,`rowid`,`key`
				FROM `".WRA_CONF::$db_prefix."langed`";
		$wd->executereader();
		while ($u0 = $wd->read()){
			//var $obj=array();
			WRA::$langdict[$u0[0]]['table'] = $u0[1];
			WRA::$langdict[$u0[0]]['field'] = $u0[2];
			WRA::$langdict[$u0[0]]['lang'] = $u0[3];
			WRA::$langdict[$u0[0]]['value'] = $u0[4];
			WRA::$langdict[$u0[0]]['rowid'] = $u0[5];
			WRA::$langdict[$u0[0]]['key'] = $u0[6];
			//array_push(wra_dictionary::$langdict	
	}
		//die(print_r($langdict));
		$wd->close(); unset($wd);
	}
}


?>