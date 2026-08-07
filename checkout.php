<?php
include('head.php');
include('con.php');

if (!isset($_SESSION['user'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$uid = $_SESSION['user']['u_id'];

// Check cart has items
$cart_result  = mysqli_query($con, "SELECT * FROM cart WHERE u_id='$uid'");
$total_query  = "SELECT SUM(c_price * c_quantity) AS total FROM cart WHERE u_id='$uid'";
$total_result = mysqli_query($con, $total_query);
$total_row    = mysqli_fetch_assoc($total_result);
$subtotal     = $total_row['total'] ?? 0;
$shipping     = ($subtotal > 0) ? 50 : 0;
$total        = $subtotal + $shipping;

if (isset($_POST['sub'])) {
    $cart_items = mysqli_query($con, "SELECT * FROM cart WHERE u_id='$uid'");

    if (mysqli_num_rows($cart_items) > 0) {
        $name           = mysqli_real_escape_string($con, $_POST['full_name']);
        $email          = mysqli_real_escape_string($con, $_POST['email']);
        $phone          = mysqli_real_escape_string($con, $_POST['phone']);
        $address        = mysqli_real_escape_string($con, $_POST['address']);
        $pincode        = mysqli_real_escape_string($con, $_POST['pincode']);
        $city           = mysqli_real_escape_string($con, $_POST['city']);
        $state          = mysqli_real_escape_string($con, $_POST['state']);
        $payment_method = mysqli_real_escape_string($con, $_POST['payment_method']);
        $status         = "Pending";

        while ($cartdata = mysqli_fetch_array($cart_items)) {
            $cid      = $cartdata['c_id'];
            $pid      = $cartdata['p_id'];
            $price    = $cartdata['c_price'];
            $quantity = $cartdata['c_quantity'];
            $pname    = mysqli_real_escape_string($con, $cartdata['c_name']);
            $pimg     = mysqli_real_escape_string($con, $cartdata['c_image']);

            $in_order = "INSERT INTO orders (u_id,c_id,p_id,o_name,o_email,o_mobile,o_address,o_pincode,o_city,o_state,o_price,o_quantity,o_pname,o_pimg,o_payment_method,o_status)
                         VALUES ('$uid','$cid','$pid','$name','$email','$phone','$address','$pincode','$city','$state','$price','$quantity','$pname','$pimg','$payment_method','$status')";
            $result = mysqli_query($con, $in_order);
            if (!$result) {
                die("Order Insertion Error: " . mysqli_error($con));
            }
        }

        mysqli_query($con, "SET FOREIGN_KEY_CHECKS=0");
        mysqli_query($con, "DELETE FROM cart WHERE u_id='$uid'");
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS=1");

        echo "<script>alert('Order placed successfully!'); window.location.href='order.php';</script>";
        exit();
    } else {
        $checkout_error = "Your cart is empty.";
    }
}
?>

<!-- Checkout Section -->
<section class="checkout-section">
   <div class="container">
      <h2>Checkout</h2>

      <?php if (!empty($checkout_error)): ?>
      <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;padding:14px 20px;border-radius:10px;margin-bottom:24px;text-align:center">
         ⚠ <?php echo $checkout_error; ?>
      </div>
      <?php endif; ?>

      <div class="row">
         <!-- Billing Form -->
         <div class="col-lg-7 mb-4">
            <div class="checkout-card">
               <h4>Billing Details</h4>
               <form action="" method="post" onsubmit="return validateCheckout()">
                  <input type="hidden" name="user_id" value="<?php echo $uid; ?>">

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Full Name</label>
                           <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Your full name" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Email Address</label>
                           <input type="email" name="email" id="email_co" class="form-control" placeholder="you@example.com" required>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="form-label">Phone Number</label>
                     <input type="text" name="phone" id="phone" class="form-control" placeholder="10-digit mobile number" required>
                  </div>

                  <div class="form-group">
                     <label class="form-label">Delivery Address</label>
                     <textarea name="address" id="address" class="form-control" rows="3" placeholder="Full address with street, landmark..." required></textarea>
                  </div>

                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label">Pincode</label>
                           <input type="text" name="pincode" id="pincode" class="form-control" placeholder="6-digit pincode" required>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label">City</label>
                           <input type="text" name="city" id="city" class="form-control" placeholder="Your city" required>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label">State</label>
                           <input type="text" name="state" id="state" class="form-control" placeholder="Your state" required>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="form-label">Payment Method</label>
                     <select name="payment_method" class="form-control" required>
                        <option value="COD">Cash on Delivery</option>
                        <option value="UPI">UPI</option>
                        <option value="Net Banking">Net Banking</option>
                        <option value="Credit/Debit Card">Credit / Debit Card</option>
                     </select>
                  </div>

                  <button type="submit" name="sub" class="btn-place-order">✓ Place Order</button>
               </form>
            </div>
         </div>

         <!-- Order Summary -->
         <div class="col-lg-5">
            <div class="order-summary-card">
               <div class="summary-header">Order Summary</div>
               <?php
                  $display_cart = mysqli_query($con, "SELECT * FROM cart WHERE u_id='$uid'");
                  while ($cart = mysqli_fetch_array($display_cart)):
               ?>
               <div class="order-item">
                  <span><?php echo htmlspecialchars($cart['c_name']); ?> (×<?php echo $cart['c_quantity']; ?>)</span>
                  <span class="price">₹<?php echo number_format($cart['c_price'] * $cart['c_quantity'], 2); ?></span>
               </div>
               <?php endwhile; ?>
               <div class="order-item">
                  <span>Shipping</span>
                  <span class="price">₹<?php echo number_format($shipping, 2); ?></span>
               </div>
               <div class="order-total">
                  <span>Grand Total</span>
                  <span class="price">₹<?php echo number_format($total, 2); ?></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
function validateCheckout() {
   var phone   = document.getElementById("phone").value;
   var pincode = document.getElementById("pincode").value;
   if (!/^\d{10}$/.test(phone)) {
      showToast("Please enter a valid 10-digit phone number.", "error");
      return false;
   }
   if (!/^\d{6}$/.test(pincode)) {
      showToast("Please enter a valid 6-digit pincode.", "error");
      return false;
   }
   return true;
}
</script>

<?php include('footer.php'); ?>
