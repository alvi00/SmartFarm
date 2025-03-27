document.getElementById("member").addEventListener("click", function (event) {
  event.stopPropagation();
  let dropdown = this.querySelector(".dropdown");

  if (dropdown.classList.contains("show")) {
    dropdown.classList.remove("show");
    setTimeout(() => (dropdown.style.display = "none"), 300); // Hide after animation
  } else {
    dropdown.style.display = "block";
    setTimeout(() => dropdown.classList.add("show"), 10);
  }
});

document.addEventListener("click", function () {
  let dropdown = document.querySelector(".dropdown");
  if (dropdown.classList.contains("show")) {
    dropdown.classList.remove("show");
    setTimeout(() => (dropdown.style.display = "none"), 300);
  }
});
