<?php defined('WERUA') or include('../bad.php');  
include 'parts/_headercontent.php';
?>        <div class="info" style="position: absolute;overflow: hidden;height: 20px;margin-top: -20px">
            <? if(isset($this->venue)){?>
            <h1><?WRA::e($this->venue->name);?></h1>
            <img title="<?WRA::e($this->venue->name);?>" src="<?WRA::e($this->venue->picture);?>"/>
            <?}else{
                
                foreach($this->venues as $k=>$v){?>
                <a href="<?WRA::e($v->getlink());?>" title="<?WRA::e($v->name);?>"><?WRA::e($v->name);?></a>
            
                <?} }?>
                <h2><a href="<?WRA::e(WRA::base_url());?>history" title="History of ukraine conflict">History of ukraine conflict</a></h2>
        </div>
<div id="map_canvas" style="width: 100%; height: 100%">
    
    
</div>
<div class="top">
<a href="http://liveuamap.com" class="logo"><img src="<?WRA::e(WRA::base_url());?>images/logo.png" width="76" height="12"></a><a href="#" 
 class="tim"></a><div class="data" id="toptime">
   <span class="all"></span>  <span class="datac"><?php echo date('j',time());?></span> <span class="datam"><?WRA::e(date('F',time()));?></span> <span class="datag"><?WRA::e(date('Y',time()));?></span>
 </div>

</div>

  <div class="mnu">
<a href="#" id="topl"></a><a href="#" id="list" class="inside"></a><a href="#" id="map"></a><a href="#" id="filter"></a><a href="<?WRA::e(WRA::base_url());?>rss" id="rss"></a><a href="#" id="info"></a>
</div>
<div id="maplegend">
 <div class="scro" id="boxmsg" style="display: none;height: 100%;">
    <ul>
         <li id="modaltitle" ></li>
       
        <li id="modalbody"></li>
        
    </ul></div>

    
    <div class="feed">
        <div class="tweet">
            
            <div class="header">
                EVENTS <a href="#" style="display: none" id="showmap">MAP</a>
            </div>
            <div class="link">
                TWEET US <a href="http://twitter.com/liveuamap" target="_blank">@liveuamap</a>
            </div>
        </div>
            <div id="infobox" style="display: none;height: 100%;">
                <p>Liveuamap.com is nonprofit, volunteer-run project of civic journalism. Our mission is to tell about
                crisis in Ukraine all over the world. We gather information from open sources and put it on the map in format of Reds-vs-Blues conflict.</p>
                <p>
                    If you want to share our mission, or have any question, just mail to info@liveuamap.com or ask in Twitter @liveuamap
                </p>
                <p>
                    To support liveuamap.com you can donate bitcoins to <a style="font-size: 13px;" href="https://blockchain.info/address/1EjYq48gmWN8mRxLtg6bZYyNT5xqZHonAd" target="_blank" rel="nofollow">1EjYq48gmWN8mRxLtg6bZYyNT5xqZHonAd</a>
                    
                </p>
                <p>
                    Or
                    
                    <select id="txtamount" name="txtamount">
                        <option value="1">$1</option>
                        <option value="5" selected="selected">$5</option>
                        <option value="10">$10</option>
                        <option value="100">$100</option>
                    </select>
                    <a href="#" id="goliqpay">from card</a>
                    <div class="footer__logo"></div>
                </p>

    </div>
    <div id="filterbox" style="display: none;height: 100%;">
        
        <div class="group">Time filter</div>
        <div class="group">Type filter</div>
        <div class="group">Custom filter</div>
        <a href="#" id="defaultfilter">Set Default</a>
    </div>
   
        <div class="scro" id="feedler"  >
  
       
    </div>
    </div> 
       
  

</div>
    <script type="text/javascript">
        var curid=<?php WRA::e($this->cpid);?>;
        <?php if($this->cpid>0){?>
             globaltime=<? WRA::e( $this->venue->time-43100);?>;first=true;
        <?}?>
        
        
        </script>
<div class="boxselect">
    <div class="txt">Select date</div>
       <div class="bb">
        <select name="datam" id="datam">
            <?php for($i=5;$i<=12;$i++){?>
<option <? if(date('F',($i-1)*2592000+1389484800)==date('F',time())){?>selected="selected"<?}?> value="<?php WRA::e($i);?>"><?WRA::e(date('F',($i-1)*2592000+1389484800));?></option>   
            <?php }?>

</select>
    </div>
    <div class="bb">
    <select name="datac">
<?php if(false){?><option selected>All day</option><?php }?>
<?php for($i=1;$i<=31;$i++){?>
<option <?if($i==date('j',time())) {?>selected="selected"<?}?> value="<?php
if($i<10)WRA::e($i);else
WRA::e($i);?>"><?php WRA::e($i);?></option>     <?php }?>
<?php if(false){?>
<option value="t2">22 </option>
<option value="t3">23</option>
<option value="t4">24</option> <?php }?>
</select>
        </div>
 
    <?php if(false){?>
      <div class="bb">
        <select name=datag>
<option selected>All year </option>
<option value=t1>2014 </option> 
<option value=t1>2013 </option>        
<option value=t2>2012 </option>
<option value=t3>2011 </option>
<option value=t4>2010</option>
</select>
    </div><?}?>
    <a href="#" class="ok" id="loadmore">ok</a>
</div>

<?php  include 'parts/_footercontent.php'; ?>