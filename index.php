<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

if (isset($_POST['go_to_farmer'])) {
    header("Location: html_files/farmer.php");
    exit();
}

// Get search term and category
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'All';

// Query for Featured Products
$sql_featured = "SELECT pt.product_name, pt.product_image, p.product_type_id, ft.farm_type_name,
                SUM(p.weight_kg) AS total_weight, AVG(p.price_tk) AS avg_price
                FROM products p
                JOIN product_types pt ON p.product_type_id = pt.product_type_id
                JOIN farm_types ft ON p.farm_type_id = ft.farm_type_id";

// Add WHERE clause for search and category
$where = [];
if ($search != '') {
    $where[] = "pt.product_name LIKE '%$search%'";
}
if ($category != 'All') {
    $where[] = "ft.farm_type_name = '$category'";
}
if (!empty($where)) {
    $sql_featured .= " WHERE " . implode(" AND ", $where);
}

$sql_featured .= " GROUP BY p.product_type_id, pt.product_name, pt.product_image, ft.farm_type_name";
$result_featured = $conn->query($sql_featured);

// Query for Our Products (same as Featured Products)
$sql_products = $sql_featured;
$result_products = $conn->query($sql_products);

// Query for cart count
$sql_cart = "SELECT COUNT(*) AS cart_count FROM cart";
$result_cart = $conn->query($sql_cart);
$cart_count = $result_cart->fetch_assoc()['cart_count'];

// Query for Top Sellers
$sql_sellers = "SELECT f.farmer_id, f.full_name, f.face_image, 
                SUM(p.weight_kg) AS total_weight
                FROM farmers f
                LEFT JOIN products p ON f.farmer_id = p.farmer_id
                GROUP BY f.farmer_id, f.full_name, f.face_image
                ORDER BY total_weight DESC
                LIMIT 4";
$result_sellers = $conn->query($sql_sellers);
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
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <!-- Navbar starts here -->
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="#"><img src="IMG/LOGO DESIGN-01.png" alt="logo" /></a>
            </div>

            <form class="d-flex search-form desktop-only" method="GET" onsubmit="scrollToTrending()">
                <input class="form-control search-input" type="search" name="search" placeholder="Type Your Products" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                <button class="btn search-button" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="icons-right">
                <div class="user-icon"><i class="fa-regular fa-user"></i></div>
                <div class="heart-icon"><i class="fa-regular fa-heart"></i></div>
                <div class="shopping-cart-icon">
                    <a href="html_files/add_to_cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php if ($cart_count > 0) { ?>
                            <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php } ?>
                    </a>
                </div>
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
                                <i class="fa-solid fa-bars-staggered"></i> All Categories <i class="fa-solid fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Action</button></li>
                                <li><button class="dropdown-item" type="button">Another action</button></li>
                                <li><button class="dropdown-item" type="button">Something else here</button></li>
                            </ul>
                        </div>
                        <form class="d-flex search-form mobile-only mb-3" method="GET" onsubmit="scrollToTrending()">
                             <input class="form-control search-input" type="search" name="search" placeholder="Type Your Products" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                            <button class="btn search-button" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        <div class="offcanvas-buttons">
                            <button class="btn w-100 mb-2 alvi"><a href="index.php">E-commerce</a></button>
                            <button class="btn w-100 mb-2 alvi"><a href="html_files/official_website.php">Official Website</a></button>
                            <form method="POST">
                                <button class="btn w-100 mb-2 alvi" name="go_to_farmer" type="submit">Be a Farmer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar ends here -->

    <!-- Vertical starts here -->
    <div class="vertical-products">
        <div class="items_all">
            <div class="image_of_the_item"><img src="IMG/vegetable.png" alt="item" /></div>
            <div class="item_description"><h6>Vegetables</h6><p>6 Products</p></div>
        </div>
        <div class="items_all">
            <div class="image_of_the_item"><img src="IMG/fruits.png" alt="item" /></div>
            <div class="item_description"><h6>Fresh Fruits</h6><p>8 Products</p></div>
        </div>
        <div class="items_all">
            <div class="image_of_the_item"><img src="IMG/Milk.png" alt="item" /></div>
            <div class="item_description"><h6>Dairy Items</h6><p>5 Products</p></div>
        </div>
        <div class="items_all">
            <div class="image_of_the_item"><img src="IMG/fish.png" alt="item" /></div>
            <div class="item_description"><h6>Fish Items</h6><p>6 Products</p></div>
        </div>
        <div class="items_all">
            <div class="image_of_the_item"><img src="IMG/meat.png" alt="item" /></div>
            <div class="item_description"><h6>Meat Items</h6><p>6 Products</p></div>
        </div>
        <div class="items_all">
            <div class="image_of_the_item"><img src="IMG/vegetable.png" alt="item" /></div>
            <div class="item_description"><h6>Carb Items</h6><p>6 items</p></div>
        </div>
    </div>
    <!-- Closing vertical-products -->

    <!-- Promotional Contents starts here -->
    <div class="Promotional_Contents">
        <div class="promo-banner_one">
            <div class="promo-content">
                <span class="promo-badge">100% Farm Fresh Food</span>
                <h1>Fresh Organic</h1>
                <p>Food For All</p>
                <button class="shop-btn">Shop Now</button>
            </div>
        </div>
        <div class="promo-banner_two" style="position: relative; right: 0; width: 50%; height: 50%; margin-top: 30px; margin-right: 30px; border-radius: 20px; overflow: hidden;">
    <img src="uploads/carb.jpg" alt="Premium Honeynuts" style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px; position: absolute; top: 0; left: 0; z-index: 0;">
    <div class="promo-content_banner_two" style="width: auto; height: auto; padding-left: 50px; padding-right: 50px; padding-top: 40px; position: relative; z-index: 1;">
        <h1 style="font-size: 30px; font-weight: bold; padding-top: 15px; color: white;">Premium Carbs</h1>
        <p style="font-size: 15px; font-weight: 500; color:rgb(236, 255, 253);">100% Premium Carbs</p>
    </div>
