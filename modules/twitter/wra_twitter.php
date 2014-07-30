<?php

defined('WERUA') or include('../bad.php');



class wra_twitter extends wfbaseclass{
	// var $connection;
	var $access_token;

	static function loginLink(){
		$connection = new TwitterOAuth(WRA_CONF::$twiappid, WRA_CONF::$twiappsecret);
                $temporary_credentials = $connection->getRequestToken(WRA_CONF::$twiauthlink); 
  		$redirect_url = $connection->getAuthorizeURL($temporary_credentials);
  		return $redirect_url;
	}
	function wra_twitter() {

		$connection = new TwitterOAuth(WRA_CONF::$twiappid, WRA_CONF::$twiappsecret);
		$this->access_token = $connection->getAccessToken();
	}
	function get_access_token() {

	}

	function post($message="hello") {
		// $message
		$connection = new TwitterOAuth(WRA_CONF::$twiappid, WRA_CONF::$twiappsecret, $this->oauth_token, $this->oauth_token_secret);
		// $content = $connection->get('account/rate_limit_status');
		$res = $connection->post('statuses/update', array('status' => $message));
		// WRA::debug($res);
		// $content = $connection->get('users/show',array('user_id'=> $_SESSION['access_token']['user_id']));
	}

}