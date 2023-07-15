<?php
    // welcome to the account controller!
    
    /* imports */
    //functions
    require_once '../library/console_log.php';
    require_once '../library/functions.php';
    //get the database connection
    require_once '../library/connections.php';
    //get the main model
    require_once '../model/main-model.php';
    //get the accounts model
    require_once '../model/accounts-model.php';
    require_once '../model/reviews-model.php';


    /* variable creation */
    //get session
    session_start();    

    //get classifications
    $classifications = getClassifications();

    //build elements
    $nav_list = buildNav($classifications);

    $admin_section = 
    '<section class="administration divider-top">'.
        '<h2>Administration</h2>'.
        '<p><a class="link" href="/phpmotors/vehicles/">Vehicle Management</a></p>'.
        '<p><a class="link" href="/phpmotors/uploads/">Pictures and Images Management</a></p>'.
    '</section>';

    //decide which webpage to show
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    // reset messages
    $message = '';

    switch ($action){

        case '500':
        case 'error':
            include 'view/500.php';
            break;

        case 'logout':
            // unset $_SESSION data, not $_SESSION itself
            $_SESSION = array();
            session_unset();

            // end/pause session
            session_destroy();

            header('Location: /phpmotors/');
            exit;
            break;

        case 'registered':
            //filter data, store data
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            //$confirmPassword = trim(filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));


            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);

            //check if missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../view/register.php';
                exit;
            }

            //check for duplicate records. if duplicate, go to start
            $existingEmail = checkExistingEmail($clientEmail);

            if ($existingEmail) {
               $message = '<p>This email address is used by another user. Try again.</p>';
               include '../view/login.php';
               exit;
            }

            // make hash browns
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

            //we have the data, send it
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
            
            if ($regOutcome === 1) {
                // bake a cookie
                //setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
                
                $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
                header('Location: /phpmotors/accounts/?action=login');
                exit;
            } else {
                $message = "<p>Sorry $clientFirstname, but it looks like something went wrong</p>";
                include '../view/register.php';
            }

            break;

        case 'register':
            include '../view/register.php';
            break;

        case 'logged-in':
            //filter data, store data
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            
            //vaildate
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            
            //check if missing data
            if(empty($clientEmail) || empty($checkPassword)){
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../view/login.php';
                exit;
            }

            //data exists, get data
            $clientData = getClientUsingEmail($clientEmail);

            if(empty($clientData)){
                $message = '<p>This user does not exist. Try again.</p>';
                include '../view/login.php';
                exit;
            }

            //validate data again
            $hash_check = password_verify($clientPassword, $clientData['clientPassword']);

            if (!$hash_check) {
                $message = '<p>Password incorrect. Try again.</p>';
                include '../view/login.php';
                exit;                
            }
            
            //success        
            unset($message);

            $_SESSION['loggedin'] = TRUE;

            // remove client password. hopefully, it was last
            array_pop($clientData);
            // store the rest
            $_SESSION['clientData'] = $clientData;

            //header('Location: /phpmotors/');
            //include '../view/admin.php';
            header('Location: /phpmotors/accounts/');
            exit;
            
            break;

        case 'login':
            include '../view/login.php';
            break;

        case 'client-update-account':
            //filter data, store data
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

            $clientEmail = checkEmail($clientEmail);
           
            //check if missing data
            if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
                $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
                $_SESSION['message_location'] = 'update-account';
                include '../view/client-update.php';
                exit;
            }

            //check for duplicate records. if duplicate, go to start
            // $emailInUse = $_SESSION['clientData']['clientEmail'] == $clientEmail;

            // if ($emailInUse) {
            //     $_SESSION['message'] = '<p>This email address is already used by another user: You! Try again.</p>';
            //     $_SESSION['message_location'] = 'update-account';
            //     include '../view/client-update.php';  
            //     exit;
            // }
            
            //check for duplicate records. if duplicate, and not user's own email, go to start
            $existingEmail = checkExistingEmail($clientEmail);

            if ($existingEmail && $_SESSION['clientData']['clientEmail'] != $clientEmail) {
                $_SESSION['message'] = '<p>This email address is already used by another user. Try again.</p>';
               $_SESSION['message_location'] = 'update-account';
               include '../view/client-update.php';  
               exit;
            }

            //we have the data, send it
            $updatedClient = updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail);
            
            if ($updatedClient === 1) {
                // update session info
                $clientData = getClientUsingId($clientId);
                array_pop($clientData);
                $_SESSION['clientData'] = $clientData;

                
                $_SESSION['message'] = "Your account has been updated $clientFirstname.";
                header('Location: /phpmotors/accounts/');
                exit;
            } else {
                $_SESSION['message'] = "<p>Sorry $clientFirstname, but it looks like something went wrong</p>";
                $_SESSION['message_location'] = 'update-account';
                include '../view/client-update.php';
                exit;
            }

            break;

        case 'client-update-password':
            //filter new data, store new data, validate new data
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

            $checkPassword = checkPassword($clientPassword);

            //check if missing new data
            if (empty($checkPassword)) {
                $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
                $_SESSION['message_location'] = 'update-password';
                include '../view/client-update.php';
                exit;
            }

            // remake hash browns
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

            //we have the data, send it
            $passwordOutcome = updatePassword($clientId, $hashedPassword);
            
            if ($passwordOutcome === 1) {
                $_SESSION['message'] = "Thank you for updating your password $clientFirstname.";
                header('Location: /phpmotors/accounts/');
                exit;
            } else {
                $_SESSION['message'] = "<p>Sorry $clientFirstname, but it looks like something went wrong...</p>";
                $_SESSION['message_location'] = 'update-password';
                include '../view/client-update.php';
                exit;
            }

            break;

        case 'mod':
            include '../view/client-update.php';
            break;
            
        case 'client-delete-account':
            //filter POST data
            $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 

            //got the data? trash it.
            $deleteOutcome = deleteClient($clientId);
            
            if ($deleteOutcome) {
                //no more data
                $message = "<p> Successfully removed account belonging to $clientFirstname $clientLastname.</p>";
                $_SESSION['message'] = $message;
                header('Location: /phpmotors/accounts/?action=logout');
                exit;
            } else {
                //got data maybe?
                $message = "<p>Sorry, but $clientFirstname $clientLastname\'s account was not deleted.</p>";
                $_SESSION['message'] = $message;
                //redirect, scrub data
                header('Location: /phpmotors/accounts/');
                exit;
            }

            break;
            
        case 'del':
            include '../view/client-delete.php';
            break;
        
        default:
            # get reviews from this client id if any
            $myReviews = getClientReviews($_SESSION['clientData']['clientId']);

            $manageReviews = buildClientReviewsDisplay($myReviews);
            
            include '../view/admin.php';
            break;
    }
?>