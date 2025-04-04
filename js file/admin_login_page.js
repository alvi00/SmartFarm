document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".btn-admin-login").forEach((element) => {
    element.addEventListener("click", function () {
      window.location.href = "../html_files/employee_form.html";
    });
  });
});
