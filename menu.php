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
}
else if(isset($_SESSION['staff_id']))
{
	$staff_id=$_SESSION['staff_id'];
	$squery=mysqli_query($con,"select * from tblstaff where staff_id='$staff_id'");
	$sresult=mysqli_fetch_array($squery);
	$cust_id="";
}
else
{
	$cust_id="";
	$staff_id="";
}

$query=mysqli_query($con,"select  tblmanager.fld_name,tblmanager.fldmanager_id,tblmanager.fld_email,
tblmanager.fld_mob,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
tbfood.qty_available,tbfood.paymentmode from tblmanager inner join tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['food_id'];
	shuffle($arr);
}

if(isset($_POST['submit1']))
{

    if(!empty($_POST['a'])) 
	{

        foreach($_POST['a'] as $value)
		{
            //echo "value : ".$value.'<br/>';
			$_SESSION['c1'] = $_POST['a'];
        }

    }

	else
	{
		echo "<b>Please Select Atleast One Option.</b>";
	}

}

if(isset($_POST['submit2']))
{

    if(!empty($_POST['b'])) 
	{

        foreach($_POST['b'] as $value)
		{
            //echo "value : ".$value.'<br/>';
			$_SESSION['c2'] = $_POST['b'];
        }

    }

	else
	{
		echo "<b>Please Select Atleast One Option.</b>";
	}

}

if(isset($_POST['submit3']))
{

    if(!empty($_POST['c'])) 
	{

        foreach($_POST['c'] as $value)
		{
            //echo "value : ".$value.'<br/>';
			$_SESSION['c3'] = $_POST['c'];
        }

    }

	else
	{
		echo "<b>Please Select Atleast One Option.</b>";
	}

}

if(isset($_POST['submit4']))
{

    if(!empty($_POST['d'])) 
	{

        foreach($_POST['d'] as $value)
		{
            //echo "value : ".$value.'<br/>';
			$_SESSION['c4'] = $_POST['d'];
        }

    }

	else
	{
		echo "<b>Please Select Atleast One Option.</b>";
	}

}

/*if(isset($_POST['submit']))
{
	if(!empty($_POST['veg'])) 
	{
// Counting number of checked checkboxes.
	$checked_count = count($_POST['veg']);
	echo "You have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
		
		foreach($_POST['veg'] as $selected) 
		{
			echo "<p>".$selected ."</p>";
		}
			
	}

	else
	{
		echo "<b>Please Select Atleast One Option.</b>";
	}
}*/

