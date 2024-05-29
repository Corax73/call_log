import { controlForms } from "./controlForms.js";

const OperatorBtn = document.getElementById('operatorBtn');
const FormOperator = document.getElementById('formOperator');

const PhoneBtn = document.getElementById('phoneBtn');
const FormPhone = document.getElementById('formPhone');

const init = () => {
    if (OperatorBtn && FormOperator) {
        controlForms(OperatorBtn, FormOperator);
    }

    if (PhoneBtn && FormPhone) {
        controlForms(PhoneBtn, FormPhone);
    }
}

init();