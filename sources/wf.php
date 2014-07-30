<?php

class wf {
    var $search='';
    static $dbglobal;
    //put your code here
    var $cp; // current page
    var $dbconnection; // curconn;
    var $requestedpage;
    var $realpage = '';
    var $currentpage;
    var $ext0;
    var $pageheader = '';
    var $lang;
    var $caching = false;
    var $item;var $isloged=false;
    var $models = array();var $routes=array();
    var $pagetype = 0;
    var $curroute;//текущий путь
   var $languages=array();
   var $options=array();
    function nicedie() {
        $this->closedb();
        die();
    }
  //   function loadoptions(){
		// $result=array();
		// $wd=new wra_db();
		
		// $wd->query  = "SELECT 
		// 		`key`,
		// 		`value`
		// 		FROM `".WRA_CONF::$db_prefix."options`";
		// // WRA::debug($wd->query);
		// $wd->executereader();
		// while($u0=$wd->read()){
		// 	$this->options[$u0[0]]=$u0[1];
		// }
		// $wd->close() ;
		// unset($wd);
		// return $result;
  //   }
    function wf() {
        $this->models = WRA_ENV::models();
        for ($i = 0; $i < count($this->models); $i++) {
            require_once(WRA_Path.'/'.$this->models[$i]->path);
        }
        $this->routes=wfroute::routetable();
       
        if (session_id() == '') {

            session_start();
        }

        if (WRA_CONF::$offline == 1) {

            WRA::e(WRA_CONF::$offline_text);
            WRA::nicedie();
        }

        $this->opendb();
        //$this->languages=wra_lang::getlist();
        // $this->loadoptions();
       // $this->options = wra_options::loadoptions();
        $this->cp = new wra_page();

        $this->isloged=wra_userscontext::isloged($this);
         
        if ($this->isloged) {
            $this->user = new wra_users();
            $userid = wra_userscontext::curuser();
            $this->user->load($userid);
            // WRA::debug($this->user);
        }


        $this->requestedpage = strtolower(WRA::getfullnoquestion());
        $this->requestedpage = ltrim(rtrim( str_replace(WRA_CONF::$rootpath, '', $this->requestedpage), '/'),'/');

        if ($this->requestedpage == '')
            $this->requestedpage = 'index';

        //$meta = new wra_meta();
        //$meta->getbypage($this->requestedpage);
        // WRA::debug($this->requestedpage);
       /*   
        if (!empty($meta->id)) {
            $this->cp->keywords = $meta->meta_keywords;
            $this->cp->description = $meta->meta_description;
            $this->cp->ogimage = $meta->og_image;
        } else {
            $this->cp->keywords = WRA_CONF::$keywords;
            $this->cp->description = WRA_CONF::$description;
            $this->cp->ogimage = WRA::base_url()."images/post.png";                            
        }
   */
        $cachename = 'link_' . $this->realpage . $this->cp->language;
        if (!wra_cacheflow::cacheexist($cachename)) {
             $this->realpage = $this->requestedpage;
           
            $this->ext0 = WRA::file_extension($this->requestedpage);
            $fileextimage = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($this->ext0, $fileextimage)) {
                WRA::htmlpic('/images/pixel.png');
                $this->nicedie();
            }
        } else {
            $this->requestedpage = 'proj';
        }
        if ($this->is404()) {
            $this->set404();
        }else {
            header('Status: 200 OK');
            if ($this->requestedpage == '/contacts' || strpos($this->requestedpage, 'admin') >= 0) {
                $this->caching = false;
            }
            $cachename = 'link_' . $this->realpage . $this->cp->language;
            $cache0 = new wra_cacheflow($cachename, $this->caching);
            if ($cache0->begin()) {
                $this->prepare();
                if (!$this->item->dont) {
                    if (!$this->item->noheader){
                        if (!empty($meta->id)) {
                            $this->cp->pagehead = $meta->title;
                        }
                        include 'template/parts/_header.php';
                    }
                    $this->show();
                    if (!$this->item->nofooter)
                        include 'template/parts/_footer.php';
                }
            }
            $cache0->end();
        }
        $this->closedb();
    }
    function includeheader(){
          include 'template/parts/_header.php';
    }
     function includefooter(){
          include 'template/parts/_footer.php';
    }
    function set404(){
        $sapi_name = php_sapi_name();
        if ($sapi_name == 'cgi' || $sapi_name == 'cgi-fcgi') {
            header('Status: 404 Not Found');
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        }
        $this->cp->pagehead = 'Ошибка 404 |  ' . WRA_CONF::$sitename;
        $this->cp->add_jquery();
        $this->cp->add_style('styles/404.css');

        if (false)
            include 'template/parts/_header.php';
        include 'template/404.php';
        if (false)
            include 'template/parts/_footer.php';
        $this->nicedie();
    }
    function prepare() {
        switch ($this->pagetype) {
            case 1:case 2:
                $this->item->addscripts();
                $this->item->addstyles();
                $this->item->run();
                break;
        }
    }

    function show() {

        switch ($this->pagetype) {
            case 1:

                $this->item->show(WRA_Path . '/template/' . $this->curroute->path . '');
                break;
            case 2:

                $this->item->show(WRA_Path . '/template/' . $this->curroute->path . '/index.php');
                break;
        }
    }
    function linkpattern($link, $route, &$keys = array()) {
        $patternlink = false;
        $arrlink = explode("/", $link);
        $arrroute = explode("/", $route->vpath);
        // WRA::debug($arrlink);
        // WRA::debug($arrroute);
        if ($arrlink[0]==$arrroute[0]&&count($arrroute)==count($arrlink)){
            foreach ($arrroute as $k => $v) {
                if ($k == 0 ) continue;
                switch ($v) {
                    case '{l}':
                        $arr['type'] = "l";
                        $arr['index'] = addslashes($arrlink[$k]);
                        $keys[] = $arr;
                        $patternlink = true;
                        break;
                    case '{i}':
                        $arr['type'] = "i";
                        $arr['index'] = (int)$arrlink[$k];
                        $keys[] = $arr;
                        $patternlink = true;
                        break;                        
                    default:
                        # code...
                        break;
                }
            }
        }
        return $patternlink;
    }
    function is404() {
        $result = true;
        for($i=0;$i<count($this->routes);$i++){
            $this->currouteindex = 0; $keys = array();
            if ($this->linkpattern($this->requestedpage, $this->routes[$i], $keys)) {
                $this->curroute=$this->routes[$i];
                $this->currouteindex = $keys;
                break;
            }elseif($this->requestedpage==$this->routes[$i]->vpath){
                $this->curroute=$this->routes[$i];       // echo 'is'.$this->routes[$i]->vpath.'<br/>';
                break;
            }
        }
        // WRA::debug("keys ");
        // WRA::debug($keys);
        // WRA::debug("curroute");
        // WRA::debug($this->curroute);
        // die();
        //  WRA::debug($this->routes);
       //   die($this->requestedpage);
        // WRA::debug(wra_pages::get_list());
        // print_r(wra_lang::getdefault()); die();
      /*  $this->pages = wra_pages::get_list('_'.wra_lang::getdefault());
        foreach ($this->pages as $k => $v) {
            if ($this->requestedpage==$v->path) {
                $this->curroute->path = "pages.php";
                $this->cp->pageid = $v->id;
                $this->cp->header = $v->header;
                $this->cp->keywords = $v->keywords;
                $this->cp->content = $v->content;
                break;
            }
        }*/
        // WRA::debug($this->requestedpage);
        // die()
        if(isset($this->curroute)){
            $fn = WRA_Path . '/controllers/' . $this->curroute->path;
      
            include $fn;
            $this->item = new wfitem($this);
          
            $this->item->wf = $this;
            $this->pagetype = 1;
            if (!empty($this->curroute->index))
                $this->item->itemindex = $this->currouteindex;
            $result = false;

        }
        return $result;
    }

    function opendb() {
        $this->dbconnection = mysql_connect(WRA_CONF::$dbhost, WRA_CONF::$dbuser, WRA_CONF::$dbpassword);
        mysql_query('SET NAMES \'utf8\'', $this->dbconnection);

        mysql_query('SET SQL_MODE=\'\'', $this->dbconnection);
        mysql_select_db(WRA_CONF::$dbdb, $this->dbconnection);
        wf::$dbglobal = $this->dbconnection;
    }

    function closedb() {

        if (isset($this->dbconnection))
            mysql_close($this->dbconnection);
    }

}

