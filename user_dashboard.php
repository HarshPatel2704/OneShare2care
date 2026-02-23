<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

 $user_id = $_SESSION['user_id'];

// Get user details
 $user_query = "SELECT * FROM users WHERE user_id = '$user_id'";
 $user_result = mysqli_query($conn, $user_query);

if (!$user_result) {
    die("Database error: " . mysqli_error($conn));
}

 $user = mysqli_fetch_assoc($user_result);

// Handle profile update
 $success_msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    
    // Handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        $target = "uploads/" . $photo;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $update_sql = "UPDATE users SET name='$name', email='$email', contact_no='$contact_no', city='$city', photo='$photo' WHERE user_id='$user_id'";
        } else {
            $update_sql = "UPDATE users SET name='$name', email='$email', contact_no='$contact_no', city='$city' WHERE user_id='$user_id'";
        }
    } else {
        $update_sql = "UPDATE users SET name='$name', email='$email', contact_no='$contact_no', city='$city' WHERE user_id='$user_id'";
    }
    
    if (mysqli_query($conn, $update_sql)) {
        $success_msg = "Profile updated successfully!";
        
        // Refresh user data
        $user_result = mysqli_query($conn, $user_query);
        $user = mysqli_fetch_assoc($user_result);
    } else {
        $error_msg = "Error updating profile: " . mysqli_error($conn);
    }
}

// Get user's help requests (requests made by user for help)
 $help_requests_query = "SELECT * FROM requests WHERE user_id = '$user_id' ORDER BY request_date DESC";
 $help_requests_result = mysqli_query($conn, $help_requests_query);

if (!$help_requests_result) {
    die("Database error: " . mysqli_error($conn));
}

 $help_requests_count = mysqli_num_rows($help_requests_result);

// Get user's donations (help given to others) - simplified query
 $donations_query = "SELECT * FROM success_stories WHERE helper_name = '{$user['name']}' ORDER BY created_at DESC";
 $donations_result = mysqli_query($conn, $donations_query);

