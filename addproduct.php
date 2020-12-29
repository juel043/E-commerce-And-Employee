<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'dbconfig.php';
	
	if(isset($_POST['btnsave']))
	{
		$username = $_POST['user_name'];// user name
		$useremail =$_POST['user_email'];//user email
		$userjob = $_POST['user_job'];// user email
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		
		if(empty($username))
		{
			$errMSG = "Please Enter Username.";
		}
		else if(empty($useremail))
		{
			$errMSG = "Please Enter Ur Mail.";
		}
		else if(empty($userjob))
		{
			$errMSG = "Please Enter Your Job Work.";
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
			$stmt = $DB_con->prepare('INSERT INTO tbl_users(Name,Email,Profession,Pic) VALUES(:uname,:uemail, :ujob, :upic)');
			$stmt->bindParam(':uname',$username); //PDOStatement::bindParam — Binds a parameter to the specified variable name.
			$stmt->bindParam(':uemail',$useremail);
			$stmt->bindParam(':ujob',$userjob);
			$stmt->bindParam(':upic',$userpic);
			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:2;home.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
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
    	<h1 class="text-center bg-primary text-white">All Member List </h1> 
    	<p class="text-center bg-primary "><a class="text-white"href="home.php">View All</a></p>
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
			<label class="text-primary">Name</label>
				<input type="text" name="user_name" placeholder="Enter Username" class="form-control"  
						value="<?php echo $username; ?>"/>
				
			</div>
			<div class="form-group">
				<label class="text-primary">Email</label>

				<input type="text" name="user_email" placeholder="Enter Your Email"  class="form-control" 
						value="<?php echo $useremail; ?>"/>
			</div>
			<div class="form-group">
				<label class="text-primary">Profession</label>

				<input type="text" name="user_job" placeholder="Your Profession" class="form-control"  
						value="<?php echo $userjob; ?>"/>
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