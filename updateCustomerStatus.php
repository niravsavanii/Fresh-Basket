<?php
require_once 'config.php';
session_start();
ob_start();
if(!isset($_GET['customerID']) && !isset($_GET['status']))
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
if(isset($_GET['customerID']) && isset($_GET['status']))
{
    if($_GET['status']=='Activate')
    {
        $updateStatusDeactivate="update tbl_customer set Status='Deactivate' where Customer_Id='".$_GET['customerID']."'";
        mysqli_query($con, $updateStatusDeactivate);
    }
    else 
    {
        $updateStatusActivate="update tbl_customer set Status='Activate' where Customer_Id='".$_GET['customerID']."'";
        mysqli_query($con, $updateStatusActivate);
    }
    header("location:viewUser.php");
}
?>