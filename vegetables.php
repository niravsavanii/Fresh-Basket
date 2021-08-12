<?php
    require_once 'config.php';
    include ('header.php');
    if(isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeAdmin.php");
    }
    if(!isset($_SESSION['adminID']) && isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeDeliveryBoy.php");
    }
?>
<div class="container-fluid">
    <div  class="row">
        <?php
            $select="SELECT distinct tbl_product_master.Product_Name,tbl_product_details.Quality,tbl_product_details.Image,tbl_product_details.Stock,tbl_product_details.Price,tbl_product_details.Description,tbl_product_details.Product_Detail_Id FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_details.Product_Id=tbl_product_master.Product_Id WHERE tbl_product_master.Category='Vegetable' AND tbl_product_details.Status='1' GROUP BY tbl_product_master.Product_Name" ;
            if($result= mysqli_query($con, $select))
            {
                if(mysqli_num_rows($result)>0)
                {
                    while ($row= mysqli_fetch_array($result))
                    {
                        $productName=$row[0];
                        $quality=$row[1];
                        $image=$row[2];
                        $stock=$row[3];
                        $price=$row[4];
                        $desciption=$row[5];
                        $productDetailID=$row[6];
                        ?>                        
        <div class="col-3">
            <form action="" method="post">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?php echo $image;?>" alt="Card image" height="200px" width="150px">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $productName;?></h5>                       
                        <h6 class="card-text">Quality : <?php echo $row[1]?></h6>
                        
                        <div class="row">
                            <div class="col-md-9">
                                <h6 class="card-text">1 Kg - Rs. <?php echo $price;?></h6>
                            </div>
                            <div class="col-md-3">
                                <a href="manageCart.php?productDetailID=<?php echo $row[6]?>&totalPrice=<?php echo $row[4]?>"><i style="color:green;font-size:25px;" class="fas fa-cart-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>                 
                        <?php
                    }
                }
            }
        ?>
    </div>
</div>
<?php
    include 'footer.php';
?>