<?php include 'admin_header.php'; ?>
<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<section class="appointment-form-section">
    <h1>Add Doctor</h1>
    <form method="POST" action="" class="appointment-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="specialization">Specialization:</label>
        <select id="specialization" name="specialization" required>
            <option value="general">General</option>
            <option value="cardiology">Cardiology</option>
            <option value="dentistry">Dentistry</option>
            <option value="dermatology">Dermatology</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="add_doctor">Add Doctor</button>
    </form>
</section>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doctor'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $specialization = $_POST['specialization'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $errors = [];

    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Name must only contain letters and spaces.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match("/^[0-9]{11}$/", $phone)) {
        $errors[] = "Phone Number must be exactly 11 digits.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    $conn = new mysqli("localhost", "root", "", "doctor_appointment_system");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Email already exists.";
    }
    $stmt->close();

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, phone, specialization, email, password, user_type) VALUES (?, ?, ?, ?, ?, 'doctor')");
        $stmt->bind_param("sssss", $name, $phone, $specialization, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<p class='success-message'>Doctor added successfully!</p>";
        } else {
            echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {

        foreach ($errors as $error) {
            echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>";
        }
    }

    $conn->close();
}
?>
</body>
</html>
