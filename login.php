<?php
session_start();
require_once 'dbconfig.php';

if (isset($_SESSION['mysession'])!="")
 {
	header("Location: home.php");
	exit;
}

if (isset($_POST['btn-login']))
 {
	
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	
	$email = $DBcon->real_escape_string($email);
	$password = $DBcon->real_escape_string($password);
	
	$query = $DBcon->query("SELECT user_id, email, password FROM login WHERE email='$email'");
	$row=$query->fetch_array();
	
	$count = $query->num_rows; // if email/password are correct returns must be 1 row
	
	if (password_verify($password, $row['password']) && $count==1) 
	{
		$_SESSION['mysession'] = $row['user_id'];
		header("Location: home.php");
	}
	 else 
	 {
		$msg = "<div>
					<span></span> &nbsp; Invalid Username or Password !
				</div>";
	}
	$DB_con->close();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	<form  method="post" style="max-width:500px; margin: auto; "> 
        
        <?php
		if(isset($msg))
		{
			echo $msg;
		}
		?>
		<!-- <i style="border-radius: 10px;" class="fa fa-user icn"></i> -->
		<div class="imgcontainer">
    <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
  </div>
		<h2>Login From</h2>
		<div class="l" >
		 <label for="psw" ><b>Username</b></label><br>
		 </div>
		<div class="icontain">
			 
			<i class="fa fa-user icn"></i>
			<input class="iclass" type="email" name="email" placeholder="Enter The Mail">

		</div>
		<div class="l">
		<label for="psw"><b>Password</b></label><br>
        </div>
		<div class="icontain">
			  
			<i class="fa fa-envelope icn"></i>
			<input class="iclass"  type="password" name="psw" placeholder="********">

		</div>
		<div class="al">
			<a href="G:\University_All_Class\IDB_WEB\web desgin\Html/product.html"><button class="btn"type="submit" name="btn-login" >Login</button></a>
			<button class="btn"type="button" name="btn" value="Submit">Close</button>

		</div>
      <div>
	     <a href="register.php">Sign UP Here</a>

    </div>
	</form>

</body>
</html>