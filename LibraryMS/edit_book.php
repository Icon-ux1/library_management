<?php
$page_title = 'Edit Book';
include 'header.php';

$id = $_GET['id'] ?? null;
$message = '';

if (!$id) {
    header('Location: books.php');
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_book'])) {
    $book_data = array(
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'isbn' => $_POST['isbn'],
        'genre' => $_POST['genre'],
        'totalCopies' => (int)$_POST['total_copies'],
        'availableCopies' => (int)$_POST['available_copies']
    );

    $result = apiCall(API_BOOKS . '/' . $id, 'PUT', $book_data);
    
    if (isset($result['id'])) {
        $message = '<div class="alert alert-success">Book updated successfully! <a href="books.php">Back to list</a></div>';
    } else {
        $error_detail = isset($result['error']) ? $result['error'] : 'Unknown error';
        $message = '<div class="alert alert-error">Error updating book: ' . $error_detail . '</div>';
    }
}

// Get current book data
$book = apiCall(API_BOOKS . '/' . $id);

if (isset($book['error']) || !isset($book['id'])) {
    echo "<h2>Error</h2><div class='alert alert-error'>Book not found or API error.</div>";
    include 'footer.php';
    exit;
}
?>

<h2>Edit Book</h2>
<?php echo $message; ?>

<form method="POST" style="max-width: 500px; margin-bottom: 30px;">
    <div class="form-group">
        <label for="title">Book Title</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
    </div>

    <div class="form-group">
        <label for="author">Author</label>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
    </div>

    <div class="form-group">
        <label for="isbn">ISBN</label>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn'] ?? ''); ?>">
    </div>

    <div class="form-group">
        <label for="genre">Genre</label>
        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre'] ?? ''); ?>">
    </div>

    <div class="form-group">
        <label for="total_copies">Total Copies</label>
        <input type="number" id="total_copies" name="total_copies" min="0" value="<?php echo $book['totalCopies']; ?>" required>
    </div>

    <div class="form-group">
        <label for="available_copies">Available Copies</label>
        <input type="number" id="available_copies" name="available_copies" min="0" value="<?php echo $book['availableCopies']; ?>" required>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" name="update_book" class="btn btn-success">Update Book</button>
        <a href="books.php" class="btn btn-secondary" style="text-decoration: none; margin-left: 10px;">Cancel</a>
    </div>
</form>

<?php include 'footer.php'; ?>
