<?php $title = 'Register'?><!DOCTYPE html>
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
    <?php echo $nav_list; //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?>

    <main>
        <h1>Create an Account</h1>

        <?php
        if (isset($message)){
            echo $message;
        }
        ?>

        <form class="register-form" method="post" action="/phpmotors/accounts/index.php">

            <label for="register_first_name">First Name:</label> <br>
            <input type="text" name="clientFirstname" id="register_first_name" <?=(isset($clientFirstname) ? "value='$clientFirstname'":'')?> autocomplete="given-name" required> <br>
            
            <label for="register_last_name">Last Name:</label> <br>
            <input type="text" name="clientLastname" id="register_last_name" <?=(isset($clientLastname) ? "value='$clientLastname'":'')?>  autocomplete="family-name" required> <br>
            
            <label for="register_email">Email:</label> <br>
            <input type="email" name="clientEmail" id="register_email" autocomplete="email" <?=(isset($clientEmail) ? "value='$clientEmail'":'')?> required> <br>
            
            <label for="register_password">Password:</label> <br>
            <span class="hint">Passwords must have 8+ characters, and at least 1 number, 1 Capital Letter and 1 special character.</span> <br>
            <input type="password" name="clientPassword" id="register_password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" autocomplete="new-password" required> <br>
          
            <input type="submit" id="register_submit" name="submit" class="regbtn" value="Register">
            <input type="reset"  id="register_reset" value="Reset">

            <input type="hidden" name="action" value="registered">
        
        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html><?php unset($_SESSION['message']); ?>