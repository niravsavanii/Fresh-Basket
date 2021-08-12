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
                    <a class="navbar-brand elevation-1" href="index.php">
                        <img src="Image/topLogo.png" width="150px" height="50px" data-toggle="tooltip" data-placement="bottom" title="Home" class="d-inline-block align-top" alt="">
                    </a>
                
                    <div style="text-align:center">
                        <ul class="navbar-nav mr-left">
                            <li style="margin-left:20px;"  class="nav-item dropdown">
                                <a style="color: green;" class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="true">Categories
                                <i class="united kingdom flag m-0"></i>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                  <a class="dropdown-item" href="fruit.php">Fruit</a>
                                  <a class="dropdown-item" href="vegetables.php">Vegetables</a>
                                  <a class="dropdown-item" href="seasoningAndHerb.php">Herbs And Seasoning</a>
                              </div>
                           </li>
                        </ul>
                    </div>
                
                    <div class="collapse navbar-collapse" id="basicExampleNav">
                      <ul class="navbar-nav ml-auto">                        
                        <?php
                            if(!isset($_SESSION['customerID']) && !isset($_SESSION['adminID']))
                            {
                        ?>
                        <li style="margin-left:10px;" class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="login.php"style="color: red;text-decoration: none;" onMouseOver="this.style.color='#990000'"
   onMouseOut="this.style.color='red'">
                                <i style="padding-right: 5px;" class="fas fa-user"></i>
                            Sign In</a>
                            </li>
                        <?php } 
                            else 
                            { ?>    
                            <li class="nav-item pl-2 mb-2 mb-md-0">
                                <a href="cart.php" data-toggle="tooltip" data-placement="bottom" title="Cart" style="color: red;text-decoration: none;"  onMouseOver="this.style.color='#990000'"
   onMouseOut="this.style.color='red'" >
                                <i style="font-size: 19px;padding-right: 10px;" class="fas fa-shopping-cart pl-0"></i>
                                <?php
                                $count=0;
                                $selectCartId="select * from tbl_cart where Customer_ID='".$_SESSION['customerID']."' and Status='Active'";
                                $resultCartId= mysqli_query($con, $selectCartId);
                                if(mysqli_num_rows($resultCartId)==1)
                                {
                                    $rowCartID = mysqli_fetch_array($resultCartId);
                                    $cartID=$rowCartID['Cart_ID'];

                                    $selectCount="SELECT * FROM `tbl_cart_details` WHERE Cart_ID=$cartID";
                                    $resultSelectCount= mysqli_query($con, $selectCount);
                                    $count = mysqli_num_rows($resultSelectCount);
                                }
                                if($count>0)
                                {
                                    echo '<span style="text-align: center;padding: 0.2rem 0.6rem 0.2rem 0.6rem;border-radius: 3rem;" class="text-dark bg-light">'.$count.'</span>';
                                }
                                ?>
                                
                            </a>
                        </li>
                        <li class="nav-item pl-2 mb-2 mb-md-0" style="border-right: 2px solid #999999;">
                            <a href="myOrder.php" data-toggle="tooltip" data-placement="bottom" title="My Order" style="color: red;text-decoration: none;"  onMouseOver="this.style.color='#990000'"
   onMouseOut="this.style.color='red'" ><i style="font-size: 19px;padding-right: 15px;" class="fas fa-shopping-bag"></i></a>
                        </li>
                    </ul>
                                                
                    <ul class="navbar-nav">
                        <li class="nav-item pl-2 mb-2 mb-md-0">
                                <a href="profile.php" data-toggle="tooltip" data-placement="bottom" title="Profile" style="color: green;text-decoration: none;" onMouseOver="this.style.color='#004d00'"
       onMouseOut="this.style.color='green'"><i style="font-size: 19px;padding-right: 10px;" class="fas fa-user"></i><?php echo $_SESSION['firstName']?></a>
                        </li>
                        <li class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Logout" style="color: green;text-decoration: none;" onMouseOver="this.style.color='#004d00'"
   onMouseOut="this.style.color='green'"><i style="font-size: 19px;padding-left: 10px;" class="fas fa-sign-out-alt"></i></a>
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