<?defined('WERUA') or include('../bad.php');?>
<?
$cache0=new wra_cacheflow('platinumfooter',$this->wf->caching);
 if ($cache0->begin()) {
     if (WRA_CONF::$usestat) {
	 include 'analytics.php';
};
}
$cache0->end();
?></body></html>