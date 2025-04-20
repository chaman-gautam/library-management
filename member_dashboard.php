<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    //header("Location: manage_users.php")
     header("Location: view_users.php");
    exit();
}

// Fetch user information (optional)
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, role FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <h1>Dashboard</h1>
    </header>

    <main>
        <div class="container">
            <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
            <p>Your role: <?php echo htmlspecialchars($user['role']); ?></p>

            <h3>Actions</h3>
            <ul>
                <li><a href="books/search_books.php">search Book</a></li>
                <li><a href="books/view_books.php"> all books </a></li>
                <li><a href="./transactions/borrow_book.php">Borrow a Book</a></li>
                <li><a href="./transactions/return_book.php">Return a Book</a></li>
                <li><a href="view_librarian.php">all librarian</a></li>
            </ul>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.</p>
    </footer>
</body>
</html>