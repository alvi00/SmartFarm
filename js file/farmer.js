document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".add_farmer").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "../html_files/add_farmer_form.html";
    });
  });
});
