function sbscrdClickButton() {
    let a = document.querySelector('.i-1').value;
    let b = document.querySelector('.i-2').value;
    let name1 = document.querySelector('#name1');
    let email1 = document.querySelector('#email1');

    if (!a && !b) {
        alert("Вы не ввели имя и электронную почту");
    } else {
        if (!a) {
            alert("Вы не ввели имя");
        }
        if (!b) {
            alert("Вы не ввели электронную почту");
        }
        if (a && b) {
            name1.innerHTML = a;
            email1.innerHTML = b;
            document.getElementById("my-modal").classList.add("open");
        }
    }
}

// Добавляем обработчики событий после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    const closeModalBtn = document.getElementById("close-my-model-btn");
    const modal = document.getElementById("my-modal");
    const subscribeButton = document.getElementById("open-modal-btn");

    // Добавляем обработчик события для кнопки подписки
    subscribeButton.addEventListener("click", sbscrdClickButton);

    closeModalBtn.addEventListener("click", () => {
        modal.classList.remove("open");
    });

    // Закрыть модальное окно при нажатии на Esc
    window.addEventListener('keydown', (e) => {
        if (e.key === "Escape") {
            modal.classList.remove("open");
        }
    });

    // Закрыть модальное окно при клике вне его
    modal.addEventListener('click', (event) => {
        if (event.target === modal) { // Проверка на клик вне контента модального окна
            modal.classList.remove('open');
        }
    });
});





















