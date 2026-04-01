<?php
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
    <h3 class="p-4">Latest Posts</h3>
    <hr />
    <div class="container">
    <div class="row">
    <?php
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-md-4 text-center'>
                <div class='card h-100 shadow-sm text-center'>";
            echo "<h3 class='card-title'>" . $row['title'] . "</h3>";
            if (!empty($row['image'])) {
                echo "<img src='uploads/" . $row['image'] . "' style='width:300px; height:auto;' class='mx-auto'><br />";
            }
            echo "<p class='card-text text-muted small ps-2'>Published on: " . $row['created_at'] . "</p>";
            echo "<p class='card-text pb-4'>" . $row['content'] . "</p>";
            echo "</div></div><hr class='text-white' />";
        }
    } else {
        echo "No posts yet!";
    }

?>
    </div>
</div>
</body>
</html>