<?php
    include("header.php");
    include('con.php');
    $select = "SELECT * FROM product";
    $query = mysqli_query($con, $select);
?>

<!-- Inner Page Head -->
<section class="inner_page_head">
   <h3>Our Products</h3>
</section>

<!-- Product Section -->
<section class="product_section layout_padding">
   <div class="container">
      <div class="heading_container heading_center">
         <h2>Luxury <span>Fragrance</span> Collection</h2>
         <p style="color:var(--text);margin-top:12px;font-size:0.95rem;">Explore our complete range of premium perfumes</p>
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
                  <div style="display:flex;align-items:center;gap:12px;margin-top:4px">
                     <?php if(!empty($result['p_price_ori']) && $result['p_price_ori'] > $result['p_price_des']): ?>
                     <span style="color:var(--text-dim);text-decoration:line-through;font-size:0.85rem">₹<?php echo number_format($result['p_price_ori'],2); ?></span>
                     <?php endif; ?>
                     <h6>₹<?php echo number_format($result['p_price_des'],2); ?></h6>
                  </div>
               </div>
            </div>
         </div>
         <?php endwhile; ?>
      </div>
   </div>
</section>

<?php include("footer.php"); ?>