<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script>
    function toggleRateForm() {
        let rateForm = document.getElementById('rateForm');
        if (rateForm.getAttribute("hidden") !== null) {
            rateForm.removeAttribute("hidden");
        } else {
            rateForm.setAttribute("hidden", true);
        }
    }

    function rateFill(eventName) {
        let eventNameInput = document.getElementById("eventName");
        eventNameInput.value = eventName;
    }
    </script>
</head>

<body>

    <div class="head-bar">

        <h1 class="event-header">Events</h1>
        <span id="welcome-text"></span>


        <button class="logout-btn">
            <a href="logout.php" tite="Logout">Logout</a>
        </button>
        <button class="logout-btn" onclick="toggleRateForm()">
            Rate an Event!
        </button>
    </div>
    <div id="rateForm" hidden>
        <form method="post" name="likeform">
            <input required type="text" class="form-control" placeholder="Event Name" name="eventName"
                id="eventName"></input>
            <select required name="rating">
                <option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4</option>
                <option value=5>5</option>
            </select>
            <button name="rateform" type="submit">Rate</button>
        </form>
    </div>

    <div class="record-container" style="overflow-y:auto">
        <div class="tables">
            <div class="search-content">
                <input type="text" id="myInput" class="search-bar" onkeyup='tableSearch()'
                    placeholder="Search for event...">
            </div>
            <div class="content-table" id="contactsTable">
                <table id="contacts">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Category</th>
                            <th>Descritpion</th>
                            <th>Time</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Average Rating</th>
                            <th>Like Button</th>
                        </tr>
                    </thead>
                    <tbody id="tableInformation"></tbody>
                </table>
            </div>
        </div>
    </div>

    <table>
        <tr>
            <td>
                <div id="approveEventBtnDiv"></div>
            </td>
            <td>
                <div id="removeMembersBtnDiv"></div>
            </td>
            <td>
                <div id="leaveRSOBtnDiv"></div>
            </td>

            <td><a href="joinRso.php"><button class="btn btn-success">Join an RSO!</button></a></td>
            <td><a href="createRso.php"><button class="btn btn-success">Create an RSO!</button></a></td>
            <td><a href='comment.php'><button class='btn btn-success'>Make a Comment</button></a></td>
        </tr>
    </table>
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
$sqlCheckRSOCreator = "SELECT * FROM RSO WHERE creator='$userId'";
$sqlCheckRSOMember = "SELECT * FROM RSOmembers WHERE userId='$userId'";
$sqlCheckAdminResults = $conn->query($sqlCheckAdmin);
$sqlCheckRSOCreatorResults = $conn->query($sqlCheckRSOCreator);
$sqlCheckRSOMemberResults = $conn->query($sqlCheckRSOMember);

$item = $sqlCheckAdminResults->fetch_assoc();
$item2 = $sqlCheckRSOCreatorResults->fetch_assoc();
$item3 = $sqlCheckRSOMemberResults->fetch_assoc();

if ($item) {
    $userLevel = $item["userLevel"];
    echo $userLevel;
}

if ($item3) {
    echo " 
        <script type=\"text/javascript\">
            let insertRSOLeaveButton = '<a href=leaveRso.php><button class=\"btn btn-success\">Leave an RSO</button></a>';
            document.getElementById('leaveRSOBtnDiv').innerHTML = insertRSOLeaveButton;
        </script>
    ";
}
if ($item2) {
    echo " 
        <script type=\"text/javascript\">
            let insertButtons = '<td><a href=approveRSOMembers.php><button class=\"btn btn-success\">Approve RSO Members</button></a></td>';
            let removeButtons = '<td><a href=deleteRSOMembers.php><button class=\"btn btn-success\">Remove RSO Members</button></a></td>';
            document.getElementById('approveEventBtnDiv').innerHTML = insertButtons;
            document.getElementById('removeMembersBtnDiv').innerHTML = removeButtons;
        </script>
    ";
}

if ($userLevel == "admin") {
    echo " 
        <script type=\"text/javascript\">
            let insertButtons2 = '<td><a href=approveEvents.php><button class=\"btn btn-success\">Approve Events</button></a></td>';
            insertButtons2 += '<td><a href=createEvents.php><button class=\"btn btn-success\">Create Events</button></a></td>';
            insertButtons2 += '<td><a href=approveRSOMembers.php><button class=\"btn btn-success\">Approve RSO Members</button></a></td>';
            document.getElementById('approveEventBtnDiv').innerHTML = insertButtons2;
        </script>
    ";

}

echo " 
<script type=\"text/javascript\">
    let temp = 'Welcome Back $_SESSION[userId]';
    document.getElementById('welcome-text').innerText = temp;
</script>
";

