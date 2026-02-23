<?php
session_start();
include 'db_connect.php';
include 'header.php';

if (!isset($_GET['id'])) {
    echo "<div class='text-center text-red-600 mt-10'>Invalid Request!</div>";
    include 'footer.php';
    exit;
}

$request_id = intval($_GET['id']);
$sql = "SELECT r.*, u.name AS user_name, u.city, u.contact_no, u.email 
        FROM requests r 
        JOIN users u ON r.user_id = u.user_id 
        WHERE r.request_id = $request_id AND r.status = 'Approved'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<div class='text-center text-red-600 mt-10'>No approved request found.</div>";
    include 'footer.php';
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($row['title']); ?> - ShareForCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">

  <!-- Left Section -->
  <div class="lg:col-span-2 bg-white shadow-md rounded-xl overflow-hidden">
    <!-- Image -->
    <?php if ($row['image'] && file_exists("uploads/".$row['image'])): ?>
      <img src="uploads/<?php echo $row['image']; ?>" class="w-full h-72 object-cover" alt="Request Image">
    <?php else: ?>
      <div class="w-full h-72 bg-gray-200 flex items-center justify-center text-gray-500">
        No image available
      </div>
    <?php endif; ?>

    <!-- Content -->
    <div class="p-6">
      <h1 class="text-3xl font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($row['title']); ?></h1>
      <!-- <span class="inline-block bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full mb-4">
       php echo htmlspecialchars($row['category']); ?>
      </span> -->

      <p class="text-gray-700 mb-6 leading-relaxed"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>

      <h2 class="text-lg font-semibold text-gray-800 mb-2">Items Needed:</h2>
      <div class="flex flex-wrap gap-2 mb-6">
        <?php
          $items = explode(',', $row['category'] ?? '');
          foreach($items as $item) {
              echo "<span class='bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm'>" . htmlspecialchars(trim($item)) . "</span>";
          }
        ?>
      </div>

      <div class="space-y-3 text-gray-700">
        <p><i class="fa-solid fa-location-dot text-blue-600 mr-2"></i>
          <strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>

        <p><i class="fa-solid fa-phone text-blue-600 mr-2"></i>
          <strong>Contact:</strong> <?php echo htmlspecialchars($row['contact_no']); ?></p>
      </div>
    </div>
  </div>

  <!-- Right Section (Action Card) -->
<!-- Right Section (Action Card) -->
<div>
  <div class="bg-[#145F2A] text-white rounded-xl shadow-lg p-6 sticky top-10">
    <h2 class="text-xl font-semibold mb-4">Take Action</h2>

    <?php
    // Check if user is logged in
    $isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    $redirectUrl = $isLoggedIn ? "donate.php?id={$row['request_id']}" : "login.php?redirect=donate.php&id={$row['request_id']}";
    ?>
    
    <a href="<?php echo $redirectUrl; ?>"
       class="block bg-[#0B874B] hover:bg-[#09693B] text-white font-semibold text-center py-3 rounded-lg mb-4">
       I Want to Help
    </a>

    <p class="text-sm text-green-100 mb-6">
      <?php if ($isLoggedIn): ?>
        Click to commit to helping. You'll be able to coordinate with the poster and share your impact after donating.
      <?php else: ?>
        Please log in to help with this request. After logging in, you'll be able to coordinate with the poster.
      <?php endif; ?>
    </p>

    <hr class="border-green-400 mb-4">

    <h3 class="text-sm text-green-200 mb-2">Posted by</h3>
    <div class="flex items-center space-x-3">
      <div class="bg-white text-[#145F2A] w-10 h-10 flex items-center justify-center rounded-full font-bold text-lg">
        <?php echo strtoupper(substr($row['user_name'], 0, 1)); ?>
      </div>
      <div>
        <p class="font-semibold"><?php echo htmlspecialchars($row['user_name']); ?></p>
        <p class="text-sm text-green-100">Community Helper</p>
      </div>
    </div>
  </div>
</div>

  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
