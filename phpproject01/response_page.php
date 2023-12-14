<?php
error_reporting(0);
require_once 'includes/functions.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'header.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'management') {
    header('Location: login.php');
    exit();
}

$message = ''; 
$request_id = $_GET['request_id'] ?? null;
$delId = $_GET['del_request_id'] ?? null;


//Delete maintenance request
if ($delId) {
    $deletePaymentSql = "DELETE FROM payment_history WHERE request_id = '$delId'";
    if (!mysqli_query($conn, $deletePaymentSql)) {
        $message = "Error deleting payment history: " . mysqli_error($conn);
    } else {
        $deleteResponsesSql = "DELETE FROM maintenance_responses WHERE request_id = '$delId'";
        $deleteRequestSql = "DELETE FROM maintenance_requests WHERE request_id = '$delId'";

        if (mysqli_query($conn, $deleteResponsesSql) && mysqli_query($conn, $deleteRequestSql)) {
            $message = "Maintenance request deleted successfully.";
        } else {
            $message .= " Error deleting maintenance request: " . mysqli_error($conn);
        }
    }
}


//Insert Response 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['response'])) {
        $responder_id = $_SESSION['userid'];
        $response = mysqli_real_escape_string($conn, $_POST['response']); 
        $mark_complete = isset($_POST['mark_complete']) ? 'Completed' : 'In Progress';

        $insertSql = "INSERT INTO maintenance_responses (request_id, responder_id, response_text) VALUES ($request_id, $responder_id, '$response')";
        mysqli_query($conn, $insertSql);

        $updateSql = "UPDATE maintenance_requests SET request_status = '$mark_complete' WHERE request_id = $request_id";
        mysqli_query($conn, $updateSql);

        $message = 'Response submitted successfully.';
    }
    //Insert amountDue
    if (isset($_POST['submitAmountDue'])) {
        if (isset($_POST['amountDue']) && is_numeric($_POST['amountDue'])) {
            $amountDue = $_POST['amountDue'];
            $dueDate = date('Y-m-d', strtotime("+30 days"));
            $updateAmountSql = "UPDATE maintenance_requests SET amountDue = $amountDue, due_date = '$dueDate' WHERE request_id = $request_id";
            
            if (mysqli_query($conn, $updateAmountSql)) {
                $message .= ' Amount due updated successfully.';
            } else {
                $message .= ' Error updating amount due.';
            }
        }
    }
}

$sql = "SELECT * FROM maintenance_requests WHERE request_id = $request_id";
$result = mysqli_query($conn, $sql);
$request = mysqli_fetch_assoc($result);

$responseSql = "SELECT mr.response_text, u.usersName, mr.response_date 
                FROM maintenance_responses mr 
                JOIN users u ON mr.responder_id = u.usersId 
                WHERE mr.request_id = $request_id";
$responseResult = mysqli_query($conn, $responseSql);
$responses = mysqli_fetch_all($responseResult, MYSQLI_ASSOC);
if (!$request) {
    echo "Request not found!";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Respond to Maintenance Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: white;
            text-align: center;
        }

	h2, h3, p {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: white;
            text-align: center;
        }

	.card, .alert {
        background-color: #2c2c2c;
        border-radius: 5px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    	}

        input, textarea, button {
		padding: 10px;
            width: 80%;
            margin: 10px auto;
            display: block;
		background-color: #3a3a3a;
		border: 1px solid #555;
		border-radius: 4px;
		color: #ffffff;
        }

        textarea {
            height: 100px;
		color: #ffffff;
        }

        button {
            background-color: #4CAF50;
            color: white;
	    width: 200px;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }
        .request-box {
            background-color: #2c2c2c;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 15px;
            margin: 20px 0;
            color: white;
        }

        .request-description {
            margin-bottom: 20px;
        }

        .response-section {
            border-top: 1px solid #555;
            padding-top: 10px;
        }

        .response-list {
            list-style-type: none;
            padding: 0;
        }

        .response-item {
            border-bottom: 1px solid #555;
            padding: 10px 0;
        }

        .response-item:last-child {
            border-bottom: none;
        }

        .no-responses {
            text-align: center;
            padding: 10px 0;
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

    </style>
</head>
<body>
    <h2>Respond to Maintenance Request</h2>
    <div class="request-box">
    <div class="request-description">
        <p><strong>Description:</strong> <?php echo ($request['description']); ?></p>
    </div>
    <?php if (!empty($responses)): ?>
        <div class="response-section">
            <h3>Responses</h3>
            <ul class="response-list">
                <?php foreach ($responses as $response): ?>
                    <li class="response-item">
                        <strong><?php echo ($response['usersName']); ?>:</strong> 
                        <?php echo ($response['response_text']); ?>
                        <br>
                        <small>Responded on: <?php echo ($response['response_date']); ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="no-responses">
            <p>No responses yet.</p>
        </div>
    <?php endif; ?>
</div>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="response_page.php?request_id=<?php echo $request_id; ?>" method="post">
        <textarea name="response" placeholder="Enter your response..."></textarea>
        <button type="submit">Submit Response</button>
	<a href="response_page.php?del_request_id=<?php echo $request['request_id']; ?>" class="maintenance-btn">Mark Completed</a>
    </form>
    <form action="response_page.php?request_id=<?php echo $request_id; ?>" method="post">
        <div>
            <label for="amountDue">Amount Due:</label>
            <input type="number" step="0.01" name="amountDue" id="amountDue" placeholder="Enter amount due" />
        </div>
        <button type="submit" name="submitAmountDue">Update Amount Due</button>
    </form>
</body>
</html>