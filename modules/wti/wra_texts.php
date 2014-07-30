<?

defined('WERUA') or include('../bad.php');

class wra_texts extends wfbaseclass{

var $id;
var $header;
var $description;
var $text;
var $infoid;
var $key;
    static function adminit($wfadmin){
		$wfadmin->table='texts';
		$wfadmin->multilanguages=true;
		$c =new admincolumn("String", "keyx", "Ключ", admincolumntype::text, admincolumntype::text, 2);
		// $c->sqlfield = "`key`";
		$wfadmin->columns[] = $c;
		$wfadmin->columns[]=new admincolumn("String", "header", "Заголовок", admincolumntype::text, admincolumntype::text, 2);
		// $wfadmin->columns[]=new admincolumn("String", "description", "Описание", admincolumntype::text, admincolumntype::text, 3);
		$wfadmin->columns[]=new admincolumn("String", "text", "Содержание", admincolumntype::text, admincolumntype::bigtext, 5);
		$wfadmin->order = " order by `id` asc";

    }

	static function getbykey($key, $lang = ""){
		//$id = -1;
		$key = addslashes($key);
		$wd=new wra_db();
		$wd->query = "SELECT `text` FROM `".WRA_CONF::$db_prefix."texts".$lang."` WHERE `keyx`='$key'";
		// die($wd->query);
		$wd->executereader();
		
		if($u0=$wd->read()){
			$id = $u0[0];
			//die('1'.$id);
		} else {
			$id = false;
		}
		
		$wd->close();
		unset($wd);
		return $id;
	}
	static function getheaderbykey($key, $lang = ""){
		//$id = -1;
		$key = addslashes($key);
		$wd=new wra_db();
		$wd->query = "SELECT `header` FROM `".WRA_CONF::$db_prefix."texts".$lang."` WHERE `keyx`='$key'";
		// die($wd->query);
		$wd->executereader();
		
		if($u0=$wd->read()){
			$id = $u0[0];
			//die('1'.$id);
		} else {
			$id = false;
		}
		
		$wd->close();
		unset($wd);
		return $id;
	}
}

?>