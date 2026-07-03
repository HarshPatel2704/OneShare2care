<?php 
session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Requests - ShareForCare Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .request-card {
            transition: all 0.3s ease;
        }
        .request-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .btn-approve {
            background-color: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .btn-approve:hover {
            background-color: #059669;
            transform: scale(1.05);
        }
        .btn-reject {
            background-color: #ef4444;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .btn-reject:hover {
            background-color: #dc2626;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Pending Requests</h2>
            <p class="text-gray-600">Review and verify help requests from community members</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            include 'db_connect.php';

            $sql = "SELECT r.*, u.name, u.city FROM requests r JOIN users u ON r.user_id = u.user_id WHERE r.status='Pending' ORDER BY r.request_date ASC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Request Card -->
                    <div class="request-card bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Image Section -->
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                                 alt="Request Image" 
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            <div class="absolute top-3 right-3">
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-red-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($row['name']); ?></h3>
                                    <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($row['city']); ?></p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-tag mr-1"></i><?php echo htmlspecialchars($row['category']); ?>
                                </span>
                            </div>

                            <p class="text-gray-700 text-sm mb-4 line-clamp-3">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </p>

                            <p class="text-xs text-gray-500 mb-4">
                                <strong>Request ID:</strong> #<?php echo htmlspecialchars($row['request_id']); ?>
                            </p>

                            <div class="flex gap-3">
                                <a href="verify_request.php?action=approve&id=<?php echo htmlspecialchars($row['request_id']); ?>" 
                                   class="btn-approve flex-1 text-center">
                                    <i class="fas fa-check mr-1"></i>Approve
                                </a>
                                <a href="verify_request.php?action=reject&id=<?php echo htmlspecialchars($row['request_id']); ?>" 
                                   class="btn-reject flex-1 text-center">
                                    <i class="fas fa-times mr-1"></i>Reject
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                        <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-2">No Pending Requests</h3>
                        <p class="text-gray-600">All requests have been verified. Great work!</p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2025 ShareForCare. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
