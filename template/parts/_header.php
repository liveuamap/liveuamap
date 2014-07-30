<?php
defined('WERUA') or include('../bad.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?WRA::e($this->cp->pagehead);?></title>
         <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
        <link href="<?WRA::e(WRA::base_url());?>images/favicon.png" type="image/ico" rel="icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta property="og:image" content="<?WRA::e($this->cp->ogimage);?>" />
        <link rel="image_src" href="<?WRA::e($this->cp->ogimage);?>" />
        <meta name="keywords" content="<?php WRA::e($this->cp->keywords);?>" />
        <meta name="description" content="<?php WRA::e($this->cp->description);?>" /> 
        <link rel="image_src" href="<?php  WRA::e($this->cp->ogimage);?>" /><meta property="og:title" content="<?php  WRA::e($this->cp->ogtitle);?>" />
<meta name="twitter:card" content="summary"><meta name="twitter:site" content="@liveuamap"><meta name="twitter:title" content="<?php  WRA::e($this->cp->ogname);?>"><meta name="twitter:description" content="<?php  WRA::e($this->cp->ogdescription);?>">
<meta name="twitter:image" content="<?php  WRA::e($this->cp->ogimage);?>">
<meta property="og:site_name" content="<?php  WRA::e($this->cp->ogname);?>" /><meta property="og:descriprion" content="<?php  WRA::e($this->cp->ogdescription);?>" />
        <?php for($i=0;$i<count($this->cp->styles);$i++){?><link href="<?php WRA::e($this->cp->styles[$i]); ?>ed" type="text/css" rel="Stylesheet" /><?} ?>
        <?php for($i=0;$i<count($this->cp->scripts);$i++){?><script src="<?php WRA::e($this->cp->scripts[$i]); ?>ed" type="text/javascript"></script><?} ?>
 <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBT2mc5vMLpOWWHgHgD6kdmzCLaIFjIWWs&sensor=true"></script>
     <script src="https://connect.facebook.net/en_US/all.js#xfbml=1&appId=377520852390985"></script>
 
    </head>
    <body<? if($this->cp->bodyclass!=''){?> class="<?php WRA::e($this->cp->bodyclass); ?>"<?} ?> id="top">
        <script type="text/javascript">wwwpath='<?WRA::e(WRA::base_url());?>';
var wwwfullpath='<?
if($this->requestedpage!='index')
WRA::e($this->requestedpage);?>';
        </script>
        <?php if(false){?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53054ae228fc2a02"></script>
<script type="text/javascript">
    
  addthis.layers({
    'theme' : 'transparent',
    'share' : {
      'position' : 'bottom',
      'numPreferredServices' : 3
    }   
  });
        </script><?php }?>