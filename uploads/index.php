<?php
    // welcome to the uploads controller!
    
    /* imports */
    //utilities
    //require_once '../library/console_log.php';
    require_once '../library/functions.php';
    //get the database connection
    require_once '../library/connections.php';
    //get the main model
    require_once '../model/main-model.php';
    // and the other models
    require_once '../model/vehicle-model.php';
    require_once '../model/uploads-model.php';
    

    /* variable creation */
    // Create or unpause session
    session_start();

    //get classifications
    $classifications = getClassifications();

    //(re)build the nav
    $nav_list = buildNav($classifications);

    // directory name where uploaded images are stored
    $image_dir = '/phpmotors/images/vehicles';
    // full path from the server root
    $image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

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
            
        case 'upload':
            //filter data
            $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
            $imgPrimary = filter_input(INPUT_POST, 'imgPrimary', FILTER_VALIDATE_INT);

            // get image name
            $imgName = $_FILES['file1']['name'];

            $imageCheck = checkExistingImage($imgName);

            if($imageCheck){
                $message = '<p class="notice">An image by that name already exists.</p>';
            } elseif (empty($invId) || empty($imgName)) {
                $message = '<p class="notice">You must select a vehicle and image file for the vehicle.</p>';
            } else {
                // Upload the image, store the returned path to the file
                $imgPath = uploadFile('file1');
                
                // store img path data on db
                $result = storeImages($invId, $imgPath, $imgName, $imgPrimary);

                // Set a message based on the insert result
                if ($result) {
                    $message = '<p class="notice">The upload succeeded.</p>';
                } else {
                    $message = '<p class="notice">Sorry, the upload failed.</p>';
                }
            }
            
            //set session message for view
            $_SESSION['message'] = $message;

            //scrub POST or GET and return to this switch
            header('location: .');
            break;

        case 'delete':
            //filter data
            $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);


            //build target
            $target = $image_dir_path .'/'. $filename;
            
            //check is exists
            if (file_exists($target)) {
                //delete file if so
                $result = unlink($target);
            }

            //if deleted, remove from db
            if ($result) {
                $remove = deleteImage($imgId);
            }

            //Set a message based on the DELETE result
            if ($remove) {
                $message = "<p class='notice'>The deletion of $filename succeeded.</p>";
            } else {
                $message = "<p class='notice'>Sorry, the deletion of $filename failed.</p>";
            }

            //set session message for view
            $_SESSION['message'] = $message;

            //scrub POST or GET and return to this switch
            header('location: .');
            break;

        default:
            //get images information from db
            $imageArray = getImages();
            //Build image info HTML display
            if (count($imageArray)) {
                $imageDisplay = buildImageDisplay($imageArray);
            } else {
                $imageDisplay = '<p class="notice"> Sorry, no images were found.</p>';
            }

            //get vehicles information from db
            $vehicles = getVehicles();
            //Build a select list of vehicle information for the view
            $prodSelect = buildVehiclesList($vehicles);

            include '../view/image-admin.php';
            break;
    }
?>