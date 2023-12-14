<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  include_once 'includes/functions.inc.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PHP Project 01</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

    <nav>
      <div class="wrapper">
        <a href="index.php"><img src="img/logo-white2.png" alt="The Waverly"></a>
        <ul>

          <li><a href="view_apartment_page.php">View Apartments</a></li>
          <?php
            if (isset($_SESSION['useruid']) && $_SESSION['role'] === 'management') {
              echo "<li><a href='maintenance_response.php'>Maintenance</a></li>";
            } else {
              echo "<li><a href='maintenance.php'>Maintenance</a></li>";
            }
          ?>
          <li><a href="payments.php">Payments</a></li>
          <li><a href="notices.php">Notices</a></li>
          <li><a href="directory.php">Directory</a></li>
          <?php
            if (isset($_SESSION["useruid"])) {
              echo "<li><a href='profile.php'>Profile Page</a></li>";
              echo "<li><a href='logout.php'>Logout</a></li>";
            }
            else {
              echo "<li><a href='signup.php'>Sign up</a></li>";
              echo "<li><a href='login.php'>Log in</a></li>";
            }
          ?>
        </ul>
      </div>
    </nav>

<div class="wrapper">
