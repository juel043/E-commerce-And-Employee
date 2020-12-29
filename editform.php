<?php

	error_reporting( ~E_NOTICE );
	
	require_once 'dbconfig.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		
		$stmt_edit = $DB_con->prepare('SELECT Name,Email,Profession,Pic FROM tbl_users WHERE id =:uid');
		
		$stmt_edit->execute(array(':uid'=>$id));
		 //You can add binded parameters in the array instead of useing the function bindParam()beforehand((ie - array key=>field name).
		
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: home.php");
	}
	if(isset($_POST['btn_cancel']))
	{
		header("Location: home.php");
	}
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$username = $_POST['user_name'];// user name
		$useremail = $_POST['user_email'];// user email
		$userjob = $_POST['user_job'];//proffession

		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = 'user_images/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['Pic']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['Pic']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
		$stmt = $DB_con->prepare('UPDATE tbl_users SET Name=:uname,Email=:uemail,Profession=:ujob, 
										     Pic=:upic 
								       WHERE id=:uid');
			$stmt->bindParam(':uname',$username);
			$stmt->bindParam(':uemail',$useremail);
			$stmt->bindParam(':ujob',$userjob);
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute())
			{
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='home.php';
				</script>
                <?php
			}
			else
			{
				$errMSG = "Sorry Data Could Not Updated !";
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
    	<p class="text-center bg-primary "><a class="text-white" href="home.php">View All</a></p>
    </div>
</div>
<div class="container" style="max-width: 650px;">
	<form method="post" enctype="multipart/form-data">
		<?php
	if(isset($errMSG))
	{
		?>
        <div>
          <span></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
		<div class="form-group">
			<label class="text-primary">Name</label>
				<input type="text" name="user_name" placeholder="Enter Username" class="form-control"  
						value="<?php echo $edit_row['Name']; ?>"/>
				
			</div>
			<div class="form-group">
				<label class="text-primary">Email</label>

				<input type="text" name="user_email" placeholder="Enter Your Email"  class="form-control" 
						value="<?php echo $edit_row['Email']; ?>"/>
			</div>
			<div class="form-group">
				<label class="text-primary">Profession</label>

				<input type="text" name="user_job" placeholder="Your Profession" class="form-control"  
						value="<?php echo $edit_row['Profession']; ?>"/>
			</div>
		<div class="form-group">
			<div>
			<img src="user_images/<?php echo $edit_row['Pic']; ?>" height="150" width="150" />
			</div>
			<input type="file" name="user_image" class="form-control" accept="image/*" />
		</div>
		<div class="form-group">
		<button type="submit" class="form-control btn btn-primary" name="btn_save_updates">Update</button>
		<button type="submit" class="form-control btn btn-secondary" name="btn_cancel">Cancel</button>
       </div>

	</form>
	

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>