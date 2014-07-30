<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">������ �������. Contact </div>');

class wra_page {

    var $pagehead = '';
    var $keywords = '';
    var $underthebody='';
    var $description = '';
    var $author = '';
    var $scripts = array();
    var $styles = array();
    var $meta = array();
    var $abspath = '';
    var $bodyclass = '';
    var $currentlink = '';
    var $error = '';
    var $currentuser;
    //------fb variables
    var $facebook;
    var $user_profile;
    var $logoutUrl;
    var $loginUrl;
    var $signed_request;
    //---------------------
    var $itemsonpage = 10;

    var $dict;
    var $language;

    var $baseico = false;
    var $langs = array();


    function favicon() {
        return '<link rel="icon" type="image/ico" href="../images/favicon.png">';
    }

    function set_defaults() {
    
        $this->pagehead = WRA_CONF::$pagehead;
        $this->keywords = WRA_CONF::$keywords;
        $this->description = WRA_CONF::$description;
        $this->author = WRA_CONF::$author;
        $this->abspath = '../';
    }
    function parsePageSignedRequest() {
        if (isset($_REQUEST['signed_request'])) {
          $encoded_sig = null;
          $payload = null;
          list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
          $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
          $data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
          return $data;
        }
        return false;
      }
    function wra_page() {
        $this->set_defaults();
      
        
   
 
    }

 
    function norobots() {

        $this->add_meta('<meta name="robots" content="noindex,nofollow" />');
    }

    function addtinymce() {


        $this->add_script($this->abspath . '/scripts/tiny_mce/jquery.tinymce.js');
    }

    function add_validate() {

        $this->add_script($this->abspath . '/scripts/jquery/validate.js');
    }

    function add_numberinput() {

        $this->add_script($this->abspath . '/scripts/jquery/numberInput.js');
    }

    function add_jquery() {

        array_unshift($this->scripts, WRA::base_url() . 'scripts/jquery/jquery.js?g');
    }

    function add_jqueryui() {
        array_unshift($this->scripts, WRA::base_url() . 'scripts/jquery/jquery-ui.js?g');

        $this->add_style('styles/jquery-ui.css');
    }

    function add_meta($meta) {
        $this->meta[count($this->meta)] = $meta;
    }

    function add_script($script) {
        if (!in_array(WRA::base_url() .$script, $this->scripts))
            $this->scripts[] = WRA::base_url() .$script . '?g';
    }

    function add_style($style) {
        $this->styles[] = WRA::base_url() .$style . '?g';
    }

}

?>