class wfitembase {

    var $header = '';
    var $wf;
    var $dont = false;
    var $nofooter = false;
    var $noheader = false;
    var $lang;

    function show($path) {

        include $path;
    }

    function run() {
        
    }

 function addscripts() {
        $scripts = WRA_ENV::scripts();
      /*  for ($i = 0; $i < count($scripts); $i++) {
             $this->wf->cp->add_script($scripts[$i]);
         }
         return;*/
        $cachefile=WRA_Path.'/cache/'.md5(WRA_CONF::$sitename.WRA_CONF::$version).'.js';
          if(WRA_CONF::$usedebug)
           unlink($cachefile);
        if(!file_exists($cachefile)){
       
           $txt='';
        for ($i = 0; $i < count($scripts); $i++) {
            $lines=  file_get_contents(WRA_Path.'/'.$scripts[$i]);
           $txt.=$lines."\n";
          //  $this->wf->cp->add_script($scripts[$i]);
        }
        file_put_contents($cachefile, $txt);
       }
          $this->wf->cp->add_script('cache/'.md5(WRA_CONF::$sitename.WRA_CONF::$version).'.js');
    }
    function addstyles() {
        $styles = WRA_ENV::styles();
        $cachefile=WRA_Path.'/cache/'.md5(WRA_CONF::$sitename.WRA_CONF::$version).'.css';
          //  if(WRA_CONF::$usedebug)
        unlink($cachefile);
       if(!file_exists($cachefile)){
         
        
           $txt='';
        for ($i = 0; $i < count($styles); $i++) {
            $lines=  file_get_contents(WRA_Path.'/'.$styles[$i]);
           $txt.=$lines;
          //  $this->wf->cp->add_script($scripts[$i]);
        }
        file_put_contents($cachefile, $txt);
       }
          $this->wf->cp->add_style('cache/'.md5(WRA_CONF::$sitename.WRA_CONF::$version).'.css');
    }

}

