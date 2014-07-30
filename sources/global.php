<?php
defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');
switch(WRA_CONF::$dbtype){
    case 'mysql':
        require_once('db/mysql.php');
        break;
    
}
// die(WRA_Path.'/sources/wf.php');
include('wf.php');


class WRA{//глобальный класс - все что не влезло в другие или слишком часто используется здесь - 
            //самый основной класс
   
	static function wordForm($n, $form1, $form2, $form5){
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $form5;
		if ($n1 > 1 && $n1 < 5) return $form2;
		if ($n1 == 1) return $form1;return $form5;
	}
   static function linestoli($text){
      
       
       $ar=explode('\n\r',$text);
       $result='';
     //  echo count($ar);
       foreach($ar as $a0){
           $result.='<li>'.$a0.'</li>';
       }
       return $result;
   }
   static function strtotimef($stime,$format=''){
    if( trim($format)=='' )return strtotime($stime);
    $artimer = array(
        'd'=>'([0-9]{2})',
        'j'=>'([0-9]{1,2})',
        'F'=>'([a-z]{3,10})',
        'm'=>'([0-9]{2})',
        'M'=>'([a-z]{3})',
        'n'=>'([0-9]{1,2})',
        'Y'=>'([0-9]{4})',
        'y'=>'([0-9]{2})',
        'i'=>'([0-9]{2})',
        's'=>'([0-9]{2})',
        'h'=>'([0-9]{2})',
        'H'=>'([0-9]{2})',
        '#'=>'\\#',
        ' '=>'\\s',
    );
    $arttoval = array(
        'j'=>'d',
        'f'=>'m',
        'n'=>'m',
    );
    $reg_format = '#'.strtr($format,$artimer).'#Uis';
    if( preg_match_all('#[djFmMnYyishH]#',$format,$list) and preg_match($reg_format,$stime,$list1) ){
        $item = array('h'=>'00','i'=>'00','s'=>'00','m'=>1,'d'=>1,'y'=>1970);
        foreach($list[0] as $key=>$valkey){
            if( !isset($arttoval[strtolower($valkey)]) )
                $item[strtolower($valkey)] = $list1[$key+1];
            else
                $item[$arttoval[strtolower($valkey)]] = $list1[$key+1];
        }
        return strtotime($item['h'].':'.$item['i'].':'.$item['s'].' '.$item['d'].' '.$item['m'].' '.$item['y']);
    }else return false;
}
    static function logit($text,$tag=''){//логирование в wra_logs
        $wd = new wra_db();
		$time=  time();$txt=  addslashes($text);
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "logs` (
             `timy`,
             `logline`,`tag`
             )VALUES(
             '$time',
             '$txt','$tag'
             )";
                $wd->execute();

                $wd->close();
               unset($wd);
    }
    
   static function full_url()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}
static function basedomain( $str = '' )
{
    
    $url = @parse_url( $str );
    if ( empty( $url['host'] ) ) return;
    $parts = explode( '.', $url['host'] );
    $slice = ( strlen( reset( array_slice( $parts, -2, 1 ) ) ) == 2 ) && ( count( $parts ) > 2 ) ? 3 : 2;
    return implode( '.', array_slice( $parts, ( 0 - $slice ), $slice ) );
}
   static function base_url()
{


    
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $port .'/'.WRA_CONF::$rootpath.'';
}
    static function ifinlog($logline) { // проверка наличия значения в логе
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT timy FROM `' . WRA_CONF::$db_prefix . "logs` WHERE `logline` = '$logline'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }
	//функции кеширования------------
     function writeCache($content, $filename) { 
	 
	   if($filename=='')return false;
            $fp = fopen(WRA_Path.'/cache2/' . md5($filename).'.cache', 'w'); 
            fwrite($fp, $content); 
            fclose($fp); 
     } 
 function property_value_in_array($array, $property, $value) {
    $flag = false;

    foreach($array as $object) {
        if(!is_object($object) || !property_exists($object, $property)) {
            return false;        
        }

        if($object->$property == $value) {
            $flag = true;
        }
    }
    
    return $flag;
}

