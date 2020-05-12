<?php

include("../connection.php");
$id = (int)$_GET["id"];
$sql = "Delete from mealsubscription WHERE subscription_id=$id ";
$m="Successfully subscribed to meal subscription";
echo "<script type='text/javascript'>alert('$m');</script>";
if(mysqli_query($con, $sql))
{   }
header("location:../subscription.php");
?>