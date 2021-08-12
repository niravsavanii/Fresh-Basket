<?php
    session_start();
    unset($_SESSION['customerID']);
    unset($_SESSION['adminID']);
    unset($_SESSION['firstName']);
    unset($_SESSION['emailID']);
    session_destroy();
    
    header("location:index.php");
?>