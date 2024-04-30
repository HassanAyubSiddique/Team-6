class FormValidator {
    constructor(form, fields) {
        if (!form) throw new Error("FormValidator requires a form element.");
        this.form = form;
        this.fields = fields || [];
    }

    initialize() {
        this.form.addEventListener('submit', (event) => {
            event.preventDefault();  // Prevent form submission initially
            this.clearAllErrors();
            const isFormValid = this.validateFields();
            if (isFormValid) {
                this.form.submit(); // Submit only if all validations pass
            }
        });

        this.fields.forEach(field => {
            const input = document.getElementById(field);
            if (!input) {
                console.warn(`Input field ${field} not found in the DOM.`);
                return;
            }
            input.addEventListener('input', () => {
                this.attemptClearErrors(input);  // Attempt to clear errors if user types anything
            });
        });
    }

    validateFields() {
        let allFieldsValid = true;
        this.fields.forEach(field => {
            const input = document.getElementById(field);
            if (!input) {
                console.warn(`Validation skipped for missing input field ${field}.`);
                return;
            }
            if (!input.value.trim()) {
                this.showError(input, `${this.getFieldName(field)} is required`, true);
                allFieldsValid = false;
            } else if (!this.checkFieldValidations(input)) {
                allFieldsValid = false; // Continue checking other validations if necessary
            }
        });
        return allFieldsValid;
    }

    checkFieldValidations(input) {
        switch (input.id) {
            case 'newFirstName':
            case 'newLastName':
                return this.checkLength(input, 2, 50);
            case 'newPhoneNumber':
                return this.checkPhoneNumber(input);
            case 'newPostcode':
                return this.checkLength(input, 5, 10);
            case 'newAddress':
                return this.checkAddress(input);
            case 'newCity':
                return this.checkCity(input);
            case 'newCountry':
                return this.checkCountry(input);
            default:
                return true; // No specific validations for other fields
        }
    }

    showError(input, message, isPlaceholder) {
        const errorDiv = input.nextElementSibling;
        if (!errorDiv || !errorDiv.classList.contains('error-message')) {
            console.error(`Error div not found for input ${input.id}`);
            return;
        }
        input.classList.add('errorInput');
        if (isPlaceholder) {
            input.classList.add('errorText');
            input.placeholder = message;
        } else {
            errorDiv.textContent = message;
            errorDiv.style.visibility = 'visible';  // Ensure error div is visible
        }
    }

    attemptClearErrors(input) {
        if (input.value.trim()) {
            this.clearErrors(input);
        }
    }

    clearAllErrors() {
        this.fields.forEach(field => {
            const input = document.getElementById(field);
            if (!input) {
                console.warn(`Clear errors skipped for missing input field ${field}.`);
                return;
            }
            this.clearErrors(input);
        });
    }

    clearErrors(input) {
        const errorDiv = input.nextElementSibling;
        if (!errorDiv || !errorDiv.classList.contains('error-message')) {
            console.error(`Error div not found for input ${input.id}`);
            return;
        }
        input.classList.remove('errorInput', 'errorText');
        input.placeholder = this.getOriginalPlaceholder(input.id);
        errorDiv.textContent = '';
        errorDiv.style.visibility = 'hidden';  // Hide the error div
    }

    checkLength(input, min, max) {
        if (input.value.trim().length < min || input.value.trim().length > max) {
            this.showError(input, `${this.getFieldName(input.id)} must be ${min}-${max} characters long`, false);
            return false;
        }
        return true;
    }

    checkPhoneNumber(input) {
        const phoneRegex = /^\d{10}$/;
        if (!phoneRegex.test(input.value.trim())) {
            this.showError(input, "Enter a valid 10-digit phone number", false);
            return false;
        }
        return true;
    }

    checkAddress(input) {
        const minLength = 10;
        const maxLength = 100;
        if (input.value.trim().length < minLength || input.value.trim().length > maxLength) {
            this.showError(input, `Address must be ${minLength}-${maxLength} characters long`, false);
            return false;
        }
        return true;
    }

    checkCity(input) {
        const cityRegex = /^[a-zA-Z\s\-]+$/;
        if (!cityRegex.test(input.value.trim())) {
            this.showError(input, "City name can only contain letters, spaces, and hyphens", false);
            return false;
        }
        if (input.value.trim().length < 2 || input.value.trim().length > 50) {
            this.showError(input, "City must be 2-50 characters long", false);
            return false;
        }
        return true;
    }

    checkCountry(input) {
        const validCountries = ["United States", "Canada", "United Kingdom", "Australia"];
        if (!validCountries.includes(input.value.trim())) {
            this.showError(input, "Invalid country selected", false);
            return false;
        }
        return true;
    }

    getFieldName(fieldId) {
        return fieldId.replace('new', '').replace(/([A-Z])/g, ' $1').trim(); // Formats the field name from ID
    }

    getOriginalPlaceholder(fieldId) {
        switch (fieldId) {
            case 'newFirstName': return "First Name";
            case 'newLastName': return "Last Name";
            case 'newPhoneNumber': return "Phone Number";
            case 'newAddress': return "Address";
            case 'newCity': return "City";
            case 'newCountry': return "Country";
            case 'newPostcode': return "Postcode";
            default: return "";
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('updateForm');
    if (!form) {
        console.error('Update form not found');
        return;
    }
    const fields = ['newFirstName', 'newLastName', 'newPhoneNumber', 'newAddress', 'newCity', 'newCountry', 'newPostcode'];
    const formValidator = new FormValidator(form, fields);
    formValidator.initialize();
});










class FormValidationPassword {
    constructor(form) {
        this.form = form;
        this.fields = ["oldPassword", "newPassword", "confirmPassword"];
        this.init();
    }

    init() {
        this.form.addEventListener("submit", (event) => {
            event.preventDefault();
            const isValid = this.validateFields();
            if (isValid) {
                this.form.submit(); // If no errors, submit the form
            }
        });
    }

    validateFields() {
        this.clearErrors(); // Reset placeholders before validation
        let isValid = true;
        this.fields.forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (!input.value.trim()) { // If field is empty
                input.classList.add('error');
                input.placeholder = `${this.getFieldName(fieldId)} is required`; // Set error message in placeholder
                isValid = false;
            }
        });
        return isValid;
    }

    clearErrors() {
        this.fields.forEach(fieldId => {
            const input = document.getElementById(fieldId);
            input.classList.remove('error'); // Remove error styling class if present
            input.placeholder = this.getOriginalPlaceholder(fieldId); // Reset to original placeholder
        });
    }

    getFieldName(fieldId) {
        // Convert field id to readable form
        switch(fieldId) {
            case 'oldPassword': return 'Old Password';
            case 'newPassword': return 'New Password';
            case 'confirmPassword': return 'Confirm Password';
            default: return '';
        }
    }

    getOriginalPlaceholder(fieldId) {
        // Provide the original placeholder text based on field id
        switch(fieldId) {
            case 'oldPassword': return 'Old Password';
            case 'newPassword': return 'New Password';
            case 'confirmPassword': return 'Confirm Password';
            default: return '';
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const changePasswordForm = document.getElementById("changePasswordForm");
    new FormValidationPassword(changePasswordForm);
});


