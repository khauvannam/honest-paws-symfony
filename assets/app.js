import "./styles/app.css";

// Avatar Dropdown Functionality
const avatarDropdown = document.querySelector("#avatar");
const changePassword = document.querySelector("#change-password");
const overlay = document.querySelector("#overlay");

if (avatarDropdown) {
  avatarDropdown.addEventListener("click", (e) => {
    e.preventDefault();
    toggleVisibility(changePassword);
  });

  overlay.addEventListener("click", () => {
    hideElements([changePassword, form]); // Close both changePassword and search form
  });
}

// Quantity Increase/Decrease Functionality
document.addEventListener("DOMContentLoaded", function () {
  const increaseButton = document.getElementById("increaseQuantity");
  const decreaseButton = document.getElementById("decreaseQuantity");
  const totalPrice = document.getElementById("totalPrice");
  if (increaseButton && decreaseButton && totalPrice) {
    const basePrice = parseFloat(totalPrice.textContent.replace(/\s|\$/g, ""));
    increaseButton.addEventListener("click", () => updateQuantity(1));
    decreaseButton.addEventListener("click", () => updateQuantity(-1));

    function updateQuantity(change) {
      const quantityInput = document.getElementById("quantityInput");
      const hiddenQuantity = document.getElementById(
        "create_cart_item_quantity"
      );

      let currentQuantity = parseInt(quantityInput.value, 10);
      const newQuantity = currentQuantity + change;

      if (newQuantity >= 1) {
        quantityInput.value = newQuantity;
        hiddenQuantity.value = newQuantity;

        // Update the price
        const newPrice = basePrice * newQuantity;
        totalPrice.textContent = `$${newPrice.toFixed(2)}`;
      }
    }
  }
});

// Search Functionality
const searchIcon = document.querySelector("#search");
const form = searchIcon ? searchIcon.querySelector("form") : null;

if (searchIcon && form) {
  searchIcon.addEventListener("click", () => {
    toggleVisibility(form);
  });
  overlay.addEventListener("click", () => {
    toggleVisibility(form);
  });

  form.addEventListener("click", (event) => {
    event.stopPropagation();
  });
}

// Utility Functions
function toggleVisibility(element) {
  element.classList.toggle("hidden");
  overlay.classList.toggle("hidden");
}

function hideElements(elements) {
  elements.forEach((element) => {
    if (element) element.classList.add("hidden");
  });
  overlay.classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", function () {
  const increaseButtons = document.querySelectorAll(".increase-quantity");
  const decreaseButtons = document.querySelectorAll(".decrease-quantity");
  const totalPriceElement = document.querySelector("#total-price");
  let totalPriceValue = parseFloat(
    totalPriceElement.textContent.replace(/\s|\$/g, "")
  );

  increaseButtons.forEach((button) => attachButtonClickEvent(button, 1));
  decreaseButtons.forEach((button) => attachButtonClickEvent(button, -1));

  function attachButtonClickEvent(button, change) {
    button.addEventListener("click", function () {
      const row = button.closest("tr");
      const quantityInput = row.querySelector(".quantity-input");
      const totalItemPriceElement = row.querySelector("#total-item-price");

      const priceChange = updateQuantity(
        change,
        totalItemPriceElement,
        quantityInput
      );

      if (priceChange !== 0) {
        // Update only if there is a price change
        totalPriceValue += priceChange;
        totalPriceElement.textContent = `$${totalPriceValue.toFixed(2)}`;
      }
    });
  }

  function updateQuantity(change, totalItemPriceElement, quantityInput) {
    const basePrice = parseFloat(totalItemPriceElement.dataset.price);
    const currentQuantity = parseInt(quantityInput.value, 10);
    const newQuantity = currentQuantity + change;

    if (newQuantity >= 1 && newQuantity <= 20) {
      quantityInput.value = newQuantity;
      const newPrice = basePrice * newQuantity;
      totalItemPriceElement.textContent = `$${newPrice.toFixed(2)}`;
      return change * basePrice; // Return positive or negative change
    }
    return 0; // No change if quantity is out of bounds
  }
});