</div>

        <div class="right-bottom-photos">
    <div class="promo-banner_three" style="width: 50%; height: 100%; border-radius: 20px; margin-top: 30px; margin-right: 30px; margin-left: 15px; overflow: hidden; position: relative;">
        <img src="uploads/fresh fruit.jpg" alt="Baby diaper" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
        <div class="promo-content_banner_three">
            <h1>Fresh Fruits</h1>
            <p>Top quality product</p>
            
        </div>
    </div>
    <div class="promo-banner_four" style="width: 50%; height: 100%; border-radius: 20px; margin-top: 30px; margin-right: 30px; overflow: hidden; position: relative;">
        <img src="uploads/veg2.jpg" alt="Facewash" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
        <div class="promo-content_banner_four">
            <h1>Fresh Vegetables</h1>
            <p>All Fixed price</p>
            
        </div>
    </div>
    </div>

    </div>
    <!-- Promotional Contents ends here -->

    <!-- Featured products text starts line -->
    <div class="featured-products-text" id="trending-products">
    <h3>Trending Products</h3>
    <div class="right-side-text">
        <a href="index.php?category=All"><p <?php echo (!isset($_GET['category']) || $_GET['category'] == 'All') ? 'style="font-weight: bold;"' : ''; ?>>All</p></a>
        <a href="index.php?category=Dairy Items"><p <?php echo (isset($_GET['category']) && $_GET['category'] == 'Dairy Items') ? 'style="font-weight: bold;"' : ''; ?>>Dairy Items</p></a>
        <a href="index.php?category=Vegetables"><p <?php echo (isset($_GET['category']) && $_GET['category'] == 'Vegetables') ? 'style="font-weight: bold;"' : ''; ?>>Vegetables</p></a>
        <a href="index.php?category=Fresh Fruits"><p <?php echo (isset($_GET['category']) && $_GET['category'] == 'Fresh Fruits') ? 'style="font-weight: bold;"' : ''; ?>>Fresh Fruits</p></a>
        <a href="index.php?category=Meat Items"><p <?php echo (isset($_GET['category']) && $_GET['category'] == 'Meat Items') ? 'style="font-weight: bold;"' : ''; ?>>Meat Items</p></a>
        <a href="index.php?category=Fish Items"><p <?php echo (isset($_GET['category']) && $_GET['category'] == 'Fish Items') ? 'style="font-weight: bold;"' : ''; ?>>Fish Items</p></a>
        <a href="index.php?category=Carb Items"><p <?php echo (isset($_GET['category']) && $_GET['category'] == 'Carb Items') ? 'style="font-weight: bold;"' : ''; ?>>Carb Items</p></a>
    </div>
