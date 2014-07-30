<?php
defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_multiselect extends wfbaseclass{
    var $table;
    var $kfield;
    var $tfield;
    function wra_multiselect($table,$kfield,$tfield){
        $this->table=$table;
        $this->kfield=$kfield;
        $this->tfield=$tfield;
    }
     static function isexist($table,$kfield,$tfield,$kvalue,$tvalue) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "$table` WHERE `$kfield` = '$kvalue'
                and `$tfield`='$tvalue'
                ";
      
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }
     static function delete($table,$kfield,$tfield,$kvalue,$tvalue){
        $wd = new wra_db();

      
        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "$table` WHERE `$kfield` = '$kvalue'
                and `$tfield`='$tvalue' ";
       
        $wd->execute();
        $wd->close();
        unset($wd);
    }
    static function add($table,$kfield,$tfield,$kvalue,$tvalue){
        if(wra_multiselect::isexist($table,$kfield,$tfield,$kvalue,$tvalue)){
     
            return;
        }

        $wd = new wra_db();
        

        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "$table` (`id`,`$kfield`,`$tfield`)
                                values(null,'$kvalue' ,'$tvalue')";

        $wd->execute();
        $wd->close();
        unset($wd);
    }
        static function getlist($table,$kfield,$tfield,$kvalue) {
        $result = array();
        $wd = new wra_db();

        $wd->query = "SELECT `$tfield`
 FROM `" . WRA_CONF::$db_prefix . "$table` where `$kfield`='$kvalue'";
        $wd->executereader();
        while ($u0 = $wd->read()) {

            $result[$u0[0]] = $u0[0];
        }
        $wd->close();
        unset($wd);
      
        return $result;
    }
}
?>
