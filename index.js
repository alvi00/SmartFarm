document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".product-card_down").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "html_files/featured_product.html";
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".select-options").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "html_files/featured_product.html";
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".fa-user").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "html_files/user_login_page.html";
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".shopping-cart-icon").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "html_files/recipt_page.html";
    });
  });
});
