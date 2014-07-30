<?php defined('WERUA') or include('../bad.php'); 

class wfitemwti extends wfitembase{
    
    var $cartitems=array();
    var $contacts=array();
    var $langu;
    // var $lang = 'uk';
    var $menu = array();
    function run(){
        // $this->contacts=  wra_contacts::getfulllist();
        // WRA::debug($this->wf->cp);die();
        $this->lang = "_".$this->wf->cp->language;
        // $this->cartitems=  wra_carts::getcartitems();
        // $this->menu = wra_menu::get_list($this->lang);
    }
    
}
?>