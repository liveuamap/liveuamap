<?php defined('WERUA') or include('../bad.php');  
include 'parts/_headercontent.php';

include 'adminscripts.php';?>      

<div class="info history" >
            <? 
                $i=0;
                foreach($this->venues as $k=>$v){?>
    <div class="item"> 
<span class="datac"><?php echo date('j',$v->time);?></span> of <span class="datam"><?WRA::e(date('F',$v->time));?></span> <span class="datag"><?WRA::e(date('Y',$v->time));?>
        <a href="<?WRA::e($v->getlink());?>" title="<?WRA::e($v->name);?>"><?WRA::e($v->name);?></a>
    </div>
               <?
               $i++;
               if($i>500)break;
                }?>
        </div>

<div class="top">
<a href="http://liveuamap.com" class="logo"><img src="<?WRA::e(WRA::base_url());?>images/logo.png" width="76" height="12"></a><a href="#" 
 class="tim"></a><div class="data" id="toptime">
   <span class="all"></span>  <span class="datac"><?php echo date('j',time());?></span> <span class="datam"><?WRA::e(date('F',time()));?></span> <span class="datag"><?WRA::e(date('Y',time()));?></span>
 </div><a href="#" id="topl"></a>
</div>

  
<div id="maplegend">
 <div class="scro" id="boxmsg" style="display: none;height: 100%;">
    <ul>
         <li id="modaltitle" ></li>
       
        <li id="modalbody"></li>
        
    </ul></div>
    <?php if(!wra_userscontext::hasright('adminpage')){?>
    <div class="feed">
        <div class="tweet">
            
            <div class="header">
                EVENTS
            </div>
            <div class="link">
                TWEET US <a href="http://twitter.com/liveuamap" target="_blank">@liveuamap</a>
            </div>
        </div>
    <div class="scro" id="feedler">
  
       
    </div>
    </div> 
        <?php }else{ ?>
    <div class="adminmain" id="mapadd">
 <form method="POST" action="" id="pressFrm">
        <ul>
            <li><label for="source">Source(link)</label><input class="required" type="text" id="txtsource" name="txtsource" placeholder=""/></li>
      <li><label for="pic">Picture</label><input type="text" id="txtpicture" name="txtpicture" placeholder=""/>
      <input type="hidden" id="twitpic" name="twitpic" placeholder=""/>
      <input type="hidden" id="twitauthor" name="twitauthor" placeholder=""/></li>
            <li><label for="lat">Lat</label><input type="text" class="required" id="txtlat" name="txtlat" placeholder=""/></li>
            <li><label for="lng">Lng</label><input type="text" class="required" id="txtlng" name="txtlng" placeholder=""/></li>
            <li><label for="time">Time</label><input type="text" value="<? WRA::e(WRA::formatdatefrtime(time()));?>" id="txttime" name="txttime" placeholder=""/></li>
           
          <?if(false){?>  <li><label for="address">Address</label><input type="text" id="txtaddress" placeholder=""/></li>
            <li><label for="sity">City</label><input type="text" id="txtsity" placeholder=""/></li><?}?>
            <li><label for="ttl">TTL</label>
                <select name="txtttl" id="txtttl">
                      <option value="3600">hour</option>  
                      <option value="21600">six hours</option>  
                      <option value="43200">12 hours</option> 
                      <option value="86400" selected="selected">24 hours</option> 
                      <option value="172800">48 hours</option>
                </select>
             </li>
                 <li><label for="name">Name</label><textarea rows="4" cols="27" id="txtname" name='txtname' placeholder=""></textarea></li>
                 <li><label for="twit">Tweet</label><input type="radio" id="txttweet" name="txttweet" value="1" style="width:40px">now<input type="radio" id="txttweet" name="txttweet" style="width:40px" value="2" checked="checked">queue</li>
       
            <li><label for="des">Descriprion</label><textarea rows="4" cols="27" id="txtdescription" name='txtdescription' placeholder=""></textarea></li>
  
            <li><label for="color">Color</label><select class="required" id="txtcolor_id" name="txtcolor_id">
                    <option selected>Color </option>
                    <option value="1">red(russia)</option>        
                    <option value="2">blue(ukraine & allies)</option>
                    <option value="3">black(undefined)</option>
                </select></li>
            <li><label for="category">Category</label><select class="required" name="txtcat_id"  id="txtcat_id">
                    <option selected>Select one </option>
                     <?php foreach($this->cats as $k=>$v){?>
                    <option value="<? WRA::e($v->id);?>"><? WRA::e($v->title);?></option>
                     <?php }?>
                </select></li>
            <? if(false){?>
          
            <li><label for="link">Link</label><input type="text" id="txtlink1" placeholder=""/></li>
            <?}?>
             </ul>

        <input id="txtlink" name="txtlink" type="submit" value="Send"></form>
    </div><?php }?>

</div>
    <script type="text/javascript">
        var curid=<?php WRA::e($this->cpid);?>;

        
        
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