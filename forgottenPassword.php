<?php
require_once 'config.php';
include 'headerRegistration.php';

if(!isset($_SESSION['emailID']) && !isset($_SESSION['otp']))
{?><script>
        swal({
            title: "You can not change password",
            icon: "warning",
        }).then(function() {
            window.location = "index.php";
        });
    </script><?php
    
}?>

<script type="text/javascript">               
    $(document).ready(function(){
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

       $('#otp').keyup(function(){
            var otp=$('#otp').val();
            if (otp === "")
            {
                $('#otpErr').html('OTP is required');
                return false;
            }
            else
            {                        
                if(!/^[0-9]$/.test(document.registrationForm.otp.value)) 
                {
                    $('#otp').html('Enter only digit');
                    return false;
                }
                else if(otp.length!=6)
                {
                    $('#otpErr').html('OTP must be 6 digits');
                    return false;
                }
                else
                {
                    $('#otpErr').html('');
                }
            }
        });
    });
</script>
        
<?php
$error="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $email=$_SESSION['emailID'];       
    $password=$_POST['password'];
    $confirmPassword=$_POST['confirmPassword'];
    $otp=$_POST['otp'];

    if($password==''|| $confirmPassword=='' || $otp=='')
    {
        $error="Fill all the details";
    }
    else
    {
        if($_SESSION['otp']==$otp)
        {
            $update="update tbl_customer set Password='$password' where Email='$email'";
            if(mysqli_query($con,$update))
            {
                unset($_SESSION['emailID']);
                unset($_SESSION['otp']);
                ?><script>
                        swal({
                            title: "<?php echo $email?>",
                            text: "password is changed successfully",
                            icon: "success"
                        }).then(function() {
                            window.location = "login.php";
                        });
                    </script><?php
            }
            else
            {
                ?><script>
                        swal({
                            title: "<?php echo $email?>",
                            text: "password is not changed, try again",
                            icon: "warning"
                        });
                    </script><?php
            }
        }
        else
        {
            ?><script>
                swal({
                    title: "Entered incorrect OTP",
                    icon: "warning"
                }).then(function() {
                    window.location = "forgottenPassword.php";
                });
            </script><?php
        }
    }
}?>
<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col">
                                <h4> Forgotten Password</h4>
                        </div>
                    </div><hr>
                    <form action="#" method="post" name="registrationForm">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <b><label for="inputPassword" class="form-label">New Password<span style="color: red;"></span></label></b>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password">

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
                                    <b><label for="inputConfirmPassword" class="form-label">Confirm Password<span style="color: red;"></span></label></b>
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
                            <div class="col">
                                <div class="form-group">
                                    <b><label for="inputOtp" class="form-label">OTP<span style="color: red;"></span></label></b>
                                    <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP">

                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="otpErr"></span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input style="padding-right:20px; padding-left: 20px;" class="btn btn-success my-2 my-sm-0" type="submit" value="Submit">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span style="color: red;"><?php echo $error;?></span>
                            </div>
                        </div>                                
                    </form>
                </div>
            </div>    
        </div>
    </div>
</div>
<?php
    include 'footer.php';
?>