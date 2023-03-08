<?php
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    public function testValidCredentials()
    {
        // Test at en bruger kan oprettes og logge ind med gyldige brugernavn og adgangskode
        $username = 'testuser';
        $password = 'testpassword';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $mysqli = new mysqli('db', 'michael', '123456', 'hashing_db');
        $mysqli->query("INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')");

        $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
        $user = $result->fetch_assoc();
        $authenticated = password_verify($password, $user['password']);

        $this->assertTrue($authenticated);

        // Ryd op efter testen, ved at fjerne brugeren fra databasen
        $mysqli->query("DELETE FROM users WHERE username='$username'");
        $mysqli->close();
    }

    public function testInvalidCredentials()
    {
        // Opret en bruger og login med forkert adgangskode, for at sikre at brugeren ikke kan logge ind
        $username = 'testuser';
        $password = 'testpassword';
        $wrongPassword = 'wrongpassword';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $mysqli = new mysqli('db', 'michael', '123456', 'hashing_db');
        $mysqli->query("INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')");

        $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
        $user = $result->fetch_assoc();
        $authenticated = password_verify($wrongPassword, $user['password']);

        $this->assertFalse($authenticated);

        // Ryd op efter testen, ved at fjerne brugeren fra databasen
        $mysqli->query("DELETE FROM users WHERE username='$username'");
        $mysqli->close();
    }
}
