<?php $title = 'Add Vehicle'?>

<!-- manage php session varables before this comment -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | <?=$title?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?php echo $nav_list; //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?>

    <main>
        <h1><?=$title?> to Inventory</h1>

        <?php
        if (isset($message)){
            echo $message;
        }
        ?>

        <form class="register-form" method="post" action="/phpmotors/vehicles/index.php">


            <label for="invMake">Make:</label> <br>
            <input type="text" name="invMake" id="invMake" autocomplete="none" placeholder="Boeing" required> <br>

            <label for="invModel">Model:</label> <br>
            <input type="text" name="invModel" id="invModel" autocomplete="none" placeholder="747" required> <br>
            
            <label for="invColor">Color:</label> <br>
            <input type="text" name="invColor" id="invColor" autocomplete="none" placeholder="Black" required> <br>
        
            <label for="classificationId">Vehicle Classification:</label> <br>
            <select name="classificationId" id="classificationId">

                <?php foreach ($classifications as $classification): ?>
                <option value="<?=$classification['classificationId']?>"><?=$classification['classificationName']?></option>
                <?php endforeach; //did you know that you could do this like this with php? wild. ?>

            </select> <br> <br>
        
            <label for="invDescription">Description:</label> <br>
            <textarea name="invDescription" id="invDescription" cols="30" rows="10"></textarea> <br> <br>

            <input type="hidden" name="invImage" value="/images/no-image.png">
            
            <input type="hidden" name="invThumbnail" value="/images/no-image.png">

            <label for="invPrice">Price:</label> <br>
            <input type="text" name="invPrice" id="invPrice" autocomplete="none" placeholder="23456.78" required> <br>
            
            <label for="invStock">Stock:</label> <br>
            <input type="text" name="invStock" id="invStock" autocomplete="none" placeholder="230"required> <br> <br>

            
            <input type="submit" id="register_submit" name="submit" value="Register">
            <input type="reset"  id="register_reset" value="Reset">

            <input type="hidden" name="action" value="vehicle-added">
        
        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>