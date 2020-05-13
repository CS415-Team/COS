<?php
session_start();

extract($_REQUEST);
include("../connection.php");
$gtotal=array();
$ar=array();
$total=0;
if(isset($_GET['product']))//product id
{
	$product_id=$_GET['product'];
}
else
{
	$product_id="";
}

if(isset($_SESSION['cust_id']))
{
	$cust_id=$_SESSION['cust_id'];
	$qq=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	$qqr= mysqli_fetch_array($qq);
	$staff_id="";
	$loc="";
	$pay="";
	$del_date="";
	$del_time="";
}
else if(isset($_SESSION['staff_id']))
{
	$staff_id=$_SESSION['staff_id'];
	$qq=mysqli_query($con,"select * from tblstaff where staff_id='$staff_id'");
	$qqr= mysqli_fetch_array($qq);
	$cust_id="";
	$loc="";
	$pay="";
	$del_date="";
	$del_time="";
}

if(isset($_POST['deliv']) && isset($_POST['payment']))
{
	$loc = $_POST['deliv'];
	$pay = $_POST['payment'];
}

if(isset($_POST['delivery_date']) && isset($_POST['delivery_time']))
{
	$del_date = $_POST['delivery_date'];
	$del_time = $_POST['delivery_time'];
}

if(isset($_POST['owner']) && isset($_POST['cvv']) && isset($_POST['cardNumber']) && isset($_POST['month']) 
&& isset($_POST['year']))
{
	$owner = $_POST['owner'];
	$cvv = $_POST['cvv'];
	$cardNumber = $_POST['cardNumber'];
	$month = $_POST['month'];
	$year = $_POST['year'];	
}

if(empty($cust_id) && empty($staff_id))
{
	header("location:index.php?msg=You must login first");
}

