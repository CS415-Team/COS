<?php
session_start();
include("../connection.php");
extract($_REQUEST);
if(isset($_GET['product']))
{
	$product_id= $_GET['product'];
}
else
{
	$product_id= "";
}
if(isset($_GET['msg']))
{
	$loginmsg=$_GET['msg'];
}
else
{
	$loginmsg="";
}
if(isset($login))
{
	$query=mysqli_query($con,"select * from tblcustomer where fld_email='$email' && password='$password'");
    if($row=mysqli_fetch_array($query))
	{
		$customer_email =$row['fld_email'];
		$_SESSION['cust_id']=$customer_email;
		if(!empty($customer_email && $product_id))
		{
			 //$_SESSION['product']=$product_id;
			echo $_SESSION['cust_id']=$customer_email;
			
			 header("location:cart.php?product=$product_id");
			
		}
		else
		{
		header("location:../index.php");
		 $_SESSION['product']=$product_id;
		 $_SESSION['cust_id'];
		}
		 
	}
	else
	{
		$ermsg="invalid Details";
	}
}

if(isset($login1))
{
	$query=mysqli_query($con,"select * from tblstaff where staff_id='$s_id' && staff_password='$staffpwd'");
    if($row=mysqli_fetch_array($query))
	{
		$stf_id=$row['staff_id'];
		$_SESSION['staff_id']=$stf_id;
		if(!empty($stf_id && $product_id))
		{
			 //$_SESSION['product']=$product_id;
			echo $_SESSION['staff_id']=$stf_id;
			
			 header("location:cart.php?product=$product_id");
			
		}
		else
		{
		header("location:../index.php");
		 $_SESSION['product']=$product_id;
		 $_SESSION['staff_id'];
		}
		 
	}
	else
	{
		$ermsg="Invalid Details";
	}
}

if(isset($register))
{
	$query=mysqli_query($con,"select * from tblcustomer where fld_email='$email'");
	$row=mysqli_num_rows($query);
	if($row)
	{
		$ermsg2="Email already registered with us";
		
	}
	else
	{
		if(mysqli_query($con,"insert into tblcustomer (fld_name,fld_email,password,fld_mobile) values('$name','$email','$password','$mobile')"))
		{
			$_SESSION['cust_id']=$email;
			if(!empty($customer_email && $product_id))
			{
				$_SESSION['cust_id']=$customer_email;
				header("location:cart.php?product='$product_id'");
				
			}
			else
			{
				$_SESSION['cust_id']=$email;
				header("location:../index.php");
			}		
		}
		else
		{
			echo "fail";
			echo $name;
			echo $email;
			echo $password;
			echo $mobile;
		}
	}	
}

if(isset($register1))
{
	$query=mysqli_query($con,"select * from tblstaff where staff_id='$s_id'");
	$row=mysqli_num_rows($query);
	if($row)
	{
		$ermsg2="Staff ID already registered with us";
		
	}
	else
	{
		if(mysqli_query($con,"insert into tblstaff (staff_id,staff_name,staff_email,staff_password,staff_mobile) values('$s_id','$staffname','$staffemail','$staffpwd','$staff_mobile')"))
    	{
			$_SESSION['staff_id']=$s_id;
			if(!empty($s_id && $product_id))
			{
				$_SESSION['staff_id']=$staff_id;
				header("location:cart.php?product='$product_id'");
				
			}
			else
			{
				$_SESSION['staff_id']=$s_id;
				header("location:../index.php");
			}		
		}
		else
		{
			echo "fail";
			echo $name;
			echo $email;
			echo $password;
			echo $mobile;
		}
	}	
}

?>

<!-- Not working for now
<style>
	/*   Change Color for Inactive Tabs     */
	.nav-item>li.active>a {
		border-color: #FFFFFF;
		color: #FFFFFF;
    }
</style>
-->
     
<html>
<head>
    <title>Login Page</title>
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

		<!--Script for hiding/showing div based on user selection-->
		<script type='text/javascript'>
		$(document).ready(function() {
			$("input[name$='user']").click(function() {
				var test = $(this).val();

				$("div.desc").hide();
				$("#User" + test).show();
			});
		});
		</script>
		
		<style>
		ul li{list-style:none;}
		ul li a {color:black;font-weight:bold;text-decoration:none; }
		ul li a:hover {color:black;text-decoration:none;}
		</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #0197A5;">
  
	<a class="navbar-brand" href="../index.php"><img src="../img/USP Logo.png" style="display: inline-block;"></a>
		<a class="navbar-brand" href="../index.php"><span style="color:white;font-family: 'Permanent Marker', cursive;font-size:22pt;">NaBukDiSh</span>
		<span style="color:white;font-family:'Permanent Marker', cursive;font-size:18pt;">&copy</span>
		<br>
		<span style="color:white;font-family: 'Permanent Marker', cursive;font-size:12pt;">Food Ordering System</span>
	</a>
	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../index.php">Home</a>
        </li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
			<a class="dropdown-item" href="../menu.php#lunch">Lunch Specials</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Dinner Specials</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="../menu.php">All</a>
			</div>
		</li>

        <li class="nav-item">
          <a class="nav-link" href="../aboutus.php">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="../contact.php">Contact</a>
        </li>
		
      </ul>
    </div>
</nav>
<br><br><br>

