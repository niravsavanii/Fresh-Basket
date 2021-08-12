<?php
    ob_start();
    session_start();
    require_once 'config.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
        <script src="bootstrap/js/jquery-3.5.1.slim.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/popper.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="sweetalert/sweetalert.min.js" type="text/javascript"></script>
        <?php
            if(isset($_SESSION['status']) && $_SESSION['status']!='')
            {
                ?><script>
                    swal({
                            title: "Hello! <?php echo $_SESSION['firstName']?>",
                            text: "You are now logged In",
                            icon: "success",
                        });
                </script><?php
                unset($_SESSION['status']);
            }
        ?>
    </head>
    <body>
        <header style="margin-top: 28px;">
            <nav style="background-color: white;box-shadow: 0px 0px 8px rgba(0,0,0,0.1);" class="navbar navbar-expand-lg fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="Image/topLogo.png" width="150px" height="50px" class="d-inline-block align-top" alt="">
                    </a>
                
                    <div class="collapse navbar-collapse" id="basicExampleNav">
                      <ul class="navbar-nav ml-auto">                        
                        <?php
                            if(!isset($_SESSION['deliveryBoyID']))
                            {
                        ?>
                        <li style="margin-left:10px;" class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="login.php"style="color: red;text-decoration: none;" onMouseOver="this.style.color='##990000'"
   onMouseOut="this.style.color='red'">
                                <i style="padding-right: 5px;" class="fas fa-user"></i>
                            Sign In</a>
                            </li>
                        <?php } 
                            else 
                            { ?>    
                            <li style="margin-left:10px;" class="nav-item pl-2 mb-2 mb-md-0">
                                <a href="profile.php" data-toggle="tooltip" data-placement="bottom" title="Profile" style="color: green;text-decoration: none;" onMouseOver="this.style.color='#004d00'"
       onMouseOut="this.style.color='green'">
                                    <?php echo $_SESSION['firstName']?><i style="font-size: 20px;padding-left: 5px;" class="fas fa-user"></i></a>
                            </li>
                        <li style="margin-left:10px;" class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Logout" style="color: green;text-decoration: none;" onMouseOver="this.style.color='#004d00'"
   onMouseOut="this.style.color='green'"><i style="font-size: 20px;padding-right: 5px;" class="fas fa-sign-out-alt"></i></a>
                        </li>
                        
                        <?php
                        }
                        ?>
                      </ul>
                    </div>
                </div>
            </nav>
        </header><br><br>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
              });
        </script>