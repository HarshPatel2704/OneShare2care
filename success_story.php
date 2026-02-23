<?php
session_start();
include('db_connect.php');
include 'header.php';

 $sql = "SELECT * FROM success_stories ORDER BY created_at DESC";
 $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Stories - ShareForCare</title>
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
        .story-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .story-card:hover {
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
        .helper-info {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        .helper-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #145F2A;
            margin-right: 12px;
        }
        .helper-details h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #145F2A;
        }
        .helper-details p {
            margin: 0;
            font-size: 0.875rem;
            color: #6B7280;
        }
        .time {
            font-size: 0.75rem;
            color: #6B7280;
            display: flex;
            align-items: center;
        }
        .time i {
            margin-right: 6px;
            color: #145F2A;
        }
        .no-stories {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        .no-stories i {
            color: #145F2A;
            font-size: 3rem;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h2 class="text-sm font-semibold uppercase tracking-wider mb-2 accent-yellow">Success Stories</h2>
            <h1 class="text-4xl font-bold primary-green" style="font-family: Georgia, 'Times New Roman', Times, serif;">Making a Difference Together</h1>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">These are the stories of generosity and compassion from our community members who have stepped forward to help those in need.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="story-card">
                        <?php if($row['image'] && file_exists('uploads/'.$row['image'])): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" alt="Donation Image" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <div class="helper-info">
                                <?php if($row['helper_image'] && file_exists('uploads/'.$row['helper_image'])): ?>
                                    <img src="uploads/<?php echo $row['helper_image']; ?>" alt="Helper Image" class="helper-avatar">
                                <?php else: ?>
                                    <div class="helper-avatar bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-user text-xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="helper-details">
                                    <h3><?php echo htmlspecialchars($row['helper_name']); ?></h3>
                                    <p>Community Helper</p>
                                </div>
                            </div>
                            
                            <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Items Donated:</h4>
                                <div class="flex flex-wrap gap-2">
                                    <?php 
                                        $items = explode(',', $row['items_donated']);
                                        foreach ($items as $item) {
                                            echo "<span class='category-badge'>".htmlspecialchars(trim($item))."</span>";
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="time">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Shared on <?php echo date('d M Y', strtotime($row['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-stories col-span-full">
                    <i class="fas fa-heart-broken"></i>
                    <h3 class="text-xl font-semibold primary-green mb-2">No success stories found yet</h3>
                    <p class="text-gray-600">Be the first to help and share your story of kindness!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>