<?php
include('con.php');
session_start();
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit();
}

// Add Product
if (isset($_POST['submit'])) {
    $name = $_POST['pname'];
    $p1 = $_POST['ppriceori'];
    $p2 = $_POST['ppricedes'];
    $q = $_POST['pquan'];
    $pd = $_POST['pdes'];

    $file_name = $_FILES['pi']['name'];
    $tmp = $_FILES['pi']['tmp_name'];
    $folder = "./uploads/" . $file_name;

    if (move_uploaded_file($tmp, $folder)) {
        $stmt = $con->prepare("INSERT INTO product (p_name, p_price_ori, p_price_des, p_image, p_quantity, p_description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddsis", $name, $p1, $p2, $file_name, $q, $pd);

        if ($stmt->execute()) {
            echo "<h2 style='position:absolute; top:17%;left:25%'>Product added successfully...</h2>";
        } else {
            echo "<script>alert('Error adding product')</script>";
        }
        $stmt->close();
    }
}

// Update Product
if (isset($_POST['up'])) {
    $pid = $_POST['pid'];
    $name = $_POST['pname'];
    $p1 = $_POST['ppriceori'];
    $p2 = $_POST['ppricedes'];
    $q = $_POST['pquan'];
    $pd = $_POST['pdes'];

    $file_name = $_FILES['pi']['name'];
    $tmp = $_FILES['pi']['tmp_name'];
    $folder = "./uploads/" . $file_name;

    // Check if new image is uploaded
    if (!empty($file_name)) {
        move_uploaded_file($tmp, $folder);
        $image_query = ", p_image='$file_name'";
    } else {
        $image_query = "";
    }

    $update_query = "UPDATE product SET p_name='$name', p_price_ori='$p1', p_price_des='$p2', p_quantity='$q', p_description='$pd' $image_query WHERE p_id='$pid'";
    if (mysqli_query($con, $update_query)) {
        echo "<h2 style='position:absolute; top:17%;left:25%'>Product updated successfully...</h2>";
    } else {
        echo "<script>alert('Error updating product')</script>";
    }
}

// Delete Product
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM product WHERE p_id='$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Product deleted successfully');window.location='product.php';</script>";
    } else {
        echo "<script>alert('Error deleting product')</script>";
    }
}

// Fetch product for update if ID is set
$product = null;
if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    $result = mysqli_query($con, "SELECT * FROM product WHERE p_id='$p_id'");
    $product = mysqli_fetch_array($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <style>
        * { margin: 0; padding: 0; font-family: sans-serif; }
        header { background-color: black; height: 70px; display: flex; align-items: center; justify-content: center; }
        header h1 { color: white; font-size: 2rem; }
        article { background-color: firebrick; height: 660px; width: 20%; }
        article ul { display: flex; flex-direction: column; }
        article li { list-style: none; padding: 20px; background-color: white; margin: 5% 5%; border-radius: 15px; }
        article a { text-decoration: none; color: black; }
        article a:hover { border-bottom: solid 2px firebrick; transition: all 0.5s ease-in; }
        form { margin: 20px; }
        input, textarea { width: 100%; padding: 10px; margin: 5px 0; font-size: 1rem; border-radius: 6px; }
        button { padding: 10px 20px; font-size: 1rem; border-radius: 7px; background: firebrick; color: white; cursor: pointer; }
        button:hover { background: white; color: black; border: 1px solid firebrick; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; text-align: center; }
        .green, .red { text-decoration: none; padding: 5px 10px; border-radius: 5px; }
        .green { background: green; color: white; }
        .red { background: firebrick; color: white; }
    </style>
</head>
<body>
    <header>
        <h1>Product Management</h1>
    </header>
    <article>
        <ul>
            <li><a href="product.php" class="active">Product Management</a></li>
            <li><a href="customer.php">Customer Management</a></li>
            <li><a href="#">Sales Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </article>

    <section>
        <form method="post" enctype="multipart/form-data">
            <h2><?php echo $product ? "Update Product" : "Add Product"; ?></h2>
            <input type="hidden" name="pid" value="<?php echo $product['p_id'] ?? ''; ?>">
            <input type="text" name="pname" placeholder="Product Name" value="<?php echo $product['p_name'] ?? ''; ?>" required>
            <input type="text" name="ppriceori" placeholder="Original Price" value="<?php echo $product['p_price_ori'] ?? ''; ?>" required>
            <input type="text" name="ppricedes" placeholder="Discounted Price" value="<?php echo $product['p_price_des'] ?? ''; ?>" required>
            <input type="number" name="pquan" placeholder="Quantity" value="<?php echo $product['p_quantity'] ?? ''; ?>" required>
            <textarea name="pdes" placeholder="Product Description" required><?php echo $product['p_description'] ?? ''; ?></textarea>
            <input type="file" name="pi" accept="image/*">
            <button type="submit" name="<?php echo $product ? 'up' : 'submit'; ?>">
                <?php echo $product ? 'Update Product' : 'Add Product'; ?>
            </button>
        </form>
    </section>

    <section>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Original Price</th>
                <th>Discounted Price</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            $result = mysqli_query($con, "SELECT * FROM product");
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
                    <td>{$row['p_id']}</td>
                    <td>{$row['p_name']}</td>
                    <td>{$row['p_price_ori']}</td>
                    <td>{$row['p_price_des']}</td>
                    <td><img src='./uploads/{$row['p_image']}' width='50'></td>
                    <td>{$row['p_quantity']}</td>
                    <td>{$row['p_description']}</td>
                    <td><a href='product.php?id={$row['p_id']}' class='green'>Edit</a></td>
                    <td><a href='product.php?delete_id={$row['p_id']}' class='red' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                </tr>";
            }
            ?>
        </table>
    </section>
</body>
</html>
