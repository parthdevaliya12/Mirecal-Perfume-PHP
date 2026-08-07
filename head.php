<?php
   include("con.php");
   session_start();
   if(!isset($_SESSION['user'])){
      header("location:login.php");
      exit();
   }
   if(isset($_SESSION['user'])){
      $id = $_SESSION['user']['u_id'];
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="keywords" content="perfume, luxury fragrance, buy perfume online" />
      <meta name="description" content="Mirecal – Premium Luxury Perfumes & Fragrances" />
      <meta name="author" content="Parth Devaliya" />
      <title>Mirecal – Luxury Perfumes</title>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
      <!-- Font Awesome -->
      <link href="css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom Premium Styles -->
      <link href="css/style.css" rel="stylesheet" />
      <!-- Responsive -->
      <link href="css/responsive.css" rel="stylesheet" />
   </head>
   <body>
      <!-- Welcome Bar -->
      <div id="user">
         Welcome &nbsp;<strong><span><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span></strong>
      </div>