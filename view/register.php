<?php $title = 'Register'?>

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
        <h1>Create an Account</h1>

        <?php
        if (isset($message)){
            echo $message;
        }
        ?>

        <form class="register-form" method="post" action="/phpmotors/accounts/index.php">

            <label for="register_first_name">First Name:</label> <br>
            <input type="text" name="clientFirstname" id="register_first_name" autocomplete="given-name" required> <br>
            
            <label for="register_last_name">Last Name:</label> <br>
            <input type="text" name="clientLastname" id="register_last_name" autocomplete="family-name" required> <br>
            
            <label for="register_email">Email:</label> <br>
            <input type="email" name="clientEmail" id="register_email" autocomplete="email" required> <br>
            
            <label for="register_password">Password:</label> <br>
            <input type="password" name="clientPassword" id="register_password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" autocomplete="new-password" required> <br>

            <!-- <label for="confirm_password">Confirm Password:</label>  <br>
            <input type="password" name="confirmPassword" id="confirm_password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" autocomplete="off" required> <br> -->
            
            <input type="submit" id="register_submit" name="submit" value="Register">
            <input type="reset"  id="register_reset" value="Reset">

            <input type="hidden" name="action" value="registered">
        
        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>