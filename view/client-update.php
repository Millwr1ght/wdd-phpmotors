<?php $title = 'Update Account Information';

if (!$_SESSION['loggedin']) {
    # if not logged in, redirect to log in
    header('Location: /phpmotors/accounts/?action=login');
    exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
$message_location = (isset($_SESSION['message_location'])) ? $_SESSION['message_location'] : '' ;

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
        <h1>Update Your Account</h1>

        <?php
        if (isset($message) && !in_array($message_location, Array('update-account', 'update-password'))){
            echo $message;
        }
        ?>

        <section class="divider-top">

            <h2>Account Information</h2>
        
            <?php
            if (isset($message) && $message_location == 'update-account'){
                echo $message;
            }
            ?>

            <form class="register-form" method="post" action="/phpmotors/accounts/">

                <label for="update_first_name">First Name:</label> <br>
                <input type="text" name="clientFirstname" id="update_first_name" <?= (isset($_SESSION['clientData']['clientFirstname']) ? "value=" . $_SESSION['clientData']['clientFirstname'] : (isset($clientFirstname) ? "value='$clientFirstname'" : '' )); ?> autocomplete="given-name" required> <br>

                <label for="update_last_name">Last Name:</label> <br>
                <input type="text" name="clientLastname" id="update_last_name" <?= (isset($_SESSION['clientData']['clientLastname']) ? "value=" . $_SESSION['clientData']['clientLastname'] : (isset($clientLastname) ? "value='$clientLastname'" : '' )); ?> autocomplete="family-name" required> <br>

                <label for="update_email">Email:</label> <br>
                <input type="email" name="clientEmail" id="update_email" <?= (isset($_SESSION['clientData']['clientEmail']) ? "value=" . $_SESSION['clientData']['clientEmail'] : (isset($clientEmail) ? "value='$clientEmail'" : '' )); ?> autocomplete="email" required> <br>


                <input type="submit" id="update_submit" name="submit" value="Save">
                <input type="reset"  id="update_reset" value="Reset">

                <input type="hidden" name="action" value="client-update-account">
                <input type="hidden" name="clientId" value="<?= (isset($_SESSION['clientData']['clientId'])) ? $_SESSION['clientData']['clientId'] : ((isset($clientId)) ? $clientId : '') ;?>">

            </form>
        </section>


        <section class="divider-top">
            
            <h2>Change Password</h2>

            <?php
            if (isset($message) && $message_location == 'update-password'){
                echo $message;
            }
            ?>

            <form class="register-form" method="post" action="/phpmotors/accounts/">
                
                <!-- <label for="old_password">Old Password:</label> <br>
                <input type="password" id="old_password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required> <br> -->

                <label for="update_password">New Password:</label> <br>
                <span class="hint">This will change your password!</span> <br>
                <span class="hint">Passwords must have 8+ characters, and at least 1 number, 1 Capital Letter and 1 special character.</span> <br>
                <input type="password" name="clientPassword" id="update_password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" autocomplete="new-password" required> <br>
            
                <input type="submit" id="password_submit" name="submit" value="Submit">
                <input type="reset"  id="password_reset" value="Reset">

                <input type="hidden" name="action" value="client-update-password">
                <input type="hidden" name="clientId" value="<?= (isset($_SESSION['clientData']['clientId'])) ? $_SESSION['clientData']['clientId'] : ((isset($clientId)) ? $clientId : '') ;?>">

            </form>
        </section>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html><?php unset($_SESSION['message']); unset($_SESSION['message_location']);?>