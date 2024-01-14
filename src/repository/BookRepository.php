<?php

use models\Book;
require_once 'Repository.php';
require_once __DIR__.'/../models/Book.php';

class BookRepository extends Repository
{
    public function getBook(int $id): ?Book
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.books WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book == false) {
            return null;
        }

        return new Book(
            $book['id'],
            $book['title'],
            $book['author'],
            $book['publish_date'],
            $book['description'],
            $book['price'],
            $book['image'],
            $book['likes'],
            $book['dislikes']
        );
    }

    public function getBooks(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM books;
        ');
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($books as $book) {
            $result[] = new Book(
                $book['id'],
                $book['title'],
                $book['author'],
                $book['publish_date'],
                $book['description'],
                $book['price'],
                $book['image'],
                $book['likes'],
                $book['dislikes']
            );
        }
        return $result;
    }



    public function getBookByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM books WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserBooks(int $id): ?array {
        $stmt = $this->database->connect()->prepare('
        SELECT books.*
        FROM users
        JOIN user_books ON users.id = user_books.user_id
        JOIN books ON user_books.book_id = books.id
        WHERE users.id = :id
    ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            // Obsłuż błąd wykonania zapytania
            return null;
        }

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($books)) {
            return null;
        }

        $result = [];

        foreach ($books as $book) {
            $result[] = new Book(
                $book['id'],
                $book['title'],
                $book['author'],
                $book['publish_date'],
                $book['description'],
                $book['price'],
                $book['image'],
                $book['likes'],
                $book['dislikes']
            );
        }

        return $result;
    }

    public function getTable(int $id): ?array {
        $stmt = $this->database->connect()->prepare('
        SELECT books.*
        FROM shop_tables
        JOIN books_tables ON shop_tables.id = books_tables.table_id
        JOIN books ON books_tables.book_id = books.id
        WHERE shop_tables.id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            // Obsłuż błąd wykonania zapytania
            return null;
        }
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($books)) {
            return null;
        }
        $result = [];

        foreach ($books as $book) {
            $result[] = new Book(
                $book['id'],
                $book['title'],
                $book['author'],
                $book['publish_date'],
                $book['description'],
                $book['price'],
                $book['image'],
                $book['likes'],
                $book['dislikes']
            );
        }
        return $result;
    }

    public function getUserCart(int $id): ?array {
        $stmt = $this->database->connect()->prepare('       
        SELECT books.*
        FROM carts
        JOIN books ON carts.book_id = books.id
        WHERE carts.user_id = :id;
    ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            // Obsługa błędu wykonania zapytania
            return null;
        }

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($books)) {
            return null;
        }

        $result = [];

        foreach ($books as $book) {
            $result[] = new Book(
                $book['id'],
                $book['title'],
                $book['author'],
                $book['publish_date'],
                $book['description'],
                $book['price'],
                $book['image'],
                $book['likes'],
                $book['dislikes']
            );
        }

        return $result;
    }
}