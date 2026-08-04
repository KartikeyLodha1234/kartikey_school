<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kartikeyschool";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->exec("SET NAMES utf8mb4");
    // Connection successful (you can remove this in production)
    // echo "Connected successfully";
    
} catch(PDOException $e) {
    // Connection failed - show error message
    die("Connection failed: " . $e->getMessage());
}
?>