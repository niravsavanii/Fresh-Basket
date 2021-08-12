<?php
    ob_start();
    session_start();
    require_once 'config.php';
    if(isset($_SESSION['customerID']) || isset($_SESSION['adminID']) || isset($_SESSION['deliveryBoyID']))
    {
        header("location:index.php");
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="datatable/Css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
        <script src="sweetalert/sweetalert.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/jquery-3.5.1.slim.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/popper.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="datatable/Js/jquery.dataTables.min.js" type="text/javascript"></script>
        
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
                        
                        <li style="margin-left:10px;" class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="login.php"style="color: red;text-decoration: none;" onMouseOver="this.style.color='##990000'"
   onMouseOut="this.style.color='red'">
                                <i style="padding-right: 5px;" class="fas fa-user"></i>
                            Sign In</a>
                        </li>
                        
                      </ul>
                    </div>
                </div>
            </nav>
        </header><br><br>
