<?php
$conn = mysqli_connect("localhost", "root", "F@him7080!", "smartfarm") or die("Connection failed");

$sql = "SELECT f.full_name, f.phone_number, f.registration_date, f.face_image, 
        GROUP_CONCAT(ft.farm_type_name SEPARATOR ', ') AS farm_types
        FROM farmers f
        LEFT JOIN farmer_farm_types fft ON f.farmer_id = fft.farmer_id
        LEFT JOIN farm_types ft ON fft.farm_type_id = ft.farm_type_id
        GROUP BY f.farmer_id";
$result = $conn->query($sql);

if (isset($_POST['add_farmer'])) {
    header("Location: add_farmer_form.php");
    exit();
}
if (isset($_POST['add_products'])) {
  header("Location: add_product_form.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="../css_file/farmer.css?v=<?php echo time(); ?>" />
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="#"><img src="../IMG/LOGO DESIGN-01.png" alt="logo" /></a>
            </div>
            <div class="desktop-only dropdown">
                <button class="btn all_catagories" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bars-staggered"></i> Add New <i class="fa-solid fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu">
                
                    <li>
                        <form method="POST">
                          <button class="dropdown-item" type="submit" name="add_products">Add Products</button>
                        </form>
                   </li>
                    <li>
                        <form method="POST">
                            <button class="dropdown-item add_farmer" type="submit" name="add_farmer">Add Farmer</button>
                        </form>
                    </li>
                </ul>
            </div>
            <form class="d-flex search-form desktop-only" role="search">
                <input class="form-control search-input" type="search" placeholder="   Type Your Products" aria-label="Search" />
                <button class="btn search-button" type="submit">
                    <div class="search-text"><p>Search</p><i class="fas fa-search"></i></div>
                </button>
            </form>
            <div class="icons-right">
                <div class="user-icon"><i class="fa-regular fa-user"></i></div>
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <div class="hamburger-menu"><i class="fa-solid fa-bars"></i></div>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="mobile-only dropdown mb-3">
                            <button class="btn all_catagories w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars-staggered"></i> Add New <i class="fa-solid fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Add Products</button></li>
                                <li><button class="dropdown-item add_farmer" type="button">Add Farmer</button></li>
                            </ul>
                        </div>
                        <form class="d-flex search-form mobile-only mb-3" role="search">
                            <input class="form-control search-input" type="search" placeholder="   Type Your Products" aria-label="Search" />
                            <button class="btn search-button" type="submit">
                                <div class="search-text"><p>Search</p><i class="fas fa-search"></i></div>
                            </button>
                        </form>
                        <div class="offcanvas-buttons">
                            <button class="btn w-100 mb-2 alvi"><a href="../index.html">E-commerce</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="html_files/official_website.html">Official Website</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="farmer.html">Be a Farmer</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <h2>Empowering Farmers</h2>
        <h2>Connecting Buyers</h2>
        <p>Bridging the gap between farmers and consumers—fresh, organic, and direct from the source. Support local farmers and enjoy the best nature has to offer.</p>
        <button class="button alvi"><a href="#top-sellers">Get Started</a></button>
    </div>

    <!-- Top Sellers -->
    <div class="top-sellers" id="top-sellers">
        <h3>Our Farmers</h3>
    </div>

    <!-- Product Cards -->
    <div class="product-card-div_down">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $image_path = $row['face_image'] ? "../uploads/" . $row['face_image'] : "IMG/top-seller-1.png";
        ?>
                <div class="product-card_down">
                    <div class="product-image_down">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo $row['full_name']; ?>">
                    </div>
                    <div class="product-details_down">
                        <p class="category_down"><?php echo $row['farm_types'] ?: 'No farm types'; ?></p>
                        <h3 class="price_down"><?php echo $row['full_name']; ?></h3>
                        <p class="product-title_down">
                            <?php echo $row['phone_number']; ?> <br>
                            <?php echo $row['registration_date']; ?>
                        </p>
                    </div>
                    <div class="wishlist_down">
                        <i class="far fa-heart"></i>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>No farmers found.</p>";
        }
        $conn->close();
        ?>
    </div>

    <!-- Footer -->
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>