<?php 
    require_once 'config.php';
    include 'headerAdmin.php';
    if(!isset($_GET['category']))
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
    
    $category=$_GET['category'];
    $productDetailID=$_GET['productDetailID'];
    $error='';
  
    $select="SELECT tbl_product_master.Product_Name,tbl_product_details.Quality,tbl_product_details.Image,tbl_product_details.Stock,tbl_product_details.Price,tbl_product_details.Description FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_details.Product_Id=tbl_product_master.Product_Id WHERE tbl_product_details.Product_Detail_Id='".$productDetailID."'";
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
            }
        }
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $productName=$_POST['productName'];
        $quality=$_POST['quality'];
        $stock=$_POST['stock'];
        $price=$_POST['price'];
        $desciption=$_POST['description'];
        
        $file=$_FILES['image'];
        $fileName=$file['name'];
        $fileTemp=$file['tmp_name'];
        
        $image='uploadImage/'.$fileName;
        move_uploaded_file($fileTemp, $image);
                
        
        if($productName==''||$quality==''||$stock==''||$price==''||$desciption==''||$image=='')
        {
            $error="Fill all the details";
        }
        else
        {
            $selectProductID="select Product_Id from tbl_product_master where Product_Name='".$productName."'";
            if($resultProductID= mysqli_query($con, $selectProductID))
            {
                if(mysqli_num_rows($resultProductID) > 0)
                {
                    $row= mysqli_fetch_array($resultProductID);
                    $productID=$row[0];
                    
                    $select="SELECT * FROM tbl_product_details WHERE Product_Id='".$productID."' AND Quality='".$quality."' AND Product_Detail_Id='".$productDetailID."'";
                    if($result= mysqli_query($con, $select))
                    { 
                        if(mysqli_num_rows($result) > 0)
                        {
                            $update="update tbl_product_details set Image='".$image."',Stock='".$stock."',Price='".$price."',Description='".$desciption."' where Product_Detail_Id='".$productDetailID."'";
                            if($resultUpdate= mysqli_query($con, $update))
                            {

                            ?><script>
                                swal({
                                    title: "<?php echo $quality.' '.$productName?> updated successfully!",
                                    icon: "success"
                                }).then(function() {
                                    window.location = "homeAdmin.php";
                                });
                            </script><?php
                            }
                        }
                        /*else 
                        {
                            $select1="select * from tbl_product_details where Product_Id='".$productID."' and Quality='".$quality."' and Product_Detail_Id not in ('".$productDetailID."')";
                            
                            if($resultUpdate1= mysqli_query($con, $update1))
                            {
                                ?><script>
                                swal({
                                    title: "<?php echo $quality.' '.$productName?> Add Successfully!",
                                    icon: "success"
                                });
                            </script><?php
                            }
                        }*/
                    }
                }
                else
                {
                    ?><script>
                        swal({
                            title: "<?php echo $productName?> is not exist!",
                            text: "First insert product",
                            icon: "warning"
                        }).then(function() {
                            window.location = "addProduct.php";
                        });
                    </script><?php
                }
            }
        }
    }
?>

<script type="text/javascript">
     $(document).ready(function(){
         
        $('#productName').keyup(function(){
            var productName=$('#productName').val();
            var category="<?php echo $category;?>";
            
            if(productName !='')
            {
                $.ajax({
                    url:"searchProductForSubCategory.php",
                    method:"POST",
                    data:{query:productName,category:category},
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
            $('#productName').val($(this).text());
            $('#productNameErr').html('');
            $('#productList').fadeOut(); 
        });
        
        $('#stock').keyup(function(){
            var stock=$('#stock').val();
            if (stock === "")
            {
                $('#stockErr').html('Stock is required');
                return false;
            }
            else
            {
                if(stock.length>=5)
                {
                    $('#stockErr').html('Enter stock properly');
                    return false;
                }
                else if(!/^[0-9]+$/.test(document.addProductForm.stock.value)) 
                {
                    $('#stockErr').html('Enter only digit');
                    return false;
                }
                else
                {
                    $('#stockErr').html('');
                    return false;
                }
            }
        });
        
        $('#price').keyup(function(){
            var price=$('#price').val();
            if (price === "")
            {
                $('#priceErr').html('Price is required');
                return false;
            }
            else
            {
                if(price.length>=5)
                {
                    $('#priceErr').html('Enter price properly');
                    return false;
                }
                else if(!/^[0-9]+$/.test(document.addProductForm.price.value)) 
                {
                    $('#priceErr').html('Enter only digit');
                    return false;
                }
                else
                {
                    $('#priceErr').html('');
                    return false;
                }
            }
        });
        
        $('#description').keyup(function(){
            var description=$('#description').val();
            if (description === "")
            {
                $('#descriptionErr').html('description is required');
                return false;
            }
            else
            {
                if(description.length<=6 || description>150)
                {
                    $('#descriptionErr').html('description between 7 to 150 characters');
                    return false;
                }
                else if(!/^[a-zA-Z0-9 ]*$/.test(document.addProductForm.description.value)) 
                {
                    $('#descriptionErr').html('Description must be alpha numeric');
                    return false;
                }
                else
                {
                    $('#descriptionErr').html('');
                    return false;
                }
            }
        });
    });
 </script>
<div class="container">
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col">
                                <h4>Update Product Here..</h4>
                        </div>
                    </div><hr>
                    <form action="" method="post" name="addProductForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="inputProductName" class="form-label">Product Name</label>
                                    <input type="text" name="productName" id="productName" class="form-control" value="<?php echo $productName;?>" placeholder="Enter Product Name *">
                                    
                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="productNameErr"></span>
                                        </div>
                                    </div>
                                    
                                    <div id="productList">
                                    </div>                                                                        
                                </div>
                            </div>
                            <div class="col-6">
                                <img src="<?php echo $image;?>" height="150px;" width="150px">
                            </div>                            
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="inputQuality" class="form-label">Quality</label>
                                    <select id="quality" class="form-control" name="quality">                                                
                                        <option value="<?php echo $quality;?>" selected><?php echo $quality;?></option>
                                        <option value="Standard">Standard</option>
                                        <option value="Regular">Regular</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="image">Image</label>
                                    <input type="file" name="image" id="image" value="<?php echo $image;?>"accept="image/*" class="form-control">
                                    
                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="imageErr"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="inputStock" class="form-label">Total Stock</label>
                                    <input type="text" name="stock" id="stock" class="form-control" value="<?php echo $stock;?>" placeholder="Enter Stock in Kg *">
                                    
                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="stockErr"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>               
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="inputPrice" class="form-label">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" value="<?php echo $price;?>" placeholder="Enter Price/Kg *">
                                    
                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="priceErr"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label style="font-weight: normal;" for="description" class="form-label">Description</label>
                                    <textarea style="resize:none;" name="description" rows="3" id="description" class="form-control" placeholder="Enter Description *"><?php echo $desciption;?></textarea>
                                    
                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="descriptionErr"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input style="padding-right:20px; padding-left: 20px;" class="btn btn-success my-2 my-sm-0" type="submit" value="Update Product">
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