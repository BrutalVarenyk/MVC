let tableAddInformation = document.querySelector('.table-add-information');
let insertForm = document.querySelector('.form-insert');

tableAddInformation.addEventListener('click', function () {

    let fields = insertForm.querySelectorAll('.field')

    for (let i = 0; i < fields.length; i++) {
        if (!fields[i].value) {
            document.querySelector('.result').innerHTML = "Please fill in all information about user";
            // console.log('field is blank', fields[i]);
            return;
        }
    }
});

function check_pass() {
    let ver = document.querySelector('.password_verification');
    if (document.querySelector('.password').value ===
        document.querySelector('.confirm_password').value) {
        ver.innerHTML = "Passwords do not match";
        tableAddInformation.disabled = false;
    } else {
        ver.innerHTML = '';
        tableAddInformation.disabled = true;
    }
}