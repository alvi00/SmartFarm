<?php
session_start();
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT employee_id, password FROM employees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $employee = $result->fetch_assoc();
        if ($password == $employee['password']) {
            $_SESSION['employee_id'] = $employee['employee_id'];

            if (isset($_SESSION['intended_action'])) {
                $action = $_SESSION['intended_action'];
                unset($_SESSION['intended_action']);
                if ($action == 'add_farmer') {
                    header("Location: add_farmer_form.php");
                    exit();
                } elseif ($action == 'add_products') {
                    header("Location: add_product_form.php");
                    exit();
                }
            }
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Wrong email or password.";
        }
    } else {
        $error = "Wrong email or password.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartFarm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css_file/user_login_page.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <img src="../IMG/LOGO DESIGN-01.png" alt="Website Logo">
            </div>
            <form class="login-form" method="POST">
                <h2>Welcome Back!</h2>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                <div class="remember-forgot">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn-login" name="login">Login</button>
                <div class="signup-link">
                    Don't have an account? <a href="user_signup_page.php">Sign Up</a>
                </div>
            </form>
            <div class="social-login">
                <p>Or continue with</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>