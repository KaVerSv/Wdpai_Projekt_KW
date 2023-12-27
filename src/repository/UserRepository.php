<?php

use models\User;

require_once 'Repository.php';
require_once  __DIR__.'/../models/User.php';


class UserRepository extends  Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['username'],
            $user['password'],
            $user['birthdate']
        );
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO users (email, username, password, birthdate)
        VALUES (?, ?, ?, ?)
        ');

        // Convert DateTime to string using format method
        $birthdateString = $user->getBirthDate()->format('Y-m-d');

        $stmt->execute([
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword(),
            $birthdateString  // Use the formatted string here
        ]);
    }

}