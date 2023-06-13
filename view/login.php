<?php $title = 'Login'?><!DOCTYPE html>
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
        <h1>Sign In</h1>

        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        } else if (isset($message)){
            echo $message;
        }
        
        ?>

        <form class="login-form"  method="post" action="/phpmotors/accounts/">

            <label for="clientEmail">Email:</label> <br>
            <input type="email" name="clientEmail" id="clientEmail" <?=(isset($clientEmail) ? "value='$clientEmail'":'')?> autocomplete="email" required> <br>
            
            <label for="clientPassword">Password:</label> <br>
            <span class="hint">Passwords must have 8+ characters, and at least 1 number, 1 Capital Letter and 1 special character.</span> <br>
            <input type="password" name="clientPassword" id="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" autocomplete="none" required> <br>
            
            <input type="submit" value="Sign In">
            <input type="reset" value="Reset">

            <input type="hidden" name="action" value="logged-in">
        </form>

        <a class="register-link" href="index.php?action=register">Not a member yet? <strong>Sign up here!</strong></a>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>