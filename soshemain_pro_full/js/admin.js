(function(){
    const chartCanvas = document.getElementById('trafficChart');
    if (chartCanvas && window.Chart) {
        const visits = JSON.parse(chartCanvas.dataset.visits || '[]');
        new Chart(chartCanvas, {
            type: 'line',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    label: 'Visits',
                    data: visits,
                    tension: 0.4,
                    borderColor: getComputedStyle(document.documentElement).getPropertyValue('--color-primary') || '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    document.addEventListener('click', (event) => {
        const editButton = event.target.closest('[data-edit]');
        if (editButton) {
            try {
                const formId = editButton.dataset.edit;
                const form = document.getElementById(formId);
                if (!form) throw new Error('Form not found');
                const collapse = form.closest('.collapse');
                if (collapse) {
                    const instance = bootstrap.Collapse.getOrCreateInstance(collapse, {toggle: false});
                    instance.show();
                }
                const fields = editButton.dataset.fields ? JSON.parse(editButton.dataset.fields) : {};
                Object.entries(fields).forEach(([key, value]) => {
                    const field = form.elements[key];
                    if (!field) return;
                    if (field.type === 'checkbox') {
                        field.checked = value === 1 || value === '1' || value === true;
                    } else if (field.type === 'datetime-local' && value) {
                        field.value = String(value).replace(' ', 'T');
                    } else {
                        field.value = value ?? '';
                    }
                    if (window.tinymce && field.classList.contains('tinymce-editor')) {
                        const editor = tinymce.get(field.id);
                        if (editor) {
                            editor.setContent(value || '');
                        }
                    }
                });
            } catch (error) {
                console.error('Unable to load item for editing', error);
            }
        }

        const resetButton = event.target.closest('[data-reset-form]');
        if (resetButton) {
            const form = document.getElementById(resetButton.dataset.resetForm);
            if (form) {
                form.reset();
                if (form.elements.id) {
                    form.elements.id.value = '';
                }
                if (window.tinymce) {
                    tinymce.editors.forEach((editor) => {
                        if (form.contains(editor.targetElm)) {
                            editor.setContent('');
                        }
                    });
                }
            }
        }
    });
})();
