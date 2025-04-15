<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Hardcoded admin credentials
$admin_email = "alvifahim@gmail.com";
$admin_password = "alvifahim1234";

$farmer_id = isset($_GET['farmer_id']) ? (int)$_GET['farmer_id'] : 0;
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == $admin_email && $password == $admin_password && $farmer_id > 0) {
        // Delete farmer
        $conn->query("DELETE FROM farmer_farm_types WHERE farmer_id = $farmer_id");
        $conn->query("DELETE FROM products WHERE farmer_id = $farmer_id");
        $conn->query("DELETE FROM farmers WHERE farmer_id = $farmer_id");
        header("Location: farmer.php");
        exit();
    } else {
        $error = "Wrong email, password, or farmer ID.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css_file/admin_login_page.css">
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="logo">
                <img src="../IMG/LOGO DESIGN-01.png" alt="Logo">
            </div>
            <form method="POST">
                <h2>Admin Login</h2>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</body>
</html>