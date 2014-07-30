<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_userscontext extends wfbaseclass{

    static function isloged() {
        if (wra_vku::isvkd()) {
            if (self::curuser()){
                return true;
            } else {
                return false;
            }
        }
        if (wra_fbu::isfbd()) {
            if (self::curuser()){
                return true;
            } else {
                return false;
            }
        }
        if (isset($_COOKIE['uid']) && isset($_COOKIE['passs'])) {
            $_SESSION['uid'] = $_COOKIE['uid'];
            $_SESSION['passs'] = $_COOKIE['passs'];
        }
        if (isset($_SESSION['uid']) && isset($_SESSION['passs'])) {
            if (wra_userscontext::confirm_user($_SESSION['uid'], $_SESSION['passs']) != 0) {                
                unset($_SESSION['uid']);
                unset($_SESSION['passs']);
                return false;
            }
            return true;
        }
        return false;
    }

    static function curuser() {
        return @$_SESSION['uid'];
    }

    static function login($wf,$username, $password, $rememberme) {
        $result = 0;
        if (!$username || !$password)
            return 0;
        $username = trim($username);
        $password = trim($password);
        $md5pass = md5($password);
        $userid = wra_users::getidbylogin($wf,$username);
        $r0 = wra_userscontext::confirm_user($userid, $md5pass);
        if ($r0 != 0)
            return $r0;
        $username = stripslashes($username);
        $_SESSION['uid'] = $userid;
        $_SESSION['passs'] = $md5pass;       
        $result = 5;
        if ($rememberme) {
            setcookie('uid', $_SESSION['uid'], time() + WRA_CONF::$remembertime, '/');
            setcookie('passs', $_SESSION['passs'], time() + WRA_CONF::$remembertime, '/');            
        }
        return $result;
    }

    static function userlogin($wf,$username, $password, $rememberme) {
        $result = 0;
        if (!$username || !$password)
            return 0;
        $username = trim($username);
        $password = trim($password);
        $md5pass = md5($password);
        $userid = wra_users::getidbyemail($wf,$username);
        $r0 = wra_userscontext::confirm_user($userid, $md5pass);
        if ($r0 != 0)
            return $r0;
        $username = stripslashes($username);
        $_SESSION['uid'] = $userid;
        $_SESSION['passs'] = $md5pass;       
        $result = 5;
        if ($rememberme) {
            setcookie('uid', $_SESSION['uid'], time() + WRA_CONF::$remembertime, '/');
            setcookie('passs', $_SESSION['passs'], time() + WRA_CONF::$remembertime, '/');            
        }
        return $result;
    }

    static function logout() {
        if (isset($_COOKIE['uid']) && isset($_COOKIE['passs'])) {
            @setcookie('uid', '', time() - WRA_CONF::$remembertime, '/');
            @setcookie('passs', '', time() - WRA_CONF::$remembertime, '/');
        }
        unset($_SESSION['uid']);
        unset($_SESSION['passs']);
        $_SESSION = array();
        @session_destroy();
    }

    static function confirm_user($userid, $password) {
        $result = 1;
        $username = addslashes($userid);
        $wd = new wra_db();
        $wd->query = 'SELECT password FROM `' . WRA_CONF::$db_prefix . "users` WHERE id = '$userid'";
        $wd->executereader();
        if ($u0 = $wd->read()) {
            if ($password == $u0[0]){
                $result = 0;
            } else {
                $result=2;
            }
        } else {
            $result = 1;
        }
        $wd->close();
        unset($wd);
        return $result;
    }

    static function isemailexist($wf,$email) {
        $result = false;
        if (!WRA::check_email($email))
            return $result;
        $wd = new wra_db();
        $email = addslashes($email);
        $wd->query = 'SELECT login FROM `' . WRA_CONF::$db_prefix . "users` WHERE email = '$email'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    static function ismd5idexist($wf,$md5id) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT login FROM `' . WRA_CONF::$db_prefix . "users` WHERE MD5(id) = '$md5id'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    static function isidexist($wf,$id) {
        $result = false;
        $wd = new wra_db();
        $wd->query = 'SELECT login FROM `' . WRA_CONF::$db_prefix . "users` WHERE id = '$id'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    static function isloginexist($wf,$username) {
        $result = false;
        $wd = new wra_db();
        $username = addslashes($username);
        $wd->query = 'SELECT login FROM `' . WRA_CONF::$db_prefix . "users` WHERE login = '$username'";
        $wd->executereader();
        $result = ($u0 = $wd->read());
        $wd->close();
        unset($wd);
        return $result;
    }

    static function getaccess($link) {
        $result = false;
        $classname = 'wra_'.ltrim(ltrim($link,'admin'),'/');
        if (!class_exists($classname)) {
            return true;
        }
        $uaccess = array();
        eval('$uaccess = '.$classname.'::getacceslevel();');
        if (!empty($uaccess)){
            foreach ($uaccess as $v) {
                $r = self::hasright($v);
                $result = ($r)? true:$result;
            }
        } else {
            $result = true;
        }
        return $result;
    }

    static function hasright($rightname) {
        // WRA::debug($rightname);
        // die();
        if (self::isloged()||wra_u::islogin()){
            $userid = self::curuser();
            $urights = wra_usersrights::getlist($userid);
            switch ($rightname) {
                case 'adminpage':
                    if (in_array(1, $urights)){
                    return true;      }else{
                          if (wra_u::islogin()) {
                              $uid=wra_u::logedUser();
                         
                              if($uid->points>0){
                                   return true; 
                              }
                             
                              
                          }
                        
                    }
                    // if (in_array(5, $urights))
                        // return true;
                    break;
                case 'admin':
                    if (in_array(1, $urights)){
                    return true;      }
                    break;
                case 'user':
                    if (in_array(4, $urights))
                        return true;      
                    break;
                case 'expert':
                    if (in_array(5, $urights))
                        return true;      
                    break;
                default:
                    return false;      
                    break;
            }
            return false;      
        } else {
            return false;
        }
    }

}