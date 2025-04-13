<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Empty the cart table when this page is loaded
$sql_clear_cart = "DELETE FROM cart";
mysqli_query($conn, $sql_clear_cart);

// Fetch the latest order
$sql_order = "SELECT order_id, first_name, last_name, email, phone_number, delivery_address, payment_method, subtotal, shipping, total 
              FROM orders 
              ORDER BY order_date DESC 
              LIMIT 1";
$result_order = mysqli_query($conn, $sql_order);

if ($result_order && mysqli_num_rows($result_order) > 0) {
    $order = mysqli_fetch_assoc($result_order);
    $order_id = $order['order_id'];
    $customer_name = $order['first_name'] . " " . $order['last_name'];
    $customer_phone = $order['phone_number'];
    $customer_address = $order['delivery_address'];
    $payment_option = $order['payment_method'];
    $total_amount = $order['subtotal']; // Subtotal (products only)
    $delivery_fee = $order['shipping']; // Shipping fee
    $grand_total = $order['total'];     // Total including shipping and tax
} else {
    die("No order found. Please place an order first.");
}

// Fetch order items for the latest order
$sql_items = "SELECT oi.quantity_kg, oi.unit_price_tk, oi.total_price_tk, pt.product_name 
              FROM order_items oi 
              JOIN product_types pt ON oi.product_type_id = pt.product_type_id 
              WHERE oi.order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();

$products = [];
if ($result_items && $result_items->num_rows > 0) {
    while ($row = $result_items->fetch_assoc()) {
        $products[] = [
            'name' => $row['product_name'],
            'quantity' => $row['quantity_kg'],
            'price' => $row['unit_price_tk']
        ];
    }
} else {
    $products = [];
}
$stmt_items->close();

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css_file/recipt_page.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <div class="logo">
                <img src="../IMG/LOGO DESIGN-01.png" alt="Company Logo">
            </div>
            <h1>Order Receipt</h1>
        </div>

        <!-- Customer Details -->
        <div class="customer-details">
            <h2>Customer Details</h2>
            <p><strong>Name:</strong> <span id="customer-name"><?php echo htmlspecialchars($customer_name); ?></span></p>
            <p><strong>Phone Number:</strong> <span id="customer-phone"><?php echo htmlspecialchars($customer_phone); ?></span></p>
            <p><strong>Address:</strong> <span id="customer-address"><?php echo htmlspecialchars($customer_address); ?></span></p>
        </div>

        <!-- Product Details -->
        <div class="product-details">
            <h2>Product Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <?php foreach ($products as $product) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['quantity']); ?> kg</td>
                            <td><?php echo number_format($product['price'], 2); ?> TK</td>
                        </tr>
                    <?php } ?>
                    <?php if (empty($products)) { ?>
                        <tr><td colspan="3">No items found.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Payment Summary -->
        <div class="payment-summary">
            <h2>Payment Summary</h2>
            <p><strong>Total Amount:</strong> <span id="total-amount"><?php echo number_format($total_amount, 2); ?> TK</span></p>
            <p><strong>Delivery Fee:</strong> <span id="delivery-fee"><?php echo number_format($delivery_fee, 2); ?> TK</span></p>
            <p><strong>Grand Total:</strong> <span id="grand-total"><?php echo number_format($grand_total, 2); ?> TK</span></p>
            <p><strong>Payment Option:</strong> <span id="payment-option"><?php echo htmlspecialchars($payment_option); ?></span></p>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <p>Thank you for shopping with us!</p>
            <p>© 2025 SmartFarm. All rights reserved.</p>
            <a href="../index.php" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
    </div>
</body>
</html>