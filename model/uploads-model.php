<?php

function storeImages($invId, $imgPath, $imgName, $imgPrimary) {
    //connect to db
    $db = phpmotorsConnect();

    //prepare squirrels
    $sql = 'INSERT INTO images (invId, imgPath, imgName, imgPrimary) VALUES (:invId, :imgPath, :imgName, :imgPrimary);';
    $stmt = $db->prepare($sql);

    //bind placeholders
    $stmt->bindValue(':invId', $invId,PDO::PARAM_STR);
    $stmt->bindValue(':imgPath', $imgPath,PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName,PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary,PDO::PARAM_STR);

    //execute squirrels :(
    $stmt->execute();

    //oh but we're not done yet
    $imgPath = makeThumbnailName($imgPath);
    $imgName = makeThumbnailName($imgName);
    //the binding of issac 2: now with wingsa
    $stmt->bindValue(':invId', $invId,PDO::PARAM_STR);
    $stmt->bindValue(':imgPath', $imgPath,PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName,PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary,PDO::PARAM_STR);

    //more dead squirrels :((
    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function getImages() {
    // Get Image Information from images table
    // also make and model from inventory table
    $db = phpmotorsConnect();
    $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invMake, invModel FROM images JOIN inventory ON images.invId = inventory.invId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
}

function deleteImage($imgId) {
    // Delete image information from the images table
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM images WHERE imgId = :imgId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}

function checkExistingImage($imgName){
    // Check for an existing image
    $db = phpmotorsConnect();
    $sql = "SELECT imgName FROM images WHERE imgName = :name";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    return $imageMatch;
}

function getVehicleThumbnails($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM images WHERE imgPath LIKE "%-tn.%" AND invId = :invId AND imgPrimary = 0';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId,PDO::PARAM_STR);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
}
?>