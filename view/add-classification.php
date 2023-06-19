<?php $title = 'Add Classification';
if (!$_SESSION['loggedin']
|| ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] < 2)) {
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
    <link href="/phpmotors/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | <?= $title ?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?php echo $nav_list; //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; 
    ?>

    <main>
        <h1>Add a vehicle classification</h1>

        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>

        <form class="register-form" method="post" action="/phpmotors/vehicles/">

            <label for="classificationName">Classification Name:</label> <br>
            <span class="hint">Character limit 30</span> <br>
            <input type="text" name="classificationName" id="classificationName" <?= (isset($classificatioName) ? "value='$classificationName'" : '') ?> maxlength="30" autocomplete="none" required> <br>

            <input type="submit" id="register_submit" name="submit" value="Register">
            <input type="reset" id="register_reset" value="Reset">

            <input type="hidden" name="action" value="class-added">

        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>