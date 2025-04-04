<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "SmartFarm") or die("Connection failed");

$sql = "SELECT f.full_name, f.phone_number, f.registration_date, f.face_image, 
        GROUP_CONCAT(ft.farm_type_name SEPARATOR ', ') AS farm_types
        FROM farmers f
        LEFT JOIN farmer_farm_types fft ON f.farmer_id = fft.farmer_id
        LEFT JOIN farm_types ft ON fft.farm_type_id = ft.farm_type_id
        GROUP BY f.farmer_id";
$result = $conn->query($sql);
if (isset($_POST['add_farmer'])) {
  header("Location:add_farmer_form.php");
  exit();
}
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
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- Navbar starts here -->
    <nav>
      <div class="navbar">
        <div class="logo">
          <a href="#"><img src="IMG/LOGO DESIGN-01.png" alt="logo" /></a>
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

    <!-- Vertical starts here -->
    <div class="vertical-products">
      <!--First item-->
      <div class="items_all">
        <div class="image_of_the_item">
          <img src="IMG/vegetable.png" alt="item" />
        </div>
        <div class="item_description">
          <h6>Vegetables</h6>
          <p>6 Products</p>
        </div>
      </div>
      <!--First item ends-->

      <!--First item-->
      <div class="items_all">
        <div class="image_of_the_item">
          <img src="IMG/fruits.png" alt="item" />
        </div>
        <div class="item_description">
          <h6>Fresh Fruits</h6>
          <p>8 Products</p>
        </div>
      </div>
      <!--First item ends-->

      <!--First item-->
      <div class="items_all">
        <div class="image_of_the_item">
          <img src="IMG/Milk.png" alt="item" />
        </div>
        <div class="item_description">
          <h6>Dairy Items</h6>
          <p>5 Products</p>
        </div>
      </div>
      <!--First item ends-->

      <!--First item-->
      <div class="items_all">
        <div class="image_of_the_item">
          <img src="IMG/fish.png" alt="item" />
        </div>
        <div class="item_description">
          <h6>Fish Items</h6>
          <p>6 Products</p>
        </div>
      </div>
      <!--First item ends-->

      <!--First item-->
      <div class="items_all">
        <div class="image_of_the_item">
          <img src="IMG/meat.png" alt="item" />
        </div>
        <div class="item_description">
          <h6>Meat Items</h6>
          <p>6 Products</p>
        </div>
      </div>
      <!--First item ends-->

      <!--First item-->
      <div class="items_all">
        <div class="image_of_the_item">
          <img src="IMG/vegetable.png" alt="item" />
        </div>
        <div class="item_description">
          <h6>Carb Items</h6>
          <p>6 items</p>
        </div>
      </div>
      <!--First item ends-->
    </div>
    <!-- Closing vertical-products -->

    <!--Promotional Contents starts here-->
    <div class="Promotional_Contents">
      <div class="promo-banner_one">
        <div class="promo-content">
          <span class="promo-badge">100% Farm Fresh Food</span>
          <h1>Fresh Organic</h1>
          <p>Food For All</p>
          <h2>$59.00</h2>
          <button class="shop-btn">Shop Now</button>
        </div>
      </div>
      <div class="promo-banner_two">
        <div class="promo-content_banner_two">
          <h1>Premium Honeynuts</h1>
          <p>100% salted organic nuts</p>
          <h2>$15.00</h2>
          <button class="shop-btn_banner_two">Shop Now</button>
        </div>
      </div>

      <div class="right-bottom-photos">
        <div class="promo-banner_three">
          <div class="promo-content_banner_three">
            <h1>Baby diaper</h1>
            <p>Top quality product</p>
            <button class="shop-btn_banner_three">Shop Now</button>
          </div>
        </div>

        <div class="promo-banner_four">
          <div class="promo-content_banner_four">
            <h1>Facewash</h1>
            <p>All Fixed price</p>
            <button class="shop-btn_banner_four">Shop Now</button>
          </div>
        </div>
      </div>
    </div>
    <!--Promotional Contents ends here-->

    <!--Featured products text starts line-->
    <div class="featured-products-text">
      <h3>Trending Products</h3>
      <div class="right-side-text">
        <p>All</p>
        <p>Dairy product</p>
        <p>Vegetables</p>
        <p>Fresh Fruits</p>
        <p>Meat</p>
        <p>Fish</p>
      </div>
    </div>
    <!--Featured products text line ends here-->
    <!--Featured products stars here-->
    <div class="featured-products">
      <!--First Card-->
      <div class="product-card">
        <div class="product-header">
          <span class="category">Vegetables</span>
          <i class="fa-regular fa-heart wishlist"></i>
        </div>
        <div class="product-image">
          <img src="IMG/featured_product-1.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="weight-options">
          <button>100gm</button>
          <button>500gm</button>
        </div>
        <div class="product-price">
          <span class="price">$30.00 – $38.00</span>
          <span class="discount">-16%</span>
        </div>
        <p class="product-title">
          Russet Idaho Potatoes Fresh Premium Fruit and...
        </p>
        <div class="rating">
          <span>⭐⭐⭐⭐⭐</span>
          <span class="rating-score">(5.00)</span>
        </div>
        <button class="select-options">
          <i class="fa-solid fa-cart-shopping"></i> Select Options
        </button>
      </div>
      <!--Second Card-->
      <div class="product-card">
        <div class="product-header">
          <span class="category">Dairy Items</span>
          <i class="fa-regular fa-heart wishlist"></i>
        </div>
        <div class="product-image">
          <img src="IMG/featured_product-2.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="weight-options">
          <button>100gm</button>
          <button>375ml</button>
        </div>
        <div class="product-price">
          <span class="price">$25.00 – $30.00</span>
          <span class="discount">-44%</span>
        </div>
        <p class="product-title">
          Aptamil Folding Baby Stroller Fresh Premium Fruit...
        </p>
        <div class="rating">
          <span>⭐⭐⭐⭐⭐</span>
          <span class="rating-score">(5.00)</span>
        </div>
        <button class="select-options">
          <i class="fa-solid fa-cart-shopping"></i> Select Options
        </button>
      </div>
      <!--Third Card-->
      <div class="product-card">
        <div class="product-header">
          <span class="category">Vegetables</span>
          <i class="fa-regular fa-heart wishlist"></i>
        </div>
        <div class="product-image">
          <img src="IMG/featured_product-3.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="weight-options">
          <button>100gm</button>
          <button>500gm</button>
        </div>
        <div class="product-price">
          <span class="price">$3.00 – $8.00</span>
          <span class="discount">-77%</span>
        </div>
        <p class="product-title">
          Whole Foods Matket, Organic Russet Idaho Potatoes
        </p>
        <div class="rating">
          <span>⭐⭐⭐⭐⭐</span>
          <span class="rating-score">(5.00)</span>
        </div>
        <button class="select-options">
          <i class="fa-solid fa-cart-shopping"></i> Select Options
        </button>
      </div>
      <!--Fourth Card-->
      <div class="product-card">
        <div class="product-header">
          <span class="category">Vegetables</span>
          <i class="fa-regular fa-heart wishlist"></i>
        </div>
        <div class="product-image">
          <img src="IMG/featured_product-4.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="weight-options">
          <button>100gm</button>
          <button>500gm</button>
        </div>
        <div class="product-price">
          <span class="price">$19.00 – $20.00</span>
          <span class="discount">-14%</span>
        </div>
        <p class="product-title">
          Russet Idaho Potatoes Fresh Premium Fruit and...
        </p>
        <div class="rating">
          <span>⭐⭐⭐⭐⭐</span>
          <span class="rating-score">(5.00)</span>
        </div>
        <button class="select-options">
          <i class="fa-solid fa-cart-shopping"></i> Select Options
        </button>
      </div>
      <!--Fifth Card-->
      <div class="product-card">
        <div class="product-header">
          <span class="category">Beverage</span>
          <i class="fa-regular fa-heart wishlist"></i>
        </div>
        <div class="product-image">
          <img src="IMG/featured_product-5.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="weight-options">
          <button>100gm</button>
          <button>500gm</button>
        </div>
        <div class="product-price">
          <span class="price">$34.00 – $38.00</span>
          <span class="discount">-24%</span>
        </div>
        <p class="product-title">
          Russet Idaho Potatoes Fresh Premium Fruit and...
        </p>
        <div class="rating">
          <span>⭐⭐⭐⭐⭐</span>
          <span class="rating-score">(5.00)</span>
        </div>
        <button class="select-options">
          <i class="fa-solid fa-cart-shopping"></i> Select Options
        </button>
      </div>

      <!--Sixth Card-->
      <div class="product-card">
        <div class="product-header">
          <span class="category">Vegetables</span>
          <i class="fa-regular fa-heart wishlist"></i>
        </div>
        <div class="product-image">
          <img src="IMG/featured_product-6.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="weight-options">
          <button>300gm</button>
          <button>500gm</button>
        </div>
        <div class="product-price">
          <span class="price">$30.00 – $38.00</span>
          <span class="discount">-16%</span>
        </div>
        <p class="product-title">
          Russet Idaho Potatoes Fresh Premium Fruit and...
        </p>
        <div class="rating">
          <span>⭐⭐⭐⭐⭐</span>
          <span class="rating-score">(5.00)</span>
        </div>
        <button class="select-options">
          <i class="fa-solid fa-cart-shopping"></i> Select Options
        </button>
      </div>
    </div>
    <!--Featured products ends here-->

    <!--Top sellers starts here-->
    <div class="top-sellers">
      <h3>Top Sellers</h3>
    </div>
    <div class="cards-of-sellers">
      <!--First Top sellers-->
      <div
        class="card mb-3 shadow-sm"
        style="max-width: 400px; border-radius: 10px; overflow: hidden"
      >
        <div class="row g-0 align-items-center">
          <div class="col-4">
            <img
              src="IMG/top-seller-1.png"
              class="img-fluid rounded-start"
              alt="Profile Image"
            />
          </div>
          <div class="col-7">
            <div class="card-body py-2 px-2">
              <h5 class="card-title mb-1">Featured</h5>
              <p class="card-text mb-1 text-muted">Michel Richard</p>
              <div class="rating d-flex align-items-center">
                <span class="text-warning">⭐⭐⭐⭐⭐</span>
                <span
                  class="rating-score ms-1 text-muted"
                  style="font-size: 12px"
                  >(5.00)</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--First Top sellers ends-->
      <!--Second Top sellers-->
      <div
        class="card mb-3 shadow-sm"
        style="max-width: 400px; border-radius: 10px; overflow: hidden"
      >
        <div class="row g-0 align-items-center">
          <div class="col-4">
            <img
              src="IMG/top-seller-2.png"
              class="img-fluid rounded-start"
              alt="Profile Image"
            />
          </div>
          <div class="col-7">
            <div class="card-body py-2 px-2">
              <h5 class="card-title mb-1">Featured</h5>
              <p class="card-text mb-1 text-muted">Dianne Russell</p>
              <div class="rating d-flex align-items-center">
                <span class="text-warning">⭐⭐⭐⭐⭐</span>
                <span
                  class="rating-score ms-1 text-muted"
                  style="font-size: 12px"
                  >(5.00)</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Second Top sellers ends-->
      <!--Third Top sellers-->
      <div
        class="card mb-3 shadow-sm"
        style="max-width: 400px; border-radius: 10px; overflow: hidden"
      >
        <div class="row g-0 align-items-center">
          <div class="col-4">
            <img
              src="IMG/top-seller-3.png"
              class="img-fluid rounded-start"
              alt="Profile Image"
            />
          </div>
          <div class="col-7">
            <div class="card-body py-2 px-2">
              <h5 class="card-title mb-1">Featured</h5>
              <p class="card-text mb-1 text-muted">Marvin McKinney</p>
              <div class="rating d-flex align-items-center">
                <span class="text-warning">⭐⭐⭐⭐⭐</span>
                <span
                  class="rating-score ms-1 text-muted"
                  style="font-size: 12px"
                  >(5.00)</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Third Top sellers ends-->
      <!--Fourth Top sellers-->
      <div
        class="card mb-3 shadow-sm"
        style="max-width: 400px; border-radius: 10px; overflow: hidden"
      >
        <div class="row g-0 align-items-center">
          <div class="col-4">
            <img
              src="IMG/top-seller-4.png"
              class="img-fluid rounded-start"
              alt="Profile Image"
            />
          </div>
          <div class="col-7">
            <div class="card-body py-2 px-2">
              <h5 class="card-title mb-1">Featured</h5>
              <p class="card-text mb-1 text-muted">Eleanor Pena</p>
              <div class="rating d-flex align-items-center">
                <span class="text-warning">⭐⭐⭐⭐⭐</span>
                <span
                  class="rating-score ms-1 text-muted"
                  style="font-size: 12px"
                  >(5.00)</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Fourth Top sellers ends-->
    </div>
    <!--Top sellets ends here-->

    <!--Divider image starts here-->
    <div class="divider-image"></div>
    <!--Divider image ends here-->

    <!--our products starts here-->
    <div class="top-sellers">
      <h3>Our Products</h3>
    </div>
    <!--our products ends here-->

    <!--Prouct card starts here-->
    <div class="product-card-div_down">
      <!--First products-->

      <div class="product-card_down">
        <div class="product-image_down">
          <img src="IMG/featured_product-1.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="product-details_down">
          <p class="category_down">Vegetables</p>
          <h3 class="price_down">$30.00 – $38.00</h3>
          <span class="discount_down">-16%</span>
          <p class="product-title_down">
            Russet Idaho Potatoes <br />
            Fresh Premium Fruit and...
          </p>
          <div class="rating_down">
            <span class="stars_down">⭐⭐⭐⭐⭐</span>
            <span class="rating-value_down">(5.00)</span>
          </div>
        </div>
        <div class="wishlist_down">
          <i class="far fa-heart"></i>
        </div>
      </div>
      <!--second products-->

      <div class="product-card_down">
        <div class="product-image_down">
          <img src="IMG/featured_product-6.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="product-details_down">
          <p class="category_down">Vegetables</p>
          <h3 class="price_down">$30.00 – $38.00</h3>
          <span class="discount_down">-16%</span>
          <p class="product-title_down">
            Russet Idaho Potatoes <br />
            Fresh Premium Fruit and...
          </p>
          <div class="rating_down">
            <span class="stars_down">⭐⭐⭐⭐⭐</span>
            <span class="rating-value_down">(5.00)</span>
          </div>
        </div>
        <div class="wishlist_down">
          <i class="far fa-heart"></i>
        </div>
      </div>
      <!--third products-->

      <div class="product-card_down">
        <div class="product-image_down">
          <img src="IMG/featured_product-2.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="product-details_down">
          <p class="category_down">Vegetables</p>
          <h3 class="price_down">$30.00 – $38.00</h3>
          <span class="discount_down">-16%</span>
          <p class="product-title_down">
            Russet Idaho Potatoes <br />
            Fresh Premium Fruit and...
          </p>
          <div class="rating_down">
            <span class="stars_down">⭐⭐⭐⭐⭐</span>
            <span class="rating-value_down">(5.00)</span>
          </div>
        </div>
        <div class="wishlist_down">
          <i class="far fa-heart"></i>
        </div>
      </div>
      <!--fourth products-->

      <div class="product-card_down">
        <div class="product-image_down">
          <img src="IMG/featured_product-3.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="product-details_down">
          <p class="category_down">Vegetables</p>
          <h3 class="price_down">$30.00 – $38.00</h3>
          <span class="discount_down">-16%</span>
          <p class="product-title_down">
            Russet Idaho Potatoes <br />
            Fresh Premium Fruit and...
          </p>
          <div class="rating_down">
            <span class="stars_down">⭐⭐⭐⭐⭐</span>
            <span class="rating-value_down">(5.00)</span>
          </div>
        </div>
        <div class="wishlist_down">
          <i class="far fa-heart"></i>
        </div>
      </div>
      <!--fifth products-->

      <div class="product-card_down">
        <div class="product-image_down">
          <img src="IMG/featured_product-4.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="product-details_down">
          <p class="category_down">Vegetables</p>
          <h3 class="price_down">$30.00 – $38.00</h3>
          <span class="discount_down">-16%</span>
          <p class="product-title_down">
            Russet Idaho Potatoes <br />
            Fresh Premium Fruit and...
          </p>
          <div class="rating_down">
            <span class="stars_down">⭐⭐⭐⭐⭐</span>
            <span class="rating-value_down">(5.00)</span>
          </div>
        </div>
        <div class="wishlist_down">
          <i class="far fa-heart"></i>
        </div>
      </div>
      <!--sixth products-->

      <div class="product-card_down">
        <div class="product-image_down">
          <img src="IMG/featured_product-5.png" alt="Russet Idaho Potatoes" />
        </div>
        <div class="product-details_down">
          <p class="category_down">Vegetables</p>
          <h3 class="price_down">$30.00 – $38.00</h3>
          <span class="discount_down">-16%</span>
          <p class="product-title_down">
            Russet Idaho Potatoes <br />
            Fresh Premium Fruit and...
          </p>
          <div class="rating_down">
            <span class="stars_down">⭐⭐⭐⭐⭐</span>
            <span class="rating-value_down">(5.00)</span>
          </div>
        </div>
        <div class="wishlist_down">
          <i class="far fa-heart"></i>
        </div>
      </div>
    </div>
    <!--Prouct card ends here-->

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
