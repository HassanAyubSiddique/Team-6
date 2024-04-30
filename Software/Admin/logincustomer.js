// Get references to the existing button and new button elements
const existingBtn = document.getElementById('existingBtn');
const newBtn = document.getElementById('newBtn');

// Get references to the login form and register form elements
const loginForm = document.querySelector('.login form');
const registerForm = document.querySelector('.register form');

// Add event listener to the existing button
existingBtn.addEventListener('click', () => {
  // Hide the options element
  document.querySelector('.options').classList.add('hidden');
  // Show the login form
  document.querySelector('.login').classList.remove('hidden');
});

// Add event listener to the new button
newBtn.addEventListener('click', () => {
  // Hide the options element
  document.querySelector('.options').classList.add('hidden');
  // Show the register form
  document.querySelector('.register').classList.remove('hidden');
});
