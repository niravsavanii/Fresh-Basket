<?php
require_once 'config.php';
session_start();
ob_start();
if(!isset($_GET['deliveryBoyID']) && !isset($_GET['status']))
{
    header("location:homeAdmin.php");
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
if(isset($_GET['deliveryBoyID']) && isset($_GET['status']))
{
    if($_GET['status']=='Activate')
    {
        $updateStatusDeactivate="update tbl_delivery_boy set Status='Deactivate' where Delivery_Boy_ID='".$_GET['deliveryBoyID']."'";
        mysqli_query($con, $updateStatusDeactivate);
    }
    else 
    {
        $updateStatusActivate="update tbl_delivery_boy set Status='Activate' where Delivery_Boy_ID='".$_GET['deliveryBoyID']."'";
        mysqli_query($con, $updateStatusActivate);
    }
    header("location:manageDeliveryBoy.php");
}
?>