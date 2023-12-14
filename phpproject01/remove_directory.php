

<?php
include 'includes/dbh.inc.php';
include_once 'header.php';
include_once 'footer.php';
include_once 'includes/functions.inc.php';



// Query to get user information from directory
$query = "SELECT usersId, usersName, usersEmail, role FROM directory";
$result = mysqli_query($conn, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Directory</title>
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
        .apartment-btn {
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
        .apartment-btn:hover {
            background-color: #45a049; 
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
            <th>User Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $users): ?>
        <tr>
            <td><?php echo $users['usersName']; ?></td>
            <td><?php echo $users['usersEmail']; ?></td>
            <td><?php echo $users['role']; ?></td>
	    <td><a href="directory.php?delid=<?php echo $users['usersId']; ?>" class="apartment-btn">Remove</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="directory.php" class="apartment-btn">Back</a>

</body>
</html>
