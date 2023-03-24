<html>

<head></head>

<body>
    <h1>APPROVE RSO MEMBERS</h1>
    <a href="homePage.php">Back</a>
    <h2>Members That Are Pending Approval</h2>
    <form method="post" name="submit">
        <label>User ID</label>
        <input required type="text" name="memberId" id="userId" class="form-control" placeholder="User ID"></input>
        <br />

        <label>RSO Name</label>
        <input required type="text" name="RSOname" id="RSOname" class="form-control" placeholder="RSO Name"></input>
        <br />
        <button name="submit" type="submit">Approve Member</button>
    </form>
    <div class="record-container" style="overflow-y:auto">
        <div class="tables">
            <div class="content-table" id="contactsTable">
                <table id="contacts">
                    <thead>
                        <tr>
                            <th>RSO Name</th>
                            <th>User Id</th>
                            <th>Approve Fill Button</th>
                        </tr>
                    </thead>
                    <tbody id="tableInformation"></tbody>
                </table>
            </div>
        </div>
    </div>
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
}

$sqlEvents = "SELECT JR.userId, JR.RSOname FROM RSO R, RSOJoinRequest JR WHERE JR.RSOname = R.name AND R.creator = '$userId'";

$result = $conn->query($sqlEvents);
$numExists = $result->num_rows;
if ($numExists > 0) {
    // output data of each row

    // start of the table
    echo " 
        <script type=\"text/javascript\">
            let insertTable = '<table border=1>';

            function approveFill(id, RSOname){
                let userId = document.getElementById('userId');
                let name = document.getElementById('RSOname');
                userId.value = id;
                name.value = RSOname;
            }
        </script>
    ";


    while ($row = $result->fetch_assoc()) {

        echo "
            <script type=\"text/javascript\">
                insertTable += '<tr>'

                insertTable += '<td>\"$row[RSOname]\"</td>';

                insertTable += '<td>\"$row[userId]\"</td>';

                insertTable += '<td><button onclick=\"approveFill(\'$row[userId]\', \'$row[RSOname]\')\">approve</button></td>';
                
                insertTable += '</tr>';
            
            </script>
        ";
    }

    // end of table
    echo "
        <script type=\"text/javascript\">
            insertTable += '</table>';
            document.getElementById('tableInformation').innerHTML = insertTable;
        </script>
        ";
} else {
    echo "0 results";
}

if (isset($_POST['submit']) && !empty($_POST['memberId'])) {

    $memberId = $_POST['memberId'];
    $RSOname = $_POST['RSOname'];
    echo $memberId . $RSOname;
    $sql = "INSERT INTO `RSOmembers`(`RSOname`, `userId`) VALUES ('$RSOname','$memberId')";
    if ($conn->query($sql) === TRUE) {
        echo "New Member Added to RSO!";
        $sqlremove = "DELETE FROM `RSOJoinRequest` WHERE `userID` = '$memberId' AND`RSOname` = '$RSOname'";
        if ($conn->query($sqlremove) === TRUE) {
            echo "Successfully Removed Request";
            echo $RSOname;
        } else {
            echo "Error: " . $sqlremove . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else {
    echo "press submit";
}

$conn->close();
?>

<style>
    .record-container {
        border-radius: 10px;
        height: 600px;
        padding: 20px 0;
        margin: 30px 0;
        box-shadow: 0px 0px 3px 0px rgba(1, 0, 1, 1);
        -webkit-box-shadow: 0px 0px 2px 0px rgba(1, 0, 1, 1);
        /* color: rgb(65 54 54); */
    }

    .tables {
        width: 100%;
        height: 100%;
        table-layout: fixed;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border-radius: 10px;
    }

    table {
        border: 1;
    }

    .content-table {
        height: 460px;
        overflow-x: auto;
        margin-top: 0px;
        border-radius: 10px;
    }


    #contacts td {
        border: .5px solid rgb(0, 0, 0);
    }

    #contacts th {
        border: .5px solid rgb(0, 0, 0);
    }

    #contacts th {
        padding: 20px 15px;
        font-family: 'Karla';
        font-size: 18px;
        font-weight: bold;
        background-color: #9fad8f;
        ;
        text-transform: uppercase;
        width: 200px;
        text-align: center;
    }
</style>