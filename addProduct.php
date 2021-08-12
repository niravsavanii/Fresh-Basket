<?php
    require_once 'config.php';
    include 'headerAdmin.php';
    
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
            $select="select * from tbl_product_master where Product_Name='$productName'";
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
                    $insert="INSERT INTO tbl_product_master (Product_Id,Product_Name,Category,Status) VALUES ('NULL', '$productName','$category' , '1')";
                    if($result= mysqli_query($con, $insert))
                    {
                        ?><script>
                        swal({
                            title: "<?php echo $productName?> Add Successfully!",
                            icon: "success"
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
 <div class="row">
    <div class="col-md-2 ml-4">
    </div>
    <div class="col-md-9 ml-5">
        <div class="card">
            <div class="card-header">
                <h4 style="text-align: center;">Add New Product Here</h4>
            </div>
            <div class="card-body">
                <form action="" method="post" name="addProductForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b><label for="inputProductName" class="form-label">Product Name<span style="color: red;"> *</span></label></b>
                                <input type="text" name="productName" id="productName" class="form-control" placeholder="Enter Product Name">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="productNameErr"></span>
                                    </div>
                                </div>                                                             
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b><label for="inputCategory" class="form-label">Category<span style="color: red;"> *</span></label></b>
                                <select id="category" class="form-control" name="category">                                                
                                    <option value="" selected >Select Category</option>
                                    <option value="Fruit">Fruit</option>
                                    <option value="Vegetable">Vegetable</option>
                                    <option value="Seasoning and Herb">Seasoning and Herb</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <input style="padding-right:20px; padding-left: 20px;" class="btn btn-primary my-2 my-sm-0" type="submit" value="ADD">
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
<?php
        include 'footerAdmin.php';
?>