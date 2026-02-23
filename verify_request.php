<?php
include 'db_connect.php';

if(isset($_GET['action'], $_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if($action == 'approve'){
        $sql = "UPDATE requests SET status='Approved' WHERE request_id='$id'";
    } elseif($action == 'reject'){
        $sql = "UPDATE requests SET status='Rejected' WHERE request_id='$id'";
    }

    mysqli_query($conn, $sql);
    header("Location: admin_requests.php");
    exit();
}
?>
