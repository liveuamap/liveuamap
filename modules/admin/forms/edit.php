<?
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

$this->cap->save();
$this->useadd_button=true;

function flushpage($currentlink,$cap){
	$cap->flush();
	
	
}

?>