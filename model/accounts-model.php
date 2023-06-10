<?php // this is the accounts model, as evidenced by the name of the file.

// site registration
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword){

    //connect to database
    $db = phpmotorsConnect();

    //prepare squirrels
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword) VALUES (:clientFirstname,:clientLastname,:clientEmail,:clientPassword);';

    //combine statement with connection
    $stmt = $db->prepare($sql);

    //replace placeholders
    $stmt->bindValue(':clientFirstname', $clientFirstname,PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname,PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail,PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword,PDO::PARAM_STR);

    //eggsecute the squirrels
    $stmt->execute();

    //hopefully only one row changes
    $rowsChanged = $stmt->rowCount();

    //end interaction
    $stmt->closeCursor();

    //success if 1 (true), fail if more or less true (n < 1 < n)
    return $rowsChanged;
}

// prevent duplication of email records, no two users can have the same address
function checkExistingEmail($clientEmail) {
    //connect
    $db = phpmotorsConnect();

    //prepare squirrel
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email;';

    //load squirrel into connection
    $stmt = $db->prepare($sql);

    //replace placeholders
    $stmt->bindValue(':email', $clientEmail,PDO::PARAM_STR);

    //launch squirrels
    $stmt->execute();

    //make an array of matching emails
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);

    //end interaction
    $stmt->closeCursor();

    //if empty, we're good, 0; else, uh oh
    return (empty($matchEmail)) ? 0 : 1 ;
}

?>