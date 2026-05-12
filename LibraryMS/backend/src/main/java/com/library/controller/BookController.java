package com.library.controller;

import com.library.model.Book;
import com.library.service.BookService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/books")
public class BookController {
    @Autowired
    private BookService bookService;

    @GetMapping
    public ResponseEntity<List<Book>> getAllBooks() {
        return ResponseEntity.ok(bookService.getAllBooks());
    }

    @GetMapping("/{id}")
    public ResponseEntity<Book> getBookById(@PathVariable Integer id) {
        Optional<Book> book = bookService.getBookById(id);
        return book.map(ResponseEntity::ok).orElseGet(() -> ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<Book> createBook(@RequestBody Book book) {
        return ResponseEntity.ok(bookService.saveBook(book));
    }

    @PutMapping("/{id}")
    public ResponseEntity<Book> updateBook(@PathVariable Integer id, @RequestBody Book book) {
        Optional<Book> existing = bookService.getBookById(id);
        if (existing.isPresent()) {
            book.setId(id);
            return ResponseEntity.ok(bookService.saveBook(book));
        }
        return ResponseEntity.notFound().build();
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteBook(@PathVariable Integer id) {
        bookService.deleteBook(id);
        return ResponseEntity.noContent().build();
    }

    @GetMapping("/search/title/{title}")
    public ResponseEntity<List<Book>> searchByTitle(@PathVariable String title) {
        return ResponseEntity.ok(bookService.searchByTitle(title));
    }

    @GetMapping("/search/author/{author}")
    public ResponseEntity<List<Book>> searchByAuthor(@PathVariable String author) {
        return ResponseEntity.ok(bookService.searchByAuthor(author));
    }

    @GetMapping("/genre/{genre}")
    public ResponseEntity<List<Book>> getByGenre(@PathVariable String genre) {
        return ResponseEntity.ok(bookService.getByGenre(genre));
    }
}
