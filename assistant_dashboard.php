<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'assistant') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Dashboard</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="admin-container">
        <h1>Assistant Dashboard</h1>

        <section class="appointments">
            <h2>Manage Appointments</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Specialization</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "doctor_appointment_system");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $id = $_POST['appointment_id'] ?? null;
                        $status = $_POST['status'] ?? null;

                        if ($id && $status) {
                            $update_sql = "UPDATE appointments SET status='$status' WHERE id=$id";
                            $conn->query($update_sql);
                        }
                    }

                    $sql = "SELECT * FROM `appointments`";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $status = $row['status'] ?? 'Pending'; 
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['specialization']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                            echo "<td>";
                            echo "<form method='POST' action=''>";
                            echo "<input type='hidden' name='appointment_id' value='" . htmlspecialchars($row['id']) . "'>";
                            echo "<select name='status'>";
                            echo "<option value='Pending'" . ($status === 'Pending' ? ' selected' : '') . ">Pending</option>";
                            echo "<option value='Approved'" . ($status === 'Approved' ? ' selected' : '') . ">Approved</option>";
                            echo "<option value='Canceled'" . ($status === 'Canceled' ? ' selected' : '') . ">Canceled</option>";
                            echo "<option value='Completed'" . ($status === 'Completed' ? ' selected' : '') . ">Completed</option>";
                            echo "</select>";
                            echo "<button type='submit'>Save</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No appointments found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
        <div class="about-cta">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    </div>
</body>
</html>