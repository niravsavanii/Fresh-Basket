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
        $('.recoverDelete').click(function(e){
           e.preventDefault();
           
           var deleteID=$(this).closest("tr").find('.productDetailID').val();
           
            swal({
                title: "Are you sure?",
                text: "Product will be recovered !",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    
                    $.ajax({
                        url:"recoverSubProduct.php",
                        method:"POST",
                        data:{query:deleteID},
                        success:function()
                        {
                            swal("Product has been recovered!", {
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
                        <h4 style="text-align: center;"class="mr-left">Temporary Deleted Sub Product</h4>                        
                    </div>
                    <div class="col-3">
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
                            <th>Recover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select="SELECT tbl_product_details.Product_Detail_Id,tbl_product_master.Product_Name,tbl_product_details.Image, tbl_product_details.Quality,tbl_product_details.Stock,tbl_product_details.Price,tbl_product_details.Description,tbl_product_master.Category FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_details.Product_Id=tbl_product_master.Product_Id WHERE tbl_product_details.Status=0";
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
                                        echo '<td><button type="button" class="btn btn-info btn-sm recoverDelete">Recover</button></td>';
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