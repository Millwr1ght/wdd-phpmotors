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

        <form class="register-form">

            <label for="register_first_name">First Name:</label> <br>
            <input type="text" name="first_name" id="register_first_name" autocomplete="given-name" required> <br>
            <label for="register_last_name">Last Name:</label> <br>
            <input type="text" name="last_name" id="register_last_name" autocomplete="family-name" required> <br>
            
            <label for="register_email">Email:</label> <br>
            <input type="email" name="email" id="register_email" autocomplete="email" required> <br>
            <label for="register_password">Password:</label> <br>
            <input type="password" name="password" id="register_password" autocomplete="new-password" required> <br>
            <label for="password_confirm">Confirm Password:</label>  <br>
            <input type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" required> <br>
            
            <input type="submit" value="Sign In">
            <input type="reset" value="Reset">
        
        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>