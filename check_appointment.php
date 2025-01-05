<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Appointment</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<?php include 'header.php'; ?> <br><br>

<h2 class="appointment-title">Check Appointment</h2>

<div class="appointment-form-section">
    <form action="" method="post" class="appointment-form">
        <label for="search_input">Enter Phone Number or Email:</label>
        <input type="text" id="search_input" name="search_input" required>
        <button type="submit" class="btn">Search Appointment</button>
    </form>
    </div>
    <?php
    include 'db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $search_input = $_POST['search_input'] ?? '';

        if (preg_match("/^[0-9]{11}$/", $search_input)) {
            // Input is a phone number
            $query = "SELECT * FROM appointments WHERE phone = ?";
        } elseif (filter_var($search_input, FILTER_VALIDATE_EMAIL)) {
            // Input is an email
            $query = "SELECT * FROM appointments WHERE email = ?";
        } else {
            echo "<p style='color:red;'>Invalid input. Enter a valid phone number (11 digits) or email address.</p>";
            exit;
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $search_input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h2>Appointment Details</h2>";
            echo "<table>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Specialization</th>
                    <th>Status</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['full_name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['phone']) . "</td>
                    <td>" . htmlspecialchars($row['age']) . "</td>
                    <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                    <td>" . htmlspecialchars($row['appointment_time']) . "</td>
                    <td>" . htmlspecialchars($row['specialization']) . "</td>
                    <td>" . htmlspecialchars($row['Status']) . "</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red;'>No appointments found for this input.</p>";
        }
        $stmt->close();
    }
    ?>

<?php include 'footer.php'; ?>

</body>
</html>
