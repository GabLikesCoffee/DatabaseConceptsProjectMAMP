<?php
session_start();
echo ("Welcome " . $_SESSION['userId'] . "!");
?>

<html>

<head>

</head>

<body>
    <h1>
        Home Page
    </h1>
    <p>Click here to clean <a href="logout.php" tite="Logout">Session AKA log out.</p>
</body>

</html>