<?php defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitembase{
	var $soc_type; var $user;
   	var $peoples=array();
   	var $act;
   	var $return;var $fieldsarrow=array();
   	var $noheader = true;
   	var $nofooter = true;
        
        var $venues=array();        var $cats=array();
    function  wfitem(){    
    }
    function time_since($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'minute'),
        array(1 , 'second')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
}
function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] 'ago' ";
}
function _ago($tm,$rcs = 0) {
   $cur_tm = time(); $dif = $cur_tm-$tm;
   $pds = array('second','minute','hour','day','week','month','year','decade');
   $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
   for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

   $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
   if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
   return $x;
}
    function humanTiming ($time)
{
    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
    }

}
    function timeAgo($timestamp){
    $datetime1=date_create(time());
    $datetime2=date_create($timestamp);
    $diff=date_diff($datetime1, $datetime2);
    $timemsg='';
    if($diff->y > 0){
        $timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');

    }
    else if($diff->m > 0){
     $timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
    }
    else if($diff->d > 0){
     $timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
    }
    else if($diff->h > 0){
     $timemsg = $diff->h .' hour'.($diff->h > 1 ? "'s":'');
    }
    else if($diff->i > 0){
     $timemsg = $diff->i .' minute'. ($diff->i > 1?"'s":'');
    }
    else if($diff->s > 0){
     $timemsg = $diff->s .' second'. ($diff->s > 1?"'s":'');
    }

$timemsg = $timemsg.' ago';
return $timemsg;
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

        $wd->close();
        // $this->currentobjid = wra_objects::addnewobject('wra_fbu', $this->id, $this->objectadres);
        unset($wd);
}
    function run(){
    	$this->nofooter = true;
    	$this->noheader = true;
		$this->act = $_REQUEST['act'];
		$this->return = array();
              //  $this->query(addslashes($_SERVER['QUERY_STRING']));
         
		switch ($this->act) {
       
                 
                        case 'pts':
                           $time=intval($_GET['time']);
                            $curid=intval($_GET['curid']);
                            $last=intval($_GET['last']);  
                            if($last==0&&time()-9600<$time){
                               $time=time();
                            
                            }
                            $cache0=new wra_cacheflow('p'.$last.intval($time/50000),true);
                            
                        if ($cache0->begin()) {
                            if(intval($_REQUEST['last'])==0){
                                $this->venues=  wra_foursqvenues::get_list(intval($_GET['curid']),intval($time),250);
                          $this->fieldsarrow=  wra_foursqvenues::get_listfields(intval($_GET['curid']),intval($time),250);

                          
                          if(count($this->venues)<30){
                                $enues=  wra_foursqvenues::get_l30(intval($time));
                                $before=time();
                                if(count($this->venues)>0){
                                    $before=$this->venues[count($this->venues)-1]->time;
                                }
                                for($i=0;$i<30-count($this->venues);$i++){
                                    if($enues[$i]->time<$before){
                                        $this->venues[]=$enues[$i];
                                    }
                                }
                            }
                                }else{
                                $this->venues=  wra_foursqvenues::get_listlast(intval($_REQUEST['last']));
                        
                       }
                                  
                          
                             $this->cats=  wra_cats::get_list();
                             foreach($this->venues as $k=>$v){
                                   $this->venues[$k]->name= htmlspecialchars(  $this->venues[$k]->name);
                                  $this->venues[$k]->cat=$this->cats[$v->cat_id];
                               //   if(time()-$v->time>86400)
                                 // $this->venues[$k]->time=date('d.m.Y H:i',$v->time);
                                 // else
                                  if(time()-$v->time<60) $this->venues[$k]->time='just now'; else
                                      $this->venues[$k]->time=$this->humanTiming ($v->time);
                                   $this->venues[$k]->sf='';
                                   if($this->venues[$k]->id>wra_foursqvenues::$linknumber){
                                        $this->venues[$k]->target= $this->venues[$k]->link;
                                   }
                                    $this->venues[$k]->link='';
                                       $this->venues[$k]->sel_link='';
                             }
                              $this->return['last']=$_REQUEST['last'];
                                $this->return['venues']=$this->venues;
                                 $this->return['fields']=$this->fieldsarrow;
                                   $this->return['cats']=$this->cats;
                                $this->return['datac']=date('d',intval($_GET['time'])+6400);
                                 $this->return['datam']=date('F',intval($_GET['time'])+6400);
                                  $this->return['datay']=date('Y',intval($_GET['time'])+6400);
                                  $this->return['amount']=count($this->venues);
                                  WRA::e(json_encode($this->return, JSON_NUMERIC_CHECK));  
                                  }
                          $cache0->end(false);  
                          /*
                           if($curid==0)
                        else{
                       $this->return= json_decode( $cache0->end(true));
                          $this->venue=new wra_foursqvenues();
                         $this->venue->load($curid);
                         
                         WRA::e(json_encode($this->return, JSON_NUMERIC_CHECK));  
                     
                        }*/
                        $this->wf->nicedie();
                            break;
		
			default:
				$this->return = array("err" => 1, "text"=> "No action");
			break;
		}
    }

    function show() {
		WRA::e(json_encode($this->return, JSON_NUMERIC_CHECK));            
    }
   
}

?>