class wfroute {

    var $name = '';
    var $vpath = '';
    var $path = '';

    function wfroute($name, $vpath, $path) {
        $this->name = $name;
        $this->vpath = $vpath;
        $this->path = $path;
    }

     static function routetable() {
        $result = WRA_ENV:: routes();
      
        $adminresult = WRA_ENV:: adminnodes();
        for ($i = 0; $i < count($adminresult); $i++) {
            $aresult = $adminresult[$i];
            if ($aresult->defaultadmin)
                $result[] = new wfroute($aresult->link, $aresult->link, 'admin/table.php');
            if ($aresult->defaultedit)
                $result[] = new wfroute($aresult->link . '/edit', $aresult->link . '/edit', 'admin/edit.php');
            if ($aresult->defaultview)
                $result[] = new wfroute($aresult->link . '/view', $aresult->link . '/view', 'admin/view.php');
        }
         
        return $result;
    }

}

class wfmodel {

    var $name = '';
    var $vpath = '';
    var $path = '';

    function wfmodel($path) {

        $this->path = $path;
    }

}

class wfbaseclass{
    static function getacceslevel() {
         return array();
    }
    
}

class adminnodes {

    var $link = '';
    var $name = '';
    var $order = '';
    var $defaultadmin = true;
    var $defaultedit = true;
    var $defaultview = true;

