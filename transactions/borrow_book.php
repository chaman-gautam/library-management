<?php
session_start();
include '../db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("User is not logged in.");
    }

    // Retrieve book ID from POST data
    $book_id = $_POST['book_id'];

    // Debugging: Check the book ID
    var_dump($book_id); // This will show the book ID being used
echo $book_id;
    // Validate book ID
    if (!isset($book_id) || !is_numeric($book_id) || $book_id <= 0) {
        die("Invalid book ID.");
    }

    $user_id = $_SESSION['user_id'];
    $borrow_date = date('Y-m-d H:i:s');
    $due_date = date('Y-m-d H:i:s', strtotime('+14 days')); // Set due date to 14 days from now

    // Check if the book is available
    $checkBookQuery = "SELECT available_copies FROM books WHERE id = ?";
    $stmt = $conn->prepare($checkBookQuery);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the book exists
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        if ($book['available_copies'] > 0) {
            // Insert transaction
            $insertTransactionQuery = "INSERT INTO transactions (user_id, book_id, borrow_date, due_date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertTransactionQuery);
            $stmt->bind_param("iiss", $user_id, $book_id, $borrow_date, $due_date);

            if ($stmt->execute()) {
                // Update available copies
                $updateBookQuery = "UPDATE books SET available_copies = available_copies - 1 WHERE id = ?";
                $stmt = $conn->prepare($updateBookQuery);
                $stmt->bind_param("i", $book_id);
                if ($stmt->execute()) {
                    echo "Book borrowed successfully! Due date: " . $due_date;
                } else {
                    echo "Error updating book availability: " . $stmt->error;
                }
            } else {
                echo "Error borrowing book: " . $stmt->error;
            }
        } else {
            echo "Book is not available for borrowing.";
        }
    } else {
        echo "Book not found. Book ID: " . htmlspecialchars($book_id);
    }
}
?>

<!-- HTML Form to borrow a book -->
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
    <input type="hidden" name="book_id" value="<?php echo isset($_GET['book_id']) ? htmlspecialchars($_GET['book_id']) : ''; ?>"> 
    <button type="submit">Borrow Book</button>
</form>

<style>
    form {
        width: 50%;
        margin: 40px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    input[type="hidden"] {
        display: none;
    }

    button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #3e8e41;
    }
</style>
