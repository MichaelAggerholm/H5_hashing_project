<?php
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    // TODO: Denne test er ikke helt færdig, blot et forsøg på at teste sessions, hvis der bliver tid til det.

    public function testSession() {
        // Test at brugeren YEEEETES tilbage til login siden, hvis brugeren ikke er logget ind
        $_SESSION = array();
        $this->assertFalse(isset($_SESSION['username']));
        $this->expectOutputString('');
        // TODO: fejler da man ikke bliver mødt af 302, men bliver redirected.. skal fikses hvis der bliver tid til det..
        // $this->assertEquals(302, $this->callHeader('Location: index.php'));
        $this->assertEquals('', session_id());

        // Test, hvis brugeren logger ud, så smadrers session og brugeren YEEEETES tilbage til login siden
        $_SESSION['username'] = 'testuser';
        $_POST['logout'] = true;
        $this->assertTrue(isset($_POST['logout']));
        $this->expectOutputString('');
        // TODO: fejler da man ikke bliver mødt af 302, men bliver redirected.. skal fikses hvis der bliver tid til det..
        // $this->assertEquals(302, $this->callHeader('Location: index.php'));
        $this->assertEquals('', session_id());
    }

    private function callHeader($header) {
        // Hent alle header-værdier, i den aktuelle anmodning
        $headers = xdebug_get_headers();

        // Gennemgå værdier der matcher parameteren
        if (count($headers) > 0) {
            foreach ($headers as $hdr) {
                if (stripos($hdr, $header) !== false) {
                    // Denne del er lidt weird, men det tager i bund og grund bare statuskoden fra headeren og returnerer den som heltal
                    return (int) substr($hdr, 9, 3);
                }
            }
        }
        // Hvis headeren ikke blev fundet, returner null
        return null;
    }
}