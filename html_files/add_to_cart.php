<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $product_type_id = (int)$_POST['product_type_id'];
    $quantity_kg = (int)$_POST['quantity'];
    $unit_price_tk = (float)$_POST['unit_price'];
    $total_price_tk = (float)$_POST['total_price'];
    $product_type_id = mysqli_real_escape_string($conn, $product_type_id);

    // Check total available weight
    $sql = "SELECT SUM(weight_kg) AS total_weight FROM products WHERE product_type_id = $product_type_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $available_weight = $row['total_weight'];

    if ($available_weight >= $quantity_kg) {
        // Deduct quantity from products (distribute across rows)
        $remaining_qty = $quantity_kg;
        $sql = "SELECT product_id, weight_kg FROM products WHERE product_type_id = $product_type_id AND weight_kg > 0 ORDER BY entry_date";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc() && $remaining_qty > 0) {
            $product_id = $row['product_id'];
            $current_weight = $row['weight_kg'];
            $deduct = min($remaining_qty, $current_weight);
            $new_weight = $current_weight - $deduct;
            $conn->query("UPDATE products SET weight_kg = $new_weight WHERE product_id = $product_id");
            $remaining_qty -= $deduct;
        }

        // Add to cart
        $sql = "INSERT INTO cart (product_type_id, quantity_kg, unit_price_tk, total_price_tk)
                VALUES ($product_type_id, $quantity_kg, $unit_price_tk, $total_price_tk)";
        $conn->query($sql);
    } else {
        echo "Not enough stock available!";
    }
    header("Location: add_to_cart.php"); // Redirect to refresh cart
    exit();
}

// Handle Remove from Cart
if (isset($_GET['remove'])) {
    $cart_id = (int)$_GET['remove'];
    $cart_id = mysqli_real_escape_string($conn, $cart_id);
    $sql = "SELECT product_type_id, quantity_kg FROM cart WHERE cart_id = $cart_id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        $product_type_id = $row['product_type_id'];
        $quantity_kg = $row['quantity_kg'];

        // Add quantity back to products
        $sql = "SELECT product_id, weight_kg FROM products WHERE product_type_id = $product_type_id AND weight_kg > 0 ORDER BY entry_date LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_id = $row['product_id'];
            $new_weight = $row['weight_kg'] + $quantity_kg;
            $conn->query("UPDATE products SET weight_kg = $new_weight WHERE product_id = $product_id");
        } else {
            // If no existing row, add a new one with original farmer_id and farm_type_id
            $sql = "INSERT INTO products (weight_kg, price_tk, product_type_id, farmer_id, farm_type_id, description, entry_date)
                    SELECT $quantity_kg, (SELECT AVG(price_tk) FROM products WHERE product_type_id = $product_type_id), 
                    $product_type_id, farmer_id, farm_type_id, 'Returned stock', CURDATE()
                    FROM products WHERE product_type_id = $product_type_id LIMIT 1";
            $conn->query($sql);
        }

        // Delete from cart
        $conn->query("DELETE FROM cart WHERE cart_id = $cart_id");
    }
    header("Location: add_to_cart.php"); // Redirect to refresh cart
    exit();
}

// Fetch cart items and calculate subtotal
$sql = "SELECT c.cart_id, c.quantity_kg, c.unit_price_tk, c.total_price_tk, pt.product_name, pt.product_image
        FROM cart c
        JOIN product_types pt ON c.product_type_id = pt.product_type_id";
$result = $conn->query($sql);
$item_count = $result->num_rows;
$subtotal = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subtotal += $row['total_price_tk']; // Sum total_price_tk for subtotal
    }
    // Reset result pointer to reuse it in HTML
    $result->data_seek(0);
}

// Define fixed costs
$shipping = 100; // Fixed shipping cost in TK
$tax = 20;      // Fixed tax in TK
$total = $subtotal + $shipping + $tax; // Calculate total

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartFarm</title>
    <!-- <link rel="icon" type="image/png" sizes="2x2" href="/IMG/small logo.png" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css_file/add_to_cart.css" />
