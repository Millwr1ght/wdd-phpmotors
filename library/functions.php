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

function checkAdminPrivilege() {
    # if not logged in, or if logged in but not an admin, redirect to home
    if (!$_SESSION['loggedin'] || ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] < 2)) {
        header('Location: /phpmotors/');
        exit;
    }
}

function checkLogin() {
    # if not logged in, redirect to log in
    if (!$_SESSION['loggedin']) {
        header('Location: /phpmotors/accounts/?action=login');
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
        $breadcrumbs[] = "<a href=\"$path\"> $name </a>";
    }

    # add this page title to the end
    if (isset($pageTitle)) {
        $breadcrumbs[] = "<span> $pageTitle</span>";
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

function buildVehiclesList($vehicles) {
    # build a select/option dropdown with the vehicles as options
    $list = '<select name="invId" id="vehicleList">';
    $list .= '<option>Choose a Vehicle</option>';
    foreach ($vehicles as $vehicle) {
        # options
        $list .= "<option value='$vehicle[invId]'";
        
        # add a stickiness to the form input; if a form value for the input id exists and this is it: selected
        $list .= (isset($invId) && $invId == $vehicle['invId']) ? ' selected>' : '>' ;
        
        $list .= "$vehicle[invMake] $vehicle[invModel]</option>";
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
        $cardThumbnail = $vehicle['imgPath'];
        
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
    $card .= "<span class='vc__price'>$$cardPrice&nbsp;</span>";
    $card .= "<span class='vc__details'>";
    $card .= "<a href='/phpmotors/vehicles/?action=details&invId=$cardId'>More Details &rarr;</a>";
    $card .= "</span>";
    $card .= "</div>";
    
    $card .= "</li>";
    
    return $card;
}

function buildImageDisplay($imageArray) {
    // Build images display for image management view
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
         $id .= '<li>';
         $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
         $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
         $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

function buildClientReviewsDisplay($reviewsArray) {
    # map an array of a client's reviews to an HTML display
    if (count($reviewsArray) < 1) {
        # there are no reviews
        $reviews = '<p>There are no reviews yet.</p>';
    } else {
        # there are any reviews
        $reviews = "<ul>";

        foreach ($reviewsArray as $review) {
            $screenName = substr($review['clientFirstname'], 0, 1) . $review['clientLastname'];
            $reviewDate = date('m.d.y @ g:ia', strtotime($review['reviewDate']));
            $reviews .= "";
            $reviews .= "<li class='cr-card'>";
            $reviews .= "<div class='cr-card__content'>";
            $reviews .= "<p class='cr-card__text'>$review[reviewText]</p>";
            $reviews .= "<span class='cr-card__name'>$screenName</span>";
            $reviews .= "<span class='cr-card__date'> on $reviewDate</span>";
            $reviews .= "</div>";
            $reviews .= "<div class='cr-card__options'>";
            $reviews .= "<a href='/phpmotors/reviews?action=edit-review&reviewId=$review[reviewId]' title='Click to edit'>Edit</a>";
            $reviews .= "<a href='/phpmotors/reviews?action=delete&reviewId=$review[reviewId]' title='Click to delete'>Delete</a>";
            $reviews .= "</div>";
            $reviews .= "</li>";
        }

        $reviews .= "</ul>";

        return $reviews;
    }
}

function buildProductReviewsDisplay($reviewsArray, $invId, $text = '', $debug = false) {
    # map an array of product reviews to an HTML display

    $reviews = "<section class='details-reviews'>";
    $reviews .= "<h2>Customer Reviews</h2>";

    if ($debug) {
        # but if debug, echo data
        $reviews .= var_export($reviewsArray, true);
    } else {
        $reviews .= "";
    }

    # build review form
    $reviews .= buildReviewForm($invId, $text);

    # show existing reviews
    if (count($reviewsArray) < 1) {
        # there are no reviews
        $reviews .= '<p>There are no reviews yet.</p>';
    } else {
        # there are any reviews
        $reviews .= "<ul>";

        foreach ($reviewsArray as $review) {
            
            $screenName = substr($review['clientFirstname'], 0, 1) . $review['clientLastname'];
            $reviewDate = date('m.d.y @ g:ia', strtotime($review['reviewDate']));
            $reviews .= "<li class='dr-card'>";
            $reviews .= "<p class='dr-card__text'>$review[reviewText]</p>";
            $reviews .= "<span class='dr-card__name'>$screenName</span>";
            $reviews .= "<span class='dr-card__date'> on $reviewDate</span>";
            $reviews .= "</li>";
        }

        $reviews .= "</ul>";
    }
    
    $reviews .= "</section>";

    return $reviews;
}

function buildReviewForm($invId, $reviewText = '') {
    # build a review form
    
    # if not logged in, no form for you
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        $form = "<p class='notice'>You must log in first to leave a review. ";
        $form .= "<a href='/phpmotors/accounts/?action=login' class='link'>Log In</a>";
        $form .= "</p>";
    } else {
        # you logged in, you get form
        $clientId = $_SESSION['clientData']['clientId'];
        $form = "<form class='review-form' method='post' action='/phpmotors/reviews/'>";
        $form .= "<label for='screenName'>Screen Name: </label>";
        $form .= "<input readonly type='text' id='screenName' name='screenName' value=".substr($_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname']."> <br>";
        $form .= "<label for='reviewText'>Your review:</label> <br>";
        $form .= "<textarea name='reviewText' id='reviewText' cols='40' rows='6' required>$reviewText</textarea> <br> <br>";
        $form .= "<input type='submit' id='submit' name='submit' value='Submit'>";
        $form .= "<input type='reset'  id='reset' value='Reset'>";
        $form .= "<input type='hidden' name='action' value='review-submitted'>";
        $form .= "<input type='hidden' name='invId' value='$invId'>";
        $form .= "<input type='hidden' name='clientId' value='$clientId'>";
        $form .= "</form>";
    }
    return $form;
}

function loadVehicleDetailsTemplate($invInfo, $thumbsHTML = null, $debug = false) {
    # from vehicle information array, build product page
    if ($debug) {
        # unless debug, then just output data array
        return var_export($invInfo, true);
    }

    $makeModel = $invInfo['invMake'].' '.$invInfo['invModel'];

    # image of vehicle
    $figure = "<figure class='details-image'>";
    $altText =  "A pretty cool " . $makeModel;
    $figure .= "<img src='$invInfo[imgPath]' alt='$altText'>";
    //$figcaption = "<figcaption>words words words</figcaption>";
    //$figure .= $figcaption;
    $figure .= "</figure>";

    # information of vehicle
    $details = "<section class='details-content'>";
    $details .= "<h2>Vehicle Details</h2>";
    $details .= "<aside class='spacer mobile'>Scroll to bottom for user reviews</aside>";
    # price
    $details .= "<div class='dc__price flex-row'>";
    $details .= "<span>Price: </span>";
    $details .= "<span>$$invInfo[invPrice]</span>";
    $details .= "</div>";
    # make
    $details .= "<div class='dc__make flex-row'>";
    $details .= "<span>Make: </span>";
    $details .= "<span>$invInfo[invMake]</span>";
    $details .= "</div>";
    # model
    $details .= "<div class='dc__model flex-row'>";
    $details .= "<span>Model: </span>";
    $details .= "<span>$invInfo[invModel]</span>";
    $details .= "</div>";
    # color
    $details .= "<div class='dc__color flex-row'>";
    $details .= "<span>Color: </span>";
    $details .= "<span>$invInfo[invColor]</span>";
    $details .= "</div>";
    # left in stock
    $details .= "<div class='dc__stock flex-row'>";
    $details .= "<span># left in stock: </span>";
    $details .= "<span>$invInfo[invStock]</span>";
    $details .= "</div>";
    # description
    $details .= "<p class='dc__description'>";
    $details .= $invInfo['invDescription'];
    $details .= "</p>";
    
    $details .= "</section>";

    $display = $figure . $details . ((!is_null($thumbsHTML)) ? $thumbsHTML: '');

    return $display;

}

function wrapThumbs($thumbArray) {
    # wrap the array of extra vehicle images in HTML to be viewed beloew the main image
    $section = "<section class='details-thumbnails'>";
    $section .= "<h2>More Images</h2>";
    $section .= "<div class='dt__imgbox'>";
    # deal little cards
    foreach($thumbArray as $x => $thumb) {
        $num = $x+2;
        $altText = "Cool image #$num of this great ride!";
        $section .= "<img class='dt__img' src='$thumb[imgPath]' alt='$altText'>";
    }
    $section .= "</div>";
    $section .= "</section>";

    return $section;
}


/* ---- image processing ---- */
function imageExists($src) : String {
    //a db unintensive image checker
    # @getimagesize() returns false if it throws an error (i.e.: img does not exist)
    # check if exists ? src good : default 
    return (@getimagesize($src)) ? $src : "../images/no-image.png";
}

function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

function uploadFile($name) {
    /* Handles the file upload process and returns the path
     * The file path is stored into the database 
     */

    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}

function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';

    // Set up the image path
    $image_path = $dir . $filename;

    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);

    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);

    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    } // ends the swith

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    }
    // Free any memory associated with the old image
    imagedestroy($old_image);
}
/* -- end image processing -- */
?>