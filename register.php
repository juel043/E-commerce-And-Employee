<?php
session_start();

$msg="";
$captcha = true;

if(count($_POST)>0 && isset($_POST["captcha_code"]) && $_POST["captcha_code"]!=$_SESSION["captcha_code"])
 {
$captcha = false;
$msg = "Please Enter Captcah code matching.";
}
if (isset($_SESSION['mysession'])!="") 
{
	header("Location: home.php");
}
require_once 'dbconnect.php';

if(count($_POST)>0 && $captcha == true) {

if(isset($_POST['btn-signup']))
 {
	
	$uname = strip_tags($_POST['username']);
	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);
	
	$uname = $DB_con->real_escape_string($uname);
	$email = $DB_con->real_escape_string($email);
	$upass = $DB_con->real_escape_string($upass);
	
	$hashed_password = password_hash($upass, PASSWORD_DEFAULT); // this function works only in PHP 5.5 or latest version
	
	$check_email = $DB_con->query("SELECT email FROM login WHERE email='$email'");
	$count=$check_email->num_rows;
	
	$msg="";
	if ($count==0) 
	{
		
		$query = "INSERT INTO login(username,email,password) VALUES('$uname','$email','$hashed_password')";

		if ($DB_con->query($query)) 
		{
			$msg = " successfully registered !";
		}
		else 
		{
			$msg = " error while registering !";
		}
		
	}
	 else
	 {
		
		
		$msg = " sorry email already taken !";
			
	}
	
	$DB_con->close();
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<meta name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="reg.css">

	<style type="text/css">
		
		body{
			background-color:white;
		}
		.a{
			color: red;
		}
	</style>
</head>

<body>
	
	<form method="post" style="max-width:500px; margin:auto">
		<?php
		if (isset($msg))
		 {
		 	?>
		 	<div class="a"> <?php echo $msg;  ?></div>
			<?php
		}
		?>
		<h2 style="background-color: dodgerblue;">Registration From</h2>

		<div class="input-container">
			<i class="fa fa-user icon"></i>
			<input class="input-field" type="text" name="username" placeholder="Enter the name">

		</div>
		<div class="input-container">
			<i class="fa fa-envelope icon"></i>
			<input class="input-field" type="email" name="email" placeholder="Enter the email">

		</div>
		<div class="input-container">
			<i class="fa fa-key icon"></i>
			<input class="input-field" type="password" name="password" placeholder="Enter the pass">

		</div>
		<div class="input-container">
		
			
			<input class="input-field "style="margin-bottom: 0px;" type="text" name="captcha_code" placeholder=" Enter Captcha code"><br>

		</div>
		<div>
		   <img src="captcha_code.php" />
		</div>
		<div style="margin-bottom: 10px;">
		<button class="btn" style="color: white;" type="submit" name="btn-signup">Create Account</button>
          
		</div>
		<div align="center">
			<a style="color: dodgerblue;" href="index.php">Log In Here</a>
		</div>

	</form>

</body>
</html>