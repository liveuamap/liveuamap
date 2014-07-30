<?php

defined('WERUA') or include('../../bad.php');

class wra_liqpay extends wfbaseclass {

    var $id;
    var $version='1.2';
    var $merchant_id;
    var $result_url;
    var $server_url;
    var $order_id;
    var $amount;
    var $currency;
    var $description;
    var $default_phone;
    var $pay_way;
    var $goods_id;
    var $dateadd;
    var $ipadd;
    var $cartid;
    var $statusid;
    var $exp_time;
    var $pays_count;
    var $status;
    var $code;
    var $transaction_id;
    var $pay_way_paid;
    var $pays_count_return;
    var $returndate;
    function flushform(){
        $merchant_id=  WRA_CONF::$liqpaymerchantid;
        $this->merchant_id=$merchant_id;
        $signature=WRA_CONF::$liqpaypassword;
        $url="https://www.liqpay.com/?do=clickNbuy";

	$xml="<request>      
		<version>".$this->version."</version>
		<result_url>".$this->result_url."</result_url>
		<server_url>$this->server_url</server_url>
		<merchant_id>$merchant_id</merchant_id>
		<order_id>$this->id</order_id>
                <goods_id>$this->goods_id</goods_id>
		<amount>$this->amount</amount>
		<currency>$this->currency</currency>
		<description>$this->description</description>
		<default_phone>$this->phone</default_phone>
		<pay_way>$this->method</pay_way> 
		</request>
		";
	
	
            $xml_encoded = base64_encode($xml); 
            $lqsignature = base64_encode(sha1($signature.$xml.$signature,1));
	


            WRA::e("<form action='$url' method='POST' id='frmliqpay' name='frmliqpay'>
                <input type='hidden' name='operation_xml' value='$xml_encoded' />
                <input type='hidden' name='signature' value='$lqsignature' />
                    <input type='submit' value='Pay Now' style='position:absolute;left:50%;top:50%'/>
                    </form>
                    <script>
                        frmliqpay.submit();
                    </script>
                    ");
        
    }
    function wra_liqpay() {
        
    }

    static function adminit($wfadmin) {
        $wfadmin->table = 'liqpay';
        $wfadmin->multilanguages = false;
    //   $wfadmin->columns[] = new admincolumn("String", "version", "Версия", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[] = new admincolumn("String", "merchant_id", "merchant_id", admincolumntype::text, admincolumntype::text, 3);
         $wfadmin->columns[] = new admincolumn("String", "order_id", "Заказ", admincolumntype::text, admincolumntype::text, 6);
        $wfadmin->columns[] = new admincolumn("String", "amount", "Сумма", admincolumntype::text, admincolumntype::text, 7);
        $wfadmin->columns[] = new admincolumn("String", "currency", "Валюта", admincolumntype::text, admincolumntype::text, 8);
        $wfadmin->columns[] = new admincolumn("String", "description", "Описание", admincolumntype::text, admincolumntype::text, 9);
        $wfadmin->columns[] = new admincolumn("String", "default_phone", "Телефон", admincolumntype::text, admincolumntype::text, 10);
        $wfadmin->columns[] = new admincolumn("String", "pay_way", "pay_way", admincolumntype::text, admincolumntype::text, 11);
        $wfadmin->columns[] = new admincolumn("String", "goods_id", "goods_id", admincolumntype::text, admincolumntype::text, 12);
        $wfadmin->columns[] = new admincolumn("DateTime", "dateadd", "Добавлено", admincolumntype::text, admincolumntype::text, 13);
        $wfadmin->columns[] = new admincolumn("String", "ipadd", "IP", admincolumntype::text, admincolumntype::text, 14);
        $wfadmin->columns[] = new admincolumn("String", "cartid", "Заказ", admincolumntype::text, admincolumntype::text, 15);
        $wfadmin->columns[] = new admincolumn("String", "statusid", "Статус", admincolumntype::text, admincolumntype::text, 16);
        $wfadmin->columns[] = new admincolumn("String", "exp_time", "exp_time", admincolumntype::text, admincolumntype::text, 17);
        $wfadmin->columns[] = new admincolumn("String", "pays_count", "pays_count", admincolumntype::text, admincolumntype::text, 18);
        $wfadmin->columns[] = new admincolumn("String", "status", "status", admincolumntype::text, admincolumntype::text, 19);
        $wfadmin->columns[] = new admincolumn("String", "code", "code", admincolumntype::text, admincolumntype::text, 20);
        $wfadmin->columns[] = new admincolumn("String", "transaction_id", "transaction_id", admincolumntype::text, admincolumntype::text, 21);
        $wfadmin->columns[] = new admincolumn("String", "pay_way_paid", "pay_way_paid", admincolumntype::text, admincolumntype::text, 22);
        $wfadmin->columns[] = new admincolumn("String", "pays_count_return", "pays_count_return", admincolumntype::text, admincolumntype::text, 23);
        $wfadmin->columns[] = new admincolumn("DateTime", "returndate", "returndate", admincolumntype::text, admincolumntype::text, 24);
        $wfadmin->order = " order by id asc";
    }

    static function getcount($category) {
        $result = 0;
        $wd = new wra_db();

        $wd->query = 'SELECT count(`id`)
 FROM `' . WRA_CONF::$db_prefix . 'wra_liqpay`';
        $wd->executereader();
        while ($u0 = $wd->read()) {

            $result = $u0[0];
        }
        $wd->close();
        return $result;
    }

    static function get_list($count = 10, $page = 0) {
        $result = array();
        $wd = new wra_db();

        $wd->query = 'SELECT 
 `id`,
 `version`,
 `merchant_id`,
 `result_url`,
 `server_url`,
 `order_id`,
 `amount`,
 `currency`,
 `description`,
 `default_phone`,
 `pay_way`,
 `goods_id`,
 `dateadd`,
 `ipadd`,
 `cartid`,
 `statusid`,
 `exp_time`,
 `pays_count`,
 `status`,
 `code`,
 `transaction_id`,
 `pay_way_paid`,
 `pays_count_return`,
 `returndate`
 FROM `' . WRA_CONF::$db_prefix . "liqpay` 
 LIMIT " . $page * $count . "," . $count . "";
        $wd->executereader();
        while ($u0 = $wd->read()) {
            $r0 = new wra_liqpay();
            $r0->id = $u0[0];

            $r0->version = $u0[1];

            $r0->merchant_id = $u0[2];

            $r0->result_url = $u0[3];

            $r0->server_url = $u0[4];

            $r0->order_id = $u0[5];

            $r0->amount = $u0[6];

            $r0->currency = $u0[7];

            $r0->description = $u0[8];

            $r0->default_phone = $u0[9];

            $r0->pay_way = $u0[10];

            $r0->goods_id = $u0[11];

            $r0->dateadd = $u0[12];

            $r0->ipadd = $u0[13];

            $r0->cartid = $u0[14];

            $r0->statusid = $u0[15];

            $r0->exp_time = $u0[16];

            $r0->pays_count = $u0[17];

            $r0->status = $u0[18];

            $r0->code = $u0[19];

            $r0->transaction_id = $u0[20];

            $r0->pay_way_paid = $u0[21];

            $r0->pays_count_return = $u0[22];

            $r0->returndate = $u0[23];




            $result[] = $r0;
        }
        $wd->close();
        return $result;
    }

    function add() {


        $wd = new wra_db();
        $this->id = WRA::getnewkey("" . WRA_CONF::$db_prefix . 'liqpay');
        $wd->query = 'INSERT INTO `' . WRA_CONF::$db_prefix . "liqpay` (
 `id`,
 `version`,
 `merchant_id`,
 `result_url`,
 `server_url`,
 `order_id`,
 `amount`,
 `currency`,
 `description`,
 `default_phone`,
 `pay_way`,
 `goods_id`,
 `dateadd`,
 `ipadd`,
 `cartid`,
 `statusid`,
 `exp_time`,
 `pays_count`,
 `status`,
 `code`,
 `transaction_id`,
 `pay_way_paid`,
 `pays_count_return`,
 `returndate`
 )VALUES(
 '$this->id',
 '$this->version',
 '$this->merchant_id',
 '$this->result_url',
 '$this->server_url',
 '$this->order_id',
 '$this->amount',
 '$this->currency',
 '$this->description',
 '$this->default_phone',
 '$this->pay_way',
 '$this->goods_id',
 '$this->dateadd',
 '$this->ipadd',
 '$this->cartid',
 '$this->statusid',
 '$this->exp_time',
 '$this->pays_count',
 '$this->status',
 '$this->code',
 '$this->transaction_id',
 '$this->pay_way_paid',
 '$this->pays_count_return',
 '$this->returndate'
 )";
        $wd->execute();
        if (!WRA_CONF::$usegetkey)
            $this->id = $wd->getlastkey();
        $wd->close();
        unset($wd);
    }

