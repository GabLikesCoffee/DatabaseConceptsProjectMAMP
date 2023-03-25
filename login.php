<script>
    function nextChar(c) {
        return String.fromCharCode(c.charCodeAt(0) + 1);
    }

    function encryptPassword() {
        let passwordStr = document.getElementById("password").value;
        let password2Str = document.getElementById("password2").value;
        let string = "";
        for (let i = 0; i < password2Str.length; i++) {
            string += nextChar(password2Str.charAt(i));
            console.log(string);
        }
        document.getElementById("password").value = string;

    }
</script>

<?php
ob_start();
session_start();
?>


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
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['userId'] = $userId;
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
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h1>Login!</h1>
        <br />
        <form method="post" name="submit">

            <input required type="text" name="userId" class="form-control" placeholder="User ID"></input>
            <br />

            <input hidden onkeyup="encryptPassword()" required type="password" id="password2" name="password2"
                class="form-control" placeholder="Password"></input>
            <br />

            <div hidden>
                <input type="input" id="password" name="password" class="form-control" placeholder="Password"></input>
            </div>

            <div class="btn-div">
                <button name="submit" type="submit">Login</button>
                <br />
            </div>
        </form>

        <div class="btn-div">
            <button onclick="window.location.href = '/DC_Project/register.php';">Register</button>
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