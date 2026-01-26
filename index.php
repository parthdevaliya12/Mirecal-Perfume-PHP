<?php
    include("header.php");
   include('con.php');
    $select = "SELECT * FROM product";
    $query = mysqli_query($con,$select);
    
?>
      <!-- product section -->
      <section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h2>
                  Our <span>products</span>
               </h2>
            </div>
            <div class="row">
               <?php
               while($result = mysqli_fetch_array($query)){
               ?>
               <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="box">
                     <div class="option_container">
                        <div class="options">
                           <a href="" class="option1">
                           <?php echo $result['p_name']; ?>
                           </a>
                           <a href="product_details.php?id=<?php echo $result['p_id']; ?>" class="option2">
                           Buy Now
                           </a>
                        </div>
                     </div>
                     <div class="img-box">
                        <img src="images/<?php echo $result['p_image']; ?>" alt="">
                     </div>
                     <div class="detail-box">
                        <h5>
                        <?php echo $result['p_name']; ?>
                        </h5>
                        <h6>
                        <?php echo $result['p_price_des']; ?>
                        </h6>
                     </div>
                  </div>
               </div>
               <?php
               }
               ?>
            </div> 
            <div class="btn-box">
               <a href="product.php">
               View All products
               </a>
            </div>
         </div>
      </section>
      <!-- end product section -->

      <!-- subscribe section -->
      <section class="subscribe_section">
         <div class="container-fuild">
            <div class="box">
               <div class="row">
                  <div class="col-md-6 offset-md-3">
                     <div class="subscribe_form ">
                        <div class="heading_container heading_center">
                           <h3>Subscribe To Get Discount Offers</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                        <form action="">
                           <input type="email" placeholder="Enter your email">
                           <button>
                           subscribe
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end subscribe section -->
     
<?php
    include("footer.php");
?>