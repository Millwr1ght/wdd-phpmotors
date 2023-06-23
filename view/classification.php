<?php $title = $classificationName

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | <?=$title?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?= $nav_list . layBreadcrumbs($title) ?>
    <main>
        <h1><?= $title ?></h1>

        <?= (isset($vehicleDisplay))? $vehicleDisplay : ((isset($message))? $message:'');?>


        <ul>
        <li class='vehicle-card'>
            <a href='/phpmotors/vehicles/?action=listing?invId=$cardId'>
            <img class='vc__img' src='$cardThumbnail' alt='Image of $cardTitle'>
            <hr>
            <h2 class='vc__title'>$cardTitle</h2>
            <span class='vc__price'>$$cardPrice</span>
            </a>
        </li>
        </ul>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>
</html>