<?php
session_start();
include 'db.php'; // सुनिश्चित करें कि db.php सही तरीके से शामिल किया गया है

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // function select_user($username, $password) {

    // }
    // if ($_POST['role'] == 'librarian') {
    //    $sql = "SELECT * FROM users_librarian WHERE username=?";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("s", $username);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     // $_SESSION['role'] = 'librarian';
    //     // header(('Location: librarian_dashboard.php'));
    //     // exit();
    // } elseif ($_POST['role'] == 'member') {
    //    $sql = "SELECT * FROM users_member WHERE username=?";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("s", $username);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     // $_SESSION['role'] = 'member';
    //     // header(('Location: member_dashboard.php'));
    //     // exit();
    // } else {
    //   
    // }
    // उपयोगकर्ता को डेटाबेस से खोजें

    $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        // $_SESSION['role'] = 'user';
        // header(('Location: user_dashboard.php'));
        // exit();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // सत्र में उपयोगकर्ता की जानकारी सेट करें
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

               // Debugging: Check the roles
        echo "Form Role: " . $_POST['role'] . "<br>";
        echo "DB Role: " . $row['role'] . "<br>";
            if ($_POST['role'] == 'librarian' and $row['role'] == 'librarian') {
                // $_SESSION['role'] = 'librarian';
                header(('Location: librarian_dashboard.php'));
                exit();
            } elseif ($_POST['role'] == 'member' and $row['role'] == 'member') {
                // $_SESSION['role'] = 'member';
                header(('Location: member_dashboard.php'));
                exit();
            } elseif ($_POST['role'] == 'admin' and $row['role'] == 'admin') {
                // $_SESSION['role'] = 'member';
                header(('Location: admin_dashboard.php'));
                exit();
            } elseif( $_POST['role'] == 'user' and $row['role'] == 'user') {
                // $_SESSION['role'] = 'user';
                header(('Location: dashboard.php')); // user dashboard 
                exit();

            }
            else {
                echo "Role mismatch. Please select the correct role.";
            }
            // header("Location: dashboard.php");
            // exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form method="POST">
        <select name="role" id="u-role" default="user" required>
            <option value="" disabled selected>Select Role</option>
            <option value="user">user</option>
            <option value="admin">Admin</option>
            <option value="librarian">Librarian</option>
            <option value="member">Member</option>
        </select>
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</body>

</html>