const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});


    function validateForm() {
        const inputs = document.querySelectorAll('.sign-up-form input');
        let isValid = true;

        inputs.forEach(input => {
            const value = input.value.trim();
            if (value === '') {
                isValid = false;
            }
        });

        if (!isValid) {
            alert('Please fill in all fields.');
        }

        return isValid;
    }

  
    
 


//this is for the testing purpose ok !......

document.addEventListener("DOMContentLoaded", function() {
    const signInForm = document.querySelector('.sign-in-form');
    const signUpForm = document.querySelector('.sign-up-form');

    signInForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission initially
        clearAllErrors(signInForm);
        if (validateSignInForm()) {
            signInForm.submit(); // Submit only if all validations pass
        }
    });

    signUpForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission initially
        clearAllErrors(signUpForm);
        if (validateSignUpForm()) {
            signUpForm.submit(); // Submit only if all validations pass
        }
    });
    

    function clearAllErrors(form) {
        const inputs = form.querySelectorAll('input');
        const errorMessages = form.querySelectorAll('.error-message'); // Assuming you have error message elements with this class
        inputs.forEach(clearErrors);
        errorMessages.forEach(error => {
            error.textContent = ''; // Clear any text content
            error.style.display = 'none'; // Hide the container
        });
    }


    function validateSignInForm() {
        const username = signInForm.querySelector('input[type="text"]');
        const password = signInForm.querySelector('input[type="password"]');
        let isValid = true; // Assume validity until proven otherwise

        isValid = checkFieldNotEmpty(username, "Username") && isValid;
        isValid = checkFieldNotEmpty(password, "Password") && isValid;
        
        if (isValid) {
            isValid = checkLength(username, 2, 50, "Username must be 2-50 characters long") && isValid;
            isValid = checkPasswordComplexity(password) && isValid;
        }

        return isValid;
    }

    function validateSignUpForm() {
        const inputs = signUpForm.querySelectorAll('input');
        let isValid = true; // Assume validity until proven otherwise

        // First pass: check all fields for non-emptiness
        inputs.forEach(input => {
            isValid = checkFieldNotEmpty(input, input.placeholder) && isValid;
        });

        // Second pass: detailed validation if all fields were non-empty
        if (isValid) {
            inputs.forEach(input => {
                const type = input.type;
                const value = input.value.trim();

                if (type === "text") {
                    isValid = checkLength(input, 2, 50, `${input.placeholder} must be 2-50 characters long`) && isValid;
                } else if (type === "password") {
                    if (input.placeholder === "Confirm Password") {
                        isValid = checkPasswordMatch(input, signUpForm.querySelector('input[placeholder="Password"]').value) && isValid;
                    } else {
                        isValid = checkPasswordComplexity(input) && isValid;
                    }
                } else if (type === "tel") {
                    isValid = checkPhoneNumber(input) && isValid;
                } else if (type === "email") {
                    isValid = validateEmail(value, input) && isValid;
                }
            });
        }

        return isValid;
    }

    function checkFieldNotEmpty(input, fieldName) {
        if (!input.value.trim()) {
            showError(input, `${fieldName} is required`, true);
            return false;
        }
        clearErrors(input);
        return true;
    }

    function checkLength(input, min, max, message) {
        if (input.value.trim().length < min || input.value.trim().length > max) {
            showError(input, message, false);
            return false;
        }
        return true;
    }

    function checkPasswordComplexity(input) {
        const password = input.value;
        const re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,50}$/;
        if (!re.test(password)) {
            showError(input, "Password must include 8-50 chars, upper, lower, number, & special char", false);
            return false;
        }
        return true;
    }

    function checkPasswordMatch(input, matchTo) {
        if (input.value !== matchTo) {
            showError(input, "Passwords do not match", false);
            return false;
        }
        return true;
    }

    function checkPhoneNumber(input) {
        const phone = input.value;
        const re = /^\d{10}$/;
        if (!re.test(phone)) {
            showError(input, "Enter a valid 10-digit phone number", false);
            return false;
        }
        return true;
    }

    function validateEmail(email, input) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(email)) {
            showError(input, "Enter a valid email", false);
            return false;
        }
        return true;
    }

    function showError(input, message, isPlaceholder) {
        if (isPlaceholder) {
            input.placeholder = message; // Show error message as placeholder
        } else {
            // Update both #sign-error-message and #error-message
            const signErrorContainer = document.querySelector('#sign-error-message');
            const errorContainer = document.querySelector('#error-message');
            
            if (signErrorContainer) {
                signErrorContainer.textContent = message; // Show error message
                signErrorContainer.style.display = 'block'; // Make the container visible
            }
            
            if (errorContainer) {
                errorContainer.textContent = message; // Show error message
                errorContainer.style.display = 'block'; // Make the container visible
            }
        }
        input.classList.add('error-input'); // Add error class to input
    }
    
    function clearErrors(input) {
        input.classList.remove('error-input'); // Remove error class from input
        
        // Clear both #sign-error-message and #error-message
        const signErrorContainer = document.querySelector('#sign-error-message');
        const errorContainer = document.querySelector('#error-message');
        
        if (signErrorContainer) {
            signErrorContainer.style.display = 'none'; // Hide the container
        }
        
        if (errorContainer) {
            errorContainer.style.display = 'none'; // Hide the container
        }
        
        input.placeholder = input.getAttribute('data-placeholder'); // Restore original placeholder
    }
    
    // Set initial placeholders to be restored later
    document.querySelectorAll('.input-field input', '.input-field textarea').forEach(input => {
        input.setAttribute('data-placeholder', input.placeholder);
    });
    

});

