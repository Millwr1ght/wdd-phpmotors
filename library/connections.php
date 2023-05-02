<!-- for enhancement 2-->
<?php 

    function createConnection(){
        $server = 'localhost';   //localhost
        $dbname = 'phpmotors';   //phpmotors
        $username = 'dbCrawler'; //dbCrawler
        $password = 'i4/vr-6*yoIBaZKE';
        $dsn = 'mysql:host='.$server.';dbname='.$dbname;
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        try {
            //code...
            $connection = new PDO($dsn, $username, $password, $options);
            return $connection;
        } catch (PDOException $e) {
            //throw $e;
            //echo 'Sorry, the server couldn\'t connect. :/';

            //redirect to 500 error page
            header('Location: /phpmotors/view/500.php');
            exit;
        }
    }

?>