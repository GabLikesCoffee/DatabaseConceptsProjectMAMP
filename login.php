<?php

include 'connect.php';
if (isset($_POST['submit'])) {
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE userId='$userId' AND password='$password'";
    $result = $conn->query($sql);
    $numExists = $result->num_rows;

    if ($numExists == 0) {
        echo "incorrect userId/password";

    } else {
        echo "Authenticated";
        header("Location: /DC_Project/homePage.php");
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
        <h1>Log in</h1>
        <br />
        <form method="post" name="submit">

            <input type="text" name="userId" class="form-control" placeholder="UserId"></input>
            <br />

            <input type="text" name="password" class="form-control" placeholder="Password"></input>
            <br />

            <button class="btn btn-info" name="submit" type="submit">Submit</button>
            <br />

        </form>
        <a href="/DC_Project/register.php"><button class="btn-lg">New user? Register Here!</button></a>
    </div>
</body>

</html>