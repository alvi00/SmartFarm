document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".go_to_farmer").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "../html_files/farmer.html";
    });
  });
});
