document.addEventListener('DOMContentLoaded', function() {
    console.log('Real-time validation initialized');
    
    const form = document.querySelector('form');
    
    // Validation rules with regex patterns and messages
    const validationRules = {
        first_name: { 
            pattern: /^[A-Za-z]{2,}$/,
            message: 'First name must contain only letters and be at least 2 characters'
        },
        last_name: {
            pattern: /^[A-Za-z]{2,}$/,
            message: 'Last name must contain only letters and be at least 2 characters'
        },
        contact_number: {
            pattern: /^(09|\+639)\d{9}$/,
            message: 'Please enter a valid Philippine mobile number (e.g., 09123456789)'
        },
        email: {
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            message: 'Please enter a valid email address'
        },
        password: {
            pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
            message: 'Password must contain at least 8 characters, including uppercase, lowercase, number and special character'
        }
    };

    // Create error container for each input
    function createErrorContainer(input) {
        const container = document.createElement('div');
        container.className = 'hidden mt-1 text-xs text-red-500 error-container';
        container.id = `${input.id}-error`;
        input.parentNode.appendChild(container);
    }

    // Initialize error containers
    document.querySelectorAll('input').forEach(input => {
        createErrorContainer(input);
    });

    // Validate single field
    function validateField(input) {
        const errorContainer = document.getElementById(`${input.id}-error`);
        
        // Special handling for confirm password
        if (input.id === 'confirm_password') {
            const password = document.getElementById('password');
            if (input.value !== password.value) {
                showError(input, errorContainer, 'Passwords do not match');
                return false;
            }
            hideError(input, errorContainer);
            return true;
        }

        // Regular field validation
        const rule = validationRules[input.id];
        if (rule && input.value) {
            if (!rule.pattern.test(input.value)) {
                showError(input, errorContainer, rule.message);
                return false;
            }
            hideError(input, errorContainer);
            return true;
        }
        return true;
    }

    // Show error message
    function showError(input, container, message) {
        container.textContent = message;
        container.classList.remove('hidden');
        input.classList.add('border-red-500');
        input.classList.remove('border-green-500');
    }

    // Hide error message
    function hideError(input, container) {
        container.classList.add('hidden');
        input.classList.remove('border-red-500');
        input.classList.add('border-green-500');
    }

    // Real-time validation on input
    document.querySelectorAll('input').forEach(input => {
        ['input', 'blur'].forEach(eventType => {
            input.addEventListener(eventType, () => {
                validateField(input);
                
                // Special handling for confirm password when password changes
                if (input.id === 'password') {
                    const confirmPassword = document.getElementById('confirm_password');
                    if (confirmPassword.value) {
                        validateField(confirmPassword);
                    }
                }
            });
        });
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate all fields
        document.querySelectorAll('input').forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('.error-container:not(.hidden)');
            if (firstError) {
                firstError.previousElementSibling.focus();
            }
        }

        const termsCheckbox = document.getElementById('terms');
        
        if (!termsCheckbox.checked) {
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'You must accept the Terms and Conditions to continue',
                icon: 'error',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#EF4444'
            });
        }
    });
});