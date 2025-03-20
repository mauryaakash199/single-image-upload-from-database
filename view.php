<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Uploaded Images</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">Uploaded Images</h3>

  <?php
  // Success Message after deletion
  if (isset($_GET['deleted'])) {
      echo '<div class="alert alert-danger">Image deleted successfully!</div>';
  }
  ?>

  <div class="row">

    <?php
    $sql = "SELECT * FROM images ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="card">';
            echo '<img src="uploads/' . $row['file_name'] . '" class="card-img-top" style="height:200px; object-fit:cover;">';
            echo '<div class="card-body text-center">';
            echo '<a href="edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-dark me-2">Edit</a>';
            echo '<a href="delete.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this image?\')">Delete</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No images found.</p>';
    }
    ?>

  </div>
  <a href="index.php" class="btn btn-secondary mt-3">Upload More</a>
</div>

</body>
</html>
