document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.querySelector('.card__image img');
    const thumbnails = document.querySelectorAll('.cartProduct_gallery-thumbnails .thumbnail');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');
            // Update main image
            mainImage.src = thumbnail.dataset.image;
        });
    });

    // Tabs functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    function switchTab(tabId) {
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));

        const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
        const activeContent = document.getElementById(tabId);

        activeButton.classList.add('active');
        activeContent.classList.add('active');

        activeButton.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.dataset.tab;
            switchTab(tabId);
        });
    });

    // Initialize first tab
    switchTab('description');
});








// Update main image when clicking thumbnails
function updateMainImage(src) {
    document.getElementById('mainImage').src = src;
}

// Color selection
const colorButtons = document.querySelectorAll('.color-btn');
colorButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        colorButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        button.classList.add('active');
    });
});

// Storage selection
const storageButtons = document.querySelectorAll('.storage-btn');
storageButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        storageButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        button.classList.add('active');
    });
});

// Favorite button functionality
const favoriteBtn = document.querySelector('.favorite-btn');
favoriteBtn.addEventListener('click', () => {
    favoriteBtn.classList.toggle('active');
});

// Add hover effect to thumbnails
const thumbnails = document.querySelectorAll('.thumbnail');
thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('mouseenter', () => {
        thumbnail.style.transform = 'scale(1.05)';
    });

    thumbnail.addEventListener('mouseleave', () => {
        thumbnail.style.transform = 'scale(1)';
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('main-product-image');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            // Убираем активный класс у всех миниатюр
            thumbnails.forEach(t => t.classList.remove('active'));
            // Добавляем активный класс текущей миниатюре
            this.classList.add('active');
            // Обновляем основное изображение
            mainImage.src = this.dataset.image;
        });
    });
});
