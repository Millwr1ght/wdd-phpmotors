<?php
    // welcome to the account controller!
    
    /* imports */
    //for debugging
    require_once '../library/console_log.php';
    
    //get the database connection
    require_once '../library/connections.php';
    //get the main model
    require_once '../model/main-model.php';
    //get the accounts model
    require_once '../model/accounts-model.php';


    /* variable creation */
    //get classifications
    $classifications = getClassifications();

    //var_dump($classifications);
    //exit;

    //(re)build the nav
    $nav_list = "<nav class='nav-top' id='page-nav'>"; 
    $nav_list .= "<a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a>";
    foreach ($classifications as $classification) {
        $nav_list .= "<a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a>";
    }
    $nav_list .= "</nav>";

    //decide which webpage to show
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    switch ($action){
        case 'registered':
            //filter data, store data
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname');
            $clientLastname = filter_input(INPUT_POST, 'clientLastname');
            $clientEmail = filter_input(INPUT_POST, 'clientEmail');
            $clientPassword = filter_input(INPUT_POST, 'clientPassword');

            //check if missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientPassword)){
                $message = '<p>Please provide information for all empty form fields. </p>';
                include '../view/register.php';
                exit;
            }

            //we have the data, send it
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword);
            
            if ($regOutcome === 1) {
                $message = "<p>Thank you for registering $clientFirstname. Please use your email and password to login.</p>";
                include '../view/login.php';
                exit;
            } else {
                $message = "<p>Sorry $clientFirstname, but it looks like something went wrong</p>";
                include '../view/register.php';
            }

            break;

        case 'register':
            include '../view/register.php';
            break;

        case'login':
        default:
            include '../view/login.php';
            break;
    }
?>