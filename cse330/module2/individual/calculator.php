<?php

$first_num = 0;
$second_num = 0;


 $selected=$_GET["rad"];
 $first_num = $_GET["num1"];
 $second_num = $_GET["num2"];
 
 if($selected=="Add"){
   $sum = $first_num + $second_num;
   echo "Sum: $sum";
   echo "<br>";
 }

 if($selected=="Subtract"){
   $difference = $first_num - $second_num;
   echo "Difference: $difference";
   echo "<br>";
 }

 if($selected=="Multiply"){
   $product = $first_num * $second_num;
   echo "Product: $product";
   echo "<br>";
 }

 if($selected=="Divide"){
   if($second_num == 0){
     echo "Cannot Divide by 0. Try Again!";
   }
   else{
    $quotient = $first_num / $second_num;
    echo "Quotient: $quotient";
    echo "<br>";
   }
 }

?>
