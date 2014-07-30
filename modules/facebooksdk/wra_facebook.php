<?php

defined('WERUA') or include('../../bad.php');

class wra_facebook{
	static function loginLink(){
		$scopestring = '&scope=email';
  		$loginUrl = 'https://graph.facebook.com/oauth/authorize?client_id='.WRA_CONF::$fbappid.$scopestring.'&redirect_uri='.WRA_CONF::$fbauthlink.'';
  		return $loginUrl;
	}

	static function post($wall_id, $message, $access_token, $picture = "", $caption = "", $link = ""){
        // require  WRA_Path. '/modules/facebook/php-sdk/src/facebook.php';
      $clientid = WRA_CONF::$fbappid;
      $client_secret = WRA_CONF::$fbappsecret;

      $facebook = new Facebook(array(
        'appId'  => $clientid,
        'secret' => $client_secret,
      ));
      $result = $facebook->api(
          '/'.$wall_id.'/feed',
          'post',
          array(
              'access_token' => $access_token, 
              'message' => $message,
              'picture' => $picture,
              'caption' => $caption,
              'link' => $link
              )
      );
      // WRA::debug($result);
      return $result;
    }
}