<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oneshare2care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        .hero-container {
            position: relative;
            height: 100vh;
            min-height: 500px;
            overflow: hidden;
        }
        
        .hero-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        
        .hero-image.active {
            opacity: 1;
        }
        
        .home_text_h6{
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #FFC107;
            text-transform: uppercase;
            letter-spacing: 5px;
            font-size: 0.75rem;
        }

        @media (max-width: 640px) {
            .home_text_h6 {
                font-size: 0.65rem;
                letter-spacing: 2px;
            }
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .hero-content {
                align-items: flex-start;
                padding-top: 25%;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                align-items: flex-start;
                padding-top: 70%;
            }
        }
        
        .hero-text-wrapper {
            position: relative;
            width: 100%;
            max-width: 1200px;
        }
        
        .hero-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            text-align: center;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .hero-text {
                top: -15%;
            }
        }

        @media (max-width: 480px) {
            .hero-text {
                top: -20%;
            }
        }
        
        .hero-text.active {
            opacity: 1;
        }

        .services-section {
            position: relative;
            background-image: url('img/bg.jpg');
            background-position: center;
            background-size: cover;
            padding: 3rem 1rem;
        }
        
        .service-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .icon-circle {
            width: 100px;
            height: 100px;
            background-color: #F8F3E7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: -30px;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .icon-circle img {
            max-width: 50px;
            max-height: 50px;
        }
        
        .card-content {
            background-color: white;
            padding: 50px 30px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }
        
        .card-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            background-color: #FFC107;
        }

        @media (max-width: 768px) {
            .hero-container {
                height: 70vh;
            }

            .card-content {
                padding: 50px 20px 20px;
            }

            .icon-circle {
                width: 80px;
                height: 80px;
            }

            .icon-circle img {
                max-width: 40px;
                max-height: 40px;
            }
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <?php include 'header.php';?>

    <!-- Hero Section -->
    <section class="hero-container">
        <!-- Images -->
        <img src="img/home.jpeg" alt="Charity volunteers" class="hero-image active">
        <img src="img/hom1.jpg" alt="Helping communities" class="hero-image">
        
        <!-- Dark Overlay -->
        <div class="hero-overlay"></div>
        
        <!-- Content -->
        <div class="hero-content">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="hero-text-wrapper">
                    <!-- First Text Content -->
                    <div class="hero-text active" id="text1">
                        <h6 class="home_text_h6 mb-3">Start donating to poor people</h6>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 font-serif text-white">Make a Difference Today</h1>
                        <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 font-serif text-gray-200 px-2">Join thousands of compassionate people making real change in the world. Your donation helps us reach those in need.</p>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                            <a href="user_requests.php" class="bg-red-500 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-bold hover:bg-red-600 transition text-sm sm:text-base">Donate Now</a>
                            <a href="success_story.php" class="border-2 border-white text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-bold hover:bg-white hover:text-red-500 transition text-sm sm:text-base">View Success</a>
                        </div>
                    </div>
                    
                    <!-- Second Text Content -->
                    <div class="hero-text" id="text2">
                        <h6 class="home_text_h6 mb-3">Start donating to poor people</h6>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 font-serif text-white">Together We Can Change Lives</h1>
                        <p class="text-base sm:text-lg md:text-xl lg:text-2xl font-serif mb-6 sm:mb-8 text-gray-200 px-2">Every contribution matters. Help us provide essential resources to communities around the world and create lasting impact.</p>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                            <a href="home.php" class="bg-red-500 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-bold hover:bg-red-600 transition text-sm sm:text-base">Donate Now</a>
                            <a href="#" class="border-2 border-white text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-bold hover:bg-white hover:text-red-500 transition text-sm sm:text-base">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <!-- Left Side - Text Content -->
                <div class="space-y-6 md:space-y-8">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-semibold text-green-700 font-serif uppercase tracking-wider mb-2">About Us</h2>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 md:mb-6" style="color: #122F2A; font-family: Georgia, 'Times New Roman', Times, serif;">Our goal is to save more lives with your help.</h1>
                    </div>
                    
                    <!-- Fundraising Section -->
                    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                        <div class="flex items-start mb-4">
                            <div class="mr-3 sm:mr-4 flex-shrink-0">
                                <img src="https://kindi-react.vercel.app/img/home-1/icon/01.svg" alt="icon" class="w-10 h-10 sm:w-12 sm:h-12">
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900" style="color: #122F2A; font-family: 'Times New Roman', Times, serif;">Connecting Donors with Those in Need</h3>
                        </div>
                        <p class="text-sm sm:text-base text-gray-600">We provide a trusted platform where kind-hearted donors can connect directly with individuals or families in need. Whether it's food, clothes, books, or daily essentials — every donation makes a real difference.</p>
                    </div>
                    
                    <!-- Donation Marketing Section -->
                    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                        <div class="flex items-start mb-4">
                            <div class="mr-3 sm:mr-4 flex-shrink-0">
                                <img src="https://kindi-react.vercel.app/img/home-1/icon/02.svg" alt="icon" class="w-10 h-10 sm:w-12 sm:h-12">
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Transparent and Compassionate Support</h3>
                        </div>
                        <p class="text-sm sm:text-base text-gray-600">Our system ensures complete transparency between donors and receivers. Each request is verified, and every act of kindness is shared as a success story to inspire others to help and spread compassion.</p>
                    </div>
                    
                    <!-- More About Us Button -->
                    <button class="text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-semibold hover:bg-opacity-90 transition flex items-center text-sm sm:text-base" style="background-color: #0B4E3D;">
                        More About Us
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
                
                <!-- Right Side - Images Grid -->
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div class="space-y-3 sm:space-y-4">
                        <img src="img/home_img1.jpg" alt="Child receiving supplies" class="rounded-lg shadow-md w-full h-48 sm:h-56 md:h-64 object-cover">
                        <img src="img/home_img2.jpg" alt="Children smiling" class="rounded-lg shadow-md w-full h-36 sm:h-40 md:h-48 object-cover">
                    </div>
                    <div class="space-y-3 sm:space-y-4 mt-6 sm:mt-8">
                        <img src="img/home_img3.jpg" alt="Volunteer with children" class="rounded-lg shadow-md w-full h-36 sm:h-40 md:h-48 object-cover">
                        <img src="img/home_img4.jpg" alt="Happy children" class="rounded-lg shadow-md w-full h-48 sm:h-56 md:h-64 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <div class="p-4 sm:p-6 md:p-8">
        <section class="py-12 md:py-16 services-section rounded-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8 md:mb-12">
                    <h2 class="text-xs sm:text-sm font-semibold uppercase tracking-wider mb-2" style="color: #145F2A;">Charity Services</h2>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 px-2">Providing humanitarian services to all people is what we do</h1>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                    <!-- Education Card -->
                    <div class="service-card">
                        <div class="icon-circle">
                            <img src="https://kindi-react.vercel.app/img/home-1/icon/04.svg" alt="Education icon">
                        </div>
                        <div class="card-content">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4" style="color: #122F2A;">Education</h3>
                            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">We provide educational support to underprivileged children, including books, tuition, and learning resources to help them grow.</p>
                            <a href="#" class="inline-block bg-green-500 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-medium hover:bg-green-600 transition text-sm sm:text-base" style="background-color: #145F2A;">
                                Learn More
                            </a>
                        </div>
                    </div>
                    
                    <!-- Medical Help Card -->
                    <div class="service-card">
                        <div class="icon-circle">
                            <img src="https://kindi-react.vercel.app/img/home-1/icon/05.svg" alt="Medical icon">
                        </div>
                        <div class="card-content">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4" style="color: #122F2A;">Medical Help</h3>
                            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">We offer medical assistance to those in need, providing medicines, check-ups, and basic healthcare services.</p>
                            <a href="#" class="inline-block bg-green-500 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-medium hover:bg-green-600 transition text-sm sm:text-base" style="background-color: #145F2A;">
                                Learn More
                            </a>
                        </div>
                    </div>
                    
                    <!-- Healthy Foods Card -->
                    <div class="service-card">
                        <div class="icon-circle">
                            <img src="https://kindi-react.vercel.app/img/home-1/icon/03.svg" alt="Food icon">
                        </div>
                        <div class="card-content">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4" style="color: #122F2A;">Healthy Foods</h3>
                            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">We supply nutritious meals to needy individuals to ensure they stay healthy and well-nourished.</p>
                            <a href="#" class="inline-block bg-green-500 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-medium hover:bg-green-600 transition text-sm sm:text-base" style="background-color: #145F2A;">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php';?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.hero-image');
            const texts = document.querySelectorAll('.hero-text');
            let currentIndex = 0;
            
            function changeSlide() {
                // Remove active class from current image and text
                images[currentIndex].classList.remove('active');
                texts[currentIndex].classList.remove('active');
                
                // Move to next slide
                currentIndex = (currentIndex + 1) % images.length;
                
                // Add active class to next image and text
                setTimeout(() => {
                    images[currentIndex].classList.add('active');
                    texts[currentIndex].classList.add('active');
                }, 100);
            }
            
            // Change slide every 4 seconds
            setInterval(changeSlide, 4000);
        });
    </script>
</body>
</html>