<?php
include('header.php');
include('con.php');

$p_id = intval($_GET['id'] ?? 0);
$sel  = "SELECT * FROM product WHERE p_id='$p_id'";
$qu   = mysqli_query($con, $sel);
$re   = mysqli_fetch_array($qu);

if (!$re) {
    echo "<script>window.location.href='product.php';</script>";
    exit();
}

// Add to cart
if (isset($_POST['cart'])) {
    if (!isset($_SESSION['user']['u_id'])) {
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }
    $uid        = $_SESSION['user']['u_id'];
    $pid        = $re['p_id'];
    $cart_name  = mysqli_real_escape_string($con, $re['p_name']);
    $cart_image = mysqli_real_escape_string($con, $re['p_image']);
    $quantity   = 1;
    $cart_total = $re['p_price_des'];

    $check_cart    = "SELECT * FROM cart WHERE u_id='$uid' AND c_name='$cart_name'";
    $check_cart_ex = mysqli_query($con, $check_cart);

    if (mysqli_num_rows($check_cart_ex) > 0) {
        $cart_msg = "already_in_cart";
    } else {
        $add = "INSERT INTO cart (u_id,p_id,c_name,c_image,c_quantity,c_price)
                VALUES ('$uid','$pid','$cart_name','$cart_image','$quantity','$cart_total')";
        $cart_query = mysqli_query($con, $add);
        $cart_msg   = $cart_query ? "added" : "error";
    }
}
?>

<!-- Product Details Section — no extra DOCTYPE, inherits from header.php -->
<section class="product_details_section">
   <div class="container">

      <?php if (!empty($cart_msg)): ?>
      <script>
         window.addEventListener('load', function() {
            <?php if ($cart_msg === 'added'): ?>
            showToast('✓ Product added to cart!', 'success');
            <?php elseif ($cart_msg === 'already_in_cart'): ?>
            showToast('Product is already in your cart.', 'error');
            <?php else: ?>
            showToast('Something went wrong. Please try again.', 'error');
            <?php endif; ?>
         });
      </script>
      <?php endif; ?>

      <div class="row align-items-center">
         <!-- Product Image -->
         <div class="col-md-5">
            <div class="img-box">
               <img src="images/<?php echo htmlspecialchars($re['p_image']); ?>" alt="<?php echo htmlspecialchars($re['p_name']); ?>" class="product-image">
            </div>
         </div>

         <!-- Product Info -->
         <div class="col-md-7">
            <div class="detail-box" style="padding: 20px 40px;">

               <div style="margin-bottom:16px">
                  <span style="font-size:0.72rem;letter-spacing:3px;text-transform:uppercase;color:var(--gold)">Mirecal Collection</span>
               </div>

               <h2><?php echo htmlspecialchars($re['p_name']); ?></h2>

               <div style="display:flex;align-items:center;gap:16px;margin:16px 0;">
                  <?php if (!empty($re['p_price_ori']) && $re['p_price_ori'] > $re['p_price_des']): ?>
                  <h5 class="strikethrough">₹<?php echo number_format($re['p_price_ori'], 2); ?></h5>
                  <?php endif; ?>
                  <h5 style="font-size:1.8rem;color:var(--gold)">₹<?php echo number_format($re['p_price_des'], 2); ?></h5>
                  <?php if (!empty($re['p_price_ori']) && $re['p_price_ori'] > $re['p_price_des']):
                     $discount = round((($re['p_price_ori'] - $re['p_price_des']) / $re['p_price_ori']) * 100); ?>
                  <span style="background:rgba(201,168,76,0.15);border:1px solid rgba(201,168,76,0.4);color:var(--gold);font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:20px">
                     <?php echo $discount; ?>% OFF
                  </span>
                  <?php endif; ?>
               </div>

               <?php if (!empty($re['p_description'])): ?>
               <div style="background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:10px;padding:16px 20px;margin-bottom:24px">
                  <p style="color:var(--text);font-size:0.93rem;line-height:1.8"><?php echo nl2br(htmlspecialchars($re['p_description'])); ?></p>
               </div>
               <?php endif; ?>

               <?php if (!empty($re['p_quantity'])): ?>
               <div style="margin-bottom:20px;font-size:0.85rem;color:var(--text-dim)">
                  <?php if ($re['p_quantity'] > 0): ?>
                  <span style="color:#22c55e">✓ In Stock</span> &nbsp;(<?php echo $re['p_quantity']; ?> units available)
                  <?php else: ?>
                  <span style="color:#ef4444">✗ Out of Stock</span>
                  <?php endif; ?>
               </div>
               <?php endif; ?>

               <div class="buy_section" style="display: flex; flex-wrap: wrap; gap: 16px; margin-top: 24px; align-items: center;">
                  <form method="post" style="margin: 0;">
                     <button type="submit" name="cart" class="btn1">
                        🛍 Add To Cart
                     </button>
                  </form>
                  <a href="product.php" class="btn2">
                     ← Back to Products
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<?php include('footer.php'); ?>
