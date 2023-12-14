
<?php
include_once 'header.php';
include 'includes/dbh.inc.php';

$noticesId = $_GET['id'];

$query = "SELECT * FROM notices WHERE notice_id = '$noticesId'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {

        $title = $row['title'];
	$content = $row['content'];
	$author = $row['author'];
	$date = $row['post_date'];

    } else {
        echo "No matching rows found";
    }
}

?>

    
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo "Notices Viewer"; ?></title>
</head>
<body>
    <h1 style="color:white;"><?php echo $title; ?></h1>
    <p style="color:white;" ><?php echo $author; ?></p>
    <p style="color:white;" ><?php echo $date; ?></p>
    <p>&nbsp;</p>
    <p style="color:white;" ><?php echo $content; ?></p>
</body>
</html>   


<?php
include_once 'footer.php';
?>
