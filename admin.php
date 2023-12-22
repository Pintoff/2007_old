<?php
require 'dbConnect.php';

if ($_POST['action'] == 'updateAdminName') {
    $adminId = $_POST['adminId'];
    $newAdminName = $_POST['newAdminName'];

    // Update the admin name in the database
    $sql = "UPDATE users SET FirstName = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newAdminName, $adminId);

    if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Admin name updated successfully']);
    } else {
    echo json_encode(['success' => false, 'message' => 'Error updating admin name']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>