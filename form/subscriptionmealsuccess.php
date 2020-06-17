<?php

session_start();

extract($_REQUEST);
include('sendmail.php'); // <--- Send Mail Function
include("../connection.php");
$gtotal=array();
$ar=array();

$id = $_GET["id"];
$receiver= $_SESSION["semail"];


$body = file_get_contents("emailbodysuccessfulsubscription.php"); // <--- Send Mail Function
$subject= 'Successfully Subscribed to Meal Subscription'; // <--- Send Mail Function

$payment = $_POST['payment'];

$sql = "Update mealsubscription SET active=1, payment_method='$payment' WHERE subscription_id=$id ";

if($_POST['payment'] == "Card Payment")
{
    $owner=$_POST['owner'];
	$cvv =$_POST['cvv'];
	$c_num=$_POST['cardNumber'];
	$month=$_POST['month'];
	$year=$_POST['year'];

	$date= new DateTime();
	if($month== 4|| $month==6 || $month==9 || $month==11)
	{
		$day=30;
		$date->setDate($year, $month, $day);
		$exp_date =  $date->format('Y-m-d');
	}	
	else
	{
		$day=31;
		$date->setDate($year, $month, $day);
		$exp_date =  $date->format('Y-m-d');
	}
	
	$CardFirstDigit = substr($c_num, 0, 1);
	$CardFirst2Digit = substr($c_num, 0, 2);
	if($CardFirstDigit == "4")
	{
		$card_type = "Visa";
	}
	else if($CardFirst2Digit=="50" || $CardFirst2Digit=="51" || $CardFirst2Digit=="52" || $CardFirst2Digit=="53" || $CardFirst2Digit=="54" || $CardFirst2Digit=="55")
	{
		$card_type="Mastercard";

	}
	else if($CardFirst2Digit=="34" || $CardFirst2Digit=="37")
	{
		$card_type="American Express";
	}
	else
	{
		$card_type="Invalid";
    }
    
    $query = "insert into tblcard_ms (subscription_id,staff_email,owner,cardnumber,cvv,cardtype,exp_date) 
    values ('$id','$receiver','$owner','$c_num' ,'$cvv' , '$card_type', '$exp_date') ";
    mysqli_query($con, $query);
}
sendmail($body, $subject, $receiver, $receiver); // <--- Send Mail Function
if(mysqli_query($con, $sql))
{
    header("location:subscription.php");
}
?>