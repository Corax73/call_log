import { controlForms } from "./controlForms.js";

const UsersStatisticsBtn = document.getElementById('usersStatisticsBtn');
const FormUsersStatistics = document.getElementById('formUsersStatistics');

const init = () => {
    if (UsersStatisticsBtn && FormUsersStatistics) {
        controlForms(UsersStatisticsBtn, FormUsersStatistics);
    }
}

init();