if(!empty($product_id && $cust_id) || !empty($product_id && $staff_id))
{
	$qty = $_SESSION['qty'];
	//$br = $_SESSION['br'];

	if(mysqli_query($con,"insert into tblcart (fld_product_id,fld_customer_id, fld_staff_id, fld_product_quantity) 
						values ('$product_id','$cust_id','$staff_id' ,'$qty') "))
	{
		$query=mysqli_query($con,"select qty_available from tbfood where food_id ='$product_id'");
		while($res=mysqli_fetch_assoc($query))
		{
			$q_avail = $res['qty_available'];
			$new_q_avail = $q_avail - $qty;

			if(mysqli_query($con, "update tbfood set qty_available='$new_q_avail' where food_id='$product_id'"))
			{}
			else 
			{
				echo "failed to modify quantity available";
			}
		}
		echo "success";
		$product_id="";
		//$prod_qty="";
		header("location:cart.php");
	}
	else
	{
		echo "failed";
	}
}


if(isset($del))
{	
	$query=mysqli_query($con,"select fld_product_id, fld_product_quantity from tblcart where fld_cart_id='$del'");
	while($res=mysqli_fetch_assoc($query))
	{
		$quantity = $res['fld_product_quantity'];
		$p_id = $res['fld_product_id'];

		$query1=mysqli_query($con,"select qty_available from tbfood where food_id ='$p_id'");
		while($res1=mysqli_fetch_assoc($query1))
		{
			$q_avail = $res1['qty_available'];
			$new_q_avail = $q_avail + $quantity;
	
			if(mysqli_query($con, "update tbfood set qty_available='$new_q_avail' where food_id='$p_id'"))
			{}
			else 
			{
				echo "failed to modify quantity available";
			}
		}
	}

	//echo $del;
	if(mysqli_query($con,"delete from tblcart where fld_cart_id='$del' && fld_customer_id='$cust_id' && fld_staff_id='$staff_id'"))
	{
		header("location:deletecart.php");
	}	

}
  
 if(isset($logout))
 {
	 session_destroy();
	 
	 header("location:../index.php");
 }
 if(isset($login))
 {
	 session_destroy();
	 
	 header("location:index.php");
 }
 
 //update section
  $cust_details=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
  $det_res=mysqli_fetch_array($cust_details);
  $fld_name=$det_res['fld_name'];
  $fld_email=$det_res['fld_email'];
  $fld_mobile=$det_res['fld_mobile'];
  $fld_password=$det_res['password'];
  
  $staff_details=mysqli_query($con,"select * from tblstaff where staff_id='$staff_id'");
  $det_res1=mysqli_fetch_array($staff_details);
  $staff_name=$det_res1['staff_name'];
  $staff_email=$det_res1['staff_email'];
  $staff_mobile=$det_res1['staff_mobile'];
  $staff_password=$det_res1['staff_password'];
 
  if(isset($update))
  {
	   
	 if(mysqli_query($con,"update tblcustomer set fld_name='$name',fld_mobile='$mobile',password='$pswd' 
	 					   where fld_email='$fld_email'"))
      {
	   header("location:customerupdate.php");
	  }
  }
  else if(isset($update1))
  {
	  if(mysqli_query($con,"update tblstaff set staff_name='$name',staff_mobile='$mobile',staff_password='$pswd', staff_email='$email'
							  where staff_id='$staff_id'"))
		{
			header("location:customerupdate.php");			
		}
  }

  
  $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldmanager_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id 
							  from tbfood inner join tblcart on tbfood.food_id=tblcart.fld_product_id 
							  where tblcart.fld_customer_id='$cust_id'
							  OR tblcart.fld_staff_id='$staff_id'
							  ");
  $re=mysqli_num_rows($query);
  
?>

<html>
<head>
  <title>Cart </title>
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
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			#table1 { 
				display: block; 
				overflow:scroll;
				max-width:100%;
			}
		}
	 </style>
	
	<script>
		function del(id)
		{
			if(confirm('are you sure you want to cancel order')== true)
			{
				window.location.href='cancelorder.php?id=' +id;
			}
		}
	</script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #0197A5;">
  
		<a class="navbar-brand" href="../index.php"><img src="../img/USP Logo.png" style="display: inline-block;"></a>
			<a class="navbar-brand" href="../index.php"><span style="color:white;font-family: 'Permanent Marker', cursive;font-size:22pt;">NaBukDiSh</span>
			<span style="color:white;font-family:'Permanent Marker', cursive;font-size:18pt;">&copy</span>
			<br>
			<span style="color:white;font-family: 'Permanent Marker', cursive;font-size:12pt;">Food Ordering System</span>
		</a>

		<?php
		if(!empty($cust_id))
		{
		?>
			<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php if(isset($cust_id)) { echo $qqr['fld_name']; }?></i></a>
		<?php
		}
		?>

		<?php
		if(!empty($staff_id))
		{
		?>
			<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php if(isset($staff_id)) { echo $qqr['staff_name']; }?></i></a>
		<?php
		}
		?>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
		
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
			<a class="nav-link" href="../index.php" style="color:black;font-weight:700">Home</a>
			</li>
			<li class="nav-item dropright">
				<a class="nav-link dropdown-toggle" href="#" style="color:#063344;font-weight:650" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Menus
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="border:1px solid black;">
				<div class="dropdown-header" align="center" 
					style="background-color:#0197A5; color:white; font-family: 'Times New Roman'; font-style:italic; font-weight:bold;">
					MEAL TYPE
				</div>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="../menu.php#breakfast">Breakfast Specials</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="../menu.php#lunch">Lunch Specials</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="../menu.php#dinner">Dinner Specials</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="../menu.php">All</a>
				</div>
			</li>
			<?php 

				if(isset($_SESSION['staff_id']))

				{ ?>
					<li class="nav-item">
					<a class="nav-link" href="subscription.php"style="color:#063344;font-weight:650">Subscription</a>
					</li>
				<?php
				}

			?>
			<li class="nav-item">
			<a class="nav-link" href="../aboutus.php" style="color:#063344;font-weight:650">About</a>
			</li>

			<li class="nav-item">
			<a class="nav-link" href="../contact.php" style="color:#063344;font-weight:650">Contact</a>
			</li>
			
			<li class="nav-item">
			<form method="post">
			<?php
				if(empty($cust_id) && empty($staff_id))
				{
				?>
				<span style="color:black; font-size:30px;">
					<i class="fa fa-shopping-cart" aria-hidden="true">
						<span style="color:red;" id="cart"  class="badge badge-light">4</span>
					</i>
				</span>
				
				&nbsp;&nbsp;&nbsp;
				<button class="btn btn-outline-success my-2 my-sm-0" name="login">Log In</button>&nbsp;&nbsp;&nbsp;
				<?php
				}
				else
				{
				?>
				<a href="cart.php"><span style="color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true">
				<span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) echo $re; ?></span></i></span></a>
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
			<div class="middle" style="padding:60px; border:0px solid #0197A5; width:100%; margin-bottom:-140px;"><!--Main Div-->
				<!--tab heading-->
				<ul class="nav nav-tabs nabbar_inverse" id="myTab" style="margin-top:30; margin-bottom:-25px; background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" style="color:#063344; font-weight:650;" id="viewitem-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="viewitem" aria-selected="true" >View Cart</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:#063344; font-weight:650;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="manageaccount" aria-selected="false">Account Settings</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:#063344; font-weight:650;" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
					</li>
				</ul>

				<br><br>
				<div class="tab-content" id="myTabContent" >
					<div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab" >
						<!--Delivery location section-->
						<form id="deliv_pay" method="post" action="cart.php">	
							<div class="w3-container" style=" margin-top:5px;border-radius: 25px; border: 1.5px solid #0197A5; padding: 20px;  width: 100%; ">
								<div class="row"><!--Row 1-->
								<?php
										if(!empty($cust_id) && empty($staff_id))//Customer Options
										{
										?>
											<div class="column" style="text-align:center; float:left; width:50%;">	
												<label style=" color:black; font-weight:bold; text-transform:uppercase;"> Choose a meal pickup method:</label> 
												<select id="deliv" name="deliv" onchange="showloc(this.options[this.selectedIndex].id)">
													<option disabled selected value=" "> Meal Method</option>
													<option value="Pickup" <?php if (isset($loc) && $loc=="Pickup") echo "selected";?>>Pickup</option>
													<option value="Have-It-In" <?php if (isset($loc) && $loc=="Have-It-In") echo "selected";?>>Have-It-In</option>
												</select>
											</div><!--R1 C1 Ends-->
										<?php 
										} 
										else if(!empty($staff_id) && empty($cust_id))//For staff delivery location
										{
										?>
											<div class="column" style="text-align:center; float:left; width:50%;">	
												<label style=" color:black; font-weight:bold; text-transform:uppercase;"> Choose a Delivery Location:</label> 
												<select id="deliv" name="deliv" onchange="showloc(this.options[this.selectedIndex].id)">
													<option disabled selected value=" "> USP locations</option>
													<option value="ICT Building A" <?php if (isset($loc) && $loc=="ICT Building A") echo "selected";?>>ICT Building A</option>
													<option value="ICT Building B" <?php if (isset($loc) && $loc=="ICT Building B") echo "selected";?>>ICT Building B</option>
													<option value="Lower Campus Hub" <?php if (isset($loc) && $loc=="Lower Campus Hub") echo "selected";?>>Lower Campus Hub</option>
													<option value="SLS Hub" <?php if (isset($loc) && $loc=="SLS Hub") echo "selected";?>>SLS Hub</option>
													<option value="FBE Offices" <?php if (isset($loc) && $loc=="FBE Offices") echo "selected";?>>FBE Offices</option>
													<option value="FSTE Offices" <?php if (isset($loc) && $loc=="FSTE Offices") echo "selected";?>>FSTE Offices</option>
													<option value="Library" <?php if (isset($loc) && $loc=="Library") echo "selected";?>>Library</option>
													<option value="SCIMS Offices" <?php if (isset($loc) && $loc=="SCIMS Offices") echo "selected";?>>SCIMS Offices</option>
													<option id="UserLoc" value="None">Enter location...</option>
												</select>
											</div><!--R1 C1 Ends For Staff-->						
											<?php 
										}?>
			
									<div id="payment_opt" class="column" style="text-align:center;  float:left;  width: 50%; visibility:hidden;">
										<?php
										if(!empty($cust_id) && empty($staff_id))
										{
										?>
											<!-- Payment option section for customer-->
											<label style=" color:black; font-weight:bold; text-transform:uppercase; margin-left:40px;"> Choose a Payment Method:</label>
											<select id="payment" name="payment" onchange="showcardpayment(this.options[this.selectedIndex].value)">
											<option disabled selected value=" ">Payment Options</option>
												<option value="Cash on Pickup">Cash on Pickup</option>
												<option value="Card Payment" >Card Payment</option>
											</select>	
										<?php 
										} 
										else if(!empty($staff_id) && empty($cust_id))
										{
										?>
											<!-- Payment option section for staff-->
											<label style=" color:black; font-weight:bold; text-transform:uppercase; margin-left:40px;"> Choose a Payment Method:</label>
											<select id="payment" name="payment" onchange="showcardpayment(this.options[this.selectedIndex].value)">
												<option disabled selected value=" ">Payment Options</option>
												<option value="Payroll Deduction">Payroll Deduction</option>
												<option value="Cash on Delivery">Cash on Delivery</option>
												<option value="Card Payment">Card Payment</option>
											</select>
										<?php 
										}?>
									</div><!--R1 C2 ends-->
								</div><!--Row 1 Ends-->

								<div class="row"><!--Row 2-->
									<div class="column" style="float:left; width: 33.33%;"></div><!--R2 C1 Ends-->
									<div id="Location" class="column" style="float:left; width: 33.33%; display:none;">
										<label style="color:black; font-weight:bold; text-transform:uppercase; "> Enter Location: </label>
										<input id="txtBox" type="text" style="display:inline;" placeholder="E.g. 123 USP Road"/>							
									</div><!--R2 C2 Ends-->
								</div><!--Row 2 Ends-->

								<div class="row"><!--Row 3-->
									<div class="column" style="float:left; width: 33.33%;"></div><!--R3 C1 Ends-->
									<div class="column" style="text-align:center; width: 33.33%;"><!--R3 C2 Starts-->
										<div>
											<label id="error_message" class="text-danger"></label>  
											<label id="success_message" class="text-success"></label>
										</div>
										<div id="cardpayment" style="display:none;">
											<div class="payment">
													<div class="form-group owner">
														<label for="owner" style="font-weight:bold;">Owner</label>
														<input type="text" class="form-control" id="owner" name="owner">
													</div>
													<div class="form-group CVV">
														<label for="cvv" style="font-weight:bold;">CVV</label>
														<input type="text" class="form-control" id="cvv" name="cvv">
													</div>
													<div class="form-group" id="card-number-field">
														<label for="cardNumber" style="font-weight:bold;">Card Number</label>
														<input type="text" class="form-control" id="cardNumber" name="cardNumber">
													</div>
													<div class="form-group" id="expiration-date">
														<label style="font-weight:bold;">Expiration Date: </label>
														<select id="month" name="month">
															<option value="01">January</option>
															<option value="02">February </option>
															<option value="03">March</option>
															<option value="04">April</option>
															<option value="05">May</option>
															<option value="06">June</option>
															<option value="07">July</option>
															<option value="08">August</option>
															<option value="09">September</option>
															<option value="10">October</option>
															<option value="11">November</option>
															<option value="12">December</option>
														</select>
														<select id="year" name="year">
															<option value="2020"> 2020</option>
															<option value="2021"> 2021</option>
															<option value="2022"> 2022</option>
															<option value="2023"> 2023</option>
															<option value="2024"> 2024</option>
															<option value="2025"> 2025</option>
															<option value="2026"> 2026</option>
														</select>
													</div>
													<div class="form-group" id="credit_cards">
														<img src="../img/visa.jpg" id="visa">
														<img src="../img/mastercard.jpg" id="mastercard">
														<img src="../img/amex.jpg" id="amex">
													</div>
												
											</div>
										</div>
									</div><!--R3 C2 Ends-->
								</div><!--Row 3 Ends-->

								<?php 
								if(!empty($staff_id) && empty($cust_id))//For staff delivery location
								{
								?>
									<div class="row"><!--Row 4-->
										<div class="column" style="float:left; text-align:center; width: 50%;">
											<label style="color:black; font-weight:bold; text-transform:uppercase; "> Select Delivery Date: </label>
											<input type="date" name="delivery_date" min="<?=date('Y-m-d')?>" max="<?=date('Y-m-d',strtotime(date('Y-m-d').'+13 days'))?>"/>
										</div><!--R4 C1 Ends-->
									
										<div class="column" style="float:right; text-align:center; width: 50%;">
											<label style="color:black; font-weight:bold; text-transform:uppercase; "> Select Delivery Time: </label>	
											<input type="time" id="delivery_time" name="delivery_time" min="08:00" max="21:00" step="900" required>
										</div><!--R4 C2 Ends-->
									</div><!--Row 4 Ends-->
								<?php 
								}
								?>

								<div class="row"><!--Row 5-->
									<div class="column" style="float:left; text-align:center; width: 33.33%;"></div><!--R5 C1 Ends-->
								
									<div class="column" style="float:left; text-align:center; width: 33.33%;">
										<button id="deliver" type="submit" name="deliver" class="btn btn-success" style="margin-left:20px;">Confirm</button><!-- Submission Button -->
									</div><!--R5 C2 Ends-->
								
									<div class="column" style="float:left; text-align:center; width: 33.33%;"></div><!--R5 C3 Ends-->
								</div><!--Row 5 Ends-->

							</div><!--Container Ends-->
						</form><!--Form Ends-->
						
						<script src="js/jquery.payform.min.js" charset="utf-8"></script>
						<script>
						//Check current card value
						function checkcard()
						{
							var sel = document.getElementById("payment");
							var value= sel.options[sel.selectedIndex].value;
							if(value == 'Card Payment')
							{
								$("#cardpayment").css('display', 'block');
							}
						};

						//Card payment field Show
						function showcardpayment(value)
						{
							if(value=='Card Payment')
							{
								$("#cardpayment").css('display', 'block');
						
							}
							else
							{
								$("#cardpayment").css('display', 'none');
							}
						};

						//User defined location field Show
						function showloc(id)
						{
							if(id=='UserLoc')
							{
								var x = document.getElementById('Location');
								x.style.display = "block";
								$("#cardpayment").css('display', 'none');

								$("#txtBox").keyup(function() {
									var inputVal = document.getElementById("txtBox").value;
									if(inputVal.length == 0)
									{
										$("#payment_opt").css('visibility', 'hidden');
										$("#cardpayment").css('display', 'none');	
									}
									else
									{
										$("#deliv option:selected").val(inputVal);
										$("#payment_opt").css('visibility','visible');
										checkcard();
									} 
								});
							}
							else
							{
								$("#payment_opt").css('visibility', 'hidden');
								var x = document.getElementById('Location');
								x.style.display = "none";
							}
						};

						//Payment hide/unhide 
						$(document).ready(function(){
							var delivery = $('deliv').val();
							$('#deliv').on('change', function() {
								if (this.value && this.value != "None")
								{
									$("#payment_opt").css('visibility','visible');
									checkcard();
								}
								else
								{
									$("#payment_opt").css('visibility', 'hidden');
								}
							});
						});

						$(function() {
							var owner = $('#owner');
							var cardNumber = $('#cardNumber');
							var cardNumberField = $('#card-number-field');
							var CVV = $("#cvv");
							var mastercard = $("#mastercard");
							var visa = $("#visa");
							var amex = $("#amex");

							// Use the payform library to format and validate
							// the payment fields.

							cardNumber.payform('formatCardNumber');
							CVV.payform('formatCardCVC');

							cardNumber.keyup(function() {
								visa.css('opacity', 1);
								mastercard.css('opacity', 1);
								amex.css('opacity', 1);

								if ($.payform.validateCardNumber(cardNumber.val()) == false) 
								{
									cardNumberField.addClass('has-error');
								} 
								else 
								{
									cardNumberField.removeClass('has-error');
									cardNumberField.addClass('has-success');
								}

								if ($.payform.parseCardType(cardNumber.val()) == 'visa') 
								{
									mastercard.css('opacity', .3);
									amex.css('opacity', .3);

								} 
								else if ($.payform.parseCardType(cardNumber.val()) == 'amex') 
								{
									mastercard.css('opacity', .3);
									visa.css('opacity', .3);
								} 
								else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') 
								{
									visa.css('opacity', .3);
									amex.css('opacity', .3);
								}
							});

							//Payment submission success/failure message  
							$("#deliv_pay").submit(function( event ) {
								var delivery = $('#deliv').val();  
								var payment = $('#payment').val();
								var $this = $(this);

								event.preventDefault();
							
								if(!$('#deliv').val() || !$('#payment').val())
								{  
									$('#error_message').fadeIn().html("Please select appropriate information");
									setTimeout(function(){
											$('#error_message').fadeOut();
									}, 1500);
								}  
								else if($('#payment').val() == "Card Payment" && $('#deliv').val())
								{
									var isCardValid = $.payform.validateCardNumber(cardNumber.val());
									var isCvvValid = $.payform.validateCardCVC(CVV.val());

									if(owner.val().length < 5){
										alert("Wrong owner name");
									} 
									else if (!isCardValid) {
										alert("Wrong card number");
									} 
									else if (!isCvvValid) {
										alert("Wrong CVV");
									} 
									else 
									{
										// Everything is correct
										$("#error_message").html("").hide();
										$('#success_message').fadeIn().html("Delivery and Payment Info Confirmed");  
										setTimeout(function(){
												$('#success_message').fadeOut();
										}, 1500);

										$this.unbind("submit");
										setTimeout( $.proxy( $.fn.submit, $this ), 2000);
									}
								}
								else
								{
									$("#error_message").html("").hide();
									$('#success_message').fadeIn().html("Delivery and Payment Info Confirmed");  
									setTimeout(function(){
											$('#success_message').fadeOut();
									}, 1500);

									$this.unbind("submit");
									setTimeout( $.proxy( $.fn.submit, $this ), 2000);
								}
							});
						});					

						//Error mssg when meal pickup or delivery and payment info not filled 
						function ErrorMssg() 
						{
							alert("Please fill out all the required information before proceeding to checkout");
						}

						</script>

						<table id="table1" class="table" style="width: 100%; border-collapse: collapse; ">
							<tbody>
								<tr style="font-weight:bold;">
									<td></td>
									<td>Food name</td>
									<td>Price</td>
									<td>Description</td>
									<td style="text-align:center;">Quantity Ordered</td>
									<td>Product Total</td>
								</tr>

								<?php
								$query=mysqli_query($con,"select tbfood.foodname,tbfood.fldmanager_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id, tblcart.fld_staff_id, tblcart.fld_product_quantity 
															from tbfood inner join tblcart on tbfood.food_id=tblcart.fld_product_id 
															where tblcart.fld_customer_id='$cust_id'
															OR tblcart.fld_staff_id='$staff_id'
															");
								$re=mysqli_num_rows($query);
								if($re)
								{
									while($res=mysqli_fetch_array($query))
									{
										$manager_id=$res['fldmanager_id'];
										$m_query=mysqli_query($con,"select * from tblmanager where fldmanager_id='$manager_id'");
										$m_row=mysqli_fetch_array($m_query);
										$em=$m_row['fld_email'];
										$nm=$m_row['fld_name'];
								?>
										<tr>
											<td><image src="../image/restaurant/<?php echo $em."/foodimages/".$res['fldimage'];?>" height="80px" width="100px"></td>
											<td><?php echo $res['foodname'];?></td>
											<td><?php echo "$".$res['cost'];?></td>
											<td><?php echo $res['cuisines'];?></td>
											<td style="text-align:center;"><?php echo $res['fld_product_quantity'];?></td>
											<td style="text-align:center;"><?php $pro = ($res['cost']*$res['fld_product_quantity']); 
											echo "$" .$pro;?></td>
											<td></td>
											<form method="post" enctype="multipart/form-data">
											<td><button type="submit" name="del"  value="<?php echo $res['fld_cart_id']?>" class="btn btn-danger">Delete</button></td>
											</form>
											<td><?php $total=$total+($res['cost']*$res['fld_product_quantity']); $gtotal[]=$total;  ?></td>
										</tr>
									<?php 
									} 
									?>
								<tr>
									<td>
										<h5 style="color:red;">Grand total</h5>
									</td>
									<td>
										<h5><i class="fas fa-dollar-sign"></i>&nbsp;<?php echo end($gtotal); ?></h5>
									</td>
									<td></td>
									<td></td>
								</tr>
								<?php
								}
								else
								{
								?>
									<tr>
										<button type="button" class="btn btn-outline-success" style="margin:auto; display:block; margin-bottom:15px;"><a href="../menu.php" style="color:green; text-decoration:none;">No Items In cart Let's Shop Now</a></button>
									</tr>
								<?php
								}
								?>		
							</tbody>
						</table>	

						<a href="../menu.php#lunch">
						<button type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-success">Continue Shopping</button>
						</a>						
						<br><br>

						<?php
						if(!empty($staff_id) && empty($cust_id))//Staff
						{
							if($pay == "Card Payment")
							{
							?>
								<a href="CardOrder.php?staff_id=<?php echo $staff_id; ?>&loc=<?php echo $loc; ?>&pay=<?php echo $pay;?> &owner=<?php echo $owner; ?> &cvv=<?php echo $cvv; ?> &cardNumber=<?php echo $cardNumber; ?> &month=<?php echo $month; ?> &year=<?php echo $year;?> &del_date=<?php echo $del_date;?> &del_time=<?php echo $del_time;?>">
								<button type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">
								Proceed to checkout
								</button></a>
							<?php 
							}
							else if($pay == "Payroll Deduction")
							{
							?>
								<a href="PayrollOrder.php?staff_id=<?php echo $staff_id; ?>&loc=<?php echo $loc; ?>&pay=<?php echo $pay;?> &del_date=<?php echo $del_date;?> &del_time=<?php echo $del_time;?>">
								<button type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">
								Proceed to checkout
								</button></a>
								<?php 
							}
							else if($pay == "Cash on Delivery")
							{
							?>
								<a href="order.php?staff_id=<?php echo $staff_id; ?>&loc=<?php echo $loc; ?>&pay=<?php echo $pay;?> &del_date=<?php echo $del_date;?> &del_time=<?php echo $del_time;?>">
								<button type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">
								Proceed to checkout
								</button></a>

							<?php 
							}
							else
							{
							?>
								<button onclick="ErrorMssg()" type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">
								Proceed to checkout
								</button>
							<?php
							}
							?>  
						<?php
						}
						else if(!empty($cust_id) && empty($staff_id))//Customer
						{
							if($pay == "Card Payment")
							{
							?>
								<a href="CardOrder.php?cust_id=<?php echo $cust_id; ?>&loc=<?php echo $loc; ?>&pay=<?php echo $pay;?> &owner=<?php echo $owner; ?> &cvv=<?php echo $cvv; ?> &cardNumber=<?php echo $cardNumber; ?> &month=<?php echo $month; ?> &year=<?php echo $year;?>">
								<button type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">
								Proceed to checkout
								</button></a>
							<?php 
							}
							else if($pay == "Cash on Pickup")
							{
							?>
								<a href="order.php?cust_id=<?php echo $cust_id; ?>&loc=<?php echo $loc; ?>&pay=<?php echo $pay;?>">
								<button type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">
								Proceed to checkout
								</button></a>

							<?php 
							}
							else
							{
							?>
								<button onclick="ErrorMssg()" type="button" style="position:absolute; right:60; color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">
								Proceed to checkout
								</button>
							<?php
							}
							?>  
						<?php
						}
						?>	
						<span style="color:green; text-align:centre;"><?php if(isset($success)) { echo $success; }?></span>	
					</div><!--Tab 1 Ends-->
																<!------Customer------->
					<?php
						if(!empty($cust_id) && empty($staff_id))
						{
					?>
					<!--tab 2 for customer starts-->
					<div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="manageaccount-tab">
						<form method="post" enctype="multipart/form-data">
							<div class="form-group">
							<label for="name">Name</label>
							<input type="text" id="name" value="<?php if(isset($fld_name)){ echo $fld_name;}?>" class="form-control" name="name" required="required"/>
							</div>
							
							<div class="form-group">
							<label for="email">Email</label>
							<input type="email" id="email" name="email" value="<?php if(isset($fld_email)){ echo $fld_email;}?>" class="form-control"  readonly/>
							</div>
							<div class="form-group">
							<label for="mobile">Mobile</label>
							<input type="tel" id="mobile" class="form-control" name="mobile" pattern="[2-9]{1}[0-9]{6}" value="<?php if(isset($fld_mobile)){ echo $fld_mobile;}?>" placeholder="" required>
							</div>
							
							<div class="form-group">
								<label for="pwd">Password:</label>
								<input type="password" name="pswd" value="<?php if(isset($fld_password)) { echo $fld_password; }?>"class="form-control"  id="pwd" required/>
							</div>
			
							<div style="text-align:right;">
								<button type="submit" name="update" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
							</div> 
							
							<div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
						</form>
					</div><!--Customer Tab 2 Ends-->
					
					<!--tab 3 for customer starts-->
					<div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
						<table class="table">
						<!--<th>Order Number</th>-->
						<th>Customer Email</th>
						<th>Item Name</th>
						<th>Price($)</th>
						<th>Quantity</th>
						<th>Pickup method</th>
						<th>Payment Option</th>
						<th>Order Date/Time</th>
						<th>Cancel order</th>
							<tbody>
							<?php
							$quer_res=mysqli_query($con,"select * from tblorder where fld_email_id='$cust_id' && fldstatus='In Process'");
							while($roww=mysqli_fetch_array($quer_res))
							{   
									$fid=$roww['fld_food_id'];
									$qr=mysqli_query($con,"select * from tbfood where food_id='$fid'");
									$qrr=mysqli_fetch_array($qr);?>
								<tr>
								<td><?php echo $roww['fld_email_id']; ?></td>
								<?php
								if(empty($qrr['foodname']))
								{
								?>
								<td><span style="color:red;">Product Not Available Now</span></td>
								<?php
								}
								else
								{
									?>
									<td><?php echo $qrr['foodname']; ?></td>
									<?php
								}
								?>
								
								<td><?php echo $qrr['cost']; ?></td>
								<td><?php echo $roww['fld_product_quantity'];?></td>
								<td><?php echo $roww['delivery_location']; ?></td>
								<td><?php echo $roww['payment_option']; ?></td>
								<td><?php echo $roww['order_time']; ?></td>
								<td><a href="#" onclick="del(<?php echo $roww['fld_order_id'];?>);"><button type="button" class="btn btn-danger">Cancel Order</button></a></td>
								</tr>
								<?php }	?>  
							</tbody>
						</table>
					</div><!--Customer Tab 3 Ends-->
					<?php 
						}
					?>
																<!------Staff------->
					<?php
						if(!empty($staff_id) && empty($cust_id))
						{
					?>
					<!--tab 2 for staff starts-->
					<div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="manageaccount-tab">
						<form method="post" enctype="multipart/form-data">
							<div class="form-group">
							<label for="email">Staff ID</label>
							<input type="staff_id" id="staff_id" name="staff_id" value="<?php if(isset($staff_id)){ echo $staff_id;}?>" class="form-control"  readonly/>
							</div>

							<div class="form-group">
							<label for="name">Name</label>
							<input type="text" id="name" value="<?php if(isset($staff_name)){ echo $staff_name;}?>" class="form-control" name="name" required="required"/>
							</div>
							
							<div class="form-group">
							<label for="email">Email</label>
							<input type="email" id="email" name="email" value="<?php if(isset($staff_email)){ echo $staff_email;}?>" class="form-control"  required="required"/>
							</div>

							<div class="form-group">
							<label for="mobile">Mobile</label>
							<input type="tel" id="mobile" class="form-control" name="mobile" pattern="[2-9]{1}[0-9]{6}" value="<?php if(isset($staff_mobile)){ echo $staff_mobile;}?>" placeholder="" required>
							</div>
						
							<div class="form-group">
								<label for="pwd">Password:</label>
								<input type="password" name="pswd" value="<?php if(isset($staff_password)) { echo $staff_password; }?>"class="form-control"  id="pwd" required/>
							</div>
							
							<div style="text-align:right;">
							<button type="submit" name="update1" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
							</div>
							<div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
						</form>					
					</div><!--Staff Tab 2 Ends-->
					
					<!--tab 3 for staff starts-->
					<div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
						<table class="table">
							<!--<th>Order Number</th>-->
							<th>Staff ID</th>
							<th>Item Name</th>
							<th>Price($)</th>
							<th>Quantity</th>
							<th>Delivery Location</th>
							<th>Payment Option</th>
							<th>Order Date/Time</th>
							<th>Delivery Date</th>
							<th>Delivery Time</th>
							<th>Cancel order</th>
							<tbody>
							<?php
							$quer_res=mysqli_query($con,"select * from tblorder where staff_id='$staff_id' && fldstatus='In Process'");
							while($roww=mysqli_fetch_array($quer_res))
							{   
									$fid=$roww['fld_food_id'];
									$qr=mysqli_query($con,"select * from tbfood where food_id='$fid'");
									$qrr=mysqli_fetch_array($qr);?>
								<tr>
								<td><?php echo $roww['staff_id']; ?></td>
								<?php
								if(empty($qrr['foodname']))
								{
								?>
								<td><span style="color:red;">Product Not Available Now</span></td>
								<?php
								}
								else
								{
									?>
									<td><?php echo $qrr['foodname']; ?></td>
									<?php
								}
								?>
								
								<td><?php echo $qrr['cost']; ?></td>
								<td><?php echo $roww['fld_product_quantity'];?></td>
								<td><?php echo $roww['delivery_location']; ?></td>
								<td><?php echo $roww['payment_option']; ?></td>
								<td><?php echo $roww['order_time']; ?></td>
								<td><?php echo $roww['delivery_date']; ?></td>
								<td><?php echo $roww['delivery_time']; ?></td>
								<td><a href="#" onclick="del(<?php echo $roww['fld_order_id'];?>);"><button type="button" class="btn btn-danger">Cancel Order</button></a></td>
								</tr>
								<?php }	?>  
							</tbody>
						</table>
					</div><!--Staff Tab 3 Ends-->
					<?php 
						} 
					?>
				</div><!--Tab content ends-->	
			</div> <!--Main div ends--> 	 
			<br><br><br><br><br><br><br>
		</div><!--Page content ends-->

		<footer id="footer">
		<?php
			include("footer.php");
		?>
		</footer>
	</div><!--Container Div ends-->  
</body>
</html>