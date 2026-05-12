package com.library.controller;

import com.library.model.Transaction;
import com.library.service.TransactionService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.time.LocalDate;
import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/transactions")
public class TransactionController {
    @Autowired
    private TransactionService transactionService;

    @GetMapping
    public ResponseEntity<List<Transaction>> getAllTransactions() {
        return ResponseEntity.ok(transactionService.getAllTransactions());
    }

    @GetMapping("/{id}")
    public ResponseEntity<Transaction> getTransactionById(@PathVariable Integer id) {
        Optional<Transaction> transaction = transactionService.getTransactionById(id);
        return transaction.map(ResponseEntity::ok).orElseGet(() -> ResponseEntity.notFound().build());
    }

    @PostMapping("/borrow")
    public ResponseEntity<Transaction> borrowBook(
            @RequestParam Integer memberId,
            @RequestParam Integer bookId,
            @RequestParam String dueDate) {
        Transaction transaction = transactionService.borrowBook(memberId, bookId, LocalDate.parse(dueDate));
        return transaction != null ? ResponseEntity.ok(transaction) : ResponseEntity.badRequest().build();
    }

    @PutMapping("/{id}/return")
    public ResponseEntity<Transaction> returnBook(@PathVariable Integer id) {
        Transaction transaction = transactionService.returnBook(id);
        return transaction != null ? ResponseEntity.ok(transaction) : ResponseEntity.notFound().build();
    }

    @GetMapping("/member/{memberId}")
    public ResponseEntity<List<Transaction>> getMemberTransactions(@PathVariable Integer memberId) {
        return ResponseEntity.ok(transactionService.getMemberTransactions(memberId));
    }

    @GetMapping("/book/{bookId}")
    public ResponseEntity<List<Transaction>> getBookTransactions(@PathVariable Integer bookId) {
        return ResponseEntity.ok(transactionService.getBookTransactions(bookId));
    }

    @GetMapping("/active")
    public ResponseEntity<List<Transaction>> getActiveTransactions() {
        return ResponseEntity.ok(transactionService.getActiveTransactions());
    }
}
