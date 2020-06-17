<?php
include("../connection.php");
include('sendmail.php'); // <--- Send Mail Function 

if(isset($_GET['staff_id']))
{
	$del_date= $_GET['del_date'];
	$del_date=date("Y-m-d",strtotime($del_date)); 
	$del_time= $_GET['del_time'];
	$loc = $_GET['loc'];
	$pay = $_GET['pay'];
	$staff_id=$_GET['staff_id'];
	$cust_id="";
	$receiver="";
	$query=mysqli_query($con,"select * from tblstaff where staff_id='$staff_id'");
    if($row=mysqli_fetch_array($query))
	{
		$stf_id=$row['staff_email'];
		$receiver=$stf_id;
	}
}
else
{
	$cust_id="";
	$staff_id="";
}

$query=mysqli_query($con,"select *
						from tbfood 
						inner join restaurant on tbfood.res_name=restaurant.res_name 
						inner join tblcart on tbfood.food_id=tblcart.fld_product_id 
						where tblcart.fld_customer_id='$cust_id'
						OR tblcart.fld_staff_id='$staff_id'
						  ");
$re=mysqli_num_rows($query);
while($row=mysqli_fetch_array($query))
{
	echo "<br>";
	echo "cart id is".$cart_id=$row['fld_cart_id'];
	echo "food_id is".$food_id=$row['food_id'];
	echo "quantity ordered is".$qty=$row['fld_product_quantity'];
	echo "cost is".$cost=$row['cost'];
	//$em_id=$row['fld_email'];
	echo 'payment status is'.$paid="In Process";
	$res_name=$row['res_name'];
	$cus_ing=$row['choices'];
	$cusp=$row['prices_ing'];

	if(mysqli_query($con,"insert into tblorder
	(fld_cart_id,fld_food_id,fld_product_quantity,fld_email_id,staff_id,fld_payment,fldstatus,delivery_location,payment_option,delivery_date,delivery_time,res_name,custom_ing,cus_ing_price) values
	('$cart_id','$food_id', '$qty', '$cust_id', '$staff_id' ,'$cost','$paid', '$loc', '$pay','$del_date','$del_time','$res_name','$cus_ing','$cusp')"))
	{
		$query1= mysqli_query($con, "select fld_order_id from tblorder where fld_cart_id='$cart_id'");
		while($row1=mysqli_fetch_array($query1))
		{
			$OrderID=$row1['fld_order_id'];
			if(mysqli_query($con,"insert into payroll 
			(staff_id, payment_amnt, fld_cart_id, fld_order_id) values 
			('$staff_id','$cost','$cart_id','$OrderID')"))
			{
				if(mysqli_query($con,"delete from tblcart where fld_cart_id='$cart_id'"))
				{
					header("location:customerupdate.php");
				}
			}
			else
			{
				echo "Payroll Info insertion failed";	
			}
		}
	}
	else
	{
		echo "Order Info Insertion failed";
	}
	//$row['food_id']."<br>";

	$body = file_get_contents("emailbodysuccessfulpurchase.php");
	$subject= 'Successfully Order Your meal'; // <--- Send Mail Function
	
	sendmail($body, $subject, $receiver, $receiver); // <--- Send Mail Function
}
?>