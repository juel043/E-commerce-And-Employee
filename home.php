<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['mysession'])) 
{
	header("Location: index.php");
}

$query = $DB_con->query("SELECT * FROM login WHERE user_id=".$_SESSION['mysession']);
$userRow=$query->fetch_array();
$DB_con->close();

?>
<?php

require_once 'dbconfig.php';

if(isset($_GET['delete_id']))
{
		// select image from db to delete
	$stmt_select = $DB_con->prepare('SELECT Pic FROM tbl_users WHERE id =:uid');

	$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
	$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['Pic']); //The unlink() function deletes a file.
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM tbl_users WHERE id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: index.php");
	}
	if(isset($_POST['add']))
	{
		header('Location: addproduct.php');
	}
	

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title> The Mysql design</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
		<style type="text/css">
			
			/*.center-block {
				display: block;
				margin-left: auto;
				margin-right: auto;
			}*/
			p{
				font-family: bold ;
				font-size: 15px;
			}
			body{
				margin: 0px;
				padding: 0px;
			}





		</style>
	</head>

	<body>

		<div class="container-fluid">
			<div class="row ">
				<div class="col-6 my-1 bg-dark">
					<!-- <img src="" style="width: 100px; height: 100px"> -->
					  <a class="navbar-brand" href="#">
    <img src="images/lgo2.jpg" width="40" height="40" class="d-inline-block align-top" alt="">
    Ecommerce
  </a>
				</div>	
				<div class="col-6 my-1 bg-dark">

					<div style="float: right" >
						<a class="log" href="logout.php?logout"><input type="button" class="btn btn-info my-1" name="logout" value="Logout"></a>
					</div>
					<div style="float: right" >
						<a class="log" href="contact.php"><input type="button" class="btn btn-info my-1 mr-2"  value="Contact"></a>
					</div>

				</div>	
			</div>

			<div>
				

				<form method="post">
					<div align="center">
					<button type="submit" name="add" class=" btn btn-info text-white text-center" > Add Member</button>
					<a href="productshow.php" class="btn btn-success text-center">Show Product</a>
					</div>
					
				</form>
				<h1 class="text-center mt-1 text-dark">All Member List </h1>

			</div>
		</div>
		<div class="container  ">
			<div class="row ">

				<?php

				$stmt = $DB_con->prepare('SELECT id, Name,Email, Profession, Pic FROM tbl_users ORDER BY id DESC');
				$stmt->execute();

				if($stmt->rowCount() > 0)
				{
					while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{


			extract($row); //This function uses array keys as variable names and values as variable values.
			?>
			
			<div class="col-md-4 pt-2 ">
				<div class="border border-primary ">
					<p class="text-center text-dark p-2 m-2"><?php echo "Name: ".$Name; ?></p>
					<div align="center">
					<img style="width: 120px; height: 130px;" class="img-thumbnail img-fluid " src="user_images/<?php echo $row['Pic']; ?>">
					</div>
					<p class="text-center text-dark  p-2 m-2"><?php echo "Email: ".$Email; ?></p>
					<p class="text-center text-dark  p-2 m-2"><?php echo "Profession: ".$Profession; ?></p>
					<div class="row">
						<div class="col-6">
							<a style="padding-left: 40px; padding-right: 50px;" href="editform.php?edit_id=<?php echo $row['id']; ?>"class="text-white btn btn-info ml-3 mb-2" title="click for edit" onclick="return confirm('sure to edit ?')">Edit</a>
						</div>
						<div class="col-6">

							<a style="padding-left: 40px; padding-right: 50px;" href="?delete_id=<?php echo $row['id']; ?>" class="text-white btn btn-danger mb-2"title="click for delete" onclick="return confirm('sure to delete ?')">Delete
							</a>
						</div>
					</div>

				</div>

			</div>       
			<?php
		}
	}
	else
	{
		?>
		<div>
			<div>
				No Data Found ...
			</div>
		</div>
		<?php
	}
	
	?>

</div>
</div>	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>