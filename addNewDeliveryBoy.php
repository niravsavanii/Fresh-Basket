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
    $errMobileno=$errEmailID='';
    $error='';
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $tempMobileno=TRUE;
        $tempEmailID=TRUE;
        $existMobileno='';
        $existEmailID='';
        
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $mobileno=$_POST['mobileno'];
        $emailID=$_POST['emailID'];
        $password=$_POST['password'];
        $confirmPassword=$_POST['confirmPassword'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        
        if($firstName==''||$lastName==''||$mobileno==''||$emailID==''||$password==''||$confirmPassword==''||$address==''||$city=='')
        {
            $error="Fill all the details";
        }
        else
        {
            $select="select Mobileno,Email from tbl_delivery_boy";
            if($result= mysqli_query($con, $select))
            {
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_array($result))
                    {
                        if($mobileno==$row['Mobileno'])
                        {
                            $tempMobileno=FALSE;
                            $existMobileno="Mobile no ".$mobileno;
                        }
                        if ($emailID==$row['Email'])
                        {
                            $tempEmailID=FALSE;
                            $existEmailID="Email ID ".$emailID;
                        }
                    }
                }
            }

            if($tempMobileno && $tempEmailID)
            {
                $insert="INSERT INTO tbl_delivery_boy (Delivery_Boy_ID, First_Name, Last_Name, Mobile_No, Email_ID, Password, Address, City,Status) VALUES ('NULL', '$firstName', '$lastName', '$mobileno', '$emailID', '$password', '$address', '$city','Activate')";
                if($insertResult= mysqli_query($con, $insert))
                {
                    ?><script>
                        swal({
                            title: "Delivery Boy Added Successfully!",
                            icon: "success"
                        }).then(function() {
                            window.location = "manageDeliveryBoy.php";
                        });
                    </script><?php
                }
                else
                {
                    ?><script>
                        swal({
                            title: "Delivery Boy is not added!",
                            text: "Again fill up details",
                            icon: "error",
                        });
                    </script><?php
                }
            }
            else
            {
                ?><script>
                    swal({
                        title: "Already exist!",
                        text: '<?php echo $existMobileno." ".$existEmailID?>',
                        icon: "error",
                    });
                </script><?php
            }
        }
        
    }
?>
<script type="text/javascript">               
    $(document).ready(function(){

        $('#firstName').keyup(function(){
            var firstName=$('#firstName').val();
            if (firstName === "")
            {
                $('#firstnameErr').html('First name is required');
                return false;
            }
            else
            {
                if(!/^[a-zA-Z]*$/g.test(document.registrationForm.firstName.value)) 
                {
                    $('#firstnameErr').html('Enter only alphabets');
                    return false;
                }
                else if(firstName.length<2)
                {
                    $('#firstnameErr').html('Enter atleast 2 alphabets');
                    return false;
                }
                else if(firstName.length>20)
                {
                    $('#firstnameErr').html('Enter within 20 alphabets');
                    return false;
                }
                else
                {
                    $('#firstnameErr').html('');
                    return false;
                }
            }
        });

        $('#lastName').keyup(function(){
            var lastName=$('#lastName').val();
            if (lastName === "")
            {
                $('#lastnameErr').html('Last name is required');
                return false;
            }
            else
            {
                if(!/^[a-zA-Z]*$/g.test(document.registrationForm.lastName.value)) 
                {
                    $('#lastnameErr').html('Enter only alphabets');
                    return false;
                }
                else if(lastName.length<2)
                {
                    $('#lastnameErr').html('Enter atleast 2 alphabets');
                    return false;
                }
                else if(lastName.length>20)
                {
                    $('#lastnameErr').html('Enter within 20 alphabets');
                    return false;
                }
                else
                {
                    $('#lastnameErr').html('');
                    return false;
                }
            }
        });

       $('#mobileno').keyup(function(){
            var mobileno=$('#mobileno').val();
            if (mobileno === "")
            {
                $('#mobilenoErr').html('Mobile no is required');
                return false;
            }
            else
            {
                if(mobileno.length!=10)
                {
                    $('#mobilenoErr').html('Enter 10 digit only');
                    return false;
                }
                else if(!/^[6-9]\d{9}$/g.test(document.registrationForm.mobileno.value)) 
                {
                    $('#mobilenoErr').html('Enter valid mobile no');
                    return false;
                }
                else
                {
                    $('#mobilenoErr').html('');
                    return false;
                }
            }
        });

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

       $('#address').keyup(function(){
            var address=$('#address').val();
            if (address === "")
            {
                $('#addressErr').html('Address is required');
                return false;
            }
            else
            {    if(!/^[\w\s.-/]+\d+,\s*[\w\s.-]+\d+,\s*[\w\s.-]+$/.test(document.registrationForm.address.value)) 
                {
                    $('#addressErr').html('Format: House No, Street name - Street no, Area');
                    return false;
                }               
                else if(address.length<10)
                {
                    $('#addressErr').html('Enter atleast 10 alphabets');
                    return false;
                }
                else if(address.length>100)
                {
                    $('#addressErr').html('Enter within 100 alphabets');
                    return false;
                }
                else
                {
                    $('#addressErr').html('');
                    return false;
                }
            }
        });
    });            
</script>
<div class="row">
    <div class="col-md-2 ml-4">
    </div>
    <div class="col-md-9 ml-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 style="text-align: center;">Add New Delivery Boy Here</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="#" method="post" name="registrationForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputFirstName" class="form-label">First Name<span style="color: red;"> *</span></label>
                                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter First Name" autocomplete="off">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="firstnameErr"></span>
                                    </div>
                                </div>
                            </div>                                        
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputLastName" class="form-label">Last Name<span style="color: red;"> *</span></label>
                                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Enter Last Name" autocomplete="off">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="lastnameErr"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputMobileNo" class="form-label">Mobile Number<span style="color: red;"> *</span></label>
                                <input type="number" name="mobileno" id="mobileno" class="form-control" placeholder="Enter Mobile Number" autocomplete="off">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="mobilenoErr"></span>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputEmailID" class="form-label">Email ID<span style="color: red;"> *</span></label>
                                <input type="email" name="emailID" id="emailID" class="form-control" placeholder="Enter Email ID" autocomplete="off">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="emailIDErr"></span>
                                    </div>
                                </div>                                            
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputPassword" class="form-label">Password<span style="color: red;"> *</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="passwordErr"></span>
                                    </div>
                                </div>                                        
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputConfirmPassword" class="form-label">Confirm Password<span style="color: red;"> *</span></label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Address<span style="color: red;"> *</span></label>
                                <textarea style="resize:none;" name="address" rows="3" id="address" class="form-control" placeholder="Ex: 101, Subhashnagar-2, Katargam"></textarea>

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="addressErr"></span>
                                    </div>
                                </div>                                            
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputCity" class="form-label">City<span style="color: red;"> *</span></label>
                                <select id="inputCity" class="form-control" name="city">                                                
                                    <option value="" selected>-- Select City --</option>
                                    <?php
                                        $result= mysqli_query($con, "select * from tbl_city");
                                        while ($row= mysqli_fetch_array($result))
                                        {
                                    ?>
                                    <option value="<?php echo $row["CityName"]?>"><?php echo $row["CityName"]?></option>
                                    <?php
                                        }
                                    ?>
                                </select>   

                                <div class="row">
                                    <div class="col">
                                        <span style="color: red;" id="cityErr"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input style="padding-right:20px; padding-left: 20px;" class="btn btn-primary my-sm-0" type="submit" value="ADD">
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
?>