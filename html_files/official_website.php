<?php
$conn = mysqli_connect("localhost", "root", "alvi1234hello", "smartfarm") or die("Connection failed");

if (isset($_POST['go_to_employee'])) {
    header("Location:official_website_employee.php");
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
    <link rel="stylesheet" href="../css_file/official_website_css.css" />
  </head>
  <body>
    <!-- Navbar starts here -->
    <nav>
      <div class="navbar">
        <div class="logo">
          <a href="#"><img src="../IMG/LOGO DESIGN-01.png" alt="logo" /></a>
        </div>
        <div class="middle-text">
          <ul>
            <li>Home</li>
            <li>About</li>
            <li>Contact</li>
            <form method="POST">
            <button class="btn  anas" type="submit" name="go_to_employee"><li id="member" >Member</li></button>
              
              <!-- <ul class="dropdown">
                <li>Employee</li>
                <li>Farmers</li>
              </ul> -->
            
            </form>
          </ul>
        </div>

        <div class="icons-right">
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

              <!-- New Buttons (Always Visible in Offcanvas) -->
              <div class="offcanvas-buttons">
                <button class="btn w-100 mb-2 alvi">
                  <a href="../index.php">E-commerce</a>
                </button>
                <button class="btn w-100 mb-2 alvi">
                  <a href="official_website.php">Official Website</a>
                </button>
                <button class="btn w-100 mb-2 alvi">
                  <a href="farmer.php">Be a Farmer</a>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar ends here -->
    <!--Hero Section starts here-->
    <div class="hero">
      <h2>Empowering Farmers</h2>
      <h2>Connecting Buyers</h2>
      <p>
        Bridging the gap between farmers and consumers—fresh, organic, and
        direct from the source. Support local farmers and enjoy the best nature
        has to offer.
      </p>
      <button class="button alvi">
        <a href="#top-sellers">Get Started</a>
      </button>
    </div>
    <!--Hero Section ends here-->

    <!--numbers section starts here-->
    <section class="counter-section">
      <div class="counter-box">
        <h2><span class="counter" data-target="1200">0</span>+</h2>
        <p>Customers</p>
      </div>
      <div class="counter-box">
        <h2><span class="counter" data-target="5000">0</span>+</h2>
        <p>Employees</p>
      </div>
      <div class="counter-box">
        <h2><span class="counter" data-target="20">0</span>+</h2>
        <p>Global Clients</p>
      </div>
    </section>
    <!--numbers section starts here-->
    <section class="about-section">
      <div class="about-content">
        <h2>About Us</h2>
        <p>
          We are a team committed to delivering excellence. With 500+ employees
          and 7+ global clients, we strive to bring innovation and quality to
          every project we take on.
        </p>
        <p>
          Our mission is to create impactful solutions that empower businesses
          and individuals. Join us as we continue to grow and make a difference
          worldwide.
        </p>
        <button class="learn-more">Learn More</button>
      </div>
      <div class="about-image">
        <img src="../IMG/about_us.jpg" alt="About Us Image" />
      </div>
    </section>

    <!--contact us section starts here-->
    <section class="contact-section">
      <div class="contact-content">
        <h2>Contact Us</h2>
        <p>
          Have questions? Feel free to reach out, and we’ll get back to you as
          soon as possible.
        </p>

        <form class="contact-form">
          <div class="input-box">
            <input type="text" required />
            <label>Full Name</label>
          </div>
          <div class="input-box">
            <input type="email" required />
            <label>Email</label>
          </div>
          <div class="input-box">
            <textarea required></textarea>
            <label>Message</label>
          </div>
          <button type="submit" class="send-btn">Send Message</button>
        </form>
      </div>
    </section>

    <!--contact us section ends here-->

    <!-- Footer starts here -->
    <footer class="footer">
        <div class="container">
            <div class="footer-section logo-section">
                <h2 class="logo">SmartFarm</h2>
                <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <p><i class="fas fa-map-marker-alt"></i> 23/A Road,Uttara,Dhaka</p>
                <p><i class="fas fa-phone-alt"></i>)01711946008</p>
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
                    <li><a href="#">Beef</a></li>
                    <li><a href="#">Rice</a></li>
                    <li><a href="#">Apple</a></li>
                    <li><a href="#">Banana</a></li>
                    <li><a href="#">Egg</a></li>
                    <li><a href="#">Chicken</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Accounts</h3>
                <ul>
                    <li><a href="#">My Orders</a></li>
                    <li><a href="#">Cart</a></li>
                    <li><a href="#">Checkout</a></li>   
                    <li><a href="#">My Account</a></li>
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
    <script src="../js file/official_website_js.js"></script>
  </body>
</html>
