<?php
    // welcome to the reviews controller!

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

            if (empty($reviewText) || empty($clientId)) {
                $message = '<p class="notice">Please provide information for all empty form fields. </p>';
            } else if (empty($invId)) {
                # if we don't have an invId, we can't send you back! oh no!
                $_SESSION['message'] = '<p class="notice">Something went horribly wrong.</p>';
                header("Location: /phpmotors/");
                exit;
                break;
            } else {
                //got the data?
                $submitReview = insertReview($clientId, $invId, $reviewText);
                
                //no got data
                if ($submitReview !== 1) {
                    $message = "<p class='notice'>Sorry, but it looks like something went wrong while trying to add your review.</p>";
                } else {
                    // data got got! english is so fun.
                    $message = "<p class='notice'>Successfully added your review!</p>";
                }
            }

            //redirect, scrubbing url form data so that reloading the page doesn't add duplicate rows
            $_SESSION['message'] = $message;
            header("Location: /phpmotors/vehicles/?action=details&invId=$invId");
            exit;
            break;

        case 'edit-review':
            //filter data
            $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            
            # get the review
            $reviewToEdit = getReview($reviewId);

            # did we get anything? is it null or an empty array?
            if (is_null($reviewToEdit) || empty($reviewToEdit)) {
                # how did you get here? why are you manually changing the url? stop that
                $message = "<p class='notice'>Sorry, this review does not exist.";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            }
            
            if (count($reviewToEdit[0]) < 1) {
                # we got a result, but the result had no data. huh.
                $message = "<p class='notice'>Sorry, this review could not be found.";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            }
            $reviewToEdit = $reviewToEdit[0];

            # we have the review!

            if (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin']) && !$_SESSION['loggedin'])) {
                # if not logged in, the user can't edit reviews
                $message = "<p class='notice'>You must log in first to edit this review</p>";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            } else if ($_SESSION['clientData']['clientId'] != $reviewToEdit['clientId']) {
                # logged in but id doesnt match, go home
                # this isn't your review!
                $message = "<p>You cannot edit reviews that do not belong to you.";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
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
            # did we get anything? is it null or an empty array?
            if (is_null($reviewToDelete) || empty($reviewToDelete)) {
                # how did you get here? why are you manually changing the url? stop that
                $message = "<p class='notice'>Sorry, this review does not exist.";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            }
            
            if (count($reviewToDelete[0]) < 1) {
                # we got a result, but the result had no data. huh.
                $message = "<p class='notice'>Sorry, this review could not be found.";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            }
            $reviewToDelete = $reviewToDelete[0];

            if (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin']) && !$_SESSION['loggedin'])) {
                # if not logged in, the user can't delete reviews
                $message = "<p class='notice'>You must log in first to delete this review</p>";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            } else if ($_SESSION['clientData']['clientId'] != $reviewToDelete['clientId']) {
                # logged in but id doesnt match, go home
                # this isn't your review!
                $message = "<p>You cannot delete reviews that do not belong to you.";
                $_SESSION['message'] = $message;
                header("Location: /phpmotors/accounts/");
                exit;
            }

            include '../view/review-removal.php';
            exit;
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