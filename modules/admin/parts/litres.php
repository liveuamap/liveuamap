<?php defined('WERUA') or include('../../../bad.php');

if(isset($_REQUEST['empty'])){
    $fbu=new wra_fbu();
    $fbu->load($_REQUEST['id']);
    $fbu->points=0;
    $fbu->update();
    $this->rows[0]['points']='0';
    
   
}
?>
<a href="admin?mod=fbuedit&id=50213&empty=<?WRA::e($this->rows[0]['id']);?>">Обнулить литры</a>