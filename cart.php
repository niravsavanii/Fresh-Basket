<?php
    require_once 'config.php';
    include 'header.php';
    include_once 'configStripe.php';

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
    
    $count=0;
    $selectCartId="select * from tbl_cart where Customer_ID='".$_SESSION['customerID']."' and Status='Active'";
    $resultCartId= mysqli_query($con, $selectCartId);
    
    if(mysqli_num_rows($resultCartId)==1)
    {
        $rowCartID = mysqli_fetch_array($resultCartId);
        $cartID=$rowCartID['Cart_ID'];

        $selectProductCount="SELECT * FROM `tbl_cart_details` WHERE Cart_ID=$cartID";
        $resultProductCount= mysqli_query($con, $selectProductCount);
        $count = mysqli_num_rows($resultProductCount);
    }
    if($count < 1)
    {
        echo '<script>
            swal({
                title: "Cart is empty",
                icon: "warning",
            }).then(function() {
                window.location = "homeCustomer.php";
            });
        </script>';
    }
    else
    {
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 y-2">
        </div>
        <div class="col-md-2 text-center my-2">
            <h2>MY CART</h2><hr>
        </div>
        <div class="col-md-5 my-2">
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php
                $totalAmount=0;
                $totalPayabelAmount=0;
                $deliveryCharge=0;
                
                $selectProduct="SELECT tbl_cart_details.Cart_Detail_ID,tbl_product_details.Product_Detail_Id,tbl_product_master.Product_Name,tbl_product_details.Image,tbl_product_details.Quality,tbl_product_details.Price,tbl_product_details.Description,tbl_cart_details.Cart_ID,tbl_cart_details.Quantity FROM tbl_cart_details INNER JOIN tbl_product_details ON tbl_product_details.Product_Detail_Id=tbl_cart_details.Product_Detail_ID INNER JOIN tbl_product_master ON tbl_product_master.Product_Id=tbl_product_details.Product_Id WHERE tbl_cart_details.Cart_ID=$cartID";
                $resultProduct= mysqli_query($con, $selectProduct);
                
                while($row= mysqli_fetch_array($resultProduct))
                {
                    $totalAmount=$totalAmount +(($row[8])*($row[5]));
            ?>        
            <div class="border-rounded">
                <div class="row bg-white">
                    <div class="col-md-4 pl-0">
                        <img src="<?php echo $row[3]?>" class="img-fluid">
                    </div>
                    <div class="col-md-5 pl-3 pt-3">
                        <h5><?php echo $row[2]?></h5>
                        <h6>
                            Quality : 
                            <select name="quality" class="quality">
                                <option value="<?php echo $row[0].'-'.$row[2].'-'.$row[4];?>" selected><?php echo $row[4];?></option>
                                <?php
                                    $selectQuality="select * from tbl_quality where not Quality='".$row[4]."'";
                                    if($resultQuality= mysqli_query($con, $selectQuality))
                                    {                                        
                                        while ($rows= mysqli_fetch_array($resultQuality))
                                        {?>                                      
                                            <option value="<?php echo $row[0].'-'.$row[2].'-'.$rows[1];?>"><?php echo $rows[1];?></option>
                                        <?php }
                                    }
                                ?>
                            </select>
                        </h6>
                        <h6>Description : <?php echo $row[6];?></h6>
                        <h6>Price Per Kg : <?php echo $row[5];?>Rs.</h6>
                        <input type="hidden" class="itemPrice" value="<?php echo $row[5];?>">
                        <h6>Total : <label class="itemTotal"></label></h6>
                    </div>
                    <div class="col-md-3 pl-4 pt-3">
                        <h6 class="ml-3">Quantity in Kg</h6>
                            <form action="" method="post">
                                <button type="button" onclick="decrement()" id="minus" class="btn  bg-light"><i class="fas fa-minus"></i></button>
                                <input type="hidden" name="cartDetailID" value="<?php echo $row[0];?>">
                                <input type="number" name="modifyQuantity" id="input" onchange="this.form.submit();" class="form-control d-inline itemQuantity" value="<?php echo $row[8]?>" min="1" max="20" style="width: 66px;height: 30px;">
                                <button type="button" onclick="increment()" id="plus" class="btn  bg-light"><i class="fas fa-plus"></i></button>
                            </form>
                            <a href="removeProductFromCart.php?cartDetailID=<?php echo $row[0];?>&cartID=<?php echo $row[7]?>" data-toggle="tooltip" data-placement="bottom" title="Remove From Cart"><i style="color:red;font-size:25px;" class="far fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
        <div class="col-md-4">
            <div class="border bg-white rounded p-3">
                <h4 class="text-center">Price Summary </h4><hr>
                <?php
                    if($totalAmount<800)
                    {
                        $deliveryCharge=50;
                    }
                    else 
                    {
                        $deliveryCharge=0;
                    }
                    $totalPayabelAmount=$deliveryCharge+$totalAmount;
                ?>   
                <div class="row">
                    <div class="col-md-7">
                        <h6> Total Product Amount </h6>
                    </div>
                    <div class="col-md-1">
                        <h6 class="text-center"> : </h6>
                    </div>
                    <div class="col-md-4">
                        <h6><?php echo $totalAmount;?> Rs.</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <h6> Delivery Charge </h6>
                    </div>
                    <div class="col-md-1">
                        <h6 class="text-center"> : </h6>
                    </div>
                    <div class="col-md-4">
                        <h6><?php echo $deliveryCharge;?> Rs.</h6>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-md-7">
                        <h6> Total Payable Amount </h6>
                    </div>
                    <div class="col-md-1">
                        <h6 class="text-center"> : </h6>
                    </div>
                    <div class="col-md-4">
                        <h6><?php echo $totalPayabelAmount;?> Rs.</h6>
                    </div>
                </div>                  
                <div class="row">      
                    <div class="col-md-8">    
                        <p>Payabel amount is under 800 Rs. than delivery charge is 50 Rs. otherwise free delivery.</p>
                    </div>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="online" checked>
                    <label class="form-check-label"><h6>
                            Online Payment</h6>
                    </label>
                </div><br>
                    
                <form action="order.php" method="POST">
                    <input type="hidden" name="cartID" value="<?php echo $cartID?>">
                    <input type="hidden" name="totalAmount" value="<?php echo $totalPayabelAmount?>">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?php echo $publishableKey?>"
                        data-amount="<?php echo ($totalPayabelAmount*100)?>"
                        data-name="Fresh Basket"
                        data-description="Safely pay"
                        data-image="Image/topLogo.png"
                        data-currency="inr"
                        data-email="<?php echo $_SESSION['emailID']?>"
                    >
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>        
<?php
    }
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(isset($_POST['modifyQuantity']))
    {
        $updateQuantity="update tbl_cart_details set Quantity='".$_POST['modifyQuantity']."',Total_Price=Total_Price*'".$_POST['modifyQuantity']."' where Cart_Detail_ID='".$_POST['cartDetailID']."'";
        mysqli_query($con, $updateQuantity);
    
        echo "<script>
            window.location.href='cart.php';
        </script>";
    }
}
?>
<script>
    var itemPrice=document.getElementsByClassName('itemPrice');
    var itemQuantity=document.getElementsByClassName('itemQuantity');
    var itemTotal=document.getElementsByClassName('itemTotal');
       
    function subTotal()
    {
        for(i=0;i<itemPrice.length;i++)
        {
            itemTotal[i].innerText=(itemPrice[i].value)*(itemQuantity[i].value);
        }
    }
    subTotal();
</script>
<script>
    function increment() {
      document.getElementById('input').stepUp();
    }
    function decrement() {
       document.getElementById('input').stepDown();
    }
</script>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    $(".quality").change(function(){
        var quality=$(this).val();
        $.ajax({
            url:"updateCartProduct.php",
            method:"POST",
            data:{quality:quality},
            success:function()
            {
                location.reload();
            }
        });   
    });
</script>
<script>
  $('[data-toggle="tooltip"]').tooltip();   
</script>
<?php
include 'footerAdmin.php';
?>