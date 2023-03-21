<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <center>
        <h1>Create an RSO</h1>
    </center>
    <br />
    <br />
    <form method="post" name="submit">

        <input required type="text" name="rsoName" class="form-control" placeholder="Name of the RSO"></input>
        <div id="uniSelect">No Universities</div>
        <button class="btn btn-primary" name="submit">Create RSO</button>

    </form>
    <a href="joinRso.php"><button class="btn btn-primary">Join an RSO</button></a>
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


$sqlEvents = "SELECT * FROM Universities UN, Users U WHERE U.userId = '$userId' AND U.university = UN.name";
$result = $conn->query($sqlEvents);
$numExists = $result->num_rows;
if ($numExists > 0) {

    echo " 
        <script type=\"text/javascript\">
            let insertSelect = '<select name=\"university\" id=\"universitySelect\">';
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
        document.getElementById('uniSelect').innerHTML = insertSelect;
    </script>
    ";
}

if (isset($_POST['submit']) && !empty($_POST['rsoName']) && !empty($_POST['university'])) {

    $rsoname = $_POST['rsoName'];
    $university = $_POST['university'];


    $sql = "INSERT INTO `RSO`(`name`, `numberOfMembers`, `university`) VALUES ('$rsoname', 0,'$university')";
    $sql2 = "INSERT INTO `RSOmembers`(`RSOname`, `userId`) VALUES ('$rsoname', '$userId')";
    if ($conn->query($sql) === TRUE) {
        echo "RSO has been created!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    if ($conn->query($sql2) === TRUE) {
        echo "Added as a member of the new RSO!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
$conn->close();
?>