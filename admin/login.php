<?php
	include('con.php');
	session_start();
	if(isset($_POST['submit'])){
		$u = $_POST['username'];
		$p = $_POST['password'];

		$sele = "SELECT * FROM admin WHERE username='$u' AND password='$p'";
		$query = mysqli_query($con,$sele);
		if(mysqli_num_rows($query)>0){
			$data = mysqli_fetch_array($query);
			$_SESSION['admin'] = $data;
			header("location:dashboard.php");
			exit();
		}
		else
		{
			echo "<script>alert('sorry')</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
			font-family: sans-serif;
			box-sizing: border-box;
		}
		body{
			scroll-behavior: smooth;
		}
		.content{
			height: 400px;
			width: 400px;
			display: flex;
			justify-content: center;
			align-items: center;
			border: solid 1px white;
			margin: 10% 37%;
			border-radius: 7px;
			box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
		}
		strong{
			color: firebrick;
			font-size: 2rem;
			letter-spacing:2px;
			position: absolute;
			top: 28%;
			text-shadow: 0 0 10px firebrick;
			left: 43%;

		}
		input[type="text"],input[type="password"]{
			
			padding:10px 30px;
			margin:15px 0;

		}
		input[type="submit"]{
			background-color: firebrick;
			color:black;
			padding: 10px 30px;
			border-radius: 7px;
			margin:10px 0;
			font-size: 1rem;
		}
		input:focus{
			outline: none;
			border-color: firebrick;
		}
		input[type="submit"]:hover{
			transition: 0.4s ease;
			background-color: white;
			color: black;
			transform: translateY(-5px);
		}
	</style>
</head>
<body>
	<div class="content">
		<form method="post">
			<div>
				<strong>Admin Login</strong>
			</div>
			<div>
				<input type="text" name="username" placeholder="Username" required>
			</div>
			<div>
				<input type="password" name="password" placeholder="Password" required>
			</div>
			<div>
				<input type="submit" value="Login" name="submit">
			</div>
		</form>
	</div>
</body>
</html>