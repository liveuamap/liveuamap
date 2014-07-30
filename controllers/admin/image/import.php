<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitembase{
     var $curnode;
     var $onpage=30;
   var $curadmin;
    var $currows=array();
    var $rowscount=0;
    var $pagescount=0;var $page=0;
    var $adminnodes=array();    var $noticecount=0;
    var $totalcount=0;
    function  wfitem($wf){
      $this->noticecount=  wra_adminnotices::getcount();
      if (wra_userscontext::isloged($wf)&&wra_userscontext::hasright('adminpage')) {
              $wf->cp->baseico = true;
              $wf->cp->norobots();
              $wf->cp->bodyclass = "admin_login";            
      }else {
          WRA::gotopage(WRA::base_url().'admin/login');
          $wf->nicedie();
      }
     
      $this->adminnodes=  WRA_ENV::adminnodes();
      for($i=0;$i<count($this->adminnodes);$i++){
        $r = wra_userscontext::getaccess($this->adminnodes[$i]->link);
        if($wf->requestedpage==$this->adminnodes[$i]->link){
            if (!$r) {
              $wf->set404();
              break;
            } 
            $this->curnode=$this->adminnodes[$i];
            $this->curadmin = new wfadmin($this->curnode->link);
            break;
        }
        if (!$r) unset($this->adminnodes[$i]);
      }
     
      $this->header=$this->curnode->name;
      // WRA::debug($_POST); 
      if(isset($_POST['import_source'])){
        $this->importUrl = $_POST['import_source'];
      }
      $this->showAlbums = false;
      if (isset($_POST['import_source_search_btn'])&&!empty($this->importUrl)) {
        $this->get_albums_list();
        $this->showAlbums = true;
      }
      $this->importAlbums = false; $this->importIndex = 0;
      if (isset($_POST['import_source_execute_btn'])&&!empty($this->importUrl)) {
        $this->get_albums_list();
        $this->importAlbums = true; 
        if (isset($_POST['importIndex'])){ 
          $this->importIndex = (int)$_POST['importIndex'];
          if (isset($_POST['import_album'])){
            if (!empty($this->list)) {
              if (isset($_POST['parttype'])&&!empty($_POST['parttype'])){
                $parttype = $_POST['parttype'];
                $classname=  'wra_'.$parttype;
                // $code_b = $classname . '::adminit($this);';
                if (class_exists($classname)) {
                    $h = $this->list[$this->importIndex]['header'];
                    $code_b = '$retid = '.$classname.'::create_from_import($h,$h);';
                    eval($code_b);

                    $img = new wra_image();
                    $img->header = '';
                    $img->description = '';
                    $ismessage = false;
                    $admimessage = '';
                    $img->keywords = '';
                    $img->galinfoid = $retid;
                    $img->parttype = $parttype;
                   
                   
                    foreach ($this->list[$this->importIndex]['images'] as $k => $v) {
                      $r0 = new resizeImage();
                      $curPath = $this->importUrl.'/'.$this->list[$this->importIndex]['header'].'/'.$v;
                      $r0->setImage($curPath);
                      // WRA::debug(WRA_Path.'upload/gallery');
                      $r0->createThumb(0,250,WRA_Path.'/upload/gallery');
                      $img->tmbpic = 'upload/gallery/'.$r0->thumbName;
                      $r0->createThumb(0,1000,WRA_Path.'/upload/gallery');
                      $img->pic = 'upload/gallery/'.$r0->thumbName;
                      // WRA::debug($img);
                      // die();
                      
                      // $wimage= wra_admintable::getpic($img->pic, $img->tmbpic, $ismessage, $admimessage, 'gallery/', 340, 'qqfile', false, true);            
                      // $img->galinfoid =0;
                      // $img->width=$wimage->imagewidth;
                      // $img->height=$wimage->imageheight;
                      
                      $languages=wra_lang::getlist();
                      $img->id = '';
                      $img->add("_ru");
                      $ruid=$img->id;
                      foreach($languages as $l0){
                          if($l0->alias!='ru'){
                            $img->id = $ruid;
                            $img->add('_'.$l0->alias);
                          }
                      }
                      // WRA::debug($img);
                    }
                }
              }
            }
          }
          // if not last album, inc album index
          if ($this->importIndex < count($this->list)){
            $this->importIndex++;
            $this->last = false;
          } else {
            $this->last = true;
          }
        }
      }
      if(isset($_POST['btnclicked'])){
        switch($_POST['btnclicked']) {
          case 'btnfind':
            // $this->curadmin->search=addslashes($_REQUEST['txtfind']);
            break;            
        }
      }
      if(!$this->curadmin->multilanguages){
        // $this->currows = $this->curadmin->getrows('',$this->page+1, $this->onpage);
        // $this->totalcount=$this->curadmin->getcount();
      } else{
        // $this->currows = $this->curadmin->getrows('_'.WRA_CONF::$language,$this->page+1, $this->onpage);
        // $this->totalcount=$this->curadmin->getcount('_'.WRA_CONF::$language);
      }
      // $this->pagescount=$this->getcount();
      // WRA::debug($this->pagescount);
      // WRA::debug($this->totalcount);
    }

    function get_albums_list() {
      $this->list = array();
      $this->dirlist = scandir($this->importUrl);
      foreach ($this->dirlist as $k => $v) {
        if ($v == '..' || $v == '.') continue;
        $curPath = $this->importUrl.'/'.$v;
        if (is_dir($curPath)) {
          $this->list[count($this->list)]['header'] = $v;
          $this->list[count($this->list)-1]['curPath'] = $curPath;
          $this->list[count($this->list)-1]['images'] = scandir($curPath);
          array_shift($this->list[count($this->list)-1]['images']);
          array_shift($this->list[count($this->list)-1]['images']);
        }
      }
    }

    function run(){
      $this->nofooter=true;
      $this->noheader=true;       
      if(isset($_POST['btnclicked'])){
        switch($_POST['btnclicked']) {
          case 'btnfind':                 
            break;
          case 'btnAdd':
            // WRA::gotopage(WRA::base_url().$this->curnode->link.'/edit');
            break;                
        }
      }
    }
    function getcount(){
      $result=1;
      $amount = $this->totalcount;
      if (($amount / $this->onpage) > intval($amount / $this->onpage)) {
         $result = intval($amount / $this->onpage) + 1;
      } else {
         $result = intval($amount / $this->onpage);
      }
      return $result;
      // return ($result == 0)?($result+1):($result);
    }
    function addscripts() {
      $this->wf->cp->add_script('scripts/jquery/jquery.js');
      $this->wf->cp->add_script('scripts/jquery-migrate-1.2.1.js');
      $this->wf->cp->add_script('scripts/jquery/jquery-ui.js');
      $this->wf->cp->add_script('scripts/jquery/json.js');
      $this->wf->cp->add_script('scripts/jquery/jquery.cookie.js');
      $this->wf->cp->add_script('scripts/jquery/jquery.treetable.js');
      $this->wf->cp->add_script('scripts/admin/jstorage.js');
      $this->wf->cp->add_script('scripts/admin/jquery.jqgrid.min.js');
      $this->wf->cp->add_script('scripts/jquery/flexigrid.js');
      $this->wf->cp->add_script('scripts/tiny_mce/jquery.tinymce.js');
      $this->wf->cp->add_script('scripts/admin/admin.js');
    }

    function addstyles() {   
      $this->wf->cp->add_style('styles/admin/jquery-ui.css');
      $this->wf->cp->add_style('styles/admin/jquery.treeTable.css');
      $this->wf->cp->add_style('styles/admin/flexigrid.pack.css');
         $this->wf->cp->add_style('styles/admin/ui.jqgrid.css');
      $this->wf->cp->add_style('styles/admin/workflower.css');
    }
    function show(){
        include  WRA_Path.'/template/admin/header.php';
        include  WRA_Path.'/template/admin/image/import.php';
        include  WRA_Path.'/template/admin/footer.php';
    }
}

?>
