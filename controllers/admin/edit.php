<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitembase{
    var $curnode;
    var $onpage=50;
    var $curadmin;
    var $currows=array();
    var $rowscount=0;
    var $pagescount=0;var $page=0;
    var $adminnodes=array();
    var $currow=array();    var $noticecount=0;
    function load(wf $wf){
        $this->noticecount=  wra_adminnotices::getcount();
        $this->curadmin->clear();
        if($this->curadmin->multilanguages){                     
            foreach($wf->languages as $v){
                // WRA::debug($v);
                $this->currow[$v->alias]=$this->curadmin->currow('_'.$v->alias);                                
            }
        }else{
            $this->currow[WRA_CONF::$language]=$this->curadmin->currow('');
        }
        // WRA::debug($this->curadmin);
        // WRA::debug($this->currow);
        // die();
    }
    
    function  wfitem($wf){
        if (wra_userscontext::isloged($wf)&&wra_userscontext::hasright('adminpage')) {
            $wf->cp->baseico = true;
            $wf->cp->norobots();
            $wf->cp->bodyclass = "admin_login";            
        }else{
            WRA::gotopage(WRA::base_url().'admin/login');
            $wf->nicedie();
        }
        $this->adminnodes=  WRA_ENV::adminnodes();
        for($i=0;$i<count($this->adminnodes);$i++){
            $r = wra_userscontext::getaccess($this->adminnodes[$i]->link);
            if($wf->requestedpage==$this->adminnodes[$i]->link.'/edit'){
                if (!$r) {
                  $wf->set404();
                  break;
                } 
                $this->curnode=$this->adminnodes[$i];
                $this->curadmin = new wfadmin($this->curnode->link);
                // $this->load();
                break;
            }
            if (!$r) unset($this->adminnodes[$i]);
        }
        if (!empty($_REQUEST["id"])) {
            $this->curadmin->curid = intval($_REQUEST["id"]);
        } else {
            $this->curadmin->curid = -1;
        }
        $this->load($wf);
        if($_REQUEST["act"]=="delete"){
            if($this->curadmin->multilanguages){
                foreach($wf->languages as $v){
                    $this->curadmin->deletefirst('_'.$v->alias);
                }            
            }else{                    
                $this->curadmin->deletefirst('');
            }
            WRA::gotopage(WRA::base_url().$this->curnode->link);
        }
       $this->header=$this->curnode->name;
    }
    function run(){
        $this->nofooter=true;
        $this->noheader=true;
       
        if(isset($_POST['btnclicked'])){
            switch($_POST['btnclicked']) {
                case 'btnfind':                    
                    break;
                case 'btnadd':
                    WRA::gotopage(WRA::base_url().$this->curnode->link.'/edit');
                    break;
                case 'btnSave':
                    if ($this->curadmin->curid == -1) {
                        if($this->curadmin->multilanguages){
                            foreach($this->wf->languages as $v){
                                $this->curadmin->addfirst('_'.$v->alias);                                
                            }
                        }else{                                    
                            $this->curadmin->addfirst('');                                
                        }
                        WRA::gotopage(WRA::base_url().$this->curnode->link);
                    } else {  
                        if($this->curadmin->multilanguages){
                            // WRA::debug($this->wf->languages);
                            foreach($this->wf->languages as $v){
                                // WRA::debug($v->alias);
                                $this->curadmin->updatefirst('_'.$v->alias);                                    
                            }                                
                        }else{                                    
                            $this->curadmin->updatefirst('');                                
                        }
                       $this->load($this->wf);
                    }                  
                    break;                
            }
        }

    }
    function getcount(){
       $result=1;
       $amount = $this->curadmin.getcount();
       if (intval($amount / $this->onpage) > $amount / $this->onpage) {
           $result = intval($amount / $this->onpage) + 1;
       }else{
           $result = intval($amount / $this->onpage);
       }
        return result;
    }
    function addscripts() {
        $this->wf->cp->add_script('scripts/jquery/jquery.js');
        $this->wf->cp->add_script('scripts/jquery/jquery-ui.js');
        $this->wf->cp->add_script('scripts/jquery/jquery.cookie.js');
        $this->wf->cp->add_script('scripts/jquery/jquery.treetable.js');
        $this->wf->cp->add_script('scripts/jquery/flexigrid.js');
        $this->wf->cp->add_script('scripts/admin/jstorage.js');
        $this->wf->cp->add_script('scripts/admin/jquery.jqgrid.min.js');
        $this->wf->cp->add_script('scripts/tiny_mce/jquery.tinymce.js');
        $this->wf->cp->add_script('scripts/jquery/fileuploader.js');
        $this->wf->cp->add_script('scripts/admin/admin.js');
        // $this->wf->cp->add_script('modules/admin/scripts/admin.js');
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
        include  WRA_Path.'/template/admin/edit.php';
        include  WRA_Path.'/template/admin/footer.php';
    }
}

?>
