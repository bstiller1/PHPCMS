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
    <title>Manage Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
    <h3 class="ms-2">Manage Posts</h3>
    <table class="table table-hover border">
        <thead class="table-light">
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th class="text-end">Edit / Delete</th>
        </tr>
</thead>
<tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td class='text-end'>
                    <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a> |
                    <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    
</body>
</html>