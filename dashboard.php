
<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(!isset($_SESSION['admin']))
{
	header("location:admin.php");
	
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
if(isset($delete))
{
	header("location:deletefood.php?id=$delete");
}
if(isset($deleteManager))
{
	header("location:deleteManager.php?Managerid=$deleteManager");
}
$admin_info=mysqli_query($con,"select * from tbadmin where fld_username='$admin_username'");
$row_admin=mysqli_fetch_array($admin_info);
$user= $row_admin['fld_username'];
$pass= $row_admin['fld_password'];

//update
if(isset($update))
{
	if(mysqli_query($con,"update tbadmin set fld_password='$password'"))
	{
		//$_SESSION['pas_update_success']="Password Updated Successfully Login with New Password";
		unset ($_SESSION['admin']);
		header("location:admin_info_update.php");
	}
	else
	{
		echo "failed";
	}
}

//For meal manager
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

    header("location:dashboard.php");
  }
}
?>
<html>
  <head>
     <title>Admin control panel</title>
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

		ul li a:hover{text-decoration:none;}
		#social-fb,#social-tw,#social-gp,#social-em{color:blue;}
		#social-fb:hover{color:#4267B2;}
		#social-tw:hover{color:#1DA1F2;}
		#social-gp:hover{color:#D0463B;}
		#social-em:hover{color:#D0463B;}
	 </style>
	 <script>
			function delRecord(id)
			{
				//alert(id);
				
				var x=confirm("You want to delete this record? All Food Items Of the Menu Manager Will Also Be Deleted");
				if(x== true)
				{
					
					//document.getElementById("#result").innerHTML="success";
				  window.location.href='deleteManger.php?Managerid=' +id;		
				}
				else
				{
					window.location.href='#';
				}
				
			}
		</script>  
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
	<!--navbar ends-->

	<br><br><br><br>


