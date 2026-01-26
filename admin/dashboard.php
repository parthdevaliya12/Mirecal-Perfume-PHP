<?php
session_start();
if(!isset($_SESSION['admin'])){
	header("location:login.php");
	exit();
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pro Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        
        body {
            scroll-behavior: smooth;
        }
        
        header {
            background-color: black;
            height: 70px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        header h1 {
            color: white;
            font-size: 3rem;
        }
        
        article {
            background-color: firebrick;
            height: 660px;
            width: 20%;
        }
        
        article ul {
            display: flex;
            flex-direction: column;
        }
        
        article li {
            list-style: none;
            padding: 40px 40px;
            background-color: white;
            border-radius: 30% 30%;
            margin: 5% 5%;
        }
        
        article a {
            text-decoration: none;
            color: black;
            /* background-color: white;
            padding: 20px 20px;
            border-radius: 6px 6px; */
            font-size: 1.1rem;
        }
        
        article a:hover {
            border-bottom: solid 2px firebrick;
            transition: all 0.5s ease-in;
        }
		a.active{
			color:firebrick;
		}
    </style>
</head>

<body>
    <header>
        <h1>WELCOME TO MIRECAL DASHBOARD</h1>
    </header>
    <article>
        <ul>
            <li><a href="product.php">Product Management</a></li>
            <li><a href="customer.php">Customer Management</a></li>
            <li><a href="#">Sales Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </article>
</body>

</html>