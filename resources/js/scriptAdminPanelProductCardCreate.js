document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.formInsertProduct');
    const fileInput = document.getElementById('product_images');

    form.addEventListener('submit', (e) => {
        if (fileInput.files.length < 4) {
            e.preventDefault(); // Остановить отправку формы
            alert('Пожалуйста, выберите минимум 4 изображения.');
        }
    });
});
