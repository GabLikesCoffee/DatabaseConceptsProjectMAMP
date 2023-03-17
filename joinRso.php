<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <center>
        <h1>Join RSO</hi>
    </center>
    <br />
    <br />
    <form method="post" name="submit">
        <div id="rsoNameSelect">
            No RSOs for you to join right now!
        </div>
        <button class="btn btn-primary" name="submit">Request to join RSO</button>

    </form>
    <a href="createRso.php"><button class="btn btn-primary">Create an RSO</button></a>
    <a href="homePage.php"><button class="btn btn-primary">Go Back</button></a>
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


$sqlRSOs = "SELECT R.name from Users U, RSO R WHERE R.university=U.university AND U.userId = '$userId'";
$result = $conn->query($sqlRSOs);
$numExists = $result->num_rows;
if ($numExists > 0) {

    echo " 
        <script type=\"text/javascript\">
            let insertSelect = '<select class=\"form-select\" name=\"name\">';
        </script>
    ";

    while ($row = $result->fetch_assoc()) {
        echo " 
        <script type=\"text/javascript\">
            insertSelect += '<option value=\"$row[name]\">$row[name]</option>';
        </script>
        ";
    }
    echo "
    <script type=\"text/javascript\">
        insertSelect += '</select>';
        document.getElementById('rsoNameSelect').innerHTML = insertSelect;
    </script>
    ";
}

if (
    isset($_POST['submit']) && !empty($_POST['name'])
) {
    $rsoname = $_POST['name'];

    $sql = "INSERT INTO RSOJoinRequest (RSOname, userId) 
VALUES ('$rsoname', '$userId')";
    if ($conn->query($sql) === TRUE) {
        echo "RSO join request has been sent!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>