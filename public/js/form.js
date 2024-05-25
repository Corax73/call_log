const Login = document.getElementById('loginBtn');
const FormLogin = document.getElementById('formLogin');

const ControlLoginForm = () => {
    let click = false;
    Login.addEventListener('click', function (e) {
        if (!click) {
            FormLogin.style.display = 'block';
            click = true;
            e.preventDefault();
        } else if (click) {
            FormLogin.style.display = 'none';
            click = false;
            e.preventDefault();
        }
    });
}

const init = () => {
    if (Login && FormLogin) {
        ControlLoginForm();
    }
}

init();