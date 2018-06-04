<?php
//header.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title>VSL Indonesia </title>
		<link rel="icon" href="favicon.ico" type="image/ico" sizes="16x16">
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="left"><img src="img/logo.png" style="width:140px;height:50px;">Attendance System</h2>

			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a href="index.php" class="navbar-brand">Home</a>
					</div>
					<ul class="nav navbar-nav">
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Master Data<span class="caret"></span></a>
							<ul class="dropdown-menu">
							  <li><a href="?module=m0">User</a></li>
							  <li><a href="?module=m1">Employee</a></li>
							  <li><a href="?module=m2">Departement</a></li>
							  <li><a href="?module=m3">Team</a></li>
							  <li><a href="?module=m4">Holidays</a></li>
							  <li><a href="?module=m5">Upload Data</a></li>
							</ul>
						</li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Attendance<span class="caret"></span></a>
							<ul class="dropdown-menu">
							  <li><a href="?module=p1">Attendance</a></li>
							  <li><a href="?module=p3">e-Leave</a></li>
							</ul>
						</li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Report<span class="caret"></span></a>
							<ul class="dropdown-menu">
							  <li><a href="?module=r1">Attendance</a></li>
							  <li><a href="?module=r2">e-Leave</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["username"]; ?></a>
							<ul class="dropdown-menu">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</nav>
			