//print_r($arr);

 if(isset($addtocart))
 { 
	if(!empty($_SESSION['cust_id']) || !empty($_SESSION['staff_id']))
	{
		$query=mysqli_query($con,"select qty_available from tbfood where food_id =$addtocart");

		while($res=mysqli_fetch_assoc($query))
		{
			if($_POST['foodqty'] > $res['qty_available'])
			{
				echo "<script> alert('Error: Cannot proceed to cart. Quantity ordered exceeds current available quantity');document.location='menu.php'</script>";
			}
			else if($_POST['foodqty'] == 0)
			{
				echo "<script> alert('Error: Cannot proceed to cart. Please enter a valid quantity [>0]');document.location='menu.php'</script>";
			}
			else
			{
				$_SESSION['qty'] = $_POST['foodqty'];
				
				header("location:form/cart.php?product=$addtocart");	
			}
		}
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

$query=mysqli_query($con,"select tbfood.foodname,tbfood.fldmanager_id,tbfood.cost,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id 
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
     
	
	<script>
	//search product function
	$(document).ready(function(){
		$("#search_text").keypress(function()
		{
			load_data();
			function load_data(query)
			{
				$.ajax({
				url:"fetch2.php",
				method:"post",
				data:{query:query},
				success:function(data)
					{
						$('#result').html(data);
					}
				});
			}

			$('#search_text').keyup(function(){
				var search = $(this).val();
				if(search != '')
				{
					load_data(search);
				}
				else if(search == '')
				{
					$('#result').html("");
				}
				else
				{
					$('#result').html(data);			
				}
			});
		});
	});
	
	//Close search results when user clicks outside
	$(document).on('click', function (e) 
	{
		if($(e.target).attr('id') != "search_text") {
			$('#result').html("");
		}
	});
	

	//hotel search
	$(document).ready(function(){
		$("#search_hotel").keypress(function()
		{
			load_data();
			function load_data(query)
			{
				$.ajax({
					url:"fetch.php",
					method:"post",
					data:{query:query},
					success:function(data)
					{
						$('#resulthotel').html(data);
					}
				});
			}
		});

		$('#search_hotel').keyup(function(){
			var search = $(this).val();
			if(search != '')
			{
				load_data(search);
			}
			else
			{
				load_data();			
			}
		});
	});
	</script>
	
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

		/*Adjusting to the meal heading when clicking breakfast section */
		/*Not in use for release 1*/
		h1.breakfast-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.breakfast-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		/*Adjustment of lunch meal just for release 1*/
		/*Will not use after including breakfast and dinner */
		h1.lunch-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.lunch-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		h1.dinner-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.dinner-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}
		
		h1.custom-menu {
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.custom-menu::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		h1.beverage {
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.beverage::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}
	
		#footer {
			position: absolute;
			bottom: 0;
			width: 100%;
			height: 6rem;/* Footer height */
		}
	</style>

</head>
	<body>
		<header>
			<!--Search Results-->
				<!--<div id="result" style="position:fixed;top:300; right:500;z-index: 3000;width:350px;background:white;"></div>-->
				<!--<div id="resulthotel" style=" margin:0px auto; position:fixed; top:150px;right:750px; background:white;  z-index: 3000;"></div>-->
			<!--Search Results End-->
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

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
				
				<ul class="navbar-nav ml-auto">
					<!-- Commenting hotel search for now 
					<li class="nav-item">
						<a href="#" class="nav-link"><form method="post"><input type="text" name="search_hotel" id="search_hotel" placeholder="Search Hotels " class="form-control " /></form></a>
					</li>
					-->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<form method="post">
								<input type="text" name="search_text" id="search_text" placeholder="Search by Food Name " class="form-control"/>
							</form>
							<div id="result" style="position:fixed; z-index: 3000;width:350px;background:white;"></div>
						</a>
					</li>
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
						<a class="dropdown-item" href="#breakfast">Breakfast Specials</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#lunch">Lunch Specials</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Dinner Specials</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#custom">Custom</a>
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

					<li class="nav-item">
					<a class="nav-link" href="contact.php">Contact</a>
					</li>
					<li class="nav-item">
					<form method="post">
					<?php
						if(empty($cust_id) && empty($staff_id))
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
						<a href="form/cart.php"><span style=" color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) { echo $re; }?></span></i></span></a>
						<button class="btn btn-danger my-2 my-sm-0" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
						<?php
						}
						?>
						</form>
					</li>
				</ul>
				</div>	
			</nav>
		</header>
        <!--Header stuff ends-->

        <!--Slider-->
		<section>
			<div id="demo" class="carousel slide" data-ride="carousel" style="margin-top:110px">
			<ul class="carousel-indicators">
				<li data-target="#demo" data-slide-to="0" class="active"></li>
				<li data-target="#demo" data-slide-to="1"></li>
				<li data-target="#demo" data-slide-to="2"></li>
			</ul>
			<div class="carousel-inner">
				<div class="carousel-item active">
				<img src="img/chicken-curry.jpg" alt="Chicken curry" class="d-block w-100" width="100%" height="600">
				
				<div class="carousel-caption" style="top: 20; bottom: auto;">
					<h1 style="font-family: 'Lobster', cursive; font-weight:light; font-size:50px; color:red;">Today's Special</h1>
			</div>

				<div class="carousel-caption" style="color:white; bottom: 50;">
					<h3>Chicken curry & rice</h3>
					<p>Fast selling. Check out our meal prices below</p>
				</div>   
				</div>

				<div class="carousel-item">
				<img src="img/chicken-fried-rice.jpg" alt="Chicken fried rice" class="d-block w-100" width="100%" height="600">
				<div class="carousel-caption" style="color:black;">
					<h3>Chicken Fried Rice</h3>
					<p>Check out our meal prices below</p>
				</div>   
				</div>

				<div class="carousel-item">
				<img src="img/Chicken-Chopsuey.jpg" alt="Chicken Chopsuey" class="d-block w-100" width="100%" height="600">
				<div class="carousel-caption" style="color:black;" >
					<h3>Chicken Chopsuey</h3>
					<p>Check out our meal prices below</p>
				</div>   
				</div>
			
				<div class="carousel-item">
				<img src="img/chicken-wings.jpg" alt="Tasty Chicken Wings" class="d-block w-100" width="100%" height="600">
				<div class="carousel-caption" style="color:white;" >
					<h3>Tasty Wings</h3>
					<p>Check out our meal prices below</p>
				</div>   
				</div>
			
			</div>
			<a class="carousel-control-prev" href="#demo" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="carousel-control-next" href="#demo" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
			</div>
			<!--slider ends-->
		</section>

		<div style="position: relative;  min-height: 100vh;"><!--Container Div-->
			<div id="content-wrap" style="padding-bottom: 6rem;"><!-- all other page content -->
		
			<!--Menu Begins-->
			<!--Breakfast meals-->
			<h1 class="breakfast-meal" id="breakfast" align="center" >Breakfast Meals</h1>
				<div class="row">
				<?php
					$query=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
					tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
					tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
					tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_time='breakfast'");

						while($res=mysqli_fetch_assoc($query))
							{
								//$food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];	
							?>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<b><?php echo $res['foodname'] ?></b>
									</div>
									<div class="panel-body">
										<img src="image/restaurant/<?php echo $res['fld_email']."/foodimages/".$res['fldimage'];?>"  height="300px" width="100%">
									</div>
									<span style="color:black; font-size:20px; white-space:nowrap;">Price: $<?php echo $res['cost']; ?></span>
									<br>
									<span id="qty_av" style="color:black; font-size:20px; white-space:nowrap;">Quantity Available: <?php echo $res['qty_available']; ?></span>
									<br>
									<form action="menu.php" method="post" id="cart">
										<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
										<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
									
										<br><br>

										<div align="left">
										<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
										<button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" >
										<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
										</div>
									</form>
								</div>			
							</div>
						
					<?php } ?>
				</div>
				<!--Breakfast meals end-->`

		<!--		<script>
					$(function()
					{
						$('#foodqty').bind('keyup click', function(){
							//var n1 = parseInt($('#mirror').val());
							var n2 = parseInt($(this).val());
							var r = n2 - 1;
							document.getElementById("qty_av").innerHTML = "Quantity Available: "+r;
							//$('#mirror').val(r); 
						});
					});
				</script>
		-->
				<!--Lunch meals-->
				<h1 class="lunch-meal" id="lunch" align="center" >Lunch Meals</h1>
				<div class="row">
				<?php
					$query=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
					tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
					tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.qty_available from tblmanager inner join
					tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_time='regular'");

						while($res=mysqli_fetch_assoc($query))
							{
								//$food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];	
							?>
								<div class="col-md-3">
									<div class="panel panel-default">
										<div class="panel-heading text-center">
											<b><?php echo $res['foodname'] ?></b>
										</div>
										<div class="panel-body">
											<img src="image/restaurant/<?php echo $res['fld_email']."/foodimages/".$res['fldimage'];?>"  height="300px" width="100%">
										</div>
										<span style="color:black; font-size:20px; white-space:nowrap;">Price: $<?php echo $res['cost']; ?></span>
										<br>
										<span style="color:black; font-size:20px; white-space:nowrap;">Quantity Available: <?php echo $res['qty_available']; ?></span>
										<br>
										<form id="cartForm" name="cartForm" method="post" action="menu.php">
											<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
											<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
											<br><br>
											<div align="left">
												<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
													<button id="addtocart" type="submit" name="addtocart" value="<?php echo $res['food_id'];?>">
												<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
											</div>
										</form>
									</div>			
								</div>
					<?php   } ?>
				</div> <!-- Row ends-->
				<!--Lunch meals end-->

				<!--Dinner meals-->
				<h1 class="dinner-meal" id="dinner" align="center" >Dinner Meals</h1>
				<div class="row">
				<?php
					$query=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
					tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
					tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
					tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_time='dinner' || tbfood.food_time='regular'");

						while($res=mysqli_fetch_assoc($query))
							{
								//$food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];	
							?>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<b><?php echo $res['foodname'] ?></b>
									</div>
									<div class="panel-body">
										<img src="image/restaurant/<?php echo $res['fld_email']."/foodimages/".$res['fldimage'];?>"  height="300px" width="100%">
									</div>
									<span style="color:black; font-size:20px; white-space:nowrap;">Price: $<?php echo $res['cost']; ?></span>
									<br>
									<span style="color:black; font-size:20px; white-space:nowrap;">Quantity Available: <?php echo $res['qty_available']; ?></span>
									<br>
									<form action="menu.php" method="post" id="cart">
										<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
										<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
									
										<br><br>

										<div align="left">
										<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
										<button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" >
										<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
										</div>
									</form>
								</div>			
							</div>
						
					<?php } ?>
				</div>
				<!--Dinner meals end-->

				<!--Beverage starts-->
				<h1 class="beverage" id="beverage" align="center" >Beverages</h1>
				<div class="row">
				<?php
					$query=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
					tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
					tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
					tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_time='beverage'");

						while($res=mysqli_fetch_assoc($query))
							{
								//$food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];	
							?>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<b><?php echo $res['foodname'] ?></b>
									</div>
									<div class="panel-body">
										<img src="image/restaurant/<?php echo $res['fld_email']."/foodimages/".$res['fldimage'];?>"  height="300px" width="100%">
									</div>
									<span style="color:black; font-size:20px; white-space:nowrap;">Price: $<?php echo $res['cost']; ?></span>
									<br>
									
									<form action="menu.php" method="post" id="cart">
										<span style="color:black; font-size:20px; white-space:nowrap;">Quantity Available: <?php echo $res['qty_available']; ?></span>
										<br>
										<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
										<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
									
										<br><br>

										<div align="left">
										<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
										<button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" >
										<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
										</div>
									</form>
								</div>			
							</div>
						
					<?php } ?>
				</div>
				<!--Beverage ends-->


				<!--Custom menu starts-->
				<div style="text-align:center;">
					<h1 class="custom-menu" id="custom">Custom Menu</h1>
					<span style="color:red; font-size:20px;  width: 90%;  margin: 0 auto;  "> Eat Good. Feel Good.</span>
					<br>
					<span style="color:black; font-size:20px; "> You can build your own meal by choosing your favourite ingredients.</span>
				</div>

				<div class="row">
					<div class="col-md-4">
						<?php 
							$quer_res=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
							tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
							tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
							tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_id = 20 && tbfood.food_type='custom'"); 
							
							$roww=mysqli_fetch_array($quer_res);?>

						<!--<form name="soup">-->
							<div class="panel panel-default">
								<div class="panel-heading text-center">
									<b><?php echo $roww['foodname'] ?></b>
								</div>
								
								<div class="panel-body">
										<img src="image/restaurant/<?php echo $roww['fld_email']."/foodimages/".$roww['fldimage'];?>"  height="300px" width="100%">
								</div>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;">Price: $<?php echo $roww['cost']; ?></span>
								<br>
								<!--<div style="text-align:center">
									<span style="font-family: 'Miriam Libre', sans-serif; font-size:23px;">Pick any 3 vegetables and 1 meat of your choice</span>
									<br>
									<span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight: bold;">Vegetables</span>
									<br>
									<input type="checkbox" name="cabbage"
									onClick="return KeepMeatCount()"> Cabbage

									<input type="checkbox" name="potato"
									onClick="return KeepMeatCount()"> Potatoes

									<input type="checkbox" name="carrot"
									onClick="return KeepMeatCount()"> Carrot

									<input type="checkbox" name="tomato"
									onClick="return KeepMeatCount()"> Tomatoes

									<input type="checkbox" name="mushroom"
									onClick="return KeepMeatCount()"> Mushroom
					
									<input type="checkbox" name="brocolli"
									onClick="return KeepMeatCount()"> Brocolli
					
									<input type="checkbox" name="spinach"
									onClick="return KeepMeatCount()"> Spinach
								<br>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight:bold;">Meat</span>
								<br>
									<input type="checkbox" name="chicken"
									onClick="return KeepMeatCount()"> Chicken

									<input type="checkbox" name="pork"
									onClick="return KeepMeatCount()"> Pork

									<input type="checkbox" name="beef"
									onClick="return KeepMeatCount()"> Beef
								</div>-->

							<form method="post" action="">
								<span>Select Vegetables</span><br/>
								<input type="checkbox" name='a[]' value="brocolli"> Brocolli <br/>
								<input type="checkbox" name='a[]' value="spinach"> Spinach <br/>
								<input type="checkbox" name='a[]' value="mushroom"> Mushroom <br/>
								<input type="checkbox" name='a[]' value="potato"> Potatoes <br/>
								<span>Select Meat</span><br/>
								<input type="checkbox" name='a[]' value="chicken"> Chicken <br/>
								<input type="checkbox" name='a[]' value="pork"> Pork <br/>
								<input type="checkbox" name='a[]' value="beef"> Beef <br/>

								<input type="submit" value="Submit" name="submit1">
							</form>

									<br><br>
						<!--</form>-->

								<form action="menu.php" method="post" id="cart">
									<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
									<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
									
									<br><br>

									<div align="left">
									<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
									<button type="submit" name="addtocart" value="<?php echo $roww['food_id'];?>")" >
									<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
									</div>
								</form>
								<br>
							</div>
					</div><!--Close the column-->

					<div class="col-md-4">
					<?php 
						$quer_res=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
							tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
							tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
							tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_id = 21 && tbfood.food_type='custom'"); 
						
						$roww=mysqli_fetch_array($quer_res);?>

						<!--<form name="classicsoup">-->
							<div class="panel panel-default">
								<div class="panel-heading text-center">
									<b><?php echo $roww['foodname'] ?></b>
								</div>	
								
								<div class="panel-body">
										<img src="image/restaurant/<?php echo $roww['fld_email']."/foodimages/".$roww['fldimage'];?>"  height="300px" width="100%">
								</div>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;">Price: $<?php echo $roww['cost']; ?></span>
								<br>
					
								<div style="text-align:center">
									<span style="font-family: 'Miriam Libre', sans-serif; font-size:23px;">Pick any 3 vegetables of your choice</span>
									<br>
									<span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight: bold;">Vegetables</span>
									<br>
									
									<div style="width:200px;border-radius:6px;margin:0px auto">  
									<table border="1">  
									   <tr>  
										  <td colspan="2">Choose Your Vegetables:</td>  
									   </tr>  
									   <tr>  
										  <td>Tomato</td>  
										  <td><input type="checkbox" name="veg[]" value="tomato"></td>  
									   </tr>  
									   <tr>  
										  <td>Brocolli</td>  
										  <td><input type="checkbox" name="veg[]" value="brocolli"></td>  
									   </tr>  
									   <tr>  
										  <td>Spinach</td>  
										  <td><input type="checkbox" name="veg[]" value="Spinach"></td>  
									   </tr>  
									   <tr>  
										  <td>Cabbage</td>  
										  <td><input type="checkbox" name="veg[]" value="cabbage"></td>  
									   </tr>  
									   <tr>  
										  <td colspan="2" align="center"><input type="submit" value="submit" name="submit"></td>
									   </tr>  
									</table>  
									</div>
								</div>

								<form method="post" action="">
								<span>Select Vegetables</span><br/>
								<input type="checkbox" name='b[]' value="brocolli"> Brocolli <br/>
								<input type="checkbox" name='b[]' value="spinach"> Spinach <br/>
								<input type="checkbox" name='b[]' value="mushroom"> Mushroom <br/>
								<input type="checkbox" name='b[]' value="cabbage"> Cabbage <br/>
								<input type="checkbox" name='b[]' value="tofu"> Tofu <br/>

								<input type="submit" value="Submit" name="submit2">
							</form>

									<br><br>
						<!--</form>-->

								<form action="menu.php" method="post" id="cart">
									<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
									<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
									<br><br>

									<div align="left">
									<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
									<button type="submit" name="addtocart" value="<?php echo $roww['food_id'];?>")" >
									<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
									</div>
								</form>
								<br>
							</div>
					</div><!--Close the second column-->

					<div class="col-md-4">
						<?php 
							$quer_res=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
							tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
							tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
							tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_id = 22 && tbfood.food_type='custom'"); 
							
							$roww=mysqli_fetch_array($quer_res);?>

						<!--<form name="breakfast">-->
							<div class="panel panel-default">
								<div class="panel-heading text-center">
									<b><?php echo $roww['foodname'] ?></b>
								</div>		
							
							<div class="panel-body">
										<img src="image/restaurant/<?php echo $roww['fld_email']."/foodimages/".$roww['fldimage'];?>"  height="300px" width="100%">
							</div>
							<br>
							<span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;">Price: $<?php echo $roww['cost']; ?></span>
							<br>
							<!--<div style="text-align:center">
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:23px;">Pick any 3 items of your choice</span>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight: bold;">Breakfast Items</span>
								<br>
								<input type="checkbox" name="sausage"
								onClick="return KeepBCount()"> 2 Sausages

								<input type="checkbox" name="baked"
								onClick="return KeepBCount()"> Baked Beans

								<input type="checkbox" name="egg"
								onClick="return KeepBCount()"> 2 Eggs

								<input type="checkbox" name="bacon"
								onClick="return KeepBCount()"> 2 Bacon Strips

								<input type="checkbox" name="hashbrown"
								onClick="return KeepBCount()"> 2 Hashbrowns
							</div>-->

							<form method="post" action="">
								<span>Select Breakfast Items</span><br/>
								<input type="checkbox" name='c[]' value="sausage"> 2 Sausages <br/>
								<input type="checkbox" name='c[]' value="baked"> Baked Beans <br/>
								<input type="checkbox" name='c[]' value="egg"> 2 Eggs <br/>
								<input type="checkbox" name='c[]' value="bacon"> 2 Bacon Strips <br/>

								<input type="submit" value="Submit" name="submit3">
							</form>

								<br><br>
						<!--</form>-->

							<form action="menu.php" method="post" id="cart">
								<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
								<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
									
								<br><br>

								<div align="left">
								<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
								<button type="submit" name="addtocart" value="<?php echo $roww['food_id'];?>")" >
								<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
								</div>
							</form>
							<br>
							</div>
					</div><!--Close 3rd column-->

					<div class="col-md-4">
						<?php 
							$quer_res=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
							tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
							tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
							tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_id = 28 && tbfood.food_type='custom'"); 
							
							$roww=mysqli_fetch_array($quer_res);?>

						<!--<form name="curry">-->
							<div class="panel panel-default">
								<div class="panel-heading text-center">
									<b><?php echo $roww['foodname'] ?></b>
								</div>		
							
							<div class="panel-body">
										<img src="image/restaurant/<?php echo $roww['fld_email']."/foodimages/".$roww['fldimage'];?>"  height="300px" width="100%">
							</div>
							<br>
							<span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;">Price: $<?php echo $roww['cost']; ?></span>
							<br>
							<!--<div style="text-align:center">
									<span style="font-family: 'Miriam Libre', sans-serif; font-size:23px;">Pick any 3 vegetable curry and 2 meat curry of your choice</span>
									<br>
									<span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight: bold;">Vegetable Curry</span>
									<br>
									<input type="checkbox" name="cabbage"
									onClick="return KeepCurryCount()"> Cabbage

									<input type="checkbox" name="paneer"
									onClick="return KeepCurryCount()"> Paneer

									<input type="checkbox" name="bhindi"
									onClick="return KeepCurryCount()"> Bhindi

									<input type="checkbox" name="aloo"
									onClick="return KeepCurryCount()"> Aloo Paneer

									<input type="checkbox" name="bean"
									onClick="return KeepCurryCount()"> Bean
					
									<input type="checkbox" name="aloom"
									onClick="return KeepCurryCount()"> Aloo Mattar
					
									<input type="checkbox" name="ghobi"
									onClick="return KeepCurryCount()"> Ghobi
								<br>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight:bold;">Meat Curry</span>
								<br>
									<input type="checkbox" name="chicken"
									onClick="return KeepCurryCount()"> Chicken Curry

									<input type="checkbox" name="lamb"
									onClick="return KeepCurryCount()"> Lamb Curry

									<input type="checkbox" name="goat"
									onClick="return KeepCurryCount()"> Goat Curry

									<input type="checkbox" name="duck"
									onClick="return KeepCurryCount()"> Duck Curry
								</div>-->

								<form method="post" action="">
								<span>Select Vegetarian Curries</span><br/>
								<input type="checkbox" name='d[]' value="paneer"> Paneer <br/>
								<input type="checkbox" name='d[]' value="aloo"> Aloo Paneer <br/>
								<input type="checkbox" name='d[]' value="aloom"> Aloo Mattar <br/>
								<input type="checkbox" name='d[]' value="bhindi"> Bhindi <br/>
								<span>Select Meat Curries</span><br/>
								<input type="checkbox" name='d[]' value="duck"> Duck Curry <br/>
								<input type="checkbox" name='d[]' value="lamb"> Lamb Curry <br/>
								<input type="checkbox" name='d[]' value="chicken"> Chicken Curry <br/>

								<input type="submit" value="Submit" name="submit4">
								</form>

								<br><br>
						<!--</form>-->

							<form action="menu.php" method="post" id="cart">
								<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
								<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
									
								<br><br>

								<div align="left">
								<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
								<button type="submit" name="addtocart" value="<?php echo $roww['food_id'];?>")" >
								<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
								</div>
							</form>
							<br>
							</div>
					</div><!--Close 3rd column-->
				</div><!--End row-->			
			</div><!--End content wrap-->

			<script language="javascript">

				function KeepCount() {
				var NewCount = 0

					if (document.soup.cabbage.checked)
					{NewCount = NewCount + 1}

					if (document.soup.potato.checked)
					{NewCount = NewCount + 1}

					if (document.soup.carrot.checked)
					{NewCount = NewCount + 1}

					if (document.soup.tomato.checked)
					{NewCount = NewCount + 1}

					if (document.soup.mushroom.checked)
					{NewCount = NewCount + 1}

					if (document.soup.brocolli.checked)
					{NewCount = NewCount + 1}

					if (document.soup.spinach.checked)
					{NewCount = NewCount + 1}
					
					if (NewCount == 4)
					{
					alert('Pick Just 3 options Please')
					document.soup; return false;
					}
				}

				function KeepMeatCount() {
				var NewCount = 0
					if (document.classicsoup.cabbage.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.potato.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.carrot.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.tomato.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.mushroom.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.brocolli.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.spinach.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.chicken.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.pork.checked)
					{NewCount = NewCount + 1}

					if (document.classicsoup.beef.checked)
					{NewCount = NewCount + 1}
					
					if (NewCount == 5)
					{
					alert('Pick Just 4 options Please')
					document.classicsoup; return false;
					}
				}

				function KeepBCount() {
				var NewCount = 0

					if (document.breakfast.sausage.checked)
					{NewCount = NewCount + 1}

					if (document.breakfast.baked.checked)
					{NewCount = NewCount + 1}

					if (document.breakfast.egg.checked)
					{NewCount = NewCount + 1}

					if (document.breakfast.bacon.checked)
					{NewCount = NewCount + 1}

					if (document.breakfast.hashbrown.checked)
					{NewCount = NewCount + 1}
					
					if (NewCount == 4)
					{
						alert('Pick Just 3 options Please')
						document.soup; return false;
					}
				}

				function KeepCurryCount() {
				var NewCount = 0
					if (document.curry.cabbage.checked)
					{NewCount = NewCount + 1}

					if (document.curry.paneer.checked)
					{NewCount = NewCount + 1}

					if (document.curry.bhindi.checked)
					{NewCount = NewCount + 1}

					if (document.curry.aloo.checked)
					{NewCount = NewCount + 1}

					if (document.curry.bean.checked)
					{NewCount = NewCount + 1}

					if (document.curry.aloom.checked)
					{NewCount = NewCount + 1}

					if (document.curry.ghobi.checked)
					{NewCount = NewCount + 1}

					if (document.curry.chicken.checked)
					{NewCount = NewCount + 1}

					if (document.curry.lamb.checked)
					{NewCount = NewCount + 1}

					if (document.curry.goat.checked)
					{NewCount = NewCount + 1}

					if (document.curry.duck.checked)
					{NewCount = NewCount + 1}
					
					if (NewCount == 6)
					{
					alert('Pick Just 5 options Please')
					document.curry; return false;
					}
				}
			</script>
		
		<footer id="footer">
			<?php
				include("footer.php");
			?>
		</footer>
	</div><!--Container Div ends-->  
	</body>
</html>