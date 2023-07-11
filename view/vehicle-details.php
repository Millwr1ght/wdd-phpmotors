<?php $title = (isset($vehicleName)) ? $vehicleName : 'Vehicle Details';

if (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin']) && !$_SESSION['loggedin'])) {
    # if not logged in, the user can't submit reviews
    $loginMessage = "<p class='notice'>You must log in first to leave a review</p>";
}
$loggedin = (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin']) && !$_SESSION['loggedin']));
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
        <h1><?= $title ?></h1>

        <?= (isset($message)) ? $message: '' ?>

        <div class="main-content details">
            
            <?= (isset($vehicleDetails)) ? $vehicleDetails : '';?>
            <?= (isset($vehicleReviews)) ? $vehicleReviews : '';?>


            <section class="details-reviews">

                <h2>Submit Your Review</h2>

                <?= (isset($loginMessage)) ? $loginMessage : buildReviewForm($_SESSION['clientData']['clientId'], $invId) ;?>

            </section>

        </div>
    
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>
</html>