<?php $title = 'Vehicle Management';
if (!$_SESSION['loggedin']
|| ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] <= 1)) {
    # if not logged in, or if logged in but not an admin, redirect to home
    header('Location: /phpmotors/?action=log_in_first');
    exit;
}
?><!DOCTYPE html>
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
        <h1><?=$title?></h1>
        
        <a href="/phpmotors/vehicles/index.php?action=add-vehicle">Add Vehicle</a> <br> <br>
        <a href="/phpmotors/vehicles/index.php?action=add-class">Add Classification</a>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>