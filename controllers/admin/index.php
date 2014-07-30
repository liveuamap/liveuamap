<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitembase{
    var $enter_try=0;
    var $cap;var $useleftmenu;var $inner_content_text;var $useadd_button=true;
    var $cp;var $editlink_withoutid; var $currentlink;
    
    var $adminnodes=array();
    var $noticecount=0;
    function  wfitem($wf){
        //include  WRA_Path. '/modules/admin/admintable.php';
        //include WRA_Path.'/modules/admin/adminpages.php'; 
        $this->header='Администрирование';
        $this->adminnodes=  WRA_ENV::adminnodes();
        $this->noticecount=  wra_adminnotices::getcount();
        if (wra_userscontext::isloged($wf)&&wra_userscontext::hasright('adminpage')) {
                $wf->cp->baseico = true;
                $wf->cp->norobots();
                $wf->cp->bodyclass = "admin_login";
            
        }else{
            WRA::gotopage(WRA::base_url().'admin/login');
            $wf->nicedie();
        }
       // wra_adminnotices:: message('hello','hello');
    }
    function run(){
        $this->nofooter=true;
        $this->noheader=true;       
        if(isset($_REQUEST['clearcache'])){    
            wra_cacheflow::clearcache();
        }
        if(isset($_POST['btnclicked'])){
            switch($_POST['btnclicked'])
            {
               case 'btnsave':
                wra_options::$options['phone'] =  wra_admintable::getpost('phone');
                wra_options::$options['email'] =  wra_admintable::getpost('email');
                wra_options::$options['fb'] =  wra_admintable::getpost('fb');
                wra_options::$options['vk'] =  wra_admintable::getpost('vk');
                wra_options::$options['insta'] =  wra_admintable::getpost('insta');
                wra_options::$options['lj'] =  wra_admintable::getpost('lj');
                wra_options::$options['blogger'] =  wra_admintable::getpost('blogger');
                wra_options::$options['flickr'] =  wra_admintable::getpost('flickr');
                wra_options::saveoptions();
                $this->wf->options = wra_options::loadoptions();
                break;                
            }
        }
        /*
        if (WRA::ir('mod')) {
            $this->cap->adminedit = @WRA::r('mod');
            $this->currentlink='?mod='. $this->cap->adminedit;
            if(strpos($this->cap->adminedit,'edit')){            
                $this->cap->isedit=true;  
                $this->cap->mod = str_replace("edit","", $this->cap->adminedit);

            }else{
                
           
                $this->cap->mod =  $this->cap->adminedit;
            }
            
            switch ($this->cap->mod) {
                default :
                    if (wra_adminmenu::isexist($this->cap->mod)) {
                        $this->editlink_withoutid = '?mod='.$this->cap->mod;
                         $this->cap->getcurmenu();
                        if (WRA::ir('id'))
                            $this->currentlink .= '&id=' . WRA::r('id');

                        if (WRA::ir('pid')) {
                            $this->currentlink .= '&pid=' . WRA::r('pid');
                            $this->editlink_withoutid .= '&pid=' . WRA::r('pid');
                        }
                        if (WRA::ir('type')) {
                            $this->currentlink .= '&type=' . WRA::r('type');
                            $this->editlink_withoutid .= '&type=' . WRA::r('type');
                        }
                       if ($this->cap->usenames) {

                            $this->cap->getnames();
                        }
                        if(!$this->cap->isedit)
                        include WRA_Path. '/modules/admin/forms/list.php';
                        else
                        include WRA_Path. '/modules/admin/forms/edit.php';
                        
                        $this->cap->doedit($this->wf);
                    } else {
                        include WRA_Path. '/modules/admin/parts/default.php';
                    }
                    break;
            }
        } else {
            $this->useleftmenu = - 1;
            //echo 'hi'; print_r($_SESSION);
           // die(session_id());
         
            include WRA_Path. '/modules/admin/parts/main.php';
        }*/

    }
    function addscripts() {
        $this->wf->cp->add_script('scripts/jquery/jquery.js');
          $this->wf->cp->add_script('scripts/jquery-migrate-1.2.1.js');
        $this->wf->cp->add_script('scripts/jquery/jquery-ui.js');
        $this->wf->cp->add_script('scripts/jquery/jquery.cookie.js');
        $this->wf->cp->add_script('scripts/jquery/json.js');
        $this->wf->cp->add_script('scripts/jquery/jquery.treetable.js');
        $this->wf->cp->add_script('scripts/jquery/flexigrid.js');
             $this->wf->cp->add_script('scripts/admin/jstorage.js');
         $this->wf->cp->add_script('scripts/admin/jquery.jqgrid.min.js');
        $this->wf->cp->add_script('scripts/tiny_mce/jquery.tinymce.js');
        $this->wf->cp->add_script('scripts/admin/admin.js');
    }

    function addstyles() {
        //$//this->wf->cp->add_style( 'styles/nk.css' );
        $this->wf->cp->add_style('styles/admin/jquery-ui.css');
        $this->wf->cp->add_style('styles/admin/jquery.treeTable.css');
        $this->wf->cp->add_style('styles/admin/flexigrid.pack.css');
           $this->wf->cp->add_style('styles/admin/ui.jqgrid.css');
        $this->wf->cp->add_style('styles/admin/workflower.css');
    }
    function show(){
        include  WRA_Path.'/template/admin/header.php';
        include  WRA_Path.'/template/admin/index.php';
        include  WRA_Path.'/template/admin/footer.php';
    }
}

?>
