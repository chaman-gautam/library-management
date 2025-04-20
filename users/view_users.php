<?php
// Include database connection
include '../db.php';

// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location:../login.php'); // Redirect to login if not logged in
    exit();
}

// Fetch all users
$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'user' or role='member'");
$stmt->execute();
$result = $stmt->get_result();
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view_users.css">
    <title>View Users</title>
</head>
<body>
    <h1>View Users</h1>

    <h2>Existing Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
