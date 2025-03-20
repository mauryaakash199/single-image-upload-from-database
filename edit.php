<?php
include 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request!");
}

$id = intval($_GET['id']);

// Fetch existing image data securely
$stmt = mysqli_prepare($conn, "SELECT file_name FROM images WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $currentImage);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$currentImage) {
    die("Image not found!");
}

$message = '';

if (isset($_POST['update'])) {
    $newImage = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    if (!empty($newImage)) {
        $uploadDir = "uploads/";
        $fileExtension = strtolower(pathinfo($newImage, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type
        if (in_array($fileExtension, $allowed)) {
            $newFileName = uniqid() . "." . $fileExtension;
            $targetPath = $uploadDir . $newFileName;

            // Move file
            if (move_uploaded_file($tmpName, $targetPath)) {
                // Delete old image
                if (file_exists($uploadDir . $currentImage)) {
                    unlink($uploadDir . $currentImage);
                }

                // Update database
                $updateStmt = mysqli_prepare($conn, "UPDATE images SET file_name = ? WHERE id = ?");
                mysqli_stmt_bind_param($updateStmt, "si", $newFileName, $id);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);

                header("Location: view.php?updated=1");
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Failed to upload new image.</div>";
            }
        } else {
            $message = "<div class='alert alert-warning'>Invalid file type. Only JPG, PNG, GIF allowed.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please select a new image to upload.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Image</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .card-img-top {
      height: 250px;
      object-fit: cover;
      border-radius: 12px;
    }
    .container {
      max-width: 600px;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h4>Edit Image</h4>
    </div>
    <div class="card-body">
      <?php echo $message; ?>

      <div class="text-center mb-3">
        <img src="uploads/<?php echo htmlspecialchars($currentImage); ?>" class="img-fluid rounded shadow-sm" alt="Current Image">
      </div>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Select New Image:</label>
          <input type="file" name="image" class="form-control" required>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" name="update" class="btn btn-success">Update Image</button>
          <a href="view.php" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
