

<?php
include 'includes/dbh.inc.php';
include_once 'header.php';
include_once 'footer.php';
include_once 'includes/functions.inc.php';

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
 }

$query = "SELECT * FROM notices";
$result = mysqli_query($conn, $query);
$notices = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Apartments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333333;
        }

        table {
            width: 80%;
            max-width: 1200px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #333;
        }

        thead th {
            padding: 10px;
            border: 1px solid black;
            background-color: #555;
        }

        tbody td {
            padding: 10px;
            border: 1px solid black;
            background-color: #444;
        }

        img {
            display: block;
            max-width: 100%;
            height: auto;
            border: none;
            box-shadow: none;
        }

        table, thead, tbody, th, td, tr {
            text-align: center;
            color: white;
        }
        .notice-btn {
            display: block;
            width: 200px;
            margin: 10px auto 20px;
            padding: 10px 15px;
            text-align: center;
            background-color: #4CAF50; 
            color: white; 
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease; 
        }
        thead th, tbody td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<table>
    <thead>
        <tr>
	    <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
            <th>Post_Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notices as $notices): ?>
        <tr>
            <td><?php echo $notices['notice_id']; ?></td>
            <td><?php echo $notices['title']; ?></td>
            <td><a href="view_notice.php?id=<?php echo $notices['notice_id']; ?>" class="notice-btn">View Complete Details</a></td>
            <td><?php echo $notices['author']; ?></td>
            <td><?php echo $notices['post_date']; ?></td>
	    <td><a href="notices.php?delid=<?php echo $notices['notice_id']; ?>" class="notice-btn">Remove</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
	<a href="notices.php" class="notice-btn">Back</a>
</body>
</html>
