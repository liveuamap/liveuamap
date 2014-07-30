<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_iteminfo extends wfbaseclass{

    //класс
    var $objectadres = '';
    var $currentobjid = -1;
    var $id;
    var $weight;
    var $alt;
    var $keywords;
    var $autoadres;
    var $adres;
    var $commentopt;
    var $mappriority;
    var $authorid;
    var $postdate;
    var $postopt;
    var $saveid;
    var $teaser;
    var $author = null;

    function gauthor() {

        if ($this->author == null) {
            $this->author = new wra_user();

            if (isset($this->authorid))
                $this->author->load($this->authorid);
            return $this->author;
        }else
            return $this->author;
    }

    function gettexttm() {

        $timestamp = strtotime($this->postdate);
        $monthes = wra_time::getmonthesrp('ru');
        $result = date('H', $timestamp) . ':' . date('i', $timestamp);

        return $result;
    }

    function gettextdmy() {

        $timestamp = strtotime($this->postdate);
        $monthes = wra_time::getmonthesrp('ru');
        $result = date('j', $timestamp) . ' ' . $monthes[round(date('m', $timestamp), 0)] . ' ' . date('Y', $timestamp);

        return $result;
    }

    function gettextdaymonthyear($dict) {

        $timestamp = strtotime($this->postdate);
        $monthes = wra_time::getmonthesrp('ru');
        $result = date('j', $timestamp) . ' ' . $dict->getword($monthes[round(date('m', $timestamp), 0)]) . ' ' . date('Y', $timestamp);

        return $result;
    }

    function saveobj($objid, $wra) {

        $obj = new wra_objects();
        $obj->load($objid);
      
        $obj->altlink = $this->adres;
        
        if ($this->adres == '') {
            switch ($wra) {
                case 'wra_events':
                    $obj->altlink = 'history/' . $obj->objid;
                    break;
                case 'wra_virtualpage':
                    $obj->altlink = 'page/' . $obj->objid;
                    break;
                default:
                    $obj->altlink = str_replace('wra_','',$wra). '/' . $obj->objid;
                    break;
            }
        }
        if($this->autoadres)
        if($this->adres==''){$this->adres=$obj->altlink;
        $this->update();
        }
        $obj->update();
        
    }

    function saveit($saveid, $header='') {
        $this->saveid = $saveid;
        $this->weight = $_POST['fieldiiweight'];
        $this->weight = $_POST['fieldiiweight'];
        $this->alt = $_POST['fieldiialt'];
        $this->keywords = $_POST['fieldiikeywords'];
        if (isset($_POST['fieldiiautoadres']))
            $this->autoadres = 1;
        else
            $this->autoadres = 0;
        if ($this->autoadres) {
            $this->adres = WRA::totranslit(WRA::mb_trim($header));
        } else {

            $this->adres = $_POST['fieldiiadres'];
        }

        $this->commentopt = $_POST['fieldiicommentopt'];
        $this->mappriority = $_POST['fieldiimappriority'];
        $this->authorid = $_POST['fieldiiauthorid'];
        $this->postdate = wra_admintable::getdate('fieldiipostdate'); //(iipostdate_ATOM, mktime($_POST['fieldiipostdateshowhour'], $_POST['fieldiipostdateshowminute'], 0, $_POST['fieldiipostdateshowmonth'], $_POST['fieldiipostdateshowday'], $_POST['fieldiipostdateshowyear']));
        $this->postopt = $_POST['fieldiipostopt'];
        if ($saveid != -1) {
            $this->update();
        } else {

            $this->add();
        }
        
        ///обработка уникальной формы cf_images
        $jsonpost=json_decode(stripslashes(wra_admintable::getpost('new-fieldiiimages')));
        $jsondelete=json_decode(stripslashes(wra_admintable::getpost('delete-fieldiiimages')));
if($jsonpost=='')
 $jsonpost=json_decode(stripslashes(stripslashes(wra_admintable::getpost('new-fieldiiimages'))));
if($jsondelete=='')
 $jsondelete=json_decode(stripslashes(stripslashes(wra_admintable::getpost('delete-fieldiiimages'))));
        if(is_array($jsonpost))
        foreach($jsonpost as $key => $value){


                $newitem=new wra_image();
                $edik=false;
                if(substr($value->id,0,1)!='p')$edik=true;
                if($edik)
                    $newitem->load($value->id);
                
                else  $newitem->load($value->picid);

                $newitem->description=$value->description;
                $newitem->header=$value->header;
                $newitem->galinfoid=$this->id;
                
                $newitem->update();


        }
        if(is_array($jsondelete))
        foreach($jsondelete as $key => $value){


                $newitem=new wra_image();
                $newitem->load($value);
                $newitem->delete();


        }
        else{
               $newitem=new wra_image();
                $newitem->load($jsondelete);
                $newitem->delete();

        }
       
        //-----------
    }

    static function selectcolumns() {
        return 'ii.id as iiimages,ii.alt as iialt,
 ii.keywords as iikeywords,
 ii.autoadres as iiautoadres,
 ii.adres as iiadres,
 ii.authorid as iiauthorid,
 ii.postdate as iipostdate';
        
         return 'ii.weight as iiweight,
 ii.alt as iialt,
 ii.keywords as iikeywords,
 ii.autoadres as iiautoadres,
 ii.adres as iiadres,
 ii.commentopt as iicommentopt,
 ii.mappriority as iimappriority,
 ii.authorid as iiauthorid,
 ii.postdate as iipostdate,
 ii.postopt as iipostopt';
    }

    function wra_iteminfo() {
        
    }

    static function addadmincolumns($wt) {

        $c0 = new wra_column('Вес материала', column_type_text, 'iiweight');
        $c0->classes='inforow';
        $c0->description = 'При выводе содержимого, вес материала учитывается и отразится на порядке вывода материалов.';
      //  $wt->addcolumn($c0);

        
        $c0 = new wra_column('Фотографии', column_type_customfield, 'iiimages');
        $c0->customfieldpage="parts/cf_imageinfo.php";
        $c0->classes='inforow';
        $wt->addcolumn($c0);

        $c0 = new wra_column('Мета-ярлык: Описание', column_type_bigtext, 'iialt');
        $c0->description = 'Введите описание для данной страницы. Используйте не более 20 слов, общее число символов не должно превышать 255. Разметка HTML недопустима, как и прочие средства форматирования. Если не заполнять это поле, описанием будет служить аннотация';
        $c0->itemstyle = 'width:550px;height:150px;';
        $wt->addcolumn($c0);


        $c0 = new wra_column('Мета-ярлык: Ключевые слова', column_type_bigtext, 'iikeywords');
        $c0->description = 'Введите через запятую список ключевых слов для этой страницы. Избегайте повторения ключевых слов - это снижает рейтинг сайта в поисковых системах.';
        $c0->itemstyle = 'width:550px;height:150px;';
        $wt->addcolumn($c0);


        $c0 = new wra_column('Автоматический адрес', column_type_check, 'iiautoadres');
        $c0->description = 'Адрес страницы будет сгенерирован автоматически.';
        $c0->defaultvalue=1;
        $wt->addcolumn($c0);


        $c0 = new wra_column('Адрес', column_type_text, 'iiadres');
        $c0->description = 'Альтернативная ссылка страницы';

        $wt->addcolumn($c0);


        $c0 = new wra_column('Установка комментариев', column_type_dropdown, 'iicommentopt');
        $c0->description = 'Могут ли пользователи использовать систему комментариев в этом разделе';
        $c0->dropdown_query = "select '0' as 'id', 'Отключено' as 'text'
 UNION select '1' as 'id', 'Только чтение' as 'text'
 UNION select '2' as 'id', 'Чтение/Запись' as 'text'
                ";
        $c0->defaultvalue = '2';
      //  $c0->loaddropdown();
       // $wt->addcolumn($c0);


        $c0 = new wra_column('Приоритет карты сайта', column_type_dropdown, 'iimappriority');
        $c0->description = 'С каким приоритетом страница будем показыватся на карте сайта';
        $c0->dropdown_query = "select '1' as 'id', 'По умолчанию' as 'text'
UNION select '0.9' as 'id', '0.9' as 'text'
UNION select '0.8' as 'id', '0.8' as 'text'
UNION select '0.7' as 'id', '0.7' as 'text'
UNION select '0.6' as 'id', '0.6' as 'text'
UNION select '0.5' as 'id', '0.5' as 'text'
UNION select '0.4' as 'id', '0.4' as 'text'
UNION select '0.3' as 'id', '0.3' as 'text'
UNION select '0.2' as 'id', '0.2' as 'text'
UNION select '0.1' as 'id', '0.1' as 'text'
UNION select '0' as 'id', '0' as 'text'
UNION select '-1' as 'id', 'Нет в карте сайта' as 'text'
                ";

       // $c0->loaddropdown();
        $c0->defaultvalue = '1.0';
        //$wt->addcolumn($c0);


        $c0 = new wra_column('Автор', column_type_dropdown, 'iiauthorid');
        $c0->description = 'Автор данной страницы';
        $c0->defaultvalue = wra_userscontext::curuser();
        $c0->dropdown_query = wra_iteminfo::getusersquery();

        $c0->loaddropdown();

        $wt->addcolumn($c0);


        $c0 = new wra_column('Дата публикации', column_type_datetime, 'iipostdate');
        $c0->defaultvalue = WRA::getcurtime();
        $c0->description = 'Когда добавлена страница';

        $wt->addcolumn($c0);


        $c0 = new wra_column('Установка публикации', column_type_dropdown, 'iipostopt');
        $c0->dropdown_query = "select '0' as 'id', 'Не публиковать' as 'text'
 UNION select '1' as 'id', 'Опубликовать' as 'text'
 UNION select '2' as 'id', 'Опубликовать на главной' as 'text'
 UNION select '3' as 'id', 'Закреплять вверху' as 'text'
                ";
        $c0->defaultvalue = '1';
      //  $c0->loaddropdown();
      //  $wt->addcolumn($c0);
    }

    static function getusersquery() {
        return "
select '-1' as 'id','гость' as login UNION
 select id, login from `" . WRA_CONF::$db_prefix . "users`
                ";
    }

    static function getlist($count=255, $page=0) {//получить список
        $result = array();
        $wd = new wra_db();

        $wd->query = "SELECT `id`
 FROM `" . WRA_CONF::$db_prefix . "iteminfo`  LIMIT " . $page * $count . "," . $count . " ";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_iteminfo();
            $r0->loadid($u0[0]);
            $result[count($result)] = $r0;
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    static function updatebyid($id, $key, $value) {

        $wd = new wra_db();


        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "iteminfo`
                SET `$key`='$value' 
                WHERE `id`='$id'";

        $wd->execute();
        $wd->close();
        unset($wd);
    }

    static function getinfoidbyadres($adres) {
        $result = false;
        $wd = new wra_db();

        $wd->query = 'SELECT `id` FROM `' . WRA_CONF::$db_prefix . "iteminfo`
    WHERE rtrim(`adres`) LIKE '$adres'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    static function getidbyitemid($itemid, $table) {
        $result = false;
        $wd = new wra_db();

        $wd->query = 'SELECT `id` FROM `' . WRA_CONF::$db_prefix . "$table`
    WHERE `infoid`='$itemid'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    static function getvaluebyid($id, $key) {//получить значение по id и ключу
        $result = '';
        $wd = new wra_db();


        $wd->query = 'SELECT `$key` FROM `' . WRA_CONF::$db_prefix . "iteminfo`
                            WHERE `id`='$id'";

        $wd->executereader();

        if ($u0 = $wd->read()) {


            $result = $u0[0];
        }

        $wd->close();
        unset($wd);
        return $result;
    }

    function add() {//добавление нового объекта

        if (!isset($this->creator_id)) {

            $this->creator_id = wra_userscontext::curuser();
        }

        $wd = new wra_db();
        $this->id = WRA::getnewkey('' . WRA_CONF::$db_prefix . 'iteminfo');
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "iteminfo` (
 `id`,
 `weight`,
 `alt`,
 `keywords`,
 `autoadres`,
 `adres`,
 `commentopt`,
 `mappriority`,
 `authorid`,
 `postdate`,
 `postopt`,`teaser`
 )VALUES(
 '$this->id',
 '$this->weight',
 '$this->alt',
 '$this->keywords',
 '$this->autoadres',
 '$this->adres',
 '$this->commentopt',
 '$this->mappriority',
 '$this->authorid',
 '$this->postdate',
 '$this->postopt','$this->teaser'
 )";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();
        unset($wd);
        //$this->currentobjid=wra_objects::addnewobject("wra_iteminfo",$this->id,$this->objectadres);
    }

    function update() {//обновление объекта


        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "iteminfo`
 SET 
 `weight`='$this->weight',
 `alt`='$this->alt',
 `keywords`='$this->keywords',
 `autoadres`='$this->autoadres',
 `adres`='$this->adres',
 `commentopt`='$this->commentopt',
 `mappriority`='$this->mappriority',
 `authorid`='$this->authorid',
 `postdate`='$this->postdate',
 `postopt`='$this->postopt',`teaser`='$this->teaser'
 WHERE `id`='$this->id'";
        $wd->execute();
        //$this->currentobjid=wra_objects::updateobject("wra_iteminfo",$this->id,$this->objectadres);
        $wd->close();
        unset($wd);
    }

    static function isexist($id) {//возвращает true, если объект с запрашиваемым id существует
        $result = false;
        $wd = new wra_db();


        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "iteminfo` WHERE `id` = '$id'";

        $wd->executereader();

        $result = ($u0 = $wd->read());

        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {//удаление объекта
        $wd = new wra_db();

        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "iteminfo` where `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
        //wra_objects::deleteobj($this->currentobjid);
        return false;
    }

    function loadid($id) {
        $this->id = $id;
    }

    function loadmore() {
        $this->load($this->id);
    }

    function load($id) {//загрузка объекта
        $wd = new wra_db();
        $this->id = $id;

        $wd->query = 'SELECT 
 `id`,
 `weight`,
 `alt`,
 `keywords`,
 `autoadres`,
 `adres`,
 `commentopt`,
 `mappriority`,
 `authorid`,
 `postdate`,
 `postopt`,`teaser`
 FROM `' . WRA_CONF::$db_prefix . "iteminfo`   where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {

            $this->id = $u0[0];

            $this->weight = $u0[1];

            $this->alt = $u0[2];

            $this->keywords = $u0[3];

            $this->autoadres = $u0[4];

            $this->adres = $u0[5];

            $this->commentopt = $u0[6];

            $this->mappriority = $u0[7];

            $this->authorid = $u0[8];

            $this->postdate = $u0[9];

            $this->postopt = $u0[10];
            
            
            $this->teaser = $u0[11];
        }
        $wd->close();
        unset($wd);
        //$this->currentobjid=wra_objects::getidbyitemid("wra_iteminfo",$this->id);
    }

}



class wra_image extends wfbaseclass{
    //класс
    var $objectadres='';
    var $currentobjid=-1;
    var $curobj=null;
    var $link='';var $parttype='';
    function gobj(){    
        if($this->curobj==null){
        $this->curobj=new wra_objects();        
            $this->curobj->load($this->currentobjid);
            return $this->curobj;
        }else 
        return $this->curobj;
    }


    var $id;
    var $header;
    var $description;
    var $pic;
    var $tmbpic;
    var $galinfoid;
    var $keywords; 
    var $sortorder;
    var $morevisual;
    var $htmlcontent;

function wra_image (){}

     static function adminit($wfadmin){
        $wfadmin->table='image';
        $wfadmin->multilanguages=true;
        $wfadmin->columns[]=new admincolumn("String", "header", "Заголовок", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "description", "Описание", admincolumntype::text, admincolumntype::bigtext, 3);
        $wfadmin->columns[]=new admincolumn("String", "pic", "pic", admincolumntype::none, admincolumntype::pic); 
        $wfadmin->columns[]=new admincolumn("String", "tmbpic", "tmb pic", admincolumntype::none, admincolumntype::pic, 5);
        $wfadmin->columns[]=new admincolumn("String", "galinfoid", "id галереи", admincolumntype::text, admincolumntype::text, 5);
        $wfadmin->columns[]=new admincolumn("String", "parttype", "галерея", admincolumntype::text, admincolumntype::text, 5);
        $wfadmin->order = " order by id asc";

    }

static function save($saveid=-1,$pid=-1,$adminedit='', $lang="ru"){//сохранение изменного (или добавляемого класса) для админки
    switch($adminedit){
        default:
        $savepc = new wra_image();
        if($savepc->ifexist($saveid)){
            $savepc->load($saveid,$lang);
        }
        $savepc->header=wra_admintable::getpost('fieldheader-'.$lang);
        $savepc->description=wra_admintable::getpost('fielddescription-'.$lang);
        $savepc->pic=wra_admintable::getpost('fieldpic-'.$lang);
        $savepc->tmbpic=wra_admintable::getpost('fieldtmbpic-'.$lang);
        $savepc->galinfoid=wra_admintable::getpost('fieldgalinfoid-'.$lang);
        $savepc->keywords=wra_admintable::getpost('fieldkeywords-'.$lang);
        $savepc->sortorder=wra_admintable::getpost('fieldsortorder-'.$lang);
        $savepc->htmlcontent=wra_admintable::getpost('fieldhtmlcontent-'.$lang);
        $savepc->morevisual=wra_admintable::getcheck('fieldmorevisual-'.$lang);
        $savepc->parttype=wra_admintable::getcheck('fieldparttype-'.$lang);
        $savepc->link=wra_admintable::getcheck('fieldlink-'.$lang);
        if($savepc->ifexist($saveid)){
            $savepc->update($lang);
        }else{
            $savepc->add($lang);
        }
        //$moreinfo->saveobj($savepc->currentobjid,'wra_image');
        return $savepc->id;
    }
    return $saveid;
}

static function getlistfull($infoid, $count=10,$page=0,$lang="ru")//получить полный список
{
    $result=array();
    $wd=new wra_db();
    $wd->query = 'SELECT 
                `id`,
                `header`,
                `description`,
                `pic`,
                `tmbpic`,
                `galinfoid`,
                `keywords`,`sortorder`,
                `morevisual`,
                `htmlcontent`,`parttype`,`link`
             FROM `'.WRA_CONF::$db_prefix."image".$lang."` 
                 WHERE `galinfoid`='$infoid'
             LIMIT ".$page*$count.",".$count."";
    $wd->executereader();
    while($u0=$wd->read()){
        $r0=new wra_image();
        $r0->id = $u0[0];
        $r0->header = $u0[1];
        $r0->description = $u0[2];
        $r0->pic = $u0[3];
        $r0->tmbpic = $u0[4];
        $r0->galinfoid = $u0[5];
        $r0->keywords = $u0[6];
        $r0->sortorder= $u0[7];
        $r0->morevisual= $u0[8];
        $r0->htmlcontent= $u0[9];
        $r0->parttype= $u0[10];
        $r0->link= $u0[11];
        // $r0->currentobjid=wra_objects::getidbyitemid('wra_image',$r0->id);
        $result[count($result)]=$r0;
    }
    $wd->close();
    return $result;
}
static function getlistadmin($galid, $parttype,$lang="ru", $count=500,$page=0)//получить полный список
{
    $result=array();
    $wd=new wra_db();
    $wd->query = 'SELECT 
                `id`,
                `header`,
                `description`,
                `pic`,
                `tmbpic`,
                `galinfoid`,
                `keywords`,`sortorder`,
                `morevisual`,
                `htmlcontent`,`parttype`,`link`,`width`,`height`
             FROM `'.WRA_CONF::$db_prefix."image".$lang."` 
                 WHERE `galinfoid`='$galid' and  `parttype`='$parttype'
            order by `sortorder`
             LIMIT ".$page*$count.",".$count."";

    $wd->executereader();
    while($u0=$wd->read()){
        $r0=new wra_image();
        $r0->id = $u0[0];
        $r0->header = $u0[1];
        $r0->description = $u0[2];
        $r0->pic = $u0[3];
        $r0->tmbpic = $u0[4];
        $r0->galinfoid = $u0[5];
        $r0->keywords = $u0[6];
        $r0->sortorder= $u0[7];
        $r0->morevisual= $u0[8];
        $r0->htmlcontent= $u0[9];
        $r0->parttype= $u0[10];
        $r0->link= $u0[11];
           $r0->width= $u0[12];
              $r0->height= $u0[13];
        // $r0->currentobjid=wra_objects::getidbyitemid('wra_image',$r0->id);
        $result[count($result)]=$r0;
    }
    $wd->close();
    return $result;
}
static function getlistany($parttype,$lang="ru", $count=500,$page=0)//получить полный список
{
    $result=array();
    $wd=new wra_db();
    $wd->query = 'SELECT 
                `id`,
                `header`,
                `description`,
                `pic`,
                `tmbpic`,
                `galinfoid`,
                `keywords`,`sortorder`,
                `morevisual`,
                `htmlcontent`,`parttype`,`link`,`width`,`height`
             FROM `'.WRA_CONF::$db_prefix."image".$lang."` 
                 WHERE `link`='' and  `parttype`='$parttype'
            order by RAND()
             LIMIT ".$page*$count.",".$count."";
 
    $wd->executereader();
    while($u0=$wd->read()){
        $r0=new wra_image();
        $r0->id = $u0[0];
        $r0->header = $u0[1];
        $r0->description = $u0[2];
        $r0->pic = $u0[3];
        $r0->tmbpic = $u0[4];
        $r0->galinfoid = $u0[5];
        $r0->keywords = $u0[6];
        $r0->sortorder= $u0[7];
        $r0->morevisual= $u0[8];
        $r0->htmlcontent= $u0[9];
        $r0->parttype= $u0[10];
        $r0->link= $u0[11];
           $r0->width= $u0[12];
              $r0->height= $u0[13];
        // $r0->currentobjid=wra_objects::getidbyitemid('wra_image',$r0->id);
        $result[count($result)]=$r0;
    }
    $wd->close();
    return $result;
}
static function getlist($count=10,$page=0, $lang = "ru")//получить список
{
    $result=array();
    $wd=new wra_db();
    $wd->query = 'SELECT `id`
                     FROM `'.WRA_CONF::$db_prefix."image".$lang."` 
                     LIMIT ".$page*$count.",".$count."";
    $wd->executereader();
    while($u0=$wd->read()){
        $r0=new wra_image();
        $r0->loadid($u0[0]);
        $result[count($result)]=$r0;
    }
    $wd->close();
    return $result;
}
static function pic_replace($pics = array(), $text, $size='690', $divclass='') {
    foreach ($pics as $k => $v) {
        $imgsearch = "[image".$v->id."]";
        $text = str_replace($imgsearch, "<div class='".$divclass."'><img src ='".WRA::base_url().$v->pic."' width='".$size."'/></div>", $text);
    }
    return $text;
}
static function updatebyid($id,$key,$value,$lang="ru"){
    $wd=new wra_db();
    $wd->query='UPDATE `'.WRA_CONF::$db_prefix."image".$lang."`
                    SET `$key`='$value' 
                    WHERE `id`='$id'";
    $wd->execute(); 
    $wd->close();
}

static function getvaluebyid($id,$key,$lang="ru"){//получить значение по id и ключу
    $result='';
    $wd=new wra_db();
    $wd->query='SELECT `$key` FROM `'.WRA_CONF::$db_prefix."image".$lang."`
                    WHERE `id`='$id'";
    $wd->executereader();
    if($u0=$wd->read()){
        $result=$u0[0];
    }
    $wd->close();
    return $result;
}

function add($lang="ru")//добавление нового объекта
{

    $wd=new wra_db();
    if (!$this->id)$this->id=WRA::getnewkey("".WRA_CONF::$db_prefix."image".$lang);
    $wd->query= 'INSERT INTO `'.WRA_CONF::$db_prefix."image".$lang."` (
                    `id`,
                    `header`,
                    `description`,
                    `pic`,
                    `tmbpic`,
                    `galinfoid`,
                    `keywords`,`sortorder`,
                    `morevisual`,
                    `htmlcontent`,`parttype`,`link`,`width`,`height`
                )VALUES(
                    '$this->id',
                    '$this->header',
                    '$this->description',
                    '$this->pic',
                    '$this->tmbpic',
                    '$this->galinfoid',
                    '$this->keywords',
                    '$this->sortorder',
                    '$this->morevisual',
                    '$this->htmlcontent','$this->parttype','$this->link','$this->width','$this->height'
                )";
    $wd->execute();
    if(!WRA_CONF::$usegetkey) $this->id=$wd->getlastkey();  
    $wd->close();
    // $this->currentobjid=wra_objects::addnewobject('wra_image',$this->id,$this->objectadres);
    unset($wd);
}
function update($lang="ru")//обновление объекта
{
    $wd=new wra_db();
    $wd->query = 'UPDATE `'.WRA_CONF::$db_prefix."image".$lang."`
        SET 
         `header`='$this->header',
         `description`='$this->description',
         `pic`='$this->pic',
         `tmbpic`='$this->tmbpic',
         `galinfoid`='$this->galinfoid',
         `keywords`='$this->keywords',
          `sortorder`='$this->sortorder',
        `morevisual`='$this->morevisual',
        `htmlcontent`='$this->htmlcontent',`parttype`='$this->parttype',`link`='$this->link'
         WHERE `id`='$this->id'";
    // WRA::debug($wd->query);
   
    $wd->execute(); 
    // $this->currentobjid=wra_objects::updateobject('wra_image',$this->id,$this->objectadres);
    $wd->close();
    unset($wd);
}
static function isexist($wf, $id, $lang="ru")//возвращает true, если объект с запрашиваемым id существует
{
    $result=false;
    $wd=new wra_db();
    $wd->query= 'SELECT id FROM `'.WRA_CONF::$db_prefix."image".$lang."` WHERE `id` = '$id'";
    $wd->executereader();
    $result=($u0=$wd->read());
    $wd->close();
    unset($wd);
    return $result;
}
static function ifexist($id, $lang="ru")//возвращает true, если объект с запрашиваемым id существует
{
    $result=false;
    $wd=new wra_db();
    $wd->query= 'SELECT id FROM `'.WRA_CONF::$db_prefix."image".$lang."` WHERE `id` = '$id'";
    $wd->executereader();
    $result=($u0=$wd->read());
    $wd->close();
    unset($wd);
    return $result;
}
static function getexistid($id, $lang = "ru")
{
    $result=false;
    $wd=new wra_db();
    $wd->query= 'SELECT id FROM `'.WRA_CONF::$db_prefix."image".$lang."` WHERE `id` = '$id'";
    $wd->executereader();
    if($u0=$wd->read())
        $result=$u0['id'];
    $wd->close();
    unset($wd);
    return $result;
}
function delete($lang = "ru")//удаление объекта
{
    $wd=new wra_db();
    $languages=wra_lang::getlist();
    foreach($languages as $l0){
        $wd->query = 'DELETE FROM `'.WRA_CONF::$db_prefix."image_".$l0->alias."` where `id`='$this->id'";
        // print_r($wd->query);
        $wd->execute();
    }
    $wd->close();
    // wra_objects::deleteobj($this->currentobjid);
    unset($wd);
    return true;
}
function loadid($id){
    $this->id=$id;
}
function loadmore(){
    $this->load($this->id);
}
function load($id,$lang="ru")//загрузка объекта
{
    $wd=new wra_db();
    $this->id = $id;
    $wd->query = 'SELECT 
     `id`,
     `header`,
     `description`,
     `pic`,
     `tmbpic`,
     `galinfoid`,
     `keywords`,`sortorder`,
    `morevisual`,
    `htmlcontent`,`parttype`,`link`
     FROM `'.WRA_CONF::$db_prefix."image".$lang."`  where `id`='$this->id'";
     // WRA::debug($wd->query);
    $wd->executereader();
    if($u0=$wd->read()){
        $this->id = $u0[0];
        $this->header = $u0[1];
        $this->description = $u0[2];
        $this->pic = $u0[3];
        $this->tmbpic = $u0[4];
        $this->galinfoid = $u0[5];
        $this->keywords = $u0[6];
        $this->sortorder= $u0[7];
        $this->morevisual= $u0[8];
        $this->htmlcontent= $u0[9];
        $this->parttype= $u0[10];
         $this->link= $u0[11];
    }
    $wd->close();
    unset($wd);
    // $this->currentobjid=wra_objects::getidbyitemid('wra_image',$this->id);
}
 }


class wra_options extends wfbaseclass{

    var $id;
    var $key;
    var $value;
    static $options = array();

    function wra_options() {        
    }

    static function updatevalue($key, $value) {
        if (wra_options::isexist($key)) {
            $wd = new wra_db();
            $wd->query = "UPDATE `" . WRA_CONF::$db_prefix . "options`
                            SET `value`='$value' 
                            WHERE `key`='$key'";
            $wd->execute();
            $wd->close();
            unset($wd);
        } else {
            $newoption = new wra_options();
            $newoption->key = $key;
            $newoption->value = $value;
            $newoption->add();
        }
    }

    static function getvalue($key) {
        $result = "";
        $wd = new wra_db();
        $wd->query = "SELECT `value` FROM `" . WRA_CONF::$db_prefix . "options`
                        WHERE `key`='$key'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return stripslashes($result);
    }

    static function loadoptions(){
        $result=array();
        $wd=new wra_db();
        
        $wd->query  = "SELECT 
                `key`,
                `value`
                FROM `".WRA_CONF::$db_prefix."options`";
        // WRA::debug($wd->query);
        $wd->executereader();
        while($u0=$wd->read()){
            self::$options[$u0[0]]=$u0[1];
        }
        $wd->close() ;
        unset($wd);
        return self::$options;
    }

    static function saveoptions(){
        // WRA::debug(self::$options);
        foreach (self::$options as $key => $option) {
            if (self::isexist($key)) {
                self::update($key,$option);
            } else {
                self::add($key,$option);
            }
        }
    }

    static function add($key, $value) {
        $wd=new wra_db();
        $wd->query= "INSERT INTO `".WRA_CONF::$db_prefix."options` (
            `id`,
            `key`,
            `value` 
        )VALUES(
            NULL,
            '$key',
            '$value'
        )";
        $wd->execute();
        // $this->id=$wd->getlastkey();
        $wd->close();
        unset($wd);
    }

    static function update($key, $value) {
        $wd=new wra_db();
        $wd->query = "UPDATE `".WRA_CONF::$db_prefix."options`
        SET 
            `value`='$value'
        WHERE `key`='$key'";
        // WRA::debug($wd->query);
        // die();
        $wd->execute(); 
        $wd->close();
        unset($wd);
    }

    static function isexist($key){//возвращает true, если объект с запрашиваемым id существует
        $result=false;
        $wd=new wra_db();
        $wd->query= "SELECT id FROM `".WRA_CONF::$db_prefix."options` WHERE `key` = '$key'";
        $wd->executereader();
        $result=($u0=$wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }
}



class wra_virtualpage extends wfbaseclass{

//класс
    var $objectadres = "";
    var $currentobjid = -1;
    var $id;
    var $header;
    var $content;
    var $link;
    var $menuid;
    var $infoid;

    function wra_virtualpage() {
        
    }

    static function deletecase($dcase, $did) {//удаление класса
        switch ($dcase) {
            default:
                return true;
        }

        return false;
    }

    static function edittable($saveid=-1, $pid=-1) { //таблица редактирования для вывода в админке
        $wt = new wra_admintable();
        $wt->link = WRA::getcurpage();

        $wt->query = "SELECT 
vi0.id,
vi0.header,
vi0.content,

vi0.menuid,'0' as 'menuidadd','' as 'menuidto'
," . wra_iteminfo::selectcolumns() . "
FROM `" . WRA_CONF::$db_prefix . "virtualpage` as vi0
 LEFT JOIN `" . WRA_CONF::$db_prefix . "iteminfo` as ii on ii.id=vi0.infoid
 WHERE vi0.id='$saveid'";

        $c0 = new wra_column("id", column_type_id, 'id');
        $c0->defaultvalue = $saveid;
        $wt->addcolumn($c0);


        $c0 = new wra_column("Заголовок", column_type_text, 'header');
        $c0->itemstyle = "width:550px;height:150px;";
        $wt->addcolumn($c0);




        $c0 = new wra_column("Содержимое", column_type_bigtext, 'content');
        $c0->itemstyle = "width:550px;height:350px;";
        $c0->classes = 'fieldcontent';
        $wt->addcolumn($c0);




//$c0=new wra_column("Ссылка",column_type_text,'link');
//$c0->itemstyle="width:550px;height:150px;";
//$wt->addcolumn($c0);  




        $c0 = new wra_column("Меню на странице", column_type_dropdown, 'menuid');
        $c0->dropdown_query = "select '-1' as 'id', 'нет' as 'header'
        union select id,header from `" . WRA_CONF::$db_prefix . "menu` where iscat=1";
        $c0->loaddropdown();
        $wt->addcolumn($c0);


        $c0 = new wra_column("Добавить новый подпункт меню", column_type_check, 'menuidadd');

        $c0->itemstyle = "width:550px;height:150px;";
        $wt->addcolumn($c0);
        $c0 = new wra_column("Добавить как подпункт", column_type_dropdown, 'menuidto');
        $c0->dropdown_query = "select '-1' as 'id', 'выберите' as 'header'
        union select id,header from `" . WRA_CONF::$db_prefix . "menu` ";
        $c0->loaddropdown();
        $wt->addcolumn($c0);

        wra_iteminfo::addadmincolumns($wt);
        if ($saveid != -1) {
            $wt->load($saveid, $pid);
        } else {

            $wt->addnew($saveid, $pid);
        }
        return $wt;
    }

    static function admintable($saveid=-1, $pid=-1) { //таблица просмотра для вывода в админке
        $wt = new wra_admintable();
        $wt->link = WRA::getcurpage();
        $wt->query = "SELECT 
vi0.id,
vi0.header,
vi0.content,
vi0.link,
vi0.menuid,
vi0.infoid
 FROM `" . WRA_CONF::$db_prefix . "virtualpage` as vi0 ";


        $c0 = new wra_column("id", column_type_id);
        $c0->defaultvalue = $saveid;
        $wt->addcolumn($c0);


        $c0 = new wra_column("название поля", column_type_h2header);
        $wt->addcolumn($c0);





        $wt->load($saveid, $pid);
        return $wt;
    }

    static function save($saveid=-1, $pid=-1, $adminedit="") {//сохранение изменного (или добавляемого класса) для админки
        switch ($adminedit) {
            default:
                $savepc = new wra_virtualpage();
                $moreinfo = new wra_iteminfo();
                if ($saveid != -1) {
                    $savepc->load($saveid);
                    $moreinfo->load($savepc->infoid);
                }
                $moreinfo->saveit($saveid, $_POST['fieldheader']);
                $savepc->header = wra_admintable::getpost('fieldheader');
                $savepc->content = wra_admintable::getpost('fieldcontent');
//$savepc->link=$_POST['fieldlink'];
                $savepc->menuid = $_POST['fieldmenuid'];
                $savepc->infoid = $moreinfo->id;
                if ($saveid != -1) {
                    $savepc->update();
                } else {

                    $savepc->add();
                }
                $saveid = $savepc->id;
        }
        $moreinfo->saveobj($savepc->currentobjid, "wra_virtualpage");
        return $saveid;
    }

    static function getlist($count=255, $page=0) {//получить список
        $result = array();
        $wd = new wra_db();

        $wd->query = "SELECT `id`
 FROM `" . WRA_CONF::$db_prefix . "virtualpage`  LIMIT " . $page * $count . "," . $count . " ";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_virtualpage();
            $r0->loadid($u0[0]);
            $result[count($result)] = $r0;
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    static function updatebyid($id, $key, $value) {

        $wd = new wra_db();


        $wd->query = "UPDATE `" . WRA_CONF::$db_prefix . "virtualpage`
SET `$key`='$value' 
WHERE `id`='$id'";

        $wd->execute();
        $wd->close();
        unset($wd);
    }

    static function getvaluebyid($id, $key) {//получить значение по id и ключу
        $result = "";
        $wd = new wra_db();


        $wd->query = "SELECT `$key` FROM `" . WRA_CONF::$db_prefix . "virtualpage`
WHERE `id`='$id'";

        $wd->executereader();

        if ($u0 = $wd->read()) {


            $result = $u0[0];
        }

        $wd->close();
        unset($wd);
        return $result;
    }

    function add() {//добавление нового объекта

        if (!isset($this->creator_id)) {

            $this->creator_id = wra_userscontext::curuser();
        }

        $wd = new wra_db();
        $this->id = WRA::getnewkey("" . WRA_CONF::$db_prefix . 'virtualpage');
        $wd->query = "INSERT INTO `" . WRA_CONF::$db_prefix . "virtualpage` (
 `id`,
 `header`,
 `content`,
 `link`,
 `menuid`,
 `infoid`
 )VALUES(
 '$this->id',
 '$this->header',
 '$this->content',
 '$this->link',
 '$this->menuid',
 '$this->infoid'
 )";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();
        unset($wd);
        $this->currentobjid = wra_objects::addnewobject("wra_virtualpage", $this->id, $this->objectadres);
    }

    function update() {//обновление объекта


        $wd = new wra_db();
        $wd->query = "UPDATE `" . WRA_CONF::$db_prefix . "virtualpage`
SET 
 `id`='$this->id',
 `header`='$this->header',
 `content`='$this->content',
 `link`='$this->link',
 `menuid`='$this->menuid',
 `infoid`='$this->infoid'
 WHERE `id`='$this->id'";
        $wd->execute();
        $this->currentobjid = wra_objects::updateobject("wra_virtualpage", $this->id, $this->objectadres);
        $wd->close();
        unset($wd);
    }

    static function isexist($id) {//возвращает true, если объект с запрашиваемым id существует
        $result = false;
        $wd = new wra_db();


        $wd->query = "SELECT id FROM `" . WRA_CONF::$db_prefix . "virtualpage` WHERE `id` = '$id'";

        $wd->executereader();

        $result = ($u0 = $wd->read());

        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {//удаление объекта
        $wd = new wra_db();

        $wd->query = "DELETE FROM `" . WRA_CONF::$db_prefix . "virtualpage` where `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
        wra_objects::deleteobj($this->currentobjid);
        return true;
    }

    function loadid($id) {
        $this->id = $id;
    }

    function loadmore() {
        $this->load($this->id);
    }

    function load($id) {//загрузка объекта
        $wd = new wra_db();
        $this->id = $id;

        $wd->query = "SELECT 
 `id`,
 `header`,
 `content`,
 `link`,
 `menuid`,
 `infoid`
 FROM `" . WRA_CONF::$db_prefix . "virtualpage`  where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {

            $this->id = $u0[0];

            $this->header = $u0[1];

            $this->content = $u0[2];

            $this->link = $u0[3];

            $this->menuid = $u0[4];

            $this->infoid = $u0[5];
        }
        $wd->close();
        unset($wd);
        $this->currentobjid = wra_objects::getidbyitemid("wra_virtualpage", $this->id);
    }

    static function findbaseid($basemenu, $findlink) {
        $menulist = wra_menu::getlistbycat(wra_menu::getidbyname($basemenu));

        foreach ($menulist as $ml) {
            if ($ml->link == $findlink) {
                return $ml->id;
            } else
            if ($ml->childname != "") {

                if (wra_virtualpage::findbaseid($ml->childname, $findlink) != "") {
                    return $ml->menuname;
                }
            }
        }
        return "";
    }

    static function getbypath($path) {

        $result = new wra_virtualpage();
        $wd = new wra_db();


        $wd->query = "SELECT
                `id`

                FROM `" . WRA_CONF::$db_prefix . "virtualpage`
                WHERE `link`='$path'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $r0 = new wra_virtualpage();
            $r0->loadid($u0[0]);
            //  if($r0->header!="")
            $result = $r0;
        }
        $wd->close();
        unset($wd);
        return $result;
    }

}

?>
