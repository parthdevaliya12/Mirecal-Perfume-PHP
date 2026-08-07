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
   // Cart count
   $count_qu = mysqli_query($con, "SELECT * FROM cart WHERE u_id='$id'");
   $count_num = mysqli_num_rows($count_qu);
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

      <div class="hero_area">
         <!-- Header -->
         <header class="header_section" id="mainHeader">
            <div class="container">
               <nav class="navbar navbar-expand-lg custom_nav-container">
                  <!-- Brand -->
                  <a class="navbar-brand d-flex align-items-center" href="index.php">
                     <img src="images/logo.jpeg" alt="Mirecal Logo" id="img">
                     <span class="navbar-brand-text">Mire<span>cal</span></span>
                  </a>

                  <!-- Toggler -->
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF'])=='index.php') ? 'active' : ''; ?>">
                           <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF'])=='about.php') ? 'active' : ''; ?>">
                           <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF'])=='product.php') ? 'active' : ''; ?>">
                           <a class="nav-link" href="product.php">Products</a>
                        </li>
                        <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF'])=='contact.php') ? 'active' : ''; ?>">
                           <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF'])=='order.php') ? 'active' : ''; ?>">
                           <a class="nav-link" href="order.php">My Orders</a>
                        </li>
                        <?php if(!isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                           <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                           <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                           <a class="nav-link cart-link" href="cart.php">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                 <path d="M6.5 2h11a1 1 0 0 1 .8.4l3 4A1 1 0 0 1 21 7H3a1 1 0 0 1-.8-1.6l3-4A1 1 0 0 1 6.5 2zM3.5 9h17l-1.5 9a2 2 0 0 1-2 1.7H7A2 2 0 0 1 5 18L3.5 9zm6.5 3a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1zm4 0a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1z"/>
                              </svg>
                              Cart <sup><?php echo $count_num; ?></sup>
                           </a>
                        </li>
                     </ul>
                  </div>
               </nav>
            </div>
         </header>
         <!-- End Header -->

         <!-- Hero Slider -->
         <section class="slider_section">
            <div id="customCarousel1" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">

                  <!-- Slide 1 -->
                  <div class="carousel-item active">
                     <div class="container">
                        <div class="row align-items-center">
                           <div class="col-md-6">
                              <div class="detail-box hero-detail fade-in-up">
                                 <span class="hero-badge">✦ New Collection 2025</span>
                                 <h1>
                                    <span>Sale 20% Off</span><br>
                                    On Everything
                                 </h1>
                                 <p>Discover our exclusive collection of luxury fragrances crafted for those who seek the extraordinary. Each bottle tells a story of elegance.</p>
                                 <div class="btn-box">
                                    <a href="product.php" class="btn1">Shop Now</a>
                                    <a href="about.php" class="btn2">Discover More</a>
                                 </div>
                                 <div class="carousel-indicators" style="position:static; margin-top:40px; justify-content:flex-start;">
                                    <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
                                    <li data-target="#customCarousel1" data-slide-to="1"></li>
                                    <li data-target="#customCarousel1" data-slide-to="2"></li>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="hero-img-wrap fade-in">
                                 <img src="images/embark.jpeg" alt="Luxury Perfume">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Slide 2 -->
                  <div class="carousel-item">
                     <div class="container">
                        <div class="row align-items-center">
                           <div class="col-md-6">
                              <div class="detail-box hero-detail">
                                 <span class="hero-badge">✦ Exclusive Offer</span>
                                 <h1>
                                    <span>Timeless</span><br>
                                    Fragrances
                                 </h1>
                                 <p>From woody musks to floral bouquets — find the scent that defines your identity. Premium quality, unforgettable impressions.</p>
                                 <div class="btn-box">
                                    <a href="product.php" class="btn1">Explore Now</a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="hero-img-wrap">
                                 <img src="images/destiny.jpeg" alt="Destiny Perfume">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Slide 3 -->
                  <div class="carousel-item">
                     <div class="container">
                        <div class="row align-items-center">
                           <div class="col-md-6">
                              <div class="detail-box hero-detail">
                                 <span class="hero-badge">✦ Best Sellers</span>
                                 <h1>
                                    <span>Signature</span><br>
                                    Scents
                                 </h1>
                                 <p>Bold, daring, unforgettable. Our signature collection is crafted for those who want to leave a lasting impression wherever they go.</p>
                                 <div class="btn-box">
                                    <a href="product.php" class="btn1">Buy Now</a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="hero-img-wrap">
                                 <img src="images/berado.jpeg" alt="Berado Perfume">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </section>
         <!-- End Slider -->

      </div><!-- end hero_area -->

      <script>
         // Sticky header on scroll
         window.addEventListener('scroll', function() {
            var header = document.getElementById('mainHeader');
            if (window.scrollY > 50) {
               header.classList.add('scrolled');
            } else {
               header.classList.remove('scrolled');
            }
         });
      </script>