<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(isset($_SESSION['d_id']))
{
	$id=$_SESSION['d_id'];
	$dq=mysqli_query($con,"select * from tbl_deliverer where fld_email='$id'");
	$dr=mysqli_fetch_array($dq);
	$drid=$dr['deliverer_id'];
}
else
{
	header("location:deliverer_login.php?msg=Please Login To continue");
}

if(isset($logout))
{
	session_destroy();
	header("location:index.php");
}

if(isset($upd_account))
{
	if(mysqlI_query($con,"update tbl_deliverer set fld_name='$fn',fld_email='$emm',fld_address='$add',fld_mob='$mob',fld_password='$pwsd' where fld_email='$id'"))
	{
		header("location:deliverer_infoUpdate.php");
	}
}

if(isset($_POST['ConfirmDelivered']))
{
	$ord_id = $_POST['delivered'];
	if(mysqli_query($con,"update tblorder set fldstatus='Delivered' where fld_order_id='$ord_id'"))
	{
		header('refresh:1;url=deliverer_home.php');
	}
	else
	{
		echo "Couldn't set order status for deliverer";
	}
}
?>

<html>
<head>
  <title>View Delivery Items</title>
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
		<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php if(isset($id)) { echo $dr['fld_name']; }?></i></a>
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
				if(empty($_SESSION['d_id']))
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
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="home" aria-selected="true" style="color:#063344;font-weight:650;">Order Status</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="accountsettings-tab" data-toggle="tab" href="#accountsettings" role="tab" aria-controls="accountsettings" aria-selected="false" style="color:#063344;font-weight:650;">Account Settings</a>
					</li>
				</ul>
				<br><br>
				<span style="color:green;"><?php if(isset($msgs)) { echo $msgs; }?></span>
				<!--tab content starts-->   
				<div class="tab-content" id="myTabContent">
					<!--tab 1-- starts-->
					<div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
						<table id="table1" class="table">
						<tbody>
						<th>Order Id</th>
						<th>Staff Id</th>
						<th>Customer Email</th>
						<th>Food Ordered</th>
						<th>Quantity</th>
						<th>Restaurant</th>
						<th>Delivery Location</th>
						<th>Delivery Date</th>
						<th>Delivery Time</th>
						<th>Order Status</th>
						<th>Update Status</th>
						<?php
						$orderquery=mysqli_query($con,"select * from tblorder");
						if(mysqli_num_rows($orderquery))
						{
							while($orderrow=mysqli_fetch_array($orderquery))
							{
								if(!empty($orderrow['fld_email_id']) || !empty($orderrow['staff_id']))
								{
									$stat=$orderrow['fldstatus'];
									if($stat!="cancelled" && $stat!="Out Of Stock" && $stat!="Delivered")
									{
									?>
										<tr>
										<td><?php echo $orderrow['fld_order_id']; ?></td>
										<td><?php echo $orderrow['staff_id']; ?></td>
										<td><?php echo $orderrow['fld_email_id']; ?></td>

										<?php $f_id = $orderrow['fld_food_id'];
											$foodquery=mysqli_query($con,"select foodname from tbfood where food_id='$f_id'");
											while($foodrow=mysqli_fetch_array($foodquery))
											{
										?>
											<td><?php echo $foodrow['foodname']; ?></td>
										<?php } ?>		

										<td><?php echo $orderrow['res_name']; ?></td>
										<td><?php echo $orderrow['fld_product_quantity']; ?></td>
										<td><?php echo $orderrow['delivery_location']; ?></td>
										<td><?php echo $orderrow['delivery_date']; ?></td>
										<td><?php echo $orderrow['delivery_time']; ?></td>
										<td><span style="color:green;"><?php echo $orderrow['fldstatus']; ?></span></td>
						
										<form method="post">
											<td><button class="btn btn-danger" type="submit" name="ConfirmDelivered">Delivered</button></td>
											<input type="hidden" name="delivered" value="<?php echo $orderrow['fld_order_id']; ?>"/>
										</form>
										<tr>
									<?php
									}
								}
							}
						}
						?>
						</tbody>
						</table>
					</div><!--Tab 1 ends-->

					<!--tab 2-- starts-->
					<div class="tab-pane fade" id="accountsettings" role="tabpanel" aria-labelledby="accountsettings-tab">
						<form method="post" enctype="multipart/form-data">
							<?php
							$upd_info=mysqli_query($con,"select * from tbl_deliverer where fld_email='$id'");
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
					<!--tab 2-- Ends-->
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