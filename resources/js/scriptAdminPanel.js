document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.adminPanelSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.adminPanelMainContent');

    // Sidebar Toggle
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });

    // Table row selection
    const checkboxes = document.querySelectorAll('.adminPanelTable input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const row = checkbox.closest('tr');
            if (checkbox.checked) {
                row.style.backgroundColor = '#f1f5f9';
            } else {
                row.style.backgroundColor = '';
            }
        });
    });

    // Filter functionality
    const filterBtn = document.querySelector('.adminPanelFilterBtn');
    const filterInputs = document.querySelectorAll('.adminPanelFilterItem input');

    filterBtn.addEventListener('click', () => {
        const filters = {};
        filterInputs.forEach(input => {
            filters[input.placeholder.toLowerCase()] = input.value.toLowerCase();
        });

        const rows = document.querySelectorAll('.adminPanelTable tbody tr');
        rows.forEach(row => {
            let shouldShow = true;
            const cells = row.querySelectorAll('td');

            // Skip checkbox and image columns
            for (let i = 2; i < cells.length - 1; i++) {
                const cellText = cells[i].textContent.toLowerCase();
                const filterKey = Object.keys(filters)[i - 2];

                if (filters[filterKey] && !cellText.includes(filters[filterKey])) {
                    shouldShow = false;
                    break;
                }
            }

            row.style.display = shouldShow ? '' : 'none';
        });
    });
});


document.getElementById("filterToggleButton").addEventListener("click", function() {
    var filterPanel = document.getElementById("filterPanel");
    // Переключаем видимость панели фильтров
    if (filterPanel.style.display === "none") {
        filterPanel.style.display = "block";
    } else {
        filterPanel.style.display = "none";
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("selectAll"); // Чекбокс "Выбрать все"
    const productCheckboxes = document.querySelectorAll(".adminPanelCheckbox"); // Все чекбоксы товаров
    const deleteBtn = document.getElementById("deleteSelectedBtn"); // Кнопка удаления
    const deleteForm = document.getElementById("deleteProductsForm"); // Форма удаления

    // Функция для показа/скрытия кнопки удаления
    function toggleDeleteButton() {
        const anyChecked = document.querySelector(".adminPanelCheckbox:checked"); // Проверяем, есть ли отмеченные
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
            if (!this.checked) {
                selectAllCheckbox.checked = false; // Если один снимаем, "Выбрать все" отключается
            }
            toggleDeleteButton();
        });
    });

    // Обработчик для удаления выбранных товаров
    deleteForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Останавливаем стандартную отправку

        const selectedProducts = Array.from(document.querySelectorAll(".adminPanelCheckbox:checked"))
            .map(checkbox => checkbox.value);

        if (selectedProducts.length === 0) {
            alert("Выберите хотя бы один товар для удаления!");
            return;
        }

        if (!confirm("Вы уверены, что хотите удалить выбранные товары?")) {
            return;
        }

        // Добавляем скрытые input'ы с ID товаров в форму перед отправкой
        selectedProducts.forEach(id => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "product_ids[]";
            input.value = id;
            deleteForm.appendChild(input);
        });

        deleteForm.submit(); // Отправляем форму
    });
});

