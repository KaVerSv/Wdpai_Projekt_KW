<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Book.php';
require_once __DIR__.'/../repository/BookRepository.php';

class BookController extends AppController {

    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $bookRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->bookRepository->getProjectByTitle($decoded['search']));
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }

    public function library() {
        if (!isset($_SESSION['userId'])) {
            return $this->render('login');
        }
        $user_books = $this->bookRepository->getUserBooks($_SESSION['userId']);
        return  $this->render('library', ['books' => $user_books]);
    }

    public function cart() {
        if (!isset($_SESSION['userId'])) {
            return $this->render('login');
        }
        $user_books = $this->bookRepository->getUserCart($_SESSION['userId']);
        return  $this->render('cart', ['books' => $user_books]);
    }

    public function index() {
        $recomended_books = $this->bookRepository->getTable(1);
        $this->render('shop', ['books' => $recomended_books]);
    }

    public function shop() {
        $recomended_books = $this->bookRepository->getTable(1);
        $this->render('shop', ['books' => $recomended_books]);
    }

    public function book_page($queryParams = []) {
        $id = $queryParams['id'] ?? null;

        if ($id !== null) {
            $book = $this->bookRepository->getBook($id);
            $this->render('book_page', ['book' => $book]);
        } else {
            // Obsługa błędu braku ID w żądaniu
            die("Missing ID in request");
        }
    }

    public function delete($queryParams = []) {
        $userId = $queryParams['userId'] ?? null;
        $bookId = $queryParams['bookId'] ?? null;

        if ($userId !== null || $bookId !== null) {
            $success = $this->bookRepository->removeFromCart($userId, $bookId);
            if ($success) {
                $this->render('cart');
            } else {
                die("failed to remove book");
            }

        } else {
            // Obsługa błędu braku ID w żądaniu
            die("Missing ID in request");
        }
    }

    public function addToCart($queryParams = [])
    {
        if (!isset($_SESSION['userId'])) {
            return $this->render('login');
        }

        $bookId = $queryParams['bookId'] ?? null;

        // Sprawdź, czy bookId zostało przekazane i czy to jest poprawna liczba całkowita
        if ($bookId !== null && is_numeric($bookId)) {
            // Pobierz ID użytkownika z sesji
            $userId = $_SESSION['userId'];

            // Wykorzystaj metodę z repozytorium do dodawania do koszyka
            if ($this->bookRepository->addToCart($userId, $bookId)) {
                // Udało się dodać książkę do koszyka
                // Możesz przekierować użytkownika na stronę koszyka lub inny widok
                return $this->render('cart');
            } else {
                // Błąd przy dodawaniu do koszyka
                return $this->render('error');
            }
        } else {
            // Nieprawidłowe bookId, możesz obsłużyć błąd lub przekierować użytkownika na inną stronę
            return $this->render('error');
        }
    }



}