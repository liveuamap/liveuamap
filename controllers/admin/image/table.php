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
      if(isset($_POST['btnclicked'])){
        switch($_POST['btnclicked']) {
          case 'btnfind':
            $this->curadmin->search=addslashes($_REQUEST['txtfind']);
            break;            
        }
      }
      if(isset($_GET['page'])){
        $this->page=intval($_GET['page']);
      }
      if(!$this->curadmin->multilanguages){
        $this->currows = $this->curadmin->getrows('',$this->page+1, $this->onpage);
        $this->totalcount=$this->curadmin->getcount();
      } else{
        $this->currows = $this->curadmin->getrows('_'.WRA_CONF::$language,$this->page+1, $this->onpage);
        $this->totalcount=$this->curadmin->getcount('_'.WRA_CONF::$language);
      }
      $this->pagescount=$this->getcount();
      // WRA::debug($this->pagescount);
      // WRA::debug($this->totalcount);
    }

    function run(){
      $this->nofooter=true;
      $this->noheader=true;       
      if(isset($_POST['btnclicked'])){
        switch($_POST['btnclicked']) {
          case 'btnfind':                 
            break;
          case 'btnAdd':
            WRA::gotopage(WRA::base_url().$this->curnode->link.'/edit');
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
        include  WRA_Path.'/template/admin/image/table.php';
        include  WRA_Path.'/template/admin/footer.php';
    }
}

?>
