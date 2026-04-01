<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <style>
    input[type="file"]::file-selector-button {
        background-color: #198754;
        border: 2px solid #198754;
        padding: 0.5em 1em;
        border-radius: 0.4em;
        color: white;
        cursor: pointer;
        /* Add hover effect */
        transition: background-color 0.3s; 
        margin-bottom: 20px;
}

input[type="file"]::file-selector-button:hover {
  background-color: #157347;
  border: 2px solid #146c43;
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-content-center mb-4">
    <h3>Add New Post</h3>
    <a href="logout.php" class="btn btn-outline-danger btn-sm" title="Logout">Logout</a>
</div>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Post Title" required /><br /><br />
        <textarea name="content" placeholder="Write content..." required></textarea><br />
        <label>Select Image:</label><br />
        <input type="file" name="image" /><br />
        <button type="submit" name="submit" class="btn btn-primary">Publish</button>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        // set Time Zone
        
        
        // // get file ext
        // $ext = strtolower(pathinfo ($image_name, PATHINFO_EXTENSION));
        // // Ext allowed
        // $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        // if(!in_array($ext, $allowed)){
        //     echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
        //     exit();
        // }

        $allowed = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf'
        ];
        if(isset($_FILES['image'])){
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            // check if file ext is in the array
            if (!array_key_exists($ext, $allowed)){
                die("Error: Invalid File Extension.");
            }
            // verify the actual file content (MIME TYPE)
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $real_mime = $finfo->file($file_tmp);
            if ($real_mime !== $allowed[$ext]){
                die("Error: File content does not match it's extension.");
            }
        }
        
        date_default_timezone_set('America/New_York');
        // image upload handling
        $image = $_FILES['image']['name'];
        $image_name = date('YmdHis') . basename($image);
        $target = "uploads/" . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Failed to upload image (or no image selected)";
            $image_name = null; // set null if fails
        }

        $sql = "INSERT INTO posts (title, content, image) VALUES ('$title', '$content', '$image_name')";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Post published successfully!</p>";
        }
    }
    ?>
</body>
</html>

