<?php $title = ($_SESSION['clientData']['clientLevel'] > 1) ? 'Administration' : 'My Account';
$search = array('client', 'Id', 'name');
$replace = array('', 'User Id', ' name');

if (!$_SESSION['loggedin']) {
    # if not logged in, redirect to log in
    header('Location: /phpmotors/accounts/?action=login');
    exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

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
        <h1>Welcome <?=$_SESSION['clientData']['clientFirstname']?></h1>

        <?php
        if (isset($message)){
            echo $message;
        }
        ?>

        <section>
            <h2>Account Information:</h2>
            <!-- for each key in the session's client data, output the key:value pair in an unordered list -->
            <?php echo "<ul>"; foreach ($_SESSION['clientData'] as $dataKey => $dataValue):?>
            <li><?=str_replace($search, $replace, $dataKey)?>: <?=$dataValue?></li>
            <?php endforeach; echo "</ul>"?>

            <p><a href='/phpmotors/accounts/?action=mod' title='Click to modify'>Modify Account Details</a></p>
            <p><a href='/phpmotors/accounts/?action=del' title='Click to delete'>Delete Account</a></p>

        </section>
        
        <?= ($_SESSION['clientData']['clientLevel'] > 1) ? $admin_section : '' ; # if user is admin, add admin section?>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>
</html><?php unset($_SESSION['message']); ?>