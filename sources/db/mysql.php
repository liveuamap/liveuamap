<?php

defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">������ �������. Contact rdx.dnipro@gmail.com</div>');

class wra_db {

    var $connection;
    var $dbhost;
    var $dbuser;
    var $dbpassword;
    var $dbdb;
    var $db_prefix;
    var $query;
    private $result;
    var $rows_count;
    var $error;

    function wra_db($wf=null, $isopen = true) {

        if(!isset($wf->dbconnection)){
           
            $this->open(wf::$dbglobal);
        }else{
        $this->open($wf->dbconnection);}
    }

    function open($conn) {


        $this->connection = $conn;
    }

    function execute($catcherror=true) {
        $this->error = '';
        
        @mysql_query($this->query, $this->connection);
        
        if($catcherror)
        $this->catcherror();
    }

    function executereader() {

        $this->error = '';
        $this->result = @mysql_query($this->query, $this->connection);
        $this->rows_count = @mysql_num_rows($this->result);
        // WRA::debug($this->query);
        $this->catcherror();
    }

    function catcherror() {
     
     
      // try{
        $this->error = mysql_errno($this->connection) . ":" . mysql_error($this->connection);
       // echo '<pre>';
            // print_r( debug_backtrace());  
            // echo '</pre>';
       //}catch (Exception $e) {
           
             
           
      // }
        if ($this->error == "0:")
            $this->error = "";
        if ($this->error != "") {
            // WRA::e( "<br/><font style='font-size:10pt'>" . $this->query . "</font><br/>");
            if (WRA_CONF::$usedebug)
                WRA::e($this->error . '<br/>' . $this->query);
          //      var_dump(debug_backtrace());
            $this->close();
        }
    }

    function readfield() {
     
        $this->error = '';
        $result = @mysql_fetch_field($this->result);
        $this->catcherror();
        return $result;
    }

    function read() {
        $this->error = '';
        $result = @mysql_fetch_array($this->result);
        $this->catcherror();
        return $result;
    }

    function readresult($row, $field) {

        $this->error = '';
        $result = @mysql_result($this->result, $row, $field);
        $this->catcherror();
        return $result;
    }

    function getlastkey() {

        if (!WRA_CONF::$usegetkey)
            return mysql_insert_id($this->connection);
    }

    function createdb() {

        mysql_create_db($this->dbdb, $this->connection);
    }

    function dropdb() {

        mysql_drop_db($this->dbdb, $this->connection);
    }

    function close() {

    }

    function __destruct() {
        unset($this->query);
        unset($this->result);
        @$this->close();
    }

}

?>