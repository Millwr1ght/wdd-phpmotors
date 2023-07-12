<?php
    // welcome to the reviews controller

    /* imports */
    //utilities
    require_once '../library/console_log.php';
    require_once '../library/functions.php';
    //get the database connection
    require_once '../library/connections.php';
    //get the main model
    require_once '../model/main-model.php';
    require_once '../model/reviews-model.php';
    

    /* variable creation */
    // Create or unpause session
    session_start();

    //get classifications
    $classifications = getClassifications();

    //(re)build the nav
    $nav_list = buildNav($classifications);

    //decide which webpage to show
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    switch ($action){
        case 'template':
            include '../view/template.php';
            break;

        case '500':
        case 'error':
            include '../view/500.php';
            break;
        
        case 'review-submitted':
            //filter data
            $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            //validata (heh heh)
            $invId = filter_var($invId, FILTER_VALIDATE_INT);
            $clientId = filter_var($clientId, FILTER_VALIDATE_INT);

            if (empty($reviewText) || empty($invId) || empty($clientId)) {
                $message = '<p>Please provide information for all empty form fields. </p>';
            }

            //got the data?
            $submitReview = insertReview($clientId, $invId, $reviewText);
            
            //no got data
            if ($submitReview !== 1) {
                $message = "<p>Sorry, but it looks like something went wrong while trying to add your review.</p>";
            } else {
                $message = "<p> Successfully added your review!</p>";
            }

            //redirect, scrubbing url form data so that reloading the page doesn't add duplicate rows
            $_SESSION['message'] = $message;
            header("Location: /phpmotors/vehicles/?action=details&invId=$invId");
            exit;
            break;

        case 'edit-review':
            //filter data
            $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $reviewToEdit = getReview($reviewId);
            $reviewToEdit = $reviewToEdit[0];
            console_log($reviewToEdit);

            if (count($reviewToEdit) < 1) {
                $message = '<p>Sorry, this review could not be found.';
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            }
            
            if (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin']) && !$_SESSION['loggedin'])) {
                # if not logged in, the user can't submit reviews
                $loginMessage = "<p class='notice'>You must log in first to edit this review</p>";
                $reviewForm = $loginMessage;
            } else if ($_SESSION['clientData']['clientId'] != $reviewToEdit['clientId']) {
                # logged in but id doesnt match, go home
                # this isn't your review!
                $message = "<p>Sorry, looks like this review doesn't belong to you.";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
                console_log($_SESSION['clientData']['clientId'], $reviewToEdit['clientId']);
            }

            include '../view/review-editor.php';
            break;
        
        case 'review-updated':
            //filter data
            $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $reviewId = filter_var($reviewId, FILTER_VALIDATE_INT);

            if (empty($reviewText) || empty($reviewId)) {
                $message = '<p>Please provide information for all empty form fields. </p>';
                include '../view/review-editor.php';
                exit;
            }

            $updateOutcome = updateReview($reviewId, $reviewText);

            if ($updateOutcome !== 1) {
                //no got data
                $message = "<p>Sorry, but it looks like either something went wrong while trying to edit your review or nothing was updated.</p>";
                include '../view/review-editor.php';
                exit;
            } else {
                //got data!
                $message = "<p>Successfully updated your review!</p>";
                //redirect, scrubbing url form data so that reloading the page doesn't add duplicate rows
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
                break;
            }
            



        case 'delete':
            # get review to delete from url
            //filter data
            $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            $reviewToDelete = getReview($reviewId);

            if ($reviewToDelete < 1) {
                $message = "<p class='notice'>Sorry, but it looks like something went wrong while trying to find that review.</p>";
            } else {
                $reviewToDelete = $reviewToDelete[0];
                include '../view/review-removal.php';
                exit;
            }

            break;

        case 'review-deleted':
            //filter POST data
            $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
            
            //got the data? trash it.
            $deleteOutcome = deleteReview($reviewId);
            
            if ($deleteOutcome) {
                //no more data
                $message = "<p> Successfully removed your review!</p>";
            } else {
                //got data! still! maybe!
                $message = "<p>Sorry, but your review was not deleted.</p>";
            }

            $_SESSION['message'] = $message;
            header("Location: /phpmotors/accounts/");
            exit;
            break;

        default:

            # check if user is logged in, and if not set header location to homepage and exit
            checkLogin();
            # go to accounts default view
            header("Location: /phpmotors/accounts/");
            break;
    }

?>