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
tbfood.paymentmode from tblvendor inner join tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id;");
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
		$_SESSION['qty'] = $_POST['foodqty'];
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
				else
					{
					$('#result').html(data);			
					}
				});
				});
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

	</style>

</head>
	<body>
		<header>
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
					<!-- Commenting hotel search for now 
					<li class="nav-item">
						<a href="#" class="nav-link"><form method="post"><input type="text" name="search_hotel" id="search_hotel" placeholder="Search Hotels " class="form-control " /></form></a>
					</li>
					-->

					<li class="nav-item">
						<a href="#" class="nav-link"><form method="post"><input type="text" name="search_text" id="search_text" placeholder="Search by Food Name " class="form-control " /></form></a>
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
						<a class="dropdown-item" href="menu.php">All</a>
						</div>
					</li>


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

		<!--Menu Begins-->
		<!--Breakfast meals
		<h1 class="breakfast-meal" id="breakfast" align="center" >Breakfast Meals</h1>
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading text-center">
						<b>Food something</b>
					</div>
					<div class="panel-body">
						<img src="img/istockphoto-516324258-612x612.jpg" height="300px" width="100%">
					</div>
					<form method="post">
					<div class="col-sm-2" style="text-align:left;padding:10px; font-size:25px;"><button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" ><span style="color:green;" <i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button></div>
					<form>
				</div>			
			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading text-center">
						<b>Food something</b>
					</div>
					<div class="panel-body">
						<img src="img/istockphoto-516324258-612x612.jpg" height="300px" width="100%">
					</div>
					<form method="post">
					<div class="col-sm-2" style="text-align:left;padding:10px; font-size:25px;"><button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" ><span style="color:green;" <i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button></div>
					<form>

				</div>			
			</div>
		</div>
		-->
		<!--Breakfast meals end-->`

		<!--Lunch meals-->
		<h1 class="lunch-meal" id="lunch" align="center" >Lunch Meals</h1>
		<div class="row">
		<?php
			$query=mysqli_query($con,"select tblvendor.fld_email,tblvendor.fld_name,tblvendor.fld_mob,
			tblvendor.fld_phone,tblvendor.fld_address,tblvendor.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
			tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage from tblvendor inner join
			tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id where tbfood.fldvendor_id=tblvendor.fldvendor_id");

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
							<span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;"><?php echo $res['fld_name']; ?></span>
							<br>
							<span style="color:black; font-size:20px; white-space:nowrap;">Price: $<?php echo $res['cost']; ?></span>
							<br>
							
							<form action="menu.php" method="post" id="cart">
								<span style="color:black; font-size:20px; white-space:nowrap;">Quantity: 
								<input type="number" id="foodqty" name="foodqty" min="0" max="20" step="1" value="0" style="font-size:20px;"></span>
							
								<br><br>

								<div align="right">
								<span style="color:black; font-size:20px; white-space:nowrap;">Add to cart: </span>
								<button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" >
								<span style="color:green; font-size:25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
								</div>
							</form>
						</div>			
					</div>
				
			<?php } ?>
		</div>
		<!--Lunch meals end-->

		<!--Dinner meals-->
		<!--Dinner meals end-->

		<!--footer primary-->	     
		<?php include("footer.php"); ?>		
	</body>
</html>