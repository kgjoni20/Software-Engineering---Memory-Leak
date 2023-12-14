<?php
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';
    require_once 'header.php'; 

    // Check if user is logged in 
    if (!isset($_SESSION['userid'])) {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Apartment Management System - Maintenance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
    body {
	font-family: Arial, sans-serif;
        background-color: #1e1e1e;
        color: white;
    }
    .card, .alert {
        background-color: #2c2c2c;
        border-radius: 5px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
	width: 100%
    }

	.response_box {
	margin: auto;
        background-color: #2c2c2c;
        border-radius: 5px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
	width: 45%

    }
    .form-control, .form-control:focus {
        background-color: #3a3a3a; 
        color: white; 
        border-color: #555; 
	width: 100%;
    }
    .btn-primary {
        background-color: #28a745; 
        border-color: #28a745; 
    }
    .btn-primary:hover {
        background-color: #218838; 
        border-color: #1e7e34; 
    }
    .btn-dark-mode {
        background-color: #555;
        color: white;
    }
    .btn-dark-mode:hover {
        background-color: #6c757d;
    }
    .badge {
        background-color: #6c757d;
    }
    .current-request-text {
    color: white; 
    font-weight: bold; 
    }
    .comment p {
        color: white !important; 
    }

    
</style>
</head>

<body>
    <?php
    //Function to check for open maintenace requests
    function checkForOpenRequest($conn, $userId) {
        $query = "SELECT * FROM maintenance_requests WHERE usersId = $userId AND request_status IN ('Pending', 'In Progress')";
        $result = $conn->query($query);
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }

    //function call the check if the user has any requests
    $openRequest = checkForOpenRequest($conn, $_SESSION['userid']);
    $comments = null;

    //Function to fetch comments
    function fetchCommentsForRequest($conn, $requestId) {
        $query = "SELECT mr.*, u.usersName 
                  FROM maintenance_responses mr
                  JOIN users u ON mr.responder_id = u.usersId
                  WHERE mr.request_id = $requestId";
        $result = $conn->query($query);
        return $result;
    }
    
    //If there is an open request fetch the comments
    if ($openRequest) {
        $comments = fetchCommentsForRequest($conn, $openRequest['request_id']);
    }
    

    $description = '';
    $urgency = '';
    $errorMsg = '';
    $editMode = false;

    //Form submission logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['edit'])) {
            $editMode = true;
            $description = $openRequest['description'];
            $urgency = $openRequest['urgency'];
        } elseif (isset($_POST['description'])) {
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $urgency = mysqli_real_escape_string($conn, $_POST['urgency']);
    
            if (empty($description)) {
                $errorMsg = 'Please describe the maintenance issue.';
            } else {
                if ($openRequest) {
                    $requestId = $openRequest['request_id'];
                    $query = "UPDATE maintenance_requests SET description = '$description', urgency = '$urgency' WHERE request_id = $requestId";
                } else {
                    $apartment_id = $_SESSION['apartment_id']; 
                    $query = "INSERT INTO maintenance_requests (usersId, apartment_id, description, urgency, request_status) VALUES ({$_SESSION['userid']}, $apartment_id, '$description', '$urgency', 'Pending')";
                }
                
                //execute the query
                if ($conn->query($query) === TRUE) {
                    echo "<p>Maintenance request " . ($editMode ? "updated" : "submitted") . " successfully!</p>";
                    $openRequest = $editMode ? checkForOpenRequest($conn, $_SESSION['userid']) : false;
                    $editMode = false;
                } else {
                    $errorMsg = "Error submitting the request: " . ($conn->error);
                }
            }
        }
    }


    //User response submission logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['user_response'])) {
            $userResponse = mysqli_real_escape_string($conn, $_POST['user_response']);
            $requestId = $_POST['request_id'];

            $query = "INSERT INTO maintenance_responses (request_id, responder_id, response_text) VALUES ($requestId, {$_SESSION['userid']}, '$userResponse')";
            if ($conn->query($query) === TRUE) {
                echo "<p>Response submitted successfully!</p>";
            } else {
                echo "<p>Error submitting the response: " . ($conn->error) . "</p>";
            }
        }
    }
    
    ?>
    <div class="container mt-4">
        <?php if (isset($errorMsg) && $errorMsg): ?>
            <div class="alert alert-danger" role="alert">
                <?= ($errorMsg) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($openRequest) && $openRequest && !$editMode): ?>
            <div class="card mb-3">
                <div class="card-header">Current Request</div>
                <div class="card-body">
                <h5 class="card-title current-request-text">Issue: <?= ($openRequest['description']) ?></h5>
                <p class="card-text current-request-text">Urgency: <?= ($openRequest['urgency']) ?></p>
                    <form action="maintenance.php" method="post">
                        <input type="hidden" name="request_id" value="<?= $openRequest['request_id'] ?>">
                        <button type="submit" name="edit" class="btn btn-dark-mode">Edit</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="card mb-3">
                <div class="card-header"><?= $editMode ? 'Edit Maintenance Request' : 'Submit Maintenance Request' ?></div>
                <div class="card-body">
                    <form action="maintenance.php" method="post" id="maintenanceForm">
                        <div class="form-group">
                            <label for="description">Describe the issue:</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= ($description) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="urgency">Urgency:</label>
                            <select class="form-control" id="urgency" name="urgency" required>
                                <option value="Mild" <?= $urgency === 'Mild' ? 'selected' : '' ?>>Mild</option>
                                <option value="Medium" <?= $urgency === 'Medium' ? 'selected' : '' ?>>Medium</option>
                                <option value="Urgent" <?= $urgency === 'Urgent' ? 'selected' : '' ?>>Urgent</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= $editMode ? 'Update Request' : 'Submit Request' ?></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($openRequest): ?>
            <div class="card mb-3">
                <div class="card-header">Comments</div>
                <div class="card-body">
                    <?php while($comment = $comments->fetch_assoc()): ?>
                        <div class="comment">
                        <p>
                            <strong><?= ($comment['usersName']) ?>:</strong>
                            <?= ($comment['response_text']) ?>
                            <br>
                            <small>Posted on: <?= ($comment['response_date']) ?></small>
                        </p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($openRequest): ?>
        <div class="response_box">
            <div class="card-header">Submit Your Response</div>
            <div class="card-body">
                <form action="maintenance.php" method="post">
                    <input type="hidden" name="request_id" value="<?= $openRequest['request_id'] ?>">
                    <div class="form-group">
                        <textarea class="form-control" name="user_response" placeholder="Enter your response here..." rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Response</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    </body>

    </html>