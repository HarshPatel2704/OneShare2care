<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <title>Kindio - Charity Donation Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-container {
            position: relative;
            height: 100vh;
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
        
        .hero-text-wrapper {
            position: relative;
            width: 100%;
            max-width: 4xl;
        }
        
        .hero-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            text-align: center;
        }
        
        .hero-text.active {
            opacity: 1;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .services-section {
            position: relative;
            background-image: url('img/bg.jpg');
            background-position: center;
            padding: 30px;
        }
        
        .service-card {
            display: flex;
            flex-direction: column;
            align-items: center;
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
        
        .card-content {
            background-color: white;
            padding: 50px 30px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            background-color: #FFC107;
            transition: 0.5s;
        }
        
        .graduation-cap {
            position: relative;
            color: #374151;
        }
        
        .graduation-cap::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 15px;
            background-color: #374151;
        }
        
        .graduation-cap::before {
            content: '';
            position: absolute;
            bottom: -18px;
            left: 50%;
            transform: translateX(-50%);
            width: 10px;
            height: 10px;
            background-color: #374151;
            border-radius: 50%;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="hero-text-wrapper">
                    <!-- First Text Content -->
                    <div class="hero-text active" id="text1">
                        <h6 class="home_text_h6">Start donating to poor people</h6>
                        <h1 class="text-5xl md:text-6xl font-bold mb-6 font-serif text-white">Make a Difference Today</h1>
                        <p class="text-xl md:text-2xl mb-8 font-serif text-gray-200">Join thousands of compassionate people making real change in the world. Your donation helps us reach those in need.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="user_requests.php" class="bg-red-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-600 transition">Donate Now</a>
                            <a href="success_story.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-red-500 transition">View Success</a>
                        </div>
                    </div>
                    
                    <!-- Second Text Content -->
                    <div class="hero-text" id="text2">
                        <h6 class="home_text_h6">Start donating to poor people</h6>
                        <h1 class="text-5xl md:text-6xl font-bold mb-6 font-serif text-white">Together We Can Change Lives</h1>
                        <p class="text-xl md:text-2xl font-serif mb-8 text-gray-200">Every contribution matters. Help us provide essential resources to communities around the world and create lasting impact.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="home.php" class="bg-red-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-600 transition">Donate Now</a>
                            <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-red-500 transition">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Text Content -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-semibold text-green-700 font-serif uppercase tracking-wider mb-2">About Us</h2>
                        <h1 class="text-4xl font-bold mb-6" style="color: #122F2A; font-family: Georgia, 'Times New Roman', Times, serif;">Our goal is to save more lives with your help.</h1>
                    </div>
                    
                    <!-- Fundraising Section -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="mr-4">
                                <!-- <i class="fas fa-hand-holding-heart text-red-500 text-xl"></i> -->
                                 <img src="https://kindi-react.vercel.app/img/home-1/icon/01.svg" alt="icon not found">
                                </div>
                                <h3 class="text-xl font-bold text-gray-900"  style="color: #122F2A; font-family: 'Times New Roman', Times, serif;">Connecting Donors with Those in Need</h3>
                            </div>
                            <p class="text-gray-600">We provide a trusted platform where kind-hearted donors can connect directly with individuals or families in need. Whether it's food, clothes, books, or daily essentials — every donation makes a real difference.</p>
                        </div>
                        
                        <!-- Donation Marketing Section -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="p-3 mr-4">
                                    <!-- <i class="fas fa-bullhorn text-red-500 text-xl"></i> -->
                                    <img src="https://kindi-react.vercel.app/img/home-1/icon/02.svg" alt="icon not found">
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Transparent and Compassionate Support</h3>
                        </div>
                        <p class="text-gray-600">Our system ensures complete transparency between donors and receivers. Each request is verified, and every act of kindness is shared as a success story to inspire others to help and spread compassion.</p>
                    </div>
                    
                    <!-- More About Us Button -->
                    <button class="text-white px-8 py-3 rounded-full font-semibold hover:bg-red-600 transition flex items-center" style="background-color: #0B4E3D; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                        More About Us
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
                
                <!-- Right Side - Images Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="img/home_img1.jpg" alt="Child receiving supplies" class="rounded-lg shadow-md w-full h-64 object-cover">
                        <img src="img/home_img2.jpg" alt="Children smiling" class="rounded-lg shadow-md w-full h-48 object-cover">
                    </div>
                    <div class="space-y-4 mt-8">
                        <img src="img/home_img3.jpg" alt="Volunteer with children" class="rounded-lg shadow-md w-full h-48 object-cover">
                        <img src="img/home_img4.jpg" alt="Happy children" class="rounded-lg shadow-md w-full h-64 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="p-8">
     <section class="py-16 services-section rounded-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 services-content">
            <div class="text-center mb-12">
                <h2 class="text-sm font-semibold text-red-500 uppercase tracking-wider mb-2"  style="color: #145F2A;">Charity Services</h2>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Providing humanitarian services to all people is what we do</h1>
            </div>
            
            <div class="grid md:grid-cols-3 gap-12">
                <!-- Education Card -->
                <div class="service-card">
                    <div class="icon-circle">
                        <!-- <i class="fas fa-graduation-cap text-4xl graduation-cap"></i> -->
                         <img src="https://kindi-react.vercel.app/img/home-1/icon/04.svg" alt="">
                    </div>
                    <div class="card-content">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4" style="color: #122F2A;">Education</h3>
                        <p class="text-gray-600 mb-6">We provide educational support to underprivileged children, including books, tuition, and learning resources to help them grow.</p>
                        <a href="#" class="bg-green-500 text-white px-8 py-3 rounded-lg font-medium hover:bg-green-600 transition inline-block"  style="background-color: #145F2A;">
                            Learn More
                        </a>
                    </div>
                </div>
                
                <!-- Medical Help Card -->
                <div class="service-card">
                    <div class="icon-circle">
                        <!-- <i class="fas fa-hands-helping text-4xl text-gray-700"></i> -->
                         <img src="https://kindi-react.vercel.app/img/home-1/icon/05.svg" alt="">
                    </div>
                    <div class="card-content">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4" style="color: #122F2A;">Medical Help</h3>
                        <p class="text-gray-600 mb-6">We offer medical assistance to those in need, providing medicines, check-ups, and basic healthcare services.</p>
                        <a href="#" class="bg-green-500 text-white px-8 py-3 rounded-lg font-medium hover:bg-green-600 transition inline-block"  style="background-color: #145F2A;">
                            Learn More
                        </a>
                    </div>
                </div>
                
                <!-- Healthy Foods Card -->
                <div class="service-card">
                    <div class="icon-circle">
                        <!-- <i class="fas fa-seedling text-4xl text-gray-700"></i> -->
                         <img src="https://kindi-react.vercel.app/img/home-1/icon/03.svg" alt="">
                    </div>
                    <div class="card-content">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4" style="color: #122F2A;">Healthy Foods</h3>
                        <p class="text-gray-600 mb-6">We supply nutritious meals to needy individuals to ensure they stay healthy and well-nourished.</p>
                        <a href="#" class="bg-green-500 text-white px-8 py-3 rounded-lg font-medium hover:bg-green-600 transition inline-block"  style="background-color: #145F2A;">
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
                }, 100); // Small delay for smoother transition
            }
            
            // Change slide every 5 seconds
            setInterval(changeSlide, 4000);
        });
    </script>
</body>
</html>