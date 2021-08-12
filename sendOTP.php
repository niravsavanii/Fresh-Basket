<?php
require_once 'config.php';
include 'headerRegistration.php';

require './PHPMailer.php';
require './Exception.php';
require './SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_SESSION['emailID']) && isset($_SESSION['otp']))
{
    header("location:login.php");
}

$otp=0;
$emailID = $_GET['id'];

if($emailID=="empty")
{
    ?><script>
        swal({
            title: "Email ID can not be empty",
            icon: "warning"
        }).then(function () {
            window.location = "login.php";
        });
    </script><?php
}
else
{
    $select = "select Email from tbl_customer where Email='$emailID'";
    if ($result = mysqli_query($con, $select))
    {
        if (mysqli_num_rows($result) > 0)
        {
            $otp=rand(999999,111111);
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = "true";
            $mail->SMTPSecure = "tls";
            $mail->Port = "587";
            $mail->Username = "18bmiit038@gmail.com";
            $mail->Password = "nirav72038";
            $mail->Subject = "Fresh Basket";
            $mail->setFrom("18bmiit038@gmail.com");
            $mail->Body = $otp;
            $mail->addAddress($emailID);
        
            if (!$mail->send())
            {
                ?><script>
                swal({
                    title:"<?php echo $emailID;?>",
                    text: "due to poor connection OTP is not sent",
                    icon: "warning",
                }).then(function () {
                        window.location = "login.php";
                });
                </script><?php
            }
            else
            {
                $_SESSION['emailID']=$emailID;
                $_SESSION['otp']=$otp;
                ?><script>
                    swal({
                        title: "<?php echo $_SESSION['emailID']?>",
                        text:'OTP has sent',
                        icon: "success"
                    }).then(function () {
                        window.location = "forgottenPassword.php";
                });
            </script><?php
            }
        }
        else
        {
            ?><script>
                swal({
                    title: "<?php echo $emailID;?>",
                    text:'this email ID is not registered',
                    icon: "warning"
                }).then(function () {
                    window.location = "login.php";
                });
            </script><?php
        }
    }    
}
include 'footer.php';
?>