<?php
    require_once 'config.php';
    ob_start();
    session_start();
    if(!isset($_GET['orderID']) && !isset($_GET['deliveryBoyID']))
    {
        header("location:homeAdmin.php");
    }
    else if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
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
    $deliveryBoyID=$_GET['deliveryBoyID'];
        
    $updateDeliveryOrder="update tbl_order set Delivery_Boy_ID=$deliveryBoyID where Order_ID=$orderID";
    mysqli_query($con, $updateDeliveryOrder);
    
    header("location:pendingOrder.php");
    ob_flush();
?>