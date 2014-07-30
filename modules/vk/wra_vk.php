<?php

defined('WERUA') or include('../../bad.php');

class wra_vk{
	static private $scope = "friends,wall,offline";
  static private $display="popup"; 

	static function loginLink(){
  		$link = "https://oauth.vk.com/authorize?client_id=".WRA_CONF::$vkappid."&scope=".self::$scope."&redirect_uri=".WRA_CONF::$vkauthlink."&display=".self::$display."&response_type=code";
  		return $link;
	}

    static function wallPost($owner_id = "-52007862", $message = "" , $link=""){
        $message = urlencode($message);
        $access_token = "fc93487e6617d2c670f65284ffd60b745ab7b34d2fccd5d768e397aeffa92da8867121cf49a46503083e3";
        $request = 'https://api.vk.com/method/wall.post?owner_id='.$owner_id.
            '&access_token='.$access_token.
            '&attachments='.$link.
            '&from_group=1'.
            '&signed=0'.
            '&message='.$message;
        $json_result = @file_get_contents($request);
        if ($json_result != false){
               $arr = json_decode($json_result,true);
               return $arr;
        }
        return false;
    }

    static function JwallPost($wall_id, $message, $access_token){
        $message = urlencode($message);
        WRA::e('
            <script>
                VK.Api.call("wall.post", {owner_id: '.$wall_id.',"message": "'.$message.'","access_token":"'.$access_token.'"}, onComplete);
            </script>
            ');
        // VK.api("wall.post", { owner_id:uid, message:'123', attachment:'http://vkontakte.ru/xxxxxxx'}, onComplete);
    }	
}