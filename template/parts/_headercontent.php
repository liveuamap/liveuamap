<?defined('WERUA') or include('../bad.php');?>
<script type="text/javascript">
            <?php if(!empty($this->ll[1])){?>
            lat=<?php WRA::e($this->ll[0]);?>;
            lng=<?php WRA::e($this->ll[1]);?>;
        <?php }?>
        <?php if($this->zoom!=0){?>
            zoom=<?php WRA::e($this->zoom);?>;
        <?php }?>
    </script>