<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_type_id = $_POST['product_type_id'];
    $weight_kg = $_POST['weight_kg'];
    $price_tk = $_POST['price_tk'];
    $farmer_id = $_POST['farmer_id'];
    $farm_type_id = $_POST['farm_type_id'];
    $description = $_POST['description'];
    $entry_date = $_POST['entry_date'];

    $sql = "INSERT INTO products (weight_kg, price_tk, product_type_id, farmer_id, farm_type_id, description, entry_date)
            VALUES ('$weight_kg', '$price_tk', '$product_type_id', '$farmer_id', '$farm_type_id', '$description', '$entry_date')";
    if ($conn->query($sql)) {
        header("Location: farmer.php"); // Redirect to farmer.php in root
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="../css_file/add_product_form.css" />
</head>
<body>
    <div class="product-form-container">
        <div class="product-form-card">
            <div class="logo">
                <img src="../IMG/LOGO DESIGN-01.png" alt="Company Logo" />
            </div>
            <h2>Add Product Form</h2>
            <form class="product-form" method="POST">
                <div class="form-group">
                    <label>Product</label>
                    <select class="form-control" name="product_type_id" required>
                        <option value="" disabled selected>Select a product</option>
                        <?php
                        $products = $conn->query("SELECT product_type_id, product_name FROM product_types");
                        while ($row = $products->fetch_assoc()) {
                            echo "<option value='{$row['product_type_id']}'>{$row['product_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Weight (kg)</label>
                    <input type="number" class="form-control" name="weight_kg" placeholder="Enter product weight" step="1" min="0" required />
                </div>
                <div class="form-group">
                    <label>Price (TK)</label>
                    <input type="number" class="form-control" name="price_tk" placeholder="Enter product price" step="1" min="0" required />
                </div>
                <div class="form-group">
                    <label>Farmer</label>
                    <select class="form-control" name="farmer_id" required>
                        <option value="" disabled selected>Select a farmer</option>
                        <?php
                        $farmers = $conn->query("SELECT farmer_id, full_name FROM farmers");
                        while ($row = $farmers->fetch_assoc()) {
                            echo "<option value='{$row['farmer_id']}'>{$row['full_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Farm Type</label>
                    <select class="form-control" name="farm_type_id" required>
                        <option value="" disabled selected>Select a farm type</option>
                        <?php
                        $farm_types = $conn->query("SELECT farm_type_id, farm_type_name FROM farm_types");
                        while ($row = $farm_types->fetch_assoc()) {
                            echo "<option value='{$row['farm_type_id']}'>{$row['farm_type_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" placeholder="Enter product description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Product Entry Date</label>
                    <input type="date" class="form-control" name="entry_date" required />
                </div>
                <button type="submit" class="btn-submit">Add Product</button>
            </form>
        </div>
    </div>
</body>
</html>