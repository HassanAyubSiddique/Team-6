

// Correct path to the HTML file
const htmlFilePath = path.resolve(__dirname, "../HTML/ADprofile.html"); //  HTML file is named index.html, adjust as necessary
const htmlContent = fs.readFileSync(htmlFilePath, "utf-8");

const { window } = new JSDOM(htmlContent);
global.document = window.document;
global.window = window;
global.navigator = { userAgent: 'node.js' };

// Correct path to the JavaScript class
const FormValidationPassword = require("../JS/FormValidationPassword");

describe("FormValidationPassword", () => {
    let form;
    let formValidator;

    beforeEach(() => {
        document.body.innerHTML = htmlContent; // Reset the DOM to its initial state
        form = document.getElementById("changePasswordForm");
        formValidator = new FormValidationPassword(form);
    });

    test("Form prevents submission if fields are invalid", () => {
        const mockSubmit = jest.fn();
        form.submit = mockSubmit; // Mock the form submission

        form.dispatchEvent(new window.Event("submit", { cancelable: true }));

        expect(mockSubmit).not.toHaveBeenCalled();
    });

    test("Displays error when required field is empty", () => {
        const input = document.getElementById('oldPassword');
        input.value = ''; // Clear the input to simulate an empty field
        input.dispatchEvent(new window.Event('input'));

        expect(input.classList.contains('error')).toBeTruthy();
        expect(input.placeholder).toBe('Old Password is required');
    });

    test("Form submits when all fields are valid", () => {
        document.getElementById('oldPassword').value = 'password123';
        document.getElementById('newPassword').value = 'newpassword123';
        document.getElementById('confirmPassword').value = 'newpassword123';

        const mockSubmit = jest.fn();
        form.submit = mockSubmit; // Mock the form submission

        form.dispatchEvent(new window.Event('submit', { cancelable: true }));

        expect(mockSubmit).toHaveBeenCalled();
    });
});
