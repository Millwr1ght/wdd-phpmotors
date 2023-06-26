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

function checkAdminPriviledge() {
    # if not logged in, or if logged in but not an admin, redirect to home
    if (!$_SESSION['loggedin'] || ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] < 2)) {
        header('Location: /phpmotors/');
        exit;
    }
}


function buildNav($classifications){
    # build the <nav> element in the header
    $nav_list = "<nav class='nav-top' id='page-nav'>"; 
    $nav_list .= "<a href='/phpmotors/' title='View the PHP Motors home page'>Home</a>";
    foreach ($classifications as $classification) {
        $nav_list .= "<a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a>";
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

function buildVehicleDisplay($vehicleArray, $debug = false) {
    # build html card array
    if ($debug) {
        # unless debug, then just output data array
        return var_export($vehicleArray, true);
    }

    $display = "<section class='vehicle-display'>";
    $display .= "<ul class='vehicle-list'>";

    # deal cards
    foreach ($vehicleArray as $vehicle) {
        # prep card info
        $cardTitle = $vehicle['invMake'] ." ". $vehicle['invModel'];
        //$cardImage = imageExists('..'.$vehicle['invImage']);
        $cardThumbnail = imageExists('..'.$vehicle['invThumbnail']);
        
        # add card to deck
        $display .= buildInventoryCard($vehicle['invId'], $cardTitle, $cardThumbnail, $vehicle['invPrice']);
    }
    
    $display .= '</ul></section>';
    return $display;
}

function buildInventoryCard($cardId, $cardTitle, $cardThumbnail, $cardPrice) {
    # inventory card template
    # card build
    $card = "<li class='vehicle-card'>";
    $altText = ((str_contains($cardThumbnail, 'no-image.png')) ? "No image available for the " : "A pretty cool ") . $cardTitle;
    $card .= "<img class='vc__img' src='$cardThumbnail' alt='$altText'>"; 
    $card .= "<hr>";
    $card .= "<h2 class='vc__title'>$cardTitle</h2>";
    $card .= "<div class='flex-row'>";
    $card .= "<span class='vc__price'>$$cardPrice</span>";
    $card .= "<span class='vc__details'>";
    $card .= "<a href='/phpmotors/vehicles/?action=details&invId=$cardId'>More Details &rarr;</a>";
    $card .= "</span>";
    $card .= "</div>";
    $card .= "</li>";
    
    return $card;
}

function loadVehicleDetailsTemplate($invInfo, $debug = false) {
    # from vehicle information array, build product page
    if ($debug) {
        # unless debug, then just output data array
        return var_export($invInfo, true);
    }

    $makeModel = $invInfo['invMake'].' '.$invInfo['invModel'];

    # image of vehicle
    $figure = "<figure class='details-image'>";
    $altText = ((str_contains($invInfo['invImage'], 'no-image.png')) ? "No image available for the " : "A pretty cool ") . $makeModel;
    $figure .= "<img src='..$invInfo[invImage]' alt='$altText'>";
    $figcaption = "<figcaption></figcaption>";
    //$figure .= $figcaption;
    $figure .= "</figure>";

    # information of vehicle
    $details = "<section class='details-content'>";
    $details .= "<h2>Vehicle Details</h2>";

    $details .= "<div class='dc__price flex-row'>";
    $details .= "<span>Price: </span>";
    $details .= "<span>$$invInfo[invPrice]</span>";
    $details .= "</div>";
    
    $details .= "<div class='dc__stock flex-row'>";
    $details .= "<span># left in stock: </span>";
    $details .= "<span>$invInfo[invStock]</span>";
    $details .= "</div>";
    
    $details .= "<div class='dc__color flex-row'>";
    $details .= "<span>Color: </span>";
    $details .= "<span>$invInfo[invColor]</span>";
    $details .= "</div>";
    
    $details .= "<p class='dc__description'>";
    $details .= $invInfo['invDescription'];
    $details .= "</p>";
    
    $details .= "</section>";

    $display = $figure . $details;

    return $display;

}

function imageExists($src) : String {
    # @getimagesize() returns false if it throws an error (i.e.: img does not exist)
    # check if exists ? src good : default 
    console_log(@getimagesize($src));
    return (@getimagesize($src)) ? $src : "../images/no-image.png";
}

?>