    function update() {


        $wd = new wra_db();
        $wd->query = 'UPDATE `' . WRA_CONF::$db_prefix . "liqpay`
SET 
 `id`='$this->id',
 `version`='$this->version',
 `merchant_id`='$this->merchant_id',
 `result_url`='$this->result_url',
 `server_url`='$this->server_url',
 `order_id`='$this->order_id',
 `amount`='$this->amount',
 `currency`='$this->currency',
 `description`='$this->description',
 `default_phone`='$this->default_phone',
 `pay_way`='$this->pay_way',
 `goods_id`='$this->goods_id',
 `dateadd`='$this->dateadd',
 `ipadd`='$this->ipadd',
 `cartid`='$this->cartid',
 `statusid`='$this->statusid',
 `exp_time`='$this->exp_time',
 `pays_count`='$this->pays_count',
 `status`='$this->status',
 `code`='$this->code',
 `transaction_id`='$this->transaction_id',
 `pay_way_paid`='$this->pay_way_paid',
 `pays_count_return`='$this->pays_count_return',
 `returndate`='$this->returndate'
 WHERE `id`='$this->id'";
        $wd->execute();
        $wd->close();
        unset($wd);
    }

    static function isexist($id, $lang = 'ru') {
        $result = false;
        $wd = new wra_db();


        $wd->query = 'SELECT id FROM `' . WRA_CONF::$db_prefix . "liqpay` WHERE `id` = '$id'";

        $wd->executereader();

        if ($u0 = $wd->read())
            $result = $u0['id'];

        $wd->close();
        unset($wd);
        return $result;
    }

