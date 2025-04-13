<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Fetch employees
$query = "SELECT full_name, designation, email, phone_number, blood_group, joining_date, profile_image FROM employees";
$result = mysqli_query($conn, $query);

if (isset($_POST['go_to_login'])) {
  header("Location: admin_login_page.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css_file/official_website_employee.css" />
</head>
<body>
    <!-- Navbar starts here -->
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="#"><img src="../IMG/LOGO DESIGN-01.png" alt="logo" /></a>
            </div>
            <form class="d-flex search-form desktop-only" role="search">
                <input class="form-control search-input" type="search" placeholder="   Type Your Products" aria-label="Search" />
                <button class="btn search-button" type="submit">
                    <div class="search-text">
                        <p>Search</p>
                        <i class="fas fa-search"></i>
                    </div>
                </button>
            </form>
            <div class="icons-right">
                <div class="user-icon">
                    <i class="fa-regular fa-user"></i>
                </div>
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <div class="hamburger-menu">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form class="d-flex search-form mobile-only mb-3" role="search">
                            <input class="form-control search-input" type="search" placeholder="   Type Your Products" aria-label="Search" />
                            <button class="btn search-button" type="submit">
                                <div class="search-text">
                                    <p>Search</p>
                                    <i class="fas fa-search"></i>
                                </div>
                            </button>
                        </form>
                        <div class="offcanvas-buttons">
                            <button class="btn w-100 mb-2 alvi"><a href="../index.php">E-commerce</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="official_website.php">Official Website</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="farmer.php">Be a Farmer</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar ends here -->
    <!-- Hero Section starts here -->
    <div class="hero">
        <h2>Empowering Farmers</h2>
        <h2>Connecting Buyers</h2>
        <p>Bridging the gap between farmers and consumers—fresh, organic, and direct from the source. Support local farmers and enjoy the best nature has to offer.</p>
        <button class="button alvi"><a href="#top-sellers">Get Started</a></button>
    </div>
    <!-- Hero Section ends here -->
    <!-- Our products starts here -->
    <div class="top-sellers" id="top-sellers">
        <h3>OFFICE EMPLOYEES</h3>
    </div>
    <!-- Our products ends here -->
    <!-- Product card starts here -->
    <div class="product-card-div_down">
        <?php while ($employee = mysqli_fetch_assoc($result)) { ?>
            <div class="product-card_down">
                <div class="product-image_down">
                    <img src="../uploads/<?php echo htmlspecialchars($employee['profile_image']); ?>" alt="<?php echo htmlspecialchars($employee['full_name']); ?>" />
                </div>
                <div class="product-details_down">
                    <p class="category_down"><?php echo htmlspecialchars($employee['designation']); ?></p>
                    <h3 class="price_down"><?php echo htmlspecialchars($employee['full_name']); ?></h3>
                    <p class="product-title_down">
                        <?php echo htmlspecialchars($employee['email']); ?><br />
                        <?php echo htmlspecialchars($employee['phone_number']); ?><br />
                        Blood Group: <?php echo htmlspecialchars($employee['blood_group']); ?>
                    </p>
                    <div class="rating_down">
                        <span class="stars_down">Joined: <?php echo htmlspecialchars($employee['joining_date']); ?></span>
                    </div>
                </div>
                <div class="wishlist_down">
                    <i class="far fa-heart"></i>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- Product card ends here -->
     
    <!--add member starts here-->
    
    <div class="add-member-container">
    <form  method="POST">
      <button class="add-member-btn" name="go_to_login">Add Member</button>
      </form>
    </div>
   
    <!--add member  ends here-->
    <!-- Footer starts here -->
    <footer class="footer">
        <div class="container">
            <div class="footer-section logo-section">
                <h2 class="logo">SmartFarm</h2>
                <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <p><i class="fas fa-map-marker-alt"></i> 23/A Road, New York City</p>
                <p><i class="fas fa-phone-alt"></i> +9888-256-666</p>
                <div class="social-icons">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-x-twitter"></i>
                    <i class="fab fa-pinterest"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-tiktok"></i>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Smartphones</a></li>
                    <li><a href="#">Headphones</a></li>
                    <li><a href="#">Laptop & Tablet</a></li>
                    <li><a href="#">Monitors</a></li>
                    <li><a href="#">Printers</a></li>
                    <li><a href="#">Gadgets</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Accounts</h3>
                <ul>
                    <li><a href="#">My Orders</a></li>
                    <li><a href="#">Cart</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">Compare</a></li>
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Wishlist</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Privacy Policy</h3>
                <ul>
                    <li><a href="#">Returns & Exchanges</a></li>
                    <li><a href="#">Payment Terms</a></li>
                    <li><a href="#">Delivery Terms</a></li>
                    <li><a href="#">Payment & Pricing</a></li>
                    <li><a href="#">Terms Of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <!-- Footer ends here -->
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <script src="https://kit.fontawesome.com/85fcd39f72.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../js_file/official_website_employee.js"></script>
</body>
</html>

