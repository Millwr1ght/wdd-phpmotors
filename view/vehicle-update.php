<?php $title = 'Modify';
if (!$_SESSION['loggedin']
|| ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] < 2)) {
    # if not logged in, or if logged in but not an admin, redirect to home
    header('Location: /phpmotors/?action=log_in_first');
    exit;
}
# finish title
if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
    $title .= " $invInfo[invMake] $invInfo[invModel]";
} elseif (isset($invMake) && isset($invModel)) {
    $title .= " $invMake $invModel";
} else {
    $title .= ' Vehicle information';
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | <?= $title ?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?php echo $nav_list; //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; 
    ?>

    <main>
        <h1><?= $title ?></h1>

        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>

        <form class="register-form" method="post" action="/phpmotors/vehicles/">

            <label for="invMake">Make:</label> <br>
            <input type="text" name="invMake" id="invMake" <?=
                (isset($invMake) 
                    ? "value='$invMake'" 
                    : ((isset($invInfo['invMake'])) 
                        ? "value='$invInfo[invMake]'" 
                        : '')) 
                    ?>
                maxlength="30" title="Character limit 30" autocomplete="none" required> <br>

            <label for="invModel">Model:</label> <br>
            <input type="text" name="invModel" id="invModel" <?=
                (isset($invModel) 
                    ? "value='$invModel'" 
                    : ((isset($invInfo['invModel'])) 
                        ? "value='$invInfo[invModel]'" 
                        : '')) 
                    ?> 
                maxlength="30" title="Character limit 30" autocomplete="none" required> <br>

            <label for="invColor">Color:</label> <br>
            <input type="text" name="invColor" id="invColor" <?=(isset($invColor) ? "value='$invColor'" : ((isset($invInfo['invColor'])) ? "value='$invInfo[invColor]'" : '')) ?> maxlength="20" title="Character limit 20" autocomplete="none" required> <br>

            <label for="classificationId">Vehicle Classification:</label> <br>
            <select name="classificationId" id="classificationId">
                <?php console_log( $classificationId .', '. $invInfo['classificationId'] );
                console_log($carclassifications);?>
                <option>Choose a Category</option>
                <?php foreach ($carclassifications as $classification): ?>
                <option value="<?=$classification['classificationId']?>" <?=( isset($classificationId) && $classificationId == $classification['classificationId'] ? 'selected' : ((isset($invInfo['classificationId']) && $invInfo['classificationId'] == $classification['classificationId']) ? 'selected' : '')) ?> ><?=$classification['classificationName']?></option>
                <?php endforeach; //did you know that you could do this like this with php? wild. ?>

            </select> <br> <br>

            <label for="invDescription">Description:</label> <br>
            <textarea name="invDescription" id="invDescription" cols="40" rows="6"><?= (isset($invDescription) ? $invDescription : ((isset($invInfo['invDescription'])) ? $invInfo['invDescription'] : '')) ?></textarea> <br> <br>

            <label for="invImage">Image file path:</label> <br>
            <input type="text" name="invImage" id="invImage" <?=(isset($invImage) ? "value='$invImage'" : ((isset($invInfo['invImage'])) ? "value='$invInfo[invImage]'" : 'value="/images/no-image.png"'))?> maxlength="50" title="Character limit 50" required> <br>

            <label for="invThumbnail">Thumbnail file path:</label> <br>
            <input type="text" name="invThumbnail" id="invThumbnail" <?=(isset($invThumbnail) ? "value='$invThumbnail'" :((isset($invInfo['invThumbnail'])) ? "value='$invInfo[invThumbnail]'" : 'value="/images/no-image.png"'))?> maxlength="50" title="Character limit 50" required> <br>

            <label for="invPrice">Price:</label> <br>
            <input type="text" name="invPrice" id="invPrice" placeholder="$" <?=(isset($invPrice) ? "value='$invPrice'" : ((isset($invInfo['invPrice'])) ? "value='$invInfo[invPrice]'" : '')) ?> autocomplete="none" maxlength="10" title="Max Price 9,999,999.99; Do not include commas" required> <br>

            <label for="invStock">Stock:</label> <br>
            <input type="text" name="invStock" id="invStock" placeholder="#" <?=(isset($invStock) ? "value='$invStock'" : ((isset($invInfo['invStock'])) ? "value='$invInfo[invStock]'" : '')) ?> autocomplete="none" maxlength="6" title="Max quantity 999,999; Do not include commas" required> <br> <br>


            <input type="submit" id="register_submit" name="submit" value="Update">
            <input type="reset"  id="register_reset" value="Reset">

            <input type="hidden" name="action" value="vehicle-modded">
            <input type="hidden" name="invId" value="<?= 
                (isset($invInfo['invId'])) 
                    ? $invInfo['invId'] 
                    : ((isset($invId))
                        ? $invId
                        : '');
                ?>">

        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>