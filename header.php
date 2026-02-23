<?php
 $current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
.navbar {
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.navbar-top {
    background-color: #fbbf24; /* Yellow color */
}

.navbar-scrolled {
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar-top .nav-link {
    color: #374151;
}

.navbar-top .nav-link:hover {
    color: #1f2937;
}

.navbar-scrolled .nav-link {
    color: #374151;
}

.navbar-scrolled .nav-link:hover {
    color: #ef4444;
}

.navbar-top .donate-btn {
    background-color: #374151;
}

.navbar-top .donate-btn:hover {
    background-color: #1f2937;
}

.navbar-scrolled .donate-btn {
    background-color: #ef4444;
}

.navbar-scrolled .donate-btn:hover {
    background-color: #dc2626;
}

/* Home page specific styling */
<?php if ($current_page == 'home.php'): ?>
.home-hero {
    /* Your home page specific styles */
}
<?php endif; ?>
</style>

<nav id="navbar" class="navbar navbar-top sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="home.php" class="flex items-center space-x-2">
                <img src="img/logo.png" alt="ShareForCare Logo" class="w-45 h-60">
            </a>

            <div class="hidden md:flex space-x-8">
                <a href="home.php" class="nav-link font-medium <?php echo $current_page == 'home.php' ? 'text-red-500' : ''; ?>">Home</a>
                
                <?php if(isset($_SESSION['user_logged_in'])): ?>
                    <?php if($_SESSION['role'] == 'user'): ?>
                        <a href="user_requests.php" class="nav-link font-medium">User Request</a>
                        <a href="post_request.php" class="nav-link font-medium">Post Request</a>
                        <a href="user_dashboard.php" class="nav-link font-medium">Dashboard</a>
                    <?php elseif($_SESSION['role'] == 'admin'): ?>
                        <a href="admin_requests.php" class="nav-link font-medium">Requests for Verify</a>
                        <a href="admin_dashboard.php" class="nav-link font-medium">Admin Dashboard</a>
                        <a href="admin_request_update.php" class="nav-link font-medium">request detail</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="user_requests.php" class="nav-link font-medium">User Request</a>
                <?php endif; ?>

                <a href="success_story.php" class="nav-link font-medium">Success Stories</a>

                <?php if(isset($_SESSION['user_logged_in'])): ?>
                    <a href="logout.php" class="donate-btn text-white px-6 py-2 rounded-lg transition">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="donate-btn text-white px-6 py-2 rounded-lg transition">Login</a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-2">
                <a href="home.php" class="nav-link block px-3 py-2 rounded-md <?php echo $current_page == 'home.php' ? 'text-red-500' : ''; ?>">Home</a>
                
                <?php if(isset($_SESSION['user_logged_in'])): ?>
                    <?php if($_SESSION['role'] == 'user'): ?>
                        <a href="user_requests.php" class="nav-link block px-3 py-2 rounded-md">User Request</a>
                        <a href="post_request.php" class="nav-link block px-3 py-2 rounded-md">Post Request</a>
                        <a href="user_dashboard.php" class="nav-link block px-3 py-2 rounded-md">Dashboard</a>
                    <?php elseif($_SESSION['role'] == 'admin'): ?>
                        <a href="admin_requests.php" class="nav-link block px-3 py-2 rounded-md">Requests for Verify</a>
                        <a href="admin_dashboard.php" class="nav-link block px-3 py-2 rounded-md">Admin Dashboard</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="user_requests.php" class="nav-link block px-3 py-2 rounded-md">User Request</a>
                <?php endif; ?>

                <a href="success_story.php" class="nav-link block px-3 py-2 rounded-md">Success Stories</a>

                <?php if(isset($_SESSION['user_logged_in'])): ?>
                    <a href="logout.php" class="donate-btn text-white px-6 py-2 rounded-lg transition block text-center">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="donate-btn text-white px-6 py-2 rounded-lg transition block text-center">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
// Navbar scroll effect
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.remove('navbar-top');
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
            navbar.classList.add('navbar-top');
        }
    });
    
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>