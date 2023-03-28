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

        <label>Event Name:</label>
        <input required type="text" name="name" class="form-control" placeholder="Event Name"></input>

        <br />
        <label>Event Category:</label>
        <br />
        <select class="form-select" name="category" onchange="checkRSO()" id='category'>
            <option selected value="public">public</option>
            <option value="private">private</option>
            <option value="RSO">RSO</option>
        </select>

        <br />
        <div id="rsoNameSelect" hidden>
            No RSOs!
        </div>

        <br />
        <label>Event Description:</label>
        <input required type="textarea" name="description" class="form-control" placeholder="Description"></input>

        <label>Event Time:</label>
        <input required type="input" name="time" class="form-control" placeholder="Time"></input>

        <label>Event Date:</label>
        <input required type="date" name="date" class="form-control" placeholder="Date"></input>

        <label>Event Location:</label>
        <input required type="input" name="location" class="form-control" placeholder="Location"></input>

        <label>Contact Phone:</label>
        <input required type="input" name="contactPhone" class="form-control" placeholder="Phone Number"></input>

        <label>Contact Email:</label>
        <input required type="email" name="contactEmail" class="form-control" placeholder="Contact Email"></input>

        <label>Associated University:</label>
        <div id="uniSelect"></div>
        <br />


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

<html>

<head>
    <title>Places Search Box</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script type="module" src="./index.js"></script>
</head>

<body>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
    <div id="map"></div>

    <!-- 
      The `defer` attribute causes the callback to execute after the full HTML
      document has been parsed. For non-blocking uses, avoiding race conditions,
      and consistent behavior across browsers, consider loading using Promises
      with https://www.npmjs.com/package/@googlemaps/js-api-loader.
      -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAz35NoSlk7K93K6OHFvW2sBeZzrsChc6E&callback=initAutocomplete&libraries=places&v=weekly"
        defer></script>
    <script>
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    function initAutocomplete() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -33.8688,
                lng: 151.2195
            },
            zoom: 13,
            mapTypeId: "roadmap",
        });
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    window.initAutocomplete = initAutocomplete;
    </script>
</body>

</html>
<style>
/* 
 * Always set the map height explicitly to define the size of the div element
 * that contains the map. 
 */
#map {
    height: 100%;
}

/* 
 * Optional: Makes the sample page fill the window. 
 */
html,
body {
    height: 100%;
    margin: 0;
    padding: 0;
}

#description {
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
}

#infowindow-content .title {
    font-weight: bold;
}

#infowindow-content {
    display: none;
}

#map #infowindow-content {
    display: inline;
}

.pac-card {
    background-color: #fff;
    border: 0;
    border-radius: 2px;
    box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
    margin: 10px;
    padding: 0 0.5em;
    font: 400 18px Roboto, Arial, sans-serif;
    overflow: hidden;
    font-family: Roboto;
    padding: 0;
}

#pac-container {
    padding-bottom: 12px;
    margin-right: 12px;
}

.pac-controls {
    display: inline-block;
    padding: 5px 11px;
}

.pac-controls label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
}

#pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 400px;
}

#pac-input:focus {
    border-color: #4d90fe;
}

#title {
    color: #fff;
    background-color: #4d90fe;
    font-size: 25px;
    font-weight: 500;
    padding: 6px 12px;
}

#target {
    width: 345px;
}
</style>