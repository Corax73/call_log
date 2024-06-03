let select = document.getElementById('selectUser');
let userPhonePlaceholder = document.getElementById('userPhone');

select.addEventListener('change', (event) => {
    let arrPhoneNumbers = JSON.parse(allPhoneNumbers);
    search = arrPhoneNumbers.filter(function (number) {
        return number.user_id == event.target.value;
    });
    userPhonePlaceholder.placeholder = search[0].number;
});