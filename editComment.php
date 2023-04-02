<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <center>
        <h1>Edit Your Comment/s</h1>
    </center>
    <br />
    <br />

    <a href="comment.php"><button class="btn btn-primary">Go Back</button></a>

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
                            <th>Comment</th>
                            <th>User</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="tableInformation"></tbody>
                </table>
            </div>
        </div>
    </div>

    <table>
        <tr>
            <td><a href="deleteComment.php"><button class="btn btn-success">Delete your Comment</button></a></td>
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

    // $sqlEvents = "SELECT * FROM Universities UN, Users U WHERE U.userId = '$userId' AND U.university = UN.name";
    // $result = $conn->query($sqlEvents);
    // $numExists = $result->num_rows;


    $sqlEvents = "SELECT e.commentId, e.message, e.eventName, e.userId FROM Comments e WHERE e.userId = '$userId'";
    $result = $conn->query($sqlEvents);
    $numExists = $result->num_rows;

    echo "---- $userId ---- ";

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

                insertTable += '<td>$row[eventName]</td>';
                insertTable += '<td>$row[message]</td>';
                insertTable += '<td>$row[userId]</td>';
                insertTable += '<td>' +
                    \"<button type='button' style='height:35px;width:35px id='edit-btn' onclick='editComment($row[commentId])'>edit</button>\" +
                '</td>';

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

    $commentId = $_POST['commentId'];

    $message = $_POST['message'];
    $sql = "UPDATE Comments SET message='$message' WHERE commentId=$commentId";
    // Update the comment text in the database
    $sql = "UPDATE Comments SET message='$message' WHERE commentId='$commentId'";
    if ($conn->query($sql) === TRUE) {
    // If the update was successful, return a success message
    echo "Comment updated successfully";
    } else {
    // If there was an error with the update, return an error message
    echo "Error updating comment: " . $conn->error;
}


    $conn->close();

?>

<script type=text/javascript>
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

    function editComment(commentId) {

        // Prompt the user for a new comment text
        var newText = prompt("Enter the new comment text:");

            // Make an AJAX request to update the comment in the database
            $.ajax({
            url: "editComment.php",
            method: "POST",
            data: { commentId: commentId, message: newText },
            success: function(response) {
                // Update the comment text on the page after it has been updated in the database
                // $('#comment_' + commentId).text(newText);

                location.reload();
            },
            error: function(xhr, status, error) {
            // If there was an error with the update, log the error to the console
            console.error("Error updating comment:", error);
            }
            });
        }


</script> 


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
            /* height: 460px; */
            overflow-x: auto;
            margin-top: 0px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
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
</style>