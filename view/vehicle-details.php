<?php $title = (isset($vehicleName)) ? $vehicleName : 'Vehicle Details';

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

        <div class="main-content">
            
            <?= (isset($vehicleDetails)) ? $vehicleDetails : '' ?>

            <!-- <figure class="details-image">
                <img src="..<?= $invInfo['invImage']?>" alt="No image available">
                <figcaption></figcaption>
            </figure>

            <section class="details-content">
                <h2>Vehicle Details</h2>
                <div class="dc__price flex-row">
                    <span>Price: </span>
                    <span>$<?= $invInfo['invPrice'] ?></span>
                </div>
                <div class="dc__color flex-row">
                    <span>Color: </span>
                    <span><?= $invInfo['invColor'] ?></span>
                </div>
                <div class="dc__stock flex-row">
                    <span># left in stock: </span>
                    <span><?= $invInfo['invStock'] ?></span>
                </div>
                <p class="dc__description">
                <?= $invInfo['invDescription'] ?>
                </p>

            </section> -->
        
        </div>
    
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>
</html>