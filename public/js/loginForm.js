import { controlForms } from "./controlForms.js";

const Login = document.getElementById('loginBtn');
const FormLogin = document.getElementById('formLogin');

const init = () => {
    if (Login && FormLogin) {
        controlForms(Login, FormLogin);
    }
}

init();