    function adminnodes($link, $name, $defaultadmin = true, $defaultedit = true, $defaultview = true) {
        $this->link = $link;
        $this->name = $name;
        $this->defaultadmin = $defaultadmin;
        $this->defaultedit = $defaultedit;
        $this->defaultview = $defaultview;
    }

}

class admincolumntype {
const none = 123;
const id=0;
const text=1;

const pic=2;
const date=3;
const bigtext=4;
const check=5;
const int=6;
const dropdown=7;
const file=8;
const textsource=9;
const password=10;
const hidden=11;
const nothing=16;
const h2header=17;
const doubletext=12;
const label=13;
const datetime=14;
const link=15;
const multiselect=18;
const customfield=19;
const textsource_label=20;
const groupit=21;
const images=22;
const tinymce = 23;
const json = 24;
const currentuser=25;
const fromdrop=26;
}


class admincolumn {

    var $columns = array();
    var $field = '';
    var $sqlfield = '';
    var $header = '';
    var $tablestatus = admincolumntype::none;
    var $editstatus = admincolumntype::none;
    var $sortorder = 0;
    var $type = '';
    var $width = 0;
    var $dropdown = array();
    var $uselanguages=false;
    var $lang='ru';
    var $skipsave=false;
    var $multiselect=null;
    //--from old
    var $name;
	var $table;
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
	var $classes='';
	var $description='';
	var $culstomfieldpage='';
        //---------------
    function getdropdown($key) {
        $html = '';
        foreach ($this->dropdown as $k => $v) {
            if ($k != key)
                $html .= '<option value="' . $k . '">' . $v . '</option>';
            else
                $html += '<option selected="selected" value="' . $k . '">' . $v . '</option>';
        }
        $_result = '<select id="txt' . $this->field . '" name="txt' . $this->field . '>' . $html . '</select>';

        return $_result;
    }

    function getdropvalue($key) {
        if (isset($dropdown[key]))
            return $dropdown[key];
        return '';
    }

    function admincolumn($fieldtype, $field, $header, $tablestatus, $editstatus, $sortorder = 0, $dropdown = array()) {
        $this->type = $fieldtype;
        $this->field = $field;
        $this->sqlfield = $field;
        $this->header = $header;
        $this->tablestatus = $tablestatus;
        $this->editstatus = $editstatus;
        $this->sortorder = $sortorder;
        $this->dropdown = $dropdown;
    }

}

class adminrows {

    var $id = 0;
    var $isheader = false;
    var $values = array();

    function searchstring() {
        $result = '';
        foreach ($this->dropdown as $k => $v) {
            $result .= strtolower($v);
        }
        return $result;
    }

    function delete($table) {
        $wd = new wra_db();
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . $table . "` where `id`='.$this->id'";
        $wd->execute();
        $wd->close();

        unset($wd);
        return true;
    }

}


class wfadmin {
    var $multilanguages=false;
    var $curid = 0;
    var $innerclass;
    var $table = '';
    var $selectquery = '';
    var $where = '';
    var $order = '';
    var $fields = array();
    var $columns = array();

    function wfadmin($link) {
        $classname=  'wra_'.ltrim(ltrim($link,'admin'),'/');
        // $code_a = 'wra_'.$classname.'::getacceslevel("asdf");';
        $code_b = $classname . '::adminit($this);';
        if (class_exists($classname)) {
            eval($code_b);
        }
    }

    function addfirst($lang='') {
        $wd = new wra_db();
 
        $fields = $this->save($lang);
        
        $insertfields = '';
        $insertvalues = '';
        foreach ($fields as $k => $v) {
            if($k!='id'){
            $insertfields.=",`" . $k . "`";
            $insertvalues.=",'" . $v . "'";}
        }

        $wd->query = 'INSERT INTO ' . WRA_CONF::$db_prefix . $this->table.$lang . " (
             `id`" . $insertfields . "
             )VALUES(
             ''" . $insertvalues . "
             )";
        $wd->execute();

