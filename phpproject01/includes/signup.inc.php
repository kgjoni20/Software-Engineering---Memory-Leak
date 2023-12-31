<?php

if (isset($_POST["submit"])) {

  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdrepeat"];
  $apartmentId = $_POST["apartment_id"];

  require_once "dbh.inc.php";
  require_once 'functions.inc.php';




if (apartmentIdExists($conn, $apartmentId)) {
  header("location: ../signup.php?error=apartmentidtaken");
  exit();
}

if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat, $apartmentId) !== false) { 
  header("location: ../signup.php?error=emptyinput");
  exit();
}

  if (invalidUid($uid) !== false) {
    header("location: ../signup.php?error=invaliduid");
		exit();
  }

  if (invalidEmail($email) !== false) {
    header("location: ../signup.php?error=invalidemail");
		exit();
  }
 
  if (pwdMatch($pwd, $pwdRepeat) !== false) {
    header("location: ../signup.php?error=passwordsdontmatch");
		exit();
  }
 
  if (uidExists($conn, $username) !== false) {
    header("location: ../signup.php?error=usernametaken");
		exit();
  }


  createUser($conn, $name, $email, $username, $pwd, $apartmentId);


} else {
	header("location: ../signup.php");
    exit();
}
