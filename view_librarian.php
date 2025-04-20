<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all books
$librarian = [];
$sql = "SELECT * FROM users WHERE role='librarian'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $librarian[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="./users/view_users.css">
</head>
<body>
    <header>
        <h1>View All librarian</h1>
    </header>

    <main>
        <h2>All librarian</h2>
        <table>
            <tr>
                <th>user name</th>
                <th>role</th>
                <!-- <th>Published Year</th> -->
                <!-- <th>Available Copies</th> -->
            </tr>
            <?php if (!empty($librarian)): ?>
                <?php foreach ($librarian as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['username']); ?></td>
                    <td><?php echo htmlspecialchars($u['role']); ?></td>
                    <!-- <td><?php echo htmlspecialchars($book['published_year']); ?></td> -->
                    <!-- <td><?php echo htmlspecialchars($book['available_copies']); ?></td> -->
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No librarian found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.</p>
    </footer>
</body>
</html>