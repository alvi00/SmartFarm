<?php
session_start();
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm");

$error = ""; // Prevent undefined variable issue

$employee_id = isset($_SESSION['employee_id_to_update']) ? (int)$_SESSION['employee_id_to_update'] : 0;
if ($employee_id == 0) {
    header("Location: official_website_employee.php");
    exit();
}

$query = "SELECT * FROM employees WHERE employee_id = $employee_id";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);
if (!$employee) {
    header("Location: official_website_employee.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $designation = $_POST['designation'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $blood_group = $_POST['blood_group'];
    $nationality = $_POST['nationality'];
    $permanent_address = $_POST['permanent_address'];
    $present_address = $_POST['present_address'];
    $joining_date = $_POST['joining_date'];
    $marital_status = $_POST['marital_status'];
    $password = $_POST['password'];

    $profile_image = $employee['profile_image'];
    if (!empty($_FILES['profile_image']['name'])) {
        $profile_image = time() . "_" . basename($_FILES['profile_image']['name']); // unique file name
        $target = "../Uploads/" . $profile_image;
        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
            $error = "Image upload failed.";
        }
    }

    if (!$error) {
        $update_query = "UPDATE employees SET 
            full_name='$full_name',
            designation='$designation',
            email='$email',
            phone_number='$phone_number',
            blood_group='$blood_group',
            nationality='$nationality',
            permanent_address='$permanent_address',
            present_address='$present_address',
            joining_date='$joining_date',
            marital_status='$marital_status',
            profile_image='$profile_image',
            password='$password'
            WHERE employee_id=$employee_id";

        if (mysqli_query($conn, $update_query)) {
            unset($_SESSION['employee_id_to_update']);
            header("Location: official_website_employee.php?message=Employee+updated");
            exit();
        } else {
            $error = "Database update failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 720px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        h2 {
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Update Employee</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Designation</label>
                <input type="text" class="form-control" name="designation" value="<?php echo htmlspecialchars($employee['designation']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" value="<?php echo htmlspecialchars($employee['phone_number']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Blood Group</label>
                <input type="text" class="form-control" name="blood_group" value="<?php echo htmlspecialchars($employee['blood_group']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nationality</label>
                <input type="text" class="form-control" name="nationality" value="<?php echo htmlspecialchars($employee['nationality']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Permanent Address</label>
                <textarea class="form-control" name="permanent_address" required><?php echo htmlspecialchars($employee['permanent_address']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Present Address</label>
                <textarea class="form-control" name="present_address" required><?php echo htmlspecialchars($employee['present_address']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Joining Date</label>
                <input type="date" class="form-control" name="joining_date" value="<?php echo htmlspecialchars($employee['joining_date']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Marital Status</label>
                <select class="form-control" name="marital_status" required>
                    <option value="Single" <?php echo $employee['marital_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                    <option value="Married" <?php echo $employee['marital_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <input type="file" class="form-control" name="profile_image">
                <small>Current: <?php echo htmlspecialchars($employee['profile_image']); ?></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($employee['password']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="official_website_employee.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
