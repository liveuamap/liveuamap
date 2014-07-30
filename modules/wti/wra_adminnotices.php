<?

defined('WERUA') or include('../bad.php');

class wra_adminnotices extends wfbaseclass{
    var $id;
    var $header;
    var $dateadd;
    var $ip;
    var $message;
    var $status;

    function add() {//добавление нового объекта
        $wd = new wra_db();
        $this->id = WRA::getnewkey("" . WRA_CONF::$db_prefix . 'adminnotices');
        $wd->query = "INSERT INTO `" . WRA_CONF::$db_prefix . "adminnotices` (
 `id`,
 `dateadd`,
 `ip`,
 `message`,
 `status`,`header`
 )VALUES(
 '$this->id',
 '$this->dateadd',
 '$this->ip',
 '$this->message',
 '$this->status', '$this->header'
 )";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();

        unset($wd);
    }

    static function getstatuses() {
        $result = array();
        $result[0] = 'Не прочитано';
        $result[1] = 'Прочитано';
        return $result;
    }

    static function message($header,$message) {
        $newnotice = new wra_adminnotices();
        $newnotice->dateadd = time();
        $newnotice->ip = WRA::getip();
        $newnotice->status = 0;
        $newnotice->message = $message;
        $newnotice->header=$header;
        $newnotice->add();
        // $admins=  wra_adminemails::getlist();
        // foreach($admins as $email){
            // wra_email::sendemail($email, $header, $message);
        // }
    }

    static function sendemail($to, $subject, $message2, $ar = array()) {
        include WRA_Path . '/modules/swiftmailer/swift_required.php';
        WRA::debug($to);
        // die();
        if(!Swift_Validate::email($to)){ //if email is not valid
                //do something, skip them or log them
                WRA::debug("invalid email");
                WRA::debug($to);
                die();
        }
        $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom(WRA_CONF::$smtpfrom)
                ->setTo(array($to))
                ->setBody($message2, 'text/html', 'utf-8');
        for ($i = 0; $i < count($ar); $i++) {
            
        }

        $transporter = Swift_SmtpTransport::newInstance(WRA_CONF::$smtpserver, WRA_CONF::$smtpport, '')
                ->setUsername(WRA_CONF::$smtpuser)
                ->setPassword(WRA_CONF::$smtppassword);

        $mailer = Swift_Mailer::newInstance($transporter);
        try {
            $result = $mailer->send($message);
        } catch (Exception $e) {
            WRA::logit($e->getMessage(), 'message');
            // echo   $e->getMessage(), "\n";  
        }
        return $result;
    }

    static function adminit($wfadmin) {
        $wfadmin->table = 'adminnotices';
        $wfadmin->multilanguages = false;
        $wfadmin->columns[] = new admincolumn("DateTime", "dateadd", "Добавлено", admincolumntype::text, admincolumntype::datetime, 2);
        $wfadmin->columns[] = new admincolumn("String", "ip", "ip-адрес", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[] = new admincolumn("String", "message", "Сообщение", admincolumntype::text, admincolumntype::bigtext, 2);
        $wfadmin->columns[] = new admincolumn("Int32", "status", "Статус", admincolumntype::fromdrop, admincolumntype::dropdown, 2, wra_adminnotices::getstatuses());
        $wfadmin->order = " order by id desc";
    }

    static function getcount() {
        $result = 0;
        $wd = new wra_db();

        $wd->query = "SELECT 
				count(`id`)
				FROM `" . WRA_CONF::$db_prefix . "adminnotices` where status=0";
        // WRA::debug($wd->query);
        $wd->executereader();
        if ($u0 = $wd->read()) {

            $result = $u0[0];
        }
        $wd->close();
        unset($wd);
        return $result;
    }

}

?>