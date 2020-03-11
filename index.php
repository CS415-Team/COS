<?php
session_start();

include("connection.php");
extract($_REQUEST);
$arr=array();
if(isset($_GET['msg']))
{
	$loginmsg=$_GET['msg'];
}
else
{
	$loginmsg="";
}
if(isset($_SESSION['cust_id']))
{
	 $cust_id=$_SESSION['cust_id'];
	 $cquery=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	 $cresult=mysqli_fetch_array($cquery);
}
else
{
	$cust_id="";
}
 

$query=mysqli_query($con,"select  tblvendor.fld_name,tblvendor.fldvendor_id,tblvendor.fld_email,
tblvendor.fld_mob,tblvendor.fld_address,tblvendor.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
tbfood.paymentmode 
from tblvendor inner join tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['food_id'];
	shuffle($arr);
}

//print_r($arr);

 if(isset($addtocart))
 {
	 
	if(!empty($_SESSION['cust_id']))
	{
		 
		header("location:form/cart.php?product=$addtocart");
	}
	else
	{
		header("location:form/?product=$addtocart");
	}
 }
 
 if(isset($login))
 {
	 header("location:form/index.php");
 }
 if(isset($logout))
 {
	 session_destroy();
	 header("location:index.php");
 }


 
 $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldvendor_id,tbfood.cost,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
if(isset($message))
 {
	 
	 if(mysqli_query($con,"insert into tblmessage(fld_name,fld_email,fld_phone,fld_msg) values ('$nm','$em','$ph','$txt')"))
     {
		 echo "<script> alert('We will be Connecting You shortly')</script>";
	 }
	 else
	 {
		 echo "failed";
	 }
 }

?>
<html>
  <head>
     <title>Home</title>
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
	//body{
		background-image:url("img/main_spice2.jpg");
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: center;
	}
	ul li {list-style:none;}
	ul li a{color:black; font-weight:bold;}
	ul li a:hover{text-decoration:none;}



/* Style the button and place it in the middle of the container/image */
 .imagewrap .btn {
  position: absolute;
  top: 80%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color: red;
  color: white;
  font-size: 30px;
  padding: 12px 24px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.imagewrap .btn:hover {
  background-color: #0197A5;
}
</style>
</head>
	<body>
	
		<div id="result" style="position:fixed;top:300; right:500;z-index: 3000;width:350px;background:white;"></div>
		<div id="resulthotel" style=" margin:0px auto; position:fixed; top:150px;right:750px; background:white;  z-index: 3000;"></div>

		<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #0197A5;">
		
			<a class="navbar-brand" href="index.php"><img src="img/USP Logo.png" style="display: inline-block;"></a>
			<a class="navbar-brand" href="index.php"><span style="color:white;font-family: 'Permanent Marker', cursive;font-size:22pt;">NaBukDiSh</span>
				<span style="color:white;font-family:'Permanent Marker', cursive;font-size:18pt;">&copy</span>
				<br>
				<span style="color:white;font-family: 'Permanent Marker', cursive;font-size:12pt;">Food Ordering System</span>
			</a>

			<?php
			if(!empty($cust_id))
			{
			?>
			<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php echo $cresult['fld_name']; ?></i></a>
			<?php
			}
			?>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
			
			<ul class="navbar-nav ml-auto">

				<li class="nav-item active">
				<a class="nav-link" href="index.php">Home</a>
				</li>
				
                <li class="nav-item dropright">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menus
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="border:1px solid black;">
                    <div class="dropdown-header" align="center" 
                        style="background-color:#0197A5; color:white; font-family: 'Times New Roman'; font-style:italic; font-weight:bold;">
                        MEAL TYPE
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="menu.php#breakfast">Breakfast Specials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="menu.php#lunch">Lunch Specials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Dinner Specials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="menu.php">All</a>
                    </div>
                </li>

				<li class="nav-item">
				<a class="nav-link" href="aboutus.php">About</a>
				</li>

				<li class="nav-item">
				<a class="nav-link" href="contact.php">Contact</a>
				</li>
				<li class="nav-item">
				<form method="post">
				<?php
					if(empty($cust_id))
					{
					?>
					<a href="form/index.php?msg=You must be logged in first"><span style="color:red; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">0</span></i></span></a>
					
					&nbsp;&nbsp;&nbsp;
					<button class="btn btn-danger my-2 my-sm-0" name="login" type="submit">Log In</button>&nbsp;&nbsp;&nbsp;
					<?php
					}
					else
					{
					?>
					<a href="form/cart.php"><span style=" color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) { echo $re; }?></span></i></span></a>
					<button class="btn btn-success my-2 my-sm-0" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
					<?php
					}
					?>
					</form>
				</li>
				
			</ul>
			
			</div>
			
		</nav>

		<!--Homepage Body-->
		<div class="imagewrap" style="margin-top:110px;">
			<img src="img/homepage.jpg" alt="Welcome image" class="d-block w-100" width="100%" height="500" >
			<button type="button" class="btn btn-danger btn-lg" onclick="window.location.href = 'menu.php';">Check out our menus</button>
		</div>
		<!--footer primary-->	     
		<?php include("footer.php"); ?>
			 			 		
	</body>
</html>