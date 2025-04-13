<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Fetch cart items and calculate subtotal
$sql = "SELECT c.cart_id, c.quantity_kg, c.unit_price_tk, c.total_price_tk, pt.product_name, pt.product_image, pt.product_type_id
        FROM cart c
        JOIN product_types pt ON c.product_type_id = pt.product_type_id";

$result = mysqli_query($conn, $sql);
$subtotal = 0.00;
$cart_items = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $subtotal += (float)$row['total_price_tk'];
        $cart_items[] = $row;
    }
} else {
    $cart_items = [];
}
$shipping = 100.00; // Fixed shipping cost in TK
$tax = 20.00;       // Fixed tax in TK
$total = $subtotal + $shipping + $tax;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $notes = $_POST['notes'] ?? '';
    $payment_method = $_POST['paymentMethod'];

    // Validate input (basic checks)
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($address) || empty($payment_method)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } elseif (empty($cart_items)) {
        echo "<script>alert('Your cart is empty.');</script>";
    } else {
        // Insert into orders table using prepared statement
        $stmt = $conn->prepare("INSERT INTO orders (first_name, last_name, email, phone_number, delivery_address, additional_notes, payment_method, subtotal, shipping, tax, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssssssddd", $first_name, $last_name, $email, $phone, $address, $notes, $payment_method, $subtotal, $shipping, $tax, $total);
            if ($stmt->execute()) {
                $order_id = $conn->insert_id; // Get the new order ID

                // Insert cart items into order_items
                $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_type_id, quantity_kg, unit_price_tk, total_price_tk) VALUES (?, ?, ?, ?, ?)");
                if ($stmt_items) {
                    foreach ($cart_items as $item) {
                        $product_type_id = $item['product_type_id'];
                        $quantity_kg = $item['quantity_kg'];
                        $unit_price_tk = $item['unit_price_tk'];
                        $total_price_tk = $item['total_price_tk'];
                        $stmt_items->bind_param("iiidd", $order_id, $product_type_id, $quantity_kg, $unit_price_tk, $total_price_tk);
                        $stmt_items->execute();
                    }
                    $stmt_items->close();
                } else {
                    echo "<script>alert('Error preparing order_items statement: " . addslashes($conn->error) . "');</script>";
                }

                // Clear the cart
                mysqli_query($conn, "DELETE FROM cart");

                // Redirect to confirmation page
                header("Location: recipt_page.php");
                exit();
            } else {
                echo "<script>alert('Error executing order insert: " . addslashes($stmt->error) . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing order statement: " . addslashes($conn->error) . "');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartFarm - Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="../css_file/order_details.css?v=<?php echo time(); ?>" />
</head>
<body>
    <!-- Navbar starts here -->
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../IMG/LOGO DESIGN-01.png" alt="logo" /></a>
            </div>
            <div class="desktop-only dropdown">
                <button class="btn all_catagories" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bars-staggered"></i> All Categories <i class="fa-solid fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" type="button">Action</button></li>
                    <li><button class="dropdown-item" type="button">Another action</button></li>
                    <li><button class="dropdown-item" type="button">Something else here</button></li>
                </ul>
            </div>
            <form class="d-flex search-form desktop-only" action="../index.php" method="GET">
                <input class="form-control search-input" type="search" name="search" placeholder="Type Your Products" aria-label="Search" />
                <button class="btn search-button" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="icons-right">
                <div class="user-icon"><i class="fa-regular fa-user"></i></div>
                <div class="heart-icon"><i class="fa-regular fa-heart"></i></div>
                <div class="shopping-cart-icon">
                    <a href="add_to_cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </div>
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <div class="hamburger-menu"><i class="fa-solid fa-bars"></i></div>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="mobile-only dropdown mb-3">
                            <button class="btn all_catagories w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars-staggered"></i> All Categories <i class="fa-solid fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Action</button></li>
                                <li><button class="dropdown-item" type="button">Another action</button></li>
                                <li><button class="dropdown-item" type="button">Something else here</button></li>
                            </ul>
                        </div>
                        <form class="d-flex search-form mobile-only mb-3" action="../index.php" method="GET">
                            <input class="form-control search-input" type="search" name="search" placeholder="Type Your Products" aria-label="Search" />
                            <button class="btn search-button" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        <div class="offcanvas-buttons">
                            <button class="btn w-100 mb-2 alvi"><a href="../index.php">Home</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="official_website.php">Official Website</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="farmer.php">Be a Farmer</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar ends here -->

    <!-- Main Content Section -->
    <main class="checkout-page">
        <div class="checkout-container">
            <!-- Left Column - Order Form -->
            <div class="order-form">
                <h2 class="section-title">Order Information</h2>
                <form method="POST">
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">Personal Information</h3>
                        <div class="name-fields">
                            <div class="input-group">
                                <label for="firstName">First Name*</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="input-group">
                                <label for="lastName">Last Name*</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="email">Email Address*</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="phone">Phone Number*</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>
                    <!-- Delivery Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">Delivery Information</h3>
                        <div class="input-group">
                            <label for="address">Delivery Address*</label>
                            <textarea id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="input-group">
                            <label for="notes">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="2" placeholder="Any special instructions for delivery"></textarea>
                        </div>
                    </div>
                    <!-- Payment Method -->
                    <div class="form-section">
                        <h3 class="form-section-title">Payment Method</h3>
                        <div class="payment-methods">
                            <div class="payment-option">
                                <input type="radio" id="mastercard" name="paymentMethod" value="MasterCard" checked>
                                <label for="mastercard"><i class="fab fa-cc-mastercard"></i> MasterCard</label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" id="visa" name="paymentMethod" value="Visa">
                                <label for="visa"><i class="fab fa-cc-visa"></i> Visa</label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" id="cod" name="paymentMethod" value="COD">
                                <label for="cod"><i class="fas fa-money-bill-wave"></i> Cash on Delivery</label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" id="bkash" name="paymentMethod" value="bKash">
                                <label for="bkash"><i class="fas fa-mobile-alt"></i> bKash</label>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden field to trigger form submission -->
                    <input type="hidden" name="confirm_order" value="1">
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="btn-back" type="button" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </button>
                        <button class="btn-confirm" type="submit">
                            Confirm Order <i class="fas fa-check"></i>
                        </button>
                    </div>
                </form>
            </div>
            <!-- Right Column - Order Summary -->
            <div class="order-summary">
                <h2 class="section-title">Your Order</h2>
                <!-- Products List -->
                <div class="products-list">
                    <?php if (!empty($cart_items)) {
                        foreach ($cart_items as $item) { ?>
                            <div class="product-item">
                                <div class="product-image">
                                    <img src="../Uploads/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                                </div>
                                <div class="product-info">
                                    <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                                    <p><?php echo $item['quantity_kg']; ?>kg × <?php echo number_format($item['unit_price_tk'], 2); ?> TK</p>
                                </div>
                                <div class="product-price"><?php echo number_format($item['total_price_tk'], 2); ?> TK</div>
                            </div>
                        <?php }
                    } else { ?>
                        <p>No items in cart.</p>
                    <?php } ?>
                </div>
                <!-- Order Totals -->
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span><?php echo number_format($subtotal, 2); ?> TK</span>
                    </div>
                    <div class="total-row">
                        <span>Shipping:</span>
                        <span><?php echo number_format($shipping, 2); ?> TK</span>
                    </div>
                    <div class="total-row">
                        <span>Tax:</span>
                        <span><?php echo number_format($tax, 2); ?> TK</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total:</span>
                        <span><?php echo number_format($total, 2); ?> TK</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer starts here -->
    <footer class="footer">
        <div class="container">
            <div class="footer-section logo-section">
                <h2 class="logo">SmartFarm</h2>
                <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <p><i class="fas fa-map-marker-alt"></i> 23/A Road, New York City</p>
                <p><i class="fas fa-phone-alt"></i> +9888-256-666</p>
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
                    <li><a href="#">Smartphones</a></li>
                    <li><a href="#">Headphones</a></li>
                    <li><a href="#">Laptop & Tablet</a></li>
                    <li><a href="#">Monitors</a></li>
                    <li><a href="#">Printers</a></li>
                    <li><a href="#">Gadgets</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Accounts</h3>
                <ul>
                    <li><a href="#">My Orders</a></li>
                    <li><a href="#">Cart</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">Compare</a></li>
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Wishlist</a></li>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../index.js"></script>
</body>
</html>