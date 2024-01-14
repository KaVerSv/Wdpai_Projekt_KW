<?php

namespace models;

class User
{
    private  $userID;
    private  $email;
    private  $username;
    private  $dateOfBirth;
    private  $password;

    public function __construct(int $userID, string $email, string $username, string $password, string $bithdate)
    {
        $this->userID = $userID;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->dateOfBirth = new \DateTime($bithdate);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserId(): int
    {
        return $this->userID;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setUsername(string $username) {
        $this->username = $username;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth)
    {
        $this->dateOfBirth = new \DateTime($dateOfBirth);
    }
}