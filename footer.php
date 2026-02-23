<html>
    <head>
        <title>footer</title>
    </head>
    <style>

        .footer {
            background-color: #0B4E3D;
        }
        .footer-link {
            color: #D1D5DB;
            transition: color 0.3s ease;
        }
        .footer-link:hover {
            color: #FFC107;
        }
        .social-icon {
            color: #D1D5DB;
            transition: color 0.3s ease;
        }
        .social-icon:hover {
            color: #FFC107;
        }
        .no-requests {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        .no-requests i {
            color: #145F2A;
            font-size: 3rem;
            margin-bottom: 16px;
        }
        .footer-logo {
            height: 200px;
            width: auto;
        }
    </style>
    <body>
        <footer class="footer text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center mb-4">
                        <!-- <i class="fas fa-heart text-2xl mr-2" style="color: #FFC107;"></i> -->
                        <!-- <i class="fas fa-heart text-red-500 mr-2 text-2xl"></i> -->
                        <!-- <h3 class="">ShareForCare</h3> -->
                        <img src="img/navbar_logo.png" alt="ShareForCare Logo" class="footer-logo">
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="home.php" class="footer-link">Home</a></li>
                        <li><a href="user_requests.php" class="footer-link">Browse Requests</a></li>
                        <li><a href="success_story.php" class="footer-link">Success Stories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="footer-link">Contact Us</a></li>
                        <li><a href="#" class="footer-link">FAQ</a></li>
                        <li><a href="#" class="footer-link">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>&copy; Oneshare2care. All rights reserved.</p>
            </div>
        </div>
    </footer>


    </body>
</html>