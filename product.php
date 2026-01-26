<?php
    include("header.php");
    include('con.php');
    $select = "SELECT * FROM product";
    $query = mysqli_query($con,$select);
?>
      <!-- inner page section -->
      <section class="inner_page_head">
         <div class="container_fuild">
            <div class="row">
               <div class="col-md-12">
                  <div class="full">
                     <h3>Product Grid</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end inner page section -->
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
         </div>
      </section>
      <!-- end product section -->
<?php
    include("footer.php");
?>