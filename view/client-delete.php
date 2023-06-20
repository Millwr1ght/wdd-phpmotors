<?php $title = 'Delete Your Account';

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
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | <?=$title?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?= $nav_list . layBreadcrumbs($title) ?>

    <main>
        <h1>Delete Your Account</h1>

        <?php
        if (isset($message)){
            echo $message;
        }
        ?>

        <section class="divider-top">

            <h2>Account Information</h2>

            <form class="register-form" method="post" action="/phpmotors/accounts/">

                <label for="delete_first_name">First Name:</label> <br>
                <input readonly type="text" name="clientFirstname" id="delete_first_name" <?= (isset($_SESSION['clientData']['clientFirstname'])) ? "value=" . $_SESSION['clientData']['clientFirstname'] : '' ; ?>> <br>

                <label for="delete_last_name">Last Name:</label> <br>
                <input readonly type="text" name="clientLastname" id="delete_last_name" <?= (isset($_SESSION['clientData']['clientLastname'])) ? "value=" . $_SESSION['clientData']['clientLastname'] : '' ; ?>> <br>

                <label for="delete_email">Email:</label> <br>
                <input readonly type="email" name="clientEmail" id="delete_email" <?= (isset($_SESSION['clientData']['clientEmail'])) ? "value=" . $_SESSION['clientData']['clientEmail'] : '' ; ?>> <br>


                <input type="submit" id="delete_submit" name="submit" value="Delete Forever">

                <input type="hidden" name="action" value="client-delete-account">
                <input type="hidden" name="clientId" value="<?= (isset($_SESSION['clientData']['clientId'])) ? $_SESSION['clientData']['clientId'] : '' ;?>">

            </form>
        </section>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html><?php unset($_SESSION['message']); ?>