<?php 
session_start();
include('connection.php');
$Res_ID=$_GET['Res_ID'];
if(!empty($Res_ID))
{
  unset($_SESSION['r_id']);

	$query=mysqli_query($con,"select res_name from restaurant where res_id='$Res_ID'");
  while($res_row=mysqli_fetch_array($query))
  {
    $rest_name=$res_row['res_name'];
    $query1=mysqli_query($con,"select * from tbfood inner join ingredient on tbfood.food_id=ingredient.food_id where res_name='$rest_name'");
    while($res_row1=mysqli_fetch_array($query1))
    { 
      if($res_row1['food_type'] =='custom')
      {
        $food_id=$res_row1['food_id'];
        mysqli_query($con,"delete from ingredient where food_id ='$food_id'");
        mysqli_query($con,"delete from tbfood where res_name='$rest_name'");
        mysqli_query($con,"delete from tblmanager where res_name='$rest_name'");
        mysqli_query($con,"delete from restaurant where res_id='$Res_ID'");
        header( "refresh:3;url=dashboard.php" );
      }
      else
      {
        $food_id=$res_row1['food_id'];
        mysqli_query($con,"delete from tbfood where res_name='$rest_name'");
        mysqli_query($con,"delete from tblmanager where res_name='$rest_name'");
        mysqli_query($con,"delete from restaurant where res_id='$Res_ID'");
        header( "refresh:3;url=dashboard.php" );
      }
    }
  }
} 
?>

<html>
  <head>
     <title>Admin control panel</title>
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <style>
  h1 {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
}
p {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
}
  </style>
  
  </head>
  
    
	<body>
	  <div class="container" style="margin:0px auto;text-align:center;">
     <p style="color:green;"> Please Wait While We Are Updating</p>
	 <img src="img/lg.walking-clock-preloader.gif"/></div>
	   <h1><time>00</time></h1>
<script>
var h1 = document.getElementsByTagName('h1')[0],
    start = document.getElementById('start'),
    stop = document.getElementById('stop'),
    clear = document.getElementById('clear'),
    seconds = 0, minutes = 0, hours = 0,
    t;

function add() {
    seconds++;
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
    }
    
    h1.textContent =   (seconds > 9 ? seconds : "0" + seconds);

    timer();
}
function timer() {
    t = setTimeout(add, 1000);
}
timer();



</script>

	</body>
