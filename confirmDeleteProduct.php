<?php
require_once 'config.php';
session_start();
ob_start();
if(!isset($_POST['query']))
{
    header("location:homeAdmin.php");
}
if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
{
    header("location:index.php");
}
else if(!isset($_SESSION['customerID']) && isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
{
    header("location:homeAdmin.php");
}
else if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && isset($_SESSION['deliveryBoyID']))
{
    header("location:homeDeliveryBoy.php");
}
if(isset($_POST['query']))
{
    $query = "delete FROM tbl_product_master WHERE Product_ID = '".$_POST['query']."'";
    mysqli_query($con, $query);
}
ob_flush();
?>