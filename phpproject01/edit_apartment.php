<?php
include_once 'header.php';
include 'includes/dbh.inc.php';


// check if the user is logged in and is managment 
if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'management') {
    header('Location: login.php'); 
    exit();
}

$message = '';
$apartmentData = [];
$canRemoveApartment = true; 



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['fetchApartment'])) {
        $apartmentId = (int) $_POST['retrieve_apartment_id']; 
    
        //Query to fetch apartment data from the database
        $sql = "SELECT * FROM Apartments WHERE apartment_id = $apartmentId";
        $result = mysqli_query($conn, $sql);
        $apartmentData = mysqli_fetch_assoc($result);
    
        if ($apartmentData) {
            //Query to check if the apartment is tied to any maintenance requests or user id's
            $maintenanceSql = "SELECT * FROM maintenance_requests WHERE apartment_id = $apartmentId";
            $maintenanceResult = mysqli_query($conn, $maintenanceSql);
    
            $userSql = "SELECT * FROM Users WHERE user_apartment_id = $apartmentId";
            $userResult = mysqli_query($conn, $userSql);
            
            //set variable to decide if user can remove apartment or not
            if (mysqli_num_rows($maintenanceResult) > 0 || mysqli_num_rows($userResult) > 0) {
                $canRemoveApartment = false;
            }
        } else {
            $message = "Apartment not found!";
        }
    }
    

    elseif (isset($_POST['UApartment'])) {
        //Retreive data
        $apartmentId = (int) $_POST['apartment_id']; 
        $apartment_number = $_POST['apartment_number'];
        $floor_number = (int) $_POST['floor_number'];
        $bedrooms = (int) $_POST['bedrooms'];
        $bathrooms = (int) $_POST['bathrooms'];
        $status = $_POST['status'];
        $description = $_POST['description'];
        $rent_amount = $_POST['rent_amount'];
        $image_url = $_POST['image_url'];
        //Query to update apartment details
        $sql = "UPDATE Apartments SET apartment_number='$apartment_number', floor_number=$floor_number, bedrooms=$bedrooms, bathrooms=$bathrooms, status='$status', description='$description', rent_amount='$rent_amount', image_url='$image_url' WHERE apartment_id=$apartmentId";
        mysqli_query($conn, $sql);
        $message = "Apartment edited successfully";
    }
    elseif (isset($_POST['RApartment'])) {
        $apartmentId = (int) $_POST['apartment_id']; 

        $sql = "DELETE FROM Apartments WHERE apartment_id=$apartmentId";
        mysqli_query($conn, $sql);
        $message = "Apartment removed successfully";
    } 
    else {
        $message = "Invalid input!";
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
</style>


<?php if($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form action="edit_apartment.php" method="post">
    <label>Enter Apartment ID to Edit:</label>
    <input type="text" name="retrieve_apartment_id" placeholder="Enter Apartment ID">
    <button type="submit" name="fetchApartment">Fetch Apartment Data</button>
</form>

<form action="edit_apartment.php" method="post">
    <input type="hidden" name="apartment_id" value="<?php echo $apartmentData['apartment_id'] ?? ''; ?>">

    <label>Apartment Number:</label>
    <input type="text" name="apartment_number" value="<?php echo $apartmentData['apartment_number'] ?? ''; ?>">
    
    <label>Floor Number:</label>
    <input type="number" name="floor_number" value="<?php echo $apartmentData['floor_number'] ?? ''; ?>">
    
    <label>Bedrooms:</label>
    <input type="number" name="bedrooms" value="<?php echo $apartmentData['bedrooms'] ?? ''; ?>">
    
    <label>Bathrooms:</label>
    <input type="number" name="bathrooms" value="<?php echo $apartmentData['bathrooms'] ?? ''; ?>">
    
    <label>Status:</label>
    <select name="status">
        <option value="Available" <?php echo (isset($apartmentData['status']) && $apartmentData['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
        <option value="Occupied" <?php echo (isset($apartmentData['status']) && $apartmentData['status'] == 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
        <option value="Under Maintenance" <?php echo (isset($apartmentData['status']) && $apartmentData['status'] == 'Under Maintenance') ? 'selected' : ''; ?>>Under Maintenance</option>
    </select>
    
    <label>Description:</label>
    <textarea name="description"><?php echo $apartmentData['description'] ?? ''; ?></textarea>
    
    <label>Rent Amount:</label>
    <input type="text" name="rent_amount" value="<?php echo $apartmentData['rent_amount'] ?? ''; ?>">
    
    <label>Image URL:</label>
    <input type="text" name="image_url" value="<?php echo $apartmentData['image_url'] ?? ''; ?>">
    
    <?php if ($canRemoveApartment): ?>
        <button type="submit" name="RApartment">Remove Apartment</button>
    <?php endif; ?>
    <button type="submit" name="UApartment">Update Apartment</button>
</form>

<?php
include_once 'footer.php';
?>