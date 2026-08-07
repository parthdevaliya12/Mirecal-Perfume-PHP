<?php
    include("header.php");
    include('con.php');
    $select = "SELECT * FROM product ORDER BY p_id DESC LIMIT 6";
    $query = mysqli_query($con, $select);
?>

<!-- Product Section -->
<section class="product_section layout_padding">
   <div class="container">
      <div class="heading_container heading_center">
         <h2>Our <span>Featured Products</span></h2>
         <p style="color:var(--text);margin-top:12px;font-size:0.95rem;">Handpicked luxury fragrances for every occasion</p>
      </div>
      <div class="row">
         <?php while($result = mysqli_fetch_array($query)): ?>
         <div class="col-sm-6 col-md-4 col-lg-4">
            <div class="box">
               <div class="option_container">
                  <div class="options">
                     <a href="product_details.php?id=<?php echo $result['p_id']; ?>" class="option1">
                        <?php echo htmlspecialchars($result['p_name']); ?>
                     </a>
                     <a href="product_details.php?id=<?php echo $result['p_id']; ?>" class="option2">
                        Buy Now
                     </a>
                  </div>
               </div>
               <div class="img-box">
                  <img src="images/<?php echo htmlspecialchars($result['p_image']); ?>" alt="<?php echo htmlspecialchars($result['p_name']); ?>">
               </div>
               <div class="detail-box">
                  <h5><?php echo htmlspecialchars($result['p_name']); ?></h5>
                  <h6>₹<?php echo number_format($result['p_price_des'], 2); ?></h6>
               </div>
            </div>
         </div>
         <?php endwhile; ?>
      </div>
      <div class="btn-box center-btn">
         <a href="product.php" class="view-all-btn">View All Products &rarr;</a>
      </div>
   </div>
</section>

<!-- Subscribe Section -->
<section class="subscribe_section">
   <div class="container">
      <div class="row">
         <div class="col-md-8 offset-md-2">
            <div class="subscribe_form">
               <div class="heading_container heading_center">
                  <h3>Get Exclusive Offers</h3>
               </div>
               <p>Subscribe to our newsletter and be the first to know about new arrivals and special discounts.</p>
               <form action="">
                  <input type="email" placeholder="Enter your email address">
                  <button type="submit">Subscribe</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- New Arrivals Section -->
<section class="arrival_section">
   <div class="container">
      <div class="box">
         <div class="row align-items-center">
            <div class="col-md-4 d-none d-md-block">
               <div style="text-align:center">
                  <img src="images/wild stone.jpeg" alt="New Arrival" style="width:260px;height:320px;object-fit:cover;border-radius:160px 160px 0 0;border:2px solid rgba(201,168,76,0.4);box-shadow:0 20px 60px rgba(0,0,0,0.5);">
               </div>
            </div>
            <div class="col-md-8">
               <div class="heading_container remove_line_bt">
                  <span style="display:inline-block;font-size:0.72rem;letter-spacing:4px;text-transform:uppercase;color:var(--gold);margin-bottom:14px"># New Arrivals</span>
                  <h2 style="font-size:2.4rem;color:var(--cream)">Fresh Scents, <span style="color:var(--gold);font-style:italic">Bold Impressions</span></h2>
               </div>
               <p style="margin-top:20px;margin-bottom:30px;color:var(--text);font-size:0.95rem;max-width:480px;">Our latest collection features bold new fragrances crafted from the finest ingredients. Experience the art of perfumery reimagined for the modern connoisseur.</p>
               <a href="product.php" class="arrival_section a shop-btn">Shop New Arrivals</a>
            </div>
         </div>
      </div>
   </div>
</section>

<?php include("footer.php"); ?>