<?php
    $server = "localhost";
    $username = "root";
    $password = "alvi1234hello";
    $database = "SmartFarm";

    // Create connection
    $conn = mysqli_connect($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $full_name = $_POST["full_name"];
        $phone_number = $_POST["phone_number"];
        $address = $_POST["address"];
        $nationality = $_POST["nationality"];
        $email = $_POST["email"];
        $registration_date = $_POST["registration_date"];

        // Handle file upload
        if ($_FILES["face_image"]["error"] == UPLOAD_ERR_OK) {
            $face_image = $_FILES["face_image"]["name"];
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($face_image);
        
            if (move_uploaded_file($_FILES["face_image"]["tmp_name"], $target_file)) {
            } else {
            }
        } else {
            echo "File upload error: " . $_FILES["face_image"]["error"];
        }
        
        // Insert farmer details
        $sql = "INSERT INTO farmers (full_name, phone_number, address, nationality, email, registration_date, face_image)
                VALUES ('$full_name', '$phone_number', '$address', '$nationality', '$email', '$registration_date', '$face_image')";
        
        if ($conn->query($sql) === TRUE) {
            $farmer_id = $conn->insert_id;

            // Insert farm types
            if (!empty($_POST["farm_type"])) {
                foreach ($_POST["farm_type"] as $farm_type_id) {
                    $conn->query("INSERT INTO farmer_farm_types (farmer_id, farm_type_id) VALUES ('$farmer_id', '$farm_type_id')");
                }
            }
            
            // Redirect to farmer.html after successful submission
            header("Location: farmer.php");
            exit(); // Make sure to exit after redirect
            
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Farmer</title>
    <title>Admin Login</title>
    <!-- Bootstrap & FontAwesome -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css_file/add_farmar_form.css" />
</head>
<body>
<div class="farmer-form-container">
      <div class="farmer-form-card">
        <!-- Logo -->
        <div class="logo">
          <img src="../IMG/LOGO DESIGN-01.png" alt="Company Logo" />
        </div>

        <!-- Form Title -->
        <h2>Farmer Details</h2>


    <div class=" farmer-form container mt-5">
        <h2 class="mb-3">Add Farmer</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="farmer-form">
            <div class="mb-3 form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Nationality</label>
                <input type="text" name="nationality" class="form-control" required>
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Email (Optional)</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Upload Face Image</label>
                <input type="file" name="face_image" class="form-control" required>
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Farm Type</label><br>
                <?php
                // Fetch farm types from database
                $conn = new mysqli("localhost", "root", "alvi1234hello", "smartfarm");
                $result = $conn->query("SELECT * FROM farm_types");
                while ($row = $result->fetch_assoc()) {
                    echo '<input type="checkbox" name="farm_type[]" value="' . $row["farm_type_id"] . '"> ' . $row["farm_type_name"] . '<br>';
                }
                $conn->close();
                ?>
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Date of Registration</label>
                <input type="date" name="registration_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit </button>
        </form>
    </div>
    <script src="../js file/add_farmer.js"></script>
</body>
</html>
