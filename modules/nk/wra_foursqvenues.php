<?php defined('WERUA') or include('../../bad.php');
class wra_foursqvenues extends wfbaseclass{


 var $id;
 var $time;
 var $name;
 var $address;
 var $city;
 var $ttl;
 var $source;
 var $lat;
 var $lng;
 var $color_id;
 var $cat_id;
 var $picture;var $target='';
 var $link;
 var $description;
 var $status;
 var $updated;
  var $resource;
 var $points;
 var $type_id;
 var $strokeweight;
 var $strokeopacity;
 var $strokecolor;
 var $symbolpath;
 var $fillcolor;
 var $fillopacity;
 var $twitpic;
 var $user_added;
 var $tts;
 var $status_id;
 var $killed=0;
 var $injured=0;
 public static $linknumber=21188090;
 function wra_foursqvenues ()
{
}
function getlink(){
    if($this->id<=wra_foursqvenues::$linknumber){
            return WRA::base_url().'e/'.$this->id;
   
    }else{
           return WRA::base_url().'e/'.$this->link;
    }
}
static function adminit($wfadmin) {
$wfadmin->table = 'foursqvenues';
$wfadmin->multilanguages = false;
//$wfadmin->columns[] = new admincolumn("String", "id", "id", admincolumntype::text, admincolumntype::text, 1);
$wfadmin->columns[] = new admincolumn("String", "time", "time", admincolumntype::text, admincolumntype::text, 2);
$wfadmin->columns[] = new admincolumn("String", "name", "name", admincolumntype::text, admincolumntype::text, 3);
$wfadmin->columns[] = new admincolumn("String", "address", "address", admincolumntype::text, admincolumntype::text, 4);
$wfadmin->columns[] = new admincolumn("String", "city", "city", admincolumntype::none, admincolumntype::text, 5);
$wfadmin->columns[] = new admincolumn("String", "ttl", "ttl", admincolumntype::none, admincolumntype::text, 6);
$wfadmin->columns[] = new admincolumn("String", "source", "source", admincolumntype::none, admincolumntype::text, 7);
$wfadmin->columns[] = new admincolumn("String", "lat", "lat", admincolumntype::none, admincolumntype::text, 8);
$wfadmin->columns[] = new admincolumn("String", "lng", "lng", admincolumntype::none, admincolumntype::text, 9);
$wfadmin->columns[] = new admincolumn("String", "color_id", "color_id", admincolumntype::none, admincolumntype::dropdown,11, array('1'=>'ukr','2'=>'ru'));
$wfadmin->columns[] = new admincolumn("String", "cat_id", "cat_id", admincolumntype::none, admincolumntype::dropdown, 11,  wra_cats::getdrop());
$wfadmin->columns[] = new admincolumn("String", "picture", "picture", admincolumntype::none, admincolumntype::text, 12);
$wfadmin->columns[] = new admincolumn("String", "link", "link", admincolumntype::none, admincolumntype::text, 13);
$wfadmin->columns[] = new admincolumn("String", "description", "description", admincolumntype::none, admincolumntype::text, 14);
$wfadmin->columns[] = new admincolumn("String", "status", "status", admincolumntype::none, admincolumntype::text, 15);
$wfadmin->columns[] = new admincolumn("String", "updated", "updated", admincolumntype::none, admincolumntype::text, 16);
$wfadmin->columns[] = new admincolumn("String", "resource", "resource", admincolumntype::none, admincolumntype::text, 17);
$wfadmin->columns[] = new admincolumn("String", "points", "points", admincolumntype::none, admincolumntype::bigtext, 18);
$wfadmin->columns[] = new admincolumn("String", "type_id", "type_id", admincolumntype::none, admincolumntype::text, 19);
$wfadmin->columns[] = new admincolumn("String", "strokeweight", "strokeweight", admincolumntype::none, admincolumntype::text, 20);
$wfadmin->columns[] = new admincolumn("String", "strokeopacity", "strokeopacity", admincolumntype::none, admincolumntype::text, 21);
$wfadmin->columns[] = new admincolumn("String", "strokecolor", "strokecolor", admincolumntype::none, admincolumntype::text, 22);
$wfadmin->columns[] = new admincolumn("String", "symbolpath", "symbolpath", admincolumntype::none, admincolumntype::text, 23);
$wfadmin->columns[] = new admincolumn("String", "fillcolor", "fillcolor", admincolumntype::none, admincolumntype::text, 24);
$wfadmin->columns[] = new admincolumn("String", "fillopacity", "fillopacity", admincolumntype::none, admincolumntype::text, 25);
$wfadmin->columns[] = new admincolumn("String", "twitpic", "twitpic", admincolumntype::none, admincolumntype::text, 26);
$wfadmin->columns[] = new admincolumn("String", "user_added", "user_added", admincolumntype::none, admincolumntype::text, 27);
$wfadmin->columns[] = new admincolumn("String", "tts", "tts", admincolumntype::none, admincolumntype::text, 28);
$wfadmin->columns[] = new admincolumn("String", "status_id", "status_id", admincolumntype::none, admincolumntype::text, 29);
$wfadmin->order = " order by id desc";
}

static function getcount($category)
{
$result=0;
$wd=new wra_db();

$wd->query = 'SELECT count(`id`)
 FROM `'.WRA_CONF::$db_prefix.'wra_foursqvenues`';
$wd->executereader();
while($u0=$wd->read()){

$result=$u0[0];
}
$wd->close();
return $result;
}
static function get_listall()
{
$result=array();
$wd=new wra_db();

$wd->query = 'SELECT 
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,
 `updated`
 `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`

 FROM `'.WRA_CONF::$db_prefix."foursqvenues` 
where type_id=1
         order by time desc";
$wd->executereader();
while($u0=$wd->read()){
$r0=new wra_foursqvenues();
$r0->id = $u0[0];

$r0->time = $u0[1];

$r0->name = $u0[2];

$r0->address = $u0[3];

$r0->city = $u0[4];

$r0->ttl = $u0[5];

$r0->source = $u0[6];

$r0->lat = $u0[7];

$r0->lng = $u0[8];

$r0->color_id = $u0[9];

$r0->cat_id = $u0[10];

$r0->picture = $u0[11];

$r0->link = $u0[12];

$r0->description = $u0[13];

$r0->status = $u0[14];

$r0->updated = $u0[15];
$r0->resource = $u0[16];

$r0->points = $u0[17];

$r0->type_id = $u0[18];

$r0->strokeweight = $u0[19];

$r0->strokeopacity = $u0[20];

$r0->strokecolor = $u0[21];

$r0->symbolpath = $u0[22];

$r0->fillcolor = $u0[23];

$r0->fillopacity = $u0[24];

$r0->twitpic = $u0[25];

$r0->user_added = $u0[26];

$r0->tts = $u0[27];

$r0->status_id = $u0[28];



$result[]=$r0;
}
$wd->close();
return $result;
}
static function get_list($id,$time,$count=10,$page=0)
{
$result=array();
$wd=new wra_db();

$wd->query = 'SELECT 
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,
 `updated`,
  `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`
 FROM `'.WRA_CONF::$db_prefix."foursqvenues` 
     where type_id=1 and (time+ttl>".$time." and time<".$time."+86400  or id='$id')
         order by time desc
 LIMIT ".$page*$count.",".$count."";
$wd->executereader();
while($u0=$wd->read()){
$r0=new wra_foursqvenues();
$r0->id = $u0[0];

$r0->time = $u0[1];

$r0->name = $u0[2];

$r0->address = $u0[3];

$r0->city = $u0[4];

$r0->ttl = $u0[5];

$r0->source = $u0[6];

$r0->lat = $u0[7];

$r0->lng = $u0[8];

$r0->color_id = $u0[9];

$r0->cat_id = $u0[10];

$r0->picture = $u0[11];

$r0->link = $u0[12];

$r0->description = $u0[13];

$r0->status = $u0[14];

$r0->updated = $u0[15];
$r0->resource = $u0[16];

$r0->points = $u0[17];

$r0->type_id = $u0[18];

$r0->strokeweight = $u0[19];

$r0->strokeopacity = $u0[20];

$r0->strokecolor = $u0[21];

$r0->symbolpath = $u0[22];

$r0->fillcolor = $u0[23];

$r0->fillopacity = $u0[24];

$r0->twitpic = $u0[25];

$r0->user_added = $u0[26];

$r0->tts = $u0[27];

$r0->status_id = $u0[28];



$result[]=$r0;
}
$wd->close();
$result=  array_reverse($result);
return $result;
}
static function get_listlast($id,$count=10,$page=0)
{
$result=array();
$wd=new wra_db();

$wd->query = 'SELECT 
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,
 `updated`,
  `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`
 FROM `'.WRA_CONF::$db_prefix."foursqvenues` 
     where type_id=1 and id>'$id'
         order by time desc
 LIMIT ".$page*$count.",".$count."";
$wd->executereader();
while($u0=$wd->read()){
$r0=new wra_foursqvenues();
$r0->id = $u0[0];

$r0->time = $u0[1];

$r0->name = $u0[2];

$r0->address = $u0[3];

$r0->city = $u0[4];

$r0->ttl = $u0[5];

$r0->source = $u0[6];

$r0->lat = $u0[7];

$r0->lng = $u0[8];

$r0->color_id = $u0[9];

$r0->cat_id = $u0[10];

$r0->picture = $u0[11];

$r0->link = $u0[12];

$r0->description = $u0[13];

$r0->status = $u0[14];

$r0->updated = $u0[15];
$r0->resource = $u0[16];

$r0->points = $u0[17];

$r0->type_id = $u0[18];

$r0->strokeweight = $u0[19];

$r0->strokeopacity = $u0[20];

$r0->strokecolor = $u0[21];

$r0->symbolpath = $u0[22];

$r0->fillcolor = $u0[23];

$r0->fillopacity = $u0[24];

$r0->twitpic = $u0[25];

$r0->user_added = $u0[26];

$r0->tts = $u0[27];

$r0->status_id = $u0[28];



$result[]=$r0;
}
$wd->close();
$result=  array_reverse($result);
return $result;
}
static function get_listfields($id,$time,$count=10,$page=0)
{
$result=array();
$wd=new wra_db();

$wd->query = 'SELECT 
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,
 `updated`,
  `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`
 FROM `'.WRA_CONF::$db_prefix."foursqvenues` 
     where (type_id=3 or type_id=4 or type_id=5)  and (time<".$time." and time+ttl>".$time.")
         order by time desc
 LIMIT ".$page*$count.",".$count."";

$wd->executereader();
while($u0=$wd->read()){
$r0=new wra_foursqvenues();
$r0->id = $u0[0];

$r0->time = $u0[1];

$r0->name = $u0[2];

$r0->address = $u0[3];

$r0->city = $u0[4];

$r0->ttl = $u0[5];

$r0->source = $u0[6];

$r0->lat = $u0[7];

$r0->lng = $u0[8];

$r0->color_id = $u0[9];

$r0->cat_id = $u0[10];

$r0->picture = $u0[11];

$r0->link = $u0[12];

$r0->description = $u0[13];

$r0->status = $u0[14];

$r0->updated = $u0[15];
$r0->resource = $u0[16];

$r0->points =  json_decode(stripslashes($u0[17]));

$r0->type_id = $u0[18];

$r0->strokeweight = $u0[19];

$r0->strokeopacity = $u0[20];

$r0->strokecolor = $u0[21];

$r0->symbolpath = $u0[22];

$r0->fillcolor = $u0[23];

$r0->fillopacity = $u0[24];

$r0->twitpic = $u0[25];

$r0->user_added = $u0[26];

$r0->tts = $u0[27];

$r0->status_id = $u0[28];



$result[]=$r0;
}
$wd->close();
return $result;
}
static function get_l30($time,$count=30,$page=0)
{
$result=array();
$wd=new wra_db();

$wd->query = 'SELECT 
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,
 `updated`, `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`
 FROM `'.WRA_CONF::$db_prefix."foursqvenues` 
   where type_id=1 and  time<".$time."+86400
         order by time desc
 LIMIT ".$page*$count.",".$count."";
$wd->executereader();
while($u0=$wd->read()){
$r0=new wra_foursqvenues();
$r0->id = $u0[0];

$r0->time = $u0[1];

$r0->name = $u0[2];

$r0->address = $u0[3];

$r0->city = $u0[4];

$r0->ttl = $u0[5];

$r0->source = $u0[6];

$r0->lat = $u0[7];

$r0->lng = $u0[8];

$r0->color_id = $u0[9];

$r0->cat_id = $u0[10];

$r0->picture = $u0[11];

$r0->link = $u0[12];

$r0->description = $u0[13];

$r0->status = $u0[14];

$r0->updated = $u0[15];
$r0->resource = $u0[16];

$r0->points = $u0[17];

$r0->type_id = $u0[18];

$r0->strokeweight = $u0[19];

$r0->strokeopacity = $u0[20];

$r0->strokecolor = $u0[21];

$r0->symbolpath = $u0[22];

$r0->fillcolor = $u0[23];

$r0->fillopacity = $u0[24];

$r0->twitpic = $u0[25];

$r0->user_added = $u0[26];

$r0->tts = $u0[27];

$r0->status_id = $u0[28];




$result[]=$r0;
}
$wd->close();
return $result;
}
static function lastupdate($count=10,$page=0)
{
$result=time();
$wd=new wra_db();

$wd->query = 'SELECT 

 `updated`
 FROM `'.WRA_CONF::$db_prefix."foursqvenues` 
 order by id desc";
$wd->executereader();
if($u0=$wd->read()){
$result=$u0[0];
}
$wd->close();
return $result;
}
function add()
{


 $wd=new wra_db();
 $this->id=WRA::getnewkey("".WRA_CONF::$db_prefix.'foursqvenues');
 $wd->query= 'INSERT INTO `'.WRA_CONF::$db_prefix."foursqvenues` (
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,

 `updated`,
 `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`
 )VALUES(
 '$this->id',
 '$this->time',
 '$this->name',
 '$this->address',
 '$this->city',
 '$this->ttl',
 '$this->source',
 '$this->lat',
 '$this->lng',
 '$this->color_id',
 '$this->cat_id',
 '$this->picture',
 '$this->link',
 '$this->description',
 '$this->status',
 '$this->updated',

 '$this->resource',
 '$this->points',
 '$this->type_id',
 '$this->strokeweight',
 '$this->strokeopacity',
 '$this->strokecolor',
 '$this->symbolpath',
 '$this->fillcolor',
 '$this->fillopacity',
 '$this->twitpic',
 '$this->user_added',
 '$this->tts',
 '$this->status_id'
 )";
 foreach(WRA_CONF::$clones as $k=>$v){
     $url = 'URL';
$data = array('query' =>  $wd->query,'code'=>  WRA_CONF::$updatecode);
$options = array(
        'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    )
);
$url=$v.'sinc';
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
 // wra_works::add('sincresult', '', $result);
 }
 $wd->execute();
if(!WRA_CONF::$usegetkey) $this->id=$wd->getlastkey();	
$wd->close();
unset($wd);
}
function update()
{


$wd=new wra_db();
 $wd->query = 'UPDATE `'.WRA_CONF::$db_prefix."foursqvenues`
SET 
 `time`='$this->time',
 `name`='$this->name',
 `address`='$this->address',
 `city`='$this->city',
 `ttl`='$this->ttl',
 `source`='$this->source',
 `lat`='$this->lat',
 `lng`='$this->lng',
 `color_id`='$this->color_id',
 `cat_id`='$this->cat_id',
 `picture`='$this->picture',
 `link`='$this->link',
 `description`='$this->description',
 `status`='$this->status',
 `updated`='$this->updated',
 `resource`='$this->resource',
 `points`='$this->points',
 `type_id`='$this->type_id',
 `strokeweight`='$this->strokeweight',
 `strokeopacity`='$this->strokeopacity',
 `strokecolor`='$this->strokecolor',
 `symbolpath`='$this->symbolpath',
 `fillcolor`='$this->fillcolor',
 `fillopacity`='$this->fillopacity',
 `twitpic`='$this->twitpic',
 `user_added`='$this->user_added',
 `tts`='$this->tts',
 `status_id`='$this->status_id'

 WHERE `id`='$this->id'";
 $wd->execute();	
$wd->close();
unset($wd);
}
static function getidbylink($link)
{
$result=false;
$wd=new wra_db();


$wd->query= 'SELECT id FROM `'.WRA_CONF::$db_prefix."foursqvenues` WHERE `link` = '$link'";

$wd->executereader();

if($u0=$wd->read())
    $result=$u0['id'];

$wd->close();
unset($wd);
return $result;
}
static function isexist($id,$lang='ru')
{
$result=false;
$wd=new wra_db();


$wd->query= 'SELECT id FROM `'.WRA_CONF::$db_prefix."foursqvenues` WHERE `id` = '$id'";

$wd->executereader();

if($u0=$wd->read())
    $result=$u0['id'];

$wd->close();
unset($wd);
return $result;
}
function delete()
{
$wd=new wra_db();

$wd->query = 'DELETE FROM `'.WRA_CONF::$db_prefix."foursqvenues` where `id`='$this->id'";
 $wd->execute();
$wd->close();

unset($wd);
return true;
}

