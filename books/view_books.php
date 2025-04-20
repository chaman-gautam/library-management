<?php
session_start();
include '../db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all books
$books = [];
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <header>
        <h1>View All Books</h1>
    </header>

    <main>
        <h2>All Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Published Year</th>
                <th>Available Copies</th>
                <th colspan="2">Action</th>
            </tr>
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['published_year']); ?></td>
                    <td><?php echo htmlspecialchars($book['available_copies']); ?></td>
                    <td><a href="../transactions/borrow_book.php?book_id=<?php echo htmlspecialchars($book['id']); ?>">Borrow</a></td>
                    <td><a href="../transactions/return_book.php?book_id=<?php echo htmlspecialchars($book['id']); ?>">return</a></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No books found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.</p>
    </footer>
</body>
</html>
