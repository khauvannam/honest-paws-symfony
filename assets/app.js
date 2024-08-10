import "./styles/app.css";

const avatarDropdown = document.querySelector("#avatar");
const changePassword = document.querySelector("#change-password");
const overlay = document.querySelector("#overlay");

avatarDropdown.addEventListener("click", (e) => {
  e.preventDefault();

  if (changePassword.style.display === "block") {
    changePassword.style.display = "none";
    overlay.style.display = "none";
  } else {
    changePassword.style.display = "block";
    overlay.style.display = "block";
  }
});

overlay.addEventListener("click", () => {
  changePassword.style.display = "none";
  overlay.style.display = "none";
});

const cartIcon = document.getElementById("cart-icon");
const cartPopup = document.getElementById("cart-popup");
const closeCartButton = document.getElementById("close-cart");

cartIcon.addEventListener("click", function (event) {
  event.preventDefault();
  cartPopup.classList.remove("hidden");
});

closeCartButton.addEventListener("click", function () {
  cartPopup.classList.add("hidden");
});
cartPopup.addEventListener("click", function (event) {
  if (event.target === cartPopup) {
    cartPopup.classList.add("hidden");
  }
});
