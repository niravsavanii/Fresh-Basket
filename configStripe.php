<?php
    require 'stripe-php-master/init.php';
    
    $publishableKey="pk_test_51IlXHYSGGCkthBTDMckhXwz1iWw7Di6octyQTgsTTqfpW2dicQp9FFjwYA2UWeHLlxYN81qSSQr52l30JqrMlQl0003KKGsTlx";
    $secretKey="sk_test_51IlXHYSGGCkthBTDnucoUm74FCMa0ON16UUVhAM6BAaQzzsNSD3YHc0ZrhjEEwPxJuTpnf6EBXchxir5ClSVdZ1S00exhT7hCx";

    \Stripe\Stripe::setApiKey($secretKey);
?>