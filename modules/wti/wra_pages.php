<?php defined('WERUA') or include('../bad.php');

class wra_pages extends wfbaseclass{

var $id;
var $path;
var $filename;
var $user_id;
var $dateadd;
var $content;
var $header;
var $ptype;
var $keywords;
var $menu_id;

    static function adminit($wfadmin){
        $wfadmin->table='pages';
        $wfadmin->multilanguages=true;
       
        $wfadmin->columns[]=new admincolumn("DateTime", "dateadd", "Дата", admincolumntype::text, admincolumntype::datetime, 1);
        $wfadmin->columns[]=new admincolumn("String", "header", "Заголовок", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "path", "Путь", admincolumntype::text, admincolumntype::text, 3);
        $wfadmin->columns[]=new admincolumn("Int32", "user_id", "Добавил", admincolumntype::fromdrop, admincolumntype::dropdown, 4, wra_users::get_list()); 
        $wfadmin->columns[]=new admincolumn("String", "content", "Содержание", admincolumntype::none, admincolumntype::tinymce, 5);
        $wfadmin->columns[]=new admincolumn("String", "keywords", "Ключевые слова", admincolumntype::none, admincolumntype::bigtext, 6);
        $wfadmin->order = " order by dateadd desc";

    }

    static function get_list($lang='') {
        $result = array();
        $wd=new wra_db();
        $wd->query = "SELECT 
        p.id,p.dateadd,p.header,p.path,p.user_id,p.content,p.keywords
        FROM `".WRA_CONF::$db_prefix."pages$lang` AS p
        ORDER by p.id asc";   
        $wd->executereader();
        while($u0=$wd->read()){
            $item=new wra_pages();
            $item->id=$u0[0];
            $item->dateadd=$u0[1];
            $item->header=$u0[2];
            $item->path=$u0[3];
            $item->user_id=$u0[4];
            $item->content=$u0[5];
            $item->keywords=$u0[6];
            $result[$item->id]= $item;            
        }
        $wd->close();
        unset($wd);
        
        return $result;
    }

    function load($id, $lang='') {
        $result = array();
        $wd=new wra_db();
        $wd->query = "SELECT 
        p.id,p.dateadd,p.header,p.path,p.user_id,p.content,p.keywords
        FROM `".WRA_CONF::$db_prefix."pages$lang` AS p
        where p.id = '$id'";   
        $wd->executereader();
        while($u0=$wd->read()){
            $this->id=$u0[0];
            $this->dateadd=$u0[1];
            $this->header=$u0[2];
            $this->path=$u0[3];
            $this->user_id=$u0[4];
            $this->content=$u0[5];
            $this->keywords=$u0[6];
            // $result[$item->id]= $item;            
        }
        $wd->close();
        unset($wd);
        
        return $this;
    }
}

?>