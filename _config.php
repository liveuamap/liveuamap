<?php
define('WERUA', 1 );
define('WRA_Path',dirname(__FILE__));
header('Content-Type:text/html; charset=UTF-8' );
//файл конфигурации/configuration file
require_once(WRA_Path.'/_environment.php');
require_once(WRA_Path.'/sources/global.php');


class WRA_CONF{

    public static $version='1.0.101';
// public static $fbpagelink='';
// public static $fbapplink='';
// public static $fbtabpageid='';
// public static $fbat='';

    public static $clones=array('');public static $updatecode='';

public static $rootpath ='dev/liveuamap_pub/';   
public static $fbauthlink='http://liveuamap.com/fblogin';
public static $fbappid='';
public static $fbappsecret='';

public static $vkauthlink='http://liveuamap.com/';
public static $vkappid='';
public static $vkappsecret='';
// public static $fbwidth='810';
// public static $fbheight='1136'; 
public static $twiauthlink='http://liveuamap.com/twilogin/';
public static $twiappid='';
public static $twiappsecret='';

public static $order_emails='rdx.dnipro@gmail.com;rdx-dnipro@yandex.ru';
public static $order_ftpserver='ftpserver';
public static $order_ftpuser='root';
public static $order_ftppassword='12345';
public static $order_ftppath='nk';
public static $pointscomment=30;
public static $pointsshare=15;
public static $pointsorder=50;

public static $wwwpath='http://liveuamap.com/dev/liveuamap_pub/';
public static $admin_email='';

public static  $usesmtpauth=0;
public static  $smtpserver='smtp.yandex.ru';
public static  $smtpport=25;
public static  $smtpuser='';
public static  $smtppassword='';
public static  $smtpfrom=array('info@liveuamap.com' => 'Liveuamap');
public static  $offline=0;
public static  $offline_text='Приложение закрыто';
public static  $sitename='Live Ukraine Map';

public static  $usedebug=false;

public static  $dbtype='mysql';
public static  $dbhost='localhost';
public static  $dbuser='liveuamap';
public static  $dbpassword='';
public static  $dbdb='lpub';
public static  $db_prefix='wra_';
public static $btcrpcu='';
public static $btcrpcp='';

public static  $google_verification='';
public static  $yandex_verification='';

public static $charset='utf-8';
public static $pagehead='Map of Ukraine Unrest';
public static $keywords='Map of Ukraine Unrest';
public static $description='Map of Ukraine Unrest';
public static $author='';
public static $language='ru';
public static $usegetkey=false;
public static $usestat=true;

public static $remembertime=604800;

public static $cacheon=false;
public static $cachetime=604800;	
public static $formattime='d.m.Y H:i';
public static $formatdate='d.m.Y H:i';
public static $cacheentities=true;

public static $privat24id=72164;
public static $privat24password='';
public static $liqpaymerchantid='';
public static $liqpaypassword='';
public static $w1merchantid='';
public static $w1key='';

}


?>