// Global storage para sa mga images ng bawat product
window.productImagesData = window.productImagesData || {};

function changeSlide(productId, direction) {
    let images = window.productImagesData[productId];
    if (!images || images.length <= 1) return;

    let imgElement = document.querySelector('.slider-img-' + productId);
    let counterElement = document.getElementById('slider-counter-' + productId);
    
    if (!imgElement) return;

    let currentIndex = parseInt(imgElement.getAttribute('data-index')) || 0;
    let newIndex = currentIndex + direction;

    // Mag-loop pabalik sa simula o dulo
    if (newIndex >= images.length) {
        newIndex = 0;
    } else if (newIndex < 0) {
        newIndex = images.length - 1;
    }

    // I-update ang image source at counter
    imgElement.src = images[newIndex];
    imgElement.setAttribute('data-index', newIndex);
    if (counterElement) {
        counterElement.innerText = newIndex + 1;
    }
}