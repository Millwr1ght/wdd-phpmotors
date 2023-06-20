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

//get client data
function getClientUsingEmail(string $clientEmail){
    //squirrelly things
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :email;';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

//get client data
function getClientUsingId(int $clientId){
    //squirrelly things
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientId = :id;';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

function updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, clientEmail = :clientEmail WHERE clientId = :clientId;';
    $stmt = $db->prepare($sql);

    //replace placeholders
    $stmt->bindValue(':clientFirstname', $clientFirstname,PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname,PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail,PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId,PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function updatePassword($clientId, $clientPassword) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId;';
    $stmt = $db->prepare($sql);

    //replace placeholders
    $stmt->bindValue(':clientPassword', $clientPassword,PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId,PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function deleteClient($clientId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM clients WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

?>