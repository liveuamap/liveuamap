<?defined('WERUA') or include('../bad.php');
class wra_vku {

    static function vkd($vkid) {
        $_SESSION['wravkidamstor'] = $vkid;
        $_SESSION['wravkidamstor_second'] = md5(wra_fbu::getbrowser());
        setcookie('wravkidamstor', $_SESSION['wravkidamstor'], time() + WRA_CONF::$remembertime, '/');
        setcookie('wravkidamstor_second', $_SESSION['wravkidamstor_second'], time() + WRA_CONF::$remembertime, '/');
        return true;
    }

    static function isvkexist($vkuserid) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "vku` WHERE `vkuserid` = '$vkuserid'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    static function isvkd() {
        if (isset($_COOKIE['wravkidamstor']) && $_COOKIE['wravkidamstor'] != '') {
            if (isset($_COOKIE['wravkidamstor_second']) && $_COOKIE['wravkidamstor_second'] != '') {
                $_SESSION['wravkidamstor'] = $_COOKIE['wravkidamstor'];
                $_SESSION['wravkidamstor_second'] = $_COOKIE['wravkidamstor_second'];
            }
        }
        if (isset($_SESSION['wravkidamstor'])) {
            return true;
        }
        return false;
    }

    static function getbd() {
        if (isset($_COOKIE['wravkidamstor']) && $_COOKIE['wravkidamstor'] != '') {
            if (isset($_COOKIE['wravkidamstor_second']) && $_COOKIE['wravkidamstor_second'] != '') {
                $_SESSION['wravkidamstor'] = $_COOKIE['wravkidamstor'];
                $_SESSION['wravkidamstor_second'] = $_COOKIE['wravkidamstor_second'];
            }
        }
        if (isset($_SESSION['wravkidamstor'])) {
            return $_SESSION['wravkidamstor'];
        }
        return -1;
    }

    static function clearvkid() {
        setcookie('wravkidamstor', '', time() - 360000, '/');
        setcookie('wravkidamstor_second', '', time() - 360000, '/');
        unset($_SESSION['wravkidamstor']);
        unset($_SESSION['wravkidamstor_second']);
        unset($_COOKIE['wravkidamstor']);
        unset($_COOKIE['wravkidamstor_second']);
    }
    var $id;
    var $userid;
    var $vkuserid;
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
            fb0.vkuserid,
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
            FROM `' . WRA_CONF::$db_prefix . "vku` as fb0
             WHERE fb0.id='$saveid'";
        $c0 = new wra_column('id', column_type_id, 'id');
        $c0->defaultvalue = $saveid;
        $wt->addcolumn($c0);
        $c0 = new wra_column('Обнулить литры', column_type_customfield, 'litres');
        $c0->customfieldpage='parts/litres.php';
        $wt->addcolumn($c0);
        $c0 = new wra_column('Id пользователя', column_type_text, 'userid');
        $wt->addcolumn($c0);
        $c0 = new wra_column('Id пользователя на ВК', column_type_text, 'vkuserid');
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
         FROM `' . WRA_CONF::$db_prefix . "vku` as fb0 ORDER BY `points` desc ";
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
                $savepc = new wra_vku();
                if ($saveid != -1) {
                    $savepc->load($saveid);
                }
                $savepc->userid = wra_admintable::getpost('fielduserid');
                $savepc->vkuserid = wra_admintable::getpost('fieldvkuserid');
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
                FROM `' . WRA_CONF::$db_prefix . 'wra_vku`';
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_vku();
            $r0->loadid($u0[0]);
            $result = $u0[0];
        }
        $wd->close();
        return $result;
    }

    function add() {//добавление нового объекта
        $reg_date = time();
        $wd = new wra_db();
        $this->id = WRA::getnewkey("" . WRA_CONF::$db_prefix . 'vku');
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "vku` (
             `id`,
             `userid`,
             `vkuserid`,
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
             '$this->vkuserid',
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
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "vku`
            SET 
             `id`='$this->id',
             `userid`='$this->userid',
             `vkuserid`='$this->vkuserid',
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
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "vku`
            SET `$key`='$value' 
            WHERE `id`='$id'";
        $wd->execute();
        $wd->close();
    }

    static function updatebyemail($email, $key, $value) {
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "vku`
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
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "vku` WHERE `id` = '$id'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {//удаление объекта
        $wd = new wra_db();
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "vku` where `id`='$this->id'";
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
             `vkuserid`,
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
             FROM `' . WRA_CONF::$db_prefix . "vku`  where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->userid = $u0[1];
            $this->vkuserid = $u0[2];
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

    function loadbyvk($vkid) {//загрузка объекта
        $wd = new wra_db();
        $wd->query = 'SELECT 
             `id`,
             `userid`,
             `vkuserid`,
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
             FROM `' . WRA_CONF::$db_prefix . "vku`  where `vkuserid`='$vkid'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->userid = $u0[1];
            $this->vkuserid = $u0[2];
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