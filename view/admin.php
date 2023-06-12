<?php $title = 'Admin';
$search = array('client', 'Id', 'name');
$replace = array('', 'User Id', ' name');

if (!$_SESSION['loggedin']) {
    # if not logged in, redirect to log in
    header('Location: /phpmotors/accounts/?action=login');
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
        <h1>Welcome <?=$_SESSION['clientData']['clientFirstname']?></h1>

        <section>
            <h2>Account Information:</h2>
            <!-- for each key in the session's client data, output the key:value pair in an unordered list -->
            <?php echo "<ul>"; foreach ($_SESSION['clientData'] as $dataKey => $dataValue):?>
            <li><?=str_replace($search, $replace, $dataKey)?>: <?=$dataValue?></li>
            <?php endforeach; echo "</ul>"?>
        </section>
        
        <?= ($_SESSION['clientData']['clientLevel'] > 1) 
        ? '<section class="administration divider-top">
            <h2>Administration</h2>
            <p><a href="/phpmotors/vehicles/">Vehicle Management</a></p>
        </section>' 
        : '' ; #if user level 2+, link to vehicle management?>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>
</html>