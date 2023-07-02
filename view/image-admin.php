<?php $title = 'Image Management';
checkAdminPriviledge();

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
    <title>PHP Motors | <?=$title?></title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?= $nav_list . layBreadcrumbs($title) ?>

    <main>
        <h1><?=$title?></h1>

        <section class="image-add">
            <h2>Add New Vehicle Image</h2>
            <?= (isset($message)) ? $message : '' ?>

            <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data" class="image-form">
                <label for="invItem">Vehicle: </label>
                    <?= $prodSelect ?>
                    <fieldset>
                        <label>Is this the main image for the vehicle?</label>
                        <label for="priYes" class="pImage">Yes</label>
                        <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
                        <label for="priNo" class="pImage">No</label>
                        <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
                    </fieldset>
                <label>Upload Image:</label>
                <input type="file" name="file1"> <br>

                <input type="submit" class="regbtn" value="Upload">
                <input type="hidden" name="action" value="upload">
            </form>
        </section>
        
        <section class="image-display divider-top">
            <h2>Existing Images</h2>

            <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
            <?= (isset($imageDisplay)) ? $imageDisplay : '<p class="notice"> Sorry, something with the display went wrong.</p>'?>
        </section>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    <script src="../js/inventory.js"></script>
</body>

</html><?php unset($_SESSION['message']); ?>