<?php
include('con.php.php');
session_start();
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit();
}

$msg = "";
$msg_type = "";

// Add Product
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['pname']);
    $p1   = mysqli_real_escape_string($con, $_POST['ppriceori']);
    $p2   = mysqli_real_escape_string($con, $_POST['ppricedes']);
    $q    = intval($_POST['pquan']);
    $pd   = mysqli_real_escape_string($con, $_POST['pdes']);

    $file_name = $_FILES['pi']['name'];
    $tmp       = $_FILES['pi']['tmp_name'];
    $folder    = "../images/" . $file_name; // Fixed: upload to main images folder

    if (move_uploaded_file($tmp, $folder)) {
        $stmt = $con->prepare("INSERT INTO product (p_name, p_price_ori, p_price_des, p_image, p_quantity, p_description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddsis", $name, $p1, $p2, $file_name, $q, $pd);

        if ($stmt->execute()) {
            $msg = "Product added successfully.";
            $msg_type = "success";
        } else {
            $msg = "Error adding product.";
            $msg_type = "error";
        }
        $stmt->close();
    } else {
        $msg = "Failed to upload image.";
        $msg_type = "error";
    }
}

// Update Product
if (isset($_POST['up'])) {
    $pid  = intval($_POST['pid']);
    $name = mysqli_real_escape_string($con, $_POST['pname']);
    $p1   = mysqli_real_escape_string($con, $_POST['ppriceori']);
    $p2   = mysqli_real_escape_string($con, $_POST['ppricedes']);
    $q    = intval($_POST['pquan']);
    $pd   = mysqli_real_escape_string($con, $_POST['pdes']);

    $file_name = $_FILES['pi']['name'];
    $tmp       = $_FILES['pi']['tmp_name'];
    $folder    = "../images/" . $file_name;

    if (!empty($file_name)) {
        move_uploaded_file($tmp, $folder);
        $image_query = ", p_image='$file_name'";
    } else {
        $image_query = "";
    }

    $update_query = "UPDATE product SET p_name='$name', p_price_ori='$p1', p_price_des='$p2', p_quantity='$q', p_description='$pd' $image_query WHERE p_id='$pid'";
    if (mysqli_query($con, $update_query)) {
        $msg = "Product updated successfully.";
        $msg_type = "success";
    } else {
        $msg = "Error updating product.";
        $msg_type = "error";
    }
}

// Delete Product
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM product WHERE p_id='$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        echo "<script>window.location='product.php';</script>";
        exit();
    } else {
        $msg = "Error deleting product.";
        $msg_type = "error";
    }
}

