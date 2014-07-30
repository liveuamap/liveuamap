<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_rights extends wfbaseclass{

//класс
    var $id;
    var $alias;
    var $rutext;

    function wra_rights() {
        
    }

    static $accesslevel = array("admin");
    static function getacceslevel() {
        return self::$accesslevel;
    }
    static function adminit($wfadmin){
        $wfadmin->table='rights';
        $wfadmin->multilanguages=false;       
        $wfadmin->columns[]=new admincolumn("String", "alias", "Алиас", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "rutext", "Название", admincolumntype::text, admincolumntype::text, 2);
    }
    static function getlist() {//получить список
        $result = array();
        $wd = new wra_db();
        $wd->query = 'SELECT `id`,`rutext`
            FROM `' . WRA_CONF::$db_prefix . "rights`";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $result[$u0[0]] = $u0[1];
        }
        $wd->close();
        unset($wd);
        // WRA::debug($result);
        return $result;
    }

   
}