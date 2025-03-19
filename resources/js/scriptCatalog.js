document.addEventListener('DOMContentLoaded', function() {
    const products = document.querySelectorAll('.product');
    const totalPriceElement = document.getElementById('total-price');

    function updateTotalPrice() {
        let total = 0;
        products.forEach(product => {
            const quantityInput = product.querySelector('input[type="number"]');
            const productPrice = parseFloat(product.dataset.price);
            const quantity = parseInt(quantityInput.value);
            const totalPriceForProduct = productPrice * quantity;

            // Обновляем цену для каждого товара
            product.querySelector('.cart-price').textContent = ${totalPriceForProduct} ₽;
            total += totalPriceForProduct; // Суммируем общую цену
        });

        // Обновляем общую цену
        totalPriceElement.textContent = ${total} ₽;
    }

    products.forEach((product, index) => {
        const decrementButton = product.querySelector('.decrement');
        const incrementButton = product.querySelector('.increment');
        const quantityInput = product.querySelector('input[type="number"]');

        // Обработчик нажатия на кнопку уменьшения
        decrementButton.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantity--; // Уменьшаем количество, если больше 1
                quantityInput.value = quantity; // Обновляем значение в поле ввода
                updateTotalPrice(); // Обновляем общую цену
            }
        });

        // Обработчик нажатия на кнопку увеличения
        incrementButton.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            quantity++; // Увеличиваем количество
            quantityInput.value = quantity; // Обновляем значение в поле ввода
            updateTotalPrice(); // Обновляем общую цену
        });
    });

    // Инициализация общей цены при загрузке страницы
    updateTotalPrice();
});
