<?php
    // add pageId (/phpmotors/$pageId) and pageName (what will be listed in the nav) to this array to extend nav menu
    // maybe add way to pass an array and callback to make this applicable for all menus
    $pages = array(
        'home' => 'Home',
        'classic' => 'Classic',
        'sports' => 'Sports',
        'suv' => 'SUV',
        'trucks' => 'Trucks',
        'used' => 'Used'
    );
    // echo $_SERVER['REQUEST_URI'] // /phpmotors/$currentPageId
    $currentPageId = ($_SERVER['REQUEST_URI'] == '/phpmotors/template.php') ? 'classic' : 'home' ; // TODO: un-'hardcode' this
?>

<nav class="nav-top" id="page-nav">

    <?php foreach ($pages as $pageId => $pageName): ?>
    <a href="/phpmotors/<?=($pageId == 'home' ? 'index.php' : $pageId);?>"<?=($pageId == $currentPageId) ? ' class="active"' : '' ;?>><?=$pageName?></a>
    <?php endforeach; ?>
    
    <!-- <a href="/phpmotors/" class="active">Home</a>
    <a href="/phpmotors/classic">Classic</a>
    <a href="/phpmotors/sports">Sports</a>
    <a href="/phpmotors/suv">SUV</a>
    <a href="/phpmotors/trucks">Trucks</a>
    <a href="/phpmotors/used">Used</a> -->

</nav>