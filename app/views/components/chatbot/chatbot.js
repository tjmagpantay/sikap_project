const SIKAP_FAQS = {
    jobseeker: [ 
        {
            q: "What is Sikap?",
            a: "Sikap is a web-based employment platform developed for PESO Rosario, Batangas. It uses machine learning to provide personalized job recommendations and helps job seekers, employers, and PESO staff streamline the job application and recruitment process."
        },
        {
            q: "Who can use Sikap?",
            a: "Sikap is open to:\n• Job seekers from Rosario and nearby areas looking for verified job opportunities\n• Employers who want to post job openings and find qualified applicants\n• PESO Rosario staff for managing job programs, tracking employment trends, and supporting job placement efforts"
        },
        {
            q: "How does the job recommendation system work?",
            a: "Sikap uses machine learning algorithms that analyze your profile, skills, and preferences to match you with the most suitable job postings. It uses techniques like content-based filtering to ensure personalized results based on your qualifications."
        }, 
        { 
            q: "Is Sikap free to use?",
            a: "Yes. Sikap is completely free for job seekers, employers, and PESO Rosario staff. It is a public service platform developed under the goals of the PESO Act of 1999 (RA 8759)."
        },
        {
            q: "How long does my job application stay active?",
            a: "Your job application remains active for 7 days. If the employer does not manage or respond to the application within that time, it will be automatically removed from the system to keep the platform clean and updated."
        },
        {
            q: "Can I track my job applications?",
            a: "Yes. Once registered, job seekers can track their application status in real time. You'll receive updates when:\n• Your application is viewed\n• You are shortlisted\n• An employer responds or schedules an interview"
        },
        {
            q: "What if I have questions while using Sikap?",
            a: "Sikap features a built-in chatbot that helps answer job-related questions, guide users through the platform, and assist with application steps. You can also reach out to PESO Rosario directly for further assistance."
        },
        {
            q: "Is my personal information safe?",
            a: "Yes. Sikap uses a secure authentication system and follows proper data protection practices to keep your information safe. Only verified users can access and manage their data."
        }
    ],
    employer: [
        {
            q: "How can employers use Sikap?",
            a: "Employers can:\n• Post job openings\n• Screen applicants\n• Communicate with candidates\n• Manage recruitment activities\n\nAll in one dashboard, designed for speed and simplicity.\n\n🔒 Note: Before an employer can post a job opening, they must complete all required verification documents. This ensures that all job postings on Sikap are legitimate, safe, and properly authorized by PESO Rosario."
        },
        {
            q: "What are the required documents for employer accreditation?",
            a: "Before posting job openings, employers must submit:\n• Letter of Intent (from Company)\n• Company Profile\n• Updated Business Permit\n• Certificate of No Pending Case (SEC/DOLE)\n• SEC or DOLE Registration\n• Certificate of No Objection (for local recruitment)\n• POEA Registration (for overseas recruitment)\n• List of Job Vacancies with Qualifications\n• Phil-JobNet Registration"
        },
        {
            q: "What kind of job programs are supported?",
            a: "Sikap supports PESO Rosario's participation in government programs such as:\n• SPES (Special Program for Employment of Students)\n• TUPAD (Tulong Panghanapbuhay sa Ating Disadvantaged/Displaced Workers)\n• GIP (Government Internship Program)\n\nThese programs are integrated into the platform for easier monitoring and reporting."
        },
        {
            q: "How does Sikap help PESO Rosario?",
            a: "Sikap gives PESO Rosario:\n• A powerful job facilitation tool\n• Access to labor market analytics\n• Visual dashboards to monitor placements and applicant performance\n• Automated systems to reduce manual workloads and improve program delivery"
        }
    ]
};

// Contact info removed since it's now directly in the formatBulletPoints function

function formatBulletPoints(text) {
    const parts = text.split('\n•');
    let messages = [];
    
    if (parts.length <= 1) {
        messages = [text];
    } else {
        // Add the introduction (text before first bullet point)
        messages.push(parts[0]);
        
        // Add each bullet point as a separate message
        for (let i = 1; i < parts.length; i++) {
            messages.push('• ' + parts[i].trim());
        }

        // Add any concluding text (after the last bullet point)
        const lastPart = parts[parts.length - 1];
        if (lastPart.includes('\n\n')) {
            const conclusion = lastPart.split('\n\n')[1];
            messages.push(conclusion);
        }
    }

    // Add contact info as a separate message
    messages.push('\nIf you have any inquiries, please feel free to contact us through our official <a href="https://www.facebook.com/profile.php?id=100072009206931" target="_blank" style="color: #3b82f6; text-decoration: underline;">Facebook page</a>.');

    return messages;
}

// Make SIKAP_FAQS available globally
window.SIKAP_FAQS = SIKAP_FAQS;