document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector(".adminPanelSidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const filterPanel = document.getElementById("filterPanel");
    const filterToggleButton = document.getElementById("filterToggleButton");
    const selectAllCheckbox = document.getElementById("selectAll");
    const customerCheckboxes = document.querySelectorAll(".adminPanelCheckbox");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    const deleteForm = document.getElementById("deleteCustomersForm"); // Исправлено на deleteCustomersForm

    // Переключение сайдбара
    sidebarToggle.addEventListener("click", () => {
        sidebar.classList.toggle("open");
    });

    document.addEventListener("click", (e) => {
        if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
            sidebar.classList.remove("open");
        }
    });

    // Переключение фильтра
    filterToggleButton.addEventListener("click", () => {
        filterPanel.style.display = filterPanel.style.display === "none" ? "block" : "none";
    });

    // Выделение строк при выборе чекбоксов
    customerCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", () => {
            const row = checkbox.closest("tr");
            row.style.backgroundColor = checkbox.checked ? "#f1f5f9" : "";
            toggleDeleteButton();
        });
    });

    // Выбрать все / Снять все
    selectAllCheckbox.addEventListener("change", () => {
        customerCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
            checkbox.closest("tr").style.backgroundColor = checkbox.checked ? "#f1f5f9" : "";
        });
        toggleDeleteButton();
    });

    // Функция показа/скрытия кнопки удаления
    function toggleDeleteButton() {
        deleteBtn.style.display = document.querySelector(".adminPanelCheckbox:checked") ? "inline-block" : "none";
    }

    // Удаление выбранных клиентов
    deleteForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const selectedCustomers = Array.from(customerCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        if (selectedCustomers.length === 0) {
            alert("Выберите хотя бы одного клиента для удаления!");
            return;
        }

        // Подтверждение удаления
        if (!confirm("Вы уверены, что хотите удалить выбранных клиентов?")) {
            return; // Если пользователь нажал "Отмена", прерываем выполнение
        }

        // Добавляем скрытые input'ы с ID клиентов в форму перед отправкой
        selectedCustomers.forEach(id => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "customers_ids[]";
            input.value = id;
            deleteForm.appendChild(input);
        });

        deleteForm.submit(); // Отправляем форму
    });
});
