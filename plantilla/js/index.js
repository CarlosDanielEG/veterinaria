const images = [
    { url: 'images/veterinario.jpg', text: 'Cuidados de la máxima calidad para mascotas que le encantarán', alignment: 'text-left' },
    { url: 'images/gallery-2.jpg', text: 'El lugar donde su mascota recibe el mejor cuidado', alignment: 'text-right' }
];

let currentIndex = 0;
const heroElement = document.getElementById('hero');
const heroText = document.getElementById('hero-text');
const heroHeading = document.getElementById('hero-heading');

function changeBackgroundImage() {
    const currentImage = images[currentIndex];

    // Update background image
    heroElement.style.backgroundImage = `url('${currentImage.url}')`;

    // Update text content and alignment class
    heroHeading.innerText = currentImage.text;
    heroText.className = `col-md-11 ${currentImage.alignment}`;

    // Move to the next image, looping back if necessary
    currentIndex = (currentIndex + 1) % images.length;
}

// Initialize the first image and text
changeBackgroundImage();
setInterval(changeBackgroundImage, 4000);
