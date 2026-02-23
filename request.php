<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $contact_no = $_POST['contact_no'];

    // Upload needy person photo
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp_name, "uploads/$image");

    $sql = "INSERT INTO requests (user_id, category, description, image, location, contact_no, request_date, status)
            VALUES ('$user_id','$category','$description','$image','$location','$contact_no', NOW(), 'Pending')";

    if (mysqli_query($conn, $sql)) {
        echo "Request posted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    User ID: <input type="number" name="user_id" required><br>
    Category: <input type="text" name="category" required><br>
    Description: <textarea name="description" required></textarea><br>
    Location: <input type="text" name="location"><br>
    Contact No: <input type="text" name="contact_no"><br>
    Photo: <input type="file" name="image"><br>
    <input type="submit" value="Post Request">
</form>
