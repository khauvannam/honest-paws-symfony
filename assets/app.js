import "./styles/app.css";

// Cart Popup
document.addEventListener("DOMContentLoaded", function () {
  const cartIcon = document.getElementById("cartIcon");
  const cartPopup = document.getElementById("cartPopup");
  const overlay = document.getElementById("overlay");
  const closeCart = document.getElementById("closeCart");

  // Hiển thị popup và overlay
  cartIcon.addEventListener("click", function () {
    cartPopup.classList.remove("translate-x-full");
    cartPopup.classList.add("translate-x-0");
    overlay.classList.remove("hidden");
  });

  // Đóng popup và overlay khi nhấp vào nút đóng
  closeCart.addEventListener("click", function () {
    cartPopup.classList.remove("translate-x-0");
    cartPopup.classList.add("translate-x-full");
    overlay.classList.add("hidden");
  });

  // Đóng popup và overlay khi nhấp ra ngoài
  document.addEventListener("click", function (event) {
    // Kiểm tra xem nhấp vào bên ngoài popup và overlay
    if (
      overlay.classList.contains("hidden") &&
      !cartPopup.contains(event.target) &&
      !cartIcon.contains(event.target) &&
      !overlay.contains(event.target)
    ) {
      cartPopup.classList.remove("translate-x-0");
      cartPopup.classList.add("translate-x-full");
      overlay.classList.add("hidden");
    }
  });

  // Ngăn chặn việc đóng khi nhấp vào overlay
  overlay.addEventListener("click", function (event) {
    event.stopPropagation();
  });
});

// Search Popup
document.addEventListener("DOMContentLoaded", function () {
  const searchIcon = document.querySelector(
    "a.flex.items-center.cursor-pointer",
  );
  searchIcon.setAttribute("id", "search");

  const form = document.getElementById("searchForm");
  const closeButton = document.getElementById("closeSearchForm");

  searchIcon.addEventListener("click", function () {
    if (form.classList.contains("opacity-0")) {
      form.classList.remove("top-[-100px]", "opacity-0", "pointer-events-none");
      form.classList.add("top-0", "opacity-100", "pointer-events-auto");
    }
  });

  closeButton.addEventListener("click", function () {
    form.classList.add("top-[-100px]", "opacity-0", "pointer-events-none");
    form.classList.remove("top-0", "opacity-100", "pointer-events-auto");
  });
});

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
        "create_cart_item_quantity",
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

document.addEventListener("DOMContentLoaded", function () {
  const increaseButtons = document.querySelectorAll(".increase-quantity");
  const decreaseButtons = document.querySelectorAll(".decrease-quantity");
  const totalPriceElement = document.querySelector("#total-price");
  let totalPriceValue = parseFloat(
    totalPriceElement.textContent.replace(/\s|\$/g, ""),
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
        quantityInput,
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
