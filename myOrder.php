<?php
    require_once 'config.php';
    include 'header.php';
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9">
                        <h4 style="text-align: center;"class="mr-left">My Orders</h4>
                    </div>
                    <div class="col-3">
                        <input type="search" style="width: 300px; margin-left: auto; float: left;" placeholder="Search..." class="form-control search-input" data-table="product-list"/><br><br>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable1" class="table table-bordered table-hover product-list">
                    <thead>
                        <tr>
                            <th>Order Date</th>
                            <th>Total Price</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th style="text-align: center;">Bill</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $selectCartID="select Cart_ID from tbl_cart where Customer_ID='".$_SESSION['customerID']."' and Status='Deactivate' ORDER BY Cart_ID DESC";
                            $resultCartID= mysqli_query($con, $selectCartID);
                            if(mysqli_num_rows($resultCartID)<1)
                            {
                                echo '<script>
                                    swal({
                                        title: "You have not placed an order",
                                        icon: "warning",
                                    }).then(function() {
                                        window.location = "homeCustomer.php";
                                    });
                                </script>';
                            }
                            else 
                            {
                                while ($cartID= mysqli_fetch_array($resultCartID))
                                {
                                    $selectOrder="SELECT `Insert_Date`,`Grand_Total`, `Order_Status`,`Payment_Status`, `Order_ID` FROM `tbl_order` WHERE Cart_ID='".$cartID[0]."'";
                                    $resultOrder= mysqli_query($con, $selectOrder);

                                    while ($order= mysqli_fetch_array($resultOrder))
                                    {
                                    ?>
                        <tr>
                            <td><?php echo $order[0]?></td>
                            <td><?php echo $order[1]?></td>
                            <td><?php echo $order[3]?></td>
                            <td><?php echo $order[2]?></td>
                            <td style="text-align: center;" rowspan="<?php echo $numberOfProduct?>"><a href="generateBill.php?orderID=<?php echo $order[4]?>" data-toggle="tooltip" data-placement="bottom" title="View Bill"><i style="font-size:20px;" class="fas fa-eye"></i></a></td>
                        </tr>
                                    <?php
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
include 'footer.php';
?>
