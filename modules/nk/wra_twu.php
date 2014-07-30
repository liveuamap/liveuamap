<?php  defined('WERUA') or include('../bad.php');
class wra_twu {

    static $accesslevel = array("admin");
    static function getacceslevel() {
        return self::$accesslevel;
    }
            static function adminit($wfadmin){
        $wfadmin->table='twu';
        $wfadmin->multilanguages=false;
       
//$wfadmin->columns[]=new admincolumn("String", "userid", "Забанен", admincolumntype::check, admincolumntype::check, 2);
 //$wfadmin->columns[]=new admincolumn("String", "banreason", "Причина бана", admincolumntype::text, admincolumntype::bigtext, 2);
       
$wfadmin->columns[]=new admincolumn("String", "twuserid", "twuserid", admincolumntype::text, admincolumntype::text, 2);
$wfadmin->columns[]=new admincolumn("String", "display_name", "Имя", admincolumntype::text, admincolumntype::text, 2);
$wfadmin->columns[]=new admincolumn("String", "link", "Ссылка", admincolumntype::text, admincolumntype::text, 2);
$wfadmin->columns[]=new admincolumn("DateTime", "reg_date", "Время регистрации", admincolumntype::datetime, admincolumntype::datetime, 2);
$wfadmin->columns[]=new admincolumn("String", "Email", "Email", admincolumntype::text, admincolumntype::text, 2);
//$wfadmin->columns[]=new admincolumn("String", "points", "Баллы", admincolumntype::text, admincolumntype::text, 2);
//$wfadmin->columns[]=new admincolumn("String", "position", "Этап", admincolumntype::text, admincolumntype::text, 2);

        $wfadmin->order = " order by points desc";

    }
    static function twd($twid, $userid) {
        $_SESSION['wratwidraftingbug'] = $twid;
        $_SESSION['wratwidraftingbug_second'] = md5(wra_fbu::getbrowser());
        setcookie('wratwidraftingbug', $_SESSION['wratwidraftingbug'], time() + WRA_CONF::$remembertime, '/');
        setcookie('wratwidraftingbug_second', $_SESSION['wratwidraftingbug_second'], time() + WRA_CONF::$remembertime, '/');
        $_SESSION['wrauserid'] = $userid;
        setcookie('wrauserid', $_SESSION['wrauserid'], time() + WRA_CONF::$remembertime, '/');
        return true;
    }

