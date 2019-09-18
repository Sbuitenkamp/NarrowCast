const validationMessage = document.getElementById("validation-message");
const username = document.getElementById("validate-username");
const password = document.getElementById("validate-password");

function validateForm() {
    if (username.value == "" || username.value == null) {
        validationMessage.innerText = "Vul uw gebruikersnaam in.";
        return false;
    } else if (password.value == "" || password.value == null) {
        validationMessage.innerText = "Vul uw wachtwoord in.";
        return false;
    }

    return true;
}