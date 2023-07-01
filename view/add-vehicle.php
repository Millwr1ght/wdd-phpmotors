<?php $title = 'Add Vehicle';
checkAdminPriviledge();

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
        <h1><?=$title?> to Inventory</h1>

        <?php
        if (isset($message)){
            echo $message;
        }
        ?>

        <form class="register-form" method="post" action="/phpmotors/vehicles/">


            <label for="invMake">Make:</label> <br>
            <input type="text" name="invMake" id="invMake" <?=(isset($invMake) ? "value='$invMake'" : '') ?> maxlength="30" title="Character limit 30" autocomplete="none" required> <br>

            <label for="invModel">Model:</label> <br>
            <input type="text" name="invModel" id="invModel" <?=(isset($invModel) ? "value='$invModel'" : '') ?> maxlength="30" title="Character limit 30" autocomplete="none" required> <br>
            
            <label for="invColor">Color:</label> <br>
            <input type="text" name="invColor" id="invColor" <?=(isset($invColor) ? "value='$invColor'" : '') ?> maxlength="20" title="Character limit 20" autocomplete="none" required> <br>
        
            <label for="classificationId">Vehicle Classification:</label> <br>
            <select name="classificationId" id="classificationId">

                <?php foreach ($carclassifications as $classification): ?>
                <option value="<?=$classification['classificationId']?>" <?=( isset($classificationId) && $classificationId == $classification['classificationId'] ? 'selected' : '') ?> ><?=$classification['classificationName']?></option>
                <?php endforeach; //did you know that you could do this like this with php? wild. ?>

            </select> <br> <br>
        
            <label for="invDescription">Description:</label> <br>
            <textarea name="invDescription" id="invDescription" cols="40" rows="6"><?= (isset($invDescription) ? $invDescription : '') ?></textarea> <br> <br>
            
            <label for="invImage">Image file path:</label> <br>
            <input type="text" name="invImage" id="invImage" <?=(isset($invImage) ? "value='$invImage'" :'value="/images/no-image.png"')?> maxlength="50" title="Character limit 50" required> <br>
            
            <label for="invThumbnail">Thumbnail file path:</label> <br>
            <input type="text" name="invThumbnail" id="invThumbnail" <?=(isset($invThumbnail) ? "value='$invThumbnail'" :'value="/images/no-image.png"')?> maxlength="50" title="Character limit 50" required> <br>

            <label for="invPrice">Price:</label> <br>
            <input type="text" name="invPrice" id="invPrice" placeholder="$" <?=(isset($invPrice) ? "value='$invPrice'" : '') ?> autocomplete="none" maxlength="10" title="Max Price 9,999,999.99; Do not include commas" required> <br>
            
            <label for="invStock">Stock:</label> <br>
            <input type="text" name="invStock" id="invStock" placeholder="#" <?=(isset($invStock) ? "value='$invStock'" : '') ?> autocomplete="none" maxlength="6" title="Max quantity 999,999; Do not include commas" required> <br> <br>

            
            <input type="submit" id="register_submit" name="submit" value="Register">
            <input type="reset"  id="register_reset" value="Reset">

            <input type="hidden" name="action" value="vehicle-added">
        
        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>