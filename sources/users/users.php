<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_users extends wfbaseclass{
    var $wf;
    var $id;
    var $login;
    var $email;
    var $password;
    var $active;
    var $displayname;
    var $bday;
    var $description;
    var $gender;
    var $interests;
    var $infor;
    var $namei;
    var $namef;
    var $nameo;
    var $cellphone;
    var $cityid;
    var $lasttime;
    var $dolg;
    var $icq;
    var $twitter;
    var $web;
    var $avatar;
    var $adresid;
    var $groupid;
    var $curadres;
    var $adres;
    var $tmbavatar;
    var $company;
    var $ismain;
    var $fromwhere;
    var $signin;
    var $discount;
    static $accesslevel = array("admin");
    static function getacceslevel() {
        return self::$accesslevel;
    }

    static function adminit($wfadmin){
        // $teachers = wra_teachers::get_drop("_ru");
        
        $wfadmin->table='users';
        $wfadmin->multilanguages=false;
        $wfadmin->columns[]=new admincolumn("String", "login", "Логин", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "email", "E-mail", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "password", "Пароль", admincolumntype::none, admincolumntype::password, 2);
        $wfadmin->columns[]=new admincolumn("String", "displayname", "Отображаемое имя", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "namef", "Фамилия", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "namei", "Имя", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "nameo", "Отчество", admincolumntype::none, admincolumntype::text, 2);
        // $wfadmin->columns[]=new admincolumn("String", "cellphone", "Телефон", admincolumntype::text, admincolumntype::text, 2);
        // $wfadmin->columns[]=new admincolumn("String", "adres", "Адрес", admincolumntype::text, admincolumntype::bigtext, 2);
        // $wfadmin->columns[]=new admincolumn("String", "teacherid", "Преподаватель", admincolumntype::fromdrop, admincolumntype::dropdown, 2, $teachers);
        $rightscolumn=new admincolumn("String", "rights", "Права", admincolumntype::none, admincolumntype::multiselect, 2,wra_rights::getlist());
       
        $rightscolumn->sqlfield='id';
        $rightscolumn->multiselect=new wra_multiselect('usersrights','user_id','right_id');
        $wfadmin->columns[]=$rightscolumn;
        // $wfadmin->columns[]=new admincolumn("String", "semestr", "Программа обучения", admincolumntype::fromdrop, admincolumntype::dropdown, 2, wra_program::get_drop("_ru"));
        // $wfadmin->columns[]=new admincolumn("String", "balancemonth", "Остаток (Месяц)", admincolumntype::fromdrop, admincolumntype::dropdown, 2, WRA::getmonthdropdown_ru());
        // $wfadmin->columns[]=new admincolumn("String", "balanceday", "Остаток (Дней)", admincolumntype::text, admincolumntype::text, 2);
        // $wfadmin->columns[]=new admincolumn("String", "discount", "Скидка(%)", admincolumntype::text, admincolumntype::text, 2);
       
        $wfadmin->order = " order by signin desc";

    }

    static function get_list($lang='', $start=0, $count = 0) {
        $result = array();
        $wd=new wra_db();
        $wd->query = "SELECT 
        p.id,concat(p.namei,' ',p.namef)
        FROM `".WRA_CONF::$db_prefix."users` AS p
        ORDER by p.id asc";
        // WRA::debug($wd->query);
        if (!empty($start)&&!empty($count)){
            $start = $count*($page-1);
            $end = $count;
        }
        // $wd->query.= " LIMIT $start,$end";
        $wd->executereader();
        while($u0=$wd->read()){
            $result[$u0[0]]= $u0[1];
        }
        $wd->close();
        unset($wd);
        // WRA::debug($result);
        return $result;
    }

    static function save($saveid=-1, $pid=-1, $adminedit='') {
        switch ($adminedit) {
            case 'rightsedit':
                $savepc = new wra_users();
                if ($saveid != -1) {
                    $savepc->load($saveid);
                }
                $savepc->addright(WRA::p('rightsedit-fieldright_id'));
                return $savepc->id;
            default:
                $savepc = new wra_users();
                if ($saveid != -1) {
                    $savepc->load($saveid);
                }
                $savepc->login = htmlspecialchars($_POST['fieldlogin']);
                $savepc->email = htmlspecialchars($_POST['fieldemail']);
                if ($_POST['fieldpassworder'] != '')
                    $savepc->password = md5($_POST['fieldpassworder']);
                $savepc->active = wra_admintable::getcheck('fieldactive');
                $savepc->displayname = htmlspecialchars($_POST['fielddisplayname']);

                if (WRA::p('delpicvalue-fieldavatar') == 'delete') {

                    $savepc->avatar = '';
                    $savepc->tmbavatar = '';
                }
                if (isset($_FILES['fieldavatar'])) {
                    if ($_FILES['fieldavatar']['size'] != 0) {
                        $wf = new wra_uploadedfile(WRA_Path);
                        $wf->uploaddir.='users/';

                        $wf->addvalidtype('jpg');
                        $wf->addvalidtype('gif');
                        $wf->addvalidtype('png');

                        $wf->upload('fieldavatar', true);
                        $wf->getimageinfo();
                        $wf->createavatar();
                        if ($wf->error == '') {
                            $savepc->avatar = 'upload/users/' . $wf->filename;
                            $savepc->tmbavatar = 'upload/users/' . $wf->tmbfilename;
                        } else {
                            $ismessage = true;
                            switch ($wf->error) {
                                case 'sizeimage':
                                    $adminmessage = 'Неправильные пропорции картинки';
                                    break;
                                case 'maxsize':
                                    $adminmessage = 'Слишком большая картинка';
                                    break;
                                case 'fileext':
                                    $adminmessage = 'Это расширение не подходит, могут быть загружены файлы JPG,PNG,GIF';
                                    break;

                                default:
                                    $adminmessage = 'Ошибка загрузки аватара';
                                    break;
                            }
                        }
                    }
                }
                if ($saveid != -1) {
                    $savepc->update();
                } else {
                    $savepc->add();
                }
                wra_admintable::savemultipleclass('fielduserrights', $saveid, 'wra_usersrights', 'right_id');
                return $savepc->id;
        }
        return $saveid;
    }

    function updatesetting($key, $value) {
        wra_usersetting::updatebyid($this->id, $key, $value);
    }

    function getsetting($key) {
        wra_usersetting::getvaluebyid($this->id, $key);
    }

    function getgroup() {
        $result = new wra_usersgroups();
        $result->load($this->groupid);
        return $result;
    }

    static function isexist($wf,$id) {
        return wra_userscontext::isidexist($wf,$id);
    }

    function wra_users($wf=null) {
         $this->wf=$wf;
        $this->login = '';
        $this->email = '';
        $this->password = '';
        $this->active = 0;
        $this->displayname = '';
        $this->namei = '';
        $this->namef = '';
        $this->nameo = '';
        $this->cellphone = '';
        $this->dolg = '';
        $this->icq = '';
        $this->twitter = '';
        $this->web = '';
        $this->avatar = '';
        $this->adres = '';
        $this->tmbavatar = '';
        $this->issotr = 0;
        $this->company = '';
    }

    static function deleterightbyid($rid) {
        $wd = new wra_db($wf);
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "usersrights` 
				WHERE `id`='$rid' ";
        $wd->execute();
        $wd->close();
        unset($wd);
    }

    function allrights() {
        $result = array();
        $wd = new wra_db($wf);
        $wd->query = 'SELECT 
				`right_id`
				FROM `' . WRA_CONF::$db_prefix . "usersrights` where `user_id`='$this->id'";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $result[count($result)] = new wra_right();
            $result[count($result) - 1]->load($u0[0]);
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    function hasright($rightid) {
        $result = false;
        $wd = new wra_db($wf);
        $wd->query = 'SELECT 
				`right_id`
				FROM `' . WRA_CONF::$db_prefix . "usersrights` where `user_id`='$this->id' and `right_id`='$rightid'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = true;
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    function addright($rightid) {
        if ($this->hasright($rightid))
            return;
        $wd = new wra_db($wf);
        $id = WRA::getnewkey('' . WRA_CONF::$db_prefix . 'usersrights');
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "usersrights` (
				`id`,
				`user_id`,
				`right_id`
				)VALUES(
				'$id',
				'$this->id',
				'$rightid')";
        $wd->execute();
        //if(!WRA_CONF::$usegetkey) $this->id=$wd->getlastkey();
        $wd->close();
        unset($wd);
    }

    function deleteright($rightid) {
        $wd = new wra_db($wf);
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "usersrights` 
				WHERE `user_id`='$this->id' and `right_id`='$rightid' ";
        $wd->execute();
        $wd->close();
        unset($wd);
    }

    function getrights() {
        $result = array();
        $wd = new wra_db($wf);
        $wd->query = 'SELECT 
				`right_id`
				FROM `' . WRA_CONF::$db_prefix . "usersrights` where `user_id`='$this->id'";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $ng = new wra_right();
            $ng->load($u0[0]);
            $result[count($result)] = $ng;
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    function add() {
        $wd = new wra_db($wf);
        if (!isset($this->id))
            $this->id = WRA::getnewkey('' . WRA_CONF::$db_prefix . 'users');
        $this->lasttime = WRA::getcurtime();
        $wd->query = 'INSERT INTO  `' . WRA_CONF::$db_prefix . "users` (  `id` ,  `login` ,  `email` ,  `password` ,  `active` ,  `displayname` ,  `namei` ,  `namef` ,  `nameo` ,  `cellphone` ,  `cityid` ,  `lasttime` ,  `dolg` ,  `icq` ,  `twitter` ,  `web`,`adresid`,`groupid`,`avatar`,`adres`
				,`tmbavatar`,`issotr`,`company`,`bday`,`description`,`gender`,`interests`,`infor`,`fromwhere`,`signin` ) 
		VALUES (
				'$this->id' ,  '$this->email' ,  '$this->email' ,  '$this->password' ,  '$this->active' ,  '$this->displayname' ,  '$this->namei' ,  '$this->namef' ,  '$this->nameo' ,  '$this->cellphone' ,  '$this->cityid' ,  '$this->lasttime' ,  '$this->dolg' ,  '$this->icq' ,  '$this->twitter' ,  '$this->web' ,'$this->adresid','$this->groupid','$this->avatar','$this->adres'
				,'$this->tmbavatar','$this->issotr','$this->company','$this->bday','$this->description','$this->gender','$this->interests','$this->infor','$this->fromwhere','$this->signin'
		);";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();
        unset($wd);
    }

    static function updatebyid($id, $key, $value) {
        $wd = new wra_db($wf);
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "users`
				SET    `$key`='$value' 
				WHERE `id`='$id'";
        $wd->execute();
        $wd->close();
        unset($wd);
    }

    static function getvaluebyid($id, $key) {
        $result = '';
        $wd = new wra_db($wf);
        $wd->query = 'SELECT `$key` FROM `' . WRA_CONF::$db_prefix . "users`
							WHERE `id`='$id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {//удаление пользователя
        if (wra_userscontext::curuser() != $this->id) {
            $wd = new wra_db($wf);
            $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "users`
    		    WHERE `id`='$this->id' 
				    ";
            $wd->execute();
            $wd->close();
            unset($wd);
            return true;
        }
        return false;
    }

    function update() {
        $wd = new wra_db($wf);
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "users`
				SET    `login`='$this->login'  ,  `email`='$this->email' , 
				`password`='$this->password' ,  `active`= '$this->active' , 
				`displayname` ='$this->displayname',  `namei`= '$this->namei' ,  `namef`='$this->namef'  ,
				`nameo`='$this->nameo' ,  `cellphone`= '$this->cellphone' ,  `cityid`='$this->cityid'  ,
				`lasttime`='$this->lasttime'  ,  `dolg`='$this->dolg' ,  `icq`='$this->icq'  ,  `twitter`='$this->twitter' ,  `web`='$this->web'  ,
				`adresid`='$this->adresid', `groupid`='$this->groupid', `avatar`='$this->avatar',`adres`='$this->adres', `tmbavatar`='$this->tmbavatar',
				`issotr`='$this->issotr',`company`='$this->company',
				`bday`='$this->bday',`description`='$this->description',`gender`='$this->gender',
				`interests`='$this->interests',`infor`='$this->infor',
				`fromwhere`='$this->fromwhere',`signin`='$this->signin',`discount`='$this->discount'
		WHERE `id`='$this->id' 
				";
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

    function load($id=-1) {
        $wd = new wra_db();
        $wd->query = 'select login, email, password, active, displayname,
			 namei, namef, nameo, cellphone, cityid, lasttime, dolg, icq, twitter, web,id,adresid,groupid,avatar,adres,tmbavatar,`issotr`,`company` 
			 ,`bday`,`description`,`gender`,`interests`,`infor`,`fromwhere`,`signin`,`discount`,`teacherid`,`semestr`,`balancemonth`,`balanceday`
			 from ' . WRA_CONF::$db_prefix . 'users where id=' . $id;
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->login = $u0[0];
            $this->email = $u0[1];
            $this->password = $u0[2];
            $this->active = $u0[3];
            $this->displayname = $u0[4];
            $this->namei = $u0[5];
            $this->namef = $u0[6];
            $this->nameo = $u0[7];
            $this->cellphone = $u0[8];
            $this->cityid = $u0[9];
            $this->lasttime = $u0[10];
            $this->dolg = $u0[11];
            $this->icq = $u0[12];
            $this->twitter = $u0[13];
            $this->web = $u0[14];
            $this->id = $u0[15];
            $this->adresid = $u0[16];
            $this->groupid = $u0[17];
            $this->avatar = $u0[18];
            $this->adres = $u0[19];
            $this->tmbavatar = $u0[20];
            $this->issotr = $u0[21];
            $this->company = $u0[22];
            $this->bday = $u0[23];
            $this->description = $u0[24];
            $this->gender = $u0[25];
            $this->interests = $u0[26];
            $this->infor = $u0[27];
            $this->fromwhere = $u0[28];
            $this->signin = $u0[29];//подписка
            $this->discount = $u0[30];
            $this->teacherid = $u0[31];
            $this->semestr = $u0[32];
            $this->balancemonth = $u0[33];
            $this->balanceday = $u0[34];
        }

        $wd->close();
        unset($wd);
    }

    function getloginbyid($id) {
        $result = 0;
        $wd = new wra_db($wf);
        $wd->query = 'select login from ' . WRA_CONF::$db_prefix . "users where id='" . $id . "'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }
 function getnamebyid($id) {
        $result = 0;
        $wd = new wra_db($wf);
        $wd->query = 'select displayname from ' . WRA_CONF::$db_prefix . "users where id='" . $id . "'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }

        $wd->close();
        unset($wd);
        return $result;
    }
    static function getidbyemail($wf, $email) {
        $result = 0;
        $wd = new wra_db($wf);
        $wd->query = 'select id from ' . WRA_CONF::$db_prefix . "users where email='" . $email . "'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }
    static function getidbyphone($wf, $phone) {
        $result = 0;
        $wd = new wra_db($wf);
        $wd->query = 'select id from ' . WRA_CONF::$db_prefix . "users where cellphone='" . $phone . "'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    static function getidbylogin($wf,$login) {
        $result = 0;
        $wd = new wra_db($wf);
        $wd->query = 'select id from ' . WRA_CONF::$db_prefix . "users where login='" . $login . "'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    function loadbyid($id) {
        $this->load($id);
    }

    function loadbyemail($email) {
        $id = wra_users::getidbyemail($email);
        $this->load($id);
    }

    static function create_password($lenght = 7) {
        $chars = 'abcdefghijkmnopqrstuvwxyz023456789';
        srand((double) microtime() * 1000000);
        $pass = '';
        for ($i = 0; $i < $lenght; $i++) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
        }
        return $pass;
    }

    static function checkCode($input_code,$input_email) {
        return $input_code === self::getRightCode($input_email);
    }

    static function getRightCode($input_email){
        $right_code = substr(md5($input_email),0,5);
        // WRA::debug($input_email);
        // WRA::debug($right_code);
        return $right_code;
    }

    static function acceptCode(){
        $args = func_get_args();
        $wf = array_shift($args);
        $input_code = array_shift($args);
        $input_email = array_shift($args);
        $correct_code = (bool)self::checkCode($input_code,$input_email);
        if ($correct_code){
            $user = new wra_users();
            $user->load(self::getidbyemail($wf, $input_email));
            // WRA::debug($user);
            if (empty($user->active)) {
                $user->active = 1;
                $user->update();
            }
        }
        return $correct_code;
    }

}


?>