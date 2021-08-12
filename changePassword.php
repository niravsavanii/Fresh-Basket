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
    $error='';
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $oldPassword=$_POST['oldPassword'];
        $password=$_POST['password'];
        $confirmPassword=$_POST['confirmPassword'];
        
        if($oldPassword=='' || $password==''||$confirmPassword=='')
        {
            $error="Fill all the details";
        }
        else
        {
            $changePassword="update tbl_customer set Password='$password' where Customer_Id='".$_SESSION['customerID']."' and Password='$oldPassword'";
            if ($result=mysqli_query($con, $changePassword))
            {
            ?>
            <script>
                swal({
                    title: "Hello! <?php echo $_SESSION['firstName']?>",
                    text: "Your password is changed\n You have to login with new password",
                    icon: "success",
                }).then(function() {
                    window.location = "logout.php";
                });
            </script><?php
                
            }
        }
    }
?>
<script type="text/javascript">               
    $(document).ready(function(){
        $('#oldPassword').keyup(function(){
            var oldPswd=$('#oldPassword').val();
            if (oldPswd === "")
            {
                $('#oldPasswordErr').html('Old password is required');
                return false;
            }
            else
            {                        
                if(!/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,20}$/.test(document.registrationForm.oldPassword.value)) 
                {
                    $('#oldPasswordErr').html('Password between 8 to 20 characters and contains atleast one digit, upercase, lowercase and special character');
                    return false;
                }
                else
                {
                    $('#oldPasswordErr').html('');
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

        $('#confirmPassword').keyup(function(){
            var password=$('#password').val();
            var confirmPassword=$('#confirmPassword').val();

            if(confirmPassword!=password)
            {
                $('#confirmPasswordErr').html('Password is not match*');
                return false;
            }
            else
            {
                $('#confirmPasswordErr').html('');
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
                        <h4 style="text-align: center;">Change Password Here</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post" name="registrationForm">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <b><label for="inputOldPassword" class="form-label">Old Password<span style="color: red;"> *</span></label></b>
                                <input type="password" name="oldPassword" id="oldPassword" class="form-control" placeholder="Enter Old Password">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="oldPasswordErr"></span>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <b><label for="inputPassword" class="form-label">New Password<span style="color: red;"> *</span></label></b>
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
                        <div class="col">
                            <div class="form-group">
                                <b><label for="inputConfirmPassword" class="form-label">Confirm New Password<span style="color: red;"> *</span></label></b>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Re-type Password">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="confirmPasswordErr"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <input style="padding-right:20px; padding-left: 20px;" class="btn btn-success my-2 my-sm-0" type="submit" value="CHANGE">
                            </div>
                        </div>

                        <div class="col-9">
                            <span style="color: red;"><?php echo $error;?></span>
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