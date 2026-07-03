<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: user_requests.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ShareForCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .primary-gradient {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
        }
        .input-focus:focus {
            border-color: #FF6B6B;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }
        .bg-pattern {
            background-color: #FFF5F3;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 107, 107, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 142, 83, 0.05) 0%, transparent 50%);
        }
        .heart-icon {
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .social-btn {
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-pattern">
<?php include 'header.php'; ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4 border-4 border-orange-100">
                <i class="fas fa-heart text-4xl text-red-500 heart-icon"></i>
            </div>
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Welcome Back</h2>
            <p class="text-gray-600">Sign in to continue your journey of kindness</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <?php if(isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-700 font-medium"><?php echo $error; ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <!-- Email Input -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl input-focus outline-none transition-all" 
                            placeholder="you@example.com"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            name="password" 
                            required 
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl input-focus outline-none transition-all" 
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-red-500 hover:text-red-600 font-semibold">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary text-white py-4 rounded-xl font-bold text-lg shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>

            <!-- Social Login -->
            <div class="grid grid-cols-3 gap-3">
                <button class="social-btn flex items-center justify-center py-3 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition">
                    <i class="fab fa-facebook-f text-blue-600 text-lg"></i>
                </button>
                <button class="social-btn flex items-center justify-center py-3 border-2 border-gray-200 rounded-xl hover:border-red-500 hover:bg-red-50 transition">
                    <i class="fab fa-google text-red-500 text-lg"></i>
                </button>
                <button class="social-btn flex items-center justify-center py-3 border-2 border-gray-200 rounded-xl hover:border-blue-400 hover:bg-blue-50 transition">
                    <i class="fab fa-twitter text-blue-400 text-lg"></i>
                </button>
            </div>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Don't have an account? 
                    <a href="register.php" class="text-red-500 hover:text-red-600 font-bold">Create Account</a>
                </p>
            </div>
        </div>

        <!-- Security Badge -->
        <div class="mt-6 text-center">
            <div class="inline-flex items-center text-sm text-gray-600 bg-white px-4 py-2 rounded-full shadow">
                <i class="fas fa-shield-alt text-red-500 mr-2"></i>
                Your information is safe and secure
            </div>
        </div>
    </div>
</div>
</body>
</html>
