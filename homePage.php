<?php
include 'connect.php';
session_start();
//Checks that the user is logged in. If not, redirect to the login screen.
if (!$_SESSION['userId']) {
    header("Location: /DC_Project/login.php");
}

$sqlEvents = "SELECT * FROM Events WHERE category='public'";
$result = $conn->query($sqlEvents);
$numExists = $result->num_rows;
if ($numExists > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"] . " - Category: " . $row["category"] . " - Description: " . $row["description"] . " - Time: " . $row["time"] . " - Date: " . $row["date"] . " - Location: " . $row["location"] . " - Contact Phone: " . $row["contactPhone"] . " - Contact Email: " . $row["contactEmail"] . "<br>" . "<br>";
    }
} else {
    echo "0 results";
}

echo ("Welcome " . $_SESSION['userId'] . "!");
$conn->close();
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