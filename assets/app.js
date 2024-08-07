/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';


const avatarDropdown = document.querySelector('#avatar');
const changePassword = document.querySelector('#change-password');

avatarDropdown.addEventListener("click", (e) => {
    e.preventDefault();

    if (changePassword.style.display === 'block') {
        changePassword.style.display = 'none';
    } else {
        changePassword.style.display = 'block';
    }

});
