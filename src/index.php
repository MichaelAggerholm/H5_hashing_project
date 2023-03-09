<?php

session_start();

// Hvis brugeren allerede er logget ind, sendes brugeren til dashboard
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// når form submit, forsøg at godkend brugerlogin
if (isset($_POST['username']) && isset($_POST['password'])) {
    $mysqli = new mysqli('db', 'michael', '123456', 'hashing_db');
    if ($mysqli->connect_errno) {
        die("Fejlede forbindelsen til MySQL: " . $mysqli->connect_error);
    }

    // undgå SQL-injektion ved brug af real_escape_string
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // Hent alle users, hver der er brugere i databasen, check om det hashede password matcher ved brug af password_verify
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Forkert Brugernavn eller adgangskode';
        }
    } else {
        $error = 'Forkert Brugernavn eller adgangskode';
    }

    $mysqli->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
<?php } ?>
<form method="post">
    <div>
        <label for="username">Brugernavn:</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div>
        <label for="password">Adgangskode:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <button type="submit">Login</button>
        <br />
        <br />
        <span>eller registrer</span>
        <a href="register.php">Registrer</a>
    </div>
</form>
</body>
</html>