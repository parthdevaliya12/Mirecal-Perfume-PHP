<?php
include('head.php');
include('con.php');

if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}

$uid = $_SESSION['user']['u_id'];

// Fetch cart items
$cart_query = "SELECT * FROM cart WHERE u_id='$uid'";
$cart_result = mysqli_query($con, $cart_query);

// Calculate total price
$total_query = "SELECT SUM(c_price * c_quantity) AS total FROM cart WHERE u_id='$uid'";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$subtotal = $total_row['total'] ?? 0;
$shipping_charge = ($subtotal > 0) ? 50 : 0;
$total = $subtotal + $shipping_charge;

if (isset($_POST['sub'])) {
    $cart_result = mysqli_query($con, "SELECT * FROM cart WHERE u_id='$uid'"); // Re-fetch cart items

    if (mysqli_num_rows($cart_result) > 0) {
        while ($cartdata = mysqli_fetch_array($cart_result)) {
            $cid = $cartdata['c_id'];
            $pid = $cartdata['p_id'];
            $name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $pincode = $_POST['pincode'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $price = $cartdata['c_price'];
            $quantity = $cartdata['c_quantity'];
            $pname = $cartdata['c_name'];
            $pimg = $cartdata['c_image'];
            $payment_method = $_POST['payment_method'];
            $status = "Pending";

            $in_order = "INSERT INTO orders (u_id, c_id, p_id, o_name, o_email, o_mobile, o_address, o_pincode, o_city, o_state, o_price, o_quantity,o_pname,o_pimg,o_payment_method,o_status) 
                         VALUES ('$uid', '$cid', '$pid', '$name', '$email', '$phone', '$address', '$pincode', '$city', '$state', '$price', '$quantity','$pname','$pimg', '$payment_method','$status')";

            $in_order_query = mysqli_query($con, $in_order);
            if (!$in_order_query) {
                die("Order Insertion Error: " . mysqli_error($con));
            }
        }


        mysqli_query($con, "SET FOREIGN_KEY_CHECKS=0");

        // Delete cart items only (orders remain)
        $clear_cart_query = "DELETE FROM cart WHERE u_id='$uid'";
        mysqli_query($con, $clear_cart_query);

        // Re-enable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS=1");


        echo "<script>alert('Order placed successfully!'); window.location.href='order.php?success=1';</script>";
        exit();

    } else {
        echo "<script>alert('Error: Your cart is empty!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        .form-control, .btn { border-radius: 8px; }
        .order-summary { background-color: #fff3f3; border-radius: 10px; padding: 20px; }
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center text-danger mb-4">Checkout</h2>
    <div class="row">
        
        <!-- Billing Details -->
        <div class="col-lg-7">
            <div class="card p-4">
                <h4 class="text-danger mb-3">Billing Details</h4>
                <form action="" method="post" onsubmit="return validateForm()">
                    <input type="hidden" name="user_id" value="<?php echo $uid; ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="full_name" class="form-control" id="full_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" id="phone" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Pincode</label>
                            <input type="text" name="pincode" class="form-control" id="pincode" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">City</label>
                            <input type="text" name="city" class="form-control" id="city" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">State</label>
                            <input type="text" name="state" class="form-control" id="state" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="COD">Cash on Delivery</option>
                            <option value="UPI">UPI</option>
                            <option value="Net Banking">Net Banking</option>
                            <option value="Credit/Debit Card">Credit/Debit Card</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 mt-3" name="sub">Place Order</button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="card order-summary p-4">
                <h4 class="bg-danger text-white p-2 text-center">Order Summary</h4>
                <ul class="list-group">
                    <?php 
                    $cart_result = mysqli_query($con, "SELECT * FROM cart WHERE u_id='$uid'"); // Re-fetch for display
                    while ($cart = mysqli_fetch_array($cart_result)) { ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo $cart['c_name']; ?> (x<?php echo $cart['c_quantity']; ?>)</span>
                            <span>₹<?php echo number_format($cart['c_price'] * $cart['c_quantity'], 2); ?></span>
                        </li>
                    <?php } ?>
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>₹<?php echo number_format($total, 2); ?></span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>

<script>
    function validateForm() {
        let phone = document.getElementById("phone").value;
        let pincode = document.getElementById("pincode").value;
        if (!/^\d{10}$/.test(phone)) {
            alert("Enter a valid 10-digit phone number");
            return false;
        }
        if (!/^\d{6}$/.test(pincode)) {
            alert("Enter a valid 6-digit pincode");
            return false;
        }
        return true;
    }
</script>

</body>
</html>

<?php include('footer.php'); ?>
