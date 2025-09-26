<section
    class="relative w-full px-4 py-8 sm:px-6 md:px-16 lg:px-24 min-h-[650px] flex items-center"
    style="
background: linear-gradient(0deg, rgba(122,140,160,0.4), rgba(122,140,160,0.4)), 
            url('assets/images/hero-page-bg.png');
    background-blend-mode: overlay;
    background-size: cover;
    background-position: center;
  ">

    <div class="w-full mx-auto max-w-7xl">
        <div class="relative flex flex-col items-center justify-center w-full text-center">
            <!-- Main Header -->
            <h1 class="max-w-3xl mb-4 text-2xl font-bold sm:text-3xl md:text-4xl lg:text-5xl animate-fade-in-up" style="background: linear-gradient(to top right, #1567B2, #092C4C); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Public Employment Service Office (PESO) Rosario Batangas
            </h1>

            <!-- Sub Header -->
            <p class="max-w-2xl mb-8 text-sm md:text-sm text-primary animate-fade-in-up-delayed">
                The Public Employment Service Office (PESO) in Rosario, Batangas provides free employment services, career guidance, and job matching to connect jobseekers with opportunities both locally and abroad.
            </p>

            <div class="flex flex-row gap-4 mt-4 animate-fade-in-up-delayed-2">
                <a href="https://peis.philjobnet.ph/" target="_blank"
                    class="px-6 py-3 text-sm font-medium text-white transition-colors duration-300 rounded-md bg-primary hover:bg-blue-700">
                    ABOUT PESO
                </a>
                <a href="https://www.lgurosariobatangas.com/" target="_blank"
                    class="px-6 py-3 text-sm font-medium transition-colors duration-300 bg-gray-100 rounded-md text-primary hover:bg-blue-800">
                    ABOUT ROSARIO
                </a>
            </div>


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