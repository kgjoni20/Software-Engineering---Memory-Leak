<?php
require_once 'includes/functions.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'header.php';
error_reporting(0);


if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'management') {
    header('Location: login.php');
    exit();
}

//Query to fetch all maintenance requests 
$sql = "SELECT request_id, usersId, apartment_id, description, urgency, request_status, submitted_at FROM maintenance_requests";
$result = mysqli_query($conn, $sql);
$requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #33333;
        }

        table {
            width: 80%;
            max-width: 2000px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #333;
        }

        thead th {
            padding: 10px;
            border: 1px solid black;
            background-color: #555;
            color: white;
        }

        tbody td {
            padding: 10px;
            border: 1px solid black;
            background-color: #444;
            color: white;
        }

        table, thead, tbody, th, td, tr {
            text-align: center;
        }

	.maintenance-btn {
            display: block;
            width: 120px;
            margin: 10px auto 20px;
            padding: 10px 15px;
            text-align: center;
            background-color: #4CAF50; 
            color: white; 
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease; 
        }

        .maintenance-btn:hover {
            background-color: #45a049; 
        }

        thead th, tbody td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <h2 style="color: white; text-align: center;">Maintenance Requests</h2>
    <table>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>User ID</th>
                <th>Apartment ID</th>
                <th>Description</th>
                <th>Urgency</th>
                <th>Status</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
            <tr>
                <td><?php echo ($request['request_id']); ?></td>
                <td><?php echo ($request['usersId']); ?></td>
                <td><?php echo ($request['apartment_id']); ?></td>
                <td><?php echo ($request['description']); ?></td>
                <td><?php echo ($request['urgency']); ?></td>
                <td><?php echo ($request['request_status']); ?></td>
                <td><?php echo ($request['submitted_at']); ?></td>
                               <td>
                    <a href="response_page.php?request_id=<?php echo $request['request_id']; ?>" class="maintenance-btn">Respond</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>