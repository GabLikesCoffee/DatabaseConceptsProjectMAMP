<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <center>
        <h1>Create a University</h1>
    </center>
    <br />
    <br />
    <form method="post" name="submit">

        <label>University Name:</label>
        <input required type="text" name="name" class="form-control" placeholder="Name of the University"></input>
        <label>University Acronym:</label>
        <input required type="text" name="acronym" class="form-control" placeholder="Acronym of the University"></input>
        <label>University Location:</label>
        <input required type="text" name="location" class="form-control"
            placeholder="Location of the University"></input>
        <label>University Description:</label>
        <input required type="text" name="description" class="form-control"
            placeholder="Description of the University"></input>
        <button class="btn btn-primary" name="submit">Create University</button>
        <a href="homePage.php"><button class="btn btn-primary">Go Back</button></a>

    </form>
</body>

</html>

<?php

include 'connect.php';
session_start();

//Checks that the user is logged in. If not, redirect to the login screen.
if (!$_SESSION['userId']) {
    header("Location: /DC_Project/login.php");
}
$userId = $_SESSION['userId'];

$sqlCheckAdmin = "SELECT * FROM Users WHERE userId='$userId'";
$sqlCheckAdminResults = $conn->query($sqlCheckAdmin);

$item = $sqlCheckAdminResults->fetch_assoc();

if ($item) {
    $userLevel = $item["userLevel"];
    echo $userLevel;
}

if ($userLevel != "preSuperAdmin") {
    header("Location: /DC_Project/homePage.php");
}

if (isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['acronym']) && !empty($_POST['location']) && !empty($_POST['description'])) {

    $uniName = $_POST['name'];
    $uniAc = $_POST['acronym'];
    $uniLoc = $_POST['location'];
    $uniDes = $_POST['description'];


    $sql = "INSERT INTO `Universities`(`name`, `acronym`, `location`, `description`) VALUES ('$uniName', '$uniAc','$uniLoc', '$uniDes')";
    $sql2 = "UPDATE `Users` SET `userLevel`='superAdmin',`university`='$uniName' WHERE userId = '$userId'";
    if ($conn->query($sql) === TRUE) {
        echo "University has been created!";
        if ($conn->query($sql2) === TRUE) {
            echo "You are officially a superadmin!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>