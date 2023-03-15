<?php

include 'connect.php';
if (
    isset($_POST['submit']) && !empty($_POST['userId'])
    && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['university'])
) {
    $userId = $_POST['userId'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $university = $_POST['university'];

    $sql = "INSERT INTO Users (userId, password, userLevel) 
    VALUES ('$userId', '$password', 'student')";

    $sql2 = "INSERT INTO Users (userId, password, userLevel, university, email) 
    VALUES ('$userId', '$password', 'student', '$university', '$email')";

    $sqlUserIDExists = "SELECT * FROM Users WHERE userId='$userId'";
    $sqlUniExist = "SELECT * FROM Universities WHERE name='$university'";

    $result = $conn->query($sqlUserIDExists);
    $numIDExists = $result->num_rows;

    $result2 = $conn->query($sqlUniExist);
    $numUniExists = $result2->num_rows;

    if ($numIDExists == 0) {
        echo "Good userId";
        if ($numUniExists > 0) {
            if ($conn->query($sql2) === TRUE) {
                echo "New record created successfully. Select the log in button to proceed.";
            } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            }
        } else {
            echo "University does not exist";
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
    <title>Register</title>
</head>

<body>
    <div class="container">
        <h1>Welcome!</h1>
        <form method="post" name="submit">

            <input required type="text" name="userId" class="form-control" placeholder="User ID"></input>
            <br />

            <input required type="password" name="password" class="form-control" placeholder="Password"></input>
            <br />

            <!-- needs user level input -->

            <input type="email" name="email" class="form-control" placeholder="Email"></input>
            <br />

            <input type="text" name="university" class="form-control" placeholder="University"></input>
            <br />

            <div class="btn-div">
                <button name="submit" type="submit">Register</button>
                <br />
            </div>

        </form>
        <div class="btn-div">
            <button onclick="window.location.href = '/DC_Project/login.php';">Login</button>
        </div>
    </div>
</body>

</html>

<style>
    body {
        background-color: #36454F;
        margin-bottom: 200px;
    }

    h1 {
        font-size: 65px;
        color: white;
        text-align: center;
    }

    .btn-div {
        font-size: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    button {
        background-color: #E9D3FF;
        height: 40px;
        width: 300px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: opacity 0.35, color 0.35s;
        box-shadow: 5px 5px 10px black(0, 0, 0, .15);
        transition: box-shadow 0.15s;
        transition: background-color 0.15s;
        text-align: center;
    }

    button:hover {
        background-color: rgb(255, 255, 255);
    }

    form {
        align-items: center;
        width: 250px;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form-control {
        color: black;
        font-size: 20px;
        text-align: left;
        border: none;
        border-radius: 6px;
        height: 40px;
        width: 300px;
        padding-bottom: 5px;
        background-color: grey;
    }
</style>