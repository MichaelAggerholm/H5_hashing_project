<?php
use PHPUnit\Framework\TestCase;

class hashedPasswordsTest extends TestCase
{
    public function testHashing()
    {
        // Generer flere passwords
        $passwords = ['password123', 'testpassword', '123456789'];

        // hash hvert password
        $hashed_passwords = [];
        foreach ($passwords as $password) {
            $hashed_passwords[] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Sammenlign hvert hashed password mod hinanden og mod det tilsvarende password i plaintext
        foreach ($passwords as $key => $password) {
            // Sammenlign med sig selv
            $this->assertTrue(password_verify($password, $hashed_passwords[$key]));

            // Sammenlign med andre passwords
            for ($i = 0; $i < count($hashed_passwords); $i++) {
                if ($i !== $key) {
                    $this->assertFalse(password_verify($password, $hashed_passwords[$i]));
                }
            }
        }
    }
}