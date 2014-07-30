<?php defined('WERUA') or include('../../bad.php');
class wra_cats extends wfbaseclass{


 var $id;
 var $title;
 var $ruicon;
 var $alicon;
 var $style;
 var $img;

 function wra_cats ()
{
}

static function adminit($wfadmin) {
$wfadmin->table = 'cats';
$wfadmin->multilanguages = false;
$wfadmin->columns[] = new admincolumn("String", "id", "id", admincolumntype::text, admincolumntype::text, 1);
$wfadmin->columns[] = new admincolumn("String", "title", "title", admincolumntype::text, admincolumntype::text, 2);
$wfadmin->columns[] = new admincolumn("String", "ruicon", "ruicon", admincolumntype::text, admincolumntype::text, 3);
$wfadmin->columns[] = new admincolumn("String", "alicon", "alicon", admincolumntype::text, admincolumntype::text, 4);
$wfadmin->columns[] = new admincolumn("String", "style", "style", admincolumntype::text, admincolumntype::text, 5);
$wfadmin->columns[] = new admincolumn("String", "img", "img", admincolumntype::text, admincolumntype::text, 6);
$wfadmin->order = " order by id asc";
}

static function getcount($category)
{
$result=0;
$wd=new wra_db();

$wd->query = 'SELECT count(`id`)
 FROM `'.WRA_CONF::$db_prefix.'wra_cats`';
$wd->executereader();
while($u0=$wd->read()){

$result=$u0[0];
}
$wd->close();
return $result;
}
static function get_list($count=50,$page=0)
{
$result=array();
$wd=new wra_db();

$wd->query = 'SELECT 
 `id`,
 `title`,
 `ruicon`,
 `alicon`,
 `style`,
 `img`
 FROM `'.WRA_CONF::$db_prefix."cats` order by `title` 
 LIMIT ".$page*$count.",".$count."";
$wd->executereader();
while($u0=$wd->read()){
$r0=new wra_cats();
$r0->id = $u0[0];

$r0->title = $u0[1];

$r0->ruicon = $u0[2];

$r0->alicon = $u0[3];

$r0->style = $u0[4];

$r0->img = $u0[5];




$result[$u0[0]]=$r0;
}
$wd->close();
return $result;
}
static function getdrop($count=50,$page=0)
{
$result=array();
$wd=new wra_db();

$wd->query = 'SELECT 
 `id`,
 `title`
 FROM `'.WRA_CONF::$db_prefix."cats` order by `title` 
 LIMIT ".$page*$count.",".$count."";
$wd->executereader();
while($u0=$wd->read()){


$result[$u0[0]]=$u0[1];
}
$wd->close();
return $result;
}
function add()
{


 $wd=new wra_db();
 $this->id=WRA::getnewkey("".WRA_CONF::$db_prefix.'cats');
 $wd->query= 'INSERT INTO `'.WRA_CONF::$db_prefix."cats` (
 `id`,
 `title`,
 `ruicon`,
 `alicon`,
 `style`,
 `img`
 )VALUES(
 '$this->id',
 '$this->title',
 '$this->ruicon',
 '$this->alicon',
 '$this->style',
 '$this->img'
 )";
 $wd->execute();
if(!WRA_CONF::$usegetkey) $this->id=$wd->getlastkey();	
$wd->close();
unset($wd);
}
function update()
{


$wd=new wra_db();
 $wd->query = 'UPDATE `'.WRA_CONF::$db_prefix."cats`
SET 
 `id`='$this->id',
 `title`='$this->title',
 `ruicon`='$this->ruicon',
 `alicon`='$this->alicon',
 `style`='$this->style',
 `img`='$this->img'
 WHERE `id`='$this->id'";
 $wd->execute();	
$wd->close();
unset($wd);
}

static function isexist($id,$lang='ru')
{
$result=false;
$wd=new wra_db();


$wd->query= 'SELECT id FROM `'.WRA_CONF::$db_prefix."cats` WHERE `id` = '$id'";

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

$wd->query = 'DELETE FROM `'.WRA_CONF::$db_prefix."cats` where `id`='$this->id'";
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
 `title`,
 `ruicon`,
 `alicon`,
 `style`,
 `img`
 FROM `'.WRA_CONF::$db_prefix."cats`  where `id`='$this->id'";
 $wd->executereader();
if($u0=$wd->read()){

$this->id = $u0[0];

$this->title = $u0[1];

$this->ruicon = $u0[2];

$this->alicon = $u0[3];

$this->style = $u0[4];

$this->img = $u0[5];
 }
$wd->close();
unset($wd);

}
 }
    ?>
