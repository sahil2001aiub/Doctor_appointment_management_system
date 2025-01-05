<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<?php include 'header.php'; ?>
        <h2 class="appointment-title">Login Page</h2>
    <div class="appointment-form-section">
        <form action="" method="post" class="appointment-form">
            <label for="user_type">Select User Type:</label>
            <select id="user_type" name="user_type" required>
                <option value="admin">Admin</option>
                <option value="doctor">Doctor</option>
                <option value="assistant">Assistant</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn" >Login</button>
        </form>
        </div>
       
        <?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db_connect.php';

    $user_type = $_POST['user_type'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $admin_email = 'admin@domain.com';
    $admin_password = 'admin123';

    if ($user_type === 'admin') {
        if ($email === $admin_email && $password === $admin_password) {
            $_SESSION['userType'] = 'admin';
            $_SESSION['loggedIn'] = true;
            $_SESSION['email'] = $email;

            header('Location: admin_dashboard.php');
            exit;
        } else {
            echo '<p style="color: red;">Invalid admin credentials.</p>';
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND user_type = ?");
        $stmt->bind_param("ss", $email, $user_type);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['userType'] = $user_type;
                $_SESSION['loggedIn'] = true;
                $_SESSION['email'] = $email;

                if ($user_type === 'doctor') {
                    header('Location: doctor_dashboard.php');
                } elseif ($user_type === 'assistant') {
                    header('Location: assistant_dashboard.php');
                }
                exit;
            } else {
                echo '<p style="color: red;">Invalid password.</p>';
            }
        } else {
            echo '<p style="color: red;">No user found with these credentials.</p>';
        }
        $stmt->close();
    }
    $conn->close();
}
?>
        
        <?php include 'footer.php'; ?>
</body>
</html>