<!--User Views Start-->
<div id="myRadioGroup">
	<div class="middle" style="margin-top:60px; margin-bottom:10px; text-align:center;">
		Customer Login<input type="radio" name="user" checked="checked" value="1" style="margin-right:15px;"/>  
		Staff Login<input type="radio" name="user" value="2"/>
	</div>

    <div id="User1" class="desc">
		<div class="middle" style=" margin:0px auto;width:500px; margin-top:0px;">
			   <ul class="nav nav-tabs navbar_inverse" id="myTab" style="background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
				  <li class="nav-item">
					 <a class="nav-link active" style="color:#063344;" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Log In</a>
				  </li>
				  <li class="nav-item">
					  <a class="nav-link" id="signup-tab" style="color:#063344;" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Create New Account</a>
				  </li>
			   </ul>
			   <br><br>
			   <div class="tab-content" id="myTabContent">

			   <!--login Section-- starts-->
					<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
						<div class="footer" style="color:red;"><?php if(isset($loginmsg)){ echo $loginmsg;}?></div>
					  <form method="post" enctype="multipart/form-data">
							<div class="form-group">
							  <label for="email">Email address:</label>
							  <input type="email" class="form-control" name="email" id="email" required/>
							</div>
						   <div class="form-group">
							  <label for="pwd">Password:</label>
							 <input type="password" name="password" class="form-control" id="pwd" required/>
						   </div>
		 
						  <button type="submit" name="login" style="background:#0197A5; border:1px solid #0197A5;" class="btn btn-primary">Login </button>
						  <div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
					 </form>
					</div>
				<!--login Section-- ends-->

					
				<!--New Customer account Section-- starts-->
					<div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="profile-tab">
						<form method="post" enctype="multipart/form-data">
							<div class="form-group">
							  <label for="name">Name</label>
							  <input type="text" id="name"  class="form-control" name="name" required="required"/>
							</div>
							
							<div class="form-group">
							  <label for="email">Email</label>
							  <input type="email" id="email" name="email" class="form-control"  required/>
							</div>
							
						   <div class="form-group">
							  <label for="pwd">Password:</label>
							 <input type="password" name="password" class="form-control" id="pwd" required/>
						   </div>
						   
						   <div class="form-group">
							  <label for="mobile">Mobile</label>
							  <input type="tel" id="mobile" class="form-control" name="mobile" pattern="[2-9]{1}[0-9]{6}" placeholder="" required>
							</div>
		 
						  <button type="submit" name="register" style="background:#0197A5; border:1px solid #0197A5;" class="btn btn-primary">Create New Account</button>
						  <div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
					 </form>
					</div>    
			  </div>
		  </div>
    </div>
    <div id="User2" class="desc" style="display: none;">
		<div class="middle" style=" margin:0px auto;width:500px; margin-top:0px;">
			   <ul class="nav nav-tabs navbar_inverse" id="myTab2" style="background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
				  <li class="nav-item">
					  <a class="nav-link active" id="stafflogin-tab" style="color:#063344;" data-toggle="tab" href="#stafflogin" role="tab" aria-controls="stafflogin" aria-selected="true">Staff Login</a>
				  </li>		  
				  <li class="nav-item">
					  <a class="nav-link" id="staffsignup-tab" style="color:#063344;" data-toggle="tab" href="#staffsignup" role="tab" aria-controls="staffsignup" aria-selected="false">Create Staff Account</a>
				  </li>
			   </ul>
			   <br><br>
			   <div class="tab-content" id="myTabContent">

			<!--Staff login Section-- starts-->
					<div class="tab-pane fade show active" id="stafflogin" role="tabpanel" aria-labelledby="home-tab">
						<div class="footer" style="color:red;"><?php if(isset($loginmsg)){ echo $loginmsg;}?></div>
							<form method="post" enctype="multipart/form-data">
							<div class="form-group">
							<label for="s_id">Staff ID:</label>
							<input type="s_id" class="form-control" name="s_id" id="s_id" required/>
							</div>
						<div class="form-group">
							<label for="staffpwd">Password:</label>
							<input type="password" name="staffpwd" class="form-control" id="staffpwd" required/>
						</div>

						<button type="submit" name="login1" style="background:#0197A5; border:1px solid #0197A5;" class="btn btn-primary">Login </button>
						<div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
						</form>
					</div>
					<!--Staff login Section-- ends-->


					<!--New Staff account Section-- starts-->
					<div class="tab-pane fade" id="staffsignup" role="tabpanel" aria-labelledby="profile-tab">
						<form method="post" enctype="multipart/form-data">
							<div class="form-group">
							  <label for="ID">Staff ID</label>
							  <input type="text" id="s_id"  class="form-control" name="s_id" required="required"/>
							</div>
							
							<div class="form-group">
							  <label for="staffname">Name</label>
							  <input type="staffname" id="staffname" name="staffname" class="form-control"  required/>
							</div>

							<div class="form-group">
							  <label for="staffemail">Email</label>
							  <input type="staffemail" id="staffemail" name="staffemail" class="form-control"  required/>
							</div>
							
						   <div class="form-group">
							  <label for="staffpwd">Password:</label>
							 <input type="password" name="staffpwd" class="form-control" id="staffpwd" required/>
						   </div>
						   
						   <div class="form-group">
							  <label for="mobile">Mobile</label>
							  <input type="tel" id="staff_mobile" class="form-control" name="staff_mobile" pattern="[2-9]{1}[0-9]{6}" placeholder="" required>
							</div>
		 
						  <button type="submit" name="register1" style="background:#0197A5; border:1px solid #0197A5;" class="btn btn-primary">Create New Account</button>
						  <div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
					 </form>
					</div>
			  </div>
		  </div>
    </div>
</div>
<!--User Views End-->
<br><br> <br><br> <br><br>
<?php
include("footer.php");
?>	   
</body>
</html>




