<?php

include("../connection.php");
include('sendmail.php'); // <--- Send Mail Function
$quantity = 1;
$status = "In Process";
$paymentoption = "Payroll Deduction";
$cust_id = "";

$sql = "SELECT * FROM mealsubscription WHERE active='1'";
$sql = mysqli_query($con, $sql);

while($res=mysqli_fetch_assoc($sql))
{
    $meal = $res["meal"];
    $id = $res["staff_id"];
    $location = $res["delivery_location"];
    $dtime = $res["delivery_time"];
    $ddate = date("Y/m/d");
    $otime = date("Y-m-d h:i:sa");

    $query = "INSERT INTO tblcart (fld_product_id, fld_staff_id, fld_product_quantity) 
    values ('$meal','$id','1')";
    mysqli_query($con, $query);

    $query="SELECT tblcart.fld_cart_id, tblcart.fld_product_id, tblcart.fld_staff_id, tbfood.food_id, tbfood.cost FROM tblcart JOIN tbfood ON
    tblcart.fld_product_id=tbfood.food_id
    WHERE tblcart.fld_staff_id='$id' AND tblcart.fld_product_id='$meal'";

    $query = mysqli_query($con, $query);
    if($row=mysqli_fetch_assoc($query)){
    
        $cost = $row["cost"];
        $cart = $row["fld_cart_id"];

        $qry="insert into tblorder
        (fld_cart_id,fldmanager_id,fld_food_id,fld_product_quantity,fld_email_id,staff_id,fld_payment,fldstatus,delivery_location,payment_option,delivery_date,delivery_time) values
        ('$cart','22','$meal', '$quantity', '$cust_id', '$id' ,'$cost','$status', '$location', '$paymentoption','$ddate','$dtime')";
        mysqli_query($con, $qry);

        $qry = "Delete from tblcart WHERE fld_cart_id='$cart'";
        mysqli_query($con, $qry);
        //sendmail($body, $subject, $receiver, $receiver); // <--- Send Mail Function

    }

    
}
?>