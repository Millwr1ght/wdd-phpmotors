<?php $title = 'Vehicle Management';
checkAdminPrivilege();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
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
        <h1><?=$title?></h1>
        
        <a href="/phpmotors/vehicles/?action=add-vehicle">Add Vehicle</a> <br> <br>
        <a href="/phpmotors/vehicles/?action=add-class">Add Classification</a> <br> <br>

        <section class="divider-top">
            <?= (isset($message)) ? $message : '' ; ?>
            <?= (isset($classificationList)) ? 
                    '<h2>Vehicles By Classification</h2>'.
                    '<label for="classificationList">Choose a classification to see those vehicles: </label>'.
                    $classificationList .' <br> <br>'
                    : ''; ?>
                    
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>

            <table id="inventoryDisplay"></table>
        </section>
        

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    <script src="../js/inventory.js"></script>
</body>

</html><?php unset($_SESSION['message']); ?>