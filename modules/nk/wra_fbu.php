<?defined('WERUA') or include('../bad.php');
class wra_fbu extends wfbaseclass{
    static function updatepoints(){return;
        $result = array();
        $wd = new wra_db();
        $wd->query = 'SELECT sum(points),user_id FROM `wra_actions` group by user_id';
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_fbu();
            $r0->loadbyfb($u0[1]);
            $r0->points=$u0[0];
            $r0->update();
           
          
        }
        $wd->close();
        return $result;
    }
    static $accesslevel = array("admin");
    static function getacceslevel() {
        return self::$accesslevel;
    }
    function getlastorder(){
    $wd=new wra_db();
    $this->id = $id;
    $wd->query = 'SELECT 
     `id`,
     `status`,
     `user_id`,
     `pib`,
     `phone`,
     `adresa`,
     `amount`,
     `timefrom`,
     `timeto`,
     `adddate`,
     `ispomp`,
     `iscooler`,
     `isunder`,
     `isdispenser`,
     `isfirst`
     FROM `'.WRA_CONF::$db_prefix."orders`  where `user_id`='$this->fbuserid'
            order by `adddate` desc";
    $wd->executereader();
    $result=false; 
        if($u0=$wd->read()){
            $result=new wra_fbu();
            $result->id = $u0[0];
            $result->status = $u0[1];
            $result->user_id = $u0[2];
            $result->pib = $u0[3];
            $result->phone = $u0[4];
            $result->adresa = $u0[5];
            $result->amount = $u0[6];
            $result->timefrom = $u0[7];
            $result->timeto = $u0[8];
            $result->adddate = $u0[9];
            $result->ispomp = $u0[10];
            $result->iscooler = $u0[11];
            $result->isunder = $u0[12];
            $result->isdispenser = $u0[13];
            $result->isfirst = $u0[14];
        }
    $wd->close();
    return $result;
    }

    static function getbrowser() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    static function fbd($fbid) {
        $_SESSION['wrafbidamstor'] = $fbid;
        $_SESSION['wrafbidamstor_second'] = md5(wra_fbu::getbrowser());
        setcookie('wrafbidamstor', $_SESSION['wrafbidamstor'], time() + WRA_CONF::$remembertime, '/');
        setcookie('wrafbidamstor_second', $_SESSION['wrafbidamstor_second'], time() + WRA_CONF::$remembertime, '/');
        return true;
    }

    static function fbdorder($fbid) {
        $_SESSION['wrafboid'] = $fbid;
        setcookie('wrafboid', $_SESSION['wrafboid'], time() + WRA_CONF::$remembertime, '/');
        return true;
    }

    static function clearfbid() {
        setcookie('wrafbidamstor', '', time() - 360000, '/');
        setcookie('wrafbidamstor_second', '', time() - 360000, '/');
        unset($_SESSION['wrafbidamstor']);
        unset($_SESSION['wrafbidamstor_second']);
        unset($_COOKIE['wrafbidamstor']);
        unset($_COOKIE['wrafbidamstor_second']);
    }
    static function getbd() {
        if (isset($_COOKIE['wrafbidamstor']) && $_COOKIE['wrafbidamstor'] != '') {
            if (isset($_COOKIE['wrafbidamstor_second']) && $_COOKIE['wrafbidamstor_second'] != '') {
                $_SESSION['wrafbidamstor'] = $_COOKIE['wrafbidamstor'];
                $_SESSION['wrafbidamswrafbidamstor_secondtor'] = $_COOKIE['wrafbidamstor_second'];
            }
        }
        if (isset($_SESSION['wrafbidamstor'])) {
            return $_SESSION['wrafbidamstor'];
        }
        return -1;
    }
    static function getbdorder() {
        if (isset($_COOKIE['wrafboid']) && $_COOKIE['wrafboid'] != '') {
            $_SESSION['wrafboid'] = $_COOKIE['wrafboid'];
        }
        if (isset($_SESSION['wrafboid'])) {
            return $_SESSION['wrafboid'];
        }
        return -1;
    }
    static function isfbd() {
        if (isset($_COOKIE['wrafbidamstor']) && $_COOKIE['wrafbidamstor'] != '') {
            if (isset($_COOKIE['wrafbidamstor_second']) && $_COOKIE['wrafbidamstor_second'] != '') {
                $_SESSION['wrafbidamstor'] = $_COOKIE['wrafbidamstor'];
                $_SESSION['wrafbidamstor_second'] = $_COOKIE['wrafbidamstor_second'];
            }
        }
        if (isset($_SESSION['wrafbidamstor'])) {
            return true;
        }
        return false;
    }
    static function isfbdorder() {
        if (isset($_COOKIE['wrafboid']) && $_COOKIE['wrafboid'] != '') {
            $_SESSION['wrafboid'] = $_COOKIE['wrafboid'];
        }
        if (isset($_SESSION['wrafboid'])) {
            return true;
        }
        return false;
    }
    static function getfbexistid($fbuserid) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "fbu` WHERE `fbuserid` = '$fbuserid'";
        $wd->executereader();
        if ($u0 = $wd->read())
            $result = $u0['id'];
        $wd->close();
        unset($wd);
        return $result;
    }

    static function isfbexist($fbuserid) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "fbu` WHERE `fbuserid` = '$fbuserid'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

