<?php $title = 'Login'?>

<!-- manage php session varables before this comment -->
<!DOCTYPE html>
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
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form class="login-form">
            <label for="login_email">Email:</label> <br>
            <input type="email" name="email" id="login_email" autocomplete="email" required> <br>
            
            <label for="login_password">Password:</label> <br>
            <input type="password" name="password" id="login_password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required> <br>
            
            <input type="submit" value="Sign In">
        </form>

        <a class="register-link" href="index.php?action=register">Not a member yet? <strong>Sign up here!</strong></a>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>