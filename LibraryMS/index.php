<?php
$page_title = 'Dashboard';
include 'header.php';

// Get statistics from API
$books = apiCall(API_BOOKS);
$members = apiCall(API_MEMBERS);
$transactions = apiCall(API_TRANSACTIONS);

$total_books = is_array($books) && !isset($books['error']) ? count($books) : 0;
$total_members = is_array($members) && !isset($members['error']) ? count($members) : 0;
$active_transactions = 0;
$available_books = 0;

if (is_array($books) && !isset($books['error'])) {
    foreach ($books as $book) {
        $available_books += $book['availableCopies'] ?? 0;
    }
}

if (is_array($transactions) && !isset($transactions['error'])) {
    foreach ($transactions as $trans) {
        if ($trans['status'] === 'ACTIVE') {
            $active_transactions++;
        }
    }
}
?>

<h2>Dashboard</h2>

<div class="stats">
    <div class="stat-card">
        <h3>Total Books</h3>
        <div class="number"><?php echo $total_books; ?></div>
    </div>
    <div class="stat-card">
        <h3>Available Books</h3>
        <div class="number"><?php echo $available_books; ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Members</h3>
        <div class="number"><?php echo $total_members; ?></div>
    </div>
    <div class="stat-card">
        <h3>Active Borrowings</h3>
        <div class="number"><?php echo $active_transactions; ?></div>
    </div>
</div>

<h3>Recent Transactions</h3>
<table>
    <thead>
        <tr>
            <th>Member</th>
            <th>Book</th>
            <th>Type</th>
            <th>Borrow Date</th>
            <th>Due Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (is_array($transactions) && !isset($transactions['error'])) {
            $sorted = array_slice($transactions, 0, 10);
            if (count($sorted) > 0) {
                foreach ($sorted as $trans) {
                    echo "<tr>";
                    echo "<td>" . ($trans['member']['name'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($trans['book']['title'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($trans['transactionType'] ?? 'N/A') . "</td>";
                    echo "<td>" . formatDateTime($trans['borrowDate'] ?? '') . "</td>";
                    echo "<td>" . formatDate($trans['dueDate'] ?? '') . "</td>";
                    echo "<td><span style='padding: 5px 10px; border-radius: 3px; background-color: " . ($trans['status'] === 'ACTIVE' ? '#bee3f8' : '#c6f6d5') . ";'>" . $trans['status'] . "</span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>No transactions yet</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'><div class='alert alert-error'>Unable to load transactions. Make sure the Java backend is running on http://localhost:8080</div></td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
