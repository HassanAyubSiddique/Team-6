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

    document.querySelector('.sign-up-form').addEventListener('submit', function(event) {
        event.preventDefault();
        if (validateForm()) {
            alert('Validation successful. Form submitted.');
            // Uncomment the following line to submit the form
            // this.submit();
        }
    });

