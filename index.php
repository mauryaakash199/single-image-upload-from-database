<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Image Upload</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h3>Upload Image</h3>
    </div>
    <div class="card-body">
      <?php
      if (isset($_POST['submit'])) {
          $fileName = $_FILES['image']['name'];
          $fileTmpName = $_FILES['image']['tmp_name'];
          $targetDir = "uploads/" . basename($fileName);

          if (move_uploaded_file($fileTmpName, $targetDir)) {
              $sql = "INSERT INTO images (file_name) VALUES ('$fileName')";
              if (mysqli_query($conn, $sql)) {
                  echo '<div class="alert alert-success">Image uploaded successfully.</div>';
              } else {
                  echo '<div class="alert alert-danger">Database error.</div>';
              }
          } else {
              echo '<div class="alert alert-danger">Failed to upload image.</div>';
          }
      }
      ?>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="image" class="form-label">Choose Image:</label>
          <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Upload</button>
        <a href="view.php" class="btn btn-success">View Images</a>
      </form>
    </div>
  </div>
</div>

</body>
</html>
