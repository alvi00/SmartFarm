<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
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

    // Handle image upload
    $profile_image = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $image_name = 'employee_' . time() . '.' . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_path = '../uploads/' . $image_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
        $profile_image = $image_name;
    }

    // Insert into database
    $query = "INSERT INTO employees (full_name, designation, email, phone_number, blood_group, nationality, permanent_address, present_address, joining_date, marital_status, profile_image)
              VALUES ('$full_name', '$designation', '$email', '$phone_number', '$blood_group', '$nationality', '$permanent_address', '$present_address', '$joining_date', '$marital_status', '$profile_image')";
    mysqli_query($conn, $query);

    // Redirect to official_website_employee.php
    header('Location: official_website_employee.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css_file/employee_form.css">
</head>
<body>
    <div class="employee-form-container">
        <div class="employee-form-card">
            <div class="logo">
                <img src="../IMG/LOGO DESIGN-01.png" alt="Company Logo">
            </div>
            <h2>Employee Registration Form</h2>
            <form class="employee-form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
                </div>
                <div class="form-group">
                    <label>Designation</label>
                    <select name="designation" class="form-control" required>
                        <option value="">Select Designation</option>
                        <option value="HR">HR</option>
                        <option value="Clerk">Clerk</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Manager">Manager</option>
                        <option value="Accountant">Accountant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone_number" class="form-control" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label>Blood Group</label>
                    <select name="blood_group" class="form-control" required>
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nationality</label>
                    <input type="text" name="nationality" class="form-control" placeholder="Enter nationality" required>
                </div>
                <div class="form-group">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>Permanent Address</label>
                    <textarea name="permanent_address" class="form-control" placeholder="Enter permanent address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Present Address</label>
                    <textarea name="present_address" class="form-control" placeholder="Enter present address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Joining Date</label>
                    <input type="date" name="joining_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Marital Status</label>
                    <div class="marital-status">
                        <label><input type="radio" name="marital_status" value="married" required> Married</label>
                        <label><input type="radio" name="marital_status" value="unmarried" required> Unmarried</label>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>