if (!$donations_result) {
    // If the query fails, try with user_id if that column exists
    $donations_query = "SELECT * FROM success_stories WHERE user_id = '$user_id' ORDER BY created_at DESC";
    $donations_result = mysqli_query($conn, $donations_query);
    
    if (!$donations_result) {
        // If still fails, set empty result
        $donations_result = null;
        $donations_count = 0;
    } else {
        $donations_count = mysqli_num_rows($donations_result);
    }
} else {
    $donations_count = mysqli_num_rows($donations_result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - ShareForCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8F3E7;
        }
        .primary-green {
            color: #145F2A;
        }
        .secondary-green {
            color: #0B4E3D;
        }
        .accent-yellow {
            color: #FFC107;
        }
        .bg-primary-green {
            background-color: #145F2A;
        }
        .bg-secondary-green {
            background-color: #0B4E3D;
        }
        .bg-accent-yellow {
            background-color: #FFC107;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .tab-button {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .tab-button.active {
            background-color: #145F2A;
            color: white;
        }
        .tab-button:not(.active) {
            background-color: #e5e7eb;
            color: #6b7280;
        }
        .tab-button:not(.active):hover {
            background-color: #d1d5db;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .request-card, .donation-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .request-card:hover, .donation-card:hover {
            transform: translateY(-2px);
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-fulfilled {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #145F2A;
        }
        .form-input {
            width: 100%;
            padding: 10px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: #145F2A;
        }
        .btn-primary {
            background-color: #145F2A;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0B4E3D;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include 'header.php'; ?>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold primary-green" style="font-family: Georgia, 'Times New Roman', Times, serif;">My Dashboard</h1>
            <p class="text-gray-600 mt-2">Manage your profile and track your contributions</p>
        </div>

        <!-- Success Message -->
        <?php if (!empty($success_msg)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $success_msg; ?>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (!empty($error_msg)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card text-center">
                <i class="fas fa-user text-3xl mb-3" style="color: #145F2A;"></i>
                <h3 class="text-2xl font-bold primary-green"><?php echo $help_requests_count; ?></h3>
                <p class="text-gray-600">Help Requests</p>
            </div>
            <div class="stat-card text-center">
                <i class="fas fa-hand-holding-heart text-3xl mb-3" style="color: #145F2A;"></i>
                <h3 class="text-2xl font-bold primary-green"><?php echo $donations_count; ?></h3>
                <p class="text-gray-600">Donations Made</p>
            </div>
            <div class="stat-card text-center">
                <i class="fas fa-calendar-alt text-3xl mb-3" style="color: #145F2A;"></i>
                <h3 class="text-2xl font-bold primary-green"><?php echo date('M Y'); ?></h3>
                <p class="text-gray-600">Current Month</p>
            </div>
            <div class="stat-card text-center">
                <i class="fas fa-trophy text-3xl mb-3" style="color: #FFC107;"></i>
                <h3 class="text-2xl font-bold" style="color: #FFC107;">Level <?php echo min(5, floor(($help_requests_count + $donations_count) / 2) + 1); ?></h3>
                <p class="text-gray-600">Helper Level</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold primary-green mb-6">My Profile</h2>
                    
                    <!-- Profile Picture -->
                    <div class="text-center mb-6">
                        <?php if($user['photo'] && file_exists('uploads/'.$user['photo'])): ?>
                            <img src="uploads/<?php echo $user['photo']; ?>" alt="Profile" class="profile-avatar mx-auto mb-4">
                        <?php else: ?>
                            <div class="profile-avatar mx-auto mb-4 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-4xl text-gray-400"></i>
                            </div>
                        <?php endif; ?>
                        <h3 class="text-xl font-semibold primary-green"><?php echo htmlspecialchars($user['name']); ?></h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($user['city']); ?></p>
                    </div>

                    <!-- Update Profile Form -->
                    <form method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                            <input type="text" name="contact_no" value="<?php echo htmlspecialchars($user['contact_no']); ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                            <input type="file" name="photo" accept="image/*" class="form-input">
                        </div>
                        <button type="submit" name="update_profile" class="btn-primary w-full">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>

            <!-- Activity Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <!-- Tabs -->
                    <div class="flex space-x-4 mb-6">
                        <button class="tab-button active" onclick="showTab('requests')">
                            <i class="fas fa-hands-helping mr-2"></i>My Help Requests
                        </button>
                        <button class="tab-button" onclick="showTab('donations')">
                            <i class="fas fa-hand-holding-heart mr-2"></i>My Donations
                        </button>
                    </div>

                    <!-- My Help Requests Tab -->
                    <div id="requests-tab" class="tab-content active">
                        <h3 class="text-xl font-semibold primary-green mb-4">Help Requests You've Made</h3>
                        <?php if(mysqli_num_rows($help_requests_result) > 0): ?>
                            <?php while($request = mysqli_fetch_assoc($help_requests_result)): ?>
                                <div class="request-card">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($request['title']); ?></h4>
                                        <span class="status-badge <?php 
                                            echo $request['status'] == 'Approved' ? 'status-approved' : 
                                                 ($request['status'] == 'Pending' ? 'status-pending' : 'status-fulfilled'); 
                                        ?>">
                                            <?php echo htmlspecialchars($request['status']); ?>
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mb-3"><?php echo nl2br(htmlspecialchars($request['description'])); ?></p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span><?php echo htmlspecialchars($request['location']); ?></span>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">You haven't made any help requests yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- My Donations Tab -->
                    <div id="donations-tab" class="tab-content">
                        <h3 class="text-xl font-semibold primary-green mb-4">Donations You've Made</h3>
                        <?php if($donations_result && mysqli_num_rows($donations_result) > 0): ?>
                            <?php while($donation = mysqli_fetch_assoc($donations_result)): ?>
                                <div class="donation-card">
                                    <div class="flex items-start space-x-4">
                                        <?php if($donation['image'] && file_exists('uploads/'.$donation['image'])): ?>
                                            <img src="uploads/<?php echo $donation['image']; ?>" alt="Donation" class="w-20 h-20 rounded-lg object-cover">
                                        <?php else: ?>
                                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800 mb-2">Donation</h4>
                                            <p class="text-gray-600 mb-2"><?php echo nl2br(htmlspecialchars($donation['description'])); ?></p>
                                            <div class="flex flex-wrap gap-2 mb-2">
                                                <?php 
                                                    $items = explode(',', $donation['items_donated']);
                                                    foreach ($items as $item) {
                                                        echo "<span class='bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs'>" . htmlspecialchars(trim($item)) . "</span>";
                                                    }
                                                ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-calendar mr-2"></i>
                                                <?php echo date('d M Y', strtotime($donation['created_at'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <i class="fas fa-hand-holding-heart text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">You haven't made any donations yet.</p>
                                <a href="user_requests.php" class="inline-block mt-3 bg-primary-green text-white px-6 py-2 rounded-lg hover:bg-secondary-green transition">
                                    Browse Help Requests
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
    </script>
</body>
</html>