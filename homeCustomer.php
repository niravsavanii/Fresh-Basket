<?php
    require_once 'config.php';
    include ('header.php');
    
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
?>
<div class="bd-example">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="Image/slider1.jpg" class="d-block" width="1350px" height="380px" alt="...">
            </div>

            <div class="carousel-item">
                <img src="Image/slider2.jpg" class="d-block" width="1350px" height="380p" alt="...">
            </div>

            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div  class="row">
        <div style="text-align: center;"class="col-3">
            <h3 style="margin-top:75px">Fruits</h3>
            
            <p>To buy fresh fruits..</p>
            
            <br><a href="fruit.php" class="btn btn-success my-2 my-sm-0">SHOP NOW</a> 
        </div>
        <?php
            $select="SELECT tbl_product_master.Product_Name,tbl_product_details.Quality,tbl_product_details.Image,tbl_product_details.Stock,tbl_product_details.Price,tbl_product_details.Description,tbl_product_details.Product_Detail_Id FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_details.Product_Id=tbl_product_master.Product_Id WHERE tbl_product_master.Category='Fruit' AND tbl_product_details.Status='1' GROUP BY tbl_product_master.Product_Name limit 3" ;
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
            <form action="homeCustomer.php" method="post">
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
<div class="container-fluid">
    <div  class="row">
        <div style="text-align: center;"class="col-3">
            <h3 style="margin-top:75px">Vegetables</h3>
            
            <p>To buy fresh vegetables..</p>
            
            <br><a href="vegetables.php" class="btn btn-success my-2 my-sm-0">SHOP NOW</a> 
        </div>
        <?php
            $select="SELECT tbl_product_master.Product_Name,tbl_product_details.Quality,tbl_product_details.Image,tbl_product_details.Stock,tbl_product_details.Price,tbl_product_details.Description,tbl_product_details.Product_Detail_Id FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_details.Product_Id=tbl_product_master.Product_Id WHERE tbl_product_master.Category='Vegetable' AND tbl_product_details.Status='1' GROUP BY tbl_product_master.Product_Name limit 3" ;
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
            <form action="homeCustomer.php" method="post">
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
<div class="container-fluid">
    <div  class="row">
        <div style="text-align: center;"class="col-3">
            <h3 style="margin-top:75px">Seasoning and Herbs</h3>
            
            <p>To buy fresh seasoning and herbs..</p>
            
            <br><a href="seasoningAndHerb.php" class="btn btn-success my-2 my-sm-0">SHOP NOW</a> 
        </div>
        <?php
            $select="SELECT tbl_product_master.Product_Name,tbl_product_details.Quality,tbl_product_details.Image,tbl_product_details.Stock,tbl_product_details.Price,tbl_product_details.Description,tbl_product_details.Product_Detail_Id FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_details.Product_Id=tbl_product_master.Product_Id WHERE tbl_product_master.Category='Seasoning and Herb' AND tbl_product_details.Status='1' GROUP BY tbl_product_master.Product_Name limit 3" ;
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
            <form action="homeCustomer.php" method="post">
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