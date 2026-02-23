<?php
session_start();
include 'header.php';
include 'db_connect.php';


// Query to get all requests with fulfillment status
 $sql = "SELECT r.*, u.name, u.city 
        FROM requests r 
        JOIN users u ON r.user_id = u.user_id 
        ORDER BY r.request_date DESC";
 $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Requests - ShareForCare Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">All Help Requests</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $status_class = $row['is_fulfilled'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                    $status_text = $row['is_fulfilled'] ? 'Fulfilled' : 'Pending';
                    ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden <?php echo $row['is_fulfilled'] ? 'opacity-75' : ''; ?>">
                        <?php if($row['image'] && file_exists('uploads/'.$row['image'])): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" alt="Request Image" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <h2 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($row['name']); ?></h2>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $status_class; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </div>
                            <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($row['city']); ?></p>
                            <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            <div class="text-sm text-gray-600">
                                <p><i class="fas fa-map-marker-alt mr-2"></i><?php echo htmlspecialchars($row['location']); ?></p>
                                <p><i class="fas fa-phone mr-2"></i><?php echo htmlspecialchars($row['contact_no']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</body>
</html>