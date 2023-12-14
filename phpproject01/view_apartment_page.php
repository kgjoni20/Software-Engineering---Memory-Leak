
<?php
include_once 'header.php';

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

include 'includes/dbh.inc.php';
include_once 'includes/functions.inc.php';

//Query to display apartment table
$query = "SELECT * FROM Apartments";
$result = mysqli_query($conn, $query);
$apartments = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
            width: 100%;
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
            <th>ID</th>
            <th>Apartment Number</th>
            <th>Floor Number</th>
            <th>Bedrooms</th>
            <th>Bathrooms</th>
            <th>Status</th>
            <th>Description</th>
            <th>Rent Amount</th>
            <th>Picture</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($apartments as $apartment): ?>
        <tr>
            <td><?php echo $apartment['apartment_id']; ?></td>
            <td><?php echo $apartment['apartment_number']; ?></td>
            <td><?php echo $apartment['floor_number']; ?></td>
            <td><?php echo $apartment['bedrooms']; ?></td>
            <td><?php echo $apartment['bathrooms']; ?></td>
            <td><?php echo $apartment['status']; ?></td>
            <td><?php echo $apartment['description']; ?></td>
            <td><?php echo $apartment['rent_amount']; ?></td>
            <td><img src="<?php echo $apartment['image_url']; ?>" alt="Apartment Image"></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
if (isset($_SESSION['role']) && $_SESSION['role'] == 'management') {
    echo '<a href="add_apartment.php" class="apartment-btn">Add Apartment</a>';
    echo '<a href="edit_apartment.php" class="apartment-btn">Edit Apartment</a>';
}
?>
</body>
</html>
