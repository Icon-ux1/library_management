<?php
$page_title = 'Books Management';
include 'header.php';

$message = '';

// Add Book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $book_data = array(
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'isbn' => $_POST['isbn'],
        'genre' => $_POST['genre'],
        'totalCopies' => (int)$_POST['total_copies'],
        'availableCopies' => (int)$_POST['total_copies']
    );

    $result = apiCall(API_BOOKS, 'POST', $book_data);
    
    if (isset($result['id'])) {
        $message = '<div class="alert alert-success">Book added successfully!</div>';
    } else {
        $message = '<div class="alert alert-error">Error adding book. Make sure the backend is running.</div>';
    }
}

// Delete Book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = apiCall(API_BOOKS . '/' . $id, 'DELETE');
    $message = '<div class="alert alert-success">Book deleted successfully!</div>';
}

// Get all books
$books = apiCall(API_BOOKS);
?>

<h2>Books Management</h2>

<?php echo $message; ?>

<h3>Add New Book</h3>
<form method="POST" style="max-width: 500px; margin-bottom: 30px;">
    <div class="form-group">
        <label for="title">Book Title</label>
        <input type="text" id="title" name="title" required>
    </div>

    <div class="form-group">
        <label for="author">Author</label>
        <input type="text" id="author" name="author" required>
    </div>

    <div class="form-group">
        <label for="isbn">ISBN</label>
        <input type="text" id="isbn" name="isbn">
    </div>

    <div class="form-group">
        <label for="genre">Genre</label>
        <input type="text" id="genre" name="genre">
    </div>

    <div class="form-group">
        <label for="total_copies">Total Copies</label>
        <input type="number" id="total_copies" name="total_copies" min="1" required>
    </div>

    <button type="submit" name="add_book" class="btn btn-success">Add Book</button>
</form>

<h3>All Books</h3>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Genre</th>
            <th>Total Copies</th>
            <th>Available</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (is_array($books) && !isset($books['error'])) {
            if (count($books) > 0) {
                foreach ($books as $book) {
                    echo "<tr>";
                    echo "<td>" . $book['title'] . "</td>";
                    echo "<td>" . $book['author'] . "</td>";
                    echo "<td>" . ($book['isbn'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($book['genre'] ?? 'N/A') . "</td>";
                    echo "<td>" . $book['totalCopies'] . "</td>";
                    echo "<td>" . $book['availableCopies'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_book.php?id=" . $book['id'] . "' class='btn btn-warning' style='margin-right: 5px;'>Edit</a>";
                    echo "<a href='books.php?delete=" . $book['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align: center;'>No books found</td></tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align: center;'><div class='alert alert-error'>Unable to load books. Make sure the backend is running on http://localhost:8080</div></td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
