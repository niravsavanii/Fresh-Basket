<?php
    include 'config.php';
    include 'headerTemp.php';

    if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:login.php");
    }
    else if(!isset($_SESSION['customerID']) && isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeAdmin.php");
    }
    else if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeDeliveryBoy.php");
    }    
    
    if(isset($_GET['productDetailID']) && isset($_GET['totalPrice']))
    {
        $productDetailID=$_GET['productDetailID'];
        $totalPrice=$_GET['totalPrice'];
        
        $dateInsert=date("Y/m/d");
    
        //Check cart is exist or not
        $selectCartId="SELECT Cart_ID FROM `tbl_cart` WHERE Customer_ID='".$_SESSION['customerID']."' AND Status='Active'";
        $cartAvailable= mysqli_query($con, $selectCartId);
        
        if(mysqli_num_rows($cartAvailable)==1)
        {
            $resultCartId= mysqli_query($con, $selectCartId);
                if(mysqli_num_rows($resultCartId)==1)
                {
                    $rowCartID = mysqli_fetch_array($resultCartId);
                    $cartID=$rowCartID[0];

                    //check product is exist in cart or not
                    $productExist="select * from tbl_cart_details where Product_Detail_ID=$productDetailID and Cart_ID=$cartID";

                    $resultProductExist= mysqli_query($con,$productExist);
                    if(mysqli_num_rows($resultProductExist)==1)
                    {
                        echo '<script>
                            swal({
                                title: "Product is already in a cart",
                                icon: "warning",
                            }).then(function() {
                                window.location = "homeCustomer.php";
                            });</script>';
                    }
                    else
                    {
                        $AddToCart="insert into tbl_cart_details values (NULL,$cartID,$productDetailID,1,$totalPrice,'$dateInsert')";
                        mysqli_query($con, $AddToCart);
                        header("location:homeCustomer.php");
                    }   
                }
        }
        else
        {
            $createCart="insert into tbl_cart values (NULL,'".$_SESSION['customerID']."','$dateInsert','Active')";
            if(mysqli_query($con, $createCart))
            {
                $resultCartId= mysqli_query($con, $selectCartId);
                if(mysqli_num_rows($resultCartId)==1)
                {
                    $rowCartID = mysqli_fetch_array($resultCartId);
                    $cartID=$rowCartID[0];

                    $AddToCart="insert into tbl_cart_details values (NULL,$cartID,$productDetailID,1,$totalPrice,'$dateInsert')";
                    mysqli_query($con, $AddToCart);
                    header("location:homeCustomer.php");                    
                }                    
            }
        }
    }
    ob_flush();
?>