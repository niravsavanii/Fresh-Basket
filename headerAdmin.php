<?php
    ob_start();
    session_start();
    require_once 'config.php';
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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdminLTE 3 | Dashboard</title>
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
        <script src="bootstrap/js/jquery-3.5.1.slim.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/popper.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="sweetalert/sweetalert.min.js" type="text/javascript"></script>
        
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
       
       <script src="plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-light" style="background-color: white;box-shadow: 0px 0px 8px rgba(0,0,0,0.1);">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                           
                <a href="homeAdmin.php">Home</a>
                
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-widget="control-sidebar" data-slide="true" style="color: #3366ff; text-decoration: none;" role="button" onMouseOver="this.style.color='#0047b3'"
                           onMouseOut="this.style.color='#3366ff'"><i style="padding-right: 5px;color: #0047b3;" class="fas fa-user-alt"></i>Admin</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link" data-slide="true" style="color: #3366ff; text-decoration: none;" onMouseOver="this.style.color='#0047b3'"
    onMouseOut="this.style.color='#3366ff'"><i style="padding-right: 5px;color: #0047b3;" class="fas fa-sign-out-alt"></i>Logout</a>
                    </li>
                </ul>
            </nav>
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-0">
                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item has-treeview menu-open">
                                <a href="homeAdmin.php" class="nav-link active">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <p>
                                        Deshboard
                                    </p>
                                </a>
                            </li>
                            
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        Product
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="manageProduct.php" class="nav-link">
                                            <i class="nav-icon fas fa-tasks"></i>
                                            <p>Manage Product</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="recoverDeleteProduct.php" class="nav-link">
                                            <i class="nav-icon fas fa-radiation"></i>
                                            <p>Recover Product</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="viewAllProduct.php" class="nav-link">
                                            <i class="nav-icon fas fa-eye"></i>
                                            <p>View All Product</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-archive"></i>
                                    <p>
                                        categories
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="manageSubCategory.php" class="nav-link">
                                            <i class="nav-icon fas fa-tasks"></i>
                                            <p>Manage Sub-Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="recoverDeleteSubProduct.php" class="nav-link">
                                            <i class="nav-icon fas fa-radiation"></i>
                                            <p>Recover Sub-Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="viewAllSubProduct.php" class="nav-link">
                                            <i class="nav-icon fas fa-eye"></i>
                                            <p>view All Sub-Categories</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-store"></i>
                                    <p>
                                        Orders
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="pendingOrder.php" class="nav-link">
                                            <i class="nav-icon fas fa-stopwatch"></i>
                                            <p>Pending Orders</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="deliveredOrder.php" class="nav-link">
                                            <i class="nav-icon fas fa-clipboard-check"></i>
                                            <p>Delivered Orders</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="viewAllOrders.php" class="nav-link">
                                            <i class="nav-icon fas fa-eye"></i>
                                            <p>View All Orders</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-paste"></i>
                                    <p>
                                        View Report
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="orderReport.php" class="nav-link">
                                            <i class="nav-icon fas fa-retweet"></i>
                                            <p>Order Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="productReport.php?like=Quantity" class="nav-link">
                                            <i class="nav-icon fas fa-search"></i>
                                            <p>Selling Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="stockReport.php?category=Fruit" class="nav-link">
                                            <i class="nav-icon fas fa-boxes"></i>
                                            <p>Stock Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="manageDeliveryBoy.php" class="nav-link">
                                    <i class="nav-icon fas fa-truck"></i>
                                    <p>
                                        Delivery Boy
                                    </p>
                                </a>
                            </li>
                            
                            <li class="nav-item has-treeview">
                                <a href="viewUser.php" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        View Customer
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
        </div>