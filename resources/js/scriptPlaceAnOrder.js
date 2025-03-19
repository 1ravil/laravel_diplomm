document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('orderForm');
    const paymentButtons = document.querySelectorAll('.payment-btn');
    const inputs = form.querySelectorAll('input[required]'); // Используем атрибут required
    const checkoutBtn = document.querySelector('.checkout-btn');
    const warningMessage = document.querySelector('.warning-message');
    const termsCheck = document.getElementById('termsCheck'); // Чекбокс для условий оферты и политики конфиденциальности
    const termsMessage = document.querySelector('.terms-warning-message'); // Сообщение для предупреждения
    const callbackCheck = document.getElementById('callbackCheck'); // Чекбокс для "Перезвоните мне"
    const callbackWarning = document.querySelector('.callback-warning'); // Предупреждение для чекбокса "Перезвоните мне"

    // Payment method selection
    paymentButtons.forEach(button => {
        button.addEventListener('click', () => {
            paymentButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        });
    });

    // Form validation
    function validateForm() {
        let isValid = true;

        // Проверка обязательных полей
        inputs.forEach(input => {
            if (!input.value.trim()) { // Проверяем, что поле не пустое
                isValid = false;
                input.style.borderColor = ''; // Убираем подсветку
            } else {
                input.style.borderColor = ''; // Убираем подсветку
            }
        });

        // Дополнительная проверка для email
        const emailInput = document.getElementById('email');
        if (emailInput.value && !validateEmail(emailInput.value)) {
            isValid = false;
            emailInput.style.borderColor = '#ff0000'; // Подсветка поля email, если оно невалидно
        }

        // Проверка чекбокса "Согласие с условиями"
        if (!termsCheck.checked) {
            isValid = false;
            termsMessage.style.display = 'block'; // Показываем сообщение, если чекбокс не установлен
        } else {
            termsMessage.style.display = 'none'; // Скрываем сообщение, если чекбокс установлен
        }

        // Проверка чекбокса "Перезвоните мне"
        if (!callbackCheck.checked) {
            isValid = false;
            callbackWarning.style.display = 'block'; // Показываем сообщение, если чекбокс не установлен
        } else {
            callbackWarning.style.display = 'none'; // Скрываем сообщение, если чекбокс установлен
        }

        return isValid;
    }

    // Функция для проверки валидности email
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    // Input validation on change
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            if (input.value.trim()) {
                input.style.borderColor = ''; // Убираем подсветку, если поле заполнено
            }
            warningMessage.style.display = validateForm() ? 'none' : 'block';
        });
    });

    // Проверка чекбокса "Согласие с условиями" при изменении
    termsCheck.addEventListener('change', () => {
        if (termsCheck.checked) {
            termsMessage.style.display = 'none'; // Убираем предупреждение при активации чекбокса
        } else {
            termsMessage.style.display = 'block'; // Показываем предупреждение, если чекбокс не активирован
        }
        warningMessage.style.display = validateForm() ? 'none' : 'block';
    });

    // Проверка чекбокса "Перезвоните мне" при изменении
    callbackCheck.addEventListener('change', () => {
        if (callbackCheck.checked) {
            callbackWarning.style.display = 'none'; // Убираем предупреждение, если чекбокс активирован
        } else {
            callbackWarning.style.display = 'block'; // Показываем предупреждение, если чекбокс не активирован
        }
        warningMessage.style.display = validateForm() ? 'none' : 'block';
    });

    // Form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        if (validateForm()) {
            // Здесь вы обычно отправляете данные формы на сервер
            console.log('Form submitted successfully');
            warningMessage.style.display = 'none';

            // Сбор данных формы
            const formData = {
                phone: document.getElementById('phone').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                callback: callbackCheck.checked, // Используем чекбокс для подтверждения звонка
                termsAccepted: termsCheck.checked // Чекбокс для согласия с условиями
            };

            console.log('Form data:', formData);

            // Показ сообщения об успешном оформлении заказа
            alert('Заказ успешно оформлен!');
        } else {
            warningMessage.style.display = 'block';
        }
    });
});
