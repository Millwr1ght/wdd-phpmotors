<?php $title = 'Delete';
checkAdminPrivilege();

if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
    $title .= " $invInfo[invMake] $invInfo[invModel]";
} else {
    $title .= ' Vehicle';
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | <?= $title ?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?= $nav_list . layBreadcrumbs($title) ?>

    <main>
        <h1><?= $title ?></h1>

        <p><strong>Warning!</strong> Deletion is permanent. This cannot be undone.</p>
        <?= (isset($message)) ? $message : '' ;?>

        <form class="register-form" method="post" action="/phpmotors/vehicles/">

            <label for="invMake">Make:</label> <br>
            <input readonly type="text" name="invMake" id="invMake" <?= (isset($invInfo['invMake'])) ? "value='$invInfo[invMake]'" : ''; ?>> <br>

            <label for="invModel">Model:</label> <br>
            <input readonly type="text" name="invModel" id="invModel" <?= (isset($invInfo['invModel'])) ? "value='$invInfo[invModel]'" : ''; ?>> <br>

            <label for="invDescription">Description:</label> <br>
            <textarea readonly name="invDescription" id="invDescription" cols="40" rows="6"><?= (isset($invInfo['invDescription'])) ? $invInfo['invDescription'] : '' ?></textarea> <br> <br>


            <input type="submit" id="register_submit" name="submit" value="Delete Vehicle Forever">
            
            <input type="hidden" name="action" value="vehicle-deleted">
            <input type="hidden" name="invId" value="<?= (isset($invInfo['invId'])) ? $invInfo['invId'] : '';?>">

        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html><?php unset($_SESSION['message']); ?>