        if (!WRA_CONF::$usegetkey)
            $this->curid = $wd->getlastkey();
        $wd->close();

        unset($wd);
        $this->aftersave($lang);
    }
     function aftersave($lang=''){
        $fields=array();
        
         foreach ($this->columns as $ac) {
            if ($ac->editstatus == admincolumntype::none)
                continue;
    
            switch ($ac->editstatus) {
               case admincolumntype::multiselect:
                    $ilang=$lang;
                    if(empty($ilang))$ilang='ru';
                    $values=(is_array($_POST['txt'.$ac->field.'multiple']))?($_POST['txt'.$ac->field.'multiple']):(array());               
                    foreach(array_keys($ac->dropdown) as $i){                        
                        if(in_array($i,$values)){                        
                            wra_multiselect::add($ac->multiselect->table,$ac->multiselect->kfield,$ac->multiselect->tfield,$this->curid,$i);
                        }else{
                            wra_multiselect::delete($ac->multiselect->table,$ac->multiselect->kfield,$ac->multiselect->tfield,$this->curid,$i);
                        }
                    }
                      
                    break;
                case admincolumntype::images:
                    $ilang=$lang;
                    if(empty($ilang))$ilang='ru';
                    $ilang = str_replace('_', '', $lang);
                    $images= wra_admintable::getimages('txt'.$ac->field,$ilang);
                    // WRA::debug($ilang);
                    // WRA::debug($ac->field);
                    // WRA::debug($images);
                    foreach ($images as $key => $value) {
                        // WRA::debug($this);
                        $newitem = new wra_image();
                        $newitem->load($key, $lang);
                        $newitem->galinfoid = $this->curid;
                        $newitem->header = $value[$ilang]['header'];
                        $newitem->link = $value[$ilang]['link'];
                        $newitem->parttype =  $this->table;
                        $newitem->description = $value[$ilang]['description'];
                        $newitem->sortorder = $value[$ilang]['sortorder'];
                        $newitem->morevisual = $value[$ilang]['morevisual'];
                        $newitem->htmlcontent = $value[$ilang]['htmlcontent'];
                        $newitem->update($lang);                        
                        // WRA::debug($newitem);
                    }                 
                    break;
              
            }

        }
        return $fields;
    }
    function save($lang=''){
        $fields=array();
        // WRA::debug($this->columns);
        // WRA::debug($this->columns);
         foreach ($this->columns as $ac) {
            $skipsave=false;$skipfsave=false;$skippsave=false;
            if ($ac->editstatus == admincolumntype::none)
                continue;             
            $postvalue=$_POST["txt".$ac->field.$lang]; 
            // WRA::debug("txt".$ac->field.$lang);               
            switch ($ac->editstatus) {
               /* case admincolumntype::images:
                    $ilang=$lang;
                    if(empty($ilang))$ilang='ru';
                    $images= wra_admintable::getimages("txt".$ac->field,$ilang);
                 
                    foreach ($images as $key => $value) {
			$newitem = new wra_image();
			$newitem->load($key, $ilang);

			$newitem->galinfoid = $this->curid;
			$newitem->header = $value[$lang]['header'];
                        $newitem->link = $value[$lang]['link'];
                        $newitem->parttype =  $this->table;
			$newitem->description = $value[$lang]['description'];
			$newitem->sortorder = $value[$lang]['sortorder'];
			$newitem->morevisual = $value[$lang]['morevisual'];
			$newitem->htmlcontent = $value[$lang]['htmlcontent'];

			$newitem->update($ilang);
                        
                       }  
                    break;*/
                case admincolumntype::pic:
                    $pic='';$tmbpic='';
                    // WRA::debug($ac->field.$lang);
                    wra_admintable::getpic($pic,$tmbpic,$ismessage,$admimessage,'',200,"txt".$ac->field.$lang,false,true);
                    // WRA::debug($pic);  
                    if(!empty($pic)) {
                        $currow->values[$ac->field] = $pic;
                    }else{                        
                        $skipsave=true;
                    }      
                    break;
                case admincolumntype::file:
                    $pic='';$tmbpic='';
                    // WRA::debug($ac->field.$lang);
                    wra_admintable::getfile($pic,'',"txt".$ac->field.$lang);
                    if(!empty($pic)) {
                        $currow->values[$ac->field] = $pic;
                    } else {
                        $skipfsave=true;
                    }
                    break;
                case admincolumntype::password:
                    // $pic='';$tmbpic='';
                    // WRA::debug($ac->field.$lang);
                    // wra_admintable::getfile($pic,'',"txt".$ac->field.$lang);
                    $pswd = $postvalue;
                    // $currow->values[$ac->field]
                    if(!empty($pswd)) {
                        $currow->values[$ac->field] = md5($pswd);
                    } else {
                        $skippsave=true;
                    }
                    break;
                case admincolumntype::fromdrop:
                    break;
                case admincolumntype::datetime:
                      $currow->values[$ac->field] = strtotime($postvalue);
                    //     $currow->values[$ac->field] = WRA::strtotimef($postvalue,WRA_CONF::$formatdate);
                 // $currow->values[$ac->field] = strtotime($postvalue);
                  //    die($currow->values[$ac->field].'@');
                     //    die('@'.strtotime( "$postvalue"));
                 break;
                case admincolumntype::currentuser://получить из текущего пользователя

                    break;
                case admincolumntype::check:
                    if (!empty($postvalue)) {
                        $currow->values[$ac->field] = "1";
                    } else {
                        $currow->values[$ac->field] = "0";
                    }

                    break;
                default:
                    $currow->values[$ac->field] = $postvalue;
                    break;
            }
            // WRA::debug($ac->field);
            // WRA::debug($currow->values[$ac->field]);
            $prmeter = '';
            if ($ac->sqlfield != "id")
                switch ($ac->type) {
                    case "String":
                        $prmeter = addslashes($currow->values[$ac->field]);
                        break;
                    default:
                        $prmeter = $currow->values[$ac->field];
                        break;
                }
            // if(!$skipfsave)WRA::debug($currow->values[$ac->field]);  
            // WRA::debug($prmeter);
            if(!$skipsave&&!$skipfsave&&!$skippsave)$fields[$ac->sqlfield] = $prmeter;
            // WRA::debug($fields);
        }
        return $fields;
    }
    function updatefirst($lang) {
        $wd = new wra_db();
        
        $fields = $this->save($lang);
        // WRA::debug($lang);
        // WRA::debug($fields);
        $insertfields = '';
        $first = true;
        foreach ($fields as $k => $v) {
            if($k!='id'){
                if (!$first)
                    $insertfields.=",";
                $insertfields.="`" . $k . "`='" . $v . "'";
                $first = false;
            }        
        }

        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . $this->table .$lang. "` SET
                " . $insertfields . "
                WHERE id=" . $this->curid;
        // WRA::debug($wd->query);
        $wd->execute();

        $wd->close();
        unset($wd);
        $this->aftersave($lang);
    }

    function deletefirst($lang) {
        $wd = new wra_db();
    
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . $this->table .$lang. "` where `id`='$this->curid'";
       
        $wd->execute();
        $wd->close();

        unset($wd);
        return true;
    }

    var $_rows = array();
    var $_currow;

    function currow($lang='') {
        // WRA::debug($lang);
        // WRA::debug($this->_currow);
        // if ( (!isset($this->_currow)) ) {           
            $a = $this->getrows($lang,1, 1);           
            if (count($a) > 0) {                
                $this->_currow = $a[0];   
                // WRA::debug($a[0]);            
                  foreach ($this->columns as $ac) {              
                   switch ($ac->editstatus) {
                    case admincolumntype::multiselect:
                        $ilang=$lang;
                        if($ilang=='')$ilang='ru';                        
                        $ac->items=  wra_multiselect::getlist($ac->multiselect->table,$ac->multiselect->kfield,$ac->multiselect->tfield,$this->curid,$sO);                    
                    break;   
                    case admincolumntype::images:
                        $ilang=$lang;
                        if($ilang=='')$ilang='ru';
                        $items=wra_image::getlistadmin($this->curid,$this->table,$ilang);
                        // WRA::debug($ilang);
                        // WRA::debug($items);
                        if(!empty($items))
                         $ac->items[str_replace('_', '', $ilang)]=$items;
                    break;                    
                    }                      
                   }                
                return $this->_currow;
            }
            $this->_currow = new adminrows();
            foreach ($this->columns as $ac) {
                $this->_currow->values[$ac->field] = '';
            }
        // }        
        return $this->_currow;
    }
    function clear(){
        $this->_rows=null;
       $this->_currow=null;        
    }
    function getrows($lang='',$page=0, $count=0) {
        // WRA::debug($lang);
        // WRA::debug($this->_rows);
        // if ($this->_rows == null) {
            $this->_rows = array();$first = true;
            if ($this->curid != 0) {
                $this->where = " where id=" . $this->curid;
            }else{
               if(!empty($this->search)){
                 if(!empty($this->where))
                 $this->where = " where ";
                  foreach ($this->columns as $k => $v) {
                     if (!$first)
                      $this->where .=" or ";
                      $this->where .=" `" . $v->sqlfield . "` like '%".$this->search."%'";
                      $first = false;
                  }
              }
                
            }
            $insertfields = '';
            $first = true;

            foreach ($this->columns as $k => $v) {
                if (!$first)
                    $insertfields.=",";
                $insertfields.="" . $v->sqlfield . "";
                $first = false;
            }
            $limit='';
            if($page!=0&&$count!=0){
                $limit .= ' limit '.($count*($page-1)).','.$count;
            }
             if(!empty($this->where)){
               
                 if(!strpos($this->where, 'where')){
                     $this->where=' where '.$this->where;
                 }
             }
           
            $sqlquery = "select id," . $insertfields . " from `" . WRA_CONF::$db_prefix . $this->table .$lang. "` " . $this->where . " " . $this->order.$limit;
           
            if (!empty($this->selectquery)) {
                $sqlquery = $this->selectquery;
            }
            $result = array();
            $wd = new wra_db();
            $wd->query = $sqlquery;
            $wd->executereader();
            while ($u0 = $wd->read()) { 
                    $ar = new adminrows();
                    $pointer = 1;
                    $ar->id = $u0[0];
                    
                    foreach ($this->columns as $ac) {
                            
                            // WRA::debug($ac->type);
                            switch ($ac->type) {
                                case "DateTime":
                                $ar->values[$ac->field] = date(WRA_CONF::$formattime,$u0[$pointer]);
                                // WRA::debug($ar->values[$ac->field]);

                                break;
                                case "IntDrop":
                                    $ar->values[$ac->field] = $ac->dropdown[$u0[$pointer]];

                                    break;
                                default:
                                    
                                    $ar->values[$ac->field] = $u0[$pointer];

                                    break;
                            }

                            $pointer++;
                        }
                          
                        $this->_rows[] = $ar;
                    
                 
                }
                $wd->close();
            // }
            return $this->_rows;
        }

            function getcount($lang="") {
                $result = 0;
                if ($this->curid != 0) {
                    $this->where = " where id=" + $this->curid;
                }           
                if(!empty($this->where)){
                 if(!strpos($this->where, 'where')){
                     $this->where=' where '.$this->where;
                 }
                }
                $sqlquery = "select count(id) from `" . WRA_CONF::$db_prefix . $this->table .$lang. "` " . $this->where;
                if (!empty($this->selectquery)) {
                    $sqlquery = $this->selectquery;
                }
                $wd = new wra_db();
                $wd->query = $sqlquery;
                $wd->executereader();
                if ($u0 = $wd->read()) {
                    $result = $u0[0];
                }
                $wd->close();
                  return $result;
            }

          
        
        
}
?>
