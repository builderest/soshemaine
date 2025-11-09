(function () {
    document.querySelectorAll('[data-editor]').forEach(el => {
        if (window.tinymce) {
            tinymce.init({ selector: '#' + el.id, menubar: false, plugins: 'link lists code table', toolbar: 'undo redo | bold italic underline | bullist numlist | link | code | table' });
        }
    });
})();
