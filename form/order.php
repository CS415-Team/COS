<?php
include("../connection.php");
include('sendmail.php'); // <--- Send Mail Function 


if(isset($_GET['cust_id']))
{
	$del_date=NULL; 
	//$del_date=date("Y-m-d",strtotime($del_date));
	$del_time= NULL;
	$loc = $_GET['loc'];
	$pay = $_GET['pay'];
	$cust_id=$_GET['cust_id'];
	$staff_id="";
	$receiver = $cust_id;
}
else if(isset($_GET['staff_id']))
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

$body = ''; // <--- Send Mail Function



$query=mysqli_query($con,"select tbfood.food_id,tbfood.foodname,tbfood.fldmanager_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_product_quantity,tblcart.fld_customer_id
						  from tbfood inner join tblcart on tbfood.food_id=tblcart.fld_product_id 
						  where tblcart.fld_customer_id='$cust_id'
						  	OR tblcart.fld_staff_id='$staff_id'  
						  ");
$re=mysqli_num_rows($query);
while($row=mysqli_fetch_array($query))
{
	echo "<br>";
	echo "cart id is".$cart_id=$row['fld_cart_id'];
	echo "menu manager id is".$man_id=$row['fldmanager_id'];
	echo "food_id is".$food_id=$row['food_id'];
	echo "quantity ordered is".$qty=$row['fld_product_quantity'];
	echo "cost is".$cost=$row['cost'];
	//$em_id=$row['fld_email'];
	echo 'payment status is'.$paid="In Process";
	//Send Email
	echo $del_date;
	echo $del_time;

	$body = file_get_contents("emailbodysuccessfulpurchase.php"); // <--- Send Mail Function
	

	//Send email ends


	if(mysqli_query($con,"insert into tblorder
	(fld_cart_id,fldmanager_id,fld_food_id,fld_product_quantity,fld_email_id,staff_id,fld_payment,fldstatus,delivery_location,payment_option,delivery_date,delivery_time) values
	('$cart_id','$man_id','$food_id', '$qty', '$cust_id', '$staff_id' ,'$cost','$paid', '$loc', '$pay','$del_date','$del_time')"))
	{
		if(mysqli_query($con,"delete from tblcart where fld_cart_id='$cart_id'"))
		{
			header("location:customerupdate.php");
		}
	}
	else
	{
		echo "failed";
	}

	//$row['food_id']."<br>";

	$subject= 'Successfully Order Your meal'; // <--- Send Mail Function
	

	sendmail($body, $subject, $receiver, $receiver); // <--- Send Mail Function
}
?>