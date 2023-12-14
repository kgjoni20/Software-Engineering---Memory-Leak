<?php
error_reporting(0);
include 'includes/dbh.inc.php';
include_once 'header.php';
include_once 'footer.php';
include_once 'includes/functions.inc.php';


// check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

// get the userid  that is going to be added from add page
$userId = $_GET['id'];

// get the userid that  is going to be deleted from remove page
$deluserId = $_GET['delid'];

// Insert entry into the database
if (isset($userId)) {
    $query = "SELECT u.usersId, u.usersName, u.usersEmail, u.role, u.user_apartment_id, a.apartment_number FROM Users u LEFT JOIN apartments a ON u.user_apartment_id = a.apartment_id WHERE u.usersId = '$userId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $usersId = $row['usersId'];
            $usersName = $row['usersName'];
            $usersEmail = $row['usersEmail'];
            $role = $row['role'];
	    $apartmentId = $row['user_apartment_id'];
            $apartmentNumber = $row['apartment_number'];
        } else {
            echo "No matching rows found";
        }
    }
    $sql = "INSERT INTO directory (usersId, usersName, usersEmail, role, apartment_id, apartment_number) VALUES ('$usersId', '$usersName', '$usersEmail','$role','$apartmentId', '$apartmentNumber')";
    if (mysqli_query($conn, $sql)) {
        echo "Added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} 

// Remove user from directory database
if (isset($deluserId)) {
    $sql = "DELETE FROM directory WHERE usersId = '$deluserId'";
    if (mysqli_query($conn, $sql)) {
        echo "Removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} 

$query = "SELECT usersId, usersName, usersEmail, role, apartment_id, apartment_number FROM directory";
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
            <th>Apartment Number</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo ($user['usersName']); ?></td>
            <td><?php echo ($user['usersEmail']); ?></td>
            <td><?php echo ($user['role']); ?></td>
            <td><?php echo ($user['apartment_number']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
// check if user is management to display add and remove operations
if (isset($_SESSION['role']) && $_SESSION['role'] == 'management') {
    echo '<a href="add_directory.php" class="apartment-btn">Add User</a>';
    echo '<a href="remove_directory.php" class="apartment-btn">Remove User</a>';
}
?>



</body>
</html>
