<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitemwti{
	var $members = array();
	var $lang = 'ru';var $venues=array();var $venue;
    var $user;var $logedin=false;var $lastupdate;var $cats=array();
    var $cpid=0;var $linky=0;var $ll;var $zoom=0;var $time=0;
    function  wfitem($wf){

       
    
    }
    function run(){     parent::run();
           	$this->nofooter = true;
    $this->noheader = true;
         $this->wf->cp->ogimage=WRA::base_url().'images/500.png';
         $adminmark='';
    if(wra_userscontext::hasright('adminpage')){
        $adminmark=time();
    }

    $cache0=new wra_cacheflow('p'.$this->wf->requestedpage.$adminmark,true);
                            
                        if ($cache0->begin()){ 
       if(!empty($this->wf->currouteindex[0]['index'])){
         
           if(count($this->wf->currouteindex)>1){
             
             $this->linky=addslashes($this->wf->currouteindex[0]['index'].'/'.$this->wf->currouteindex[1]['index']);
             $id=  wra_foursqvenues::getidbylink($this->linky);
             if($id){
                 $this->cpid=$id;  
             }
             
           }else{
                 $this->cpid=intval($this->wf->currouteindex[0]['index']);
                 if($this->cpid>wra_foursqvenues::$linknumber){
                     $this->cpid=0;
                 }
           }
       }  
 
     
           $this->wf->cp->ogtitle='Fresh ukrainian news on the map ';
     $this->wf->cp->ogname='Map of war in Ukraine';
     $this->wf->cp->header='Map of Unrest in Ukraine';

     $this->wf->cp->description='Fresh news from Ukraine on the map, event of summer 2014, war between Russia and Ukraine, beginning of Third World War. 2014 pro-Russian conflict in Ukraine ';
          $this->wf->cp->keywords='Ukraine, Russia, Donetsk, war, artillery, war games, provocations, intelligence, USA, Eastern Europe'; 
if($this->cpid!=0){
    $this->venue=new wra_foursqvenues();
    $this->venue->load($this->cpid);
    $this->wf->cp->header=$this->venue->name;
      $this->wf->cp->ogtitle=$this->venue->name;
      $this->wf->cp->pagehead=$this->venue->name;
   
}
if(!empty($_REQUEST['ll'])){
    ini_set('display_errors', 'Off');
    $this->ll=explode(';',$_REQUEST['ll']);
    $this->ll[0]=  floatval($this->ll[0]);
     $this->ll[1]=  floatval($this->ll[1]);
}
if(!empty($_REQUEST['zoom'])){
    $this->zoom=  intval($_REQUEST['zoom']);
}
  
    
        $this->cats=  wra_cats::get_list();
            $this->venues=  wra_foursqvenues::get_l30(time());
           $this->wf->includeheader(); 
             include WRA_Path.'/template/index.php';
            $this->wf->includefooter(); 
                     // $this->lastupdate=  wra_foursqvenues::lastupdate();
             
                        }
                         $cache0->end();
                    // $this->wf->nicedie();
    }
    function show(){
        
        
    }
}

?>
