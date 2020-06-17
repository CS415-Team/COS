<?php
session_start();
include("../connection.php");
$_SESSION["id"] ="";
$id = 0;
if(isset($_GET["id"]))
{
    $id = $_GET['id'];
    //echo "<script type='text/javascript'>alert('$id');</script>";
    $_SESSION["id"] = $id;
}



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






 
 if(isset($login))
 {
	 header("location:form/index.php");
 }
 if(isset($logout))
 {
	 session_destroy();
	 header("location:index.php");
 }




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
        <li class="nav-item">
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
        
            <div class="tab-content" id="myTabContent" >
					<div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab" >
						<!--Delivery location section-->
							
							<div class="w3-container" style=" margin-top:5px;border-radius: 25px; border: 1.5px solid #0197A5; padding: 20px;  width: 100%; ">
								<div style="overflow-x:auto;">
								<table id="table1" class="table" style="width: 100%; border-collapse: collapse; ">
                                    <tbody>
                                    <tr style="font-weight:bold;">
                                            <th></th> 
                                            <th>Meal</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Delivery Time</th>
                                            <th>Location</th>
											<th>Quantity</th>
                                            <th>Total</th>
                                            
                                        </tr>
                                    <?php
                                        $query=mysqli_query($con,"SELECT mealsubscription.subscription_id, mealsubscription.staff_id,mealsubscription.quantity, mealsubscription.subcription_date, mealsubscription.start_date, mealsubscription.end_date, mealsubscription.delivery_time, mealsubscription.delivery_location, mealsubscription.meal, mealsubscription.meal_image, tbfood.food_id, tbfood.foodname, tbfood.cost from mealsubscription 
                                        join tbfood on mealsubscription.meal=tbfood.food_id where mealsubscription.subscription_id='$id'");

                                            while($res=mysqli_fetch_assoc($query))
                                                {
                                                    //$food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];	
                                                ?>
                                        
                                        <tr>
                                            <td><image src=<?php $img = str_replace(' ', '%20', $res["meal_image"]); echo $img;?> height="80px" width="100px"> </td>
                                            <td><?php echo $res["foodname"]?> </td>
                                            <td><?php echo $res["start_date"]?></td>
                                            <td><?php echo $res["end_date"]?> </td>
                                            <td><?php echo $res["delivery_time"]?> </td>
                                            <td><?php echo $res["delivery_location"]?> </td>
											<td><?php echo $res["quantity"]?> </td>
                                            <td>$<?php echo $res["cost"] * $res["quantity"]?>:00 </td>
                                            
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
								</div>
                                <form id="deliv_pay" method="post" action="subscriptionmealsuccess.php?id=<?php echo $id;?>">
								<!---->
                                <div class="form-group">
                                
                                <label style=" color:black; font-weight:bold; text-transform:uppercase; margin-left:40px;"> Choose a Payment Method:</label>
											<select id="payment" name="payment" onchange="showcardpayment(this.options[this.selectedIndex].value)">
												<option disabled selected value=" ">Payment Options</option>
												<option value="Payroll Deduction">Payroll Deduction</option>
												
												<option value="Card Payment">Card Payment</option>
											</select>
								</div>

								<div class="row"><!--Row 3-->
									<div class="column" style="float:left; width: 33.33%;"></div><!--R3 C1 Ends-->
									<div class="column" style="text-align:center; width: 33.33%;"><!--R3 C2 Starts-->
										<div>
											<label id="error_message" class="text-danger"></label>  
											<label id="success_message" class="text-success"></label>
										</div>
										<div id="cardpayment" style="display:none;">
											<div class="payment">
													<div class="form-group owner">
														<label for="owner" style="font-weight:bold;">Owner</label>
														<input type="text" class="form-control" id="owner" name="owner">
													</div>
													<div class="form-group CVV">
														<label for="cvv" style="font-weight:bold;">CVV</label>
														<input type="text" class="form-control" id="cvv" name="cvv">
													</div>
													<div class="form-group" id="card-number-field">
														<label for="cardNumber" style="font-weight:bold;">Card Number</label>
														<input type="text" class="form-control" id="cardNumber" name="cardNumber">
													</div>
													<div class="form-group" id="expiration-date">
														<label style="font-weight:bold;">Expiration Date: </label>
														<select id="month" name="month">
															<option value="01">January</option>
															<option value="02">February </option>
															<option value="03">March</option>
															<option value="04">April</option>
															<option value="05">May</option>
															<option value="06">June</option>
															<option value="07">July</option>
															<option value="08">August</option>
															<option value="09">September</option>
															<option value="10">October</option>
															<option value="11">November</option>
															<option value="12">December</option>
														</select>
														<select id="year" name="year">
															<option value="2020"> 2020</option>
															<option value="2021"> 2021</option>
															<option value="2022"> 2022</option>
															<option value="2023"> 2023</option>
															<option value="2024"> 2024</option>
															<option value="2025"> 2025</option>
															<option value="2026"> 2026</option>
														</select>
													</div>
													<div class="form-group" id="credit_cards">
														<img src="../img/visa.jpg" id="visa">
														<img src="../img/mastercard.jpg" id="mastercard">
														<img src="../img/amex.jpg" id="amex">
													</div>
												
											</div>
										</div>
									</div><!--R3 C2 Ends-->
								</div><!--Row 3 Ends-->
                                <div style="text-align:right;">
								<button type="submit" name="update" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Continue</button>
							</div> 
                            </form >
							</div>
							</div><!--Container Ends-->
						
					</div><!--Tab 1 Ends-->
					<script src="js/jquery.payform.min.js" charset="utf-8"></script>
						<script>
						//Check current card value
						function checkcard()
						{
							var sel = document.getElementById("payment");
							var value= sel.options[sel.selectedIndex].value;
							if(value == 'Card Payment')
							{
								$("#cardpayment").css('display', 'block');
							}
						};

						//Card payment field Show
						function showcardpayment(value)
						{
							if(value=='Card Payment')
							{
								$("#cardpayment").css('display', 'block');
						
							}
							else
							{
								$("#cardpayment").css('display', 'none');
							}
						};

						//User defined location field Show
						function showloc(id)
						{
							if(id=='UserLoc')
							{
								var x = document.getElementById('Location');
								x.style.display = "block";
								$("#cardpayment").css('display', 'none');

								$("#txtBox").keyup(function() {
									var inputVal = document.getElementById("txtBox").value;
									if(inputVal.length == 0)
									{
										$("#payment_opt").css('visibility', 'hidden');
										$("#cardpayment").css('display', 'none');	
									}
									else
									{
										$("#deliv option:selected").val(inputVal);
										$("#payment_opt").css('visibility','visible');
										checkcard();
									} 
								});
							}
							else
							{
								$("#payment_opt").css('visibility', 'hidden');
								var x = document.getElementById('Location');
								x.style.display = "none";
							}
						};

						//Payment hide/unhide 
						$(document).ready(function(){
							var delivery = $('deliv').val();
							$('#deliv').on('change', function() {
								if (this.value && this.value != "None")
								{
									$("#payment_opt").css('visibility','visible');
									checkcard();
								}
								else
								{
									$("#payment_opt").css('visibility', 'hidden');
								}
							});
						});

						$(function() {
							var owner = $('#owner');
							var cardNumber = $('#cardNumber');
							var cardNumberField = $('#card-number-field');
							var CVV = $("#cvv");
							var mastercard = $("#mastercard");
							var visa = $("#visa");
							var amex = $("#amex");

							// Use the payform library to format and validate
							// the payment fields.

							cardNumber.payform('formatCardNumber');
							CVV.payform('formatCardCVC');

							cardNumber.keyup(function() {
								visa.css('opacity', 1);
								mastercard.css('opacity', 1);
								amex.css('opacity', 1);

								if ($.payform.validateCardNumber(cardNumber.val()) == false) 
								{
									cardNumberField.addClass('has-error');
								} 
								else 
								{
									cardNumberField.removeClass('has-error');
									cardNumberField.addClass('has-success');
								}

								if ($.payform.parseCardType(cardNumber.val()) == 'visa') 
								{
									mastercard.css('opacity', .3);
									amex.css('opacity', .3);

								} 
								else if ($.payform.parseCardType(cardNumber.val()) == 'amex') 
								{
									mastercard.css('opacity', .3);
									visa.css('opacity', .3);
								} 
								else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') 
								{
									visa.css('opacity', .3);
									amex.css('opacity', .3);
								}
							});

							//Payment submission success/failure message  
							$("#deliv_pay").submit(function( event ) {
								  
								var payment = $('#payment').val();
								var $this = $(this);

								event.preventDefault();
							
								if(!$('#payment').val())
								{  
									$('#error_message').fadeIn().html("Please select appropriate information");
									setTimeout(function(){
											$('#error_message').fadeOut();
									}, 1500);
								}  
								else if($('#payment').val() == "Card Payment" )
								{
									var isCardValid = $.payform.validateCardNumber(cardNumber.val());
									var isCvvValid = $.payform.validateCardCVC(CVV.val());

									if(owner.val().length < 5){
										alert("Wrong owner name");
									} 
									else if (!isCardValid) {
										alert("Wrong card number");
									} 
									else if (!isCvvValid) {
										alert("Wrong CVV");
									} 
									else 
									{
										// Everything is correct
										$("#error_message").html("").hide();
										$('#success_message').fadeIn().html("Delivery and Payment Info Confirmed");  
										setTimeout(function(){
												$('#success_message').fadeOut();
										}, 1500);

										$this.unbind("submit");
										setTimeout( $.proxy( $.fn.submit, $this ), 2000);
									}
								}
								else
								{
									$("#error_message").html("").hide();
									$('#success_message').fadeIn().html("Delivery and Payment Info Confirmed");  
									setTimeout(function(){
											$('#success_message').fadeOut();
									}, 1500);

									$this.unbind("submit");
									setTimeout( $.proxy( $.fn.submit, $this ), 2000);
								}
							});
						});					

						//Error mssg when meal pickup or delivery and payment info not filled 
						function ErrorMssg() 
						{
							alert("Please fill out all the required information before proceeding to checkout");
						}

						</script>


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