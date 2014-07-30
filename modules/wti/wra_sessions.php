<?php

defined('WERUA') or include('../../bad.php');

class wra_sessions extends wfbaseclass {

    var $id;
    var $sessionid;
    var $user_id;
    var $begintime;
    var $ip;var $browser;
     static function get_currentsession($user_id){
     
        $ws=new wra_sessions($user_id);
        $ws->load(session_id());
       
        if(empty($ws->id)){
            $ws->begintime=time();
            $ws->ip=WRA::getip();
            $ws->sessionid=session_id();
            $ws->browser=$_SERVER['HTTP_USER_AGENT'];
            $ws->add();
        }
        return $ws;
    }
    function wra_sessions($user_id) {
        $this->user_id=$user_id;
    }

    static function adminit($wfadmin) {
        $wfadmin->table = 'sessions';
        $wfadmin->multilanguages = false;
        $wfadmin->columns[] = new admincolumn("String", "id", "id", admincolumntype::text, admincolumntype::text, 1);
        $wfadmin->columns[] = new admincolumn("String", "sessionid", "sessionid", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[] = new admincolumn("String", "user_id", "user_id", admincolumntype::text, admincolumntype::text, 3);
        $wfadmin->columns[] = new admincolumn("String", "begintime", "begintime", admincolumntype::text, admincolumntype::text, 4);
        $wfadmin->columns[] = new admincolumn("String", "ip", "ip", admincolumntype::text, admincolumntype::text, 5);
        $wfadmin->order = " order by id asc";
    }

    static function getcount($category) {
        $result = 0;
        $wd = new wra_db();

        $wd->query = 'SELECT count(`id`)
 FROM `' . WRA_CONF::$db_prefix . 'wra_sessions`';
        $wd->executereader();
        while ($u0 = $wd->read()) {

            $result = $u0[0];
        }
        $wd->close();
        return $result;
    }

    static function get_list($count = 10, $page = 0) {
        $result = array();
        $wd = new wra_db();

        $wd->query = 'SELECT 
 `id`,
 `sessionid`,
 `user_id`,
 `begintime`,
 `ip`
 FROM `' . WRA_CONF::$db_prefix . "sessions` 
 LIMIT " . $page * $count . "," . $count . "";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_sessions();
            $r0->id = $u0[0];

            $r0->sessionid = $u0[1];

            $r0->user_id = $u0[2];

            $r0->begintime = $u0[3];

            $r0->ip = $u0[4];




            $result[] = $r0;
        }
        $wd->close();
        return $result;
    }

    function add() {
        $wd = new wra_db();
        $this->id = WRA::getnewkey("" . WRA_CONF::$db_prefix . 'sessions');
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "sessions` (
         `id`,
         `sessionid`,
         `user_id`,
         `begintime`,
         `ip`
         )VALUES(
         '$this->id',
         '$this->sessionid',
         '$this->user_id',
         '$this->begintime',
         '$this->ip'
         )";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();
        unset($wd);
    }

    function update() {


        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "sessions`
SET 
 `id`='$this->id',
 `sessionid`='$this->sessionid',
 `user_id`='$this->user_id',
 `begintime`='$this->begintime',
 `ip`='$this->ip'
 WHERE `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
    }

    static function isexist($id, $lang = 'ru') {
        $result = false;
        $wd = new wra_db();


        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "sessions` WHERE `id` = '$id'";

        $wd->executereader();

        if ($u0 = $wd->read())
            $result = $u0['id'];

        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {
        $wd = new wra_db();

        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "sessions` where `id`='$this->id'";
        $wd->execute();
        $wd->close();

        unset($wd);
        return true;
    }

    function load($sessionid) {
        $wd = new wra_db();
        $this->id = $id;
$this->sessionid=$sessionid;
        $wd->query = 'SELECT 
 `id`,
 `sessionid`,
 `user_id`,
 `begintime`,
 `ip`
 FROM `' . WRA_CONF::$db_prefix . "sessions`  where `sessionid`='$this->sessionid'";
       
        $wd->executereader();
        if ($u0 = $wd->read()) {

            $this->id = $u0[0];

            $this->sessionid = $u0[1];

            $this->user_id = $u0[2];

            $this->begintime = $u0[3];

            $this->ip = $u0[4];
        }
        $wd->close();
        unset($wd);
    }

}

?>
