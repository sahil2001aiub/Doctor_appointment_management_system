<?php
$host = "localhost";  
$user = "root";      
$password = "";       
$dbname = "doctor_appointment_system";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