$sqlEvents = "SELECT e.name, e.category, e.description, e.time, e.location, e.contactEmail, e.approved, e.university, e.date, e.contactPhone, e.avgRating FROM Events E WHERE category='public' UNION SELECT e.name, e.category, e.description, e.time, e.location, e.contactEmail, e.approved, e.university, e.date, e.contactPhone, e.avgRating FROM Events E, Users U WHERE E.category = 'private' AND E.university = U.university AND U.userId = '$userId' UNION SELECT e.name, e.category, e.description, e.time, e.location, e.contactEmail, e.approved, e.university, e.date, e.contactPhone, e.avgRating FROM Events E, Users U, RSOmembers R WHERE E.category = 'RSO' AND E.RSOname = R.RSOname AND R.userId = '$userId'";
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
        $avgRating = $row[avgRating];
        if ($avgRating == 0) {
            $avgRating = "No Ratings Yet!";
        }
        echo "
            <script type=\"text/javascript\">
                insertTable += '<tr>'

                insertTable += '<td>$row[name]</td>';
                insertTable += '<td>$row[category]</td>';
                insertTable += '<td>$row[description]</td>';
                insertTable += '<td>$row[time]</td>';
                insertTable += '<td>$row[date]</td>';
                insertTable += '<td>$row[location]</td>';
                insertTable += '<td>$row[contactPhone] <br /> $row[contactEmail]</td>';
                insertTable += '<td>$avgRating</td>';
                insertTable += '<td><button onclick=\"rateFill(\'$row[name]\')\">Rate Fill</button></td>';

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

echo "<script type=\"text/javascript\">
    function tableSearch() 
    {
        let input, filter, table, tr, td, txtValue;


        input = document.getElementById('myInput');
        filter = input.value.toUpperCase();
        table = document.getElementById('contacts');
        tr = table.getElementsByTagName('tr');

        for (let i = 0; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName('td')[0];
            if (td) 
            {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) 
                {
                    tr[i].style.display = '';
                } else 
                {
                    tr[i].style.display = 'none';
                }
            }
        }
    }
    </script> ";


if (isset($_POST['rateform']) && !empty($_POST['eventName']) && !empty($_POST['rating'])) {
    $eventName = $_POST['eventName'];
    $rating = $_POST['rating'];
    echo $eventName;
    echo $rating;
    $rateSql = "INSERT INTO `Ratings`(`userId`, `eventName`, `rating`) VALUES ('$userId','$eventName', '$rating')";
    $updateRateSql = "UPDATE `Ratings` SET `rating`='$rating' WHERE `eventName` = '$eventName' AND `userId` = '$userId'";
    if ($conn->query($rateSql) === TRUE) {
        echo "Rated!";
    } else {
        if ($conn->query($updateRateSql) === TRUE) {
            echo "Updated Rating!";
        } else {
            echo "error Rating" . $updateRateSql . "<br>" . $conn->error;
        }
    }

} else {
    echo "notset";
}


$conn->close();
?>

<style>
body {
    background-color: white;
}

.record-container {
    border-radius: 10px;
    height: 600px;
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
    background-color: #A7B688;
}

table {
    border: 1;
    background-color: #A7B688;

}

.content-table {
    height: 460px;
    overflow-x: auto;
    margin-top: 0px;
    border-radius: 10px;
}

#welcome-text {
    text-align: center;
    padding-bottom: 10px;
}

#contacts td {
    border: .5px solid rgb(0, 0, 0);
    text-decoration: none;
    text-align: center;

}

#contacts th {
    border: .5px solid rgb(0, 0, 0);
    text-decoration: none;

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

.head-bar {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.event-header {
    text-align: center;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
}

.logout-btn {
    width: 160px;
    font-size: 15px;
    font-weight: 500;
    font-family: inherit;
    padding: 10px;
    border: 3px solid rgb(0, 0, 0);
    border-radius: 25px;
    color: #fff;
    background-color: #eac3ce;
    cursor: pointer;
    opacity: 0.8;
    transition: all 0.5s ease;
    outline: none;
    text-decoration: none;

}

button:visited {
    text-decoration: none;
}

a {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}

.search-content {
    display: flex;
    justify-content: center;
    min-width: 150px;
    padding-bottom: 20px;
    padding-top: 10px;
}

.search-bar {
    border: 1px #000;
    border-radius: 5px;
    height: 20px;
    width: 200px;
    padding: 5px 25x 5px 25px;
    outline: 0;
    background-color: #eac3ce;
    text-align: center;
}

.rating {
    display: inline-flex;
    flex-direction: row-reverse;
}

.rating input {
    display: none;
}

.rating label {
    color: #ddd;
    font-size: 30px;
    margin-right: 10px;
}

.rating label:before {
    content: "\2605";
    position: relative;
    display: inline-block;
    color: #777;
}

.rating input:checked~label:before {
    color: #ffcc00;
}

#approveEventBtnDiv {
    display: inline;
}
</style>