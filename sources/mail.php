<?
defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_email{


	static function sendreg($id,$pass){
		

			$message="";
			$nu=new wra_users;
			$nu->load($id);

			$message="Здравствуйте, ".$nu->namei." ".$nu->namef."!<br/>
					Поздравляем с успешной регистрацией на сайте <a href=\"".WRA::base_url()."\">".WRA::base_url()."</a><br/>
					Логин для входа – ".$nu->login.".<br/>
					Пароль для входа – ".$pass.".<br/>
					<br/>
					Если Вы считаете, что это ошибка, просто удалите письмо.<br/>
					С Уважением, ".WRA_CONF::$sitename.". <br/>
					Письмо создано роботом, не стоит отвечать на него.";
		wra_email::simplemessage($nu->email,"Успешная регистрация",$message);
		
	}
	static function sendremember($email){
		if(wra_email::check_email_address($email)){
			$message="";
			$nu=new wra_users;
			$nu->loadbyemail($email);
			$nupas=wra_users::create_password(8);
			wra_users::updatebyid($nu->id,"password",md5($nupas));
			$message="Здравствуйте, ".$nu->namei." ".$nu->namef."!<br/>
					Новый пароль к сайту <a href=\"http://".WRA::base_url()."\">".WRA::base_url()."</a><br/>
					Логин для входа – ".$nu->login.".<br/>
					Ваш новый пароль:".$nupas."<br/>
					<br/>
					Если Вы считаете, что это ошибка, просто запомните новый пароль и удалите письмо.<br/>
					С Уважением, ".WRA_CONF::$sitename.". <br/>
					Письмо создано роботом, не стоит отвечать на него.";
		wra_email::simplemessage($email,"Восстановление пароля",$message);}
		
	}
     static function sendchange($email,$nupass){
		if(wra_email::check_email_address($email)){
			$message="";
			$nu=new wra_users;
			$nu->loadbyemail($email);

			$message="Здравствуйте, вы изменили свой пароль ".$nu->namei." ".$nu->namef."!<br/>
					Новый пароль к сайту <a href=\"http://".WRA::base_url()."\">".WRA::base_url()."</a><br/>
					Логин для входа – ".$nu->login.".<br/>
					Ваш новый пароль:".$nupas."<br/>
                                        С Уважением, ".WRA_CONF::$sitename.". <br/>
					Письмо создано роботом, не стоит отвечать на него.";
		wra_email::simplemessage($email,"Восстановление пароля",$message);}
		
	}
	static function simplemessage($to,$subject,$message){
			$head = "<b>".WRA_CONF::$sitename."<font></b>";

            $subject = WRA_CONF::$sitename.":".$subject;
		$message = $head." <p>".$message."</p><br/><hr><font style=\"font-family:Verdana;font-size:10px\">".WRA::base_url()."<br/>".WRA::getcurtime(). "</font>";	
		
                   $emails=explode(';', WRA_CONF::$order_emails);
                   foreach($emails as $e){
                wra_email::sendemail($e,$subject,$message);}
		
	}
	static function sendemail($to,$subject,$message2,$ar=array()){
		include WRA_Path.'/modules/swiftmailer/swift_required.php';           
        $message = Swift_Message::newInstance()
        ->setFrom(WRA_CONF::$smtpfrom)
        ->setTo(array($to))
        ->setSubject($subject)
        ->setBody($message2, 'text/html', 'utf-8')   ;
        for($i=0;$i<count($ar);$i++){
           
            // $message->attach(Swift_Attachment::fromPath(WRA_Path.'/'.$ar[$i]));
       
        }

        $transporter = Swift_SmtpTransport::newInstance(WRA_CONF::$smtpserver, WRA_CONF::$smtpport, '')
		->setUsername(WRA_CONF::$smtpuser)
		->setPassword(WRA_CONF::$smtppassword);

		$mailer = Swift_Mailer::newInstance($transporter);
                try{
        $result = $mailer->send($message);}catch (Exception $e) {
            WRA::logit($e->getMessage(),'message');
            // echo   $e->getMessage(), "\n";  
        }
        return $result;
    }
	function wra_email(){
		
		
	}

    static function sendRegMail($reg_mail) {
        $code = wra_users::getRightCode($reg_mail);
        $subj = "Callback from";
        $body = "<a href=".WRA::base_url()."signin?email=".$reg_mail."&code=".$code.">accept email</a>";
        $headers = 'From: no-reply@award';
 
        $res = wra_email::sendemail($reg_mail, $subj, $body);
    }

    static function sendChangeloginMail($mail) {
        $code = wra_users::getRightCode($mail);
        $subj = "Callback from award";
        $body = "<a href=".WRA::base_url()."me?email=".$mail."&code=".$code.">accept email</a>";
        $headers = 'From: no-reply@award';
        // $res = wra_email::sendemail($reg_mail, $subj, $body);
        $res = wra_email::sendemail($mail, $subj, $body);
    }

    static function sendRememberMail($reg_mail) {
        $code = wra_users::getRightCode($reg_mail);
        $subj = "Callback from ";
        $body = "<a href=".WRA::base_url()."remember?email=".$reg_mail."&code=".$code.">get new password</a>";
        $headers = 'From: no-reply@award';
        // $res = wra_email::sendemail($reg_mail, $subj, $body);
        $res = wra_email::sendemail($reg_mail, $subj, $body);
    }

    static function sendNewsPassMail($reg_mail, $pass) {
        // $code = wra_users::getRightCode($reg_mail);
        $subj = "Callback from award";
        $body = "new password: ".$pass;
        $headers = 'From: no-reply@award';
        // $res = wra_email::sendemail($reg_mail, $subj, $body);
        $res = wra_email::sendemail($reg_mail, $subj, $body);
    }
	static function check_email_address($email)	{ 
	    if (!preg_match('/^[A-Z0-9_-][A-Z0-9._-]*@([A-Z0-9][A-Z0-9-]*\.)+[A-Z]{2,6}$/i', $email)) return false;
	    return true;
	    $emaila = explode('@', $email);
	    //echo $emaila[1];
	    if ( checkdnsrr($emaila[1],"MX") || checkdnsrr($emaila[1],"A") ) return true;	    
	    return false;
	}
	
}





?>