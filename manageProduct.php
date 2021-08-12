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
           
           var deleteID=$(this).closest("tr").find('.productID').val();
           
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
                        url:"confirmDeleteProduct.php",
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
           
           var deleteID=$(this).closest("tr").find('.productID').val();
           
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
                        url:"deleteProduct.php",
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
                        <h4 style="text-align: center;"class="mr-left">Available Products </h4>
                    </div>
                    <div class="col-1">                        
                    </div>
                    <div class="col-2">
                        <a style="padding-right:20px; padding-left: 20px;" href="addProduct.php" class="btn btn-primary">Add New</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="datatable1" class="table table-bordered table-hover product-list">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select="select * from tbl_product_master where Status=1";
                            if($result= mysqli_query($con, $select))
                            {
                                if(mysqli_num_rows($result)>0)
                                {
                                    while ($row= mysqli_fetch_array($result))
                                    {
                                        echo "<tr>";
                                        echo '<input type="hidden" class="productID" value="'.$row['Product_Id'].'">';
                                        echo "<td>".$row['Product_Name']."</td>";
                                        echo "<td>".$row['Category']."</td>";?>
                    <td><a href="updateProduct.php?productID=<?php echo $row['Product_Id'];?>" data-toggle="tooltip" data-placement="bottom" title="Edit Product"><i style="font-size:20px;"class="far fa-edit"></i></a>
                                        <?php 
                                        echo '<button style="margin-left:15px;background:none;border:none;color:inherit;padding:0px;outline: inherit;" data-toggle="tooltip" data-placement="bottom" title="Temporary Delete" type="button" class="delete"><i style="color:green;font-size:20px;" class="fas fa-trash"></i></button>';
                                        echo '<button style="margin-left:15px;background:none;border:none;color:inherit;padding:0px;outline: inherit;" data-toggle="tooltip" data-placement="bottom" title="Permanently Delete" type="button" class="confirmDelete"><i style="color:red;font-size:20px;" class="far fa-trash-alt"></i></button></td>';
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