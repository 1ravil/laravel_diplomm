document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector(".adminPanelSidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const filterPanel = document.getElementById("filterPanel");
    const filterToggleButton = document.getElementById("filterToggleButton");
    const selectAllCheckbox = document.getElementById("selectAll");
    const productCheckboxes = document.querySelectorAll(".adminPanelCheckbox");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    const deleteForm = document.getElementById("deleteUserForm");

    // Переключение бокового меню
    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("open");
        });
    }

    // Закрытие бокового меню при клике вне (на мобилках)
    document.addEventListener("click", (e) => {
        if (window.innerWidth <= 768 && sidebar && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
            sidebar.classList.remove("open");
        }
    });

    // Переключение панели фильтров
    if (filterToggleButton && filterPanel) {
        filterToggleButton.addEventListener("click", () => {
            filterPanel.style.display = filterPanel.style.display === "none" ? "block" : "none";
        });
    }

    // Обработчик выбора строк таблицы
    productCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            const row = checkbox.closest("tr");
            row.style.backgroundColor = checkbox.checked ? "#f1f5f9" : "";
            toggleDeleteButton();
        });
    });

    // Обработчик "Выбрать все"
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener("change", () => {
            productCheckboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
                checkbox.closest("tr").style.backgroundColor = checkbox.checked ? "#f1f5f9" : "";
            });
            toggleDeleteButton();
        });
    }

    // Функция переключения кнопки удаления
    function toggleDeleteButton() {
        const anyChecked = document.querySelector(".adminPanelCheckbox:checked");
        if (deleteBtn) deleteBtn.style.display = anyChecked ? "inline-block" : "none";
    }

    // Обработчик удаления пользователей
    if (deleteForm) {
        deleteForm.addEventListener("submit", (event) => {
            event.preventDefault();

            const selectedUsers = Array.from(document.querySelectorAll(".adminPanelCheckbox:checked"))
                .map((checkbox) => checkbox.value);

            if (selectedUsers.length === 0) {
                alert("Выберите хотя бы одного пользователя для удаления!");
                return;
            }

            if (!confirm("Вы уверены, что хотите удалить выбранных пользователей?")) {
                return;
            }

            // Добавляем скрытые input'ы с ID пользователей в форму перед отправкой
            selectedUsers.forEach((id) => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "users_ids[]";
                input.value = id;
                deleteForm.appendChild(input);
            });

            deleteForm.submit();
        });
    }

    // Функция фильтрации пользователей
    const filterBtn = document.querySelector(".adminPanelFilterBtn");
    const filterInputs = document.querySelectorAll(".adminPanelFilterItem input");

    if (filterBtn) {
        filterBtn.addEventListener("click", () => {
            const filters = {};
            filterInputs.forEach((input) => {
                filters[input.placeholder.toLowerCase()] = input.value.toLowerCase();
            });

            const rows = document.querySelectorAll(".adminPanelTable tbody tr");
            rows.forEach((row) => {
                let shouldShow = true;
                const cells = row.querySelectorAll("td");

                for (let i = 2; i < cells.length - 1; i++) {
                    const cellText = cells[i].textContent.toLowerCase();
                    const filterKey = Object.keys(filters)[i - 2];

                    if (filters[filterKey] && !cellText.includes(filters[filterKey])) {
                        shouldShow = false;
                        break;
                    }
                }

                row.style.display = shouldShow ? "" : "none";
            });
        });
    }
});
