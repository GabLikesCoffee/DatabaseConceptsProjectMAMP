<?php
// test
include 'connect.php';
if (
    isset($_POST['submit']) && !empty($_POST['userId'])
    && !empty($_POST['password'])
) {
    $userId = $_POST['userId'];
    $password = $_POST['password'];
    $sql = "INSERT INTO Users (userId, password, userLevel) 
    VALUES ('$userId', '$password', 'student')";

    $sqlu = "SELECT * FROM Users WHERE userId='$userId'";
    $result = $conn->query($sqlu);
    $numExists = $result->num_rows;

    if ($numExists == 0) {
        echo "Good userId";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully. Select the log in button to proceed.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "bad userId";
    }
    $conn->close();
}

?>



<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>APP</title>
</head>

<body>
    <div class="container">
        <h1>Register</h1>
        <form method="post" name="submit">
            <input required type="text" name="userId" class="form-control" placeholder="UserId"></input>
            <br />

            <input required type="password" name="password" class="form-control" placeholder="Password"></input>
            <br />

            <button class="btn btn-info" name="submit" type="submit">Submit</button>
            <br />

        </form>
        <a href="/DC_Project/login.php"><button class="btn-lg">Log in!</button></a>
    </div>
</body>

</html>