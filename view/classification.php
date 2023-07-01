<?php 
$notAdjectives = array('Trucks', 'SUV', 'Boats');
$title = $classificationName . ((in_array($classificationName, $notAdjectives)) ? '' : ' vehicles');

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | <?=$title?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?= $nav_list . layBreadcrumbs($title) ?>
    <main>
        <h1><?= $title ?></h1>
        <?= (isset($message)) ? $message: '' ?>
        <?= (isset($vehicleDisplay)) ? $vehicleDisplay : '' ?>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>
</html>