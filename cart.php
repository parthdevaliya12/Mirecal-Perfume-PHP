<?php
include('head.php');
include('con.php');

if (isset($_SESSION['user'])) {
    $uid = $_SESSION['user']['u_id'];
}

// Delete cart item FIRST (before fetching)
if (isset($_GET['id'])) {
    $delid = intval($_GET['id']);
    $del   = "DELETE FROM cart WHERE c_id='$delid' AND u_id='$uid'";
    mysqli_query($con, $del);
    echo "<script>window.location.href='cart.php';</script>";
    exit();
}

// Fetch cart items
$fetch = "SELECT * FROM cart WHERE u_id='$uid'";
$qu    = mysqli_query($con, $fetch);

// Calculate total
$total_query  = "SELECT SUM(c_price * c_quantity) AS total FROM cart WHERE u_id='$uid'";
$total_result = mysqli_query($con, $total_query);
$total_row    = mysqli_fetch_assoc($total_result);
$subtotal     = $total_row['total'] ?? 0;
$shipping     = $subtotal > 0 ? 50 : 0;
$total        = $subtotal + $shipping;
?>

<!-- Cart Section -->
<section class="cart-section">
   <div class="container">
      <?php if (mysqli_num_rows($qu) > 0): ?>

      <h2>🛒 Shopping Cart</h2>

      <div class="row">
         <!-- Cart Table -->
         <div class="col-lg-8 mb-4">
            <div class="cart-table-wrap">
               <table>
                  <thead>
                     <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php while ($result = mysqli_fetch_array($qu)): ?>
                     <tr>
                        <td>
                           <img src="images/<?php echo htmlspecialchars($result['c_image']); ?>" alt="<?php echo htmlspecialchars($result['c_name']); ?>">
                        </td>
                        <td style="color:var(--cream);font-weight:500"><?php echo htmlspecialchars($result['c_name']); ?></td>
                        <td style="color:var(--gold);font-weight:600">₹<?php echo number_format($result['c_price'], 2); ?></td>
                        <td>
                           <input type="number"
                                  value="<?php echo $result['c_quantity']; ?>"
                                  min="1" max="99"
                                  data-id="<?php echo $result['c_id']; ?>"
                                  class="qty-input update-quantity">
                        </td>
                        <td class="subtotal-<?php echo $result['c_id']; ?>" style="color:var(--gold);font-weight:600">
                           ₹<?php echo number_format($result['c_price'] * $result['c_quantity'], 2); ?>
                        </td>
                        <td>
                           <a href="cart.php?id=<?php echo $result['c_id']; ?>"
                              class="btn-cancel"
                              onclick="return confirm('Remove this item from cart?')">
                              🗑 Remove
                           </a>
                        </td>
                     </tr>
                     <?php endwhile; ?>
                  </tbody>
               </table>
            </div>

            <!-- Continue Shopping -->
            <div style="margin-top:20px">
               <a href="product.php" style="color:var(--gold);font-size:0.85rem;text-decoration:none;letter-spacing:1px">
                  ← Continue Shopping
               </a>
            </div>
         </div>

         <!-- Cart Summary -->
         <div class="col-lg-4">
            <div class="cart-summary-card">
               <div class="summary-header">🧾 Order Summary</div>
               <div class="summary-body">
                  <div class="summary-row">
                     <span>Subtotal</span>
                     <span class="amount" id="cart-total">₹<?php echo number_format($subtotal, 2); ?></span>
                  </div>
                  <div class="summary-row">
                     <span>Shipping</span>
                     <span class="amount">₹<?php echo number_format($shipping, 2); ?></span>
                  </div>
                  <div class="summary-row total">
                     <span>Total</span>
                     <span class="amount" id="cart-final-total">₹<?php echo number_format($total, 2); ?></span>
                  </div>
                  <a href="checkout.php" class="btn-checkout">Proceed to Checkout →</a>
               </div>
            </div>
         </div>
      </div>

      <?php else: ?>

      <!-- Empty Cart -->
      <div class="empty-cart">
         <img src="images/emptycart.png" alt="Empty Cart" style="width:240px;height:240px;object-fit:contain">
         <h3 style="margin-top:20px;color:var(--text)">Your Cart is Empty</h3>
         <p style="color:var(--text-dim);margin:12px 0 28px">Looks like you haven't added anything yet.</p>
         <a href="product.php" class="btn1" style="display:inline-block;background:var(--gold);color:var(--black);padding:14px 36px;border-radius:50px;font-size:0.82rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;text-decoration:none;border:2px solid var(--gold);transition:all 0.35s">
            Browse Products
         </a>
      </div>

      <?php endif; ?>
   </div>
</section>

<!-- Quantity Update Script -->
<script>
$(document).ready(function() {
   $(".update-quantity").on("change", function() {
      var cart_id    = $(this).data("id");
      var new_qty    = $(this).val();
      if (new_qty < 1) { $(this).val(1); new_qty = 1; }

      $.ajax({
         url: "update_quan.php",
         type: "POST",
         data: { id: cart_id, quantity: new_qty },
         success: function(response) {
            var data = JSON.parse(response);
            if (data.success) {
               $(".subtotal-" + cart_id).text("₹" + parseFloat(data.subtotal).toFixed(2));
               $("#cart-total").text("₹" + (parseFloat(data.total) - 50).toFixed(2));
               $("#cart-final-total").text("₹" + parseFloat(data.total).toFixed(2));
            } else {
               showToast("Error updating quantity.", "error");
            }
         },
         error: function() {
            showToast("Connection error.", "error");
         }
      });
   });
});
</script>

<?php include('footer.php'); ?>
