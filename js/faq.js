// FAQ collapsible toggle
document.querySelectorAll(".faq-item").forEach(item => {
  item.querySelector(".question").addEventListener("click", () => {
    item.classList.toggle("active");
  });
});

// Popup banner show on load
const popupBanner = document.getElementById("popupBanner");
const closeBanner = document.getElementById("closeBanner");
window.addEventListener("load", () => {
  popupBanner.style.display = "block";
  setTimeout(() => popupBanner.style.display = "none", 8000); // auto-hide after 8s
});
closeBanner.addEventListener("click", () => {
  popupBanner.style.display = "none";
});

// Slider logic
const slides = document.getElementById("slides");
const images = slides.querySelectorAll("img");
let index = 0;

document.getElementById("next").addEventListener("click", () => {
  index = (index + 1) % images.length;
  slides.style.transform = `translateX(${-index * 100}%)`;
});

document.getElementById("prev").addEventListener("click", () => {
  index = (index - 1 + images.length) % images.length;
  slides.style.transform = `translateX(${-index * 100}%)`;
});

// Auto-slide every 5s
setInterval(() => {
  index = (index + 1) % images.length;
  slides.style.transform = `translateX(${-index * 100}%)`;
}, 5000);
