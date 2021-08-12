<?php
    require_once 'config.php';
    ob_start();
    session_start();
    if(!isset($_GET['orderID']) && !isset($_GET['status']))
    {
        header("location:homeDeliveryBoy.php");
    }
    if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:index.php");
    }
    else if(isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeCustomer.php");
    }
    else if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeDeliveryBoy.php");
    }
    $orderID=$_GET['orderID'];
    $status=$_GET['status'];       
    
    $updateDeliveryStatus="update tbl_order set Order_Status='$status' where Order_ID=$orderID";
    mysqli_query($con, $updateDeliveryStatus);
    
    header("location:pendingOrder.php");
    ob_flush();
?>