function load($id)
{
$wd=new wra_db();
$this->id = $id;

$wd->query = 'SELECT 
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,
 `updated`, `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`
 FROM `'.WRA_CONF::$db_prefix."foursqvenues`  where `id`='$this->id'";
 $wd->executereader();
if($u0=$wd->read()){

$this->id = $u0[0];

$this->time = $u0[1];

$this->name = $u0[2];

$this->address = $u0[3];

$this->city = $u0[4];

$this->ttl = $u0[5];

$this->source = $u0[6];

$this->lat = $u0[7];

$this->lng = $u0[8];

$this->color_id = $u0[9];

$this->cat_id = $u0[10];

$this->picture = $u0[11];

$this->link = $u0[12];

$this->description = $u0[13];

$this->status = $u0[14];

$this->updated = $u0[15];

$this->resource = $u0[16];

$this->points = $u0[17];

$this->type_id = $u0[18];

$this->strokeweight = $u0[19];

$this->strokeopacity = $u0[20];

$this->strokecolor = $u0[21];

$this->symbolpath = $u0[22];

$this->fillcolor = $u0[23];

$this->fillopacity = $u0[24];

$this->twitpic = $u0[25];

$this->user_added = $u0[26];

$this->tts = $u0[27];

$this->status_id = $u0[28];

 }
$wd->close();
unset($wd);

}


