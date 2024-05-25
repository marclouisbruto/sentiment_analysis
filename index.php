<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <center>
    <h1>
        Login Account
    </h1>
    <form action="" method="post">
        Username <br>
        <input type="text" name="username" required><br><br>
        Password <br>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" name="login" value="Login"><br><br>
        <p>Don't have account? <a href="signup.php">Create an account</a> </p>
    </form>
    </center>
</body>
</html>


<?php
session_start();

require_once 'config/connect.php';

use database\Database;

$conn = new Database();
$connect = $conn->getConnection();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM tbl_useraccount WHERE username = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        
        if(password_verify($password, $storedPassword)){
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['userID'];
            header('Location: newsfeed.php');
            exit;
        } else {
            
            echo "Wrong username or password";
        }
    } else {
        echo "Wrong username or password";
    }

    $stmt->close();
    $connect->close();
}
?>


