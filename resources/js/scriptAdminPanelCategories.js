document.addEventListener("DOMContentLoaded", function () {
    const filterToggleButton = document.getElementById("filterToggleButton");
    const filterPanel = document.getElementById("filterPanel");

    // Обработчик для кнопки "Фильтр"
    if (filterToggleButton && filterPanel) {
        console.log("Элементы найдены!"); // Проверка, что элементы найдены

        filterToggleButton.addEventListener("click", function () {
            console.log("Кнопка нажата!"); // Проверка, что событие срабатывает

            if (filterPanel.style.display === "none" || filterPanel.style.display === "") {
                filterPanel.style.display = "block";
                console.log("Панель показана");
            } else {
                filterPanel.style.display = "none";
                console.log("Панель скрыта");
            }
        });
    } else {
        console.error("Элементы не найдены!"); // Если элементы не найдены
    }

    // Остальной код (чекбоксы, удаление и т.д.)
    const selectAllCheckbox = document.getElementById("adminPanelCheckbox");
    const productCheckboxes = document.querySelectorAll(".adminPanelCheckbox");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    const deleteForm = document.getElementById("deleteCategoriesForm");

    // Функция для показа/скрытия кнопки удаления
    function toggleDeleteButton() {
        const anyChecked = document.querySelector(".adminPanelCheckbox:checked");
        deleteBtn.style.display = anyChecked ? "inline-block" : "none";
    }

    // Обработчик на "Выбрать все"
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener("change", function () {
            productCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
            toggleDeleteButton();
        });
    }

    // Обработчик для каждого чекбокса товара
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            if (!this.checked && selectAllCheckbox.checked) {
                selectAllCheckbox.checked = false; // Если один снимаем, "Выбрать все" отключается
            }
            toggleDeleteButton();
        });
    });

    // Обработчик для удаления выбранных товаров
    if (deleteForm) {
        deleteForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Останавливаем стандартную отправку

            const selectedProducts = Array.from(document.querySelectorAll(".adminPanelCheckbox:checked"))
                .map(checkbox => checkbox.value);

            if (selectedProducts.length === 0) {
                alert("Выберите хотя бы одну категорию для удаления!");
                return;
            }

            // Подтверждение удаления
            if (!confirm("Вы уверены, что хотите удалить выбранные категории?")) {
                return; // Если пользователь нажал "Отмена", прерываем выполнение
            }

            // Добавляем скрытые input'ы с ID категорий в форму перед отправкой
            selectedProducts.forEach(id => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "category_ids[]";
                input.value = id;
                deleteForm.appendChild(input);
            });

            deleteForm.submit(); // Отправляем форму
        });
    }
});
