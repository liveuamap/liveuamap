<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_usersrights extends wfbaseclass{

//класс
    var $id;
    var $user_id;
    var $right_id;

    function wra_usersrights() {
        
    }


    static function addinlist($user_id, $right_id) {
        $newitem = new wra_usersrights();
        $newitem->user_id = $user_id;
        $newitem->right_id = $right_id;
        $newitem->add();
    }

    static function getlist($userid) {//получить список
        $result = array();
        $wd = new wra_db();

        $wd->query = 'SELECT `id`,right_id
                FROM `' . WRA_CONF::$db_prefix . "usersrights` where `user_id`='$userid'";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $result[$u0[0]] = $u0[1];
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    static function updatebyid($id, $key, $value) {
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "usersrights`
            SET `$key`='$value' 
            WHERE `id`='$id'";
        $wd->execute();
        $wd->close();
        unset($wd);
    }

    static function getvaluebyid($id, $key) {//получить значение по id и ключу
        $result = '';
        $wd = new wra_db();
        $wd->query = 'SELECT `$key` FROM `' . WRA_CONF::$db_prefix . "usersrights`
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
        if (!isset($this->id))
            $this->id = WRA::getnewkey('' . WRA_CONF::$db_prefix . 'usersrights');
        $wd->query = "INSERT INTO `" . WRA_CONF::$db_prefix . "usersrights` (
             `id`,
             `user_id`,
             `right_id`
             )VALUES(
             '$this->id',
             '$this->user_id',
             '$this->right_id'
             )";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();
        unset($wd);
    }

    function update() {//обновление объекта
        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "usersrights`
        SET 
         `id`='$this->id',
         `user_id`='$this->user_id',
         `right_id`='$this->right_id'
         WHERE `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
    }

    static function isexist($id) {//возвращает true, если объект с запрашиваемым id существует
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "usersrights` WHERE `id` = '$id'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {//удаление объекта
        $wd = new wra_db();
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "usersrights` where `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
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
         `user_id`,
         `right_id`
         FROM `' . WRA_CONF::$db_prefix . "usersrights`  where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->user_id = $u0[1];
            $this->right_id = $u0[2];
        }
        $wd->close();
        unset($wd);
    }

}