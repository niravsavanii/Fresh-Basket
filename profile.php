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
<?php
    $customerID=$_SESSION['customerID'];
    $firstName=$lastName=$mobileno=$emailID=$address=$city='';
    
    $select="select * from tbl_customer where Customer_Id=$customerID";
    if($result= mysqli_query($con, $select))
    {
        if(mysqli_num_rows($result)>0)
        {
            while ($row= mysqli_fetch_array($result))
            {
                $firstName=$row['Firstname'];
                $lastName=$row['Lastname'];
                $mobileno=$row['Mobileno'];
                $emailID=$row['Email'];
                $address=$row['Address'];
                $city=$row['City'];
            }
        }
    }    
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col">
                                <h4> My Profile</h4>
                        </div>
                    </div><hr>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputFirstName" class="form-label">First Name</label>
                                <span class="form-control"><?php echo $firstName;?></span>
                            </div>                                        
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputLastName" class="form-label">Last Name</label>
                                <span class="form-control"><?php echo $lastName;?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputMobileNo" class="form-label">Mobile Number</label>
                                <span class="form-control"><?php echo $mobileno;?></span>                                        
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmailID" class="form-label">Email ID</label>
                                <span class="form-control"><?php echo $emailID;?></span>                                            
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Address</label>
                                <span class="form-control"><?php echo $address?></span>                                            
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputCity" class="form-label">City</label>
                                <span class="form-control"><?php echo $city;?></span>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col">
                            <center>Are you want? 
                            </center>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <center> 
                                <a href="updateCustomerProfile.php">Update Profile</a>
                                or <a href="changePassword.php">Change Password</a>
                            </center>
                        </div>
                    </div>
                    </div>                        
                </div>
            </div>    
        </div>
    </div>
</div>
<?php
    include 'footer.php';
?>