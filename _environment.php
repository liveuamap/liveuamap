<?php


class WRA_ENV {

public static $routetables=array();
public static $cachetables=array();
static function scripts(){
    $result=array();
    //$result[]='scripts/jquery-migrate-1.2.1';
    $result[]='scripts/jquery/jquery.js';
        $result[]='scripts/jquery/jquery-ui.js';
     $result[]='scripts/jquery/json.js';
    $result[]='scripts/bootstrap.min.js';
        $result[]='scripts/validate.js';
  //          $result[]='scripts/fotorama.js';
        $result[]='scripts/lightbox.min.js';
           $result[]='scripts/jquery.datetimepicker.js';
                 $result[]='scripts/date-functions.js';
    $result[]='scripts/uamap.js';
    // $result[]='scripts/multizoom.js';
    return $result;
}
static function styles() {
    $result=array();
    // $result[]='styles/multizoom.css';
    $result[]='styles/bootstrap.css';
  //    $result[]='styles/fotorama.css';
     $result[]='styles/lightbox.css';
     $result[]='styles/jquery-ui.css';
     $result[]='styles/jquery.datetimepicker.css';
    $result[]='styles/uamap.css';
    // $result[]='styles/jplayer.blue.monday.css';
    return $result;
}
static function models() {
    $result=array();
    
    $result[]=new wfmodel('sources/cache/start_cache.php');
    $result[]=new wfmodel('sources/users/users.php');
    $result[]=new wfmodel('sources/users/rights.php');
    $result[]=new wfmodel('sources/users/usersrights.php');
    $result[]=new wfmodel('sources/users/userscontext.php');
    $result[]=new wfmodel('sources/page.php');
    $result[]=new wfmodel('sources/mail.php');
    $result[]=new wfmodel('sources/misc/files.php');
    $result[]=new wfmodel('sources/misc/geo.php');
    $result[]=new wfmodel('modules/nk/nk.php');
      $result[]=new wfmodel('modules/nk/wra_foursqvenues.php');
    $result[]=new wfmodel('sources/misc/langv.php');
    $result[]=new wfmodel('sources/misc/ops.php');
        $result[]=new wfmodel('modules/payments/payments.php');
    $result[]=new wfmodel('sources/misc/menu.php');
    $result[]=new wfmodel('sources/misc/wra_mutiselect.php');
    $result[]=new wfmodel('modules/facebooksdk/facebook.php');
    $result[]=new wfmodel('modules/facebooksdk/wra_facebook.php');
       $result[]=new wfmodel('modules/twitter/OAuth.php');
     $result[]=new wfmodel('modules/twitter/TwitterOAuth.php');
     $result[]=new wfmodel('modules/twitter/wra_twitter.php');
    // $result[]=new wfmodel('modules/vk/wra_vk.php');
    // $result[]=new wfmodel('modules/nk/wra_vku.php');
    $result[]=new wfmodel('modules/nk/wra_fbu.php');
        $result[]=new wfmodel('modules/nk/wra_twu.php');
    $result[]=new wfmodel('modules/phputf/utf8.php');
    // $result[]=new wfmodel('modules/altwork/altwork.php');
    $result[]=new wfmodel('lang/language.php');
    $result[]=new wfmodel('modules/admin/admintable.php');
    $result[]=new wfmodel('modules/wti/wti.php');

    // $result[]=new wfmodel('modules/payments/payments.php');
    return $result;
}
static function routes() {
    $result=array();
     $result[]=new wfroute('history.xml','history','history.php');
    $result[]=new wfroute('sitemap.xml','sitemap.xml','sitemap.php');
     

    $result[]=new wfroute('ajax','ajax/do','ajax/do.php');
    $result[]=new wfroute('admindel','admin/del','ajax/admin/del.php');
    $result[]=new wfroute('admin','admin','admin/index.php');
    $result[]=new wfroute('adminlogin','admin/login','admin/login.php');
    $result[]=new wfroute('index','e/{i}','index.php');
 $result[]=new wfroute('index','e/{l}/{l}','index.php');
    $result[]=new wfroute('index','index','index.php');
    $result[]=new wfroute('login','login','login.php');
     $result[]=new wfroute('card','card','card.php');
     $result[]=new wfroute('rss','rss','rss.php');
     $result[]=new wfroute('fblogin','fblogin','fblogin.php');
        $result[]=new wfroute('twilogin','twilogin','twilogin.php');
    $result[]=new wfroute('signout','signout','signout.php');

    return $result;    
}
static function adminnodes() {
    $result = array();
    // $result[]=new adminnodes("admin/menu","Меню");
    // $result[]=new adminnodes("admin/news","Новости");
    $result[]=new adminnodes("admin/foursqvenues","Events");    
   
     $result[]=new adminnodes("admin/users","Users");  
       $result[]=new adminnodes("admin/fbu","Facebook Users");  
    return $result;
}

}
?>