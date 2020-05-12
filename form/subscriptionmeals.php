<?php
session_start();
include("../connection.php");


$meal = $_GET['meal'];

$staff_id = "";
$dt = $_GET['dt'];
$subscription_id = "";
$mimage = "";

extract($_REQUEST);
$arr=array();

if(isset($_SESSION['staff_id']))
{
    $staff_id=$_SESSION['staff_id'];
	$qq=mysqli_query($con,"select * from tblstaff where staff_id='$staff_id'");
	$qqr= mysqli_fetch_array($qq);
	$cust_id="";
}
else
{
	$cust_id="";
	$staff_id="";
}

$query=mysqli_query($con,"select  tblmanager.fld_name,tblmanager.fldmanager_id,tblmanager.fld_email,
tblmanager.fld_mob,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
tbfood.qty_available,tbfood.paymentmode from tblmanager inner join tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['food_id'];
	shuffle($arr);
}

$query=mysqli_query($con,"Select * from mealsubscription where staff_id='$staff_id' AND subcription_date='$dt'");
if($row=mysqli_fetch_array($query))
{
    $subscription_id = $row['subscription_id'];
    
}
//print_r($arr);

if(isset($addtocart))
{ 
    
    $addtocart =(int)$addtocart;
    $query=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob, tblmanager.fld_phone,tblmanager.fld_address,
    tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost, tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,
    tbfood.qty_available from tblmanager inner join tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id 
    where tbfood.fldmanager_id=tblmanager.fldmanager_id && tbfood.food_id=$addtocart");

        while($res=mysqli_fetch_assoc($query))
            {
                $mimage = "../image/restaurant/". $res['fld_email']."/foodimages/".$res['fldimage'];
            }
    $_POST['foodqty'] = 1;
   if(!empty($_SESSION['cust_id']) || !empty($_SESSION['staff_id']))
   {
       $query=mysqli_query($con,"select qty_available from tbfood where food_id =$addtocart");

       while($res=mysqli_fetch_assoc($query))
       {
           if($_POST['foodqty'] > $res['qty_available'])
           {
               echo "<script> alert('Error: Cannot proceed to cart. Quantity ordered exceeds current available quantity');document.location='menu.php'</script>";
           }
           else if($_POST['foodqty'] == 0)
           {
               echo "<script> alert('Error: Cannot proceed to cart. Please enter a valid quantity [>0]');document.location='menu.php'</script>";
           }
           else
           {
 
               $_SESSION['qty'] = $_POST['foodqty'];
               $sql = "Update mealsubscription SET meal='$addtocart', meal_image='$mimage' WHERE subscription_id='$subscription_id' ";
                
                    if(mysqli_query($con, $sql))
                    {
                        
                        header("location:subscriptionconfirmation.php?id=".(int)$subscription_id);
                    }
                    
                    else
                    {
                        echo "Error: " . $sql . "" . mysqli_error($conn);
                    }
               	
           }
       }
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

$query=mysqli_query($con,"select tbfood.foodname,tbfood.fldmanager_id,tbfood.cost,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id 
						 from tbfood inner join tblcart on tbfood.food_id=tblcart.fld_product_id 
						 where tblcart.fld_customer_id='$cust_id'
						 OR tblcart.fld_staff_id='$staff_id'
						 ");
$re=mysqli_num_rows($query);


?>
<html>
  <head>
     <title>Subscription</title>
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
		});

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

		/*Adjusting to the meal heading when clicking breakfast section */
		/*Not in use for release 1*/
		h1.breakfast-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.breakfast-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		/*Adjustment of lunch meal just for release 1*/
		/*Will not use after including breakfast and dinner */
		h1.lunch-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.lunch-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		h1.dinner-meal{
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.dinner-meal::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}
		
		h1.custom-menu {
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.custom-menu::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}

		h1.beverage {
			color:#0197A5;
			font-family: 'Permanent Marker', cursive;
			text-decoration: underline;
		}

		h1.beverage::before { 
		display: block; 
		content: " "; 
		margin-top: -110px; 
		height: 110px; 
		visibility: hidden; 
		pointer-events: none;
		}
	
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
                    <a class="nav-link" style="color:#063344; font-weight:650;" id="viewitem-tab"  href="subscription.php" role="tab" aria-controls="viewitem" aria-selected="true" >Active Subscription</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" style="color:#063344; font-weight:650;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="manageaccount" aria-selected="false">New Subscription</a>
                </li>
            </ul>

            <br><br>
            <!--Menu Begins-->
        <!--Breakfast meals-->
        <h1 class="breakfast-meal" id="breakfast" align="center" ><?php echo $meal;?> & Regular Meals</h1>
            <div class="row">
            <?php
                $query=mysqli_query($con,"select tblmanager.fld_email,tblmanager.fld_name,tblmanager.fld_mob,
                tblmanager.fld_phone,tblmanager.fld_address,tblmanager.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
                tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage,tbfood.food_time,tbfood.qty_available from tblmanager inner join
                tbfood on tblmanager.fldmanager_id=tbfood.fldmanager_id where (tbfood.fldmanager_id=tblmanager.fldmanager_id) && (tbfood.food_time='$meal' OR tbfood.food_time='regular')");

                    while($res=mysqli_fetch_assoc($query))
                        {
                            //$food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];	
                        ?>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">
                                    <b><?php echo $res['foodname'] ?></b>
                                </div>
                                <div class="panel-body">
                                    <img src="../image/restaurant/<?php echo $res['fld_email']."/foodimages/".$res['fldimage'];?>"  height="300px" width="100%">
                                </div>
                                <span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;"><?php echo $res['fld_name']; ?></span>
                                <br>
                                <span style="color:black; font-size:20px; white-space:nowrap;">Price: $<?php echo $res['cost']; ?></span>
                                <br>
                                
                                <form action="" method="post" id="cart">
                                    

                                    <div align="left">
                                    <span style="color:black; font-size:20px; white-space:nowrap;">Add to Subscription: </span>
                                    <button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" >
                                    <span style="color:green; font-size:25px;"><i class="fa fa-check" aria-hidden="true"></i></span></button>
                                    </div>
                                </form>
                            </div>			
                        </div>
                    
                <?php } ?>
            </div>
            <!--Breakfast meals end-->`	
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