<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

// Get product_type_id from URL
$product_type_id = isset($_GET['product_type_id']) ? (int)$_GET['product_type_id'] : 0;

// Query aggregated data for this product type
$sql = "SELECT pt.product_name, pt.product_image, ft.farm_type_name,
        SUM(p.weight_kg) AS total_weight, AVG(p.price_tk) AS avg_price
        FROM products p
        JOIN product_types pt ON p.product_type_id = pt.product_type_id
        JOIN farm_types ft ON p.farm_type_id = ft.farm_type_id
        WHERE p.product_type_id = $product_type_id
        GROUP BY p.product_type_id, pt.product_name, pt.product_image, ft.farm_type_name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $image_path = "../uploads/" . $row['product_image'];
    $product_name = $row['product_name'];
    $total_weight = $row['total_weight'];
    $avg_price = number_format($row['avg_price'], 2);
} else {
    // Fallback if no data
    $image_path = "../IMG/potatoes.png";
    $product_name = "Product Not Found";
    $total_weight = 0;
    $avg_price = "N/A";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartFarm</title>
    <!-- <link rel="icon" type="image/png" sizes="2x2" href="/IMG/small logo.png" /> -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css_file/featured_product.css" />
  </head>
  <body>
    <!-- Navbar starts here -->
    <nav>
      <div class="navbar">
        <div class="logo">
          <a href="#"><img src="../IMG/LOGO DESIGN-01.png" alt="logo" /></a>
        </div>

        <!-- Desktop Categories -->
        <div class="desktop-only dropdown">
          <button
            class="btn all_catagories"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="fa-solid fa-bars-staggered"></i>
            All Categories
            <i class="fa-solid fa-angle-down"></i>
          </button>
          <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button">Action</button></li>
            <li>
              <button class="dropdown-item" type="button">
                Another action
              </button>
            </li>
            <li>
              <button class="dropdown-item" type="button">
                Something else here
              </button>
            </li>
          </ul>
        </div>

        <!-- Desktop Search -->
        <form class="d-flex search-form desktop-only" role="search">
          <input
            class="form-control search-input"
            type="search"
            placeholder="   Type Your Products"
            aria-label="Search"
          />
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

          <div class="heart-icon">
            <i class="fa-regular fa-heart"></i>
          </div>
          <div class="shopping-cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
          </div>
          <button
            class="btn"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample"
          >
            <div class="hamburger-menu">
              <i class="fa-solid fa-bars"></i>
            </div>
          </button>

          <!-- Offcanvas Menu -->
          <div
            class="offcanvas offcanvas-start"
            tabindex="-1"
            id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel"
          >
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
              ></button>
            </div>
            <div class="offcanvas-body">
              <!-- Mobile Categories (Visible only in mobile) -->
              <div class="mobile-only dropdown mb-3">
                <button
                  class="btn all_catagories w-100"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="fa-solid fa-bars-staggered"></i>
                  All Categories
                  <i class="fa-solid fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu">
                  <li>
                    <button class="dropdown-item" type="button">Action</button>
                  </li>
                  <li>
                    <button class="dropdown-item" type="button">
                      Another action
                    </button>
                  </li>
                  <li>
                    <button class="dropdown-item" type="button">
                      Something else here
                    </button>
                  </li>
                </ul>
              </div>

              <!-- Mobile Search (Visible only in mobile) -->
              <form class="d-flex search-form mobile-only mb-3" role="search">
                <input
                  class="form-control search-input"
                  type="search"
                  placeholder="   Type Your Products"
                  aria-label="Search"
                />
                <button class="btn search-button" type="submit">
                  <div class="search-text">
                    <p>Search</p>
                    <i class="fas fa-search"></i>
                  </div>
                </button>
              </form>

              <!-- New Buttons (Always Visible in Offcanvas) -->
              <div class="offcanvas-buttons">
                <button class="btn w-100 mb-2 alvi">
                  <a href="index.html">Home</a>
                </button>
                <button class="btn w-100 mb-2 alvi">
                  <a href="html_files/official_website.html"
                    >Official Website</a
                  >
                </button>
                <button class="btn w-100 mb-2 alvi">
                  <a href="html_files/farmer.html">Be a Farmer</a>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar ends here -->

    <!-- middle part start -->

    <div class="middle-content">
        <div class="left_side">
           <div class="image-container">
            <img src="<?php echo $image_path; ?>" alt="<?php echo $product_name; ?>" />
           </div>
         </div>

        <div class="middle_side">
           <h1>FRESH PREMIUM <?php echo $product_name; ?></h1>
           <p class="description">
            People live in a world of changing seasons, <br />where opportunities
            and challenges arise.
            </p>
             <ul>
              <li>People live in a changing environment.</li>
              <li>Facing challenges in difficult situations.</li>
              <li>Finding balance and adapting over time.</li>
            </ul>
         </div>

    <div class="right_side">
            <h2><?php echo $avg_price; ?> TK/kg</h2>
            <p>Available <?php echo $total_weight; ?> kg</p>
          <div class="cart-options">
            <button class="quantity-btn">-</button>
            <input type="text" value="1Kg" class="quantity" />
            <button class="quantity-btn">+</button>
            <button class="add-to-cart">Add to cart</button>
          </div>
          <div class="checkout">
            <p>Guaranteed Safe Checkout</p>
            <div class="payment-options">
                <i class="fa fa-cc-visa" style="font-size: 48px; color: #1a1f71"></i>
                <i class="fa fa-cc-mastercard" style="font-size: 48px; color: #eb001b"></i>
                <span class="cash-on-delivery">Cash on Delivery</span>
            </div>
          </div>
    </div>
</div>

    <!--Footer starts here-->
    <footer class="footer">
      <div class="container">
        <div class="footer-section logo-section">
          <h2 class="logo">SmartFarm</h2>
          <p>
            When an unknown printer took a galley of type and scrambled it to
            make a type specimen book.
          </p>
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

    <!--Footer ends here-->

    <script
      src="https://kit.fontawesome.com/85fcd39f72.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script src="index.js"></script>
  </body>
</html>
