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


    /* variable creation */
    //get session
    session_start();    

    //get classifications
    $classifications = getClassifications();

    //get nav
    $nav_list = buildNav($classifications);

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

            // //confirm password
            // if($clientPassword !== $confirmPassword) {
            //     $message = '<p>Passwords should match.</p>';
            //     include '../view/register.php';
            //     exit;
            // }

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
            $clientData = getClient($clientEmail);

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

            //header('Location: /phpmotors/index.php');
            include '../view/admin.php';
            exit;
            
            break;

        case'login':
            include '../view/login.php';
            break;

        default:
            include '../view/admin.php';
            break;
    }
?>