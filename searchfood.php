<?php
session_start();

include("connection.php");
extract($_REQUEST);

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
 
if(isset($food_id))
{
	$fid= $food_id;
}
else
{
	header("location:index.php");
}

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


 
$query=mysqli_query($con,"select tbfood.foodname,tbfood.fldmanager_id,tbfood.cost,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id, tblcart.fld_staff_id 
						 from tbfood inner join tblcart on tbfood.food_id=tblcart.fld_product_id 
						 where tblcart.fld_customer_id='$cust_id'
 							OR tblcart.fld_staff_id='$staff_id'
						 ");
$re=mysqli_num_rows($query);


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
					if(empty($cust_id) && empty($staff_id))
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
		<div class="container-fluid" style="margin-top:100px;">
		<br><br>
		<div class="row">
		   <div class="col-sm-3"></div>
		   <div class="col-sm-6" >
		   <?php
			  
			  $query=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
			  tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.foodname,tbfood.cost,
			  tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage from tblmanager inner join
			  tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where tbfood.food_id='$fid'");
			  if(mysqli_num_rows($query))
			  {
			  while($res=mysqli_fetch_assoc($query))
			  {
				   $food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];
			  ?>
			  <div class="w3-container">
				<div class="row" style="padding-top:10px; text-align:right;">
					<div class="column" style="width:33.33%"></div>
					<div class="column" style="width:33.33%">
							<span style="font-family: 'Miriam Libre', sans-serif; font-size:30px; color:#CB202D;">
								<?php echo $res['fld_name']; ?>
							</span>
					</div>
					<div class="column" style="width:33.33%;"></div>
				</div>
			  </div>
			  <div class="container-fluid">
			  <div class="row" style="padding:10px;padding-top:0px;padding-right:0px; padding-left:0px;">
				 <div class="col-sm-20"><img src="<?php echo $food_pic; ?>" class="rounded" height="400px" width="100%" alt="Cinque Terre"></div> 
				 </div>
			  </div>
			
				<div class="row">
					<div class="column" style="text-align:left; width: 33.33%;">
					</div>
					<div class="column" style="text-align:center; width:33.33%"><?php echo"(" .$res['foodname'].")"?></b></div>
					<div  class="column" style="float:left; width: 33.33%; display:inline; text-align:right; padding:10px; font-size:15px;">
					<span style="color:black; font-size:25px; white-space:nowrap;">Price: $<?php echo $res['cost']; ?></span>
						<form method="post">
							<button type="submit" name="addtocart" value="<?php echo $fid; ?>")" >
							<span style="color:green; font-size:2vw;">Add to cart: <i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button>
						</form>
					</div>
				</div>
			
			<?php
			  }
			  }
			  else
			  {
			?>
			<div class="row"><div class="col-sm-12" style="color:red;"><?php echo "sorry No Record Found For This Order";?></div></div>
			<?php
			  }
			?>
			</div>

		   
		   </div>
		   
		   <div class="col-sm-3"></div>
		</div>
		</div>
		<br><br>
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
				
				</div>
				<div class="col-sm-4">
				
				</div>
				<div class="col-sm-4">
				
				</div>
			</div>
		</div>
		
		<!--footer primary-->	     
		<?php include("footer.php"); ?>
			 			 		
	</body>
</html>