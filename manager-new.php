<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(!isset($_SESSION['admin']))
{
  header("location:admin.php?msg=Please Login To continue");
}
else
{
  $admin_username=$_SESSION['admin'];
}
if(isset($logout))
{
  unset ($_SESSION['admin']);
  setcookie('logout','loggedout successfully',time() +5);
  header("location:admin.php");
}

if(isset($register))
{
  $sql=mysqli_query($con,"select * from tblmanager where fld_email='$email'");
  if(mysqli_num_rows($sql))
  {
    $email_error="This Email Id is already registered with us";
  }
  else
  {
    $logo=$_FILES['logo']['name'];
    $sql=mysqli_query($con,"insert into tblmanager 
    (fld_name	,fld_email,fld_password,fld_mob,fld_phone,fld_address,fld_logo)
      values('$r_name','$email','$pswd','$mob','$phone','$address','$logo')");

    if($sql)
    {
      mkdir("image/restaurant");
      mkdir("image/restaurant/$email");
      
      move_uploaded_file($_FILES['logo']['tmp_name'],"image/restaurant/$email/".$_FILES['logo']['name']);
    }
    $_SESSION['id']=$email;

    header("location:food.php");
  }
}
?>


<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
    <title>Manager Registration Form</title>
  <!--bootstrap files-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <!--bootstrap files-->

  <!--font files-->
  <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">
  <!---->


		<style>
		ul li{list-style:none;}
		ul li a {color:black;text-decoration:none; }
		ul li a:hover {color:black; text-decoration:none;}
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
    if(!empty($admin_username))
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
          <a class="nav-link" href="index.php" style="color:black;font-weight:700">Home</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"  style="color:#063344;font-weight:650" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

				<?php
        if(isset($_SESSION['admin']))
        {
          ?>
          <li class="nav-item">
                <a class="nav-link" href="">
              <form method="post">
              <button type="submit" name="logout" class="btn btn-danger">Log Out</button>
            </form>
            </a>
                </li>
          <?php
        }        
        ?>
		
      </ul>
    </div>
</nav>
<br><br><br>
<div class="container" style="margin:0px auto; border:1px solid #F8F9FA;  width:800px; margin-top:110px;">
       <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" style="color:#063344; font-weight:650;" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="true">Register Menu Manager</a>
          </li>
       </ul>
	   <br><br>
	   <!--tab 1 starsts-->
	   <div class="tab-content" id="myTabContent">
	       <div class="tab-pane fade show active" id="register" role="tabpanel" aria-labelledby="home-tab">
			    <div class="footer" style="color:red;"><?php if(isset($loginmsg)){ echo $loginmsg;}?></div>
			    <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="name">Name:</label>
                          <input type="text" class="form-control" id="name" value="<?php if(isset($r_name)) { echo $r_name;}?>" placeholder="Enter Manager Name" name="r_name" required/>
                      </div>
	                  <div class="form-group">
                          <label for="name">Email Id:</label>
                          <input type="email" class="form-control" id="email" value="<?php if(isset($email)) { echo $email;}?>" placeholder="Enter Email" name="email" required/>
                          <span style="color:red;"><?php if(isset($email_error)){ echo $email_error;} ?></span>
	                  </div>
	                 <div class="form-group">
                         <label for="pswd">Password:</label>
                         <input type="password" class="form-control" id="pswd" placeholder="Enter Password" name="pswd" required/>
                     </div>
                     <div class="form-group">
                         <label for="mob">Mobile:</label>
                         <input type="tel" class="form-control" pattern="[2-9]{1}[0-9]{6}" value="<?php if(isset($mob)) { echo $mob;}?>"id="mob" placeholder="9123456578" name="mob" required/>
                     </div>
	                 <div class="form-group">
                          <label for="phone">Phone:</label>
                          <input type="tel" class="form-control" pattern="[2-9]{1}[0-9]{6}" id="phone" value="<?php if(isset($phone)) { echo $phone;}?>" placeholder="011-1234567" name="phone" required>
                     </div>
	                 <div class="form-group">
                          <label for="add">Address:</label>
                          <input type="text" class="form-control" id="add" placeholder="Enter Address" value="<?php if(isset($address)) { echo $address;}?>" name="address" required>
                     </div>
	                 <div class="form-group">
                          <input type="file"  name="logo" required>Upload Logo 
                     </div>
                     <button type="submit" id="register" name="register" class="btn btn-primary">Register</button>
                     
                </form>
				<br>
			</div>

	   </div>
	</div>
	<br>
	 <?php
			include("footer.php");
			?>
	 
	   
</body>
</html>