<?php
    define('DB_SERVER','localhost');
    define('DB_USER', 'root');
    define('DB_PSWD', '');
    define('DB_NAME', 'FreshBasket');
    
    $con= mysqli_connect(DB_SERVER,DB_USER,DB_PSWD,DB_NAME);
    
    if($con==FALSE)
    {
        echo 'Error: cannot connect with the database';
    }
?>