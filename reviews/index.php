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
            include '../view/review-editor.php';
            break;
        
        case 'updated':
        case 'delete-review':
            # get review to delete from url
            //filter data
            $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $reviewId = filter_var($reviewId, FILTER_VALIDATE_INT);
            
            $reviewToDelete = getReview($reviewId);

            if ($reviewToDelete < 1) {
                $message = "<p class='notice'>Sorry, but it looks like something went wrong while trying to find that review.</p>";
            } else {
                # get vehicle info, specifically make and model
                $invInfo = getInvItemInfo($reviewToDelete['invId']);
                
                if (count($invInfo) < 1) {
                    $message = "<p class='notice'>It looks like that vehicle does not exist or no longer exists.</p>";
                } else {
                    $invInfo = $invInfo[0];
                }
                include '../view/review-removal.php';
                exit;
            }
            

            
            break;

        case 'deleted':
        case 'user-reviews':
        
        default:

            # check if user is admin, and if not set header location to homepage and exit
            checkAdminPrivilege();

            include '../view/review-management.php';
            break;
    }

?>