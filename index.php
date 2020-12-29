<?php
session_start();

$msg="";
$captcha = true;

if(count($_POST)>0 && isset($_POST["captcha_code"]) && $_POST["captcha_code"]!=$_SESSION["captcha_code"])
 {
$captcha = false;
$msg = "This Account Is Lock For This 1 Minute Wait Then You Are try It.";
}
require_once 'dbconnect.php';

if (isset($_SESSION['mysession'])!="")
 {
	header("Location: home.php");
	exit;
}
$ip = $_SERVER['REMOTE_ADDR'];

$result = $DB_con->query("SELECT count(ip_address) AS failed_login_attempt FROM failed_login WHERE ip_address = '$ip'  AND date BETWEEN DATE_SUB( NOW() , INTERVAL 1 minute ) AND NOW()");

$row  = $result->fetch_array();
$result->free();

$failed_login_attempt = $row['failed_login_attempt'];

if(count($_POST)>0 && $captcha == true) 
{

if (isset($_POST['btn-login']))
 {
	
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	
	$email = $DB_con->real_escape_string($email);
	$password = $DB_con->real_escape_string($password);
	
	$query = $DB_con->query("SELECT user_id, email, password FROM login WHERE email='$email'");
	$row=$query->fetch_array();
	
	$count = $query->num_rows; // if email/password are correct returns must be 1 row
	
	if (password_verify($password, $row['password']) && $count==1) 
	{
		$_SESSION['mysession'] = $row['user_id'];
		$DB_con->query("DELETE FROM failed_login WHERE ip_address = '$ip'");
		header("Location: home.php");
	}
	 else 
	 {
		$msg = "Invalid Username Or Password";
		if ($failed_login_attempt < 3) 
		{
			$DB_con->query("INSERT INTO failed_login (ip_address,date) VALUES ('$ip', NOW())");
		} 
		else
		 {
			$msg = "You have tried more than 3 invalid attempts. Enter captcha code.";
		}
	}
	$DB_con->close();
}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		.a{
			color: white;
		}
	</style>

</head>
<body>
	<form  method="post" style="max-width:500px; margin: auto; "> 
        
        <?php
		if(isset($msg))
		{
			?>
			<p style="color: red;"><?php echo $msg; ?></p>
			<?php
		}
		?>
		<!-- <i style="border-radius: 10px;" class="fa fa-user icn"></i> -->
		<div class="imgcontainer">
    <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
  </div>
		<h2>Login Form</h2>
		<div class="l" >
		 <label for="psw" ><b>Username</b></label><br>
		 </div>
		<div class="icontain ">
			 
			<i class="fa fa-user icn"></i>
			<input class="iclass" type="email" name="email" placeholder="Enter The Mail">

		</div>
		<div class="l">
		<label for="psw"><b>Password</b></label><br>
        </div>
        
		<div class="icontain">
			  
			<i class="fa fa-envelope icn"></i>
			<input class="iclass"  type="password" name="password" placeholder="Enter Password">

		</div>
		<?php
 if (isset($failed_login_attempt) && $failed_login_attempt >= 3) 
 	{ 
 		?>
           <div class="icontain d-none ">

              <input  type="text" name="captcha_code"><br><br><img src="captcha_code.php" />
           </div>

<?php
 }

  ?>
		<div class="al "style="margin-bottom: 15px;">
			<button class="btn"type="submit" name="btn-login" >Login</button>
			<button class="btn"type="button" name="btn" value="Submit">Close</button>

		</div>
      <div class="al" style="margin-bottom: 15px;">
	     <a style="color: white;" href="register.php">Sign UP Here</a>

    </div>
    <div class="icontain">
    	
    </div>
	</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>