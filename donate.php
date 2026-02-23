<?php
session_start();
include 'db_connect.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $request_id = $_POST['request_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $items_donated = mysqli_real_escape_string($conn, $_POST['items_donated']);

    // Get user information from the users table
    $user_query = "SELECT name, photo FROM users WHERE user_id = '$user_id'";
    $user_result = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $helper_name = $user_data['name'];
    $helper_image = $user_data['photo'];

    // Handle image upload
    $photo = '';
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        $target = "uploads/" . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert into success_stories
        $sql = "INSERT INTO success_stories (helper_name, helper_image, image, description, items_donated)
                VALUES ('$helper_name', '$helper_image', '$photo', '$description', '$items_donated')";
        mysqli_query($conn, $sql);

        // Update the request to mark it as fulfilled
        $update_sql = "UPDATE requests SET is_fulfilled = TRUE WHERE request_id = '$request_id'";
        mysqli_query($conn, $update_sql);

        // Commit transaction
        mysqli_commit($conn);

        // Redirect to success page
        header("Location: success_story.php");
        exit();
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($conn);
        echo "<div style='color:red;text-align:center;margin-top:20px;'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donate - ShareForCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
      body {
          font-family: 'Poppins', sans-serif;
          background-color: #f9f9f9;
      }
      .card {
          background: #ffffff;
          border-radius: 20px;
          box-shadow: 0 10px 20px rgba(0,0,0,0.08);
          padding: 2rem;
          max-width: 700px;
          margin: 40px auto;
          transition: all 0.3s ease;
      }
      .card:hover {
          transform: translateY(-4px);
          box-shadow: 0 15px 30px rgba(0,0,0,0.12);
      }
      .btn-submit {
          background-color: #145F2A;
          color: white;
          font-weight: 600;
          padding: 10px 0;
          border-radius: 8px;
          transition: background 0.3s ease;
      }
      .btn-submit:hover {
          background-color: #0B4E3D;
      }
      .form-label {
          color: #145F2A;
          font-weight: 500;
          margin-bottom: 6px;
          display: block;
      }
      .form-input, .form-textarea {
          width: 100%;
          border: 1px solid #ddd;
          border-radius: 8px;
          padding: 10px;
          font-size: 15px;
          margin-bottom: 15px;
          outline: none;
          transition: border 0.2s ease;
      }
      .form-input:focus, .form-textarea:focus {
          border-color: #145F2A;
          box-shadow: 0 0 0 2px rgba(20, 95, 42, 0.2);
      }
      .upload-box {
          border: 2px dashed #aaa;
          padding: 25px;
          border-radius: 10px;
          text-align: center;
          color: #666;
          margin-bottom: 20px;
      }
      .upload-box:hover {
          border-color: #145F2A;
          color: #145F2A;
      }
  </style>
</head>
<body>

<div class="card">
  <h2 class="text-2xl font-bold text-center text-[#145F2A] mb-4">Share Your Donation</h2>
  <p class="text-gray-600 text-center mb-6">Upload a photo and describe what you donated to help others.</p>

  <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="request_id" value="<?php echo $_GET['id'] ?? ''; ?>">
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?? ''; ?>">

      <label class="form-label">Upload Donation Photo *</label>
      <div class="upload-box">
          <input type="file" name="photo" required>
      </div>

      <label class="form-label">Description *</label>
      <textarea name="description" class="form-textarea" rows="4" placeholder="Describe your donation and the impact it made..." required></textarea>

      <label class="form-label">Items Donated *</label>
      <input type="text" name="items_donated" class="form-input" placeholder="e.g. Clothes, Books, Food Packets" required>

      <button type="submit" class="btn-submit w-full mt-4">Share My Impact</button>
  </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>