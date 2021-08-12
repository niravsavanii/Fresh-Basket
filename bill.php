<?php
    session_start();
    include("db.php");

    require("FPD/fpdf.php");

    
    
        $date=date("d-M-Y");
        if(isset($_GET['or_id']))
            {
                $o_id=$_GET['or_id'];
            }
        $get_orders = "select * from orders where id='$o_id'";
        $run_orders = mysqli_query($con,$get_orders);
        $i = 0;
       while( $row_orders = mysqli_fetch_array($run_orders)){
         
            $customer_name=$row_orders['customer_name'];
            $customer_address=$row_orders['customer_address'];
            $customer_contact=$row_orders['customer_contact'];
            $customer_email=$row_orders['customer_email'];
            $customer_city=$row_orders['customer_city'];
            $order_id=$row_orders['id'];
            $i++; 
    
    
    $total=0;
    $get_c_orders = "select * from customer_orders where order_id='$o_id'";
    $run_c_orders = mysqli_query($con,$get_c_orders);
    while( $row_c_orders = mysqli_fetch_array($run_c_orders)){
        $order_id=$row_c_orders['id'];
        $invoice_no=$row_c_orders['invoice_no'];
        $order_date=$row_c_orders['order_date'];
        $pro_id=$row_c_orders['product_id'];
        $pro_qty=$row_c_orders['qty'];
        $get_products="select * from tbl_product where product_id='$pro_id'";
        $run_products=mysqli_query($con,$get_products);
        while($row_products=mysqli_fetch_array($run_products)){
            $product_title=$row_products['model_name'];
            $product_img1=$row_products['product_image'];
            $product_price=$row_products['price'];
            $sub_total=$row_products['price']*$pro_qty;
            $total+=$sub_total;
    }
}
    $pdf=new FPDF();
    $pdf->AddPage();

   //set font to arial, bold, 14pt
   $pdf->SetFont('Arial','B',14);

$pdf->Image('lhlogo.png',90,5,20);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130	,5,'Laptop House',0,0);
$pdf->Cell(59	,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130	,5,'34,Silver Business Point,surat',0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'Surat, India, 395004',0,0);
$pdf->Cell(25	,5,'Date :',0,0);
$pdf->Cell(34	,5,"{$order_date}",0,1);//end of line

$pdf->Cell(130	,5,'+91 9876543210',0,0);
$pdf->Cell(25	,5,'Invoice :',0,0);
$pdf->Cell(34	,5,"{$invoice_no}",0,1);//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Order ID :',0,0);
$pdf->Cell(34	,5,"{$o_id}",0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//billing address
$pdf->Cell(100	,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,"{$customer_name}",0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,"{$customer_email}",0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,"{$customer_address}",0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,"{$customer_contact}",0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(50	,5,'Product id',1,0);
$pdf->Cell(35	,5,'Product Name',1,0);
$pdf->Cell(25	,5,'Price',1,0);
$pdf->Cell(34	,5,'Quantity',1,0);
$pdf->Cell(45	,5,'Total',1,1);//end of line

$pdf->SetFont('Arial','',12);

//Numbers are right-aligned so we give 'R' after new line parameter
$total=0;
$sub_total=0;
$gst=0;
$totals=0;
$get_c_orders = "select * from customer_orders where order_id='$o_id'";
$run_c_orders = mysqli_query($con,$get_c_orders);
while ($row_c_orders = mysqli_fetch_array($run_c_orders)) {
    $order_id=$row_c_orders['id'];
    $invoice_no=$row_c_orders['invoice_no'];
    $order_date=$row_c_orders['order_date'];
    $pro_id=$row_c_orders['product_id'];
    $pro_qty=$row_c_orders['qty'];
   
   
        $get_products="select * from tbl_product where product_id='$pro_id'";
        $run_products=mysqli_query($con, $get_products);
        while ($row_products=mysqli_fetch_array($run_products)) {
            $product_title=$row_products['model_name'];
            $product_img1=$row_products['product_image'];
            $product_price=$row_products['price'];
            $sub_total=$row_products['price']*$pro_qty;
            
            $pdf->Cell(50, 5, "{$pro_id}", 1, 0);
            $pdf->Cell(35, 5, "{$product_title}", 1, 0);
            $pdf->Cell(25, 5, "{$product_price}", 1, 0);
            $pdf->Cell(34, 5, "{$pro_qty}", 1, 0);
            $pdf->Cell(45, 5, "{$sub_total}", 1, 1, 'R');
        }
    
    $total+=$sub_total;
    $gst=$total*12/100;
    $totals=$total+$gst;
}
//summary
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Sub Total',0,0);
$pdf->Cell(30	,5,"Rs.{$total}",1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'GST(12%)',0,0);
$pdf->Cell(30	,5,"Rs.{$gst}",1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Total Paid',0,0);
$pdf->Cell(30	,5,"Rs.{$totals}",1,1,'R');//end of line

    $pdf->output();
    }
?>