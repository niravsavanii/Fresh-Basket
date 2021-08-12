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
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
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
                        <h4 style="text-align: center;"class="mr-left">Pending Orders</h4>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable1" class="table table-bordered table-hover product-list">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Quality</th>
                            <th scope="col">Order Address</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Status</th>
                            <th scope="col">Delivery Boy</th>
                            <th scope="col">Bill</th>
                        </tr>
                    </thead>
                        <?php
                            //Get cart ID
                            $selectCartID="SELECT tbl_order.*,tbl_delivery_boy.First_Name,tbl_delivery_boy.Last_Name FROM tbl_order INNER JOIN tbl_delivery_boy ON tbl_delivery_boy.Delivery_Boy_ID=tbl_order.Delivery_Boy_ID where tbl_order.Order_Status='Pending'";
                            $resultCartID= mysqli_query($con, $selectCartID);
                            
                            while ($cartID= mysqli_fetch_array($resultCartID))
                            {
                                //Get customer detail
                                $selectCustomerDetail="SELECT tbl_customer.Firstname,tbl_customer.Lastname,tbl_customer.Mobileno,tbl_customer.Email,tbl_customer.Address,tbl_customer.City FROM tbl_customer INNER JOIN tbl_cart ON tbl_cart.Customer_ID=tbl_customer.Customer_Id WHERE tbl_cart.Cart_ID='".$cartID[1]."'";
                                $resultCustomerDetail= mysqli_query($con, $selectCustomerDetail);
                                $customerDetail= mysqli_fetch_array($resultCustomerDetail);
                                $orderID=$cartID[0];
                                $name=$customerDetail[0].' '.$customerDetail[1];
                                $mobileno=$customerDetail[2];
                                $email=$customerDetail[3];
                                $address=$customerDetail[4];
                                $city=$customerDetail[5];

                                //Get product detail
                                $selectProduct="SELECT tbl_product_details.Image,tbl_product_master.Product_Name,tbl_product_details.Quality FROM tbl_product_details INNER JOIN tbl_cart_details on tbl_cart_details.Product_Detail_ID=tbl_product_details.Product_Detail_Id INNER JOIN tbl_product_master ON tbl_product_master.Product_Id=tbl_product_details.Product_Id WHERE tbl_cart_details.Cart_ID='".$cartID[1]."'";
                                $resultProduct= mysqli_query($con,$selectProduct);
                                $numberOfProduct= mysqli_num_rows($resultProduct);
                                $count=1;
                                echo "<tbody>";
                                while($product= mysqli_fetch_array($resultProduct))
                                {   
                                    if($count==1)
                                    {
                                        ?>
                                        <tr>
                                            <th style="text-align: center;" rowspan="<?php echo $numberOfProduct?>" scope="rowgroup"><?php echo $cartID[0]?></th>
                                            <td><img src="<?php echo $product[0]?>" height="70px" width="90px"></td>
                                            <td><?php echo $product[1]?></td>
                                            <td><?php echo $product[2]?></td>
                                            <td rowspan="<?php echo $numberOfProduct?>" scope="rowgroup"><?php echo $address?></td>
                                            <td rowspan="<?php echo $numberOfProduct?>" scope="rowgroup"><?php echo $cartID[5]?></td>
                                            <td style="text-align: center;" rowspan="<?php echo $numberOfProduct?>" scope="rowgroup"><?php echo $cartID[3]?></td>
                                            <td style="text-align: center;"  rowspan="<?php echo $numberOfProduct?>" scope="rowgroup">
                                                <select name="status" class="status" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                    <option value="<?php echo $row['Status'];?>" selected><?php echo $cartID[4];?></option>
                                                    <?php
                                                        $selectStatus="select * from tbl_order_status where not Status='".$cartID[4]."'";
                                                        if($resultStatus= mysqli_query($con, $selectStatus))
                                                        {
                                                            if(mysqli_num_rows($resultStatus)>0)
                                                            {
                                                                while ($rows= mysqli_fetch_array($resultStatus))
                                                                {                                      
                                                    echo '<option value="http://localhost/FreshBasket/updateDeliveryStatusByAdmin.php?orderID='.$orderID.'&status='.$rows['Status'].'">'.$rows['Status'].'</option>';
                                                    ?>

                                                                <?php }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td style="text-align: center;"  rowspan="<?php echo $numberOfProduct?>" scope="rowgroup">
                                                <select name="deliveryBoy" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                    <option value="0" selected><?php echo $cartID[7].' '.$cartID[8]?></option>
                                                    <?php
                                                        $selectDeliveryBoy="select Delivery_Boy_ID,First_Name,Last_Name from tbl_delivery_Boy where not Delivery_Boy_ID=4";
                                                        if($resultDeliveryBoy= mysqli_query($con, $selectDeliveryBoy))
                                                        {
                                                            if(mysqli_num_rows($resultDeliveryBoy)>0)
                                                            {
                                                                while ($rowDelivery= mysqli_fetch_array($resultDeliveryBoy))
                                                                {
                                                                    echo '<option value="http://localhost/FreshBasket/assignDeliveryBoy.php?orderID='.$cartID[0].'&deliveryBoyID='.$rowDelivery[0].'">'.$rowDelivery[0]."-".$rowDelivery[1]." ".$rowDelivery[2].'</option>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td style="text-align: center;" rowspan="<?php echo $numberOfProduct?>"><a href="generateBill.php?orderID=<?php echo $cartID[0]?>" data-toggle="tooltip" data-placement="bottom" title="View Bill"><i style="font-size:20px;" class="fas fa-eye"></i></a></td>
                                         </tr>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <tr>
                                            <td><img src="<?php echo $product[0]?>" height="70px" width="90px"></td>
                                            <td><?php echo $product[1]?></td>
                                            <td><?php echo $product[2]?></td>
                                         </tr>
                                        <?php
                                    }                                    
                                    $count+=1;
                                }
                                echo "</tbody>";
                            }
                        ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include 'footerAdmin.php';
?>