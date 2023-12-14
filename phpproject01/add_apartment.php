<?php
session_start(); 

include_once 'header.php';
include 'includes/dbh.inc.php';

// check if the user is logged in and has a management role
if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'management') {
    header('Location: login.php'); 
    exit();
}

$message = '';

//Insert data into the form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(
        !empty($_POST['apartment_number']) && 
        !empty($_POST['floor_number']) &&
        !empty($_POST['bedrooms']) &&
        !empty($_POST['bathrooms']) &&
        !empty($_POST['status']) &&
        !empty($_POST['description']) &&
        !empty($_POST['rent_amount']) &&
        !empty($_POST['image_url'])
    ) {
        $apartment_number = $_POST['apartment_number'];
        $floor_number = $_POST['floor_number'];
        $bedrooms = $_POST['bedrooms'];
        $bathrooms = $_POST['bathrooms'];
        $status = $_POST['status'];
        $description = $_POST['description'];
        $rent_amount = $_POST['rent_amount'];
        $image_url = $_POST['image_url'];

        $sql = "INSERT INTO Apartments (apartment_number, floor_number, bedrooms, bathrooms, status, description, rent_amount, image_url) VALUES ('$apartment_number', '$floor_number', '$bedrooms', '$bathrooms', '$status', '$description', '$rent_amount', '$image_url')";

        if ($conn->query($sql) === TRUE) {
            $message = "Apartment added successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "All fields required";
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 40px;
        background-color: #1e1e1e; 
        color: #ffffff; 
    }
    form {
        background-color: #2c2c2c; 
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
    }
    input, select, textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #555; 
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #3a3a3a; 
        color: #ffffff; 
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
    p {
        color: #ff6969; 
    }
    input[type="submit"] {
    background-color: #4CAF50; 
    color: white; 
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    }

input[type="submit"]:hover {
    background-color: #45a049; 
}
    
</style>

<?php if($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form action="add_apartment.php" method="post">
    Apartment Number: <input type="text" name="apartment_number"><br>
    Floor Number: <input type="number" name="floor_number"><br>
    Bedrooms: <input type="number" name="bedrooms"><br>
    Bathrooms: <input type="number" name="bathrooms"><br>
    Status: 
    <select name="status">
        <option value="Available">Available</option>
        <option value="Occupied">Occupied</option>
        <option value="Under Maintenance">Under Maintenance</option>
    </select><br>
    Description: <textarea name="description"></textarea><br>
    Rent Amount: <input type="text" name="rent_amount"><br>
    Image URL: <input type="text" name="image_url"><br>
    <input type="submit" value="Add Apartment">
</form>

<?php
include_once 'footer.php';
?>
