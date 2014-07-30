<?

//include WRA_Path . "\\lang\\" . wra_lang::getcurlang() . "\\sources\\lang.php";

class wra_dictionary {
    var $lang = 'ru';
    function select($text) {
        return $text;

    }

    function getword($text, $lang = 'ru') {
        $langdict = WRA::$langdict;
        //die (print_r($langdict));
        $equlangid = -1;
        //die($lang);
        //print_r($langdict);
        $md5text = md5($text);
        //print($text);
        foreach ($langdict as $key => $value) {
            if (!empty($value['value']))
            if ((md5($value['value']) == $md5text) and ($value['lang'] == 'ru')) {
                //print $value['value'].$text.'<br>';
                $equlangid = $key;
                break;
            }
        }
        $begintext=$text;
        //print($equlangid);
        //print($lang);
        //print_r($langdict);
        foreach ($langdict as $key => $value) {
            //print_r($value);
            if (($value['table'] == $langdict[$equlangid]['table']) and ($value['field'] == $langdict[$equlangid]['field']) and ($value['rowid'] == $langdict[$equlangid]['rowid']) and ($value['lang']==$lang)) {
                /*print $value['table'].$langdict[$equlangid]['table'].'<br>';
                print $value['field'].$langdict[$equlangid]['field'].'<br>';
                print $value['rowid'].$langdict[$equlangid]['rowid'].'<br>';
                print $value['lang'].$lang.'<br>';*/
                if(!empty($value['value']))
                $text = $value['value'];
                break;
            }
        }
        //print($text);
        return $text;
    }

    function e($text,$lang = 'ru') {

        WRA::e($this->getword($text,$lang));
    }

    function getp0($text) {
        $return = $this->getword($text);

        if (substr($return, 0, 3) == '<p>') {
            return substr($return, 3, strlen($return) - 7);
        } else {
            return $return;
        }
    }

    function ep0($text) {
        $return = $this->getword($text);
        if (substr($return, 0, 3) == '<p>') {
            WRA::e(substr($return, 3, strlen($return) - 7));
        }else
            WRA::e($return);
    }

}

?>