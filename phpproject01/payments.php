<?php
require_once 'includes/dbh.inc.php'; 
include_once 'header.php';


if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'resident') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['userid']; 
$sql = "SELECT request_id, amountDue, due_date FROM maintenance_requests WHERE usersId = $user_id AND amountDue > 0";
$result = mysqli_query($conn, $sql);
$requests = mysqli_fetch_all($result, MYSQLI_ASSOC);

$hasRequests = !empty($requests);
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay'])) {
    $request_id = $_POST['request_id'];
    $payment_amount = $_POST['payment_amount'];

    // Get the current amount due
    $currentSql = "SELECT amountDue FROM maintenance_requests WHERE request_id = $request_id";
    $currentResult = mysqli_query($conn, $currentSql);
    $currentData = mysqli_fetch_assoc($currentResult);
    $currentAmountDue = $currentData['amountDue'];

    // Calculate new amount due
    $newAmountDue = $currentAmountDue - $payment_amount;

    if ($newAmountDue < 0) {
        $message = "Payment exceeds amount due. Please enter a correct amount.";
    } else {
        // Update the amount due in the database
        $updateSql = "UPDATE maintenance_requests SET amountDue = $newAmountDue WHERE request_id = $request_id";
        if (mysqli_query($conn, $updateSql)) {
            // Insert payment record into payment_history
            $insertPaymentHistorySql = "INSERT INTO payment_history (request_id, user_id, amount_paid) VALUES ($request_id, $user_id, $payment_amount)";
            mysqli_query($conn, $insertPaymentHistorySql);

            $message = "Payment successful. Amount due is now $" . $newAmountDue;
        } else {
            $message = "Error updating the payment. Please try again.";
        }
    }
}
$paymentHistorySql = "SELECT * FROM payment_history WHERE user_id = $user_id ORDER BY payment_date DESC";
$paymentHistoryResult = mysqli_query($conn, $paymentHistorySql);
$paymentHistory = mysqli_fetch_all($paymentHistoryResult, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Maintenance Fee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333; 
            color: white !important; 
            padding: 20px;
            font-size: 18px; 
            font-weight: bold; 
        }

        h2 {
            text-align: center;
            font-size: 24px; 
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #444; 
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        p {
            margin: 10px 0;
            text-align: center; 
        }

        .no-payment-due {
            font-size: 24px; 
            color: #28a745; 
            font-weight: bold; 
        }

        form {
            margin-top: 15px;
            background-color: #555; 
            padding: 15px;
            border-radius: 8px;
        }

        input[type="number"], button {
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            display: block;
            width: 95%;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745; 
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .highlight {
            color: white !important;
            font-weight: bold;
            font-size: 20px; 
        }

    </style>
</head>
<body>
<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>
<?php if ($hasRequests): ?>
    <?php foreach ($requests as $request): ?>
        <div>
            <div>
                <p class="highlight"><strong>Request ID:</strong> <?php echo $request['request_id']; ?></p>
                <p class="highlight"><strong>Amount Due:</strong> $<?php echo $request['amountDue']; ?></p>
                <p class="highlight"><strong>Due Date:</strong> <?php echo date('F j, Y', strtotime($request['due_date'])); ?></p>
            </div>
            <form action="" method="post">
                <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                <input type="number" step="0.01" name="payment_amount" placeholder="Enter payment amount">
                <button type="submit" name="pay">Pay</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="no-payment-due"><strong>No Payment Due</strong></p> 
<?php endif; ?>
<?php if (!empty($paymentHistory)): ?>
    <ul>
        <?php foreach ($paymentHistory as $payment): ?>
            <li>
                Request ID: <?php echo $payment['request_id']; ?>,
                Amount Paid: $<?php echo $payment['amount_paid']; ?>,
                Payment Date: <?php echo $payment['payment_date']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No payment history found.</p>
<?php endif; ?>

</body>
</html>
