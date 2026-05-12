<?php
include 'config.php';
if (!isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Library Management System'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>📚 Library Management System</h1>
    </header>

    <nav>
        <div class="nav-links">
            <a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Dashboard</a>
            <a href="books.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'books.php') ? 'active' : ''; ?>">Books</a>
            <a href="members.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'members.php') ? 'active' : ''; ?>">Members</a>
            <a href="transactions.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'transactions.php') ? 'active' : ''; ?>">Transactions</a>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
        <div class="user-nav">
            <span>👤 <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
        <?php endif; ?>
    </nav>

    <div class="container">
        <main>
