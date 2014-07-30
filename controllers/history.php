<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitemwti{
	var $members = array();
	var $lang = 'ru';var $venues=array();var $venue;
    var $user;var $logedin=false;var $lastupdate;var $cats=array();
    var $cpid=0;var $ll;var $zoom=0;
    function  wfitem($wf){

       $wf->cp->ogimage=WRA::base_url().'images/500.png';
 
   
       if(!empty($wf->currouteindex[0]['index'])){
           $this->cpid=intval($wf->currouteindex[0]['index']);
       }
    }
    function run(){
            
      parent::run();
           $this->wf->cp->ogtitle='History of war in Ukraine ';
     $this->wf->cp->ogname='History map of war in Ukraine';
     $this->wf->cp->header='Map of Unrest in Ukraine';
          $this->wf->cp->bodyclass='longpage';
     $this->wf->cp->description='History of Ukraine on the map, event of summer 2014, war between Russia and Ukraine, beginning of Third World War. 2014 pro-Russian conflict in Ukraine ';
          $this->wf->cp->keywords='Ukraine, Russia, Donetsk, war, artillery, war games, provocations, intelligence, USA, Eastern Europe'; 

        
                         
                     // $this->lastupdate=  wra_foursqvenues::lastupdate();
    }
function show(){
        $cache0=new wra_cacheflow('history',true);
                            
                        if ($cache0->begin()) {
    $this->venues=  wra_foursqvenues::get_listall(time());
                
             include WRA_Path.'/template/history.php';
                }   $cache0->end();
             
     
}
}

?>
