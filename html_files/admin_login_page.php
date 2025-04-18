<?php
session_start();
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Hardcoded admin credentials
$admin_email = "alvifahim@gmail.com";
$admin_password = "alvifahim1234";

// Initialize error message
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submitted_email = trim($_POST['email']);
    $submitted_password = trim($_POST['password']);
    $employee_id = (int)$_POST['employee_id'];
    $action = $_POST['action'];

    // Validate credentials
    if ($submitted_email === $admin_email && $submitted_password === $admin_password) {
        if ($action == 'delete' && $employee_id > 0) {
            $stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            $stmt->close();
            header("Location: official_website_employee.php?message=Employee+deleted");
            exit();
        } elseif ($action == 'update' && $employee_id > 0) {
            $_SESSION['employee_id_to_update'] = $employee_id;
            header("Location: update_employee_form.php");
            exit();
        } else {
            header("Location: employee_form.php");
            exit();
        }
    } else {
        $error_message = "Invalid email or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css_file/admin_login_page.css?v=<?php echo time(); ?>" />
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-card">
            <!-- Logo -->
            <div class="logo">
                <img src="../IMG/LOGO DESIGN-01.png" alt="Website Logo" />
            </div>

            <!-- Admin Login Form -->
            <form class="admin-login-form" method="POST">
                <h2>Admin Login</h2>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>
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
                <input type="hidden" name="employee_id" value="<?php echo isset($_GET['employee_id']) ? (int)$_GET['employee_id'] : 0; ?>">
                <input type="hidden" name="action" value="<?php echo isset($_GET['action']) ? htmlspecialchars($_GET['action']) : ''; ?>">
                <button type="submit" class="btn-admin-login" name="go_to_employee_form">Login</button>
            </form>
        </div>
    </div>
</body>
</html>