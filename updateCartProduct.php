<?php
    include_once 'config.php';;
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
    
    if(isset($_POST['quality']))
    {
        $query=$_POST['quality'];

        $data=explode("-", $query);
        $id=$data[0];
        $name=$data[1];
        $quality=$data[2];

        $select="SELECT tbl_product_details.Product_Detail_Id,tbl_product_details.Price from tbl_product_details INNER JOIN tbl_product_master ON tbl_product_master.Product_Id=tbl_product_details.Product_Id WHERE tbl_product_details.Quality='$quality' and tbl_product_master.Product_Name='$name'";
        $result= mysqli_query($con, $select);

        if(mysqli_num_rows($result)>0)
        {
            $row= mysqli_fetch_array($result);
            
            $update="update tbl_cart_details set Product_Detail_ID=$row[0],Total_Price=$row[1] where Cart_Detail_ID=$id";
            mysqli_query($con, $update);
        }
        else
        {
            echo "not available";
        }
    }
else 
{
    header("location:homeCustomer.php");
}
    ob_flush();
?>