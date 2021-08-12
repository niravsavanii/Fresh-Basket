<?php
require_once 'config.php';
session_start();
ob_start();
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
if(isset($_GET['cartDetailID']) && isset($_GET['cartID']))
{
    $cartDetailID=$_GET['cartDetailID'];
    $cartID=$_GET['cartID'];
    
    $removeFromCart="delete from tbl_cart_details where Cart_Detail_ID=$cartDetailID and Cart_ID=$cartID";
    mysqli_query($con, $removeFromCart);
    header("location:cart.php");
}
else 
{
    header("location:homeCustomer.php");
}

ob_flush();
?>