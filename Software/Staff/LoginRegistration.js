const sign_in_btn = document.querySelector(".sign-in-btn");
const sign_up_btn = document.querySelector(".sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
    console.log("Sign up button clicked");
    container.classList.add("sign-up-mode");
});

document.querySelector('#sign-in-btn').addEventListener('click', () => {
    console.log("Sign in button clicked");
    container.classList.remove("sign-up-mode");
});



// Validation function for sign-up form
function validateForm(formSelector) {
    const form = document.querySelector(formSelector);
    
    if (form.classList.contains('sign-up-form')) {
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
    } else {
        return true;
    }
}

// Event listener for sign-in button click
document.querySelector('#sign-in-btn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get the form elements
    const form = document.querySelector('.sign-in-form');
    const emailInput = form.querySelector('input[name="email"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const emailValue = emailInput.value.trim();
    const passwordValue = passwordInput.value.trim();

    // Perform basic client-side validation
    if (emailValue === '' || !emailValue.includes('@')) {
        alert('Email must not be empty and must contain "@" symbol.');
        return; // Prevent form submission if email is invalid
    }

    if (passwordValue === '') {
        alert('Please enter your password.');
        return; // Prevent form submission if password is empty
    }

    // If validation passes, submit the form
    form.submit();


    // Perform additional validation using validateForm function
    if (validateForm('.sign-in-form')) {
        // If form is valid, submit the form data via fetch
        fetch('login.php', {
            method: 'POST',
            body: new FormData(form) // Send form data
        })
        .then(response => {
            if (response.ok) {
                return response.text(); // Return response text
            } else {
                throw new Error('Network response was not ok.');
            }
        })
        .then(data => {
            // Check the response text for redirection
            if (data.trim() === 'client') {
                window.location.href = 'clientpage.html';
            } else if (data.trim() === 'staff') {
                window.location.href = 'staffpage.html';
            } else if (data.trim() === 'admin') {
                window.location.href = 'adminpage.html';
            } else {
                alert('User not found. Please check your credentials.');
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
});