// Fetch product for update
$product = null;
if (isset($_GET['id'])) {
    $p_id = intval($_GET['id']);
    $result = mysqli_query($con, "SELECT * FROM product WHERE p_id='$p_id'");
    $product = mysqli_fetch_array($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Management – Mirecal</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --black: #0A0A0F; --dark: #12121A; --card: #1A1A2E; --gold: #C9A84C; --gold-lt: #E8CC7A; --cream: #F5EDD6; --text: #B8B8C8; --text-dim: #6B6B8A; --border: rgba(201,168,76,0.2); --border-h: rgba(201,168,76,0.5); }
        body { font-family: 'Inter', sans-serif; background: var(--black); color: var(--text); display: flex; min-height: 100vh; }
        
        /* Sidebar */
        aside { width: 280px; background: var(--dark); border-right: 1px solid var(--border); display: flex; flex-direction: column; }
        .sidebar-header { padding: 30px 24px; border-bottom: 1px solid var(--border); text-align: center; }
        .sidebar-header h2 { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: var(--cream); letter-spacing: 2px; text-transform: uppercase; }
        .sidebar-header h2 span { color: var(--gold); }
        .sidebar-menu { padding: 24px 0; flex: 1; }
        .sidebar-menu ul { list-style: none; }
        .sidebar-menu li a { display: block; padding: 14px 30px; color: var(--text-dim); text-decoration: none; font-size: 0.95rem; font-weight: 500; letter-spacing: 1px; transition: all 0.3s; border-left: 3px solid transparent; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { color: var(--gold); background: rgba(201,168,76,0.05); border-left-color: var(--gold); }
        .sidebar-footer { padding: 24px 30px; border-top: 1px solid var(--border); }
        .sidebar-footer a { color: #ef4444; text-decoration: none; font-size: 0.9rem; font-weight: 600; display: inline-block; transition: 0.3s; }
        .sidebar-footer a:hover { color: #f87171; }

        /* Main Content */
        main { flex: 1; padding: 40px; overflow-y: auto; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .topbar h1 { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; color: var(--cream); }

        .toast-msg { padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.9rem; }
        .toast-msg.success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #22c55e; }
        .toast-msg.error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; }

        .form-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 30px; margin-bottom: 40px; }
        .form-card h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: var(--gold); margin-bottom: 20px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { display: block; font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 8px; }
        .form-input { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--cream); padding: 12px 16px; border-radius: 8px; font-size: 0.9rem; outline: none; transition: 0.3s; }
        .form-input:focus { border-color: var(--gold); }
        .btn-submit { background: var(--gold); color: var(--black); border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-submit:hover { background: var(--gold-lt); box-shadow: 0 4px 15px rgba(201,168,76,0.3); }

        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: rgba(201,168,76,0.1); color: var(--gold); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; padding: 14px; text-align: left; }
        td { padding: 14px; border-bottom: 1px solid var(--border); color: var(--text); font-size: 0.9rem; }
        tr:hover td { background: rgba(255,255,255,0.02); }
        .prod-img { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border); }
        .btn-edit { background: rgba(34,197,94,0.15); color: #22c55e; border: 1px solid rgba(34,197,94,0.3); padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; margin-right: 8px; }
        .btn-delete { background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; }
    </style>
</head>
<body>

    <aside>
        <div class="sidebar-header">
            <h2>Mire<span>cal</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="product.php" class="active">Product Management</a></li>
                <li><a href="customer.php">Customer Management</a></li>
                <li><a href="#">Sales Management</a></li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="logout.php">← Logout</a>
        </div>
    </aside>

    <main>
        <div class="topbar">
            <h1>Product Management</h1>
        </div>

        <?php if(!empty($msg)): ?>
            <div class="toast-msg <?php echo $msg_type; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="form-card">
            <h3><?php echo $product ? "Edit Product" : "Add New Product"; ?></h3>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="pid" value="<?php echo $product['p_id'] ?? ''; ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="pname" class="form-input" value="<?php echo $product['p_name'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity in Stock</label>
                        <input type="number" name="pquan" class="form-input" value="<?php echo $product['p_quantity'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Original Price (₹)</label>
                        <input type="text" name="ppriceori" class="form-input" value="<?php echo $product['p_price_ori'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Discounted Price (₹)</label>
                        <input type="text" name="ppricedes" class="form-input" value="<?php echo $product['p_price_des'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Product Description</label>
                        <textarea name="pdes" class="form-input" rows="3" required><?php echo $product['p_description'] ?? ''; ?></textarea>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="pi" class="form-input" accept="image/*" <?php echo $product ? '' : 'required'; ?>>
                        <?php if($product && !empty($product['p_image'])): ?>
                            <div style="margin-top:10px; font-size:0.8rem; color:var(--gold)">Current: <?php echo $product['p_image']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" name="<?php echo $product ? 'up' : 'submit'; ?>" class="btn-submit">
                    <?php echo $product ? 'Update Product' : 'Add Product'; ?>
                </button>
                <?php if($product): ?>
                    <a href="product.php" style="color:var(--text-dim); margin-left:16px; font-size:0.9rem; text-decoration:none">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price (Des/Ori)</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM product ORDER BY p_id DESC");
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>
                            <td><img src='../images/{$row['p_image']}' class='prod-img'></td>
                            <td style='color:var(--cream)'>{$row['p_name']}</td>
                            <td><span style='color:var(--gold)'>₹{$row['p_price_des']}</span> / <span style='text-decoration:line-through;font-size:0.8rem'>₹{$row['p_price_ori']}</span></td>
                            <td>{$row['p_quantity']}</td>
                            <td>
                                <a href='product.php?id={$row['p_id']}' class='btn-edit'>Edit</a>
                                <a href='product.php?delete_id={$row['p_id']}' class='btn-delete' onclick='return confirm(\"Delete this product?\")'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
