<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Not logged in, redirect to home page
    header("Location: login.php");
    exit();
}
?>

<?php
include 'db_connect.php';

$success_message = "";
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $user_id = $_POST['user_id'];
    $user_id = $_SESSION['user_id'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $contact_no = $_POST['contact_no'];

    // Handle image upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image = time() . "_" . basename($_FILES['image']['name']); // unique file name
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = "uploads/";
        if (!move_uploaded_file($tmp_name, $upload_dir.$image)) {
            $error_message = "Failed to upload image.";
        }
    }

    if ($error_message === "") {
        $sql = "INSERT INTO requests (user_id, category, description, image, location, contact_no)
                VALUES ('$user_id','$category','$description','$image','$location','$contact_no')";
        if(mysqli_query($conn, $sql)){
            $success_message = "Request sent to admin for verification!";
        } else {
            $error_message = "Error: ".mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Help Request - ShareForCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'header.php'; ?>
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Post a Help Request</h1>
            <p class="text-gray-600">Share your need with our community. Fill in the details below and our team will verify your request.</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if($success_message != ""): ?>
            <div class="mb-4 bg-green-100 border-l-4 border-green-600 p-4 rounded">
                <p class="text-green-700 font-semibold"><i class="fas fa-check-circle mr-2"></i><?php echo $success_message; ?></p>
            </div>
        <?php elseif($error_message != ""): ?>
            <div class="mb-4 bg-green-100 border-l-4 border-green-600 p-4 rounded">
                <p class="text-green-700 font-semibold"><i class="fas fa-exclamation-circle mr-2"></i><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form id="postRequestForm" method="POST" enctype="multipart/form-data">
                <!-- Category Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-list text-green-800 mr-2"></i>Select Category
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php 
                        $categories = ["Food" => "utensils", "Medical" => "heartbeat", "Education" => "book", "Shelter" => "home", "Clothing" => "shirt", "Other" => "ellipsis-h"];
                        foreach($categories as $cat => $icon): ?>
                        <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-600 transition">
                            <input type="radio" name="category" value="<?php echo $cat; ?>" required class="w-4 h-4 text-green-600">
                            <span class="ml-3 text-gray-700">
                                <i class="fas fa-<?php echo $icon; ?> text-green-800 mr-2"></i><?php echo $cat; ?>
                            </span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="location" class="block text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-map-marker-alt text-green-800 mr-2"></i>Location
                    </label>
                    <input type="text" id="location" name="location" placeholder="Enter your city/area" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-green-600 transition">
                </div>

                <div class="mb-8">
                    <label for="contact_no" class="block text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-phone text-green-800 mr-2"></i>Contact Number
                    </label>
                    <input type="tel" id="contact_no" name="contact_no" placeholder="Enter your phone number" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-green-600 transition">
                </div>

                <div class="mb-8">
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-pen text-green-800 mr-2"></i>Detailed Description
                    </label>
                    <textarea id="description" name="description" rows="6" placeholder="Please describe your situation in detail. This helps our community understand your need better..."
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-green-600 transition resize-none" required></textarea>
                    <p class="text-sm text-gray-500 mt-2">Minimum 20 characters required</p>
                </div>

                <!-- Image Upload -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-image text-green-800 mr-2"></i>Upload Image (Optional)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-green-600 transition cursor-pointer" id="dropZone">
                        <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600 font-medium">Drag and drop your image here</p>
                        <p class="text-gray-500 text-sm">or <span class="text-green-800 cursor-pointer font-semibold" onclick="document.getElementById('image').click()">click to browse</span></p>
                        <p class="text-gray-400 text-xs mt-2">Supported formats: JPG, PNG, GIF (Max 5MB)</p>
                    </div>
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImg" src="/placeholder.svg" alt="Preview" class="max-h-64 rounded-lg mx-auto">
                        <button type="button" onclick="removeImage()" class="mt-2 text-green-600 text-sm font-semibold hover:text-green-700">
                            <i class="fas fa-trash mr-1"></i>Remove Image
                        </button>
                    </div>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="user_id" value="1"> <!-- Replace with logged in user_id -->

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button type="submit" name="submit" class="flex-1 bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Request
                    </button>
                    <button type="reset" class="flex-1 bg-gray-200 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Clear Form
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Drag and drop functionality
        const dropZone = document.getElementById('dropZone');
        const imageInput = document.getElementById('image');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-green-600', 'bg-green-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-green-600', 'bg-green-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-green-600', 'bg-green-50');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                previewImage({ target: { files: files } });
            }
        });

        // Image preview
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Remove image
        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        }
    </script>
</body>
</html>
