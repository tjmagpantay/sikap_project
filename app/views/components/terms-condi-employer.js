function showTerms(event) {
    if (event) event.preventDefault();
    if (typeof Swal === 'undefined') {
        alert('Terms and Conditions:\\n\\nBy accessing and using SIKAP, you agree to be bound by these Terms and Conditions.');
        return;
    }
    Swal.fire({
        title: 'Terms and Conditions',
        html: `
            <div class="text-left max-h-[350px] overflow-y-auto p-2 text-sm">
                <div class="mb-4"><b>1. Acceptance of Terms</b><br>By accessing and using SIKAP, you agree to be bound by these Terms and Conditions.</div>
                <div class="mb-4"><b>2. User Registration</b><br>Users must provide accurate, current, and complete information during registration.</div>
                <div class="mb-4"><b>3. User Conduct</b><br>Users agree to use the service responsibly and in compliance with all applicable laws.</div>
                <div class="mb-4"><b>4. Account Security</b><br>Users are responsible for maintaining the confidentiality of their account credentials.</div>
                <div class="mb-4"><b>5. Job Posting Guidelines</b><br>Employers must post legitimate job opportunities and provide accurate job descriptions.</div>
                <div class="mb-4"><b>6. Hiring Practices</b><br>Employers agree to fair and non-discriminatory hiring practices in compliance with employment laws.</div>
            </div>
        `,
        width: 600,
        confirmButtonText: 'I Understand',
        showCloseButton: true,
        customClass: {
            title: 'text-lg font-semibold',
            confirmButton: 'bg-secondary hover:bg-secondary/90 text-white px-4 py-2 rounded-lg text-sm',
            popup: 'terms-modal-popup rounded-xl shadow-lg',
            htmlContainer: 'text-sm leading-relaxed'
        }
    });
}

function showPrivacy(event) {
    if (event) event.preventDefault();
    if (typeof Swal === 'undefined') {
        alert('Privacy Policy:\\n\\nWe collect information you provide during registration and usage of SIKAP...');
        return;
    }
    Swal.fire({
        title: 'Privacy Policy',
        html: `
            <div class="text-left max-h-[350px] overflow-y-auto p-2 text-sm">
                <div class="mb-4"><b>1. Information We Collect</b><br>We collect information you provide during registration and usage of SIKAP.</div>
                <div class="mb-4"><b>2. How We Use Your Information</b><br>Your information is used to provide and improve our services, and communicate with you.</div>
                <div class="mb-4"><b>3. Information Security</b><br>We implement security measures to protect your personal information.</div>
                <div class="mb-4"><b>4. Data Sharing</b><br>We do not sell or share your personal information with third parties.</div>
                <div class="mb-4"><b>5. Employer Data</b><br>Employer information may be visible to job seekers for legitimate job search purposes.</div>
                <div class="mb-4"><b>6. Contact Information</b><br>We may use your contact information to send important updates about our services.</div>
            </div>
        `,
        width: 600,
        confirmButtonText: 'I Understand',
        showCloseButton: true,
        customClass: {
            title: 'text-lg font-semibold',
            confirmButton: 'bg-secondary hover:bg-secondary/90 text-white px-4 py-2 rounded-lg text-sm',
            popup: 'terms-modal-popup rounded-xl shadow-lg',
            htmlContainer: 'text-sm leading-relaxed'
        }
    });
}