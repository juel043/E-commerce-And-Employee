
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'dbconfig.php';
	
	if(isset($_POST['btnsave']))
	{
		$catagoryname = $_POST['catagory_name'];

		if(empty($catagoryname))
		{
			$errMSG = "Please Enter catagoryname.";
		}

		if(!isset($errMSG))
		{

			$stmt = $DB_con1->prepare('INSERT INTO brand(brand_name) VALUES(:pname)');
			$stmt->bindParam(':pname',$catagoryname); ;
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				
				// header("refresh:2;home.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}



?>
<?php
			error_reporting( ~E_NOTICE );
			if(isset($errMSG))
			{
				?>
				<div>
					<span></span> <strong><?php echo $errMSG; ?></strong>
				</div>
				<?php
			}

			else if(isset($successMSG))
			{
				?>
				<div>
					<strong><span></span> <?php echo $successMSG; ?></strong>
				</div>
				<?php
			}
			?>   
<html>
<head>
<title> Catagory</title>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body>
	<div class="container-fluid">

			<div class="page-header">
				<h1 class="text-center bg-primary text-white">All Product List </h1> 
			</div>
			<div align="center" >
          <a href="home.php " class="btn btn-success text-center mr-2">Home</a>
            <a href="addproductitem.php " class="btn btn-success text-center">Add Product</a>
          </div> 
		</div>
<form method="post">
   <div class="form-group">
					<label class="text-primary">Product Name</label>
					<input type="text" name="catagory_name" placeholder="Enter catgoryname" class="form-control"  
					value="<?php echo $catagoryname ;?>"/>

				</div>

          <div class="form-group">
					<button type="submit" class="form-control btn btn-danger" name="btnsave">Save</button>
				</div>
				</form>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>