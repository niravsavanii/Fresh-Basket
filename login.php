<?php
    require_once 'config.php';
    include 'headerLogin.php';  

    if(isset($_SESSION['adminID']))
    {?>
        <script>
            swal({
                title: "Hello! <?php echo $_SESSION['firstName']?>",
                text: "You are already logged In",
                icon: "success",
            }).then(function() {
                window.location = "homeAdmin.php";
            });
        </script><?php
    }
    
    if(isset($_SESSION['customerID']))
    {?>
        <script>
            swal({
                title: "Hello! <?php echo $_SESSION['firstName']?>",
                text: "You are already logged In",
                icon: "success",
            }).then(function() {
                window.location = "homeCustomer.php";
            });
        </script><?php   
    }
    if(isset($_SESSION['deliveryBoyID']))
    {?>
        <script>
            swal({
                title: "Hello! <?php echo $_SESSION['firstName']?>",
                text: "You are already logged In",
                icon: "success",
            }).then(function() {
                window.location = "homeDeliveryBoy.php";
            });
        </script><?php   
    }
    if(isset($_SESSION['otp']) && isset($_SESSION['emailID']))
    {
        unset($_SESSION['emailID']);
        unset($_SESSION['otp']);
        ?>
        <script>
            swal({
                title: "Password is not changed",
                icon: "error",
            }).then(function(){
                window.location = "login.php";
            });
        </script><?php   
    }
    
    $error='';
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $emailID=$_POST['emailID'];
        $password=$_POST['password'];
        
        if($emailID==''||$password=='')
        {
            $error="Fill username and password";
        }
        else 
        {
            if($emailID=="admin@gmail.com" && $password=="Admin@123")
            {
                $_SESSION['status']="Loged In";
                $_SESSION['adminID']=1;
                $_SESSION['firstName']="Admin";
                
                ?><script>
                    swal({
                        title: "Hello! <?php echo $_SESSION['firstName']?>",
                        text: "login Successfully",
                        icon: "success",
                    }).then(function() {
                        window.location = "homeAdmin.php";
                    });
                </script><?php
            }
            else
            {
                $select="select Customer_Id,Firstname,Email from tbl_customer where Email='$emailID' and Status='Activate' and Password='$password'";
                if($result= mysqli_query($con, $select))
                {
                    if(mysqli_num_rows($result) > 0)
                    {
                        $row = mysqli_fetch_array($result);

                        $_SESSION['status']="Loged In";
                        $_SESSION['customerID']=$row['Customer_Id'];
                        $_SESSION['firstName']=$row['Firstname'];
                        $_SESSION['emailID']=$row['Email'];
                        

                        ?><script>
                            swal({
                                title: "Hello! <?php echo $_SESSION['firstName']?>",
                                text: "login Successfully",
                                icon: "success",
                            }).then(function() {
                                window.location = "homeCustomer.php";
                            });
                        </script><?php
                    }
                    else
                    {
                        $selectDeliveryBoyLogin="select Delivery_Boy_ID,First_Name,Email_ID from tbl_delivery_boy where Email_ID='$emailID' and Status='Activate' and Password='$password'";
                        if($resultDeliveryBoy= mysqli_query($con, $selectDeliveryBoyLogin))
                        {
                            if(mysqli_num_rows($resultDeliveryBoy) > 0)
                            {
                                $rowDeliveyBoy = mysqli_fetch_array($resultDeliveryBoy);

                                $_SESSION['status']="Loged In";
                                $_SESSION['deliveryBoyID']=$rowDeliveyBoy['Delivery_Boy_ID'];
                                $_SESSION['firstName']=$rowDeliveyBoy['First_Name'];
                                ?><script>
                                    swal({
                                        title: "Hello! <?php echo $_SESSION['firstName']?>",
                                        text: "login Successfully",
                                        icon: "success",
                                    }).then(function() {
                                        window.location = "homeCustomer.php";
                                    });
                                </script><?php
                            }
                            else
                            {
                                ?><script>
                                    swal({
                                        title: "Login Fail",
                                        text: "Enter valid username and password",
                                        icon: "error",
                                    });
                                </script><?php
                            }
                    }                    
                    }
                }
            }
        }
    }
?>        
<script type="text/javascript">               
    $(document).ready(function(){

       $('#emailID').keyup(function(){

            var emailID=$('#emailID').val();
            if (emailID === "")
            {
                $('#emailIDErr').html('Email ID is required');
                return false;
            }
            else
            {
                if(emailID.length<=6 || emailID>30)
                {
                    $('#emailIDErr').html('Email ID between 7 to 30 characters');
                    return false;
                }
                else if(!/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(document.registrationForm.emailID.value)) 
                {
                    $('#emailIDErr').html('Enter valid email ID');
                    return false;
                }
                else
                {
                    var link = 'sendOTP.php?id=' + emailID;
                    $("#link").attr("href", link);
                    $('#emailIDErr').html('');
                    return false;
                }
            }
        });

        $('#password').keyup(function(){
            var pswd=$('#password').val();
            if (pswd === "")
            {
                $('#passwordErr').html('Password is required');
                return false;
            }
            else
            {                        
                if(!/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,20}$/.test(document.registrationForm.password.value)) 
                {
                    $('#passwordErr').html('Password between 8 to 20 characters and contains atleast one digit, upercase, lowercase and special character');
                    return false;
                }
                else
                {
                    $('#passwordErr').html('');
                    return false;
                }
            }
        });
    });            
</script>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 style="text-align: center;">Login Here</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post" name="registrationForm">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <b><label for="inputEmailID" class="form-label">Username<span style="color: red;"> *</span></label></b>
                                <input type="text" name="emailID" id="emailID" class="form-control" placeholder="Enter Email ID">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="emailIDErr"></span>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <b><label for="inputPassword" class="form-label">Password<span style="color: red;"> *</span></label></b>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="passwordErr"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <input style="padding-right:20px; padding-left: 20px;" class="btn btn-success my-2 my-sm-0" type="submit" value="LOGIN">
                            </div>
                        </div>

                        <div class="col-9">
                            <span style="color: red;"><?php echo $error;?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <center>
                                <a id="link" href="sendOTP.php?id=empty">Forgotten Password?</a>
                            </center>
                        </div>
                    </div><hr>

                    <div class="row">
                        <div class="col">
                            <center>Not a member? <a href="registration.php">Sign Up</a></center>
                        </div>
                    </div>
                </form>
            </div>
        </div>    
    </div>
</div>
<?php
    include 'footer.php';
?>