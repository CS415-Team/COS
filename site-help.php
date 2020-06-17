<?php
session_start();
include("connection.php");
extract($_REQUEST);
$arr=array();

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
tbfood.cuisines,tbfood.paymentmode 
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
 
 if(isset($message))
 {
	 echo $name;
	 echo $msgtxt;
	 echo $email;
	 echo $phone;
	 if(mysqli_query($con,"insert into tblmessage(fld_name,fld_email,fld_phone,fld_msg) values ('$name','$email','$phone','$msgtxt')"))
     {
		 echo "<script> alert('We will be Connecting You shortly')</script>";
	 }
	 else
	 {
		 echo "failed";
	 }
}$query=mysqli_query($con,"select tbfood.foodname,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
?>
<html>
  <head>
     <title>Site-Help Docs</title>
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
     <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">
     
	 <style>
	 .carousel-item {
	height: 100vh;
	min-height: 350px;
	background: no-repeat center center scroll;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	}
	 </style>
	 
	 
<script>
//search product function
$(document).ready(function(){
$("#search_text").keypress(function()
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
				load_data();			
				}
			});
			});
		});
</script>
<style>
	ul li {list-style:none;}
	ul li a{color:black; font-weight:bold;}
	ul li a:hover{text-decoration:none;}

    h1.help-header{
        color:#0197A5;
        font-family: 'Permanent Marker', cursive;
        text-decoration: underline;
    }

    h1.help-header::before { 
    display: block; 
    content: " "; 
    margin-top: -110px; 
    height: 110px; 
    visibility: hidden; 
    pointer-events: none;
    }

	#footer 
	{
		position: absolute;
		bottom: 0;
		width: 100%;
		height: 3rem;/* Footer height */
	}

    .faqHeader {
        font-size: 25px;
        margin: 20px;
        font-weight:bold;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "e072"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>
</head>
  

<body>
<div id="result" style="position:fixed;top:100; right:50;z-index: 3000;width:350px;background:white;"></div>
<!--navbar start-->
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
			if(empty($cust_id) && empty($staff_id) && empty($man_id) && empty($admin_id)  && empty($d_id))
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
<!--navbar ends-->


<div style="position: relative;  min-height: 100vh;"><!--Container Div-->
	<div id="content-wrap" style="padding-bottom: 6rem;"><!-- all other page content -->

        <div class="container">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                This section contains a wealth of information, related to <strong>PrepBootstrap</strong> and its store. If you cannot find an answer to your question, 
                make sure to contact us. 
            </div>

            <br />

			<h1 class="help-header" id="help-header" style="text-align:center">COS User Manual</h1>
            <p style="text-align:center;">For each method shown, the instructions are to be followed in the top to bottom order of the images</p>
            <div class="" id="accordion">
                <div class="faqHeader">Patrons</div>
                <!--How to register-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">How do I register?</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="card-block">
                             <img src="manual/Home/Home.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="400">
                            <br>
                            <img src="manual/UserReg/Registration.png" alt="Select user type, fillout details and click register" class="d-block w-100" width="100%" height="600">
                       </div>
                    </div>
                </div>
                <!--How to login-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">How do I login?</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Home/Home.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="400">
                            <br>
                            <img src="manual/UserLogin/Login.png" alt="Select login type, fillout details and click login" class="d-block w-100" width="100%" height="600">
                        </div>
                    </div>
                </div>
                <!--How to place regular order-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">How do I place a regular meal order?</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/UserOrder/Home Menu.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order From Menu.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order - Select location.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order - Select Payment.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order - Delivery date.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order - Select Time.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order - Confirm.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order - Proceed.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                            <br>
                        </div>
                    </div>
                </div>
                <!--How to place custom order-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">How do I place a custom meal order?</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/UserOrder/Order Custom1.png" alt="Custom Order" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order Custom2.png" alt="Custom Order" class="d-block w-100" width="100%" height="auto">
                            <br>
                            <img src="manual/UserOrder/Order Custom3.png" alt="Custom Order" class="d-block w-100" width="100%" height="auto">
                            <br>
                            Selecting location, payment method and check out are same as shown in "How do I place a regular meal order?"
                            <br>
                        </div>
                    </div>
                </div>
                <!--How to schedule a meal-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">How do I schedule a meal?</a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="card-block">
                            All prices for themes, templates and other items, including each seller's or buyer's account balance are in <strong>USD</strong>
                        </div>
                    </div>
                </div>
                <!--How to cancel an order -->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">How can I cancel an order?</a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse">
                        <div class="card-block">
                           <img src="manual/CancelOrder/Order - Cancel.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto">
                        </div>
                    </div>
                </div>
                <!--Where to view orders-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">Where can I view my orders?</a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Orders/Orders.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto"> 
                        </div>
                    </div>
                </div>
                <!--Where to view account settings -->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">Where can I manage my account settings?</a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/UserAcc/User Account.png" alt="Click login in homepage" class="d-block w-100" width="100%" height="auto"> 
                        </div>
                    </div>
                </div>
				
				<!--Where can I subscribe for daily meals -->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse12">Where can I subscribe for daily meals?</a>
                        </h4>
                    </div>
                    <div id="collapse12" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/MealSubscription/mealsubs.jpg" alt="Click login in homepage" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
				
				<!--What can I do under meal subscription -->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse13">What can I do under meal subscription?</a>
                        </h4>
                    </div>
                    <div id="collapse13" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/MealSubscription/mealsubs1.jpg" alt="Click login in homepage" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>

                <!--Admin -->
                <div class="faqHeader">Admin</div>
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseNine">How do I login?</a>
                        </h4>
                    </div>
                    <div id="collapseNine" class="panel-collapse collapse">
                        <div class="card-block">

                            <img src="manual/Admin/Admin.png" alt="Click login in homepage" class="d-block w-30" height="250" style="  display: block; margin-left: auto;  margin-right: auto;"> 
                            <img src="manual/Admin/Admin Login.png" alt="Click login in homepage" class="d-block w-40"  height="400" style="  display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>

                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">What Can I do?</a>
                        </h4>
                    </div>
                    <div id="collapseTen" class="panel-collapse collapse">
                        <div class="card-block">
                            <ul>
                                <li>
                                    <dl> 
                                        <dt style="font-size:20px;">Food Item Management</dt> 
                                            <dd>View all food items for all restaurants</dd>
                                            <dd>Disable(hide) food items from being visible in the menu</dd>  
                                            <dd>Delete food items from the menu</dd>
                                        <br>
                                        <dt style="font-size:20px;">Account Management</dt> 
                                            <dd>Add and delete any of the cafeteria staff accounts</dd>
                                            <ul>
                                                <li>
                                                        <dd>Menu Manager Accounts</dd>
                                                        <dd>Meal Deliverer Accounts</dd>
                                                </li>
                                            </ul>
                                        <br>
                                        <dt style="font-size:20px;">Restaurant Management</dt> 
                                            <dd>Delete restaurants</dd>
                                        <br>
                                        <dt style="font-size:20px;">Order</dt> 
                                            <dd>View the status of all orders</dd>
                                    </dl>    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--Where to view account settings -->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven">Where can I manage my account settings?</a>
                        </h4>
                    </div>
                    <div id="collapseEleven" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Admin/acc.png" alt="Click login in homepage" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
				
			    <div class="faqHeader">Menu Manager</div>
                <!--Login-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwelve">Where do I login?</a>
                        </h4>
                    </div>
                    <div id="collapseTwelve" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Manager/Menu manager1.png" alt="Login" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Manage Products-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFifteen">How do I Manage Products?</a>
                        </h4>
                    </div>
                    <div id="collapseFifteen" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Manager/Man1.png" alt="Manage Products" class="d-block w-50"  height="200" style="display: block; margin-left: auto;  margin-right: auto;"> 
                            <br>
                            <img src="manual/Manager/Menu manager2.png" alt="Manage Products" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Update Products-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSixteen">How do I Update Products?</a>
                        </h4>
                    </div>
                    <div id="collapseSixteen" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Manager/Menu manager3.png" alt="Manage Products" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Add Products-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeventeen">How do I Add Products?</a>
                        </h4>
                    </div>
                    <div id="collapseSeventeen" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Manager/Menu manager4.png" alt="Manage Products" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Add Custom Meal-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEighteen">How do I Add a Custom Meal and Ingredients?</a>
                        </h4>
                    </div>
                    <div id="collapseEighteen" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Manager/Man2.png" alt="Manage Products" class="d-block w-50"  height="200" style="display: block; margin-left: auto;  margin-right: auto;"> 
                            <br>
                            Adding a custom meal is same as shown in "How do I Add Products?"
                            <br>
                            <img src="manual/Manager/Menu manager5.png" alt="Manage Products" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Update Account Settings-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseNineteen">How do I Update my Settings?</a>
                        </h4>
                    </div>
                    <div id="collapseNineteen" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Manager/Man3.png" alt="Manage Products" class="d-block w-50"  height="200" style="display: block; margin-left: auto;  margin-right: auto;"> 
                            <br>
                            <img src="manual/Manager/Menu manager6.png" alt="Manage Products" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Order Status-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwenty">How do I View my Order Status?</a>
                        </h4>
                    </div>
                    <div id="collapseTwenty" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Manager/Menu manager 7.png" alt="Manage Products" class="d-block w-50"  height="200" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>

                <!--Meal Deliverer-->
                <div class="faqHeader">Meal Deliverer</div>
                <!--Login Portal-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwentyone">Where do I login?</a>
                        </h4>
                    </div>
                    <div id="collapseTwentyone" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Deliverer/Del1.png" alt="Order Status" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Login-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwentytwo">How do I login?</a>
                        </h4>
                    </div>
                    <div id="collapseTwentytwo" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Deliverer/Del2.png" alt="Order Status" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--View all order status-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThirteen">Where do I see the Order Status?</a>
                        </h4>
                    </div>
                    <div id="collapseThirteen" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Deliverer/Deliverer1.png" alt="Order Status" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>
                <!--Deliverer account settings-->
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-header">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFourteen">Where can I manage my settings?</a>
                        </h4>
                    </div>
                    <div id="collapseFourteen" class="panel-collapse collapse">
                        <div class="card-block">
                            <img src="manual/Deliverer/Deliverer2.png" alt="Order Status" class="d-block w-50"  height="400" style="display: block; margin-left: auto;  margin-right: auto;"> 
                        </div>
                    </div>
                </div>




            </div>
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