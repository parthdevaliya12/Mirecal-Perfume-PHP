<?php 
include('head.php');
include("con.php");

// Check if user is logged in
if (!isset($_SESSION['user']['u_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit();
}

$uid = $_SESSION['user']['u_id'];

// Fetch orders
$fetch_order = "SELECT * FROM orders WHERE u_id='$uid'";
$fetch_query = mysqli_query($con, $fetch_order);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .table thead {
            background-color: #dc3545;
            color: white;
        }
        .status-badge {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: bold;
        }
        .badge-delivered {
            background-color: #28a745;
        }
        .badge-pending {
            background-color: #ffc107;
            color: black;
        }
        .badge-cancelled {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center text-danger mb-4">My Orders</h2>
    <div class="card">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Order Date</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($fetch_query)) { ?>
                <tr>
                    <td><?php echo $order['o_pname']; ?></td>
                    <td><img src="images/<?php echo $order['o_pimg']; ?>" height="80" width="80"></td>
                    <td><?php echo date("d-m-Y", strtotime($order['o_date'])); ?></td>
                    <td><?php echo $order['o_quantity']; ?></td>
                    <td>₹<?php echo $order['o_price']; ?></td>
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
                            echo '<span class="status-badge badge-secondary">'.$status.'</span>';
                        }
                        ?>
                    </td>
                    <?php
                    // Handle order cancellation
                    if (isset($_GET['id'])) {
                        $oid = $_GET['id'];
                        $oid_del = "DELETE FROM orders WHERE o_id ='$oid'";
                        $del_query = mysqli_query($con, $oid_del);

                        // Optionally, you can add a success message if the order is successfully deleted
                        if ($del_query) {
                            echo "<script>alert('Order cancelled successfully!'); window.location.href='order.php';</script>";
                        } else {
                            echo "<script>alert('Error cancelling the order. Please try again later.'); window.location.href='order.php';</script>";
                        }
                    }
                    ?>
                    <td><a href="order.php?id=<?php echo $order['o_id']; ?>" class="btn btn-danger btn-sm">Cancel</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('footer.php'); ?>
