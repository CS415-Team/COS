<?php
session_start();

extract($_REQUEST);
include("../connection.php");
$id = (int)$_GET["id"];
$gtotal=array();
$ar=array();
$total=0;

$staff_id = "";
$mealtype = "";

if(isset($_SESSION['staff_id']))
{
	$staff_id=$_SESSION['staff_id'];
	$qq=mysqli_query($con,"select * from tblstaff where staff_id='$staff_id'");
	$qqr= mysqli_fetch_array($qq);
	$cust_id="";
	$loc="";
	$pay="";
	$del_date="";
    $del_time="";
    $_SESSION["semail"] = $qqr['staff_email'];
}


if(empty($cust_id) && empty($staff_id))
{
	header("location:index.php?msg=You must login first");
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
 
 
 if(isset($_POST["daterange"]) && isset($_POST["delivery_time"]) && isset($_POST["deliv"]))
 {
    $daterange = explode("-", $_POST["daterange"]);
    $startdate = $daterange[0];
    $enddate = $daterange[1];
    //$staff = "s11084902";
    $datentime = date("d-m-Y h:i:sa");
    $dlivery_time = $_POST["delivery_time"];
    $location = $_POST["deliv"];

    
    if($dlivery_time >= "08:00:00" && $dlivery_time <= "11:00:00"){$mealtype = "Breakfast";}
    else if($dlivery_time > "11:00:00" && $dlivery_time < "16:00:00"){$mealtype = "Lunch";}
    else if($dlivery_time >= "16:00:00" && $dlivery_time <= "19:00:00"){$mealtype = "Dinner";}
	//staff_id,subcription_date,start_date,end_date,delivery_time,delivery_location
    $sql = "Update mealsubscription SET subcription_date='$datentime', start_date='$startdate', end_date='$enddate', delivery_time='$dlivery_time', delivery_location='$location' WHERE subscription_id='$id' ";

    
    if(mysqli_query($con, $sql))
    {
        header("location:../subscriptionmeals.php?meal=".$mealtype."&dt=".$datentime);
    }
    
    else
    {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }

 }
?>

<html>
<head>
  <title>Subscription </title>
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

        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
  
		<a class="navbar-brand" href="../index.php"><img src="../../img/USP Logo.png" style="display: inline-block;"></a>
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
						<li class="nav-item active">
						<a class="nav-link" href="subscription.php" style="color:#063344;font-weight:650">Subscription</a>
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
                        <a class="nav-link" style="color:#063344; font-weight:650;" id="viewitem-tab"  href="../subscription.php" role="tab" aria-controls="viewitem" aria-selected="true" >Active Subscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="color:#063344; font-weight:650;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="manageaccount" aria-selected="false">New Subscription</a>
                    </li>
                </ul>

				<br><br>
														

					<!--tab 2 for customer starts-->
					<div class="tab-pane fade show active" id="manageaccount" role="tabpanel" aria-labelledby="manageaccount-tab">
						<form method="post" enctype="multipart/form-data" action="">
							<div class="form-group">
                            <div class="row"><!--Row 4-->
									<div class="column" style="float:left; text-align:center; width: 50%;">
                                    <label style="color:black; font-weight:bold; text-transform:uppercase; ">Start Date - End Date: </label>
                                    <input type="text" name="daterange" value="" />

                                    <script>
                                    $(function() {
                                    $('input[name="daterange"]').daterangepicker({
                                        opens: 'left'
                                    }, function(start, end, label) {
                                        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                                    });
                                    });
                                    </script>
									</div><!--R4 C1 Ends-->
								
									<div class="column" style="float:right; text-align:center; width: 50%;">
                                    <label style="color:black; font-weight:bold; text-transform:uppercase; "> Select Delivery Time: </label>	
										<input type="time" id="delivery_time" name="delivery_time" min="08:00:00" max="19:00:00" required>
									</div><!--R4 C2 Ends-->
								</div><!--Row 4 Ends-->
							</div>
							
							<div class="form-group">
                            <div class="row">
                                <div class="column" style="text-align:center; float:left; width:50%;">	
                                    <label style=" color:black; font-weight:bold; text-transform:uppercase;"> Choose Delivery Location:</label> 
                                    <select id="deliv" name="deliv" required>
                                        <option disabled selected value=" "> USP locations</option>
                                        <option value="ICT Building A" >ICT Building A</option>
                                        <option value="ICT Building B" >ICT Building B</option>
                                        <option value="Lower Campus Hub" >Lower Campus Hub</option>
                                        <option value="SLS Hub" >SLS Hub</option>
                                        <option value="FBE Offices" >FBE Offices</option>
                                        <option value="FSTE Offices" >FSTE Offices</option>
                                        <option value="Library" >Library</option>
                                        <option value="SCIMS Offices" >SCIMS Offices</option>
                                        
                                    </select>
                                </div><!--R1 C1 Ends-->
							</div>
                            </div>
							
                            <div class="form-group">
                                <div style="text-align:right;">
                                    <button type="submit" name="update"  class="btn btn-Success">Update</button>
                                </div> 
							</div>

							<div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
						</form>
					</div><!--Customer Tab 2 Ends-->
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