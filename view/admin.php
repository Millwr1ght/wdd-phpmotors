<?php $title = ($_SESSION['clientData']['clientLevel'] > 1) ? 'Administration' : 'My Account';

checkLogin();

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
        <h1>Welcome <?=$_SESSION['clientData']['clientFirstname']?></h1>

        <?= (isset($message)) ? $message: '' ?>

        <section>
            <h2>Account Information:</h2>
            
            <?= buildClientInfo($_SESSION['clientData']) ?>

            <p><a class="link" href='/phpmotors/accounts/?action=mod' title='Click to modify'>Modify Account Details</a></p>
            <p><a class="link" href='/phpmotors/accounts/?action=del' title='Click to delete'>Delete Account</a></p>

        </section>

        <section class="client-reviews divider-top">
            <h2>Your Product Reviews</h2>
            <?= (isset($manageReviews)) ? $manageReviews : '<p class="notice">It looks like you have not reviewed anything in our inventory.</p>';?>
        </section>
        
        <?= ($_SESSION['clientData']['clientLevel'] > 1) ? $admin_section : '' ; # if user is admin, add admin section?>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>
</html><?php unset($_SESSION['message']); ?>