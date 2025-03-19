document.addEventListener("DOMContentLoaded", function () {
    const cartModal = document.getElementById('cart-modal');
    const openCartButton = document.getElementById('open-cart');
    const closeCartButton = document.getElementById('close-cart');

    // Открыть корзину
    openCartButton.addEventListener('click', function () {
        cartModal.style.display = 'flex'; // Показываем модальное окно
    });

    // Закрыть корзину
    closeCartButton.addEventListener('click', function () {
        cartModal.style.display = 'none'; // Скрываем модальное окно
    });

    // Закрытие по клику вне области модального окна
    cartModal.addEventListener('click', function (event) {
        if (event.target === cartModal) {
            cartModal.style.display = 'none'; // Скрываем модальное окно
        }
    });

    // Закрыть модальное окно при нажатии на Esc
    window.addEventListener('keydown', (e) => {
        if (e.key === "Escape") {
            cartModal.style.display = 'none'; // Скрываем модальное окно
        }
    });
});
