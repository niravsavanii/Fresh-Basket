<?php    
    require_once 'config.php';
    include 'headerAdmin.php';
    if(!isset($_GET['category']))
    {
        header("location:homeAdmin.php");
    }
    else if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
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
    $error='';
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
                    
                    $select="SELECT * FROM tbl_product_details WHERE Product_Id='".$productID."' and Quality='".$quality ."'";
                    if($result= mysqli_query($con, $select))
                    { 
                        if(mysqli_num_rows($result) > 0)
                        {
                            ?><script>
                            swal({
                                title: "<?php echo $quality.' '.$productName?> already exists!",
                                icon: "warning"
                            }).then(function() {
                            window.location = "addSubCategory.php";
                        });
                        </script><?php
                        }
                        else 
                        {
                            $insert="INSERT INTO tbl_product_details (Image, Quality, Stock, Price, Description, Status, Product_Id) VALUES ('$image','$quality','$stock','$price','$desciption','1','$productID')";
                            if($resultInsert= mysqli_query($con, $insert))
                            {
                                ?><script>
                                swal({
                                    title: "<?php echo $quality.' '.$productName?> Add Successfully!",
                                    icon: "success"
                                }).then(function() {
                                    window.location = "homeAdmin.php";
                                });
                            </script><?php
                            }
                        }
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
 <div class="row">
    <div class="col-md-2 ml-4">
    </div>
    <div class="col-md-9 ml-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 style="text-align: center;">Add <?php echo $category;?> Here</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post" name="addProductForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-4">
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
                        <div class="col-4">
                            <div class="form-group">
                                <b><label for="inputQuality" class="form-label">Quality<span style="color: red;"> *</span></label></b>
                                <select id="qualitys" class="form-control" name="quality">                                                
                                    <option value="" selected > Select Quality</option>
                                    <option value="Standard">Standard</option>
                                    <option value="Regular">Regular</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <b><label for="image">Image<span style="color: red;"> *</span></label></b>
                                <input type="file" name="image" id="image" accept="image/*" class="form-control">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="imageErr"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <b><label for="inputStock" class="form-label">Total Stock<span style="color: red;"> *</span></label></b>
                                <input type="number" name="stock" id="stock" class="form-control" placeholder="Enter Stock in Kg.">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="stockErr"></span>
                                    </div>
                                </div>
                            </div>
                        </div>               
                        <div class="col-4">
                            <div class="form-group">
                                <b><label for="inputPrice" class="form-label">Price<span style="color: red;"> *</span></label></b>
                                <input type="number" name="price" id="price" class="form-control" placeholder="Enter Price/Kg.">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="priceErr"></span>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <b><label for="description" class="form-label">Description<span style="color: red;"> *</span></label></b>
                                <textarea style="resize:none;" name="description" rows="3" id="description" class="form-control" placeholder="Enter Description"></textarea>

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