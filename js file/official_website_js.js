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

function startCounterAnimation() {
  const counters = document.querySelectorAll(".counter");
  const speed = 30; // Adjust speed of counting

  counters.forEach((counter) => {
    const updateCount = () => {
      const target = +counter.getAttribute("data-target");
      const count = +counter.innerText;

      const increment = Math.ceil(target / speed);

      if (count < target) {
        counter.innerText = count + increment;
        setTimeout(updateCount, 30);
      } else {
        counter.innerText = target; // Ensure exact number
      }
    };

    updateCount();
  });
}

// Trigger when section is visible
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      startCounterAnimation();
      observer.disconnect(); // Run only once
    }
  });
});

observer.observe(document.querySelector(".counter-section"));
