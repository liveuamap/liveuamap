<?php  defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitemwti{
    var $question;
    var $q = 0;

    var $maxpoints=0;
    function  wfitem(){
        $this->header='Авторизация';
    }
    function run(){
         parent::run();
        $code = $_REQUEST["code"];
     

        if (!empty($code)) {
            // WRA::debug("get fb data");
            $token_url = "https://graph.facebook.com/oauth/access_token?"."client_id=".WRA_CONF::$fbappid."&redirect_uri=".urlencode(WRA_CONF::$fbauthlink. '')."&client_secret=".WRA_CONF::$fbappsecret."&code=".$code;
            // $usr = $_REQUEST['state'];
            $response = @file_get_contents($token_url);
            // WRA::debug($response);
            $params = null;
            parse_str($response, $params);
            // WRA::debug($params);

            $graph_url = "https://graph.facebook.com/me?fields=id,picture,name,first_name,location,hometown,gender,last_name,link,email&type=large&access_token="
                    . $params['access_token'];

            // WRA::debug($graph_url);
            $user = @json_decode(@file_get_contents($graph_url));
            // WRA::debug('asdasda');
            // wra_fbu::fbd($user->id);
            $nu = new wra_fbu();
            $nu->display_name = htmlspecialchars($user->name,ENT_QUOTES);
            $nu->regdate = WRA::getcurtime();
            $nu->fbuserid = $user->id;
            // $nu->userid = $usr;
            $nu->username = htmlspecialchars($user->first_name,ENT_QUOTES);
            $nu->usersurname = htmlspecialchars($user->last_name,ENT_QUOTES);
            $nu->link = htmlspecialchars($user->link,ENT_QUOTES);
            $nu->user_agent = wra_fbu::getbrowser();
            $nu->access_token=$params['access_token'];
            $nu->email=htmlspecialchars($user->email,ENT_QUOTES);
            $nu->photo=str_replace("_q", "_n", $user->picture->data->url);
            if($user->gender=='female')
                $nu->gender=1;
            else 
                $nu->gender=0;
            $nu->phone='';
            if(isset($nu->hometown))
                $nu->adres=htmlspecialchars($nu->hometown->name,ENT_QUOTES);
            
            if(isset($nu->location))
                $nu->adres=htmlspecialchars($nu->location->name,ENT_QUOTES);
            
            // WRA::debug($nu);die();
            
            if (!empty($nu->fbuserid)){
                if (!wra_fbu::isfbexist($user->id)) {
                    $nu->userid = $this->addUsr($nu->display_name, $nu->usersurname, $nu->phone, $nu->email, "asdf".time(), $nu->photo);
                    $nu->add();
                } else {
                    $nu->loadbyfb($nu->fbuserid);
                    $nu->update();
                }    
            wra_fbu::fbd($nu->fbuserid, $nu->userid);
            // try{     
            // }catch(Exception $ex){}
            //print_r($fb);
            }
        }
        // if(empty($_SESSION['lastpage'])){
            WRA::gotopage(WRA::base_url().'?from=fb');
        // }else{
            // WRA::gotopage(WRA::base_url().$_SESSION['lastpage']);
        // }
        $_SESSION['lastpage']='';
    }

    function addUsr($namei, $namef, $phone, $email, $pass, $pic) {
        $usr = new wra_users();
        $usr->namei = $namei;
        $usr->namef = $namef;
        $usr->cellphone = $phone;
        $usr->login = $namei.' '.$name;
        $usr->email = $email;
        $usr->password = md5($pass);
        $usr->avatar = $pic;
        $usr->active = 1;
        $usr->add();
        wra_usersrights::addinlist($usr->id, 4);
        return $usr->id;
    }
    function show() {
        // not call template
    }
}

?>
