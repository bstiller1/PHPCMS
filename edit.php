<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include('db.php');

$id = (int)$_GET['id'];
// fetch current data
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id = $id");
$post = mysqli_fetch_assoc($result);
// handle update
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
    <form method="POST">
        <input type="text" name="title" value="<?php echo $post['title']; ?>" required /><br />
        <textarea name="content" required><?php echo $post['content']; ?></textarea><br />
        <button type="submit" name="update">Update Post</button>
    </form>
    
</body>
</html>