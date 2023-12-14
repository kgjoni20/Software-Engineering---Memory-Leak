<?php
require_once 'includes/dbh.inc.php'; 
include_once 'header.php';


//check if user is logged in and is resident
if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'resident') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['userid'];


//Query for users profile information
$userSql = "SELECT * FROM users WHERE usersId = $user_id";
$userResult = mysqli_query($conn, $userSql);
$userData = mysqli_fetch_assoc($userResult);

//Query for users apartment information
$apartmentSql = "SELECT * FROM apartments WHERE apartment_id = " . $userData['user_apartment_id'];
$apartmentResult = mysqli_query($conn, $apartmentSql);
$apartmentData = mysqli_fetch_assoc($apartmentResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333333; 
            color: white; 
            padding: 20px;
            font-weight: bold; 
        }
        .profile-container {
            background-color: #444; 
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            padding: 20px;
            max-width: 500px;
            margin: auto;
            text-align: center;
        }
        .profile-info, .apartment-info {
            background-color: #555; 
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            color: white; 
            font-weight: bold; 
        }
        .apartment-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 20px auto;
            object-fit: cover;
            max-height: 300px;
        }
    </style>
</head>
<body>

    <div class="profile-container">
        <div class="profile-header">
            <h2>User Profile</h2>
        </div>
        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo ($userData['usersName']); ?></p>
            <p><strong>Email:</strong> <?php echo ($userData['usersEmail']); ?></p>
            <p><strong>Username:</strong> <?php echo ($userData['usersUid']); ?></p>
            <p><strong>Role:</strong> <?php echo ($userData['role']); ?></p>
        </div>
        <?php if ($apartmentData): ?>
            <div class="apartment-info">
                <h3>Apartment Information</h3>
                <?php if (!empty($apartmentData['image_url'])): ?>
                    <img src="<?php echo ($apartmentData['image_url']); ?>" alt="Apartment Image" class="apartment-image">
                <?php endif; ?>
                <p><strong>Apartment Number:</strong> <?php echo ($apartmentData['apartment_number']); ?></p>
                <p><strong>Floor Number:</strong> <?php echo ($apartmentData['floor_number']); ?></p>
                <p><strong>Bedrooms:</strong> <?php echo ($apartmentData['bedrooms']); ?></p>
                <p><strong>Bathrooms:</strong> <?php echo($apartmentData['bathrooms']); ?></p>
                <p><strong>Status:</strong> <?php echo ($apartmentData['status']); ?></p>
                <p><strong>Rent Amount:</strong> $<?php echo ($apartmentData['rent_amount']); ?></p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
