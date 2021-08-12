<?php
    include 'config.php';
    require 'FPDF-master/fpdf.php';
    ob_start();
    session_start();
    
    if (isset($_GET['orderID']))
    {
        $orderID=$_GET['orderID'];
    
        $selectOrderDetail="select * from tbl_order where Order_ID=$orderID";
        $resultOrderDetail= mysqli_query($con, $selectOrderDetail);
        $orderDetail= mysqli_fetch_array($resultOrderDetail);
        
        $cartID=$orderDetail[1];
        $grandTotal=$orderDetail[2];
        $paymentStatus=$orderDetail[3];
        $orderDate=$orderDetail[5];

        $selectCustomerDetail="SELECT tbl_customer.Firstname,tbl_customer.Lastname,tbl_customer.Mobileno,tbl_customer.Email,tbl_customer.Address,tbl_customer.City FROM tbl_customer INNER JOIN tbl_cart ON tbl_cart.Customer_ID=tbl_customer.Customer_Id WHERE tbl_cart.Cart_ID=$cartID";
        $resultCustomerDetail= mysqli_query($con, $selectCustomerDetail);
        $customerDetail= mysqli_fetch_array($resultCustomerDetail);
        
        $name=$customerDetail[0].' '.$customerDetail[1];
        $mobileno=$customerDetail[2];
        $email=$customerDetail[3];
        $address=$customerDetail[4].','.$customerDetail[5];
        
        $pdf=new FPDF();
        $pdf->AddPage();

        //set font to arial, bold, 14pt
        $pdf->SetFont('Arial','i',14);
        
        //set image
        $pdf->Image('Image/topLogo.png',11,10,20);

        $pdf->Cell(120,10,'',0,0);
        $pdf->Cell(50,10,'INVOICE',0,1);
        
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(120,5,'Phone[+7203804872]',0,0);
        $pdf->Cell(24,5,'Order Date: ',0,0);
        $pdf->Cell(20,5,"{$orderDate}",0,1);
        
        $pdf->Cell(120,5,'visit us: www.freshbasket.com',0,0);
        $pdf->Cell(22,5,'Invoice ID: ',0,0);
        $pdf->Cell(20,5,"{$orderID}",0,1);
        $pdf->Cell(120,5,'',0,1);
        
        $pdf->SetFont('Arial','u',13);
        $pdf->Cell(120,7,'Bill To',0,1);
        
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(6,5,'',0,0);
        $pdf->Cell(6,5,'-',0,0);
        $pdf->Cell(90,5,"{$name}",0,1);
        
        $pdf->Cell(6,5,'',0,0);
        $pdf->Cell(6,5,'-',0,0);
        $pdf->Cell(90,5,"{$address}",0,1);
        
        $pdf->Cell(6,5,'',0,0);
        $pdf->Cell(6,5,'-',0,0);
        $pdf->Cell(90,5,"{$email}",0,1);
        
        $pdf->Cell(6,5,'',0,0);
        $pdf->Cell(6,5,'-',0,0);
        $pdf->Cell(90,5,"{$mobileno}",0,1);
            
        $pdf->Cell(120,5,'',0,1);
        
        $pdf->SetFont('Arial','u',13);
        $pdf->Cell(120,7,'Product Details',0,1);
        $pdf->Cell(120,2,'',0,1);        
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(10,5,'#',1,0);
        $pdf->Cell(55,5,'Product Name',1,0);
        $pdf->Cell(33,5,'Quality',1,0);
        $pdf->Cell(25,5,'Quantity',1,0);
        $pdf->Cell(30,5,'Price',1,0);
        $pdf->Cell(35,5,'Total Price',1,1);
        $pdf->SetFont('Arial','',12);
        
        $deliveryCharge=0;
        $count=1;
        
        $selectProductDetail="SELECT tbl_product_master.Product_Name,tbl_product_details.Quality,tbl_cart_details.Quantity,tbl_product_details.Price,tbl_cart_details.Total_Price FROM tbl_product_details INNER JOIN tbl_cart_details on tbl_cart_details.Product_Detail_ID=tbl_product_details.Product_Detail_Id INNER JOIN tbl_product_master ON tbl_product_master.Product_Id=tbl_product_details.Product_Id WHERE tbl_cart_details.Cart_ID=$cartID";
        $resultProductDetail= mysqli_query($con, $selectProductDetail);
        while ($productDetail= mysqli_fetch_array($resultProductDetail))
        {
            $productName=$productDetail[0];
            $quality=$productDetail[1];
            $quantity=$productDetail[2];
            $price=$productDetail[3];
            $totalPrice=$productDetail[4];
        
            $pdf->Cell(10,5,"{$count}",1,0);
            $pdf->Cell(55,5,"{$productName}",1,0);
            $pdf->Cell(33,5,"{$quality}",1,0);
            $pdf->Cell(25,5,"{$quantity}",1,0);
            $pdf->Cell(30,5,"{$price} /-",1,0);
            $pdf->Cell(35,5,"{$totalPrice} /-",1,1);
        
            $count+=1;
        }
        $pdf->Cell(119	,5,'',0,0);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(34	,5,'Sub Total',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(35	,5,"{$grandTotal} /-",1,1);
        
        if($grandTotal<800)
        {
            $deliveryCharge=50;
        }
        else
        {
            $deliveryCharge=0;
        }
        $payebleAmount=$grandTotal+$deliveryCharge;
        
        $pdf->Cell(119	,5,'',0,0);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(34	,5,'Delivery Charge',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(35	,5,"{$deliveryCharge} /-",1,1);
        
        $pdf->Cell(119	,5,'',0,0);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(34	,5,'Total Amount',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(35	,5,"{$payebleAmount} /-",1,1);
            
        $pdf->output();
        }
    ob_flush();
?>