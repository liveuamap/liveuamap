<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitemwti{
	var $members = array();
	var $lang = 'ru';var $venues=array();var $venue;
    var $user;var $logedin=false;var $lastupdate;var $cats=array();
    var $cpid=0;var $linky=0;var $ll;var $zoom=0;
    function  wfitem($wf){

       
       $wf->cp->ogimage=WRA::base_url().'images/500.png';
 
   
     
    }
    function run(){
        
      parent::run();
           if (wra_userscontext::isloged($this->wf)||wra_u::islogin()) {
      
        WRA::gotopage(WRA::base_url());
       return;
    } 
           $this->wf->cp->ogtitle='Fresh ukrainian news on the map ';
     $this->wf->cp->ogname='Map of war in Ukraine';
     $this->wf->cp->header='Map of Unrest in Ukraine';

     $this->wf->cp->description='Fresh news from Ukraine on the map, event of summer 2014, war between Russia and Ukraine, beginning of Third World War. 2014 pro-Russian conflict in Ukraine ';
          $this->wf->cp->keywords='Ukraine, Russia, Donetsk, war, artillery, war games, provocations, intelligence, USA, Eastern Europe'; 

        
                     
                     // $this->lastupdate=  wra_foursqvenues::lastupdate();
    }
   
    
    function show(){
           include WRA_Path.'/template/login.php';
        include WRA_Path.'/template/index.php';
    }
}

?>
