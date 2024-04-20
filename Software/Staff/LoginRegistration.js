const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

function validateForm(formSelector) {
    const form = document.querySelector(formSelector);
    const emailInput = form.querySelector('input[name="email"]');
    const phoneNumberInput = form.querySelector('input[name="phoneNumber"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmPasswordInput = form.querySelector('input[name="confirmPassword"]');
    const roleSelect = form.querySelector('select[name="role"]');
    let isValid = true;

    // Validate email
    const emailValue = emailInput.value.trim();
    if (emailValue === '' || !emailValue.includes('@')) {
        isValid = false;
        alert('Email must not be empty and must contain "@" symbol.');
    }

    // Validate phone number
    const phoneNumberValue = phoneNumberInput.value.trim();
    if (phoneNumberValue.length < 11) {
        isValid = false;
        alert('Phone number must contain at least 11 digits.');
    }

    // Validate password
    const passwordValue = passwordInput.value.trim();
    const confirmPasswordValue = confirmPasswordInput.value.trim();
    if (passwordValue.length < 8 || !/[A-Z]/.test(passwordValue) || !/\d/.test(passwordValue)) {
        isValid = false;
        alert('Password must be at least 8 characters long and contain at least one uppercase letter and one number.');
    } else if (passwordValue !== confirmPasswordValue) {
        isValid = false;
        alert('Password and confirm password must match.');
    }

    // Validate role selection
    const roleValue = roleSelect.value;
    if (roleValue === '') {
        isValid = false;
        alert('Please select your role.');
    }

    if (!isValid) {
        alert('Please fill in all fields correctly.');
    }

    return isValid;
}






document.querySelector('.sign-up-form').addEventListener('submit', function(event) {
    event.preventDefault();
    if (validateForm('.sign-up-form')) {
        alert('Validation successful. Sign-up form submitted.');
        // Uncomment the following line to submit the form
        // this.submit();
    }
});

document.querySelector('.sign-in-form').addEventListener('submit', function(event) {
    event.preventDefault();
    if (validateForm('.sign-in-form')) {
        alert('Validation successful. Sign-in form submitted.');
        // Uncomment the following line to submit the form
        // this.submit();
    }
});
