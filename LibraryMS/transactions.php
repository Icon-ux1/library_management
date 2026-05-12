<?php
$page_title = 'Transactions Management';
include 'header.php';

$message = '';

// Borrow Book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow_book'])) {
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];
    $due_date = $_POST['due_date'];

    $url = API_TRANSACTIONS . '/borrow?memberId=' . $member_id . '&bookId=' . $book_id . '&dueDate=' . $due_date;
    $result = apiCall($url, 'POST');
    
    if (isset($result['id'])) {
        $message = '<div class="alert alert-success">Book borrowed successfully!</div>';
    } else {
        $message = '<div class="alert alert-error">Error borrowing book. Make sure the backend is running.</div>';
    }
}

// Return Book
if (isset($_GET['return'])) {
    $id = $_GET['return'];
    $result = apiCall(API_TRANSACTIONS . '/' . $id . '/return', 'PUT');
    $message = '<div class="alert alert-success">Book returned successfully!</div>';
}

// Get data
$books = apiCall(API_BOOKS);
$members = apiCall(API_MEMBERS);
$transactions = apiCall(API_TRANSACTIONS);
?>

<h2>Transactions Management</h2>

<?php echo $message; ?>

<h3>Borrow Book</h3>
<form method="POST" style="max-width: 500px; margin-bottom: 30px;">
    <div class="form-group">
        <label for="member_id">Member</label>
        <select id="member_id" name="member_id" required>
            <option value="">Select a member</option>
            <?php
            if (is_array($members) && !isset($members['error'])) {
                foreach ($members as $member) {
                    echo "<option value='" . $member['id'] . "'>" . $member['name'] . " (" . $member['membershipId'] . ")</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="book_id">Book</label>
        <select id="book_id" name="book_id" required>
            <option value="">Select a book</option>
            <?php
            if (is_array($books) && !isset($books['error'])) {
                foreach ($books as $book) {
                    if ($book['availableCopies'] > 0) {
                        echo "<option value='" . $book['id'] . "'>" . $book['title'] . " by " . $book['author'] . "</option>";
                    }
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="due_date">Due Date</label>
        <input type="date" id="due_date" name="due_date" required>
    </div>

    <button type="submit" name="borrow_book" class="btn btn-success">Borrow Book</button>
</form>

<h3>Active Borrowings</h3>
<table>
    <thead>
        <tr>
            <th>Member</th>
            <th>Book</th>
            <th>Borrow Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (is_array($transactions) && !isset($transactions['error'])) {
            $active = array_filter($transactions, function($t) { return $t['status'] === 'ACTIVE'; });
            if (count($active) > 0) {
                foreach ($active as $trans) {
                    echo "<tr>";
                    echo "<td>" . ($trans['member']['name'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($trans['book']['title'] ?? 'N/A') . "</td>";
                    echo "<td>" . formatDateTime($trans['borrowDate'] ?? '') . "</td>";
                    echo "<td>" . formatDate($trans['dueDate'] ?? '') . "</td>";
                    echo "<td><span style='padding: 5px 10px; border-radius: 3px; background-color: #bee3f8;'>ACTIVE</span></td>";
                    echo "<td>";
                    echo "<a href='transactions.php?return=" . $trans['id'] . "' class='btn btn-success' onclick='return confirm(\"Return this book?\");'>Return</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>No active borrowings</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'><div class='alert alert-error'>Unable to load transactions. Make sure the backend is running.</div></td></tr>";
        }
        ?>
    </tbody>
</table>

<h3>Completed Transactions</h3>
<table>
    <thead>
        <tr>
            <th>Member</th>
            <th>Book</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (is_array($transactions) && !isset($transactions['error'])) {
            $completed = array_filter($transactions, function($t) { return $t['status'] === 'COMPLETED'; });
            if (count($completed) > 0) {
                foreach ($completed as $trans) {
                    echo "<tr>";
                    echo "<td>" . ($trans['member']['name'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($trans['book']['title'] ?? 'N/A') . "</td>";
                    echo "<td>" . formatDateTime($trans['borrowDate'] ?? '') . "</td>";
                    echo "<td>" . formatDate($trans['returnDate'] ?? '') . "</td>";
                    echo "<td><span style='padding: 5px 10px; border-radius: 3px; background-color: #c6f6d5;'>COMPLETED</span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align: center;'>No completed transactions</td></tr>";
            }
        }
        ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
