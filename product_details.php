<?php
    include('header.php');
    include('con.php');
    
    
      
        $p_id = $_GET['id'];
        $sel = "SELECT * FROM product WHERE p_id='$p_id'";
        $qu = mysqli_query($con,$sel);
        $re = mysqli_fetch_array($qu);

        //add to cart
    

        if(isset($_POST['cart'])){
            if(!isset($_SESSION['user']['u_id'])){
                header('location:login.php');
            }
            $uid = $_SESSION['user']['u_id'];
            $pid = $re['p_id'];
            $cart_name = $re['p_name'];
            $cart_image = $re['p_image'];
            $quantity = 1;
            $cart_total = $re['p_price_des'];
            
           

            $check_cart = "SELECT * FROM cart WHERE u_id='$uid' AND c_name='$cart_name'";
            $check_cart_ex = mysqli_query($con, $check_cart);
            if(Mysqli_num_rows($check_cart_ex) > 0){
                echo "<script>alert('Product already in cart');</script>";
            }else{
                $add = "INSERT INTO cart (u_id,p_id,c_name,c_image,c_quantity,c_price) VALUES ('$uid','$pid','$cart_name','$cart_image','$quantity','$cart_total')";
                $cart_query = mysqli_query($con,$add);
                if($cart_query){
                    echo "<script>alert('Add to cart')</script>";
                }
                else{
                    echo "<script>alert('Some error')</script>";
                }
            }
          

        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to an external CSS file for better organization -->
    <style>
        /* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #333;
    line-height: 1.6;
}

/* Container for product details */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
}


/* Product Image Section */
.img-box {
    max-width: 100%;
    height: auto;
}

.product-image {
    width: 100%;
    max-width: 500px; /* Limits the maximum image size */
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds subtle shadow */
}

/* Product Information Section */
.detail-box h2 {
    font-size: 2.2rem;
    margin-bottom: 10px;
    font-weight: bold;
}

.detail-box h5 {
    font-size: 1.6rem;
    color: #f7444e;
    margin-bottom: 20px;
}

.detail-box p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 30px;
}

.buy_section {
    display: flex;
    gap: 15px;
}

.btn {
    padding: 12px 24px;
    text-align: center;
    text-decoration: none;
    font-size: 1rem;
    border-radius: 5px;
    color: white;
    border: none;
    cursor: pointer;
    width: 150px; /* Set fixed width for buttons */
}


button{
    background:blue;
    border-radius:7px;
    padding:20px 30px;
    background:#f7444e;
    color:white;
    outline:none;
    border-color:#f7444e;
}
button:hover{
    background:white;
    color:#f7444e;
    transition:0.4s;
}


.heading_container {
    margin-bottom: 20px;
}

.heading_center h3 {
    font-size: 2.2rem;
    color: #333;
    font-weight: bold;
}


    </style>
</head>
<body>

<!-- Product details section -->
<section class="product_details_section">
    <div class="container">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-5">
                <div class="img-box">
                    <img src="images/<?php echo $re['p_image']; ?>" alt="Product Image" class="product-image">
                </div>
            </div>
            <!-- Product Information -->
            <div class="col-md-5">
                <div class="detail-box">
                    <h2><?php echo $re['p_name']; ?></h2>
                    <h5 style="text-decoration:line-through">₹ <?php echo $re['p_price_ori']; ?></h5>
                    <h5>₹ <?php echo $re['p_price_des']; ?></h5>
                    <p><h5><?php echo $re['p_description']; ?></h5></p>

                    <!-- Add to Cart or Buy Now Button -->
                    <div class="buy_section">
                        <form method="post">
                            <button type="submit" name="cart">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
    include('footer.php');
?>

</body>
</html>
