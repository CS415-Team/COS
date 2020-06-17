<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(isset($_SESSION['id']))
{
	$id=$_SESSION['id'];
	$mq=mysqli_query($con,"select * from tblmanager where fld_email='$id'");
	$mr=mysqli_fetch_array($mq);
	$mrid=$mr['fldmanager_id'];
}
else
{
	header("location:manager_login.php?msg=Please Login To continue");
}

if(isset($add))
{ 
	if(isset($_SESSION['id']))
	{
		$img_name=$_FILES['food_pic']['name'];
		$stat=1;
		if(!empty($chk))
		{
			if($query=mysqli_query($con,"select * from tblmanager where fld_email ='$id'"))
			{
				if(mysqli_num_rows($query))
				{
					while($row=mysqli_fetch_array($query))
					{			
						$man_id = $row['fldmanager_id'];
						$rest_name= $row['res_name'];
						$fdt=implode(",",$chk);
						
						/*echo $rest_name;
						echo $stat;
						echo $food_name;
						echo $cost;
						echo $cuisines;
						echo $img_name;
						echo $fdt;
						echo $qty_avail;*/
						
						if(mysqli_query($con,"insert into tbfood(res_name,display_status,foodname,cost,cuisines,fldimage,food_time,qty_available,paymentmode,food_type,custom_recipe) values
						('$rest_name','$stat','$food_name','$cost','$cuisines','$img_name','$fdt','$qty_avail','COD','','')"))
						{

							move_uploaded_file($_FILES['food_pic']['tmp_name'],"image/restaurant/$rest_name/".$_FILES['food_pic']['name']);
							header("location:food.php");
						
						}
						else
						{
							echo "failed 2";
						}
					}
				}
				else
				{
					echo "failed";
				}
			}
			else
			{
				echo "failed to get manager info";
			}

		}
		else 
		{
			$foodmessage="please select a food time";
		}
	}
	else
	{
		header("location:manager_login.php");
	}
}


if(isset($add_custom))
{
	if(isset($_SESSION['id']))
	{
		$img_name1=$_FILES['cfood_pic']['name'];
		if($query=mysqli_query($con,"select * from tblmanager where fld_email ='$id'"))
		{
			if(mysqli_num_rows($query))
			{
				while($row=mysqli_fetch_array($query))
				{			
					$man_id = $row['fldmanager_id'];
					$rest_name=$row['res_name'];
					
					if(mysqli_query($con,"insert into tbfood(food_time,res_name,display_status,foodname,cost,cuisines,fldimage,qty_available,food_type,custom_recipe,paymentmode) values
					('$food_time','$rest_name','1','$CusFname','$CusPrice','$CusFc','$img_name1','100','custom','$CusR','COD')"))
					{
						move_uploaded_file($_FILES['cfood_pic']['tmp_name'],"image/restaurant/$rest_name/".$_FILES['cfood_pic']['name']);
						$query2=mysqli_query($con,"select food_id from tbfood where foodname='$CusFname'");
						while($ing_row=mysqli_fetch_array($query2))
						{
							$food_id=$ing_row['food_id'];
							if(count($_POST))
							{
								$len = count($_POST['ingred_name']);
								for ($i=0; $i < $len; $i++)
								{
									$ing_name = $_POST['ingred_name'][$i];
									$ing_type= $_POST['ingred_type'][$i];
									$ing_price=$_POST['ingred_price'][$i];
									$meal_type=$_POST['meal_type'][$i];

									if(mysqli_query($con,"insert into ingredient(ingred,ingred_type,meal_type,price,available,food_id) values
									('$ing_name','$ing_type','$meal_type','$ing_price','1','$food_id')"))
									{
										header("location:food.php");
									}
									else
									{
										echo "failed to insert into ingredient table";
									}
								}
							}
						}
					}
					else
					{
						echo "failed 2";
					}
				}
			}
			else
			{
				echo "failed 1";
			}
		}
		else
		{
			echo "failed to get manager info";
		}

	}
	else
	{
		header("location:manager_login.php");
	}
}

if(isset($logout))
{
	session_destroy();
	header("location:index.php");
}

if(isset($upd_account))
{
	//echo $fn;
	//echo $emm;
	//echo $add;
	if(mysqlI_query($con,"update tblmanager set fld_name='$fn',fld_email='$emm',fld_address='$add',fld_mob='$mob',fld_password='$pwsd' where fld_email='$id'"))
	{
		header("location:infoUpdate.php");
	}
}

/*
if(isset($upd_logo))
{
	if(isset($_SESSION['id']))
	{
		$log_img=mysqli_query($con,"select * from tblmanager where fld_email='$id'");
		$log_img_row=mysqli_fetch_array($log_img);
		$old_logo=$log_img_row['fld_logo'];
		$new_img_name=$_FILES['logo_pic']['name'];
		
		if(mysqli_query($con,"update tblmanager set fld_logo='$new_img_name' where fld_email='$id'"))
		{
			unlink("image/restaurant/$id/$old_logo");
			move_uploaded_file($_FILES['logo_pic']['tmp_name'],"image/restaurant/$id/".$_FILES['logo_pic']['name']);
			
			header("location:update_food.php");
			
		}
	}
	else
	{
		header("location:manager_login.php?msg=Please Login To continue");
	}
}*/
			  
if(isset($_POST['changeDisplayHide']))
{
	$f_id = $_POST['hide'];
	if(mysqli_query($con,"update tbfood set display_status='0' where food_id='$f_id'"))
	{
		header('refresh:1;url=food.php');
	}
	else
	{
		echo "Couldn't set hide";
	}
}

if(isset($_POST['changeDisplayShow']))
{
	$f_id = $_POST['show'];
	if(mysqli_query($con,"update tbfood set display_status='1' where food_id='$f_id'"))
	{
		header('refresh:1;url=food.php');
	}
	else
	{
		echo "Couldn't set show";
	}
}

if(isset($_POST['IngStatUnavail']))
{
	$ing_name = $_POST['hide_ing'];
	if(mysqli_query($con,"update ingredient set available='0' where ingred='$ing_name'"))
	{
		//header('refresh:1;url=food.php');
		header("refresh:1;location:food.php");
	}
	else
	{
		echo "Couldn't set hide";
	}
}

if(isset($_POST['IngStatAvail']))
{
	$ing_name = $_POST['show_ing'];
	if(mysqli_query($con,"update ingredient set available='1' where ingred='$ing_name'"))
	{
		//header('refresh:1;url=food.php');
		header("refresh:1;location:food.php");
	}
	else
	{
		echo "Couldn't set show";
	}
}


?>

<html>
<head>
  <title>Manager Portal</title>
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
		ul li{list-style:none;}
		ul li a {color:black;text-decoration:none; }
		ul li a:hover {color:black;text-decoration:none; }

		#footer {
			position: absolute;
			bottom: 0;
			width: 100%;
			height: 6rem;/* Footer height */
		}

	/* 
	This query will take effect for any screen smaller than 760px
	and also iPads specifically.
	*/
	@media 
	only screen and (max-device-width: 768px),	(min-device-width: 768px) and (max-device-width: 1024px)  
	{
		#table1 { 
			display: block; 
			overflow:scroll;
			max-width:100%;
		}
	}
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
		<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php if(isset($id)) { echo $mr['fld_name']; }?></i></a>
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

			<li class="nav-item dropright">
				<a class="nav-link dropdown-toggle" style="color:#063344;font-weight:650" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
	<!--navbar ends-->

	<br><br>
	<div style="position: relative;  min-height: 100vh;"><!--Container Div-->
		<div id="content-wrap" style="padding-bottom: 6rem;"><!-- all other page content -->
			<div class="middle" style=" padding:40px; border:0px solid #0197A5;  width:100%; margin-top:50px;">
				<!--tab heading-->
				<ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="home" aria-selected="true" style="color:#063344;font-weight:650;">Manage Products</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="product-tab" data-toggle="tab" href="#addproduct" role="tab" aria-controls="product" aria-selected="false" style="color:#063344;font-weight:650;">Add Products</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tab" data-toggle="tab" href="#addcustom" role="tab" aria-controls="custom" aria-selected="false" style="color:#063344;font-weight:650;"> Add Custom Meal</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="accountsettings-tab" data-toggle="tab" href="#accountsettings" role="tab" aria-controls="accountsettings" aria-selected="false" style="color:#063344;font-weight:650;">Account Settings</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false" style="color:#063344;font-weight:650;">Order Status</a>
					</li>
				</ul>
				<br><br>
				<span style="color:green;"><?php if(isset($msgs)) { echo $msgs; }?></span>
				<!--tab content starts-->   
				<div class="tab-content" id="myTabContent">
					<!--tab 1 starts-->   
					<div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
						<div class="container"> 
							<table id="table1" border="1" bordercolor="#F0F0F0" cellpadding="20px">
							<th><!--food Image--></th>
							<th>Item</th>
							<th>Price($)</th>
							<th>Cuisine </th>
							<th>Meal Type </th>
							<!-- <th>Payment Mode  </th>-->
							<th style="text-align:center;">Quantity Available</th>
							<th style="text-align:center;">Display Status</th>
							<th style="text-align:center;">Hide/Show Item</th>
							<th style="text-align:center;">Update Item</th>
							<th style="text-align:center;">Delete Item</th>
							
							<?php			
							$manager_query=mysqli_query($con,"select * from tblmanager where fld_email='$id'");
							$man_id_row=mysqli_fetch_array($manager_query);
							$manager_id = $man_id_row['fldmanager_id'];
							$r_name = $man_id_row['res_name'];

							if($query=mysqli_query($con,"select * from tbfood where tbfood.res_name='$r_name'"))
							{
								if(mysqli_num_rows($query))
								{
									while($row=mysqli_fetch_array($query))
									{
									?>
										<tr>
											<td><img src="image/restaurant/<?php echo $man_id_row['res_name']; ?>/<?php echo $row['fldimage'];?>" height="100px" width="150px">
											<td style="width:150px;"><?php  echo $row['foodname']."<br>";?></td>
											<td style="text-align:center; width:150px;"><?php  echo $row['cost']."<br>";?></td>
											<td style="text-align:center; width:150px;"><?php  echo $row['cuisines']."<br>";?></td>
											<td style="text-align:center; width:150px;"><?php echo $row['food_time']."<br>"; ?></td>
											<td style="text-align:center; width:150px;"><?php echo $row['qty_available']."<br>"; ?></td>
											<!--<td align="center" style="width:150px;"></?php  echo $row['paymentmode']."<br>";?></td>-->
											<?php 
											if($row['display_status'] == 1) 
											{
											?>
												<td style="text-align:center; width:150px;">Show</td>
												<td style="text-align:center; width:150px;">
													<form method="post">
														<button class="btn btn-primary" type="submit" name="changeDisplayHide">Hide</button>
														<input type="hidden" name="hide" value="<?php echo $row['food_id'];?>"/>
													</form>
												</td>	
												<?php 
											}
											else
											{
												?>
												<td style="text-align:center; width:150px;">Hidden</td>
												<td style="text-align:center; width:150px;">
													<form method="post">
														<button class="btn btn-success" type="submit" name="changeDisplayShow">Show</button>
														<input type="hidden" name="show" value="<?php echo $row['food_id'];?>"/>
													</form>
												</td>	
												<?php 
											} 
											?>
											
											<td style="text-align:center; width:150px;">
												<a href="update.php?food_id=<?php echo $row['food_id'];?>&res_name=<?php echo $man_id_row['res_name'];?>"><button type="button" class="btn btn-warning">Update </button></a>
											</td>
											<td style="text-align:center; width:150px;">
												<a href="manager_delete_food.php?food_id=<?php echo $row['food_id'];?>"><button type="button" class="btn btn-danger">Delete </button></a>
											</td>
										</tr>
										<?php 
									
										$foodname="";
										$cuisines="";
										$cost="";					
										$qty_avail="";
									}
								}
								else 
								{
									$msg="please add some Items";
								}
							}
							else 
							{
								echo "failed";
							}
							?>		
							</table>
						</div>    	 
					</div>
					<!--tab 1 ends-->	   

					<!--tab 2 starts
					<div class="tab-pane fade" id="manageingred" role="tabpanel" aria-labelledby="ingred-tab">
						<div class="form-group">
							<table id="table1" border="1" bordercolor="#F0F0F0" style="margin-left:auto;margin-right:auto;text-align:center;" cellpadding="20px">
								<th>Ingredients</th>
								<th>Type</th>
								<th>Meal Type</th>
								<th>Availability Status</th>
								<th>Change Status</th>

								</?php 
								/*$query2=mysqli_query($con,"select * from ingredient 
															inner join custom on ingredient.ingred_id=custom.ingred_id
															where ingredient.meal_type='thali'");*/
								$query2=mysqli_query($con,"select * from ingredient where meal_type='soup' || meal_type='thali'");

								while($ing_row=mysqli_fetch_array($query2))
								{
									/*$manager_query=mysqli_query($con,"select fldmanager_id from tblmanager where fld_email='$id'");
									$man_id_row=mysqli_fetch_array($manager_query);
									$manager_id = $man_id_row['fldmanager_id'];
									if($ing_row['fldmanager_id'] == $manager_id)*/
									{
								?>
										<tr>
											<td></?php echo $ing_row['ingred']; ?></td>
											<td></?php echo $ing_row['ingred_type']; ?></td>
											<td></?php echo $ing_row['meal_type']; ?></td>
											<td></?php if($ing_row['available']==1) echo 'Available'; else echo 'Not Available'; ?></td>
											</?php if($ing_row['available']==1)
											{
											?>
												<td style="text-align:center; width:150px;">
													<form method="post">
														<button class="btn btn-danger" type="submit" name="IngStatUnavail">Unavailable</button>
														<input type="hidden" name="hide_ing" value="</?php echo $ing_row['ingred'];?>"/>
													</form>
												</td>	
											</?php 
											}
											else
											{
											?>
												<td style="text-align:center; width:150px;">
													<form method="post">
														<button class="btn btn-success" type="submit" name="IngStatAvail">Available</button>
														<input type="hidden" name="show_ing" value="</?php echo $ing_row['ingred'];?>"/>
													</form>
												</td>	
											</?php 
											}?>
										</tr>
							 </?php } ?>
						  </?php } ?>

							</table>
						</div>		
					</div>
					<-!--tab 2 ends-->
	
					<!--tab 2 starts-->
					<div class="tab-pane fade" id="addproduct" role="tabpanel" aria-labelledby="product-tab">
					<!--add Product-->
						<form action="" method="post" enctype="multipart/form-data">
							<div class="form-group"><!--food_name-->
							<label for="food_name">Food Name:</label>
									<input type="text" class="form-control" id="food_name" value="" placeholder="Enter Food Name" name="food_name" required>
							</div>
							
							<div class="form-group"><!--cost-->
									<label for="cost">Cost :</label>
									<input type="number" class="form-control" id="cost"  value="" placeholder="0" name="cost" required>
							</div>

							<div class="form-group"><!--Quantity Available-->
									<label for="cost">Quantity Available :</label>
									<input type="number" class="form-control" id="qty_avail"  value="" placeholder="0" name="qty_avail" required>
							</div>	 
							
							<div class="form-group"><!--cuisines-->
									<label for="cuisines">Cuisines :</label>
									<input type="text" class="form-control" id="cuisines" value="" placeholder="Enter Description" name="cuisines" required>
							</div>
							<!--
							<div class="form-group">
								<input type="checkbox" name="chk[]" value="COD"/>Cash On Delivery
								<input type="checkbox" name="chk[]" value="Online Payment"/>Online Payment
								<br>
								<span style="color:red;"></?php if(isset($paymessage)){ echo $paymessage;}?></span>
							</div>
							-->
							<div class="form-group"><!--foodtype-->
								<input type="checkbox" name="chk[]" value="breakfast"/>Breakfast
								<input type="checkbox" name="chk[]" value="lunch"/>Lunch
								<input type="checkbox" name="chk[]" value="dinner"/>Dinner
								<br>
								<span style="color:red;"><?php if(isset($foodmessage)){ echo $foodmessage;}?></span>
							</div>

							<div class="form-group">
								<input type="file" accept="image/*" name="food_pic" required/>Food Snaps 
							</div>

							<button type="submit" name="add" class="btn btn-primary">Add Meal</button>
							<br>
							<span style="color:red;"><?php if (isset($msg)){ echo $msg;}?></span>
						</form>			
					</div>
					<!--tab 2 ends-->

					<!--tab 3 starts-->
					<!--add custom meal-->
					<div class="tab-pane fade" id="addcustom" role="tabpanel" aria-labelledby="custom-tab">
						<form id="custom_form" action="" method="post" enctype="multipart/form-data">
							<div class="form-group"><!--food_name-->
								<label for="food_name">Food Name:</label>
								<input type="text" class="form-control" id="CusFname" value="" placeholder="Enter Food Name" name="CusFname">
							</div>

							<div class="form-group"><!--Meal Type-->
								<label for="Meal Type">Meal Type:</label> 
								<select id="food_time" name="food_time">
									<option disabled selected value=" "> Meal Type</option>
									<option value="breakfast">Breakfast</option>
									<option value="lunch">Lunch</option>
									<option value="dinner">Dinner</option>
								</select>
							</div>

							<div class="form-group"><!--Item Price-->
									<label for="cusprice">Price :</label>
									<input type="number" class="form-control" id="cusprice"  value="" placeholder="0" name="CusPrice">
							</div>	

							<div class="form-group"><!--cuisines-->
									<label for="cuisines">Cuisines :</label>
									<input type="text" class="form-control" id="cuisines" value="" placeholder="Enter Description" name="CusFc" required>
							</div>

							<div class="form-group"><!--recipe-->
								<label for="recipe">Recipe :</label>
								<textarea rows="4" cols="50" class="form-control" id="recipe" name="CusR" required></textarea>
							</div>

							<div class="form-group"><!--Image-->
								<label for="food_name">Food Image:</label><br>
								<input type="file" accept="image/*" name="cfood_pic" required/>
							</div>

							<div style="text-align:center;"><u><span style="font-weight:bold; font-size:20px;">Meal Ingredients</span></u></div>

							<div id="ingredient_add">	
								<span id="ing-label" style="font-weight:bold;">New Ingredient</span>	
								<div class="form-group"><!--ingred_name-->
									<label for="ingredient_name">Ingredient Name:</label>
									<input type="text" class="form-control" id="ingred_name" value="" placeholder="Enter ingredient name" name="ingred_name[]">
								</div>
								
								<div class="form-group"><!--Ingredient Type-->
								<label for="ingred_type">Ingredient Type :</label>
								<input type="text" class="form-control" id="ingred_type"  value="" placeholder="E.g. meat" name="ingred_type[]">
								</div>
								
								<div class="form-group"><!--Meal Type-->
								<label for="meal_type">Meal Type :</label>
								<input type="text" class="form-control" id="meal_type"  value="" placeholder="E.g. soup or thali(what kind of custom meal item it is for)" name="meal_type[]">
								</div>


								<div class="form-group"><!--Ingred Price-->
									<label for="price">Price :</label>
									<input type="number" class="form-control" id="price"  value="" placeholder="0" name="ingred_price[]">
								</div>	
							</div>
							<div id="writefield"></div>
						</form>      	 

						<button onclick="moreFields()" class="btn btn-info" id="moreFields">Add Another Ingredient</button>
						<button type="submit" name="add_custom" form="custom_form" class="btn btn-primary">Add Meal</button>
						<button onclick="window.location.href='food.php'" type="button" name="back" class="btn btn-danger btn-primary">Go Back</button>
					</div>
					<!--tab 3 ends-->
					<!-- Script for custom (add ingredients)-->
					<script>
					var counter = 0;
					function moreFields() 
					{
						counter++;
						var newFields = document.createElement('div');
						newFields.id = counter;
						var delFields = '<input type="button" style="font-size:14px;" value="Remove New Field" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" /><br>';
						newFields.innerHTML = delFields + document.getElementById('ingredient_add').innerHTML;
						document.getElementById('writefield').append(newFields);

					}
					</script>
				
					<!--tab 4-- starts-->
					<div class="tab-pane fade" id="accountsettings" role="tabpanel" aria-labelledby="accountsettings-tab">
						<form method="post" enctype="multipart/form-data">
							<?php
							$upd_info=mysqli_query($con,"select * from tblmanager where fld_email='$id'");
							$upd_info_row=mysqlI_fetch_array($upd_info);
							$nm=$upd_info_row['fld_name'];
							$emm=$upd_info_row['fld_email'];
							$ad=$upd_info_row['fld_address'];
							$mb=$upd_info_row['fld_mob'];
							$psd=$upd_info_row['fld_password'];
							
							?>
							
							<div class="form-group">
							<label for="name">Name</label>
							<input type="text" id="username" value="<?php if(isset($nm)){ echo $nm;}?>" class="form-control" name="fn" />
							</div>
							<div class="form-group">
							<label for="email">Email</label>
							<input type="text" id="email" value="<?php if(isset($emm)){ echo $emm;}?>" class="form-control" name="emm" readonly="readonly"/>
							</div>
							<div class="form-group">
							<label for="address">Address</label>
							<input type="text" id="address" value="<?php if(isset($ad)){ echo $ad;}?>" class="form-control" name="add" required/>
							</div>
							<div class="form-group">
							<label for="mobile">Contact</label>
							<input type="text" id="mobile" pattern="[6-9]{1}[0-9]{9}" value="<?php if(isset($mb)){ echo $mb;}?>" class="form-control" name="mob" required/>
							</div>
								
							<div class="form-group">
								<label for="pwd">Password:</label>
								<input type="password" name="pwsd" class="form-control" value="<?php if(isset($psd)){ echo $psd;}?>" id="pwd" required/>
							</div>
							
							<button type="submit" name="upd_account" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
						</form>
					</div>
					<!--tab 4-- Ends-->
				

					<!--tab 5-- starts-->
					<div class="tab-pane fade " id="status" role="tabpanel" aria-labelledby="status-tab">
						<table id="table1" class="table">
						<tbody>
						<th>Order Id</th>
						<th>Customer Email</th>
						<th>Staff Id</th>
						<th>Food Ordered</th>
						<th>Quantity</th>
						<th>Delivery Location</th>
						<th>Delivery Date</th>
						<th>Delivery Time</th>
						<th>Order Status</th>
						<th>Update Status</th>
						<?php
						$res_query=mysqli_query($con,"select res_name from tblmanager where fld_email='$id'");
						$res_nm_row=mysqli_fetch_array($res_query);
						$res_name = $res_nm_row['res_name'];
						$orderquery=mysqli_query($con,"select * from tblorder where res_name='$res_name'");
						if(mysqli_num_rows($orderquery))
						{
							while($orderrow=mysqli_fetch_array($orderquery))
							{
								$stat=$orderrow['fldstatus'];
								?>
								<tr>
								<td><?php echo $orderrow['fld_order_id']; ?></td>
								<td><?php echo $orderrow['fld_email_id']; ?></td>
								<td><?php echo $orderrow['staff_id']; ?></td>

								<?php $f_id = $orderrow['fld_food_id'];
									$foodquery=mysqli_query($con,"select foodname from tbfood where food_id='$f_id'");
									while($foodrow=mysqli_fetch_array($foodquery))
									{
								?>
									<td><?php echo $foodrow['foodname']; ?></td>
								<?php } ?>		

								<td><?php echo $orderrow['fld_product_quantity']; ?></td>
								<td><?php echo $orderrow['delivery_location']; ?></td>
								<td><?php echo $orderrow['delivery_date']; ?></td>
								<td><?php echo $orderrow['delivery_time']; ?></td>


								<?php
								if($stat=="cancelled" || $stat=="Out Of Stock")
								{
								?>
									<td><i style="color:orange;" class="fas fa-exclamation-triangle"></i>&nbsp;<span style="color:red;"><?php echo $orderrow['fldstatus']; ?></span></td>
								<?php
								}
								else
								{
								?>
									<td><span style="color:green;"><?php echo $orderrow['fldstatus']; ?></span></td>
								<?php
								}
								?>
								<form method="post">
								<td><a href="changestatus.php?order_id=<?php echo $orderrow['fld_order_id']; ?>"><button type="button" name="changestatus">Update Status</button></a></td>
								</form>
								<tr>
								<?php
							}
						}
						?>
						</tbody>
						</table>
					</div><!--Tab 5 ends-->
				</div><!--Tab content ends-->
			</div><!--Middle div-->
		</div> <!--Page content ends-->
		<footer id="footer">
			<?php
				include("footer.php");
			?>
		</footer>
	</div><!--Container Div ends-->  
</body>
</html>