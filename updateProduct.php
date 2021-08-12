<?php
    require_once 'config.php';
    include 'headerAdmin.php';
    if(!isset($_GET['productID']))
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
    
    $productID=$_GET['productID'];
    $select="select * from tbl_product_master where Product_Id=$productID";
    if($result= mysqli_query($con, $select))
    {
        if(mysqli_num_rows($result)>0)
        {
            while ($row= mysqli_fetch_array($result))
            {
                $productName=$row['Product_Name'];
                $category=$row['Category'];
            }
        }
    }
    $error='';
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $productName=$_POST['productName'];
        $category=$_POST['category'];
        
        if($productName==''||$category=='')
        {
            $error="Fill all the details";
        }
        else
        {                
            $select="select * from tbl_product_master where Product_Id not in ('$productID') and Product_Name='$productName'" ;
            if($result= mysqli_query($con, $select))
            {
                if(mysqli_num_rows($result) > 0)
                {
                    ?><script>
                    swal({
                        title: "<?php echo $productName?> already exists!",
                        icon: "warning"
                    });
                </script><?php
                }
                else 
                {
                    $update="update tbl_product_master set Product_Name='$productName',Category='$category' where Product_Id='$productID'";
                    if($result= mysqli_query($con, $update))
                    {
                        ?><script>
                        swal({
                            title: "<?php echo $productName?> Updated Successfully!",
                            icon: "success"
                        }).then(function() {
                            window.location = "homeAdmin.php";
                        });
                    </script><?php
                    }
                }
            }
        }
    }
?>

<script type="text/javascript">
     $(document).ready(function(){
         
        $('#productName').keyup(function(){
            var productName=$('#productName').val();

            if(productName !='')
            {
                $.ajax({
                    url:"searchProduct.php",
                    method:"POST",
                    data:{query:productName},
                    success:function(data)
                    {
                        $('#productList').fadeIn();
                        $('#productList').html(data);
                    }
                });
                 
                if(!/^[a-zA-Z]*$/g.test(document.addProductForm.productName.value)) 
                {
                    $('#productNameErr').html('Enter only alphabets');
                    return false;
                }
                else if(productName.length<2)
                {
                    $('#productNameErr').html('Enter atleast 2 alphabets');
                    return false;
                }
                else if(productName.length>20)
                {
                    $('#productNameErr').html('Enter within 20 alphabets');
                    return false;
                }
                else
                {
                    $('#productNameErr').html('');
                    return false;
                }
            }
            else
            {
                $('#productNameErr').html("Product name is required");
                $('#productList').fadeOut();
                $('#productList').html("");
            }
        });
         
        $(document).on('click','li',function(){
            $('productList').fadeOut(); 
        });
    });
 </script>
<div class="container">
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col">
                                <h4>Update Product Here..</h4>
                        </div>
                    </div><hr>
                    <form action="" method="post" name="addProductForm">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="inputProductName" class="form-label">Product Name</label>
                                    <input type="text" name="productName" id="productName" value="<?php echo $productName;?>" class="form-control" placeholder="Enter Product Name">
                                    
                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="productNameErr"></span>
                                        </div>
                                    </div>
                                    
                                    <div id="productList">
                                    </div>                                                                        
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="inputPassword" class="form-label">Category</label>
                                    <select id="category" class="form-control" name="category">                                                
                                        <option value="<?php echo $category;?>" selected ><?php echo $category;?></option>
                                        
                                        <?php
                                            $select="select Category from tbl_category where Category not in ('$category')";
                                            if($result= mysqli_query($con, $select))
                                            {
                                                if(mysqli_num_rows($result)>0)
                                                {
                                                    while ($row= mysqli_fetch_array($result))
                                                    {
                                                        ?>
                                                            <option value="<?php echo $row["Category"];?>"><?php echo $row["Category"];?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                                                                
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input style="padding-right:20px; padding-left: 20px;" class="btn btn-success my-2 my-sm-0" type="submit" value="Update">
                                </div>
                            </div>

                            <div class="col-9">
                                <span style="color: red;"><?php echo $error;?></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
<?php
        include 'footerAdmin.php';
?>