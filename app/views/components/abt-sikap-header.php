<section
    class="relative w-full px-4 py-8 sm:px-6 md:px-16 lg:px-24 min-h-[650px] flex items-center"
    style="
background: linear-gradient(0deg, rgba(122,140,160,0.4), rgba(122,140,160,0.4)), 
            url('assets/images/abt-sikap-header.png');
    background-blend-mode: overlay;
    background-size: cover;
    background-position: center;
  ">

    <div class="w-full mx-auto max-w-7xl">
        <div class="relative flex flex-col items-center justify-center w-full text-center">
            <!-- Main Header -->
            <h1
                class="max-w-2xl mb-4 text-2xl font-extrabold leading-relaxed tracking-tight sm:text-2xl md:text-4xl lg:text-5xl animate-fade-in-up">
                <span class="text-blue-600">Sikap Employment Platform </span> <span class="text-primary">for Fast and Easier Job Application</span>
            </h1>


            <!-- Sub Header -->
            <p class="max-w-2xl mb-8 text-sm text-gray-600 md:text-sm animate-fade-in-up-delayed">
                Sikap is an initiative developed to streamline the job-seeking process for local residents. It promotes transparency and accessibility in government hiring, ensuring that every qualified applicant has equal opportunity to serve the community.
            </p>
        </div>
    </div>
</section>

<style>
    /* Animation Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animation Classes */
    .animate-fade-in-up {
        animation: fadeInUp 1s ease-out 0.3s both;
    }

    .animate-fade-in-up-delayed {
        animation: fadeInUp 1s ease-out 0.6s both;
    }

    .animate-fade-in-up-delayed-2 {
        animation: fadeInUp 1s ease-out 0.9s both;
    }
</style>