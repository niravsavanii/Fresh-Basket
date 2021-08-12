<?php
    include_once 'config.php';
    include_once 'configStripe.php';
    ob_start();
    session_start();
    
    if(isset($_POST['stripeToken']))
    {
        $cartID=$_POST['cartID'];
        $grandTotal=$_POST['totalAmount'];
        $amount=$grandTotal*100;
        \Stripe\Stripe::setVerifySslCerts(FALSE);

        $token=$_POST['stripeToken'];

        $data=\Stripe\Charge::create(array(
            "amount"=>$amount,
            "currency"=>"inr",
            "description"=>"Safely Pay",
            "source"=>$token,
        ));
        
        $updateCartStatus="update tbl_cart set Status='Deactivate' where Cart_ID=$cartID";
        mysqli_query($con, $updateCartStatus);
        
        $selectProductDetail="select Product_Detail_ID,Quantity from tbl_cart_details where Cart_ID=$cartID";
        $resultProductDetail= mysqli_query($con, $selectProductDetail);
        if(mysqli_num_rows($resultProductDetail)>0)
        {
            while($rowProductDetail= mysqli_fetch_array($resultProductDetail))
            {
                $updateStock="update tbl_product_details set Stock=Stock-'".$rowProductDetail['Quantity']."' where Product_Detail_Id='".$rowProductDetail['Product_Detail_ID']."'";
                mysqli_query($con, $updateStock);
            }
        }
        
        $insertOrder="insert into tbl_order values (NULL,$cartID,$grandTotal,'Success','Pending',NULL,4)";
        mysqli_query($con, $insertOrder);
    }
    header("location:homeCustomer.php");
    ob_flush();
?>