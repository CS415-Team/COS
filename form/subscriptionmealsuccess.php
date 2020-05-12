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
$sql = "Update mealsubscription SET active=1 WHERE subscription_id=$id ";
sendmail($body, $subject, $receiver, $receiver); // <--- Send Mail Function
if(mysqli_query($con, $sql))
{
    header("location:subscription.php");
}
?>