<html>
<head>
<body>
<?php include 'header.php'; ?>
<?php include 'db_connect.php';

        $errors = [];
        $success = false;

        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $age = $_POST['age'] ?? '';
        $appointment_date = $_POST['date'] ?? '';
        $appointment_time = $_POST['time'] ?? '';
        $specialization = $_POST['specialization'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!preg_match("/^[a-zA-Z ]+$/", $full_name)) {
                $errors[] = "Full Name must only contain letters and spaces.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            } 

            if (!preg_match("/^[0-9]{11}$/", $phone)) {
                $errors[] = "Phone Number must be exactly 11 digits.";
            }

            if ($age <= 0 || $age >= 100) {
                $errors[] = "Age must be between 1 and 99.";
            }

            if (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
                $errors[] = "Appointment Date must be today or later.";
            }

            if (empty($errors)) {
                $stmt = $conn->prepare("INSERT INTO appointments 
                    (full_name, email, phone, age, appointment_date, appointment_time, specialization) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                    "sssisss",
                    $full_name,
                    $email,
                    $phone,
                    $age,
                    $appointment_date,
                    $appointment_time,
                    $specialization
                );

                if ($stmt->execute()) {
                    $success = true;
                    $full_name = '';
                    $email = '';
                    $phone = '';
                    $age = '';
                    $appointment_date = '';
                    $appointment_time = '';
                    $specialization = '';
                } else {
                    $errors[] = "Error saving appointment.";
                }
                $stmt->close();
            }
        }
        ?>

        <?php if ($success): ?>
            <p style="color: green;">Appointment successfully booked!</p>
        <?php elseif (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li style="color: red;"> <?= htmlspecialchars($error) ?> </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <h2 class="appointment-title">Book an Appointment</h2>
        <div class="appointment-form-section">
        <form action="" method="post" class="appointment-form">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($full_name) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" required>


            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($age) ?>" required>

            <label for="date">Appointment Date:</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($appointment_date) ?>" required>

            <label for="time">Preferred Time:</label>
            <input type="time" id="time" name="time" value="<?= htmlspecialchars($appointment_time) ?>" required>

            <label for="specialization">Select Specialization:</label>
            <select id="specialization" name="specialization" required>
                <option value="general" <?= $specialization == 'general' ? 'selected' : '' ?>>General</option>
                <option value="cardiology" <?= $specialization == 'cardiology' ? 'selected' : '' ?>>Cardiology</option>
                <option value="dentistry" <?= $specialization == 'dentistry' ? 'selected' : '' ?>>Dentistry</option>
                <option value="dermatology" <?= $specialization == 'dermatology' ? 'selected' : '' ?>>Dermatology</option>
            </select>

            <button type="submit" class="btn">Book Now</button>
        </form>
        </div>
    <?php include 'footer.php'; ?>

</body>
</html>
