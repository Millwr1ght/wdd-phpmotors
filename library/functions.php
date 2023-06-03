<?php

// some general utility functions

function checkPassword($clientPassword) {
    // check the password for: 8+ characters, at least 1 capital, 1 lowercase,
    // 1 speical char, and no newlines
    $pattern = "/(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/";
    return preg_match($pattern, $clientPassword);
}

function checkEmail($clientEmail){
    // validate their email
    $checkEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

?>