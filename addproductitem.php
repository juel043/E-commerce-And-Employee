<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'dbconfig.php';
	
	if(isset($_POST['btnsave']))
	{
		$productname = $_POST['product_name'];// user name
		$productmodel =$_POST['product_model'];//user email
		$productprice = $_POST['product_price'];// user email
		$brandid =$_POST['brand_id'];
		$brandname =$_POST['brand_name'];
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		
		if(empty($productname))
		{
			$errMSG = "Please Enter productname.";
		}
		else if(empty($productmodel))
		{
			$errMSG = "Please Enter productmodel.";
		}
		else if(empty($productprice))
		{
			$errMSG = "Please Enter Your Job Work.";
		}
		else if(empty($brandid))
		{
			$errMSG = "Please Enter Your brand id.";
		}
		
		else if(empty($imgFile))
		{
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = 'user_images/'; // upload directory

			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;

			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions))
			{			
				// Check file size '5MB'
				if($imgSize < 5000000)				
				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{

			$stmt = $DB_con1->prepare('INSERT INTO product(p_name,p_model,p_price,p_pic,brand_id) VALUES(:pname,:pmodel, :pprice, :ppic,:bid)');
			$stmt->bindParam(':pname',$productname); //PDOStatement::bindParam — Binds a parameter to the specified variable name.
			$stmt->bindParam(':pmodel',$productmodel);
			$stmt->bindParam(':pprice',$productprice);
			
			$stmt->bindParam(':ppic',$userpic);
			$stmt->bindParam(':bid',$brandid);
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				$productname="";
				$productmodel="";
				$productprice="";
				$brandid="";
				$brandname="";
				$userpic="";
				// header("refresh:2;home.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}
if(!isset ($errMSG))
{
	$stmt2 =$DB_con1->prepare('SELECT * FROM brand');
	$stmt2->execute();


	if($stmt2->rowCount() > 0){
		while (	$row=$stmt2->fetch(PDO::FETCH_ASSOC)) 
		{
			$output .= '<option  value="'.$row["brand_id"].'">'.$row["brand_name"].'</option>';
		}
	}
}

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>add product</title>
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
            <a href="addcatagory.php " class="btn btn-success text-center">Add Catagory</a>
          </div> 
		</div>
		<div class="container">
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
			<form method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label class="text-primary">Product Name</label>
					<input type="text" name="product_name" placeholder="Enter productname" class="form-control"  
					value="<?php echo $productname ;?>"/>

				</div>

				<div class="form-group">
					<label class="text-primary">Product Model</label>
					<input type="text" name="product_model" placeholder="Enter Product Model" class="form-control"  
					value="<?php echo $productmodel ;?>"/>

				</div>
				<div class="form-group">
					<label class="text-primary">Product Price</label>

					<input type="text" name="product_price"  class="form-control"  
					value="<?php echo $productprice ;?>"/>
				</div>
				<div class="form-group">
					<label class="text-primary">Brand Id </label>
					<select name="brand_id">
						<option>Select Your item</option>
						<?php
						echo $output;
						?>
					</select>

				<!-- <input type="text" name="brand_id" placeholder="Brand Id" class="form-control"  
					value=""/> -->
				</div>
				
				<div class="form-group">
					<input type="file" name="user_image" class="form-control" accept="image/*" />
				</div>
				<div class="form-group">
					<button type="submit" class="form-control btn btn-danger" name="btnsave">Save</button>
				</div>

			</form>


		</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</body>
	</html>