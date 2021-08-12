<?php
    require_once 'config.php';
    include ('headerDeliveryBoy.php');
    
    if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:index.php");
    }
    else if(!isset($_SESSION['customerID']) && isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeAdmin.php");
    }
    else if(isset($_SESSION['customerID']) && !isset($_SESSION['adminID']) && !isset($_SESSION['deliveryBoyID']))
    {
        header("location:homeCustomer.php");
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
                        <div class="col-md-9">
                            <h4 style="text-align: center;"class="mr-left">Order List</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="search" style="width: 300px; margin-left: auto; float: left;" placeholder="Search..." class="form-control search-input" data-table="product-list"/><br><br>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatable1" class="table table-bordered table-hover product-list">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Order Status</th>
                                <th>Bill</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select="select Order_ID,Grand_Total,Cart_ID from tbl_order where Delivery_Boy_ID='".$_SESSION['deliveryBoyID']."' order by Order_Status desc";
                                if($result= mysqli_query($con, $select))
                                {
                                    if(mysqli_num_rows($result)>0)
                                    {
                                        while ($row= mysqli_fetch_array($result))
                                        {
                                            $orderID=$row[0];
                                            $total=$row[1];
                                            $cartID=$row[2];
                                            
                                            $selectOrderStatus="select Order_Status from tbl_order where Order_ID=$orderID";
                                            $resultStatus= mysqli_query($con, $selectOrderStatus);                                            
                                            $rowStatus= mysqli_fetch_array($resultStatus);
                                            $status=$rowStatus[0];
                                            
                                            $selectCustomer="SELECT tbl_customer.Firstname,tbl_customer.Lastname,tbl_customer.Mobileno,tbl_customer.Email,tbl_customer.Address FROM tbl_cart INNER JOIN tbl_customer ON tbl_cart.Customer_ID=tbl_customer.Customer_Id where tbl_cart.Cart_ID=$cartID";
                                            $resultCustomer= mysqli_query($con, $selectCustomer);
                                            
                                            while($customer= mysqli_fetch_array($resultCustomer))
                                            {
                                                echo "<tr>";
                                                echo "<td>".$orderID."</td>";
                                                echo "<td>".$customer[0].' '.$customer[1]."</td>";
                                                echo "<td>".$customer[2]."</td>";
                                                echo "<td>".$customer[3]."</td>";
                                                echo "<td>".$customer[4]."</td>";
                                                ?>
                        <td><select name="status" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option value="<?php echo $status?>"><?php echo $status?></option>
                            <?php
                                $selectStatus="select * from tbl_order_status where not Status='$status'";
                                $resultStatus= mysqli_query($con, $selectStatus);
                                while ($rowStatus= mysqli_fetch_array($resultStatus))
                                { 
                                    echo '<option value="http://localhost/FreshBasket/updateDeliveryStatus.php?orderID='.$orderID.'&status='.$rowStatus[1].'">'.$rowStatus[1].'</option>';
                                }
                            ?></select></td>
                        <td style="text-align: center;" rowspan="<?php echo $numberOfProduct?>"><a href="generateBill.php?orderID=<?php echo $orderID?>" data-toggle="tooltip" data-placement="bottom" title="View Bill"><i style="font-size:20px;" class="fas fa-eye"></i></a></td>
                                                <?php
                                                echo "</tr>";
                                            }
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
</body>
</html>
<?php
    ob_flush();
?>