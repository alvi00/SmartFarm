<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Initialize error message
$error_message = "";

// Handle signup form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $address = trim($_POST['address']);

    // Validate inputs
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password) || empty($address)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error_message = "Email already registered.";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, address) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $address);
            if ($stmt->execute()) {
                header("Location: user_login_page.php");
                exit();
            } else {
                $error_message = "Error creating account. Please try again.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - SmartFarm</title>
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css_file/user_signup_page.css?v=<?php echo time(); ?>" />
</head>
<body>
    <div class="signup-container">
        <div class="signup-card">
            <!-- Logo -->
            <div class="logo">
                <img src="../IMG/LOGO DESIGN-01.png" alt="Website Logo" />
            </div>

            <!-- Sign Up Form -->
            <form class="signup-form" method="POST">
                <h2>Create Your Account</h2>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Full Name</label>
                    <input
                        type="text"
                        class="form-control"
                        name="full_name"
                        placeholder="Enter your full name"
                        value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>"
                        required
                    />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        placeholder="Enter your email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        required
                    />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Enter your password"
                        required
                    />
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="confirm_password"
                        placeholder="Confirm your password"
                        required
                    />
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea
                        class="form-control"
                        name="address"
                        placeholder="Enter your address"
                        rows="3"
                        required
                    ><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                </div>
                <div class="terms">
                    <input type="checkbox" id="terms" name="terms" required />
                    <label for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
                </div>
                <button type="submit" class="btn-signup" name="signup">Sign Up</button>
                <div class="login-link">
                    Already have an account? <a href="user_login_page.php">Log In</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>