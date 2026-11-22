document.querySelectorAll('[data-gallery-image-picker]').forEach((select) => {
    const container = select.closest('.mb-6');
    const preview = container?.querySelector('[data-gallery-image-preview]');

    if (!preview) {
        return;
    }

    select.addEventListener('change', () => {
        const option = select.selectedOptions[0];
        const imageUrl = option?.dataset.previewUrl || '';

        preview.src = imageUrl;
        preview.style.display = imageUrl === '' ? 'none' : '';
    });
});

