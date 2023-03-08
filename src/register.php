<?php
session_start();

// Hvis brugeren allerede er logget ind, sendes brugeren til dashboard
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// // hvis form submit, forsøg at registrer bruger
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Henter form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hasher password med password_hash, som tilføjer salt til passwordet
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Forbind til mysql db
    $host = 'db';
    $user = 'michael';
    $pass = '123456';
    $dbname = 'hashing_db';
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Tjek om brugernavn allerede eksisterer
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $error = 'Brugernavn findes allerede';
    } else {
        // øg sikkerheden ved brug af Prepared statements, som undgår SQL-injektion ved at bruge placeholders i stedet for at indsætte værdier direkte i SQL-statementet
        $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $hashed_password);
        $stmt->execute();

        // Redirect til login
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrer</title>
</head>
<body>
<h1>Registrer</h1>
<?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
<?php } ?>
<form method="post">
    <div>
        <label for="username">Brugernavn:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label for="password">Adgangskode:</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <button type="submit">Registrer</button>
    </div>
</form>
</body>
</html>