</head>
<body>
    <!-- Navbar starts here -->
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../IMG/LOGO DESIGN-01.png" alt="logo" /></a>
            </div>


            <div class="icons-right">
                <div class="user-icon">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="heart-icon">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <div class="shopping-cart-icon">
                    <a href="add_to_cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php if ($item_count > 0) { ?>
                            <span class="cart-count"><?php echo $item_count; ?></span>
                        <?php } ?>
                    </a>
                </div>
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <div class="hamburger-menu">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </button>

                <!-- Offcanvas Menu -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <!-- Mobile Categories -->

                        <!-- Mobile Search -->


                        <!-- Offcanvas Buttons -->
                        <div class="offcanvas-buttons">
                            <button class="btn w-100 mb-2 alvi"><a href="../index.php">Home</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="official_website.html">Official Website</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="farmer.php">Be a Farmer</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar ends here -->

    <!-- Middle part starts here -->
    <div class="cart-container">
        <div class="cart-header">
            <h2>Shopping Cart</h2>
            <p>You have <span class="item-count"><?php echo $item_count; ?></span> items in your cart</p>
        </div>

        <div class="cart-content">
            <div class="cart-items">
                <div class="cart-item-header">
                    <div class="product-info-header">Product</div>
                    <div class="price-header">Unit Price</div>
                    <div class="quantity-header">Quantity</div>
                    <div class="total-header">Total</div>
                    <div class="action-header">Action</div>
                </div>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $image_path = "../uploads/" . $row['product_image'];
                ?>
                    <div class="cart-item" id="cart-item-<?php echo $row['cart_id']; ?>">
                        <div class="product-info">
                            <div class="product-image">
                                <img src="<?php echo $image_path; ?>" alt="<?php echo $row['product_name']; ?>" />
                            </div>
                            <div class="product-details">
                                <h3><?php echo $row['product_name']; ?></h3>
                                <p>Fresh from local farm</p>
                            </div>
                        </div>
                        <div class="price"><?php echo number_format($row['unit_price_tk'], 2); ?> TK</div>
                        <div class="quantity">  
                            <input type="number" value="<?php echo $row['quantity_kg']; ?>" disabled />
                        </div>
                        <div class="total"><?php echo number_format($row['total_price_tk'], 2); ?> TK</div>
                        <div class="action">
                            <button class="remove-btn" onclick="removeItem(<?php echo $row['cart_id']; ?>)"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>No items in cart.</p>";
                }
                ?>
            </div>

            <div class="cart-summary">
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    <div class="voucher-section">
                        <input type="text" placeholder="Enter voucher code" />
                        <button class="apply-btn">Apply</button>
                    </div>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span><?php echo number_format($subtotal, 2); ?> TK</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span><?php echo number_format($shipping, 2); ?> TK</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax:</span>
                        <span><?php echo number_format($tax, 2); ?> TK</span>
                    </div>
                    <div class="summary-row total-row">
                        <span>Total:</span>
                        <span><?php echo number_format($total, 2); ?> TK</span>
                    </div>
                    <div class="action-buttons">
                        <a href="../index.php"><button class="continue-btn">Continue Shopping</button></a> 
                        <a href="order_details.php"><button class="checkout-btn">Proceed to Checkout</button></a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Middle part ends here -->

     <!-- Footer starts here -->
     <footer class="footer">
        <div class="container">
            <div class="footer-section logo-section">
                <h2 class="logo">SmartFarm</h2>
                <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <p><i class="fas fa-map-marker-alt"></i> 23/A Road,Uttara,Dhaka</p>
                <p><i class="fas fa-phone-alt"></i>)01711946008</p>
                <div class="social-icons">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-x-twitter"></i>
                    <i class="fab fa-pinterest"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-tiktok"></i>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Beef</a></li>
                    <li><a href="#">Rice</a></li>
                    <li><a href="#">Apple</a></li>
                    <li><a href="#">Banana</a></li>
                    <li><a href="#">Egg</a></li>
                    <li><a href="#">Chicken</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Accounts</h3>
                <ul>
                    <li><a href="#">My Orders</a></li>
                    <li><a href="#">Cart</a></li>
                    <li><a href="#">Checkout</a></li>   
                    <li><a href="#">My Account</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Privacy Policy</h3>
                <ul>
                    <li><a href="#">Returns & Exchanges</a></li>
                    <li><a href="#">Payment Terms</a></li>
                    <li><a href="#">Delivery Terms</a></li>
                    <li><a href="#">Payment & Pricing</a></li>
                    <li><a href="#">Terms Of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <!-- Footer ends here -->

    <script src="https://kit.fontawesome.com/85fcd39f72.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../index.js"></script>

    <script>
        function removeItem(cartId) {
            fetch('add_to_cart.php?remove=' + cartId)
                .then(response => {
                    if (response.ok) {
                        document.getElementById('cart-item-' + cartId).style.display = 'none';
                        let itemCount = parseInt(document.querySelector('.item-count').textContent);
                        document.querySelector('.item-count').textContent = itemCount - 1;
                    } else {
                        alert('Failed to remove item');
                    }
                });
        }
    </script>
</body>
</html>