    static function istwexist($twuserid) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "twu` WHERE `twuserid` = '$twuserid'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    static function istwd() {
        if (isset($_COOKIE['wratwidraftingbug']) && $_COOKIE['wratwidraftingbug'] != '') {
            if (isset($_COOKIE['wratwidraftingbug_second']) && $_COOKIE['wratwidraftingbug_second'] != '') {
                $_SESSION['wratwidraftingbug'] = $_COOKIE['wratwidraftingbug'];
                $_SESSION['wratwidraftingbug_second'] = $_COOKIE['wratwidraftingbug_second'];
            }
        }
        if (isset($_SESSION['wratwidraftingbug'])) {
            return true;
        }
        return false;
    }

    static function getbd() {
        if (isset($_COOKIE['wratwidraftingbug']) && $_COOKIE['wratwidraftingbug'] != '') {
            if (isset($_COOKIE['wratwidraftingbug_second']) && $_COOKIE['wratwidraftingbug_second'] != '') {
                $_SESSION['wratwidraftingbug'] = $_COOKIE['wratwidraftingbug'];
                $_SESSION['wratwidraftingbug_second'] = $_COOKIE['wratwidraftingbug_second'];
            }
        }
        if (isset($_SESSION['wratwidraftingbug'])) {
            return $_SESSION['wratwidraftingbug'];
        }
        return -1;
    }

    static function cleartwid() {
        setcookie('wratwidraftingbug', '', time() - 360000, '/');
        setcookie('wratwidraftingbug_second', '', time() - 360000, '/');
        unset($_SESSION['wratwidraftingbug']);
        unset($_SESSION['wratwidraftingbug_second']);
        unset($_COOKIE['wratwidraftingbug']);
        unset($_COOKIE['wratwidraftingbug_second']);
    }
    var $id;
    var $userid;
    var $twuserid;
    var $display_name;
    var $regdate;
    var $username;
    var $usersurname;
    var $link;
    var $gender;
    var $photo;
    var $points;
    var $access_token;
    var $email;
    var $phone;
    var $adres;


    static function edittable($saveid = -1, $pid = -1) { //таблица редактирования для вывода в админке
        $wt = new wra_admintable();
        $wt->link = WRA::getcurpage();

        $wt->query = 'SELECT 
            fb0.id,fb0.userid,
            fb0.userid,
            fb0.twuserid,
            fb0.display_name,
            fb0.regdate,
            fb0.username,
            fb0.usersurname,
            fb0.link,
            fb0.gender,
            fb0.photo,
            fb0.points,
            fb0.access_token,
            fb0.email,
            fb0.phone,
            fb0.adres
            FROM `' . WRA_CONF::$db_prefix . "twu` as fb0
             WHERE fb0.id='$saveid'";
        $c0 = new wra_column('id', column_type_id, 'id');
        $c0->defaultvalue = $saveid;
        $wt->addcolumn($c0);
        $c0 = new wra_column('Обнулить литры', column_type_customfield, 'litres');
        $c0->customfieldpage='parts/litres.php';
        $wt->addcolumn($c0);
        $c0 = new wra_column('Id пользователя', column_type_text, 'userid');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Id пользователя на Одноклассниках', column_type_text, 'twuserid');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Отображаемое имя', column_type_text, 'display_name');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Дата регистрации', column_type_text, 'regdate');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Имя', column_type_text, 'username');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Фамилия', column_type_text, 'usersurname');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Ссылка на профиль', column_type_text, 'link');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Пол', column_type_text, 'gender');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Фотография', column_type_text, 'photo');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Литры', column_type_text, 'points');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Access Token', column_type_text, 'access_token');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Email ', column_type_text, 'email');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Телефон', column_type_text, 'phone');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Адрес', column_type_text, 'adres');
        $wt->addcolumn($c0);
        if ($saveid != -1) {
            $wt->load($saveid, $pid);
        } else {

            $wt->addnew($saveid, $pid);
        }
        return $wt;
    }
    var $position=0;
    static function admintable($saveid = -1, $pid = -1) { //таблица просмотра для вывода в админке
        $wt = new wra_admintable();
        $wt->link = WRA::getcurpage();
        $wt->query = 'SELECT id,
        CONCAT(fb0.username,\' \',fb0.usersurname),
        fb0.points,
        fb0.access_token,
        fb0.email,
        fb0.phone,
        fb0.adres
         FROM `' . WRA_CONF::$db_prefix . "twu` as fb0 ORDER BY `points` desc ";
        $c0 = new wra_column('id', column_type_id);
        $c0->defaultvalue = $saveid;
        $wt->addcolumn($c0);
        $c0 = new wra_column('', column_type_h2header);
        $wt->addcolumn($c0);
        $c0 = new wra_column('баллы', column_type_text);
        $wt->addcolumn($c0);
        $wt->load($saveid, $pid);
        return $wt;
    }
        function updatephotoplus() {//обновление объекта
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "twu`
            SET   
            `photoplus`='$this->photoplus'
             WHERE `id`='$this->id'";
      
        $wd->execute();
        // $this->currentobjid = wra_objects::updateobject('wra_fbu', $this->id, $this->objectadres);
        $wd->close();
        unset($wd);
    }
    function updatepp() {//обновление объекта
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "twu`
            SET   
            `team`='$this->position'
             WHERE `id`='$this->id'";
      
        $wd->execute();
        // $this->currentobjid = wra_objects::updateobject('wra_fbu', $this->id, $this->objectadres);
        $wd->close();
        unset($wd);
    }
    static function save($saveid = -1, $pid = -1, $adminedit = '') {//сохранение изменного (или добавляемого класса) для админки
        switch ($adminedit) {
            default:
                $savepc = new wra_twu();
                if ($saveid != -1) {
                    $savepc->load($saveid);
                }
                $savepc->userid = wra_admintable::getpost('fielduserid');
                $savepc->twuserid = wra_admintable::getpost('fieldtwuserid');
                $savepc->display_name = wra_admintable::getpost('fielddisplay_name');
                $savepc->regdate = wra_admintable::getpost('fieldregdate');
                $savepc->username = wra_admintable::getpost('fieldusername');
                $savepc->usersurname = wra_admintable::getpost('fieldusersurname');
                $savepc->link = wra_admintable::getpost('fieldlink');
                $savepc->gender = wra_admintable::getpost('fieldgender');
                $savepc->photo = wra_admintable::getpost('fieldphoto');
                $savepc->points = wra_admintable::getpost('fieldpoints');
                $savepc->access_token = wra_admintable::getpost('fieldaccess_token');
                $savepc->email = wra_admintable::getpost('fieldemail');
                $savepc->phone = wra_admintable::getpost('fieldphone');
                $savepc->adres = wra_admintable::getpost('fieldadres');
                if ($saveid != -1) {
                    // $savepc->update();
                } else {
                    // $savepc->add();
                }

                return $savepc->id;
        }
        return $saveid;
    }

    static function getcount($category) {//получить список
        $result = 0;
        $wd = new wra_db();

        $wd->query = 'SELECT count(`id`)
                FROM `' . WRA_CONF::$db_prefix . 'wra_twu`';
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_twu();
            $r0->loadid($u0[0]);
            $result = $u0[0];
        }
        $wd->close();
        return $result;
    }

    function add() {//добавление нового объекта
        $reg_date = time();
        $wd = new wra_db();
        $this->id = WRA::getnewkey("" . WRA_CONF::$db_prefix . 'twu');
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "twu` (
             `id`,
             `userid`,
             `twuserid`,
             `display_name`,
             `regdate`,
             `username`,
             `usersurname`,
             `link`,
             `gender`,
             `photo`,
             `points`,
             `access_token`,
             `email`,
             `phone`,
             `adres`,
             `reg_date`
             )VALUES(
             '$this->id',
             '$this->userid',
             '$this->twuserid',
             '$this->display_name',
             '$this->regdate',
             '$this->username',
             '$this->usersurname',
             '$this->link',
             '$this->gender',
             '$this->photo',
             '$this->points',
             '$this->access_token',
             '$this->email',
             '$this->phone',
             '$this->adres',
             '$reg_date'
             )";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();
        unset($wd);
    }

    function update() {//обновление объекта
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "twu`
            SET 
             `id`='$this->id',
             `userid`='$this->userid',
             `twuserid`='$this->twuserid',
             `display_name`='$this->display_name',
             `regdate`='$this->regdate',
             `username`='$this->username',
             `usersurname`='$this->usersurname',
             `link`='$this->link',
             `gender`='$this->gender',
             `photo`='$this->photo',
             `points`='$this->points',
             `access_token`='$this->access_token',
             `email`='$this->email',
             `phone`='$this->phone',
             `adres`='$this->adres'
             WHERE `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
    }
    
    static function updatebyid($id, $key, $value) {
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "twu`
            SET `$key`='$value' 
            WHERE `id`='$id'";
        $wd->execute();
        $wd->close();
    }

    static function updatebyemail($email, $key, $value) {
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "twu`
            SET `$key`='$value' 
            WHERE `email`='$email'";
        WRA::debug($wd->query);
        $wd->execute();
        $wd->close();
    }

    function addPoints($points) {
        $this->points += $points;
        self::updatebyid($this->id, 'points', $this->points);
    }
    static function isexist($wf,$id) {//возвращает true, если объект с запрашиваемым id существует
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "twu` WHERE `id` = '$id'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {//удаление объекта
        $wd = new wra_db();
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "twu` where `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
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

        $wd->query = 'SELECT 
             `id`,
             `userid`,
             `twuserid`,
             `display_name`,
             `regdate`,
             `username`,
             `usersurname`,
             `link`,
             `gender`,
             `photo`,
             `points`,
             `access_token`,
             `email`,
             `phone`,
             `adres`,`team`
             FROM `' . WRA_CONF::$db_prefix . "twu`  where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->userid = $u0[1];
            $this->twuserid = $u0[2];
            $this->display_name = $u0[3];
            $this->regdate = $u0[4];
            $this->username = $u0[5];
            $this->usersurname = $u0[6];
            $this->link = $u0[7];
            $this->gender = $u0[8];
            $this->photo = $u0[9];
            $this->points = $u0[10];
            $this->access_token = $u0[11];
            $this->email = $u0[12];
            $this->phone = $u0[13];
            $this->adres = $u0[14];
             $this->position = $u0[15];
        }
        $this->display_name=$this->username.' '.$this->usersurname;
        $wd->close();
        unset($wd);
    }

    function loadbyuserid($twid) {//загрузка объекта
        $wd = new wra_db();
        $wd->query = 'SELECT 
             `id`,
             `userid`,
             `twuserid`,
             `display_name`,
             `regdate`,
             `username`,
             `usersurname`,
             `link`,
             `gender`,
             `photo`,
             `points`,
             `access_token`,
             `email`,
             `phone`,
             `adres`,`team`
             FROM `' . WRA_CONF::$db_prefix . "twu`  where `twuserid`='$twid'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->userid = $u0[1];
            $this->twuserid = $u0[2];
            $this->display_name = $u0[3];
            $this->regdate = $u0[4];
            $this->username = $u0[5];
            $this->usersurname = $u0[6];
            $this->link = $u0[7];
            $this->gender = $u0[8];
            $this->photo = $u0[9];
            $this->points = $u0[10];
            $this->access_token = $u0[11];
            $this->email = $u0[12];
            $this->phone = $u0[13];
            $this->adres = $u0[14];
                $this->position = $u0[15];
        }
        $wd->close();
        unset($wd);       
    }    
    var $photoplus='';
        function loadbytw($twid) {//загрузка объекта
        $wd = new wra_db();
        $wd->query = 'SELECT 
             `id`,
             `userid`,
             `twuserid`,
             `display_name`,
             `regdate`,
             `username`,
             `usersurname`,
             `link`,
             `gender`,
             `photo`,
             `points`,
             `access_token`,
             `email`,
             `phone`,
             `adres`,`team`,`photoplus`
             FROM `' . WRA_CONF::$db_prefix . "twu`  where `twuserid`='$twid'";
        
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->userid = $u0[1];
            $this->twuserid = $u0[2];
            $this->display_name = $u0[3];
            $this->regdate = $u0[4];
            $this->username = $u0[5];
            $this->usersurname = $u0[6];
            $this->link = $u0[7];
            $this->gender = $u0[8];

            $this->photo = $u0[9];
            $this->points = $u0[10];
            $this->access_token = $u0[11];
            $this->email = $u0[12];
            $this->phone = $u0[13];
            $this->adres = $u0[14];
                $this->position = $u0[15];
                $this->photoplus=$u0[16];
        }
        $wd->close();
        unset($wd);       
    }    
}


?>