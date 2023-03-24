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
        <h3>Pending RSOs. They need more members to be official. Join Now!</h3>
        <div id="rsoPendingNameSelect">
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


$sqlRSOs = "SELECT R.name, R.numberOfMembers from Users U, RSO R, RSOmembers RM WHERE R.university=U.university AND U.userId = '$userId' AND RM.RSOname = R.name AND RM.userId != '$userId'";
$result = $conn->query($sqlRSOs);
$numExists = $result->num_rows;
if ($numExists > 0) {

    echo " 
        <script type=\"text/javascript\">
            let insertSelect = '<select class=\"form-select\" name=\"name\">';
            let pendingSelect = '<select class=\"form-select\" name=\"pendingName\">';
            insertSelect += '<option selected>Select</option>';
            pendingSelect += '<option selected selected>Select</option>';
        </script>
    ";

    while ($row = $result->fetch_assoc()) {
        echo " 
        <script type=\"text/javascript\">
            if($row[numberOfMembers] < 4){
                pendingSelect += '<option value=\"$row[name]\">$row[name]</option>';
            }
            else{
                insertSelect += '<option value=\"$row[name]\">$row[name]</option>';
            }
        </script>
        ";
    }
    echo "
    <script type=\"text/javascript\">
        insertSelect += '</select>';
        pendingSelect += '</select>';
        document.getElementById('rsoNameSelect').innerHTML = insertSelect;
        document.getElementById('rsoPendingNameSelect').innerHTML = pendingSelect;
    </script>
    ";
}

if (
    isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['pendingName'])
) {
    $rsoname = $_POST['name'];
    $pendingRsoName = $_POST['pendingName'];
    if ($rsoname != "Select") {
        $sql = "INSERT INTO RSOJoinRequest (RSOname, userId) 
VALUES ('$rsoname', '$userId')";
        if ($conn->query($sql) === TRUE) {
            echo "RSO join request has been sent!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if ($pendingRsoName != "Select") {
        $sql2 = "INSERT INTO RSOJoinRequest (RSOname, userId) 
VALUES ('$pendingRsoName', '$userId')";
        if ($conn->query($sql2) === TRUE) {
            echo "RSO join request has been sent!";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }


} else {
    echo "a field is empty";
}
$conn->close();
?>