    function delete() {
        $wd = new wra_db();

        $wd->query = 'DELETE FROM `' . WRA_CONF::$db_prefix . "liqpay` where `id`='$this->id'";
        $wd->execute();
        $wd->close();

        unset($wd);
        return true;
    }

    function load($id) {
        $wd = new wra_db();
        $this->id = $id;

        $wd->query = 'SELECT 
 `id`,
 `version`,
 `merchant_id`,
 `result_url`,
 `server_url`,
 `order_id`,
 `amount`,
 `currency`,
 `description`,
 `default_phone`,
 `pay_way`,
 `goods_id`,
 `dateadd`,
 `ipadd`,
 `cartid`,
 `statusid`,
 `exp_time`,
 `pays_count`,
 `status`,
 `code`,
 `transaction_id`,
 `pay_way_paid`,
 `pays_count_return`,
 `returndate`
 FROM `' . WRA_CONF::$db_prefix . "liqpay`  where `id`='$this->id'";
        $wd->executereader();
        if ($u0 = $wd->read()) {

            $this->id = $u0[0];

            $this->version = $u0[1];

            $this->merchant_id = $u0[2];

            $this->result_url = $u0[3];

            $this->server_url = $u0[4];

            $this->order_id = $u0[5];

            $this->amount = $u0[6];

            $this->currency = $u0[7];

            $this->description = $u0[8];

            $this->default_phone = $u0[9];

            $this->pay_way = $u0[10];

            $this->goods_id = $u0[11];

            $this->dateadd = $u0[12];

            $this->ipadd = $u0[13];

            $this->cartid = $u0[14];

            $this->statusid = $u0[15];

            $this->exp_time = $u0[16];

            $this->pays_count = $u0[17];

            $this->status = $u0[18];

            $this->code = $u0[19];

            $this->transaction_id = $u0[20];

            $this->pay_way_paid = $u0[21];

            $this->pays_count_return = $u0[22];

            $this->returndate = $u0[23];
        }
        $wd->close();
        unset($wd);
    }

}

?>
