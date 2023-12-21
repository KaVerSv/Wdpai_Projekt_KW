<?php

namespace models;

class User
{
    private  $email;
    private  $username;

    private  $dateOfBirth;

    private  $password;

    public function __construct(string $username, string $email, string $bithdate, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->dateOfBirth = new \DateTime($bithdate);
    }

    public function getPassword(): string
    {
        return $this->password;
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

    public function getDateOfBirth(): \DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth)
    {
        $this->dateOfBirth = new \DateTime($dateOfBirth);
    }
}