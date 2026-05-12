package com.library.repository;

import com.library.model.Transaction;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface TransactionRepository extends JpaRepository<Transaction, Integer> {
    List<Transaction> findByMemberId(Integer memberId);
    List<Transaction> findByBookId(Integer bookId);
    List<Transaction> findByStatus(String status);
}
