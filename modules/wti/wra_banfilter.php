<?

defined('WERUA') or include('../bad.php');

class wra_banfilter extends wfbaseclass{

var $id;
var $ip;


    static function adminit($wfadmin){
        $wfadmin->table='banfilter';
        $wfadmin->multilanguages=false;
       
        $wfadmin->columns[]=new admincolumn("String", "ip", "ip-адрес", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->order = " order by ip desc";

    }
}

?>