import "./styles/app.css";

const avatarDropdown = document.querySelector("#avatar");
const changePassword = document.querySelector("#change-password");
const overlay = document.querySelector("#overlay");

if (avatarDropdown) {

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
}
document.addEventListener('DOMContentLoaded', function () {
    const increaseButton = document.getElementById('increaseQuantity');
    const decreaseButton = document.getElementById('decreaseQuantity');
    const totalPrice = document.getElementById('totalPrice');
    if (increaseButton && decreaseButton && totalPrice) {
        const basePrice = (totalPrice.textContent).replace(/\s|\$/g, "") + '0';
        increaseButton.addEventListener('click', () => updateQuantity(1));
        decreaseButton.addEventListener('click', () => updateQuantity(-1));

        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantityInput');
            const hiddenQuantity = document.getElementById('create_cart_item_quantity');

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

const searchIcon = document.querySelector("#search");
console.log(searchIcon)