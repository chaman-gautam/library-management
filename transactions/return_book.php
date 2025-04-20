<?php
session_start();
include '../db.php'; // Ensure the correct path is used

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
    $book_id = $_POST['book_id'];

    // Check if the book is currently borrowed by the user
    $checkTransactionQuery = "SELECT * FROM transactions WHERE user_id = ? AND book_id = ? AND return_date IS NULL";
    $stmt = $conn->prepare($checkTransactionQuery);
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();

    if ($transaction) {
        // Update the transaction to set the return date
        $return_date = date('Y-m-d H:i:s');
        $updateTransactionQuery = "UPDATE transactions SET return_date = ? WHERE user_id = ? AND book_id = ? AND return_date IS NULL";
        $stmt = $conn->prepare($updateTransactionQuery);
        $stmt->bind_param("sii", $return_date, $user_id, $book_id);

        if ($stmt->execute()) {
            // Update available copies
            $updateBookQuery = "UPDATE books SET available_copies = available_copies + 1 WHERE id = ?";
            $stmt = $conn->prepare($updateBookQuery);
            $stmt->bind_param("i", $book_id);
            $stmt->execute();

            echo "Book returned successfully!";
        } else {
            echo "Error returning book: " . $stmt->error;
        }
    } else {
        echo "No record of this book being borrowed by you.";
    }
}
?>

<!-- HTML Form to return a book -->
<form method="POST" action="">
    <?php if (isset($_GET['book_id'])): ?>
        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($_GET['book_id']); ?>">
        <button type="submit">Return Book</button>
    <?php else: ?>
        <p>Error: Book ID is missing.</p>
    <?php endif; ?>
</form>
