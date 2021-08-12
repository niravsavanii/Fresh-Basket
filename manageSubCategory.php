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
?>
<script>
    (function(document) {
        'use strict';

        var TableFilter = (function(myArray) {
            var search_input;

            function _onInputSearch(e) {
                search_input = e.target;
                var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
                myArray.forEach.call(tables, function(table) {
                    myArray.forEach.call(table.tBodies, function(tbody) {
                        myArray.forEach.call(tbody.rows, function(row) {
                            var text_content = row.textContent.toLowerCase();
                            var search_val = search_input.value.toLowerCase();
                            row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
                        });
                    });
                });
            }

            return {
                init: function() {
                    var inputs = document.getElementsByClassName('search-input');
                    myArray.forEach.call(inputs, function(input) {
                        input.oninput = _onInputSearch;
                    });
                }
            };
        })(Array.prototype);

        document.addEventListener('readystatechange', function() {
            if (document.readyState === 'complete') {
                TableFilter.init();
            }
        });

    })(document);
</script>
<script type="text/javascript">
    $(document).ready( function () {
        $('.confirmDelete').click(function(e){
           e.preventDefault();
           
           var deleteID=$(this).closest("tr").find('.productDetailID').val();
           
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    
                    $.ajax({
                        url:"confirmDeleteSubProduct.php",
                        method:"POST",
                        data:{query:deleteID},
                        success:function()
                        {
                            swal("Product has been deleted!", {
                                icon: "success",
                              })
                              .then((willDelete) => {
                                  location.reload();
                                });
                        }
                    });
                }
              });
        });
        
        $('.delete').click(function(e){
           e.preventDefault();
           
           var deleteID=$(this).closest("tr").find('.productDetailID').val();
           
            swal({
                title: "Are you sure?",
                text: "Product will be temporary deleted!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    
                    $.ajax({
                        url:"deleteSubProduct.php",
                        method:"POST",
                        data:{query:deleteID},
                        success:function()
                        {
                            swal("Product has been temporary deleted!", {
                                icon: "success",
                              })
                              .then((willDelete) => {
                                  location.reload();
                                });
                        }
                    });
                }
              });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<div class="row">
    <div class="col-md-2 ml-4">
    </div>
    <div class="col-md-9 ml-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-3">
                        <input type="search" style="background-color: #f2f2f2;width: 220px; margin-left: auto; float: left;" placeholder="Search..." class="form-control search-input" data-table="product-list"/><br><br>
                    </div>
                    <div class="col-6">
                        <h4 style="text-align: center;"class="mr-left">Available Sub Products </h4>
                    </div>
                    <div class="col-md-3">
                        <select style="background-color: #f2f2f2;width: 220px;" class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option selected disabled>Add New</option>
                            <option value="http://localhost/FreshBasket/addSubCategory.php?category=Fruit&id=1">Fruit</option>
                            <option value="http://localhost/FreshBasket/addSubCategory.php?category=Vegetable&id=2">Vegetable</option>
                            <option value="http://localhost/FreshBasket/addSubCategory.php?category=Seasoning and Herb&id=3">Seasoning and Herb</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">                    
                <table id="datatable1" class="table table-bordered table-hover product-list">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Quality</th>
                            <th>Stock</th>
                            <th>Price/Kg</th>
                            <th>Description</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select="SELECT tbl_product_details.Product_Detail_Id,tbl_product_master.Product_Name,tbl_product_details.Image, tbl_product_details.Quality,tbl_product_details.Stock,tbl_product_details.Price,tbl_product_details.Description,tbl_product_master.Category FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_details.Product_Id=tbl_product_master.Product_Id WHERE tbl_product_details.Status=1";
                            if($result= mysqli_query($con, $select))
                            {
                                if(mysqli_num_rows($result)>0)
                                {
                                    while ($row= mysqli_fetch_array($result))
                                    {
                                        echo "<tr>";
                                        echo '<input type="hidden" class="productDetailID" value="'.$row[0].'">';
                                        echo "<td>".$row[1]."</td>";
                                        ?>
                                        <td><img src="<?php echo $row[2];?>" height="100px" width="100px"></td>
                                            <?php
                                        echo "<td>".$row[7]."</td>";
                                        echo "<td>".$row[3]."</td>";
                                        echo "<td>".$row[4]."</td>";
                                        echo "<td>".$row[5]."</td>";
                                        echo "<td>".$row[6]."</td>";

                                        $selectProductID="select Product_Id,Category from tbl_product_master where Product_Name='".$row[1]."'";
                                        if($resultProductID= mysqli_query($con, $selectProductID))
                                        {
                                            if(mysqli_num_rows($resultProductID) > 0)
                                            {
                                                $row1= mysqli_fetch_array($resultProductID);
                                                $productID=$row1[0];
                                            }
                                        }?>
                                        <td><a href="updateSubProduct.php?category=<?php echo $row1[1];?>&productID=<?php echo $productID;?>&productDetailID=<?php echo $row[0];?>" data-toggle="tooltip" data-placement="bottom" title="Permanently Delete" type="button"><i style="font-size:20px;"class="far fa-edit"></i></a>
                                        <?php
                                        echo '<button style="margin-left:15px;background:none;border:none;color:inherit;padding:0px;outline: inherit;" type="button" data-toggle="tooltip" data-placement="bottom" title="Permanently Delete" class="delete"><i style="color:green;font-size:20px;" class="fas fa-trash"></i></button>';
                                        echo '<button style="margin-left:20px;background:none;border:none;color:inherit;padding:0px;outline: inherit;" type="button" data-toggle="tooltip" data-placement="bottom" title="Permanently Delete" class="confirmDelete"><i style="color:red;font-size:20px;" class="far fa-trash-alt"></i></button></td>';
                                        echo "</tr>";
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
        include 'footerAdmin.php';
?>