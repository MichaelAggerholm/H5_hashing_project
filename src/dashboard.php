<?php
session_start();

// Hvis brugeren ikke er logget ind, sendes brugeren til login siden
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Hvis brugeren logger ud, smadrers session og brugeren sendes tilbage til login siden
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kontrolpanel</title>
</head>
<body>
<h1>Velkommen, <?php echo $username; ?>!</h1>
<p>Du er logget ind.</p>
<form method="post">
    <button type="submit" name="logout">Log ud</button>
</form>
</body>
</html>