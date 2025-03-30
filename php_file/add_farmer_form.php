<?php
// Database connection (change the credentials as needed)
$host = "localhost";
$dbname = "smartfarm";
$username = "root";
$password = "";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $nationality = $conn->real_escape_string($_POST['nationality']);
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;
    $registration_date = $conn->real_escape_string($_POST['registration_date']);
    
    // Handle the image upload
    if (isset($_FILES['face_image'])) {
        $file_name = $_FILES['face_image']['name'];
        $file_tmp = $_FILES['face_image']['tmp_name'];
        $file_size = $_FILES['face_image']['size'];
        $file_error = $_FILES['face_image']['error'];

        // Check if there were any errors during the file upload
        if ($file_error === 0) {
            // Check file size (limit to 2MB)
            if ($file_size <= 2 * 1024 * 1024) {
                // Extract file extension
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

                // Check if the file is of a valid image type
                if (in_array($file_ext, $allowed_exts)) {
                    // Create a unique name for the file to avoid conflicts
                    $new_file_name = "farmer_" . time() . "." . $file_ext;
                    $file_destination = "../uploads/" . $new_file_name;

                    // Move the uploaded file to the 'uploads' folder
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        // Success: File uploaded
                        echo "File uploaded successfully!";
                    } else {
                        // Error: Unable to move file
                        echo "There was an error uploading the file.";
                    }
                } else {
                    echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            } else {
                echo "File is too large. Maximum size is 2MB.";
            }
        } else {
            echo "There was an error with the file upload.";
        }
    }

    // Insert into the farmers table
    $insert_farmer_sql = "INSERT INTO farmers (full_name, phone_number, address, nationality, email, registration_date, face_image) 
                          VALUES ('$full_name', '$phone_number', '$address', '$nationality', '$email', '$registration_date', '$file_destination')";

    if ($conn->query($insert_farmer_sql) === TRUE) {
        $farmer_id = $conn->insert_id;  // Get the inserted farmer's ID

        // Insert the selected farm types into farmer_farm_types table
        if (isset($_POST['farm_type'])) {
            $farm_types = $_POST['farm_type'];
            foreach ($farm_types as $farm_type) {
                // Map the farm type value to the corresponding farm_type_id
                $farm_type_id_query = "SELECT farm_type_id FROM farm_types WHERE farm_type_name = '$farm_type'";
                $result = $conn->query($farm_type_id_query);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $farm_type_id = $row['farm_type_id'];

                    // Insert into farmer_farm_types
                    $insert_farm_type_sql = "INSERT INTO farmer_farm_types (farmer_id, farm_type_id) 
                                             VALUES ('$farmer_id', '$farm_type_id')";
                    $conn->query($insert_farm_type_sql);
                }
            }
        }

        // Success message
        echo "Farmer details added successfully!";
    } else {
        echo "Error: " . $insert_farmer_sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
