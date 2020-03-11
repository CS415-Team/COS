<?php
session_start();
include("connection.php");
extract($_REQUEST);
$arr=array();

if(isset($_SESSION['cust_id']))
{
	 $cust_id=$_SESSION['cust_id'];
	 $qq=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	 $qqr= mysqli_fetch_array($qq);
}
else
{
	$cust_id="";
}

$query=mysqli_query($con,"select  tblvendor.fld_name,tblvendor.fldvendor_id,tblvendor.fld_email,
tblvendor.fld_mob,tblvendor.fld_address,tblvendor.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
tbfood.cuisines,tbfood.paymentmode 
from tblvendor inner join tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id;");
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
		 $_SESSION['cust_id']=$cust_id;
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
 $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldvendor_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
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

     
	 <style>
	.carousel-item {
	height: 100vh;
	min-height: 350px;
	background: no-repeat center center scroll;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
		}
	body{
		background-image:url("img/background.jpg");
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: center;
	
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
 ul li a{color:black;text-decoration:none;}
 ul li a:hover{color:black;text-decoration:none;}
</style>
  </head>
  
    
	<body>
	<!--navbar start-->

<div id="result" style="position:fixed;top:100; right:50;z-index: 3000;width:350px;background:white;"></div>
<!--navbar ends-->
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
	<a class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php if(isset($cust_id)) { echo $qqr['fld_name']; }?></i></a>
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
                    <a class="nav-link dropdown-toggle" href="#"  style="color:#063344;font-weight:650" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menus
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="border:1px solid black;">
                    <div class="dropdown-header" align="center" 
                        style="background-color:#0197A5; color:white; font-family: 'Times New Roman'; font-style:italic; font-weight:bold;">
                        MEAL TYPE
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Breakfast Specials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="menu.php#lunch">Lunch Specials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Dinner Specials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="menu.php">All</a>
                    </div>
                </li>

        <li class="nav-item">
          <a class="nav-link" href="aboutus.php" style="color:#063344;font-weight:650">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="contact.php" style="color:#063344;font-weight:650">Contact</a>
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
		<li class="nav-item">
		
		  
		</li>
      </ul>
	  
    </div>
	
</nav>
<!--navbar ends-->
<br><br>
<div class="container-fluid" style="margin-top:90px">
  <img src="img/about.jpg" height="600" width='100%'/>
</div>
<br><br>
<div class="container-fluid" style="background:black; opacity:0.60;">
<h1 style="color:white; text-align:center; text-transform:uppercase;">About Us</h1>
<h3 style="color:white; text-align:center; text-transform:uppercase; font-style:italic;">What does NaBukDiSh Mean?</h3>
<p style="color:white; text-align:center; font-size:25px;">NaBukDish is a combination of the names of the creators of the system. Na for Naval, Buk for Buksh, Di for Divnesh and Sh for Shimneet. Plus it also has the word dish in it. Get it?</p>

<h3 style="color:white; text-align:center; text-transform:uppercase; font-style:italic;">Why create NaBukDish?</h3>
<p style="color:white; text-align:center; font-size:25px;">NaBukDish Food Ordering System was created as part of 
a project assignment for the course CS415 at the University of The South Pacific in semester 1 of 2020.
</p>

</div>

<br><br>
<div class="container-fluid" style="background:white; text-transform:uppercase;padding:20px; border-left:10px solid black;"><h3>Our Location</h3></div>
<div class="container-fluid">
<div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="304" id="gmap_canvas" 
	src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3669.1410809099107!2d178.44288106824857!3d-18.150103553226995!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x55dcb02171075a14!2sUSP%20Faculty%20of%20Science%20%26%20Technology!5e1!3m2!1sen!2sfj!4v1583395682586!5m2!1sen!2sfj" 
	frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.emojilib.com">emojilib.com</a></div>
	<style>.mapouter{position:relative;text-align:right;height:304px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:304px;width:100%;}</style>
</div>
</div>
<br><br>
 <?php
	include("footer.php");
?>

	</body>
</html>