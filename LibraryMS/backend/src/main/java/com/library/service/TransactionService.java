package com.library.service;

import com.library.model.Book;
import com.library.model.Member;
import com.library.model.Transaction;
import com.library.repository.BookRepository;
import com.library.repository.MemberRepository;
import com.library.repository.TransactionRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.time.LocalDate;
import java.util.List;
import java.util.Optional;

@Service
public class TransactionService {
    @Autowired
    private TransactionRepository transactionRepository;

    @Autowired
    private BookRepository bookRepository;

    @Autowired
    private MemberRepository memberRepository;

    public List<Transaction> getAllTransactions() {
        return transactionRepository.findAll();
    }

    public Optional<Transaction> getTransactionById(Integer id) {
        return transactionRepository.findById(id);
    }

    public Transaction borrowBook(Integer memberId, Integer bookId, LocalDate dueDate) {
        Optional<Member> member = memberRepository.findById(memberId);
        Optional<Book> book = bookRepository.findById(bookId);

        if (member.isPresent() && book.isPresent()) {
            Book b = book.get();
            if (b.getAvailableCopies() > 0) {
                Transaction transaction = new Transaction();
                transaction.setMember(member.get());
                transaction.setBook(b);
                transaction.setTransactionType("BORROW");
                transaction.setBorrowDate(LocalDate.now()); // FIX: populate borrowDate
                transaction.setDueDate(dueDate);
                transaction.setStatus("ACTIVE");

                // Update available copies
                b.setAvailableCopies(b.getAvailableCopies() - 1);
                bookRepository.save(b);

                return transactionRepository.save(transaction);
            }
        }
        return null;
    }

    public Transaction returnBook(Integer transactionId) {
        Optional<Transaction> transaction = transactionRepository.findById(transactionId);

        if (transaction.isPresent()) {
            Transaction t = transaction.get();
            t.setReturnDate(LocalDate.now());
            t.setStatus("COMPLETED");

            // Update available copies
            Book book = t.getBook();
            book.setAvailableCopies(book.getAvailableCopies() + 1);
            bookRepository.save(book);

            return transactionRepository.save(t);
        }
        return null;
    }

    public List<Transaction> getMemberTransactions(Integer memberId) {
        return transactionRepository.findByMemberId(memberId);
    }

    public List<Transaction> getBookTransactions(Integer bookId) {
        return transactionRepository.findByBookId(bookId);
    }

    public List<Transaction> getActiveTransactions() {
        return transactionRepository.findByStatus("ACTIVE");
    }
}
