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
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);

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



?>