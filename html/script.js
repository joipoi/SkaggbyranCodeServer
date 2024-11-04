document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('edit-button');
    const confirmButton = document.getElementById('confirm-button');
    const cancelButton = document.getElementById('cancel-button');
    const projectNameDisplay = document.getElementById('project-name-display');
    const newProjectNameInput = document.getElementById('new_project_name');

    editButton.onclick = function() {
        projectNameDisplay.style.display = 'none';
        newProjectNameInput.style.display = 'inline';
        confirmButton.style.display = 'inline';
        cancelButton.style.display = 'inline';
        newProjectNameInput.value = projectNameDisplay.textContent; // Pre-fill input
    };

    confirmButton.onclick = function() {
        const newProjectName = newProjectNameInput.value.trim();
        if (newProjectName) {
            // Submit the new project name via a form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'project_view.php?user=' + encodeURIComponent(username) + '&project=' + encodeURIComponent(projectName);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'new_project_name';
            input.value = newProjectName;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    };

    cancelButton.onclick = function() {
        projectNameDisplay.style.display = 'inline';
        newProjectNameInput.style.display = 'none';
        confirmButton.style.display = 'none';
        cancelButton.style.display = 'none';
    };
});
