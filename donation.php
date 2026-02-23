<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $donor_id = $_POST['donor_id'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    // Upload proof image
    $proof_image = $_FILES['proof_image']['name'];
    $tmp_name = $_FILES['proof_image']['tmp_name'];
    move_uploaded_file($tmp_name, "uploads/$proof_image");

    $sql = "INSERT INTO donations (request_id, donor_id, donation_date, location, proof_image, description)
            VALUES ('$request_id','$donor_id', NOW(), '$location','$proof_image','$description')";

    if (mysqli_query($conn, $sql)) {
        echo "Donation recorded successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    Request ID: <input type="number" name="request_id" required><br>
    Donor ID: <input type="number" name="donor_id" required><br>
    Description: <textarea name="description" required></textarea><br>
    Location: <input type="text" name="location"><br>
    Proof Image: <input type="file" name="proof_image"><br>
    <input type="submit" value="Submit Donation">
</form>
