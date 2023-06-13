<?php
    // welcome to the vehicle controller!
    
    /* imports */
    //functions
    require_once '../library/console_log.php';
    require_once '../library/functions.php';
    //get 
    //database connection
    require_once '../library/connections.php';
    //models
    require_once '../model/main-model.php';
    require_once '../model/vehicle-model.php';
    



    /* variable creation */
    //get session
    session_start();
    
    //get classifications
    $carclassifications = getClassifications();

    //(re)build the nav
    $nav_list = buildNav($carclassifications);

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
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            //validata (heh heh)
            $invPrice = filter_var($invPrice, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $invStock = filter_var($invStock, FILTER_VALIDATE_INT);

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
            $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            //check length
            if (checkLen($classificationName, 30)) {
                unset($classificationName);
                $message = '<p>Please use no more than 30 characters.</p>';
                include '../view/add-classification.php';
                exit;
            }

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