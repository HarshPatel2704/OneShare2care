<?php
session_start();
include 'db_connect.php';

// Updated query to exclude fulfilled requests
 $sql = "SELECT r.*, u.name, u.city 
        FROM requests r 
        JOIN users u ON r.user_id = u.user_id 
        WHERE r.status='Approved' AND r.is_fulfilled = FALSE 
        ORDER BY r.request_date DESC";
 $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Requests - ShareForCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        .request-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        .category-badge {
            background-color: #F8F3E7;
            color: #145F2A;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
        }
        .contact-info {
            display: flex;
            align-items: center;
            color: #6B7280;
            font-size: 0.875rem;
            margin-bottom: 8px;
        }
        .contact-info i {
            color: #145F2A;
            margin-right: 8px;
            width: 16px;
        }
        .urgency-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #FFC107;
            color: #145F2A;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include 'header.php'; ?>
    
    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h2 class="text-sm font-semibold uppercase tracking-wider mb-2 accent-yellow">Help Requests</h2>
            <h1 class="text-4xl font-bold primary-green" style="font-family: Georgia, 'Times New Roman', Times, serif;">Make a Difference Today</h1>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">These help requests are waiting for your support. Your contribution can make a real difference in someone's life.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="request-card relative">
                        <span class="urgency-badge">
                            <i class="fas fa-clock mr-1"></i>Urgent
                        </span>
                        <?php if($row['image'] && file_exists('uploads/'.$row['image'])): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" alt="Request Image" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <h2 class="text-xl font-bold primary-green"><?php echo htmlspecialchars($row['name']); ?></h2>
                                <span class="text-gray-500 text-sm"><?php echo htmlspecialchars($row['city']); ?></span>
                            </div>
                            <div class="category-badge mb-4">
                                <i class="fas fa-list mr-2"></i><?php echo htmlspecialchars($row['category']); ?>
                            </div>
                            <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            <div class="contact-info">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($row['location']); ?></span>
                            </div>
                            <div class="contact-info">
                                <i class="fas fa-phone"></i>
                                <span><?php echo htmlspecialchars($row['contact_no']); ?></span>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="request_detail.php?id=<?php echo $row['request_id']; ?>" 
                                    class="block w-full bg-primary-green text-white py-2 rounded-lg font-semibold hover:bg-secondary-green transition text-center">
                                    <i class="fas fa-hand-holding-heart mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='no-requests col-span-full'>";
                echo "<i class='fas fa-check-circle text-5xl mb-4' style='color: #145F2A;'></i>";
                echo "<h3 class='text-xl font-semibold primary-green mb-2'>All requests have been fulfilled!</h3>";
                echo "<p class='text-gray-600'>Thank you to our community for their generosity. Check back later for new requests.</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
