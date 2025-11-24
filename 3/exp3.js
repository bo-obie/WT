
const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');


form.addEventListener('submit', (e) => {
    e.preventDefault(); // Prevents the form from submitting
    
    validateInputs(); // Call our main validation function
});


function validateInputs() {
    
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    // --- Username Validation ---
    if (usernameValue === '') {
        // Show error and set error message
        setError(username, 'Username is required');
    } else {
        // Show success
        setSuccess(username);
    }

    // --- Email Validation ---
    if (emailValue === '') {
        setError(email, 'Email is required');
    } else if (!isValidEmail(emailValue)) {
        setError(email, 'Provide a valid email address');
    } else {
        setSuccess(email);
    }
    
    // --- Password Validation ---
    if (passwordValue === '') {
        setError(password, 'Password is required');
    } else if (passwordValue.length < 8) {
        setError(password, 'Password must be at least 8 characters.');
    } else {
        setSuccess(password);
    }

    // --- Confirm Password Validation ---
    if (password2Value === '') {
        setError(password2, 'Please confirm your password');
    } else if (password2Value !== passwordValue) {
        setError(password2, "Passwords don't match");
    } else {
        setSuccess(password2);
    }
}


function setError(input, message) {
    const formControl = input.parentElement; // .form-control div
    const small = formControl.querySelector('small');
    
    // Add error message and error class
    small.innerText = message;
    formControl.className = 'form-control error';
}


function setSuccess(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
}

function isValidEmail(email) {
    // A simple regex for email validation
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

