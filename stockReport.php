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
?><script>
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
<div class="row">
    <div class="col-md-2 ml-4">
    </div>
    <div class="col-md-9 ml-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <input type="search" style="background-color: #f2f2f2;width: 220px; margin-left: auto; float: left;" placeholder="Search..." class="form-control search-input" data-table="product-list"/><br><br>
                    </div>
                    <div class="col-md-6">
                        <h4 style="text-align: center;"class="mr-left">Stock Report</h4>
                    </div>
                    <div class="col-md-3">
                        <select style="background-color: #f2f2f2;"class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option selected disabled><?php echo $_GET['category']?></option>
                            <option value="http://localhost/FreshBasket/stockReport.php?category=Fruit">Fruit</option>
                            <option value="http://localhost/FreshBasket/stockReport.php?category=Vegetable">Vegetable</option>
                            <option value="http://localhost/FreshBasket/stockReport.php?category=Seasoning and Herb">Seasoning and Herb</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="datatable1" class="table table-bordered table-hover product-list">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quality</th>
                            <th>Total Stock</th>
                            <th>Total Sell</th>
                            <th>Available Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select="SELECT tbl_product_master.Product_Name,tbl_product_details.Quality,tbl_product_details.Stock+SUM(tbl_cart_details.Quantity) AS 'Total Stock',SUM(tbl_cart_details.Quantity) AS 'Total Sell',tbl_product_details.Stock AS 'Available Stock' FROM tbl_product_details INNER JOIN tbl_product_master ON tbl_product_master.Product_Id=tbl_product_details.Product_Id INNER JOIN tbl_cart_details ON tbl_cart_details.Product_Detail_ID=tbl_product_details.Product_Detail_Id WHERE tbl_product_master.Category='".$_GET['category']."' GROUP BY tbl_cart_details.Product_Detail_ID ORDER BY tbl_product_details.Stock";
                            if($result= mysqli_query($con, $select))
                            {
                                if(mysqli_num_rows($result)>0)
                                {
                                    while ($row= mysqli_fetch_array($result))
                                    {
                                        echo "<tr>";
                                        echo "<td>".$row[0]."</td>";
                                        echo "<td>".$row[1]."</td>";
                                        echo "<td>".$row[2]."</td>";
                                        echo "<td>".$row[3]."</td>";
                                        echo "<td>".$row[4]."</td>";
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