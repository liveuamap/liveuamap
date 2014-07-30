<?php

defined('WERUA') or include('../bad.php');

class wra_cacheflow {

    var $name;
    var $writethis = false;
    var $cacheon = true;
    var $content = "";

    static function clearcache() {

        wra_dir::destroy(WRA_Path . '/cache2/');
    }

    function wra_cacheflow($named, $cacheon) {
        $this->name = WRA::base_url(). $named.intval(time()/1200);
        $this->cacheon = $cacheon;
        if(WRA_CONF::$usedebug)$this->cacheon =false;
    }

    static function cacheexist($name) {
        return(WRA::readCache($name, WRA_CONF::$cachetime));
    }

    function begin() {
        $result = false;

        if ($this->cacheon) {
            ob_start();
        }


        if (!($this->content = WRA::readCache($this->name, WRA_CONF::$cachetime)) || !$this->cacheon)
            $result = true;

        if ($result && $this->cacheon)
            $this->writethis = true;
        return $result;
    }

    function end($returning=false) {

        if ($this->writethis) {
            $this->content = ob_get_contents();

            ob_clean();

            WRA::writeCache($this->content, $this->name);
        }
        if ($this->cacheon) {
            ob_end_clean();

            if(!$returning){
            WRA::e($this->content);
            unset($this->content);}else{
                return $this->content;
            }
        }
    }

}

?>