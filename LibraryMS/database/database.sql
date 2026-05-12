-- ============================================
-- Library Management System - Database Setup
-- ============================================

-- Create Database
CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

-- ============================================
-- Books Table
-- ============================================
CREATE TABLE IF NOT EXISTS books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(100) NOT NULL,
    isbn VARCHAR(20) UNIQUE,
    genre VARCHAR(50),
    total_copies INT NOT NULL DEFAULT 1,
    available_copies INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Members Table
-- ============================================
CREATE TABLE IF NOT EXISTS members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    membership_id VARCHAR(20) UNIQUE NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Transactions Table (Book Borrowing/Returning)
-- ============================================
CREATE TABLE IF NOT EXISTS transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_id INT NOT NULL,
    book_id INT NOT NULL,
    transaction_type VARCHAR(20) NOT NULL,
    borrow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    due_date DATE,
    return_date DATE,
    status VARCHAR(20) DEFAULT 'ACTIVE',
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Insert Sample Books
-- ============================================
INSERT INTO books (title, author, isbn, genre, total_copies, available_copies) VALUES
('Things Fall Apart', 'Chinua Achebe', '978-0-385-47454-2', 'Literature', 3, 3),
('Half of a Yellow Sun', 'Chimamanda Adichie', '978-1-4000-9578-7', 'Fiction', 2, 2),
('A Brief History of Time', 'Stephen Hawking', '978-0-553-38016-3', 'Science', 2, 2),
('Atomic Habits', 'James Clear', '978-0-7352-1129-2', 'Self-Help', 4, 4),
('The Art of War', 'Sun Tzu', '978-1-59030-225-6', 'Philosophy', 3, 3);

-- ============================================
-- Insert Sample Members
-- ============================================
INSERT INTO members (name, email, phone, membership_id, is_active) VALUES
('Alice Kamau', 'alice@email.com', '+254700111001', 'LIB-A001', TRUE),
('Brian Omondi', 'brian@email.com', '+254700111002', 'LIB-B002', TRUE),
('Carol Wanjiku', 'carol@email.com', '+254700111003', 'LIB-C003', TRUE);
