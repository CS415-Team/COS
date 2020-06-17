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

if(isset($addtocart))
{ 
	$query=mysqli_query($con,"select food_time from tbfood where food_id =$addtocart");
	while($res=mysqli_fetch_assoc($query))
	{
		if($_POST['foodqty'] == 0)
		{
			echo "<script> alert('Error: Cannot proceed to cart. Please enter a valid quantity [>0]');document.location='custom.php'</script>";
		}
		else
		{
			if(!empty($_SESSION['cust_id']) || !empty($_SESSION['staff_id']))
			{
				$c_ftime = $res['food_time'];
				$rows = mysqli_query($con,"select exists(select 1 from tblcart) as output;");
				while($val=mysqli_fetch_assoc($rows)) 
				{ 
					if($val['output'] != 1)//Cart is empty 
					{
						if ($_POST['a'])
						{
							
							$array = $_POST['a'];
							$in_choices = implode("," , $a);
							//echo $bleh;
								
							$cost = 0;
							foreach($array as $igredID => $a)
							{	
								$query3=mysqli_query($con,"select price from ingredient where ingred_id ='$igredID'");
								while($fetch_price=mysqli_fetch_assoc($query3)) 
								{
									$price = $fetch_price['price'];
									$cost+=$price;
								}
							}
							$_SESSION['qty'] = $_POST['foodqty'];
							header("location:form/cart.php?product=$addtocart&IngChoice=$in_choices&IngPrice=$cost");
							
						}		

					}
					else //Cart is not empty 
					{
						$query2=mysqli_query($con,"select food_time from tbfood inner join tblcart on tbfood.food_id=tblcart.fld_product_id");
						while($f_rec=mysqli_fetch_assoc($query2)) 
						{
							$foo_time = $f_rec['food_time'];
							if(($foo_time == $c_ftime))//Foodtime matches custom meal's foodtime 
							{			
								if ($_POST['a'])
								{
									$array = $_POST['a'];
									$in_choices = implode("," , $a);
								
									$cost = 0;
									foreach($array as $igredID => $a)
									{	
										$query3=mysqli_query($con,"select price from ingredient where ingred_id ='$igredID'");
										while($fetch_price=mysqli_fetch_assoc($query3)) 
										{
											$price = $fetch_price['price'];
											$cost+=$price;
										}
									}
							
									$_SESSION['qty'] = $_POST['foodqty'];
									header("location:form/cart.php?product=$addtocart&IngChoice=$in_choices&IngPrice=$cost");
	
								}	
							}
							else 
							{
								echo "<script> alert('Error: Cannot proceed to cart. Please select same meal time as items in cart for order');document.location='custom.php'</script>";
							}
						}
					}
				}
			}
		}
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

$query=mysqli_query($con,"select tbfood.foodname,tbfood.cost,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id 
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
     <title>Custom Meals</title>
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
		h3.breakfast-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h3.breakfast-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		/*Adjustment of lunch meal just for release 1*/
		/*Will not use after including breakfast and dinner */
		h3.lunch-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h3.lunch-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		h3.dinner-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h3.dinner-meal::before { 
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
					<!--Disabling search food for now (Added forward slash to php to comment it)
					</?php 	
					if(!empty($staff_id)|| !empty($cust_id))
					{ 
					?>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<form method="post">
									<input type="text" name="search_text" id="search_text" placeholder="Search by Food Name " class="form-control"/>
								</form>
								<div id="result" style="position:fixed; z-index: 3000;width:350px;background:white;"></div>
							</a>
						</li>
					</?php } ?>
					-->
				
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
						<a class="dropdown-item" href="custom.php">Custom</a>
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
		</header>
        <!--Header stuff ends-->

		<div style="position: relative;  min-height: 100vh;"><!--Container Div-->
			<div id="content-wrap" style="padding-bottom: 6rem;"><!-- all other page content -->
		
			<!--Menu Begins-->
				<!--Custom menu starts-->
				<div style="text-align:center; margin-top:110px">
					<h1 class="custom-menu" id="custom">Custom Menu</h1>
					<span style="color:red; font-size:20px;  width: 90%;  margin: 0 auto;  "> Eat Good. Feel Good.</span>
					<br>
					<span style="color:black; font-size:20px; "> You can build your own meal by choosing your favourite ingredients.</span>
				</div>
				
				<h3 class="breakfast-meal" id="lunch" align="center" >Breakfast Meals</h3>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<?php 
							$quer_res=mysqli_query($con,"select * from tbfood inner join restaurant on tbfood.res_name=restaurant.res_name where tbfood.food_time='breakfast' && tbfood.food_type='custom' && tbfood.display_status='1'"); 
							
							while($roww=mysqli_fetch_array($quer_res))
							{
								$food_id=$roww['food_id'];
							?>

							<div class="panel panel-default">
								<div class="panel-heading text-center">
									<b><?php echo $roww['foodname'] ?></b>
									<div style="text-align:center;">
										<b><span style="font-family: 'Miriam Libre', sans-serif; color:#CB202D;">(<?php echo $roww['res_name']; ?> Item)</span></b>
									</div>
								</div>
								
								<div class="panel-body">
									<img src="image/restaurant/<?php echo $roww['res_name'];?>/<?php echo $roww['fldimage'];?>" height="300px" width="100%">
								</div>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;">Price: $<?php echo $roww['cost']; ?></span>
								<br>

								<span style="color:black; font-size:20px;">Basic Items: <?php echo $roww['cuisines']; ?></span><br>
								<br>
													
								<form action="custom.php" method="post" id="cart">

									<div style="text-align:center">
									
										<u><span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight: bold;">Extra Available Items</span></u><br>
										<?php 
											$ingred_query=mysqli_query($con,"select * from ingredient where food_id='$food_id' && available='1'"); 
											
											while($item_row=mysqli_fetch_array($ingred_query))
											{
										?>
											<input type="checkbox" name="a[<?php echo $item_row['ingred_id'] ;?>]" value="<?php echo $item_row['ingred'] ;?>"><?php echo $item_row['ingred'];?> (+$<?php echo $item_row['price'];?>)<br/>
										<?php 
											} 
										?>
									
									</div>

									<span style="color:black; font-size:20px; font-weight: bold; ">Recipe:</span><br>
									<b><span style="text-align: justify; display:block; font-size:18px; font-family: 'Miriam Libre', sans-serif; color:#CB202D;"> <?php echo $roww['custom_recipe']; ?></span></b>
									<br>
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
						<?php } ?>
					</div><!--Close the column-->
				</div><!--End row-->	

				<h3 class="lunch-meal" id="lunch" align="center" >Lunch Meals</h3>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<?php 
							$quer_res=mysqli_query($con,"select * from tbfood inner join restaurant on tbfood.res_name=restaurant.res_name where tbfood.food_time='lunch' && tbfood.food_type='custom' && tbfood.display_status='1'"); 
							
							while($roww=mysqli_fetch_array($quer_res))
							{
								$food_id=$roww['food_id'];
							?>

							<div class="panel panel-default">
								<div class="panel-heading text-center">
									<b><?php echo $roww['foodname'] ?></b>
									<div style="text-align:center;">
										<b><span style="font-family: 'Miriam Libre', sans-serif; color:#CB202D;">(<?php echo $roww['res_name']; ?> Item)</span></b>
									</div>
								</div>
								
								<div class="panel-body">
									<img src="image/restaurant/<?php echo $roww['res_name'];?>/<?php echo $roww['fldimage'];?>" height="300px" width="100%">
								</div>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;">Price: $<?php echo $roww['cost']; ?></span>
								<br>

								<span style="color:black; font-size:20px;">Basic Items: <?php echo $roww['cuisines']; ?></span><br>
								<br>
													
								<form action="custom.php" method="post" id="cart">

									<div style="text-align:center">
									
										<u><span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight: bold;">Extra Available Items</span></u><br>
										<?php 
											$ingred_query=mysqli_query($con,"select * from ingredient where food_id='$food_id' && available='1'"); 
											
											while($item_row=mysqli_fetch_array($ingred_query))
											{
										?>
											<input type="checkbox" name="a[<?php echo $item_row['ingred_id'] ;?>]" value="<?php echo $item_row['ingred'] ;?>"><?php echo $item_row['ingred'];?> (+$<?php echo $item_row['price'];?>)<br/>
										<?php 
											} 
										?>
									
									</div>

									<span style="color:black; font-size:20px; font-weight: bold; ">Recipe:</span><br>
									<b><span style="text-align: justify; display:block; font-size:18px; font-family: 'Miriam Libre', sans-serif; color:#CB202D;"> <?php echo $roww['custom_recipe']; ?></span></b>
									<br>
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
						<?php } ?>
					</div><!--Close the column-->
				</div><!--End row-->	
				

				<h3 class="dinner-meal" id="lunch" align="center" >Dinner Meals</h3>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<?php 
							$quer_res=mysqli_query($con,"select * from tbfood inner join restaurant on tbfood.res_name=restaurant.res_name where tbfood.food_time='dinner' && tbfood.food_type='custom' && tbfood.display_status='1'"); 
							
							while($roww=mysqli_fetch_array($quer_res))
							{
								$food_id=$roww['food_id'];
							?>

							<div class="panel panel-default">
								<div class="panel-heading text-center">
									<b><?php echo $roww['foodname'] ?></b>
									<div style="text-align:center;">
										<b><span style="font-family: 'Miriam Libre', sans-serif; color:#CB202D;">(<?php echo $roww['res_name']; ?> Item)</span></b>
									</div>
								</div>
								
								<div class="panel-body">
									<img src="image/restaurant/<?php echo $roww['res_name'];?>/<?php echo $roww['fldimage'];?>" height="300px" width="100%">
								</div>
								<br>
								<span style="font-family: 'Miriam Libre', sans-serif; font-size:20px;color:#CB202D;">Price: $<?php echo $roww['cost']; ?></span>
								<br>

								<span style="color:black; font-size:20px;">Basic Items: <?php echo $roww['cuisines']; ?></span><br>
								<br>
													
								<form action="custom.php" method="post" id="cart">

									<div style="text-align:center">
									
										<u><span style="font-family: 'Miriam Libre', sans-serif; font-size:20px; font-weight: bold;">Extra Available Items</span></u><br>
										<?php 
											$ingred_query=mysqli_query($con,"select * from ingredient where food_id='$food_id' && available='1'"); 
											
											while($item_row=mysqli_fetch_array($ingred_query))
											{
										?>
												<input type="checkbox" name="a[<?php echo $item_row['ingred_id'] ;?>]" value="<?php echo $item_row['ingred'] ;?>"><?php echo $item_row['ingred'];?> (+$<?php echo $item_row['price'];?>)<br/><?php 
											} 
										?>
									
									</div>

									<span style="color:black; font-size:20px; font-weight: bold; ">Recipe:</span><br>
									<b><span style="text-align: justify; display:block; font-size:18px;font-family: 'Miriam Libre', sans-serif; color:#CB202D;"> <?php echo $roww['custom_recipe']; ?></span></b>
									<br>
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
						<?php } ?>
					</div><!--Close the column-->
				</div><!--End row-->	

			</div><!--End content wrap-->
		
		<footer id="footer">
			<?php
				include("footer.php");
			?>
		</footer>
	</div><!--Container Div ends-->  
	</body>
</html>