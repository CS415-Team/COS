<?php
$connect = mysqli_connect("localhost", "root", "", "dbfood");
$output = '';
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($connect, $_POST["query"]);
	$query = "
	SELECT * FROM tbfood 
	WHERE foodname LIKE '%".$search."%'
	OR Cuisines LIKE '%".$search."%' 
	
	";
}
else
{
	$query = "
	SELECT * FROM tbfood ";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
	$output .= '';
	while($row = mysqli_fetch_array($result))
	{
		$food_id= $row['food_id'];
		$output .= '
			<style>
				#myUL {
					list-style-type: none;
					padding: 0;
					margin: 0;
					text-align:center;
				}
				
				#myUL li a {
					border: 1px solid #ddd;
					margin-top: -1px; /* Prevent double borders */
					background-color: #f6f6f6;
					padding: 12px;
					text-decoration: none;
					font-size: 18px;
					color: black;
					display: block
				}
				
				#myUL li a:hover:not(.header) {
					background-color: #eee;
				}
			</style>

			<ul id="myUL">
				<li>
					<a href="searchfood.php?food_id='.$food_id.'">'.$row["foodname"].'</a>
				</li>
			</ul>
		';
	}
	echo $output;
}
else
{
	echo 'Data Not Found';
}
?>