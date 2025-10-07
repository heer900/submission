const slides = document.querySelector(".slides");
const slideItems = document.querySelectorAll(".showcase-item");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const dotsContainer = document.querySelector(".dots");

let index = 0;

// Create navigation dots
slideItems.forEach((_, i) => {
  const dot = document.createElement("button");
  if (i === 0) dot.classList.add("active");
  dotsContainer.appendChild(dot);
  dot.addEventListener("click", () => showSlide(i));
});

const dots = document.querySelectorAll(".dots button");

// Function to show slide by index
function showSlide(i) {
  if (i < 0) index = slideItems.length - 1;
  else if (i >= slideItems.length) index = 0;
  else index = i;

  slides.style.transform = `translateX(${-index * 100}%)`;

  dots.forEach(dot => dot.classList.remove("active"));
  dots[index].classList.add("active");
}

// Arrow button events
prevBtn.addEventListener("click", () => showSlide(index - 1));
nextBtn.addEventListener("click", () => showSlide(index + 1));

// Auto-slide every 5 seconds
setInterval(() => showSlide(index + 1), 5000);
