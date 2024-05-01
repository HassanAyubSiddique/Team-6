const { JSDOM } = require('jsdom');

// This logs the directory of the current test file
console.log(__dirname);

// Paste the full HTML content of your form into the jsdom constructor
const htmlContent = `<!DOCTYPE html>
<html>
<head>
    <title>Profile Update Form</title>
</head>
<body>
    <div class="profile-section">
        <h2 class="product-heading">Update Information</h2>
        <form id="updateForm" novalidate>
            <div class="profile-info">
                <div class="info-item">
                    <div class="form-group">
                        <label for="newFirstName">First Name:</label>
                        <input type="text" id="newFirstName" name="newFirstName" placeholder="First Name" required>
                        <div class="error-message error"></div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="form-group">
                        <label for="newLastName">Last Name:</label>
                        <input type="text" id="newLastName" name="newLastName" placeholder="Last Name" required>
                        <div class="error-message error"></div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="form-group">
                        <label for="newPhoneNumber">Phone Number:</label>
                        <input type="tel" id="newPhoneNumber" name="newPhoneNumber" placeholder="Phone Number" required pattern="\\d{10}">
                        <div class="error-message error"></div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="form-group">
                        <label for="newAddress">Address:</label>
                        <input type="text" id="newAddress" name="newAddress" placeholder="Address" required>
                        <div class="error-message error"></div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="form-group">
                        <label for="newCity">City:</label>
                        <input type="text" id="newCity" name="newCity" placeholder="City" required>
                        <div class="error-message error"></div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="form-group">
                        <label for="newCountry">Country:</label>
                        <input type="text" id="newCountry" name="newCountry" placeholder="Country" required>
                        <div class="error-message error"></div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="form-group">
                        <label for="newPostcode">Postcode:</label>
                        <input type="text" id="newPostcode" name="newPostcode" placeholder="Postcode" required>
                        <div class="error-message error"></div>
                    </div>
                </div>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
...`; // Your HTML content

// Create a JSDOM instance with your form HTML
const dom = new JSDOM(htmlContent);
const { window } = dom;

// Set global variables to simulate browser environment
global.document = window.document;
global.window = window;
global.navigator = {
    userAgent: 'node.js',
};

// Assuming FormValidator.js is stored in the js directory
const FormValidator = require('../JS/ADprofile'); // Adjust path as necessary

describe('FormValidator', () => {
    let formValidator;
    const form = document.getElementById('updateForm');

    beforeEach(() => {
        // Reset the document body to the initial HTML state before each test
        document.body.innerHTML = htmlContent; // Reset the DOM
        formValidator = new FormValidator(form, [
            'newFirstName', 'newLastName', 'newPhoneNumber', 'newAddress', 'newCity', 'newCountry', 'newPostcode'
        ]);
        formValidator.initialize();
    });

    test('Form prevents submission if fields are invalid', () => {
        const mockSubmit = jest.fn();
        form.submit = mockSubmit; // Mock the form submission

        form.dispatchEvent(new window.Event('submit', { cancelable: true }));

        expect(mockSubmit).not.toHaveBeenCalled();
    });

    test('Displays error when required field is empty', () => {
        const input = document.getElementById('newFirstName');
        input.value = ''; // Clear the input to simulate an empty field
        input.dispatchEvent(new window.Event('input'));

        const errorDiv = input.nextElementSibling;
        expect(errorDiv.textContent).toContain('is required');
        expect(input.classList.contains('errorInput')).toBe(true);
    });

    test('Form submits when all fields are valid', () => {
        // Populate all fields with valid data
        document.getElementById('newFirstName').value = 'John';
        document.getElementById('newLastName').value = 'Doe';
        document.getElementById('newPhoneNumber').value = '1234567890'; // Valid phone number
        document.getElementById('newAddress').value = '123 Baker St';
        document.getElementById('newCity').value = 'Metropolis';
        document.getElementById('newCountry').value = 'United States';
        document.getElementById('newPostcode').value = '12345';

        const mockSubmit = jest.fn();
        form.submit = mockSubmit; // Mock the form submission

        form.dispatchEvent(new window.Event('submit', { cancelable: true }));

        expect(mockSubmit).toHaveBeenCalled();
    });
});
