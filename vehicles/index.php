<?php
    // welcome to the vehicle controller!
    
    /* imports */
    //for debugging
    require_once '../library/console_log.php';
    
    //get 
    //database connection
    require_once '../library/connections.php';
    //models
    require_once '../model/main-model.php';
    require_once '../model/vehicle-model.php';
    



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
        case 'template':
            include '../view/template.php';
            break;

        case '500':
        case 'error':
            include '../view/500.php';
            break;


        case 'vehicle-added':

            //filter data
            $invMake = filter_input(INPUT_POST, 'invMake');
            $invModel = filter_input(INPUT_POST, 'invModel'); 
            $invDescription = filter_input(INPUT_POST, 'invDescription'); 
            $invImage = filter_input(INPUT_POST, 'invImage'); 
            $invThumbnail = filter_input(INPUT_POST, 'invThumbnail'); 
            $invPrice = filter_input(INPUT_POST, 'invPrice'); 
            $invStock = filter_input(INPUT_POST, 'invStock'); 
            $invColor = filter_input(INPUT_POST, 'invColor'); 
            $classificationId = filter_input(INPUT_POST, 'classificationId');

            //validata heh heh
            if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
                $message = '<p>Please provide information for all empty form fields. </p>';
                include '../view/add-vehicle.php';
                exit;
            }

            //got the data?
            $addOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
            
            //no got data
            if ($addOutcome !== 1) {
                $message = "<p>Sorry, but it looks like something went wrong while trying to add the $invMake $invModel(s).</p>";
                include '../view/add-vehicle.php';
                exit;
            } else {
                $message = "<p> Successfully added $invMake $invModel(s) to the inventory!</p>";
            }

            //redirect, scrubbing url form data so that reloading the page doesn't add duplicate rows
            header('Location: /phpmotors/vehicles/index.php');
            exit;
            break;

        case 'add-vehicle':
            include '../view/add-vehicle.php';
            break;


        case 'class-added':

            //filter data, store data
            $classificationName = filter_input(INPUT_POST, 'classificationName');

            //check if missing data
            if(empty($classificationName)){
                $message = '<p>Please provide information for all empty form fields. </p>';
                include '../view/add-classification.php';
                exit;
            }

            //we have the data, send it
            $addOutcome = addClassification($classificationName);
            
            if ($addOutcome !== 1) {
                $message = "<p>Sorry, but it looks like something went wrong while trying to add $classificationName(s).</p>";
                include '../view/add-classification.php';
                exit;
            }

            //redirect, scrub form data
            header('Location: /phpmotors/vehicles/index.php');
            exit;
            break;

        case 'add-class':
            include '../view/add-classification.php';
            break;
        
        case 'vehicles':
        default:
            include '../view/vehicle-management.php';
            break;
    }
?>