<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(isset($_SESSION['id']))
{
	header("location:food.php");
}

if(isset($login))
{
  $sql=mysqli_query($con,"select * from tblmanager where fld_email='$username' && fld_password='$pswd' ");
  if(mysqli_num_rows($sql))
  {
      $_SESSION['id']=$username;
      header('location:food.php');	
  }
  else
  {
      $admin_login_error="Invalid Username or Password";	
  }
}
   
?>

<html>
<head>
  <meta charset="UTF-8">
    <title>Menu Manager Login</title>
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
		ul li a:hover {color:black;text-decoration:none; }

		#footer {
			position: absolute;
			bottom: 0;
			width: 100%;
			height: 4rem;/* Footer height */
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

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
    
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php" style="color:black;font-weight:700">Home</a>
          </li>

          <li class="nav-item dropdown">
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
            <a class="nav-link" href="site-help.php" style="color:#063344;font-weight:650">Help</a>
          </li>
        </ul>
      </div>
  </nav>

<div style="position: relative;  min-height: 100vh;"><!--Container Div-->
<div id="content-wrap" style="padding-bottom: 1rem;"><!-- all other page content -->
  <div class="container justify-content-center" style=" position:relative; padding:40px; border:1px solid #0197A5; margin-top:150px; width:400px;">
      <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">Manager Login</a>
        </li>
        
            <a class="nav-link" id="profile-tab" style="color:white;" aria-controls="profile" aria-selected="false">Welcome</a>
        
      </ul>
    <br><br>
    <div class="tab-content" id="myTabContent">
    <!--login Section-- starts-->
          <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
        <div class="footer" style="color:red;"><?php if(isset($admin_login_error)){ echo $admin_login_error;}?></div>
      <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="username">Username:</label>
                  <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" required/>
              </div>
              <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required/>
              </div>
              <button type="submit" name="login" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!--login Section-- ends-->            
    </div>
  </div>

	</div> <!--Page content ends-->
		<footer id="footer">
			<?php
				include("footer.php");
			?>
		</footer>
	</div><!--Container Div ends-->  

</body>		
<div>
</html>
