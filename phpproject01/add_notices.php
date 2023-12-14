<?php
include_once 'header.php';
include 'includes/dbh.inc.php';

$message = '';

//Insert notice into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(
        isset($_POST['title']) &&
        isset($_POST['content']) &&
        isset($_POST['author'])
    ) {
        $date = date('Y-m-d H:i:s');
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];

        $sql = "INSERT INTO notices (title, content, author, post_date) VALUES ('$title', '$content', '$author', '$date')";
        if ($conn->query($sql) === TRUE) {
            $message = "Notice added successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
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
    input[type="submit"] {
    background-color: #4CAF50; 
    color: white; 
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease; 
    }

input[type="submit"]:hover {
    background-color: #45a049; 
}

    
    
</style>



<?php if($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form action="add_notices.php" method="post">
    Title: <input type="text" name="title"><br>
    Content: <textarea name="content"></textarea><br>
    Author: <input type="text" name="author"><br>
    <input type="submit" value="Add notices">
</form>

<?php
include_once 'footer.php';
?>
