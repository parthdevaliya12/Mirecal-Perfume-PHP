<?php
include('con.php');
session_start();

if(isset($_POST['id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['id'];
    $new_quantity = $_POST['quantity'];

    // Fetch item price
    $fetch_price = "SELECT c_price FROM cart WHERE c_id='$cart_id'";
    $result = mysqli_query($con, $fetch_price);
    $row = mysqli_fetch_assoc($result);
    $price_per_unit = $row['c_price'];
    $subtotal = $price_per_unit * $new_quantity;

    // Update quantity in the database
    $update_query = "UPDATE cart SET c_quantity='$new_quantity' WHERE c_id='$cart_id'";
    mysqli_query($con, $update_query);

    // Recalculate total
    $total_query = "SELECT SUM(c_price * c_quantity) AS total FROM cart WHERE u_id='{$_SESSION['user']['u_id']}'";
    $total_result = mysqli_query($con, $total_query);
    $total_row = mysqli_fetch_assoc($total_result);
    $total = $total_row['total'] + 50; // Including shipping

    // Return updated values as JSON
    echo json_encode(["success" => true, "subtotal" => $subtotal, "total" => $total]);
} else {
    echo json_encode(["success" => false]);
}
?>
