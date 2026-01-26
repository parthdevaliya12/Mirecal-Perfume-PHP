<?php
include('head.php');
include('con.php');

if (isset($_SESSION['user'])) {
    $uid = $_SESSION['user']['u_id'];
}

// Fetch cart items
$fetch = "SELECT * FROM cart WHERE u_id='$uid'";
$qu = mysqli_query($con, $fetch);

// Calculate total price
$total_query = "SELECT SUM(c_price * c_quantity) AS total FROM cart WHERE u_id='$uid'";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'] + 50; // Including shipping charge

// Delete cart item
if (isset($_GET['id'])) {
    $delid = $_GET['id'];
    $del = "DELETE FROM cart WHERE c_id='$delid'";
    mysqli_query($con, $del);
    echo "<script>window.location.href='cart.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
          .empty{
            display:flex;
             justify-content:center; 
             align-items:center;
             margin:10% 0;
        } 
    </style>
</head>

<body>
<div class="container mt-5">
    <?php
    if(mysqli_num_rows($qu)>0){
    ?>
    <h2 class="text-center mb-4">🛒 Shopping Cart</h2>
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <table class="table table-bordered text-center">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_array($qu)) { ?>
                        <tr>
                            <td><img src="images/<?php echo $result['c_image']; ?>" class="img-fluid" style="height: 70px; width: 70px;"></td>
                            <td><?php echo $result['c_name']; ?></td>
                            <td>₹<?php echo number_format($result['c_price'], 2); ?></td>
                            <td>
                                <input type="number" value="<?php echo $result['c_quantity']; ?>" 
                                       min="1" data-id="<?php echo $result['c_id']; ?>" 
                                       class="form-control update-quantity" style="width: 80px; margin: auto;">
                            </td>
                            <td class="subtotal-<?php echo $result['c_id']; ?>">
                                ₹<?php echo number_format($result['c_price'] * $result['c_quantity'], 2); ?>
                            </td>
                            <td>
                                <a href="cart.php?id=<?php echo $result['c_id']; ?>" class="btn btn-danger">🗑 Cancel</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="border p-3">
                <h4 class="text-center bg-danger text-white p-2">🧾 Cart Summary</h4>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span id="cart-total">₹<?php echo number_format($total - 50, 2); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Shipping</span>
                        <span>₹50.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span id="cart-final-total">₹<?php echo number_format($total, 2); ?></span>
                    </li>
                </ul>
                <a href="checkout.php" class="btn btn-danger w-100 mt-3">🛍 Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>
<?php
   }else{
    ?>
    <div class="empty">
         <img src="images/emptycart.png" alt="" height="300px" width="300px">
         <h3>Your Cart Is Empty!!</h3>
    </div>
    
    <?php
   }
   ?>
<!-- JavaScript for Quantity Update -->
<script>
    $(document).ready(function(){
        $(".update-quantity").on("change", function(){
            var cart_id = $(this).data("id");
            var new_quantity = $(this).val();

            $.ajax({
                url: "update_quan.php",
                type: "POST",
                data: { id: cart_id, quantity: new_quantity },
                success: function(response){
                    var data = JSON.parse(response);
                    if(data.success){
                        $(".subtotal-" + cart_id).text("₹" + data.subtotal.toFixed(2));
                        $("#cart-total").text("₹" + (data.total - 50).toFixed(2));
                        $("#cart-final-total").text("₹" + data.total.toFixed(2));
                    } else {
                        alert("Error updating cart.");
                    }
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('footer.php'); ?>
