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

    public function removeFromCart(int $userId, int $bookId): bool {
        $conn = $this->database->connect();

        // Sprawdź, czy książka o danym ID znajduje się w koszyku użytkownika
        $stmt = $conn->prepare('SELECT * FROM carts WHERE user_id = :userId AND book_id = :bookId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            // Obsługa błędu wykonania zapytania
            return false;
        }

        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cartItem) {
            // Książka o danym ID nie znajduje się w koszyku użytkownika
            return false;
        }

        // Usuń książkę z koszyka
        $stmt = $conn->prepare('DELETE FROM carts WHERE user_id = :userId AND book_id = :bookId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            // Obsługa błędu wykonania zapytania
            return false;
        }

        return true; // Książka została pomyślnie usunięta z koszyka
    }

    public function addToCart(int $userId, int $bookId): bool
    {
        // Sprawdź, czy książka o danym ID już nie znajduje się w koszyku użytkownika
        if ($this->isBookInCart($userId, $bookId)) {
            return false; // Książka już istnieje w koszyku
        }

        // Dodaj książkę do koszyka w bazie danych
        $stmt = $this->database->connect()->prepare('INSERT INTO carts (user_id, book_id) VALUES (:userId, :bookId)');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        return $stmt->execute(); // Zwróć true, jeśli udało się dodać książkę do koszyka
    }

    private function isBookInCart($userId, $bookId) {
        // Sprawdź, czy taka para już istnieje w koszyku
        $stmt = $this->database->connect()->prepare('SELECT * FROM carts WHERE user_id = :userId AND book_id = :bookId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result !== false); // Zwróć true, jeśli taka para już istnieje w koszyku
    }
}