</div>
    <!-- Featured products text line ends here -->

    <!-- Featured products starts here -->

    <div class="featured-products">
        <?php
        if ($result_featured->num_rows > 0) {
            while ($row = $result_featured->fetch_assoc()) {
                $image_path = "Uploads/" . $row['product_image'];
                $avg_price = number_format($row['avg_price'], 2);
                $total_weight = $row['total_weight'];
        ?>
            <div class="product-card">
                <div class="product-header">
                    <span class="category"><?php echo $row['farm_type_name']; ?></span>
                    <i class="fa-regular fa-heart wishlist"></i>
                </div>
                <div class="product-image">
                    <img src="<?php echo $image_path; ?>" alt="<?php echo $row['product_name']; ?>" />
                </div>
                <div class="weight-options">
                    <button><?php echo $total_weight; ?> kg</button>
                </div>
                <div class="product-price">
                    <span class="price"><?php echo $avg_price; ?> TK/kg</span>
                </div>
                <p class="product-title">
                    <?php echo $row['product_name']; ?>
                </p>
  
                <a href="html_files/featured_product.php?product_type_id=<?php echo $row['product_type_id']; ?>" class="select-options">
                    <i class="fa-solid fa-cart-shopping"></i> Select Options
                </a>
            </div>
        <?php
            }
        } else {
            // Check if search or category filter is active
            if (isset($_GET['search']) && $_GET['search'] != '' || (isset($_GET['category']) && $_GET['category'] != 'All')) {
        ?>
            <div style="text-align: center; width: 100%; padding: 20px;">
                <p>Sorry, no search result found.</p>
            </div>
        <?php
            } else {
        ?>
            <div class="product-card">
                <div class="product-header">
                    <span class="category">Vegetables</span>
                    <i class="fa-regular fa-heart wishlist"></i>
                </div>
                <div class="product-image">
                    <img src="IMG/featured_product-1.png" alt="No Products" />
                </div>
                <div class="weight-options">
                    <button>0 kg</button>
                </div>
                <div class="product-price">
                    <span class="price">N/A</span>
                </div>
                <p class="product-title">No Products Available</p>

                <button class="select-options">
                    <i class="fa-solid fa-cart-shopping"></i> Select Options
                </button>
            </div>
        <?php
            }
        }
        ?>
    </div>

    <!-- Featured products ends here -->

    <!-- Top sellers starts here -->
    <div class="top-sellers">
        <h3>Top Sellers</h3>
    </div>
    <div class="cards-of-sellers">
        <?php
        if ($result_sellers->num_rows > 0) {
            while ($row = $result_sellers->fetch_assoc()) {
                $image_path = "uploads/" . $row['face_image'];
                $total_weight = $row['total_weight'] ?: 0;
        ?>
            <div class="card mb-3 shadow-sm" style="max-width: 400px; border-radius: 10px; overflow: hidden">
                <div class="row g-0 align-items-center">
                    <div class="col-4">
                        <img src="<?php echo $image_path; ?>" class="img-fluid rounded-start" alt="Profile Image" />
                    </div>
                    <div class="col-7">
                        <div class="card-body py-2 px-2">
                            <h5 class="card-title mb-1">Featured</h5>
                            <p class="card-text mb-1 text-muted"><?php echo $row['full_name']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
        ?>
            <div class="card mb-3 shadow-sm" style="max-width: 400px; border-radius: 10px; overflow: hidden">
                <div class="row g-0 align-items-center">
                    <div class="col-4">
                        <img src="IMG/top-seller-1.png" class="img-fluid rounded-start" alt="Profile Image" />
                    </div>
                    <div class="col-7">
                        <div class="card-body py-2 px-2">
                            <h5 class="card-title mb-1">Featured</h5>
                            <p class="card-text mb-1 text-muted">No Top Sellers Yet</p>

                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <!-- Top sellers ends here -->

    <!-- Divider image starts here -->
    <div class="divider-image"></div>
    <!-- Divider image ends here -->

    <!-- Our products starts here -->
    <!-- Our products starts here -->
    <div class="top-sellers">
        <h3>Our Products</h3>
    </div>
    <div class="product-card-div_down">
        <?php
        if ($result_products->num_rows > 0) {
            while ($row = $result_products->fetch_assoc()) {
                $image_path = "Uploads/" . $row['product_image'];
                $avg_price = number_format($row['avg_price'], 2);
                $total_weight = $row['total_weight'];
        ?>
            <div class="product-card_down">
                <div class="product-image_down">
                    <img src="<?php echo $image_path; ?>" alt="<?php echo $row['product_name']; ?>" />
                </div>
                <div class="product-details_down">
                    <p class="category_down"><?php echo $row['farm_type_name']; ?></p>
                    <h3 class="price_down"><?php echo $avg_price; ?> TK/kg</h3>
                    <p class="product-title_down">
                        <?php echo $row['product_name']; ?> <br />
                        <?php echo $total_weight; ?> kg available
                    </p>

                    <a href="html_files/featured_product.php?product_type_id=<?php echo $row['product_type_id']; ?>" class="select-options">
                        <i class="fa-solid fa-cart-shopping"></i> Select Options
                    </a>
                </div>
                <div class="wishlist_down"><i class="far fa-heart"></i></div>
            </div>
        <?php
            }
        } else {
            // Check if search or category filter is active
            if (isset($_GET['search']) && $_GET['search'] != '' || (isset($_GET['category']) && $_GET['category'] != 'All')) {
        ?>
            <div style="text-align: center; width: 100%; padding: 20px;">
                <p>Sorry, no search result found.</p>
            </div>
        <?php
            } else {
        ?>
            <div class="product-card_down">
                <div class="product-image_down">
                    <img src="IMG/featured_product-1.png" alt="No Products" />
                </div>
                <div class="product-details_down">
                    <p class="category_down">N/A</p>
                    <h3 class="price_down">N/A</h3>
                    <p class="product-title_down">No Products Available</p>

                </div>
                <div class="wishlist_down"><i class="far fa-heart"></i></div>
            </div>
        <?php
            }
        }
        ?>
    </div>
<!-- Product card ends here -->
    <!-- Product card ends here -->

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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script>
    function scrollToTrending() {
        const trendingSection = document.getElementById('trending-products');
        if (trendingSection) {
            trendingSection.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Scroll to trending products on page load if search query exists
    window.onload = function() {
        if (window.location.search.includes('search=')) {
            scrollToTrending();
        }
    };
</script>
</body>
</html>

<?php
$conn->close();
?>