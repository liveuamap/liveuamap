<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitembase{
    var $enter_try=0;
    var $cap;
    function  wfitem($wf){

      
    }
    function show(){
        
    }
    function run(){

        wra_userscontext::logout();
        WRA::gotopage('../admin/login');
        $this->wf->nicedie();
    }

}

?>
