<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitemwti{
	var $members = array();
	var $lang = 'ru';var $venues=array();var $venue;
    var $user;var $logedin=false;var $lastupdate;var $cats=array();
    var $cpid=0; var $list=array();
    function  wfitem($wf){

    }
    function run(){
      parent::run();
      
    }
   
     

    function query($request){
      $wd = new wra_db();
       $ip=WRA::getip();
       $time=time();
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "requests` (
             `request`,
             `ip`,
             `time`
             )VALUES(
             '$request',
             '$ip',
             '$time'
             )";
        $wd->execute();
 $id = $wd->getlastkey();
        $wd->close();
             
        // $this->currentobjid = wra_objects::addnewobject('wra_fbu', $this->id, $this->objectadres);
        unset($wd);
        return $id;
}
    
      function show(){
          if(isset($_GET['sum'])){
          $id=$this->query('liqpay');
                    $liqpay=new wra_liqpay();
                    $liqpay->result_url=WRA_CONF::$wwwpath.'';
                    $liqpay->server_url=WRA_CONF::$wwwpath.'';
                    $liqpay->order_id='RB-'.$id;
                    $liqpay->amount=round(intval($_GET['sum']),2);
                    if($liqpay->amount>=1){
                    $liqpay->currency='USD';
                    $liqpay->description='Payment '.'Liveuamap-'.$id;
                    $liqpay->phone='';
                     $liqpay->pay_way='card';
                     $liqpay->goods_id=$id;
                     $liqpay->dateadd=time();
                     $liqpay->ipadd=WRA::getip();
                     $liqpay->cartid=$result->id;
                     $liqpay->statusid=0;
                     $liqpay->exp_time=24;
                     $liqpay->pays_count=0;
                     $liqpay->add();
          $liqpay->flushform();}}else{
              
          }
    }

}

?>
