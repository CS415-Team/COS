<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(isset($_SESSION['id']))
{
	$res_name=$_GET['res_name'];
    if(!empty($_GET['food_id']))
    {
		$food_id=$_GET['food_id'];
        if(!empty($_GET['meal_type']))
        {
            $meal_type=$_GET['meal_type'];
        }
        else
        {
            header("location:update.php?food_id=$food_id&res_name=$res_name");
        }
    }
    else
    {
        header("location:update.php?food_id=$food_id&res_name=$res_name");
    }
}
else
{
	header("location:manager_login.php");
}


if(isset($add))
{
   if(!empty($_SESSION['id']))	
   {
		if(count($_POST))
		{
			$len = count($_POST['ingred_name']);
			for ($i=0; $i < $len; $i++)
			{
				$ing_name = $_POST['ingred_name'][$i];
				$ing_type= $_POST['ingred_type'][$i];
				$ing_price=$_POST['ingred_price'][$i];

				if(mysqli_query($con,"insert into ingredient(ingred,ingred_type,meal_type,price,available,food_id) values
				('$ing_name','$ing_type','$meal_type','$ing_price','1','$food_id')"))
				{
					header("location:update.php?food_id=$food_id&res_name=$res_name");
				}
				else
				{
					echo "failed to insert into ingredient table";
				}
			}
		}

    }
    else
    {
        header("location:manager_login.php");
    }
}


if(isset($logout))
{
	session_destroy();
	header("location:index.php");
}
?>
<html>
<head>
  <title>Add Ingredient</title>
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
	 </style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #0197A5;">
  
<a class="navbar-brand" href="../index.php"><img src="img/USP Logo.png" style="display: inline-block;"></a>
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
			if(empty($_SESSION['id']))
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
			<div class="middle" style="padding:40px; border:0px solid #ED2553; margin-top:50px; width:100%;">
			<!--tab heading-->
				<ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="home" aria-selected="true">Add Ingredients</a>
					</li>
					<a class="nav-link" style="color:white;" id="profile-tab"  aria-selected="false">Ingredient Details</a>	  
				</ul>
				<br>

                <!--tab  starts-->   
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
						<!--add Product-->
						<form id="ingred-form" action="" method="post" enctype="multipart/form-data">
							<div id="ingredient_add">	
								<span id="ing-label" style="font-weight:bold;">New Ingredient</span>	
								<div class="form-group"><!--ingred_name-->
									<label for="ingredient_name">Ingredient Name:</label>
									<input type="text" class="form-control" id="ingred_name" value="" placeholder="Enter ingredient name" name="ingred_name[]">
								</div>
								
								<div class="form-group"><!--Ingredient Type-->
								<label for="ingred_type">Ingredient Type :</label>
								<input type="text" class="form-control" id="ingred_type"  value="" placeholder="E.g. meat" name="ingred_type[]">
								</div>
								
								<div class="form-group"><!--Ingred Price-->
									<label for="price">Price :</label>
									<input type="number" class="form-control" id="price"  value="" placeholder="0" name="ingred_price[]">
								</div>	
							</div>
							<div id="writefield"></div>
						</form>
						<button onclick="moreFields()" class="btn btn-info" id="moreFields">Add Another Ingredient</button>
						<button type="submit" name="add" form="ingred-form" class="btn btn-primary">Submit</button>
						<button onclick="window.location.href='update.php?food_id=<?php echo $food_id;?>&res_name=<?php echo $res_name;?>'" type="button" name="back" class="btn btn-danger btn-primary">Go Back</button>
                    </div>
                    <!--tab for  item ends-->	   
                </div><!--Tab content ends-->	
				<script>
					var counter = 0;
					function moreFields() 
					{
						counter++;
						var newFields = document.createElement('div');
						newFields.id = counter;
						var delFields = '<input type="button" style="font-size:14px;" value="Remove New Field" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" /><br>';
						newFields.innerHTML = delFields + document.getElementById('ingredient_add').innerHTML;
						document.getElementById('writefield').append(newFields);

					}
				</script>
			</div><!--Middle class ends-->
		</div> <!--Page content ends-->
		<footer id="footer">
			<?php
				include("footer.php");
			?>
		</footer>
	</div><!--Container Div ends-->  
</body>
</html>