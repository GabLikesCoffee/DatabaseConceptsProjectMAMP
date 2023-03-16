<html>

<head></head>

<body>
    <h1>APPROVE EVENTS ADMINS ONLY</h1>
    <a href="homePage.php">Back</a>
    <h2>Meetings That Are Pending Approval</h2>
    <div class="record-container" style="overflow-y:auto">
        <div class="tables">
            <div class="content-table" id="contactsTable">
                <table id="contacts">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Category</th>
                            <th>Descritpion</th>
                            <th>Time</th>
                            <th>Date</th>
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
    echo $userLevel;
}

if ($userLevel != "admin") {
    header("Location: /DC_Project/homePage.php");
}
echo ("Welcome " . $_SESSION['userId'] . "!");

$sqlEvents = "SELECT * FROM Events WHERE approved='no' AND category ='public'";

$result = $conn->query($sqlEvents);
$numExists = $result->num_rows;
if ($numExists > 0) {
    // output data of each row

    // start of the table
    echo " 
        <script type=\"text/javascript\">
            let insertTable = '<table border=1>';
        </script>
    ";


    while ($row = $result->fetch_assoc()) {

        echo "
            <script type=\"text/javascript\">
                insertTable += '<tr>'

                insertTable += '<td>\"$row[name]\"</td>';
                insertTable += '<td>\"$row[category]\"</td>';
                insertTable += '<td>\"$row[description]\"</td>';
                insertTable += '<td>\"$row[time]\"</td>';
                insertTable += '<td>\"$row[date]\"</td>';
                
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