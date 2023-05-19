<?php
    // welcome to the base controller!
    
    /* imports */
    //for debugging
    require_once 'library/console_log.php';
    
    //get the database connection
    require_once 'library/connections.php';
    //get the model
    require_once 'model/main-model.php';
    
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

    //echo $navlist;
    //exit;

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
    }
?>