<div style="position: relative;  min-height: 100vh;"><!--Container Div starts-->
	<div id="content-wrap" style="padding-bottom: 6rem;"><!--Page Content-->
		<!--details section-->
		<div class="container" style="margin-top:50px;"><!-- Main Div -->
		<!--tab heading-->
		<ul class="nav nav-tabs navbar_inverse" id="myTab" style="background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" style="color:#063344; font-weight:650;" id="viewitem-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="viewitem" aria-selected="true">View Food Items</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  style="color:#063344; font-weight:650;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="manageaccount" aria-selected="false">Account Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" style="color:#063344; font-weight:650;"  id="ManageMenuMan-tab" data-toggle="tab" href="#ManageMenuMan" role="tab" aria-controls="ManageMenuMan" aria-selected="false">Menu Manager Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" style="color:#063344; font-weight:650;" id="AddMenuMan-tab" data-toggle="tab" href="#AddMenuMan" role="tab" aria-controls="AddMenuMan" aria-selected="false">Add Menu Manager</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" style="color:#063344; font-weight:650;" id="orderstatus-tab" data-toggle="tab" href="#orderstatus" role="tab" aria-controls="orderstatus" aria-selected="false">Order status</a>
			</li>
		</ul>
		<br><br>

			<div class="tab-content" id="myTabContent" >
				<!--tab 1-->
				<div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
					<table class="table">
						<thead>
							<tr>
								<th scope="col"></th>
								<th scope="col">Cuisine Description</th>
								<th scope="col">Food Id</th>
								<th scope="col">Remove Item</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$query=mysqli_query($con,"select tblmanager.fldmanager_id,tblmanager.fld_name,tblmanager.fld_email,tbfood.food_id,tbfood.foodname,tbfood.cuisines,tbfood.fldimage from  tblmanager right join tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id");
								while($row=mysqli_fetch_array($query))
								{
								?>			            
									<tr>
										<td><img src="image/restaurant/<?php echo $row['fld_email']."/foodimages/" .$row['fldimage'];?>" height="50px" width="100px">
										<br><?php echo $row['foodname'];?>
										</td>
										<td><?php echo $row['cuisines'];?></td>
										<td><?php echo $row['food_id'];?></td>
								
										<form method="post">
										<td><a href=""><button type="submit" value="<?php echo $row['food_id']; ?>" name="delete"  class="btn btn-danger">Remove </button></td>
										</form>
								</tr>
								<?php
								}
								?>		   
						</tbody>
           			</table>
					<span style="color:green; text-align:centre;"><?php if(isset($success)) { echo $success; }?></span>	   
				</div>
				<!--tab 1 ends-->

				<!--tab 2-->
				<div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="manageaccount-tab">
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" id="username" value="<?php if(isset($user)){ echo $user;}?>" class="form-control" name="name" readonly="readonly"/>
						</div>
					
						<div class="form-group">
							<label for="pwd">Password:</label>
							<input type="password" name="password" class="form-control" value="<?php if(isset($pass)){ echo $pass;}?>" id="pwd" required/>
						</div>
						
						<button type="submit" name="update" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
						<div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
					</form>
				</div>
				<!--tab 2 ends-->

				<!--tab 3-->
				<div class="tab-pane fade" id="ManageMenuMan" role="tabpanel" aria-labelledby="ManageMenuMan-tab">
					<table class="table">
						<thead>
						<tr>
							<!--<th scope="col"></th>-->
								<th scope="col">Menu Manager Id</th>
								<th scope="col">Name</th>
								
								
								<th scope="col">Address</th>
								<th scope="col"></th>
							</tr>
						</thead>

						<tbody>
							<?php
							$query=mysqli_query($con,"select  * from tblmanager");
								while($row=mysqli_fetch_array($query))
								{
								?>	    
								<tr>
									<!--<td><img src="image/restaurant/<?php echo $row['fld_email']."/" .$row['fld_logo'];?>" height="50px" width="100px"></td>-->
									<th scope="row"><?php echo $row['fldmanager_id'];?></th>
									<td><?php echo $row['fld_name'];?></td>
									<td><?php echo $row['fld_address'];?></td>
									
									<form method="post">
									<td><a href="#"  style="text-decoration:none; color:white;" onclick="delRecord(<?php echo $row['fldmanager_id']; ?>)"><button type="button" class="btn btn-danger">Remove Menu Manager</a></a></td>
									</form>
								</tr>
								<?php
								}
								?>		   
						</tbody>
					</table>	
				</div>
				<!--tab 3 ends-->

				<!--tab 4-->
				<div class="tab-pane fade" id="AddMenuMan" role="tabpanel" aria-labelledby="AddMenuMan-tab">
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
				</div>
				<!--tab 4 ends-->
				
				<!--tab 5-->
				<div class="tab-pane fade" id="orderstatus" role="tabpanel" aria-labelledby="orderstatus-tab">
					<table class="table">
						<th>Order Id</th>
						<th>Food Ordered</th>
						<th>Customer Email Id</th>
						<th>Staff Id</th>
						<th>Order Status</th>
						<tbody>
							<?php			   
							$rr=mysqli_query($con,"select * from tblorder");
							while($rrr=mysqli_fetch_array($rr))
							{
								$stat=$rrr['fldstatus'];
								$foodid=$rrr['fld_food_id'];
								$r_f=mysqli_query($con,"select * from tbfood where food_id='$foodid'");
								$r_ff=mysqli_fetch_array($r_f);
							
							?>
							<tr>
							<td><?php echo $rrr['fld_order_id']; ?></td>

							<?php $f_id = $rrr['fld_food_id'];
									$foodquery=mysqli_query($con,"select foodname from tbfood where food_id='$f_id'");
									while($foodrow=mysqli_fetch_array($foodquery))
									{
								?>
									<td><a href="searchfood.php?food_id=<?php echo $rrr['fld_food_id']; ?>"><?php echo $foodrow['foodname']; ?></td>
								<?php } ?>
						
						
							<td><?php echo $rrr['fld_email_id']; ?></td>
							<td><?php echo $rrr['staff_id']; ?></td>
							<?php
							if($stat=="cancelled" || $stat=="Out Of Stock")
							{
							?>
								<td><i style="color:orange;" class="fas fa-exclamation-triangle"></i>&nbsp;<span style="color:red;"><?php echo $rrr['fldstatus']; ?></span></td>
							<?php
							}
							else
								
							{
							?>
								<td><span style="color:green;"><?php echo $rrr['fldstatus']; ?></span></td>
							<?php
							}
							?>
							
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<!--tab 5 ends-->
			</div><!--My tab content Ends-->
		</div><!-- Main Div Ends-->
	</div><!--Page Content Ends-->
	<footer id="footer">
		<?php
			include("footer.php");
		?>
	</footer>
</div><!--End Container Div-->
</body>
</html>	