<?php
include("connection.php");
session_start();
extract($_REQUEST);
if(isset($updstatus))
{
	if(!empty($_SESSION['id']))
{
	  if(mysqli_query($con,"update tblorder set fldstatus='$status' where fld_order_id='$order_id'"))
	  {
		  header("location:food.php");
	  }
}
else
{
	header("location:manager_login.php?msg=You Must Login First");
}
}

?>
<html>
<head>
<title>Change Order Status</title>
	<!--bootstrap files-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!--bootstrap files-->

	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">

	 <style>
		ul li {list-style:none;}
		ul li a{color:black; font-weight:bold;}
		ul li a:hover{text-decoration:none;}
	 </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #0197A5;">
  
    <a class="navbar-brand" href="index.php"><img src="img/USP Logo.png" style="display: inline-block;"></a>
	<a class="navbar-brand" href="index.php"><span style="color:white;font-family: 'Permanent Marker', cursive;font-size:22pt;">NaBukDiSh</span>
		<span style="color:white;font-family:'Permanent Marker', cursive;font-size:18pt;">&copy</span>
		<br>
		<span style="color:white;font-family: 'Permanent Marker', cursive;font-size:12pt;">Food Ordering System</span>
	</a>
    
	<?php
	if(!empty($id))
	{
	?>
	<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php if(isset($id)) { echo $vr['fld_name']; }?></i></a>
	<?php
	}
	?>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
	<ul class="navbar-nav ml-auto">
	  <li class="nav-item active">
		<a class="nav-link" href="index.php" style="color:black;font-weight:700">Home</a>
		</li>

		<li class="nav-item">
		<a class="nav-link" href="aboutus.php" style="color:#063344;font-weight:650">About</a>
		</li>
		<li class="nav-item">

		<li class="nav-item">
		<a class="nav-link" href="contact.php" style="color:#063344;font-weight:650">Contact</a>
		</li>

		<li class="nav-item">
          <a class="nav-link" href="site-help.php" style="color:#063344;font-weight:650">Help</a>
        </li>
		
		<li class="nav-item">
		  <form method="post">
          <?php
			if(empty($_SESSION['id']))
			{
			?>
		   <button class="btn btn-success my-2 my-sm-0" name="login">Log In</button>&nbsp;&nbsp;&nbsp;
            <?php
			}
			else
			{
			?>
			
			<button class="btn btn-danger my-2 my-sm-0" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
			<?php
			}
			?>
			</form>
        </li>
      </ul>
	  
    </div>
	
</nav>

<br><br><br><br><br><br>
   <div class="container">
    <form method="post">
      <div class="row">
	 
	  <div class="col-sm-4">Update Order Status</div>
	  <div class="col-sm-4">Delivered<input type="radio"  name="status" value="Delivered">&nbsp;&nbsp;&nbsp;Out Of Stock<input type="radio"  name="status" value="Out Of Stock"><br>
	  <br>
	  
		<button type="submit" class="btn btn-success" name="updstatus">Update Status</button>
		<a href="food.php">
			<button type="button" style="position:absolute; right:60; color:white;" class="btn btn-danger">Go Back</button>
		</a>	
	  </div>
	  <div class="col-sm-4"></div>
	  
	  </div>
	  </form>
   </div>
   <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   include("footer.php");
   ?>
</body>
</html>