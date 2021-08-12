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
<div class="row">
    <div class="col-md-2 ml-5">
    </div>
    <div class="col-md-4 ml-5">
        <a href="newOrder.php">
            <div class="card" style="background-color: #00b3b3;">
                <div class="card-body" style="color: white;">
                    <?php
                        $selectTodayOrder="SELECT COUNT(*) FROM `tbl_order` WHERE CAST(Insert_Date AS DATE) = CAST( curdate() AS DATE)";
                        $resultTodayOrder= mysqli_query($con, $selectTodayOrder);
                        $rowTodayOrder= mysqli_fetch_array($resultTodayOrder);
                        $todayOrder=$rowTodayOrder[0];
                    ?>
                    <h3><b><?php echo $todayOrder?></b></h3>
                    <h6>New Orders</h6>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 ml-5">
        <div class="card" style="background-color: #00cc00;">
            <div class="card-body" style="color: white;">
                <?php
                    $selectLastSevenDayOrder="SELECT COUNT(*) FROM `tbl_order` WHERE Insert_Date > now() - INTERVAL 7 day";
                    $resultLastSevenDayOrder= mysqli_query($con, $selectLastSevenDayOrder);
                    $rowLastSevenDayOrder= mysqli_fetch_array($resultLastSevenDayOrder);
                    $lastSevenDayOrder=$rowLastSevenDayOrder[0];
                ?>
                <h3><b><?php echo $lastSevenDayOrder?></b></h3>
                <h6>Total Order of Last Seven Days</h6>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2 ml-5">
    </div>
    <div class="col-md-4 ml-5">
        <a href="viewUser.php">
            <div class="card" style="background-color: #e6e600;">
                <div class="card-body" style="color: black;">
                    <?php
                        $selectTotalUser="select count(*) from tbl_customer";
                        $resultTotalUser= mysqli_query($con, $selectTotalUser);
                        $rowTotalUser= mysqli_fetch_array($resultTotalUser);
                        $totalUser=$rowTotalUser[0];
                    ?>
                    <h3><b><?php echo $totalUser[0]?></b></h3>
                    <h6>Total Users</h6>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 ml-5">
        <div class="card" style="background-color: #ff1a1a;">
            <div class="card-body" style="color:white;">
                <?php
                    $selectTotalProduct="select count(*) from tbl_product_master";
                    $resultTotalProduct= mysqli_query($con, $selectTotalProduct);
                    $rowTotalProduct= mysqli_fetch_array($resultTotalProduct);
                    $totalProduct=$rowTotalProduct[0];
                ?>
                <h3><b><?php echo $totalProduct?></b></h3>
                <h6>Total Product</h6>
            </div>
        </div>
    </div>
</div>
<?php
include 'footerAdmin.php';
?>
