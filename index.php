<?php
    // welcome to the base controller!
    
    /* imports */
    //utilities
    require_once 'library/console_log.php';
    require_once 'library/functions.php';
    //get the database connection
    require_once 'library/connections.php';
    //get the main model
    require_once 'model/main-model.php';
    

    /* variable creation */
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
            include 'view/template.php';
            break;

        case '500':
        case 'error':
            include 'view/500.php';
            break;
            
        default:
            include 'view/home.php';
            break;
    }
?>