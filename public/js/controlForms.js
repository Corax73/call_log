export function controlForms(btn, form) {
    let click = false;
    btn.addEventListener('click', function (e) {
        if (!click) {
            form.style.display = 'block';
            click = true;
            e.preventDefault();
        } else if (click) {
            form.style.display = 'none';
            click = false;
            e.preventDefault();
        }
    });
}
