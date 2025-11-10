    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editors = document.querySelectorAll('[data-editor="wysiwyg"]');
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '[data-editor="wysiwyg"]',
                    plugins: 'link lists table code media',
                    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link media | code',
                    height: 320,
                });
            }
        });
    </script>
</body>
</html>
