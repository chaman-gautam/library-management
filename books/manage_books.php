<?php
session_start();
include '../db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Process adding or editing a book
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_year = $_POST['published_year'];
    $available_copies = $_POST['available_copies'];

    if (isset($_POST['book_id']) && !empty($_POST['book_id'])) {
        // Update existing book
        $book_id = $_POST['book_id'];
        $sql = "UPDATE books SET title=?, author=?, published_year=?, available_copies=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $title, $author, $published_year, $available_copies, $book_id);
    } else {
        // Add new book
        $sql = "INSERT INTO books (title, author, published_year, available_copies) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $author, $published_year, $available_copies);
    }

    if ($stmt->execute()) {
        echo "Book saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Process deleting a book
if (isset($_GET['delete'])) {
    $book_id = $_GET['delete'];
    $sql = "DELETE FROM books WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    header("Location: manage_books.php");
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
    <title>Manage Books</title>
    <link rel="stylesheet" href="manage_books.css">
</head>
<body>
    <header>
        <h1>Manage Books</h1>
    </header>

    <main>
        <form method="POST">
            <input type="hidden" name="book_id" id="book_id" value="">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required>
            <label for="published_year">Published Year:</label>
            <input type="number" name="published_year" id="published_year" required>
            <label for="available_copies">Available Copies:</label>
            <input type="number" name="available_copies" id="available_copies" required>
            <input type="submit" value="Save Book">
        </form>

        <h2>Actions</h2>
        <ul>
            <li><a href="search_books.php">Search Books</a></li>
            <li><a href="view_books.php">View All Books</a></li>
        </ul>

        <h2>Existing Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Published Year</th>
                <th>Available Copies</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo htmlspecialchars($book['published_year']); ?></td>
                <td><?php echo htmlspecialchars($book['available_copies']); ?></td>
                <td>
                <a href="javascript:void(0);" onclick="editBook(<?php echo $book['id']; ?>, '<?php echo htmlspecialchars($book['title']); ?>', '<?php echo htmlspecialchars($book['author']); ?>', <?php echo $book['published_year']; ?>, <?php echo $book['available_copies']; ?>)">Edit</a>
                <a href="?delete=<?php echo $book['id']; ?>">Delete</a>
                <a href="borrow_book.php?book_id=<?php echo $book['id']; ?>">Borrow</a> <!-- Borrow link added -->
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.</p>
</footer>

<script>
    function editBook(id, title, author, published_year, available_copies) {
        document.getElementById('book_id').value = id;
        document.getElementById('title').value = title;
        document.getElementById('author').value = author;
        document.getElementById('published_year').value = published_year;
        document.getElementById('available_copies').value = available_copies;
    }
</script>
