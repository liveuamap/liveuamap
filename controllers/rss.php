<?php
defined('WERUA') or include('../bad.php');

class wfitem extends wfitemwti {
 var $items=array();
  function wfitem($wf) {
    header("Content-Type: application/xml; charset=UTF-8");
  }

  function run() {
    parent::run();
    $this->nofooter=true;
    $this->noheader=true;
 
                      

  }
function save_image($inPath,$outPath)
{ //Download images from remote server
    $in=    fopen($inPath, "rb");
    $out=   fopen($outPath, "wb");
    while ($chunk = fread($in,8192))
    {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}

    function show() {
             $cache0=new wra_cacheflow('rss',true);
                            
                        if ($cache0->begin()) {
                            
  $this->items=  wra_foursqvenues::get_list(0,time(),250);
 $this->items=  array_reverse( $this->items);
                  if(count($this->items)<30){
                                $enues=  wra_foursqvenues::get_l30(intval(time()));
                                $before=time();
                                if(count($this->items)>0){
                                    $before=$this->items[count($this->items)-1]->time;
                                }
                                for($i=0;$i<30-count($this->items);$i++){
                                    if($enues[$i]->time<$before){
                                        $this->items[]=$enues[$i];
                                    }
                                }
                            }   
     WRA::e('<?'); ?>xml version="1.0" encoding="UTF-8"<? WRA::e('?>'); ?>
<rss version="2.0">
  <channel>
    <title>Liveuamap.com</title>
    <link>http://liveuamap.com/</link>
    <description>Fresh news from Ukraine on the map, event of summer 2014, war between Russia and Ukraine, beginning of Third World War. 2014 pro-Russian conflict in Ukraine </description>
    <language>en-us</language>
    <pubDate><?php WRA::e( date('D, d M Y g:i:s O', time()));?></pubDate>
 
    <lastBuildDate><?php WRA::e( date('D, d M Y g:i:s O', time()));?></lastBuildDate>
    <docs>http://liveuamap.com/rss</docs>
    <generator>Liveuamap Feed</generator>
    <managingEditor>info@liveuamap.com</managingEditor>
    <webMaster>info@liveuamap.com</webMaster>
<?php foreach($this->items as $a0){ ?>
  <item>
      <title><?php WRA::e(htmlspecialchars($a0->name));?></title>
      <link><?php WRA::e($a0->getlink()); ?></link>
      <description><?php WRA::e(htmlspecialchars($a0->name));?></description>
      <pubDate><?php WRA::e( date('D, d M Y g:i:s O', $a0->time));?></pubDate>
      <guid><?php WRA::e($a0->getlink()); ?></guid>
      <?php if(!empty($a0->picture)){
          $ext = str_replace(':large','',pathinfo($a0->picture, PATHINFO_EXTENSION));
          $link='http://liveuamap.com/uploads/'.$a0->id.'.'.$ext;
          if(!file_exists(WRA_Path.'/uploads/'.$a0->id.'.'.$ext)){
              $this->save_image($a0->picture, WRA_Path.'/uploads/'.$a0->id.'.'.$ext);
          }
          ?>
  <image>
<url><?php WRA::e($link);?></url>
  <link><?php WRA::e($a0->getlink()); ?></link>
      </image><?php }?>
  </item>
<?php } ?>
  
  </channel></rss><?
    
    }   $cache0->end();
}}
    ?>
