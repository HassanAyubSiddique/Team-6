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
    const passwordInput = form.querySelector('input[type="password"]');
    let isValid = true;

    // Validate username
    const emailValue = emailInput.value.trim();
    if (emailValue === '' || !emailValue.includes('@')) {
        isValid = false;
        alert('Email must not be empty and must contain "@" symbol.');
    }

    // Validate password
    const passwordValue = passwordInput.value.trim();
    if (passwordValue === '') {
        isValid = false;
        alert('Password must not be empty.');
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
