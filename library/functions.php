<?php

// some general utility functions

function checkPassword($clientPassword) {
    // check the password for: 8+ characters, at least 1 capital, 1 lowercase,
    // 1 speical char, and no newlines
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
};

function checkEmail($clientEmail){
    # validate their email
    $checkEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

function checkLen($input, $length){
    # bool is str greater than length
    return strlen($input) > $length;
}

function buildNav($classifications){
    # build the <nav> element in the header
    $nav_list = "<nav class='nav-top' id='page-nav'>"; 
    $nav_list .= "<a href='/phpmotors/' title='View the PHP Motors home page'>Home</a>";
    foreach ($classifications as $classification) {
        $nav_list .= "<a href='/phpmotors/?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a>";
    }
    $nav_list .= "</nav>";
    return $nav_list;
}

function layBreadcrumbs($pageTitle = null, $separator = '&raquo;', $home = 'Home') {
    # build a string of breadcrumb links based on $_SEREVER['REQUEST_URI']
    # e.g.: Home[link] -> Admin[link] -> $pageTitle (no link)

    # get current location in site
    $crumbs = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $path = '/';
    
    # build rest of breadcrumbs
    foreach ($crumbs as $x => $crumb) {
        $name = ucwords(str_replace("phpmotors", $home, $crumb));
        $path .= $crumb . '/';
        $breadcrumbs[] = "<a href=\"$path\">$name</a>";
    }

    # add this page title to the end
    if (isset($pageTitle)) {
        $breadcrumbs[] = "<a href=\"#\">$pageTitle</a>";
    }

    # return span with impolded array
    return "<span class='breadcrumbs'>" . implode($separator, $breadcrumbs) . "</span>";
}

function buildClassificationsList($classifications) {
    # build a select/option dropdown with the car classifications as options
    $list = '<select name="classificationId" id="classificationList">';
    $list .= '<option>Choose a Category</option>';
    foreach ($classifications as $classification) {
        # options
        $list .= "<option value='$classification[classificationId]'";
        
        # add a stickiness to the form input; if a form value for the input id exists and this is it: selected
        $list .= (isset($classificationId) && $classificationId == $classification['classificationId']) ? ' selected>' : '>' ;
        
        $list .= "$classification[classificationName]</option>";
    }
    $list .= '</select>';
    return $list;
}




?>