<?php 

    function phpmotorsConnect(){
        $server = 'localhost';   //localhost
        $dbname = 'phpmotors';   //phpmotors
        $username = 'dbCrawler'; //dbCrawler
        $password = 'yVWN*6xxTuYOB8yA'; //or whatever password the db user account uses
        $dsn = "mysql:host=$server;dbname=$dbname";
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        try {
            $connection = new PDO($dsn, $username, $password, $options);
            return $connection;
        } catch (PDOException $e) {
            throw $e;

            //redirect to 500 error page
            header('Location: /phpmotors/?action=500');
            exit;
        }
    }

?>