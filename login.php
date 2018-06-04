<?php
//login.php

include('database_connection.php');

if(isset($_SESSION['id']))
{
	header("location:index.php");
}

$message = '';

if(isset($_POST["login"]))
{
	$query = "SELECT * FROM loginx WHERE login = :userlogin
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
				'userlogin'	=>	$_POST["userlogin"]
			)
	);
	$count = $statement->rowCount();
	echo 'jum : '.$count. '=>'.$_POST["userlogin"];
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			echo '<br>Pass => ' .md5($_POST["password"]) .'='. $row["password"];
			if(md5($_POST["password"])== $row["password"])
				{
					$_SESSION['login'] = $row['login'];
					$_SESSION['id'] = $row['id'];
					$_SESSION['username'] = $row['username'];
					header("location:index.php");
				}
				else
				{
					$message = "<label>Wrong Password</label>";
				}
			
		}
	}
	else
	{
		$message = "<label>Wrong Login</labe>";
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>VSL Indonesia</title>
		<link rel="icon" href="favicon.ico" type="image/ico" sizes="16x16">		
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container" style="width: 500px;margin: 0 auto;">
			<h2 align="left"><img src="img/logo.png" style="width:140px;height:50px;">Attendance System</h2>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<form method="post">
						<?php echo $message; ?>
						<div class="form-group">
							<label>User Login</label>
							<input type="text" name="userlogin" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" style="float:right;" name="login" value="Login" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>