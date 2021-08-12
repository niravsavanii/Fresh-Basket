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

$errMobileno=$errEmailID='';
$error='';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $temp=0;

    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $mobileno=$_POST['mobileno'];
    $emailID=$_POST['emailID'];
    $address=$_POST['address'];
    $city=$_POST['city'];

    if($firstName==''||$lastName==''||$mobileno==''||$emailID==''||$address==''||$city=='')
    {
        $error="Fill all the details";
    }
    else
    {
        $select="select Mobileno,Email from tbl_customer";
        if($result= mysqli_query($con, $select))
        {
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    if($mobileno==$row['Mobileno'])
                    {
                        $errMobileno="";
                    }
                    else if ($emailID==$row['Email'])
                    {
                        $errEmailID="";
                    }
                    else 
                    {
                        $temp=1;                        
                    }
                }
            }
        }

        if($temp==1)
        {
            $update="update tbl_customer set Firstname='$firstName', Lastname='$lastName', Mobileno='$mobileno', Email='$emailID', Address='$address', City='$city' where Customer_ID=$customerID";
            if($updateResult= mysqli_query($con, $update))
            {
                ?><script>
                    swal({
                        title: "Update Successfully!",
                        text:"First you have to login",
                        icon: "success"
                    }).then(function() {
                        window.location = "logout.php";
                    });
                </script><?php
            }
            else
            {
                ?><script>
                    swal({
                        title: "Updation Fail!",
                        text: "Again fill up details",
                        icon: "error",
                    }).then(function() {
                        window.location = "updateCustomerProfile.php";
                    });
                </script><?php
            }
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
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col">
                                <h4> Update Profile Here..</h4>
                        </div>
                    </div><hr>

                    <form action="#" method="post" name="registrationForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputFirstName" class="form-label">First Name</label>
                                    <input type="text" name="firstName" id="firstName" value="<?php echo $firstName;?>" class="form-control" placeholder="Enter First Name" autocomplete="off">

                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="firstnameErr"></span>
                                        </div>
                                    </div>

                                </div>                                        
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputLastName" class="form-label">Last Name</label>
                                    <input type="text" name="lastName" id="lastName" value="<?php echo $lastName;?>" class="form-control" placeholder="Enter Last Name" autocomplete="off">

                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="lastnameErr"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputMobileNo" class="form-label">Mobile Number</label>
                                    <input type="number" name="mobileno" id="mobileno" value="<?php echo $mobileno;?>" class="form-control" placeholder="Enter Mobile Number" autocomplete="off">

                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="mobilenoErr"></span>
                                            <span style="color: red;"><?php echo $errMobileno?></span>
                                        </div>
                                    </div>                                        
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputEmailID" class="form-label">Email ID</label>
                                    <input type="email" name="emailID" id="emailID" value="<?php echo $emailID;?>" class="form-control" placeholder="Enter Email ID" autocomplete="off">

                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="emailIDErr"></span>
                                            <span style="color: red;"><?php echo $errEmailID?></span>
                                        </div>
                                    </div>                                            
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputAddress" class="form-label">Address</label>
                                    <textarea style="resize:none;" name="address" rows="3" id="address" class="form-control" placeholder="Ex: 101, Subhashnagar-2, Katargam"><?php echo $address;?></textarea>

                                    <div class="row">
                                        <div class="col">
                                            <span style="color: red;" id="addressErr"></span>
                                        </div>
                                    </div>                                            
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputCity" class="form-label">City</label>
                                    <select id="inputCity" class="form-control" name="city">                                                
                                        <option value="<?php echo $city;?>" selected><?php echo $city;?></option>
                                        <?php
                                            $result= mysqli_query($con, "select * from tbl_city where CityName not in ('$city')");
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
                                    <input style="padding-right:20px; padding-left: 20px;" class="btn btn-success my-2 my-sm-0" type="submit" value="Update">
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