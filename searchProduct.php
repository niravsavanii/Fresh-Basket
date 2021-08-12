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
    else if(isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeCustomer.php");
    }
    else if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeDeliveryBoy.php");
    }
if(isset($_POST['query']))
{
    
    $output='';
    $query = "SELECT * FROM tbl_product_master WHERE Product_Name LIKE '".$_POST['query']."%' ORDER BY Product_Name ASC";
    $result = mysqli_query($con, $query);	
    $output='<ul style="background-color:#eee; margin-top:3px; cursor:pointer;" class="list-unstyled">';
    
    if(mysqli_num_rows($result)>0)
    {
        while($row= mysqli_fetch_array($result))
        {
            $output .='<li style="padding:7px;">'.$row["Product_Name"].'</li>';
        }
    }
    $output .='</ul>';
    echo $output;
}
ob_flush();
?>