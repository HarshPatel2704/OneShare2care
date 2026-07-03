<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

 $admin_id = $_SESSION['user_id'];
 $admin_query = "SELECT * FROM users WHERE user_id = '$admin_id'";
 $admin_result = mysqli_query($conn, $admin_query);
 $admin = mysqli_fetch_assoc($admin_result);


 $total_users_query = "SELECT COUNT(*) as total FROM users";
 $total_users_result = mysqli_query($conn, $total_users_query);
 $total_users = mysqli_fetch_assoc($total_users_result)['total'];

 $total_requests_query = "SELECT COUNT(*) as total FROM requests";
 $total_requests_result = mysqli_query($conn, $total_requests_query);
 $total_requests = mysqli_fetch_assoc($total_requests_result)['total'];

 $pending_requests_query = "SELECT COUNT(*) as total FROM requests WHERE status='Pending'";
 $pending_requests_result = mysqli_query($conn, $pending_requests_query);
 $pending_requests = mysqli_fetch_assoc($pending_requests_result)['total'];

 $approved_requests_query = "SELECT COUNT(*) as total FROM requests WHERE status='Approved'";
 $approved_requests_result = mysqli_query($conn, $approved_requests_query);
 $approved_requests = mysqli_fetch_assoc($approved_requests_result)['total'];

 $fulfilled_requests_query = "SELECT COUNT(*) as total FROM requests WHERE is_fulfilled=TRUE";
 $fulfilled_requests_result = mysqli_query($conn, $fulfilled_requests_query);
 $fulfilled_requests = mysqli_fetch_assoc($fulfilled_requests_result)['total'];

 $total_donations_query = "SELECT COUNT(*) as total FROM success_stories";
 $total_donations_result = mysqli_query($conn, $total_donations_query);
 $total_donations = mysqli_fetch_assoc($total_donations_result)['total'];


 $recent_requests_query = "SELECT r.*, u.name as user_name, u.city 
                          FROM requests r 
                          JOIN users u ON r.user_id = u.user_id 
                          ORDER BY r.request_date DESC LIMIT 5";
 $recent_requests_result = mysqli_query($conn, $recent_requests_query);

 $recent_donations_query = "SELECT * FROM success_stories ORDER BY created_at DESC LIMIT 5";
 $recent_donations_result = mysqli_query($conn, $recent_donations_query);

 $current_month = date('Y-m');
 $monthly_requests_query = "SELECT COUNT(*) as total FROM requests WHERE DATE_FORMAT(request_date, '%Y-%m') = '$current_month'";
 $monthly_requests_result = mysqli_query($conn, $monthly_requests_query);
 $monthly_requests = mysqli_fetch_assoc($monthly_requests_result)['total'];

 $monthly_donations_query = "SELECT COUNT(*) as total FROM success_stories WHERE DATE_FORMAT(created_at, '%Y-%m') = '$current_month'";
 $monthly_donations_result = mysqli_query($conn, $monthly_donations_query);
 $monthly_donations = mysqli_fetch_assoc($monthly_donations_result)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ShareForCare</title>
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
        .activity-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .activity-card:hover {
            transform: translateY(-2px);
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-fulfilled {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .admin-header {
            background: linear-gradient(135deg, #145F2A 0%, #0B4E3D 100%);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
        }
        .admin-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
        }
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .progress-bar {
            background-color: #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .progress-fill {
            background-color: #145F2A;
            height: 8px;
            transition: width 0.3s ease;
        }
        .admin-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #FFC107;
            color: #145F2A;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>


    <div class="max-w-7xl mx-auto px-4 py-8">

        <div class="admin-header">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <?php if($admin['photo'] && file_exists('uploads/'.$admin['photo'])): ?>
                            <img src="uploads/<?php echo $admin['photo']; ?>" alt="Admin Profile" class="admin-avatar">
                        <?php else: ?>
                            <div class="admin-avatar bg-white/20 flex items-center justify-center border-4 border-white">
                                <i class="fas fa-user-shield text-3xl text-white"></i>
                            </div>
                        <?php endif; ?>
                        <div class="admin-badge">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-1">Welcome back, <?php echo htmlspecialchars($admin['name']); ?>!</h1>
                        <p class="text-green-100">Administrator • <?php echo htmlspecialchars($admin['email']); ?></p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-green-100 text-sm">Last login</p>
                    <p class="text-white font-semibold"><?php echo date('d M Y, H:i'); ?></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card text-center">
                <i class="fas fa-users text-3xl mb-3" style="color: #145F2A;"></i>
                <h3 class="text-2xl font-bold primary-green"><?php echo $total_users; ?></h3>
                <p class="text-gray-600">Total Users</p>
            </div>
            <div class="stat-card text-center">
                <i class="fas fa-hands-helping text-3xl mb-3" style="color: #145F2A;"></i>
                <h3 class="text-2xl font-bold primary-green"><?php echo $total_requests; ?></h3>
                <p class="text-gray-600">Total Requests</p>
            </div>
            <div class="stat-card text-center">
                <i class="fas fa-hand-holding-heart text-3xl mb-3" style="color: #145F2A;"></i>
                <h3 class="text-2xl font-bold primary-green"><?php echo $total_donations; ?></h3>
                <p class="text-gray-600">Total Donations</p>
            </div>
            <div class="stat-card text-center">
                <i class="fas fa-clock text-3xl mb-3" style="color: #FFC107;"></i>
                <h3 class="text-2xl font-bold" style="color: #FFC107;"><?php echo $pending_requests; ?></h3>
                <p class="text-gray-600">Pending Requests</p>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Request Status Chart -->
            <div class="chart-container">
                <h3 class="text-xl font-semibold primary-green mb-4">Request Status Overview</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Pending</span>
                            <span class="font-semibold"><?php echo $pending_requests; ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $total_requests > 0 ? ($pending_requests / $total_requests * 100) : 0; ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Approved</span>
                            <span class="font-semibold"><?php echo $approved_requests; ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $total_requests > 0 ? ($approved_requests / $total_requests * 100) : 0; ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Fulfilled</span>
                            <span class="font-semibold"><?php echo $fulfilled_requests; ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $total_requests > 0 ? ($fulfilled_requests / $total_requests * 100) : 0; ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-container">
                <h3 class="text-xl font-semibold primary-green mb-4">This Month's Activity</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-clipboard-list text-2xl mb-2" style="color: #145F2A;"></i>
                        <h4 class="text-2xl font-bold primary-green"><?php echo $monthly_requests; ?></h4>
                        <p class="text-gray-600">New Requests</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-gift text-2xl mb-2" style="color: #145F2A;"></i>
                        <h4 class="text-2xl font-bold primary-green"><?php echo $monthly_donations; ?></h4>
                        <p class="text-gray-600">New Donations</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold primary-green">Recent Requests</h2>
                    <a href="admin_requests.php" class="text-sm bg-primary-green text-white px-4 py-2 rounded-lg hover:bg-secondary-green transition">
                        View All
                    </a>
                </div>
                
                <div class="space-y-4">
                    <?php if(mysqli_num_rows($recent_requests_result) > 0): ?>
                        <?php while($request = mysqli_fetch_assoc($recent_requests_result)): ?>
                            <div class="activity-card">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($request['title']); ?></h4>
                                    <span class="status-badge <?php 
                                        echo $request['status'] == 'Approved' ? 'status-approved' : 
                                             ($request['status'] == 'Pending' ? 'status-pending' : 'status-fulfilled'); 
                                    ?>">
                                        <?php echo htmlspecialchars($request['status']); ?>
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars(substr($request['description'], 0, 100)) . '...'; ?></p>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i class="fas fa-user mr-2"></i>
                                    <span><?php echo htmlspecialchars($request['user_name']); ?></span>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span><?php echo htmlspecialchars($request['city']); ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No requests found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Donations -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold primary-green">Recent Donations</h2>
                    <a href="success_story.php" class="text-sm bg-primary-green text-white px-4 py-2 rounded-lg hover:bg-secondary-green transition">
                        View All
                    </a>
                </div>
                
                <div class="space-y-4">
                    <?php if($recent_donations_result && mysqli_num_rows($recent_donations_result) > 0): ?>
                        <?php while($donation = mysqli_fetch_assoc($recent_donations_result)): ?>
                            <div class="activity-card">
                                <div class="flex items-start space-x-4">
                                    <?php if($donation['image'] && file_exists('uploads/'.$donation['image'])): ?>
                                        <img src="uploads/<?php echo $donation['image']; ?>" alt="Donation" class="w-16 h-16 rounded-lg object-cover">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 mb-1"><?php echo htmlspecialchars($donation['helper_name']); ?></h4>
                                        <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars(substr($donation['description'], 0, 80)) . '...'; ?></p>
                                        <div class="flex flex-wrap gap-1 mb-2">
                                            <?php 
                                                $items = explode(',', $donation['items_donated']);
                                                foreach (array_slice($items, 0, 3) as $item) {
                                                    echo "<span class='bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs'>" . htmlspecialchars(trim($item)) . "</span>";
                                                }
                                                if (count($items) > 3) {
                                                    echo "<span class='text-gray-500 text-xs'>+" . (count($items) - 3) . " more</span>";
                                                }
                                            ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
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
                            <p class="text-gray-500">No donations found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-2xl font-bold primary-green mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="admin_requests.php" class="flex items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                    <i class="fas fa-tasks text-2xl mr-3" style="color: #145F2A;"></i>
                    <div>
                        <h3 class="font-semibold primary-green">Manage Requests</h3>
                        <p class="text-sm text-gray-600">Review and approve requests</p>
                    </div>
                </a>
                <a href="post_request.php" class="flex items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <i class="fas fa-plus-circle text-2xl mr-3" style="color: #145F2A;"></i>
                    <div>
                        <h3 class="font-semibold primary-green">Create Request</h3>
                        <p class="text-sm text-gray-600">Add new help request</p>
                    </div>
                </a>
                <a href="success_story.php" class="flex items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <i class="fas fa-star text-2xl mr-3" style="color: #145F2A;"></i>
                    <div>
                        <h3 class="font-semibold primary-green">Success Stories</h3>
                        <p class="text-sm text-gray-600">View donations</p>
                    </div>
                </a>
                <a href="#" class="flex items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                    <i class="fas fa-chart-bar text-2xl mr-3" style="color: #145F2A;"></i>
                    <div>
                        <h3 class="font-semibold primary-green">Reports</h3>
                        <p class="text-sm text-gray-600">View analytics</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        // Auto-refresh dashboard every 30 seconds
        setInterval(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
