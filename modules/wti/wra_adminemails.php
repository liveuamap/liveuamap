<?

defined('WERUA') or include('../bad.php');

class wra_adminemails extends wfbaseclass{

var $id;
var $email;


    static function adminit($wfadmin){
        $wfadmin->table='adminemails';
        $wfadmin->multilanguages=false;
       
        $wfadmin->columns[]=new admincolumn("String", "email", "Адрес почты", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->order = " order by email desc";

    }
      static function getlist() {//получить список
        $result = array();
        $wd = new wra_db();

        $wd->query = "SELECT `email`
 FROM `" . WRA_CONF::$db_prefix . "adminemails` ";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $result[] = $u0[0];
        }
        $wd->close();
        return $result;
    }
}

?>