<?

defined('WERUA') or include('../bad.php');

class wra_redirects extends wfbaseclass{

var $id;
var $from;
var $to;
var $type;
    static function adminit($wfadmin){
        $wfadmin->table='redirects';
        $wfadmin->multilanguages=false;
       
        $c=new admincolumn("String", "from", "Ссылка", admincolumntype::text, admincolumntype::text, 2);
        $c->sqlfield = "'from'";
        $wfadmin->columns[] = $c;
        $c=new admincolumn("String", "to", "Редирект", admincolumntype::text, admincolumntype::text, 2);
        $c->sqlfield = "'to'";
        $wfadmin->columns[] = $c;
          $wfadmin->columns[]=new admincolumn("Int32", "type", "Тип", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->order = " order by `from` desc";

    }
}

?>