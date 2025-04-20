<?php
session_start();
include '../db.php'; // डेटाबेस कनेक्शन शामिल करें

// Initialize an empty array to hold search results
$books = [];
$message = ""; // Initialize message variable

// Check if the search form has been submitted
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];

    // Prepare the SQL query to search for books by title or author
    $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTermWithWildcards = "%" . $searchTerm . "%"; // Add wildcards for partial matching
    $stmt->bind_param("ss", $searchTermWithWildcards, $searchTermWithWildcards);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Fetch the results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
            $message = "Search successful!"; // Set success message
        } else {
            $message = "No books found matching your search.";
        }
    } else {
        $message = "Error executing query: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="search_books.css">
</head>
<body>
    <header>
        <h1>Search Books</h1>
    </header>

    <main>
        <form method="POST">
            <label for="searchTerm">Search by Title or Author:</label>
            <input type="text" name="searchTerm" id="searchTerm" required>
            <input type="submit" name="search" value="Search">
        </form>

        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <?php if (!empty($books)): ?>
            <h2>Search Results</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Year</th>
                    <th>Available Copies</th>
                </tr>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['published_year']); ?></td>
                    <td><?php echo htmlspecialchars($book['available_copies']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.</p>
    </footer>
</body>
</html>