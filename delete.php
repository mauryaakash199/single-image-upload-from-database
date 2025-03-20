<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch file name from DB
    $sql = "SELECT file_name FROM images WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $filePath = 'uploads/' . $row['file_name'];

        // Delete image file from folder
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete record from database
        $deleteQuery = "DELETE FROM images WHERE id = $id";
        mysqli_query($conn, $deleteQuery);

        // Redirect back with success message
        header("Location: view.php?deleted=1");
        exit();
    } else {
        echo "Image not found!";
    }
} else {
    echo "Invalid Request!";
}
?>
