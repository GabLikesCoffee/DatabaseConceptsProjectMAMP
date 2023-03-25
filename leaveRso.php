<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <center>
        <h1>Leave an RSO</hi>
    </center>
    <br />
    <br />
    <form method="post" name="submit">
        <div id="rsoNameSelect">
            No RSOs for you to leave!
        </div>
        <button class="btn btn-primary" name="submit">Leave RSO</button>

    </form>
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


$sqlRSOs = "SELECT R.name from RSO R, RSOmembers RM WHERE RM.userId='$userId' AND RM.RSOname = R.name AND R.creator <> '$userId'";
$result = $conn->query($sqlRSOs);
$numExists = $result->num_rows;
if ($numExists > 0) {

    echo " 
        <script type=\"text/javascript\">
            let insertSelect = '<select class=\"form-select\" name=\"name\">';
            insertSelect += '<option selected>Select</option>';
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
    if ($rsoname != "Select") {
        $sql = "DELETE FROM `RSOmembers` WHERE userId = '$userId' AND RSOname = '$rsoname'";
        if ($conn->query($sql) === TRUE) {
            echo "Removed from the RSO!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "a field is empty";
}
$conn->close();
?>