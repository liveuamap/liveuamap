<?php

defined('WERUA') or include('../bad.php');

class wfitem extends wfitemwti {


    function wfitem(wf $wf) {
        $this->header='Выйти';
        if (wra_userscontext::isloged()) {
            @wra_userscontext::logout();
            @wra_fbu::clearfbid();
            @wra_vku::clearvkid();
            if (!empty($_SERVER['HTTP_REFERER'])){
                    WRA::gotopage($_SERVER['HTTP_REFERER']);
                } else {
                    // WRA::gotopage(WRA::base_url().'me');
                    WRA::gotopage(WRA::base_url());
                }
            $wf->nicedie();
        }        
    }

    
    function run() {
        WRA::gotopage(WRA::base_url());
        // $this->wf->closedb();
        // $this->wf->nicedie();
    }

    function show() {
        
    }

}

?>
