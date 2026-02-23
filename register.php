<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include 'db_connect.php';


$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // sanitize inputs
    $name = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender'] ?? ''));
    $contact_no = mysqli_real_escape_string($conn, trim($_POST['contact_no'] ?? ''));
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $city = mysqli_real_escape_string($conn, trim($_POST['city'] ?? ''));
    $password_raw = $_POST['password'] ?? '';
    $role_selected = $_POST['role'] ?? 'user';
    $admin_code = trim($_POST['admin_code'] ?? '');

    // basic validations
    if ($name === '' || $email === '' || $password_raw === '') {
        $error = "Please fill all required fields (Name, Email, Password).";
    } else {
        // If user chose admin, verify code
        if ($role_selected === 'admin') {
            if ($admin_code !== '123') {
                $error = "Entered code is not correct.";
            } else {
                $role = 'admin';
            }
        } else {
            $role = 'user';
        }
    }

    // continue only if no error so far
    if ($error === '') {
        // hash password
        $password = password_hash($password_raw, PASSWORD_DEFAULT);

        // handle photo upload (optional)
        $photo = '';
        if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
            $orig = basename($_FILES['photo']['name']);
            $photo = time() . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', $orig);
            $tmp_name = $_FILES['photo']['tmp_name'];
            if (!move_uploaded_file($tmp_name, "uploads/$photo")) {
                $error = "Failed to upload photo.";
            }
        }
    }

    // insert into DB if still no error
    if ($error === '') {
        // check if email already exists
        $checkSql = "SELECT user_id FROM users WHERE email = '$email' LIMIT 1";
        $checkRes = mysqli_query($conn, $checkSql);
        if ($checkRes && mysqli_num_rows($checkRes) > 0) {
            $error = "Email is already registered. Please use a different email or login.";
        } else {
            $sql = "INSERT INTO users (name, gender, contact_no, email, password, city, photo, role, created_at)
                    VALUES ('$name', '$gender', '$contact_no', '$email', '$password', '$city', '$photo', '$role', NOW())";

            if (mysqli_query($conn, $sql)) {
                // ✅ Send email after successful registration
                // ✅ Send email using PHPMailer



$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hp210522@gmail.com'; // your Gmail
    $mail->Password   = 'fkfmthsrbcwqohap';   // 16-digit app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('hp210522@gmail.com', 'ShareForCare');
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = 'Welcome to ShareForCare!';
    $mail->Body    = "
        <html>
        <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
            <div style='max-width: 600px; margin: auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                <h2 style='color: #145F2A;'>Hello $name,</h2>
                <p>Thank you for registering with <strong>ShareForCare</strong> 💚</p>
                <p>You are successfully registered as a <strong>$role</strong>.</p>
                <p>We’re excited to have you join our community where kindness meets action.</p>
                <br>
                <p style='color: #555;'>Best regards,<br><strong>Team ShareForCare</strong></p>
            </div>
        </body>
        </html>
    ";

    $mail->send();
} catch (Exception $e) {
    error_log("Email not sent. Mailer Error: {$mail->ErrorInfo}");
}


                // redirect to login page
                header("Location: Login.php");
                exit();
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Register - ShareForCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #F8F3E7; }
    .btn-primary { background: #145F2A; color: #fff; }
    .btn-primary:hover { background: #0B4E3D; }
    .input-focus:focus { border-color: #145F2A; box-shadow: 0 0 0 3px rgba(20,95,42,0.08); }
  </style>
</head>
<body>
  <?php include 'header.php' ?>
  <div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8">
      <h2 class="text-3xl font-bold text-center text-[#145F2A] mb-2">Register</h2>
      <p class="text-gray-600 text-center mb-6">Sign up to create your journey of kindness</p>

      <?php if($error): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php if($success): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?php echo $success; ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="space-y-4" onsubmit="return validateForm()">
        <div>
          <label class="block font-semibold text-gray-700 mb-1">Full Name *</label>
          <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2 input-focus" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold text-gray-700 mb-1">Gender</label>
            <select name="gender" class="w-full border rounded-lg px-3 py-2 input-focus">
              <option value="">Select</option>
              <option value="Male" <?php if(($_POST['gender'] ?? '')==='Male') echo 'selected'; ?>>Male</option>
              <option value="Female" <?php if(($_POST['gender'] ?? '')==='Female') echo 'selected'; ?>>Female</option>
              <option value="Other" <?php if(($_POST['gender'] ?? '')==='Other') echo 'selected'; ?>>Other</option>
            </select>
          </div>
          <div>
            <label class="block font-semibold text-gray-700 mb-1">Contact No</label>
            <input type="text" name="contact_no" class="w-full border rounded-lg px-3 py-2 input-focus" value="<?php echo htmlspecialchars($_POST['contact_no'] ?? ''); ?>">
          </div>
        </div>

        <div>
          <label class="block font-semibold text-gray-700 mb-1">Email *</label>
          <input type="email" name="email" required class="w-full border rounded-lg px-3 py-2 input-focus" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div>
          <label class="block font-semibold text-gray-700 mb-1">City</label>
          <input type="text" name="city" class="w-full border rounded-lg px-3 py-2 input-focus" value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>">
        </div>

        <div>
          <label class="block font-semibold text-gray-700 mb-1">Password *</label>
          <input type="password" name="password" required class="w-full border rounded-lg px-3 py-2 input-focus">
        </div>

        <div>
          <label class="block font-semibold text-gray-700 mb-1">Role *</label>
          <select id="role" name="role" onchange="toggleAdminCode()" class="w-full border rounded-lg px-3 py-2 input-focus">
            <option value="user" <?php if(($_POST['role'] ?? '')==='user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if(($_POST['role'] ?? '')==='admin') echo 'selected'; ?>>Admin</option>
          </select>
        </div>

        <div id="adminCodeField" class="<?php echo (($_POST['role'] ?? '')==='admin') ? '' : 'hidden'; ?>">
          <label class="block font-semibold text-gray-700 mb-1">Admin Access Code</label>
          <input type="password" name="admin_code" class="w-full border rounded-lg px-3 py-2 input-focus" placeholder="Enter secret code">
          <p class="text-sm text-gray-500 mt-1">Enter secret code to register as admin.</p>
        </div>

        <div>
          <label class="block font-semibold text-gray-700 mb-1">Profile Photo</label>
          <input type="file" name="photo" class="w-full">
        </div>

        <button type="submit" class="btn-primary w-full py-3 rounded-lg font-semibold">Register</button>
      </form>
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
                    Already registered? 
                    <a href="login.php" class="text-red-500 hover:text-red-600 font-bold">Login</a>
                </p>
            </div>
        </div>
    </div>
  </div>

<script>
function toggleAdminCode(){
  const role = document.getElementById('role').value;
  const field = document.getElementById('adminCodeField');
  if(role === 'admin') field.classList.remove('hidden');
  else field.classList.add('hidden');
}

function validateForm(){
  const role = document.getElementById('role').value;
  if(role === 'admin'){
    const code = document.querySelector('input[name="admin_code"]').value.trim();
    if(code === ''){
      alert('Please enter admin code to register as admin.');
      return false;
    }
  }
  return true;
}
</script>
</body>
</html>
