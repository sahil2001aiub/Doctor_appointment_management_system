<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<?php
include "admin_header.php";

$conn = new mysqli("localhost", "root", "", "doctor_appointment_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Management</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<div class="admin-container">
    <h1>Assistant Management</h1>
    
    <div class="admin-container">
        <h2>Registered Assistants</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, name, email, phone FROM users WHERE user_type = 'assistant'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No assistants found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="about-cta">
            <a href="add_assistant.php" class="btn">Add Assistant</a>
        </div>
    </div>
</div>
</body>
</html>
