<?

defined('WERUA') or include('../bad.php');

class wra_meta extends wfbaseclass{

var $id;
var $link;
var $title;
var $meta_keywords;
var $meta_description;
var $og_image;

    static function adminit($wfadmin){
        $wfadmin->table='meta';
        $wfadmin->multilanguages=false;       
        $wfadmin->columns[]=new admincolumn("String", "link", "Страница(ссылка)", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "title", "Title - заголовок", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "meta_keywords", "Meta ключевые слова", admincolumntype::none, admincolumntype::bigtext, 2);
        $wfadmin->columns[]=new admincolumn("String", "meta_description", "Meta описание", admincolumntype::none, admincolumntype::bigtext, 2);
        $wfadmin->columns[]=new admincolumn("String", "og_image", "OG Image", admincolumntype::none, admincolumntype::text, 2);
        $wfadmin->order = " order by link asc";
    }

    function getbypage($url,$lang="") {
        $wd=new wra_db();
        // $this->id = $id;
        $wd->query = "SELECT 
        `id`,
        `link`,
        `title`,
        `meta_keywords`,
        `meta_description`,
        `og_image`
        FROM `".WRA_CONF::$db_prefix."meta".$lang."` WHERE `link`='$url'";
        $wd->executereader();
        
        if($u0=$wd->read()){
            $this->id = $u0[0];
            $this->link = $u0[1];
            $this->title = $u0[2];
            $this->meta_keywords = $u0[3];
            $this->meta_description = $u0[4];
            $this->og_image = $u0[5];         
        }
        $wd->close();
        unset($wd);        
    }
}

?>