static function findlast($name,$cat)
{
$wd=new wra_db();
$me=false;


$wd->query = 'SELECT 
 `id`,
 `time`,
 `name`,
 `address`,
 `city`,
 `ttl`,
 `source`,
 `lat`,
 `lng`,
 `color_id`,
 `cat_id`,
 `picture`,
 `link`,
 `description`,
 `status`,
 `updated`, `resource`,
 `points`,
 `type_id`,
 `strokeweight`,
 `strokeopacity`,
 `strokecolor`,
 `symbolpath`,
 `fillcolor`,
 `fillopacity`,
 `twitpic`,
 `user_added`,
 `tts`,
 `status_id`
 FROM `'.WRA_CONF::$db_prefix."foursqvenues`  where `name`='$name' and `type_id`='$cat' order by id desc";
 $wd->executereader();
if($u0=$wd->read()){
$me=new wra_foursqvenues();
$me->id = $u0[0];

$me->time = $u0[1];

$me->name = $u0[2];

$me->address = $u0[3];

$me->city = $u0[4];

$me->ttl = $u0[5];

$me->source = $u0[6];

$me->lat = $u0[7];

$me->lng = $u0[8];

$me->color_id = $u0[9];

$me->cat_id = $u0[10];

$me->picture = $u0[11];

$me->link = $u0[12];

$me->description = $u0[13];

$me->status = $u0[14];

$me->updated = $u0[15];

$me->resource = $u0[16];

$me->points = $u0[17];

$me->type_id = $u0[18];

$me->strokeweight = $u0[19];

$me->strokeopacity = $u0[20];

$me->strokecolor = $u0[21];

$me->symbolpath = $u0[22];

$me->fillcolor = $u0[23];

$me->fillopacity = $u0[24];

$me->twitpic = $u0[25];

$me->user_added = $u0[26];

$me->tts = $u0[27];

$me->status_id = $u0[28];

 }
$wd->close();
unset($wd);
return $me;
}
 }
    ?>
