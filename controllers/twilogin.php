<?php  defined('WERUA') or include('../bad.php'); 

class wfitem extends wfitemwti{
    var $question;
    var $q = 0;
    var $toshow=false;
    var $maxpoints=0;
    function  wfitem(){
        $this->header='Авторизация';
         $wf->cp->pagehead='';  
    }
    function run(){
        parent::run();
        if($_REQUEST['oauth_token']){
        $connection = new TwitterOAuth(WRA_CONF::$twiappid, WRA_CONF::$twiappsecret, $_REQUEST['oauth_token'],$_REQUEST['oauth_verifier']);
        $token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);
      
        $connection = new TwitterOAuth(WRA_CONF::$twiappid, WRA_CONF::$twiappsecret, $token_credentials['oauth_token'],$token_credentials['oauth_token_secret']);
    $account = $connection->get('account/verify_credentials');
     

        // WRA::debug($ctwe);

                if ($account){
     
  
                    // WRA::debug($user);
          
                    $nu = new wra_twu();
                    $nu->display_name = htmlspecialchars($account->screen_name,ENT_QUOTES);//$user->name;
                    $nu->regdate = WRA::getcurtime();
                    $nu->twuserid =$account->id;
                    // $nu->userid = $usr;
                    $nu->username = htmlspecialchars( $account->name,ENT_QUOTES);
                    $nu->usersurname =  htmlspecialchars($user['last_name'],ENT_QUOTES);
                    $nu->link = $account->url;//$user->link;
                    $nu->user_agent = wra_fbu::getbrowser();
                    $nu->access_token=$token_credentials['oauth_token'];
                    $nu->email=$token_credentials['oauth_token_secret'];
                    $nu->photo=$account->profile_image_url;
                    if($account->notifications)
                    $nu->gender=0;else $nu->gender=1;
                    $nu->phone='';
                    if (!empty($nu->twuserid)){
                        if (!wra_twu::istwexist($nu->twuserid)) {
                            $nu->userid = $this->addUsr($nu->username, $nu->usersurname, $nu->phone, $nu->email, "asdf".time(), $nu->photo);
                            $nu->add();
                        } else {
                            $nu->loadbytw($nu->twuserid);
                            $nu->update();
                        }
                        wra_twu::twd($nu->twuserid, $nu->userid);
                    }
                    if(empty($_SESSION['lastpage'])){
    
       WRA::gotopage(WRA::base_url().'?from=tw&show=no');
       }else{
            WRA::gotopage(WRA::base_url().$_SESSION['lastpage']);
        }
                $_SESSION['lastpage']='';}
                }else{
                    ?><a href="<?php WRA::e(wra_twitter::loginLink());?>">login</a><?php
                }
            

    }

    function addUsr($namei, $namef, $phone, $email, $pass, $pic) {
        $usr = new wra_users();
        $usr->namei = $namei;
        $usr->namef = $namef;
        $usr->cellphone = $phone;
//        $usr->adres = $adres;
//        $usr->email = $login;
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
