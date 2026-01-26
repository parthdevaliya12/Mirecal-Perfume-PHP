<?php
include("con.php");
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sel = "SELECT * FROM register WHERE email='$email' AND password='$password'";
    $query = mysqli_query($con, $sel);

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['user'] = $data;
		echo "<script>
		swal({
			title: 'Good job!'',
			text: 'Login Successfully,
			icon: 'success',
		  });
		  </script>";
        
		header("location:index.php");
        exit();
    } else {
		echo "<script>
		swal({
			title: 'Oops!'',
			text: 'Some Error',
			icon: 'error',
		  });
		  </script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<title>Login</title>
	<style>
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		body{
			font-family: sans-serif;
			transition: all 0.5s ease;
		}
		.content{
			display:flex;
			justify-content: center;
			align-items: center;
			border:solid 3px white;
			box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
			height: 400px;
			width:auto;
			margin: 10% 35%;
			border-radius: 7px;
		}
		.stro{
			color: black;
			text-align: center;
			font-size: 2rem;
			margin-left: 20%;
			padding:5% 0;
		}
		input[type="email"],input[type="password"]{
			width:140%;
			height: 30px;
			padding: 20px 20px;
			margin: 3% 0;
			margin-left:-18%;
		}
		input[type="submit"]{
			padding:10px 40px;
			font-size: 1rem;
			border-radius: 7px;
			margin: 3% 0;
			margin-left: 20%;
			background: lightpink;
			color:black;
		}
		p{
			padding-top:5%;
		}
		input:focus{
			outline: none;
			border-color: lightpink;
			font-size: 1rem;

		}
		input[type="submit"]:hover{
			transform: scale(0.9);
			transition: all 0.5s ease;
			background:white;
			color: lightpink;
		}
	</style>
	
</head>
<body>
	<div class="content">
		<form method="post">
			<div>
				<strong class="stro">Sign In</strong>
			</div>
			<div>
				<input type="email" name="email" placeholder="Email" required>
			</div>
			<div>
				<input type="password" name="password" placeholder="Password" required>
			</div>
			<div>
				<input type="submit" name="submit" value="Login">
			</div>
			<div>
				<p>You don't have an account? <strong><a href="register.php">Sign Up</a></strong></p>
			</div>
		</form>
	</div>

	<!-- Add SweetAlert JS -->
</body>
</html>
