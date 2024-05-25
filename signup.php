<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
</head>
<body>
<?php
require_once 'config/connect.php';

use database\Database;

if(isset($_POST['signup'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword']; 

    if(empty($firstname) || empty($lastname) || empty($age) || empty($sex) || empty($username) || empty($password) || empty($confirmPassword)){
        echo "All fields are required";
    } elseif($password !== $confirmPassword) {
        echo "Passwords do not match";
    } else {
        $conn = new Database();
        $connect = $conn->getConnection();
        
        $checkQuery = "SELECT COUNT(*) FROM tbl_users WHERE username = ?";
        $checkStmt = $connect->prepare($checkQuery);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();
        
        if ($count > 0) {
            echo "Username already exists. Please choose a different username.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO tbl_users (firstname, lastname, age, sex, username, password) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("ssisss", $firstname, $lastname, $age, $sex, $username, $hashedPassword);
            
            if($stmt->execute()){
                $sql = "INSERT INTO tbl_useraccount (username, password) VALUES (?, ?)";
                $result = $connect->prepare($sql);
                $result->bind_param("ss", $username, $hashedPassword);
                $result->execute();
                header('Location: index.php');
                exit;
            } else {
                echo "Error occurred while signing up";
            }

            $stmt->close();
        }
        
        $connect->close();
    }
}
?>
    <center>
    <h1>
        Signup Account
    </h1>
    <form action="" method="post">
        First Name <br>
        <input type="text" name="firstname" required><br><br>
        Last Name <br>
        <input type="text" name="lastname" required><br><br>
        Age <br>
        <input type="number" name="age" required><br><br>
        Sex <br>
        <input type="radio" name="sex" value="Male" required>Male
        <input type="radio" name="sex" value="Female" required>Female<br><br>
        Username <br>
        <input type="text" name="username" required><br><br>
        Password <br>
        <input type="password" name="password" required><br><br>
        Confirm Password <br>
        <input type="password" name="confirmPassword" required><br><br>
        
        
        <br><input type="submit" name="signup" value="Sign Up"><br><br>
        <p>Back to <a href="index.php">Login Page</a> </p>
    </form>
    </center>
    
</body>
</html>

