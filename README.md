# COS
Cafeteria Ordering System


Installation Guide:

1. Create dbfood Database in your PhpMyAdmin
2. dbfood.sql in the database you have created
3. Edit connection.php file:
connection.php:
<?php
$hostname="localhost";
$user_name="root"; <-- Update with your phpmyadmin username
$password=""; <-- Update with your phpmyadmin password
$db="dbfood";
$con=mysqli_connect($hostname,$user_name,$password,$db);
?>

