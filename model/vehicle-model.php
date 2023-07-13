<?php // the vehicles model

//add a vehicle to the inventory table
function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId) {

    //connect to database
    $db = phpmotorsConnect();

    //prepare squirrels
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId) VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId);';

    //combine statement with connection
    $stmt = $db->prepare($sql);

    //replace placeholders
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);

    //eggsecute the squirrels
    $stmt->execute();

    //hopefully only one row changes
    $rowsChanged = $stmt->rowCount();

    //end interaction
    $stmt->closeCursor();

    return $rowsChanged;
    //success if 1 (true), fail if more or less true (n < 1, 1 < n)

}

//add a car classification to the carclassification table
function addClassification($classificationName) {

    //connect to database
    $db = phpmotorsConnect();

    //prepare squirrels
    $sql = 'INSERT INTO carclassification (classificationName) VALUES (:classificationName);';

    //combine statement with connection
    $stmt = $db->prepare($sql);

    //replace placeholders
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);

    //eggsecute the squirrels
    $stmt->execute();

    //hopefully only one row changes
    $rowsChanged = $stmt->rowCount();

    //end interaction
    $stmt->closeCursor();

    return $rowsChanged;
    //success if 1 (true), fail if more or less true (n < 1, 1 < n)
}

function getInventoryByClassificationId($classificationId) {
    # get vehicles by classification id
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId = :classificationId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}

function getInventoryByClassificationName($classificationName, $tn = true) {
    # get vehicles by classification id
    # only returns thumbnails unless $tn is false
    $db = phpmotorsConnect();
    $sql = 'SELECT i.invId, i.invMake, i.invModel, i.invDescription, im.imgPath, i.invPrice, i.invStock, i.invColor, i.classificationId FROM inventory i JOIN images im ON i.invId = im.invId WHERE i.classificationId IN ( SELECT classificationId FROM carclassification WHERE classificationName = :classificationName ) AND im.imgPrimary = 1 AND im.imgPath ';
    $sql .= ($tn) ? '' : 'NOT' ;
    $sql .= 'LIKE "%-tn.%";';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}

function getInvItemInfo($invId, $getImages = false) {
    # get data from inventory table based on inventory id
    $db = phpmotorsConnect();
    # if getImages, get images too, else no
    $sql = ($getImages) 
        ? 'SELECT i.invId, i.invMake, i.invModel, i.invDescription, im.imgPath, i.invPrice, i.invStock, i.invColor, i.classificationId FROM inventory i JOIN images im ON i.invId = im.invId WHERE i.invId = :invId AND im.imgPath NOT LIKE "%-tn.%"'
        : 'SELECT * FROM inventory WHERE i.invId = :invId' ;
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

function updateVehicle($invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId) {
    # update info of a vehicle on the inventory table by id

    $db = phpmotorsConnect();
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';

    $stmt = $db->prepare($sql);

    //replace placeholders
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function deleteVehicle($invId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// Get information for all vehicles
function getVehicles(){
	$db = phpmotorsConnect();
	$sql = 'SELECT invId, invMake, invModel FROM inventory';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $invInfo;
}

?>