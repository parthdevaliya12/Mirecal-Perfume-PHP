<?php
include('head.php');
include('con.php');

if (!isset($_SESSION['user']['u_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit();
}

$uid = $_SESSION['user']['u_id'];

// Handle cancellation BEFORE the query/loop (Bug fix)
if (isset($_GET['id'])) {
    $oid     = intval($_GET['id']);
    $del_sql = "DELETE FROM orders WHERE o_id='$oid' AND u_id='$uid'";
    $del_q   = mysqli_query($con, $del_sql);
    if ($del_q) {
        echo "<script>window.location.href='order.php';</script>";
    } else {
        echo "<script>alert('Error cancelling order. Please try again.');</script>";
    }
    exit();
}

// Fetch orders
$fetch_order = "SELECT * FROM orders WHERE u_id='$uid' ORDER BY o_id DESC";
$fetch_query = mysqli_query($con, $fetch_order);
?>

<!-- Orders Section -->
<section class="orders-section">
   <div class="container">
      <h2>My Orders</h2>

      <?php if (mysqli_num_rows($fetch_query) > 0): ?>

      <div class="orders-card">
         <table>
            <thead>
               <tr>
                  <th>Product</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Qty</th>
                  <th>Amount</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php while ($order = mysqli_fetch_assoc($fetch_query)): ?>
               <tr>
                  <td>
                     <img src="images/<?php echo htmlspecialchars($order['o_pimg']); ?>" alt="<?php echo htmlspecialchars($order['o_pname']); ?>">
                  </td>
                  <td style="color:var(--cream);font-weight:500;max-width:150px"><?php echo htmlspecialchars($order['o_pname']); ?></td>
                  <td><?php echo date("d M Y", strtotime($order['o_date'])); ?></td>
                  <td><?php echo $order['o_quantity']; ?></td>
                  <td style="color:var(--gold);font-weight:600">₹<?php echo number_format($order['o_price'], 2); ?></td>
                  <td style="font-size:0.82rem"><?php echo htmlspecialchars($order['o_payment_method']); ?></td>
                  <td>
                     <?php
                     $status = $order['o_status'];
                     if ($status === 'Delivered') {
                        echo '<span class="status-badge badge-delivered">Delivered</span>';
                     } elseif ($status === 'Pending') {
                        echo '<span class="status-badge badge-pending">Pending</span>';
                     } elseif ($status === 'Cancelled') {
                        echo '<span class="status-badge badge-cancelled">Cancelled</span>';
                     } else {
                        echo '<span class="status-badge badge-pending">' . htmlspecialchars($status) . '</span>';
                     }
                     ?>
                  </td>
                  <td>
                     <?php if ($order['o_status'] === 'Pending'): ?>
                     <a href="order.php?id=<?php echo $order['o_id']; ?>"
                        class="btn-cancel-order"
                        onclick="return confirm('Are you sure you want to cancel this order?')">
                        Cancel
                     </a>
                     <?php else: ?>
                     <span style="color:var(--text-dim);font-size:0.78rem">—</span>
                     <?php endif; ?>
                  </td>
               </tr>
               <?php endwhile; ?>
            </tbody>
         </table>
      </div>

      <?php else: ?>

      <!-- No Orders -->
      <div style="text-align:center;padding:80px 20px">
         <div style="font-size:4rem;margin-bottom:20px">📦</div>
         <h3 style="color:var(--cream);font-family:'Cormorant Garamond',serif;font-size:1.8rem;margin-bottom:12px">No Orders Yet</h3>
         <p style="color:var(--text-dim);margin-bottom:28px">You haven't placed any orders. Start shopping!</p>
         <a href="product.php" style="display:inline-block;background:var(--gold);color:var(--black);padding:14px 36px;border-radius:50px;font-size:0.82rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;text-decoration:none;border:2px solid var(--gold);transition:all 0.35s">
            Browse Products
         </a>
      </div>

      <?php endif; ?>
   </div>
</section>

<?php include('footer.php'); ?>