static function json_safe_encode($var)
{
   return json_encode(WRA::json_fix_cyr($var));
}

static function json_fix_cyr($var)
{
   if (is_array($var)) {
       $new = array();
       foreach ($var as $k => $v) {
           $new[WRA::json_fix_cyr($k)] = WRA::json_fix_cyr($v);
       }
       $var = $new;
   } elseif (is_object($var)) {
       $vars = get_object_vars($var);
       foreach ($vars as $m => $v) {
           $var->$m = WRA::json_fix_cyr($v);
       }
   } elseif (is_string($var)) {
       $var = iconv('cp1251', 'utf-8', $var);
   }
   return $var;
}
  function readCache($filename, $expiry) { 
 

  if($filename=='')return false;
  $path=WRA_Path.'/cache2/' . md5($filename).'.cache';
    if (file_exists($path)) { 
      if ((time() - $expiry) > filemtime($path)) {
              
        return FALSE; }
      $cache = file($path); 
      return implode('', $cache); 
    } 
 
    return FALSE; 
  } 
	
  static function debug($varible){
  	if ((WRA_CONF::$usedebug) or ($_SESSION['debug'] == 1)){
  		echo '<pre>';
  	  	print_r($varible);
  	  	echo '</pre>';
  	}
  } 	
	
	
	
	static function getip(){
	return  $_SERVER['REMOTE_ADDR'];
	}
	static function gotopage($page){//переход (редирект) на $page
		header("Location: ".$page);
		exit;
	}

	static function insertkey($table){//вставляем новый ключ в базу keys
		$wd=new wra_db();
		$wd->query='insert into '.WRA_CONF::$db_prefix."keys  (  `tablename` ,  `value`) values ('$table','1')";
		
		$wd->execute();
		
		$wd->close();
		unset($wd);
	}
	//получаем время
	static function gettime(){
	 $result=date('H:i');
	return $result;
	}
        static function formattime($time){
	 $result=strtotime($time);
            $result= date(WRA_CONF::$formattime,$result);
	return $result;
	}
	        static function formatdate($time){
	 $result=strtotime($time);
            $result= date(WRA_CONF::$formatdate,$result);
	return $result;
	}
         static function formatdatefrtime($time){

            $result= date(WRA_CONF::$formatdate,$time);
	return $result;
	}
    static function getmonth_ru($timestamp){
	    $result='';
            
    	switch(date('m',$timestamp)){
    	case 1: $result.='Январь';break;
    	case 2: $result.='Февраль';break;
    	case 3: $result.='Март';break;
    	case 4: $result.='Апрель';break;
    	case 5: $result.='Май';break;
    	case 6: $result.='Июнь';break;
    	case 7: $result.='Июль';break;
    	case 8: $result.='Август';break;
    	case 9: $result.='Сентябрь';break;
    	case 10: $result.='Октябрь';break;
    	case 11: $result.='Ноябрь';break;
    	case 12: $result.='Декабрь';break;
    	}
	    return $result;
	}
	static function getmonthdropdown_ru(){
	    $result=array();
    	$result[1]='Январь';
    	$result[2]='Февраль';
    	$result[3]='Март';
    	$result[4]='Апрель';
    	$result[5]='Май';
    	$result[6]='Июнь';
    	$result[7]='Июль';
    	$result[8]='Август';
    	$result[9]='Сентябрь';
    	$result[10]='Октябрь';
    	$result[11]='Ноябрь';
    	$result[12]='Декабрь';
	    return $result;
	}
	static function getmonthday_ru(){
	    $result='';
    	$result.=date('d').' ';
    	switch(date('m')){
    	case 1: $result.=' января';break;
    	case 2: $result.=' февраля';break;
    	case 3: $result.=' марта';break;
    	case 4: $result.=' апреля';break;
    	case 5: $result.=' мая';break;
    	case 6: $result.=' июня';break;
    	case 7: $result.=' июля';break;
    	case 8: $result.=' августа';break;
    	case 9: $result.=' сентября';break;
    	case 10: $result.=' октября';break;
    	case 11: $result.=' ноября';break;
    	case 12: $result.=' декабря';break;
    	}
    	$result.=',';
    	switch(date('w')){
    	case 0: $result.=' вс';break;
    	case 1: $result.=' пн';break;
    	case 2: $result.=' вт';break;
    	case 3: $result.=' ср';break;
    	case 4: $result.=' чт';break;
    	case 5: $result.=' пт';break;
    	case 6: $result.=' сб';break;
    	}
	    return $result;
	}
	static function getmultiple($name){
		$temp='';
		if(isset($_POST[$name]))
			if (is_array($_POST[$name])){
				foreach ($_POST[$name] as $t){$temp.=$t.';';}
			} else {
				$temp = $_POST[$name].';';
			}
		return $temp;
		
	
	}
	static function getcuryear(){
		$result=date('Y');
		
		
		
		return $result;
		
	}

	static function getcurtime(){
		$result=date('Y-m-d H:i:s');
		
		
		
		return $result;
		
	}
	static function getnewkeyimpr($table){// better variant
		$result=1;
		$wd=new wra_db();
		$wd->query='select value from '.WRA_CONF::$db_prefix."keys where tablename='$table'";
		
		$wd->executereader();
		
		if($wd->error==''&&$wd->rows_count!=0){
			
			if($u0=$wd->read()){
				
				$result =$u0[0]+1;
				
				
			}
			$wd->query = "SELECT GetNewKey('$table')";
			//echo $wd->query;
			$wd->executereader();
			$u0=$wd->readresult(0,0);
			//echo $u0; 
			echo 'boom';
			WRA::nicedie();
		}else{
			
			WRA::insertkey($table);
			
		}
		
		$wd->close();
		
		
		
		return $result;
		
	}
	static function wlog($string){// запись $string в лог в файл log.txt
		if(!file_exists(WRA_Path.'/'.'log.txt')){
			$fp = fopen (WRA_Path.'/'.'log.txt', 'w');
			chmod(WRA_Path.'/'.'log.txt', 0755);
			fclose($fp); 
		}
		$fp = fopen (WRA_Path.'/'.'log.txt', 'a');
		fwrite($fp,WRA::getcurtime().':'.$string.'\r\n'); 
		fclose($fp); 
		
	}

	static function file_extension($filename)//получаем расширение файла $filename
	{
    $path_info = pathinfo($filename);
    if(is_array($path_info))
	if(in_array( 'extension',$path_info))
	    return $path_info['extension'];
	}
	static function getnewkey($table){//получаем новый ключ для таблицы table        
		if(!WRA_CONF::$usegetkey) return '';
		$result=1;
		$wd=new wra_db();		
		$wd->query='select value from '.WRA_CONF::$db_prefix."keys where tablename='$table'";		
		$wd->executereader();	
		if($wd->error==''&&$wd->rows_count!=0){		
			if($u0=$wd->read()){				
				$result =$u0[0]+1;			
			}
			$wd->query = 'update '.WRA_CONF::$db_prefix."keys set value='$result' where tablename='$table'";
	    	$wd->execute();
			$wd->close();			
		}else{	
			WRA::insertkey($table);		
		}
		unset($wd);
		return $result;		
	}
	function ep0($text){
		$return=str_replace('/n','<br/>', $text);
		if(substr($return,0,3)=='<p>'){
	         WRA::e(substr($return,3,strlen($return)-7));
		}else
		WRA::e($return);
	}

	static function htmlpic($path){
	    header('Content-type: image/png');
      //  $string = 'hello';
        $im     = imagecreatefrompng(WRA_Path.$path);
        //$orange = imagecolorallocate($im, 220, 210, 60);
        //$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
       // imagestring($im, 3, $px, 9, $string, $orange);
        imagepng($im);
        imagedestroy($im);
    	
	}
	 static function mb_trim( $string, $chars = '', $chars_array = array() )
	{
	    for( $x=0; $x<iconv_strlen( $chars ); $x++ ) $chars_array[] = preg_quote( iconv_substr( $chars, $x, 1 ) );
	    $encoded_char_list = implode( '|', array_merge( array( '\s','\t','\n','\r', '\0', '\x0B' ), $chars_array ) );

	    $string = mb_ereg_replace( '^($encoded_char_list)*', '', $string );
	    $string = mb_ereg_replace( '($encoded_char_list)*$', '', $string );
    	return $string;
	}

	static function totranslit($text) {//транслит	
		$text=WRA::strtolower_utf8($text);
	   	$trans=array('а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё'=>'jo', 'ж'=>'zh', 'з'=>'z', 'и'=>'i', 'й'=>'j', 'к'=>'k',   
	    'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p', 'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'y', 'ф'=>'f', 'х'=>'kh', 'ц'=>'ts', 'ч'=>'ch', 'ш'=>'sh',   
	    'щ'=>'sch', 'ъ'=>'', 'ы'=>'y', 'ь'=>'', 'э'=>'e', 'ю'=>'ju', 'я'=>'ja','і'=>'i',' '=>'_','є'=>'ie','і'=>'i','ї'=>'i','ґ'=>'g');
	    $tr2=array_values($trans);
	    $tr1=array_keys($trans);
	    for($i=0;$i<count($trans);$i++){
	        $text=str_replace($tr1[$i],$tr2[$i],$text);     
	    }        
	   return $text;
    }

	static function getcurpagecat(){//получаем адрес текущей страницы c каталогом
	    $result='';
        $beginpos=strpos($_SERVER['REQUEST_URI'],'/')+1;
        $endpos=strpos($_SERVER['REQUEST_URI'],'&');

        if($endpos)
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos,$endpos-$beginpos) ;
	    else
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos) ;
    	

	    return $result;
	
	}
	static function getfullnoquestion(){//получаем полный адрес с отрезанным вопросом
	    $result='';
        $beginpos=strpos($_SERVER['REQUEST_URI'],'/')+1;
        $endpos=strpos($_SERVER['REQUEST_URI'],'?');
        
        if($endpos)
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos,$endpos-$beginpos) ;
	    else
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos) ;
    	

	    return $result;
	
	}
	static function getnoquestion(){//получаем адрес с отрезанным вопросом
	    $result='';
        $beginpos=strrpos($_SERVER['REQUEST_URI'],'/')+1;
        $endpos=strpos($_SERVER['REQUEST_URI'],'?');
        
        if($endpos)
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos,$endpos-$beginpos) ;
	    else
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos) ;
    	

	    return $result;
	
	}
	
	static function getrequestvars(){//получаем запрошенные параметры
	    $result0=array();
        $beginpos=strrpos($_SERVER['REQUEST_URI'],'?')+1;
        //$endpos=strpos($_SERVER['REQUEST_URI'],'&');
        
        if($beginpos)
        
	    $result0 = substr($_SERVER['REQUEST_URI'],$beginpos) ;
    	$result=array();
        $temp=explode ('&',$result0);
        foreach($temp as $b0){
            $t0=explode('=',$b0);
            $result[$t0[0]]=urldecode($t0[1]);
        
        }
	    return $result;
	
	}
	static function getcurpage(){//получаем адрес текущей страницы
	    $result='';
            $beginpos=strrpos($_SERVER['REQUEST_URI'],'/')+1;
            $endpos=strpos($_SERVER['REQUEST_URI'],'&');
        
        if($endpos)
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos,$endpos-$beginpos) ;
	    else
	    $result = substr($_SERVER['REQUEST_URI'],$beginpos) ;
    	

	    return $result;
	
	}
	static function getpost($post){
		return (!is_array($_POST[$post]))?(addslashes($_POST[$post])):(false);
	}
	static function getget($get){
		return (!is_array($_GET[$get]))?(addslashes($_GET[$get])):(false);
	}
	static function getreq($post){
		return (!is_array($_REQUEST[$post]))?(addslashes($_REQUEST[$post])):(false);
	}
	static function check_email($email)// проверка электронного адреса на правильность
	{
	return wra_email::check_email_address($email);
	}
	static function trace(){// отладочная функция.
		print_r(debug_backtrace());	
	}
	static function ir($request){//установлен ли рекуест
	    return isset($_REQUEST[$request]);
	}
	static function curuser(){// возвращаем текущего пользователя
	    return wra_userscontext::curuser();
	}
	static function isp($request){//установлен ли пост
	    return isset($_POST[$request]);
	}
	static function p($request){//возвращаем post
	    return $_POST[$request];
	}
	static function setp($request,$value){//задаем пост
	   $_POST[$request]=$value;
	}
	static function setr($request,$value){//задаем рекуест
	
	   $_REQUEST[$request]=$value;
	}
	static function r($request){//возвращаем рекуест
	if(isset($_REQUEST[$request]))
	    return $_REQUEST[$request];
	}
	static function e($text){
		echo(stripslashes((!is_array($text))?($text):(false)));
		// echo(stripslashes($text));
	}
	static function eatarget($text){
		$text = preg_replace("~<a ~", "<a target='_blank'", $text);
		echo(stripslashes((!is_array($text))?($text):(false)));
		// echo(stripslashes($text));
	}
    static function esc($text){
    	echo(htmlspecialchars_decode(stripslashes($text)));
	}
         static function escdiv($text){
            $lko= htmlspecialchars_decode(stripslashes($text));
            $content = preg_replace("/<\/?div[^>]*\>/i", "", $lko); 
            echo($content);
	
	}
     static function er($text){
	
	echo(str_replace('{wfurl}',  WRA::base_url(),stripslashes($text)));
	
	}
	static function mb_substrws( $text, $len=180 ) {//своя функция библиотеки mb. действие аналогично оригиналу
		
		if( (mb_strlen($text) > $len) ) {
			
			$whitespaceposition = mb_strpos($text,' ',$len)-1;
			
			if( $whitespaceposition > 0 ) {
				$chars = count_chars(mb_substr($text, 0, ($whitespaceposition+1)), 1);
				if ($chars[ord('<')] > $chars[ord('>')])
					$whitespaceposition = mb_strpos($text,'>',$whitespaceposition)-1;
				$text = mb_substr($text, 0, ($whitespaceposition+1));
			}
			
			// close unclosed html tags
			if( preg_match_all('|<([a-zA-Z]+)|',$text,$aBuffer) ) {
				
				if( !empty($aBuffer[1]) ) {
					
					preg_match_all('|</([a-zA-Z]+)>|',$text,$aBuffer2);
					
					if( count($aBuffer[1]) != count($aBuffer2[1]) ) {
						
						foreach( $aBuffer[1] as $index => $tag ) {
							
							if( empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag)
								$text .= '</'.$tag.'>';
						}
					}
				}
			}
		}
		return $text;
	}
	static function strtolower_utf8($string){ // перевод в нижний регистр в кодировке utf8
		$convert_to = array( 
				'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 
				'v', 'w', 'x', 'y', 'z', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 
				'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 
				'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 
				'ь', 'э', 'ю', 'я' 
				); 
		$convert_from = array( 
				'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 
				'V', 'W', 'X', 'Y', 'Z', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 
				'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 
				'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ъ', 
				'Ь', 'Э', 'Ю', 'Я' 
				); 
		
		return str_replace($convert_from, $convert_to, $string); 
	} 


}

class wra_key_value_pair{//вспомогательный класс пара ключ-значение
	var $key;
	var $value;
	function wra_key_value_pair(){
		
		
	}
}




?>