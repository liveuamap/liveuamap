<?php
defined('WERUA') or include('../bad.php');

class wfitem extends wfitemwti {
 var $items=array();
  function wfitem($wf) {
    header("Content-Type: application/xml; charset=UTF-8");
  }

  function run() {
    parent::run();
    $this->nofooter=true;
    $this->noheader=true;
   
                      

  }

    function show() {
             $cache0=new wra_cacheflow('sitemap',true);
                            
                        if ($cache0->begin()) {
                            $this->items=  wra_foursqvenues::get_listall();
     WRA::e('<?'); ?>xml version="1.0" encoding="UTF-8"<? WRA::e('?>'); ?>

<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
      <loc><?php WRA::e(WRA::base_url()); ?></loc>
      <changefreq>hourly</changefreq>
  </url>
    <url>
      <loc><?php WRA::e(WRA::base_url()); ?>history</loc>
      <changefreq>hourly</changefreq>
  </url>
<?php foreach($this->items as $a0){ ?>
  <url>
      <loc><?php WRA::e($a0->getlink()); ?></loc>
      <changefreq>yearly</changefreq>
  </url>
<?php } ?>
  
</urlset><?
    
    }   $cache0->end();
}}
    ?>
