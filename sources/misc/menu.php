<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">������ �������. Contact rdx.dnipro@gmail.com</div>');

class wra_menu extends wfbaseclass{

//класс
    var $objectadres = "";
    var $currentobjid = -1;
    var $id;
    var $header;
    var $link;
    var $sortorder;
    var $parentid;
    var $alt;
    var $classes;
    var $activeclasses;
    var $status;
    var $type;
    static function adminit($wfadmin){
        $wfadmin->table='menu';
        $wfadmin->multilanguages=true;
       
        $wfadmin->columns[]=new admincolumn("String", "header", "Заголовок", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "link", "Ссылка", admincolumntype::text, admincolumntype::text, 3);
        $wfadmin->columns[]=new admincolumn("Int32", "sortorder", "Сортировка", admincolumntype::none, admincolumntype::text, 4); 
        $wfadmin->columns[]=new admincolumn("Int32", "parentid", "Родитель", admincolumntype::fromdrop, admincolumntype::dropdown, 5, self::get_drop());
        $wfadmin->order = " order by sortorder desc";

    }
    function wra_menu() {
        
    }
    static function get_drop($lang = '_ru') {
        $result = array();
        $result[] = '';
        $wd = new wra_db();
        $wd->query = "SELECT 
             `id`,`header`
             FROM `" . WRA_CONF::$db_prefix . "menu$lang`";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $result[$u0[0]] = $u0[1];
        }
        $wd->close();
        return $result;
    }
    function isselected($cp){
        //die($cp->menu);
        if($cp->menu==$this->link) return true;
        
    return false;
    }

    static function get_menu($menu) {
        $a0 = array();
        foreach ($menu as $k => $v) {
            if (empty($v->parentid)) 
                $a0[$k] = $v;
        }
        return $a0;
    }

    static function get_submenu($menu,$id) {
        $a0 = array();
        foreach ($menu as $k => $v) {
            if ($v->parentid == $id) 
                $a0[$k] = $v;
        }
        return $a0;
    }

    static function get_list($lang='') {//получить полный список
        $result = array();
        $wd = new wra_db();
        $wd->query = "SELECT 
             `id`,
             `header`,
             `link`,
             `sortorder`,
             `parentid`
             FROM `" . WRA_CONF::$db_prefix . "menu$lang` 
             ORDER BY `sortorder` asc";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_menu();
            $r0->id = $u0[0];
            $r0->header = $u0[1];
            $r0->link = $u0[2];
            $r0->sortorder = $u0[3];
            $r0->parentid = $u0[4];
            $result[$u0[0]] = $r0;
        }
        $wd->close();
        return $result;
    }

    static function isexist($id) {//возвращает true, если объект с запрашиваемым id существует
        $result = false;
        $wd = new wra_db();
        $wd->query = "SELECT id FROM `" . WRA_CONF::$db_prefix . "menu` WHERE `id` = '$id'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    static function getexistid($id) {
        $result = false;
        $wd = new wra_db();
        $wd->query = "SELECT id FROM `" . WRA_CONF::$db_prefix . "menu` WHERE `id` = '$id'";
        $wd->executereader();
        if ($u0 = $wd->read())
            $result = $u0['id'];

        $wd->close();
        unset($wd);
        return $result;
    }


    function loadid($id) {
        $this->id = $id;
    }

    function loadmore() {
        $this->load($this->id);
    }

    function load($id,$lang='') {//загрузка объекта
        $wd = new wra_db();
        $this->id = $id;
        $wd->query = "SELECT 
             `id`,
             `header`,
             `link`,
             `sortorder`,
             `parentid`
            FROM `" . WRA_CONF::$db_prefix . "menu$lang`  where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->header = $u0[1];
            $this->link = $u0[2];
            $this->sortorder = $u0[3];
            $this->parentid = $u0[4];
        }
        $wd->close();
        unset($wd);
    }

}

?>
