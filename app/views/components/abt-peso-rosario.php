<section class="relative flex flex-col items-center justify-between w-full min-h-screen gap-8 px-4 py-12 bg-white md:flex-row sm:px-6 md:px-16 lg:px-24">

    <div class="flex flex-col md:flex-row justify-between w-full gap-8 bg-primary text-white rounded-xl mx-auto p-16 min-h-[500px]">

        <div class="flex flex-col items-start justify-start w-full align-text-top">
            <h2 class="mb-4 text-3xl font-bold">PESO Rosario</h2>
            <p class="w-full mb-6 text-sm leading-relaxed text-justify text-gray-300 md:w-3/4">
                PESO Rosario is a local government employment service facility in Rosario, Batangas, established under the PESO Act of 1999. It connects job seekers with employers through job fairs, skills training, and job matching services, aiming to reduce unemployment and support career development in the community.
            </p>
            <p class="w-full mb-6 text-sm leading-relaxed text-justify text-gray-300 md:w-3/4">
                The office also implements programs like SPES, TUPAD, and GIP to assist students, displaced workers, and fresh graduates. Through these initiatives, PESO Rosario continues to promote inclusive employment and economic growth in the municipality.
            </p>
            <a href="#" class="bg-yellow-400 btn-primary w-fit text-primary hover:bg-yellow-300">Learn More</a>
        </div>

        <!-- Image Grid -->
        <div class="lg:w-1/2">
            <div class="grid grid-cols-2 grid-rows-2 gap-4 h-[400px] lg:h-[500px]">
                <!-- Main Image -->
                <div class="relative row-span-2 overflow-hidden rounded-xl group">
                    <img src="assets/images/abt-rosario-1.jpg" alt="PESO Rosario"
                        class="object-cover w-full h-full transition-all duration-500 ease-out transform group-hover:scale-105"
                        data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>

                <!-- Secondary Images -->
                <div class="relative overflow-hidden rounded-xl group">
                    <img src="assets/images/abt-rosario-2.jpg" alt="Building 1"
                        class="object-cover w-full h-full transition-all duration-500 ease-out transform group-hover:scale-105"
                        data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>

                <div class="relative overflow-hidden rounded-xl group">
                    <img src="assets/images/abt-rosario-3.jpg" alt="Building 2"
                        class="object-cover w-full h-full transition-all duration-500 ease-out transform group-hover:scale-105"
                        data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-out-quad',
        once: true
    });
</script>