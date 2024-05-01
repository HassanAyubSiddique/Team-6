const { JSDOM } = require('jsdom');
const fs = require('fs');
const path = require('path');

// jest.setup.js or at the top of your test file
const { TextEncoder, TextDecoder } = require('util');
global.TextEncoder = TextEncoder;
global.TextDecoder = TextDecoder;


// Make sure the path is correct relative to the test file
const htmlFilePath = path.resolve(__dirname, '../HTML/AdProfile.html');
const htmlContent = fs.readFileSync(htmlFilePath, 'utf-8');

const dom = new JSDOM(htmlContent);
const { window } = dom;
const { document } = window;

// Check the path to FormValidator to ensure it's being correctly imported
const FormValidator = require('../JS/ADprofile');

describe('FormValidator', () => {
    let form;
    let formValidator;

    beforeEach(() => {
        // Reinstantiate the DOM for each test to reset state
        document.body.innerHTML = htmlContent;
        form = document.getElementById('updateForm');
        if (!form) {
            throw new Error("The updateForm could not be found in the DOM.");
        }

        // Initialize form validator with a correct set of field IDs
        formValidator = new FormValidator(form, [
            'newFirstName', 'newLastName', 'newPhoneNumber', 'newAddress', 'newCity', 'newCountry', 'newPostcode'
        ]);
        formValidator.initialize();
    });

    test('Form prevents submission if fields are invalid', () => {
        const mockSubmit = jest.fn();
        form.submit = mockSubmit;

        // Simulate form submission
        form.dispatchEvent(new window.Event('submit', { cancelable: true }));

        expect(mockSubmit).not.toHaveBeenCalled();
    });

    test('Displays error when required field is empty', () => {
        const input = document.getElementById('newFirstName');
        input.value = ''; // Clear the input to simulate an empty field
        input.dispatchEvent(new window.Event('input'));

        const errorDiv = input.nextElementSibling;
        expect(errorDiv.textContent).toContain('is required');
        expect(input.classList.contains('errorInput')).toBetrue;
    });

    test('Form submits when all fields are valid', () => {
        // Set all inputs to valid values
        document.getElementById('newFirstName').value = 'John';
        document.getElementById('newLastName').value = 'Doe';
        document.getElementById('newPhoneNumber').value = '1234567890';
        document.getElementById('newAddress').value = '123 Baker St';
        document.getElementById('newCity').value = 'Metropolis';
        document.getElementById('newCountry').value = 'United States';
        document.getElementById('newPostcode').value = '12345';

        const mockSubmit = jest.fn();
        form.submit = mockSubmit;

        // Simulate form submission
        form.dispatchEvent(new window.Event('submit', { cancelable: true }));

        expect(mockSubmit).toHaveBeenCalled();
    });
});
