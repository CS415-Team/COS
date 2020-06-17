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
	 $staff_id="";
	 $admin_id="";
	 $man_id="";
	 $d_id="";
}
else if(isset($_SESSION['staff_id']))
{
	$staff_id=$_SESSION['staff_id'];
	$squery=mysqli_query($con,"select * from tblstaff where staff_id='$staff_id'");
	$sresult=mysqli_fetch_array($squery);
	$cust_id="";
	$admin_id="";
	$man_id="";
	$d_id="";
}
else if(isset($_SESSION['id']))
{
	$man_id=$_SESSION['id'];
	$mquery=mysqli_query($con,"select * from tblmanager where fld_email='$man_id'");
	$mresult=mysqli_fetch_array($mquery);
	$cust_id="";
	$staff_id="";
	$admin_id="";
	$d_id="";
}
else if(isset($_SESSION['admin']))
{
	$admin_id=$_SESSION['admin'];
	$aquery=mysqli_query($con,"select * from tbadmin where fld_username='$admin_id'");
	$aresult=mysqli_fetch_array($aquery);
	$man_id="";
	$cust_id="";
	$staff_id="";
	$d_id="";
}
else if(isset($_SESSION['d_id']))
{
	$d_id=$_SESSION['d_id'];
	$dquery=mysqli_query($con,"select * from tbl_deliverer where fld_email='$d_id'");
	$dresult=mysqli_fetch_array($dquery);
	$man_id="";
	$cust_id="";
	$staff_id="";
	$admin_id="";
}
else
{
	$cust_id="";
	$staff_id="";
	$man_id="";
	$admin_id="";
	$d_id="";
}
 
/*
$query=mysqli_query($con,"select  tblmanager.fld_name,tblmanager.fldmanager_id,tblmanager.fld_email,
tblmanager.fld_mob,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
tbfood.paymentmode 
from tblmanager inner join tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['food_id'];
	shuffle($arr);
}
*/
//print_r($arr);

 if(isset($addtocart))
 {
	if(!empty($_SESSION['cust_id']) || !empty($_SESSION['staff_id']))
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
 
$query=mysqli_query($con,"select tbfood.foodname,tbfood.cost,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id, tblcart.fld_staff_id 
						 from tbfood inner join tblcart on tbfood.food_id=tblcart.fld_product_id 
						 where tblcart.fld_customer_id='$cust_id'
 							OR tblcart.fld_staff_id='$staff_id'
						 ");
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

	#footer 
	{
		position: absolute;
		bottom: 0;
		width: 100%;
		height: 2rem;/* Footer height */
	}

	/* Style the button and place it in the middle of the container/image */
	.imagewrap .btn,.imagewrap1 .btn {
	position: absolute;
	top: 85%;
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

	.imagewrap .btn:hover, .imagewrap1 .btn:hover{
	background-color: #0197A5;
	}

	/*@media 
	only screen and (max-width: 767px){
		.imagewrap{
		display: none;
		}
		.imagewrap1{
		display: block;
		}
	}*/
	.imagewrap{
	display: none;
	}
	.imagewrap1{
	display: block;
	}

	@media (min-width:992px){
		.imagewrap{
		display: block;
		}
		.imagewrap1{
		display: none;
		}
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

			<?php
			if(!empty($staff_id))
			{
			?>
			<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php echo $sresult['staff_name']; ?></i></a>
			<?php
			}
			?>

			<?php
			if(!empty($man_id))
			{
			?>
			<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php echo $mresult['fld_name']; ?></i></a>
			<?php
			}
			?>


			<?php
			if(!empty($d_id))
			{
			?>
			<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php echo $dresult['fld_name']; ?></i></a>
			<?php
			}
			?>


			<?php
			if(!empty($admin_id))
			{
			?>
			<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user">Admin</i></a>
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
                    <a class="dropdown-item" href="menu.php#dinner">Dinner Specials</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="custom.php">Custom Meals</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="menu.php">All</a>
                    </div>
                </li>

				<?php 

					if(isset($_SESSION['staff_id']))

					{ ?>
						<li class="nav-item">
						<a class="nav-link" href="form/subscription.php">Subscription</a>
						</li>
					<?php
					}
				
				?>

				<li class="nav-item">
				<a class="nav-link" href="aboutus.php">About</a>
				</li>

				<li class="nav-item">
				<a class="nav-link" href="contact.php">Contact</a>
				</li>

				<li class="nav-item">
				<a class="nav-link" href="site-help.php">Help</a>
				</li>

				<li class="nav-item">
				<form method="post">
				<?php
					if(empty($cust_id) && empty($staff_id) && empty($man_id) && empty($admin_id) && empty($d_id))
					{
					?>
					<a href="form/index.php?msg=You must be logged in first"><span style="color:red; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">0</span></i></span></a>
					
					&nbsp;&nbsp;&nbsp;
					<button class="btn btn-success my-2 my-sm-0" name="login" type="submit">Log In</button>&nbsp;&nbsp;&nbsp;
					<?php
					}
					else
					{
					?>
						<?php 
						if((!isset($_SESSION['id'])) &&(!isset($_SESSION['admin'])) &&(!isset($_SESSION['d_id'])))

						{ ?>
							<a href="form/cart.php"><span style=" color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) { echo $re; }?></span></i></span></a>
						<?php 
						} 
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

		<div style="position: relative; min-height:100vh;"><!--Container Div-->
			<div id="content-wrap" style="padding-bottom: 0rem;"><!-- all other page content -->
				<!--Homepage Body-->
				<div class="imagewrap" style="margin-top:110px; position:relative; height:100vh;">
					<img src="img/homepage.jpg" alt="Welcome image" width="100%" height="100%">
					<button type="button" class="btn btn-danger btn-lg" onclick="window.location.href = 'menu.php';">Check out our menus</button>
				</div>
				<div class="imagewrap1" style="margin-top:110px; position:relative; height:100vh;">
					<img src="img/homepage3.jpg" alt="Welcome image" width="100%" height="100%">
					<button type="button" class="btn btn-danger btn-lg" onclick="window.location.href = 'menu.php';">Check out our menus</button>
				</div>
			</div><!--End content wrap-->
			<footer id="footer">
				<?php
					include("footer.php");
				?>
			</footer>
		</div><!--Container Div ends-->  	
	</body>
</html>