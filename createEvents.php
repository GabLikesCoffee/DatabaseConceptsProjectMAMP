<script>
function checkRSO() {
    let cat = document.getElementById('category');
    let rsoSelect = document.getElementById('rsoNameSelect');
    if (cat.value == 'RSO') {
        if (rsoSelect.getAttribute("hidden") !== null) {
            rsoSelect.removeAttribute("hidden");
        }
    } else {
        rsoSelect.setAttribute("hidden", true);
    }
}
</script>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <center>
        <h1>Add Event</hi>
    </center>
    <br />
    <br />
    <form method="post" name="submit">

        <input required type="text" name="name" class="form-control" placeholder="Event Name"></input>

        <select class="form-select" name="category" onchange="checkRSO()" id='category'>
            <option selected value="public">public</option>
            <option value="private">private</option>
            <option value="RSO">RSO</option>
        </select>

        <div id="rsoNameSelect" hidden>
            No RSOs!
        </div>

        <input required type="textarea" name="description" class="form-control" placeholder="Description"></input>

        <input required type="input" name="time" class="form-control" placeholder="Time"></input>

        <input required type="date" name="date" class="form-control" placeholder="Date"></input>

        <input required type="input" name="location" class="form-control" placeholder="Location"></input>

        <input required type="input" name="contactPhone" class="form-control" placeholder="Phone Number"></input>

        <input required type="email" name="contactEmail" class="form-control" placeholder="Contact Email"></input>

        <div id="uniSelect"></div>


        <button class="btn btn-primary" name="submit">Create Event</button>

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

$sqlRSOs = "SELECT R.name from RSO R, RSOmembers RM WHERE RM.userId='$userId' AND RM.RSOname = R.name AND R.creator = '$userId'";
$result = $conn->query($sqlRSOs);
$numExists = $result->num_rows;
if ($numExists > 0) {

    echo " 
        <script type=\"text/javascript\">
            let insertSelect2 = '<select class=\"form-select\" name=\"rsoname\">';
            insertSelect2 += '<option selected>Select</option>';
        </script>
    ";

    while ($row = $result->fetch_assoc()) {
        echo " 
        <script type=\"text/javascript\">
                insertSelect2 += '<option value=\"$row[name]\">$row[name]</option>';
        </script>
        ";
    }
    echo "
    <script type=\"text/javascript\">
        insertSelect2 += '</select>';
        document.getElementById('rsoNameSelect').innerHTML = insertSelect2;
    </script>
    ";
}


$sqlEvents = "SELECT * FROM Universities";
$result = $conn->query($sqlEvents);
$numExists = $result->num_rows;
if ($numExists > 0) {

    echo " 
        <script type=\"text/javascript\">
            let insertSelect = '<select class=\"form-select\" name=\"university\" id=\"universitySelect\">';
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

if (
    isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['description']) && !empty($_POST['time']) && !empty($_POST['date']) && !empty($_POST['location']) && !empty($_POST['contactPhone']) && !empty($_POST['contactEmail']) && !empty($_POST['university'])
) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $contactPhone = $_POST['contactPhone'];
    $contactEmail = $_POST['contactEmail'];
    $university = $_POST['university'];
    $university = $_POST['university'];

    if ($category != 'RSO') {
        $sql = "INSERT INTO Events (name, category, description, time, date, location, contactPhone, contactEmail, approved, university) 
    VALUES ('$name', '$category','$description','$time','$date','$location','$contactPhone','$contactEmail', 'no', '$university')";
        if ($conn->query($sql) === TRUE) {
            echo "New event created successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        if (!empty($_POST['rsoname'])) {
            $rsoname = $_POST['rsoname'];
            $sql = "INSERT INTO Events (name, category, description, time, date, location, contactPhone, contactEmail, approved, university, RSOname) 
    VALUES ('$name', '$category','$description','$time','$date','$location','$contactPhone','$contactEmail', 'yes', '$university', '$rsoname')";
            if ($conn->query($sql) === TRUE) {
                echo "New event created successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Please fill out the RSO name!";
        }
    }
}
$conn->close();
?>