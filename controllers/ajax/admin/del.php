<?php

defined('WERUA') or include('../bad.php');

class wfitem extends wfitembase {

    function wfitem() {
        $this->dont=true;
        
    }
    function run(){
        $act = @$_REQUEST['act'];
        $id = addslashes(@$_REQUEST['id']);
        // echo($id);
        switch ($act) {
            default:

                $savepc = new wra_image();
                // $languages=wra_lang::getlist();
                // foreach($languages as $l0){
                $savepc->id = intval($id);
                // print_r($savepc);
                $savepc->delete();
                // }
            
            echo '{"success":true}';          
            // echo '{"success":true,"imgid":"'.$savepc->id.'","tmb":"'.$savepc->tmbpic.'"}'; die();              
            break;         
        }
    }

    function show() {
        
    }

}

?>