//класс
    // var $objectadres = '';
    // var $currentobjid = -1;
    // var $curobj = null;

    // function gobj() {
        // if ($this->curobj == null) {
            // $this->curobj = new wra_objects();

            // $this->curobj->load($this->currentobjid);
            // return $this->curobj;
        // }else
            // return $this->curobj;
    // }

    var $id;
    var $userid;
    var $fbuserid;
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

    function wra_fbu() {
        
    }

    static function deletecase($dcase, $did) {//удаление класса
        switch ($dcase) {
            default:
                return true;
        }

        return false;
    }

    static function edittable($saveid = -1, $pid = -1) { //таблица редактирования для вывода в админке
        $wt = new wra_admintable();
        $wt->link = WRA::getcurpage();

        $wt->query = 'SELECT 
            fb0.id,fb0.userid,
            fb0.userid,
            fb0.fbuserid,
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
            FROM `' . WRA_CONF::$db_prefix . "fbu` as fb0
             WHERE fb0.id='$saveid'";
        $c0 = new wra_column('id', column_type_id, 'id');
        $c0->defaultvalue = $saveid;
        $wt->addcolumn($c0);
        $c0 = new wra_column('Обнулить литры', column_type_customfield, 'litres');
        $c0->customfieldpage='parts/litres.php';
        $wt->addcolumn($c0);
        $c0 = new wra_column('Id пользователя', column_type_text, 'userid');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Id пользователя на фейсбук', column_type_text, 'fbuserid');
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
         FROM `' . WRA_CONF::$db_prefix . "fbu` as fb0 ORDER BY `points` desc ";
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

    static function save($saveid = -1, $pid = -1, $adminedit = '') {//сохранение изменного (или добавляемого класса) для админки
        switch ($adminedit) {
            default:
                $savepc = new wra_fbu();
                if ($saveid != -1) {
                    $savepc->load($saveid);
                }
                $savepc->userid = wra_admintable::getpost('fielduserid');
                $savepc->fbuserid = wra_admintable::getpost('fieldfbuserid');
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
                    $savepc->update();
                } else {
                    $savepc->add();
                }

                return $savepc->id;
        }
        return $saveid;
    }

    static function getcount($category) {//получить список
        $result = 0;
        $wd = new wra_db();

        $wd->query = 'SELECT count(`id`)
                FROM `' . WRA_CONF::$db_prefix . 'wra_fbu`';
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_wra_fbu();
            $r0->loadid($u0[0]);
            $result = $u0[0];
        }
        $wd->close();
        return $result;
    }
    static function getlistexcel() {//получить полный список
        $result = array();
        $wd = new wra_db();

        $wd->query = 'SELECT 
             `id`,
             `userid`,
             `fbuserid`,
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
             `adres`
             FROM `' . WRA_CONF::$db_prefix . "fbu` 
                 order by points desc";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_fbu();
            $r0->id = $u0[0];
            $r0->userid = $u0[1];
            $r0->fbuserid = $u0[2];
            $r0->display_name = $u0[3];
            $r0->regdate = $u0[4];
            $r0->username = $u0[5];
            $r0->usersurname = $u0[6];
            $r0->link = $u0[7];
            $r0->gender = $u0[8];
            $r0->photo = $u0[9];
            $r0->points = $u0[10];
            $r0->access_token = $u0[11];
            $r0->email = $u0[12];
            $r0->phone = $u0[13];
            $r0->adres = $u0[14];
            // $r0->currentobjid = wra_objects::getidbyitemid('wra_fbu', $r0->id);
            $result[count($result)] = $r0;
        }
        $wd->close();
        return $result;
    }

    static function getlistfull($count = 6, $page = 0) {//получить полный список
        $result = array();
        $wd = new wra_db();
        $wd->query = 'SELECT 
             `id`,
             `userid`,
             `fbuserid`,
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
             `adres`
             FROM `' . WRA_CONF::$db_prefix . "fbu` 
                 order by points desc
             LIMIT " . $page * $count . "," . $count . "";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_fbu();
            $r0->id = $u0[0];
            $r0->userid = $u0[1];
            $r0->fbuserid = $u0[2];
            $r0->display_name = $u0[3];
            $r0->regdate = $u0[4];
            $r0->username = $u0[5];
            $r0->usersurname = $u0[6];
            $r0->link = $u0[7];
            $r0->gender = $u0[8];
            $r0->photo = $u0[9];
            $r0->points = $u0[10];
            $r0->access_token = $u0[11];
            $r0->email = $u0[12];
            $r0->phone = $u0[13];
            $r0->adres = $u0[14];
            // $r0->currentobjid = wra_objects::getidbyitemid('wra_fbu', $r0->id);
            $result[count($result)] = $r0;
        }
        $wd->close();
        return $result;
    }
    static function getlistfbids() {//получить список
        $result = array();
        $wd = new wra_db();

        $wd->query = 'SELECT `fbuserid`
             FROM `' . WRA_CONF::$db_prefix . "fbu` order by points desc";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            array_push($result, $u0[0]);
        }
        $wd->close();
        return $result;
    }
    static function getlist() {//получить список
        $result = array();
        $wd = new wra_db();

        $wd->query = 'SELECT `id`
            FROM `' . WRA_CONF::$db_prefix . "fbu` order by points desc";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_fbu();
            $r0->loadid($u0[0]);
            $result[count($result)] = $r0;
        }
        $wd->close();
        return $result;
    }
    static function updatep($userid, $points) {

        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "fbu`
                SET `points`=`points`+ $points
                WHERE `fbuserid`='$userid'";
        $wd->execute();
        $wd->close();
        echo $wd->query.'hi<BR/>';
    }
    static function updatebyid($id, $key, $value) {
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "fbu`
            SET `$key`='$value' 
            WHERE `id`='$id'";
        $wd->execute();
        $wd->close();
    }

    static function updatebyemail($email, $key, $value) {
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "fbu`
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

    static function getvaluebyid($id, $key) {//получить значение по id и ключу
        $result = '';
        $wd = new wra_db();
        $wd->query = 'SELECT `$key` FROM `' . WRA_CONF::$db_prefix . "fbu`
            WHERE `id`='$id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        return $result;
    }

    function add() {//добавление нового объекта
        if (!isset($this->creator_id)) {

            $this->creator_id = wra_userscontext::curuser();
        }

    
        $reg_date = time();

        $wd = new wra_db();
        $this->id = WRA::getnewkey("" . WRA_CONF::$db_prefix . 'fbu');
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "fbu` (
             `id`,
             `userid`,
             `fbuserid`,
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
             '$this->fbuserid',
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
        // $this->currentobjid = wra_objects::addnewobject('wra_fbu', $this->id, $this->objectadres);
        unset($wd);
    }

    function update() {//обновление объекта
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "fbu`
            SET 
             `id`='$this->id',
             `userid`='$this->userid',
             `fbuserid`='$this->fbuserid',
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
        // $this->currentobjid = wra_objects::updateobject('wra_fbu', $this->id, $this->objectadres);
        $wd->close();
        unset($wd);
    }

    static function isexist($wf,$id) {//возвращает true, если объект с запрашиваемым id существует
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "fbu` WHERE `id` = '$id'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    function litres($max){
        $result='litres0';
        $max=18900;
    //    if($max>0)
        if($this->points/$max>0.9){
            $result='litres100';
        } else  if($this->points/$max>0.8){
            $result='litres90';
        }else  if($this->points/$max>0.7){
            $result='litres80';
        }else  if($this->points/$max>0.6){
            $result='litres70';
        }else  if($this->points/$max>0.5){
            $result='litres60';
        }else  if($this->points/$max>0.4){
            $result='litres50';
        }else  if($this->points/$max>0.3){
            $result='litres40';
        }else  if($this->points/$max>0.2){
            $result='litres30';
        }else  if($this->points/$max>0.1){
            $result='litres20';
        }else  if($this->points>0){
            $result='litres10';
        }
        
        return $result;
        
    }
    static function getmax() {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT max(points) as \'id\' FROM `' . WRA_CONF::$db_prefix . "fbu`";
        $wd->executereader();
        if ($u0 = $wd->read())
            $result = $u0['id'];

        $wd->close();
        unset($wd);
        return $result;
    }
    static function getexistid($id) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "fbu` WHERE `id` = '$id'";
        $wd->executereader();
        if ($u0 = $wd->read())
            $result = $u0['id'];

        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {//удаление объекта
        $wd = new wra_db();
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "fbu` where `id`='$this->id'";
        $wd->execute();
        $wd->close();
        // wra_objects::deleteobj($this->currentobjid);
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
             `fbuserid`,
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
             `adres`
             FROM `' . WRA_CONF::$db_prefix . "fbu`  where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->userid = $u0[1];
            $this->fbuserid = $u0[2];
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
        }
        $wd->close();
        unset($wd);
        // $this->currentobjid = wra_objects::getidbyitemid('wra_fbu', $this->id);
    }
 function loadbyfb($fbid) {//загрузка объекта
        $wd = new wra_db();
        $wd->query = 'SELECT 
             `id`,
             `userid`,
             `fbuserid`,
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
             `adres`
             FROM `' . WRA_CONF::$db_prefix . "fbu`  where `fbuserid`='$fbid'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->userid = $u0[1];
            $this->fbuserid = $u0[2];
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
        }
        $wd->close();
        unset($wd);
       
    }
}

?>