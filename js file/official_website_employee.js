document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".add-member-btn").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "../html_files/admin_login_page.html";
    });
  });
});
