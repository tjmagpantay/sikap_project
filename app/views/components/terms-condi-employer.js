function showTerms(event) {
    if (event) event.preventDefault();
    if (typeof Swal === 'undefined') {
        alert('Terms and Conditions:\\n\\nBy accessing and using SIKAP, you agree to be bound by these Terms and Conditions.');
        return;
    }
    Swal.fire({
        title: 'Terms and Conditions',
        html: `
            <div style="text-align:left; max-height:350px; overflow-y:auto; padding:8px;">
                <div style="margin-bottom:1rem;"><b>1. Acceptance of Terms</b><br>By accessing and using SIKAP, you agree to be bound by these Terms and Conditions.</div>
                <div style="margin-bottom:1rem;"><b>2. User Registration</b><br>Users must provide accurate, current, and complete information during registration.</div>
                <div style="margin-bottom:1rem;"><b>3. User Conduct</b><br>Users agree to use the service responsibly and in compliance with all applicable laws.</div>
                <div style="margin-bottom:1rem;"><b>4. Account Security</b><br>Users are responsible for maintaining the confidentiality of their account credentials.</div>
            </div>
        `,
        width: 600,
        confirmButtonText: 'I Understand',
        confirmButtonColor: '#10B981',
        showCloseButton: true,
        customClass: {
            popup: 'terms-modal-popup',
        }
    });
}

function showPrivacy(event) {
    if (event) event.preventDefault();
    if (typeof Swal === 'undefined') {
        alert('Privacy Policy:\\n\\nWe collect information you provide during registration and usage of SIKAP. Your information is used to provide and improve our services, and communicate with you. We implement security measures to protect your personal information. We do not sell or share your personal information with third parties.');
        return;
    }
    Swal.fire({
        title: 'Privacy Policy',
        html: `
            <div style="text-align:left; max-height:350px; overflow-y:auto; padding:8px;">
                <div style="margin-bottom:1rem;"><b>1. Information We Collect</b><br>We collect information you provide during registration and usage of SIKAP.</div>
                <div style="margin-bottom:1rem;"><b>2. How We Use Your Information</b><br>Your information is used to provide and improve our services, and communicate with you.</div>
                <div style="margin-bottom:1rem;"><b>3. Information Security</b><br>We implement security measures to protect your personal information.</div>
                <div style="margin-bottom:1rem;"><b>4. Data Sharing</b><br>We do not sell or share your personal information with third parties.</div>
            </div>
        `,
        width: 600,
        confirmButtonText: 'I Understand',
        confirmButtonColor: '#10B981',
        showCloseButton: true,
        customClass: {
            popup: 'terms-modal-popup',
        }
    });
}