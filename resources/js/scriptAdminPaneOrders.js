document.addEventListener('DOMContentLoaded', () => {
    const filterToggleButton = document.getElementById('filterToggleButton');
    const filterPanel = document.getElementById('filterPanel');

    // Обработчик для кнопки "Фильтр"
    if (filterToggleButton && filterPanel) {
        filterToggleButton.addEventListener('click', () => {
            // Переключаем видимость блока фильтров
            if (filterPanel.style.display === 'none' || filterPanel.style.display === '') {
                filterPanel.style.display = 'block';
            } else {
                filterPanel.style.display = 'none';
            }
        });
    }

    const selectAllCheckbox = document.getElementById('selectAll'); // Исправлено: id="selectAll"
    const allCheckboxes = document.querySelectorAll('.adminPanelTable tbody .adminPanelCheckbox');

    // Обработчик для "Выбрать все"
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            toggleDeleteButton();
        });
    }

    // Обработчики для остальных чекбоксов
    allCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Если какой-то чекбокс снят, снимаем "Выбрать все"
            if (!checkbox.checked && selectAllCheckbox.checked) {
                selectAllCheckbox.checked = false;
            }
            toggleDeleteButton();
        });
    });
});

// Функция для отображения кнопки "Удалить выбранное"
function toggleDeleteButton() {
    const selectedCheckboxes = document.querySelectorAll('.adminPanelTable tbody .adminPanelCheckbox:checked');
    const deleteBtn = document.getElementById('deleteSelectedBtn');

    if (selectedCheckboxes.length > 0) {
        deleteBtn.style.display = 'inline-block';
    } else {
        deleteBtn.style.display = 'none';
    }
}
