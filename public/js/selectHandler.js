const Select = document.getElementById('selectUser');
const UserPhonePlaceholder = document.getElementById('userPhone');

const TransferringData = (select, userPhonePlaceholder) => {
    if (select && userPhonePlaceholder && allPhoneNumbers) {
        select.addEventListener('change', (event) => {
            let arrPhoneNumbers = JSON.parse(allPhoneNumbers);
            search = arrPhoneNumbers.filter(function (number) {
                return number.user_id == event.target.value;
            });
            userPhonePlaceholder.placeholder = search[0].number;
        });
    }
}

const init = () => {
    if (Select && UserPhonePlaceholder) {
        TransferringData(Select, UserPhonePlaceholder);
    }
}

init();
