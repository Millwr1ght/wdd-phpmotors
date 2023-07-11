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
    require_once '../model/uploads-model.php';
    require_once '../model/reviews-model.php';
    

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

        case 'getInventoryItems': 
            // Get the classificationId 
            $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
            // Fetch the vehicles by classificationId from the DB
            $inventoryArray = getInventoryByClassificationId($classificationId);
            // Convert the array to a JSON object and send it back
            echo json_encode($inventoryArray); 
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
            header('Location: /phpmotors/vehicles/');
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
            header('Location: /phpmotors/vehicles/');
            exit;
            break;

        case 'add-class':
            include '../view/add-classification.php';
            break;
        
        case 'mod':
            # modify vehicle data
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);
            $invInfo = $invInfo[0];

            if (count($invInfo) < 1) {
                $message = '<p>Sorry, no vehicle information could be found.';
            }
            include '../view/vehicle-update.php';
            exit;

            break;
        
        case 'vehicle-modded':

            //filter POST data
            $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
            $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));

            //validata
            $invPrice = filter_var($invPrice, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $invStock = filter_var($invStock, FILTER_VALIDATE_INT);

            if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
                $message = '<p>Please complete information for all fields. </p>';
                include '../view/vehicle-update.php';
                exit;
            }

            //got the data?
            $updateOutcome = updateVehicle($invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
            
            if ($updateOutcome !== 1) {
                //no got data
                $message = "<p>Sorry, but it looks like either something went wrong while trying to update $invMake $invModel details or nothing was updated.</p>";
                include '../view/vehicle-update.php';
                exit;
            } else {
                //got data!
                $message = "<p> Successfully updated the information for $invMake $invModel!</p>";
                $_SESSION['message'] = $message;
                //redirect, scrub data
                header('Location: /phpmotors/vehicles/');
                exit;
            }

            break;

        case 'del':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);

            if (count($invInfo) < 1) {
                $message = '<p>Sorry, no vehicle information could be found.';
            } else {
                $invInfo = $invInfo[0];
            }
            
            include '../view/vehicle-delete.php';
            exit;

            break;

        case 'vehicle-deleted':

            //filter POST data
            $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 

            //got the data? trash it.
            $deleteOutcome = deleteVehicle($invId);
            
            if ($deleteOutcome) {
                //no more data
                $message = "<p> Successfully removed $invMake $invModel from the inventory!</p>";
                $_SESSION['message'] = $message;
                header('Location: /phpmotors/vehicles/');
                exit;
            } else {
                //got data! still! maybe!
                # edge case: make and model are missing because of an invalid invId
                $message = "<p>Sorry, but ". (($invMake !== '') ? $invMake . ' ' . $invModel : 'that vehicle') ." was not deleted.</p>";
                $_SESSION['message'] = $message;
                //redirect, scrub data
                header('Location: /phpmotors/vehicles/');
                exit;
            }

            break;

        case 'classification':
            # get the classificationName from url and display associated vehicles
            $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $vehicles = getInventoryByClassificationName($classificationName);
            if (!count($vehicles)) {
                # if no vehicles in array
                $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
            } else {
                $vehicleDisplay = buildVehicleDisplay($vehicles);
            }

            include '../view/classification.php';
            break;

        case 'details':
            # get vehicle id
            $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invInfo = getInvItemInfo($invId);
            $invExtraThumbs = getVehicleThumbnails($invId);

            # validate response
            if (count($invInfo) < 1) {
                $message = "<p class='notice'>Sorry, that vehicle is not available.</p>";
            } else {
                $invInfo = $invInfo[0];
                $vehicleName = $invInfo['invMake'] .' '. $invInfo['invModel'];
                $reviewsArray = getProductReviews($invInfo['invId']);
                $vehicleReviews = buildReviewsDisplay($reviewsArray);
                
                # display associated vehicle image and details
                if (count($invExtraThumbs) >= 1) {
                    # if vehicle has extra thumbs, fix it
                    $vehicleThumbs = wrapThumbs($invExtraThumbs);
                    $vehicleDetails = loadVehicleDetailsTemplate($invInfo, $vehicleThumbs);
                } else {
                    $vehicleDetails = loadVehicleDetailsTemplate($invInfo);
                }
               
            }

            include '../view/vehicle-details.php';
            break;

        case 'vehicles':
        default:
            # build a classification select dropdown and go to management
            $classificationList = buildClassificationsList($carclassifications);

            include '../view/vehicle-management.php';
            break;
    }
?>