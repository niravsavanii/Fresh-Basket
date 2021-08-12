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
                    <div class="col-3">
                        <input type="search" style="background-color: #f2f2f2;width: 220px; margin-left: auto; float: left;" placeholder="Search..." class="form-control search-input" data-table="product-list"/><br><br>
                    </div>
                    <div class="col-6">
                        <h4 style="text-align: center;"class="mr-left">User List</h4>
                    </div>  
                    <div class="col-md-3"></div>                    
                </div>
            </div>

            <div class="card-body">
                <table id="datatable1" class="table table-bordered table-hover product-list">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select="SELECT * FROM tbl_customer";
                            if($result= mysqli_query($con, $select))
                            {
                                if(mysqli_num_rows($result)>0)
                                {
                                    while ($row= mysqli_fetch_array($result))
                                    {
                                        echo "<tr>";
                                        echo '<input type="hidden" class="customerID" value="'.$row[0].'">';
                                        echo "<td>".$row[1].' '.$row[2]."</td>";
                                        echo "<td>".$row[4]."</td>";
                                        echo "<td>".$row[3]."</td>";
                                        echo "<td>".$row[6]."</td>";
                                        echo "<td>".$row[7]."</td>";
                                        echo "<td>".$row[8]."</td>";
                                        ?>
                    <td style="text-align: center;"><a href="updateCustomerStatus.php?customerID=<?php echo $row[0];?>&status=<?php echo $row[8];?>" data-toggle="tooltip" data-placement="bottom" title="Change Status" type="button"><i style="font-size: 20px;" class="fas fa-sync"></i></a></td>
                                        <?php
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