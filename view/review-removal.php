<?php $title = 'Delete your review';

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
    <title>PHP Motors | <?= $title ?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?= $nav_list . layBreadcrumbs($title) ?>

    <main>
        <h1><?= $title ?></h1>

        <p><strong>Warning!</strong> Deletion is permanent. This cannot be undone.</p>
        <?= (isset($message)) ? $message : '' ;?>

        <form class="review-form" method="post" action="/phpmotors/reviews/">

            <label for='screenName'>Screen Name: </label>
            <input readonly type='text' id='screenName' name='screenName' value="<?= substr($_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname'] ?>"> <br>
            
            <label for='reviewText'>Your review:</label> <br>
            <textarea readonly name='reviewText' id='reviewText' cols='40' rows='6' required><?= (isset($reviewToDelete['reviewText'])) ? $reviewToDelete['reviewText'] : '';?></textarea> <br> <br>

            <input type="submit" id="submit" name="submit" value="Delete Review Forever">
            
            <input type="hidden" name="action" value="review-deleted">
            <input type="hidden" name="reviewId" value="<?= (isset($reviewToDelete['reviewId'])) ? $reviewToDelete['reviewId'] : '';?>">

        </form>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html><?php unset($_SESSION['message']); ?>