<?php
require_once('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <title>User Flight Schedules</title>
    <style>
        /* Inline CSS for demonstration */

        body {
            margin: 0;
            overflow: hidden;
            background: linear-gradient(45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s infinite;
            font-family: 'Open Sans', sans-serif;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Additional styles for the content */
        header, nav, section, footer {
            padding: 15px;
        }

        header {
            color: #FFFFF0;
            text-align: center;
            border: none;
            font-weight: bold;
        }

        header h1 {
            font-size: 30px;
            margin-bottom: 5px;
            color: blue;
            font-weight: bold;
        }

        .logo-option {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-option img {
            width: 80px;
            margin-right: 10px;
        }

        .logo {
            font-size: 20px;
        }

        .logo-img:hover {
            transform: scale(1.1); 
            transition: transform 0.5s ease; 
        }

        .logo-img:not(:hover) {
            transform: scale(1);
            transition: transform 0.5s ease; 
        }

        .top-right-options {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            align-items: center;
        }

        .top-right-options a {
            text-decoration: none;
            color: #333; 
            margin-right: 10px;
            font-weight: bold;
            transition: color 0.3s ease, background-color 0.3s ease;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .top-right-options a:hover {
            color: #FFFFF0; 
            background-color: #333;
        }

        nav ul {
            list-style: none;
        }

        nav li {
            display: inline;
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #FFFFF0;
            margin-right: 10px;
            font-weight: bold;
            transition: color 0.3s ease, background-color 0.3s ease;
            padding: 5px 10px;
            border-radius: 5px;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        nav a:hover {
            color: #333;
            background-color: #FFFFF0;
        }

        .options-section {
            text-align: center;
            margin-top: 50px;
        }

        .options-section a {
            display: inline-block;
            text-decoration: none;
            background-color: #FFFFF0;
            color: #333;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .options-section a:hover {
            color: #FFFFF0;
            background-color: #e73c7e;
        }

        .flight-table {
            background-color: rgba(255, 255, 255, 0.899);
            border-radius: 10px;
            padding: 20px;
            margin-top: 2px;
            max-height: 500px; 
            overflow: auto;
            border-collapse: collapse; 
            width: 97%; 
        }

        .flight-table td {
            border: 1px solid #333;
            padding: 10px;
        }

        .flight-table h2 {
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.09);
            margin-bottom: 20px;
        }

        .flight-details {
            margin-bottom: 20px;
        }

        .flight-details p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }

        footer {
            background-color: #333;
            color: #FFFFF0;
            text-align: center;
        }
    </style>
    <script>
        // Javascript
    </script>
</head>
<body>
    

    <div class="top-right-options">
        <a href="SignOut.php">Sign Out</a>
        <a href="#"><?php
        
                if (isset($_SESSION['USER'])) {
                    echo "Welcome, " . $_SESSION['USER'] . "!";
                } else {
                    echo "You are not logged in.";
                }
            ?>
            </a>
    </div>
    <header>
        <div class="logo-option">
            <a href="https://www.cristianoronaldo.com/brands"><img src="cr7logo.png" alt="Logo" class="logo-img"></a>
            <div class="logo">CR7 Airlines</div>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
    <section class="content">
        <div class="flight-table">
            <h2>Flight Schedules</h2>
<?php
$query = "SELECT * FROM bookings WHERE username = '{$_SESSION['USER']}'";
$result = mysqli_query($conn, $query);

echo "<table>";

while ($row = mysqli_fetch_assoc($result)) {
    $flight_no = $row['flight_no'];
    
    $flight_query = "SELECT * FROM flight_details WHERE flight_no = '$flight_no'";
    $flight_result = mysqli_query($conn, $flight_query);
    
    if ($flight_row = mysqli_fetch_assoc($flight_result)) {
        echo "<tr><td colspan='11'><hr></td></tr>";
        echo "<tr class='flight-details'>";
        echo "<td><b>Flight Number:</b><br>" . $flight_row['flight_no'] . "</td>";
        echo "<td><b>Aircraft ID:</b><br>" . $flight_row['aircraft_id'] . "</td>";
        echo "<td><b>Arrival City:</b><br>" . $flight_row['arrival_city'] . "</td>";
        echo "<td><b>Arrival Date-Time:</b><br>" . $flight_row['arrival_datetime'] . "</td>";
        echo "<td><b>Departure City:</b><br>" . $flight_row['departure_city'] . "</td>";
        echo "<td><b>Departure Date-Time:</b><br>" . $flight_row['departure_datetime'] . "</td>";
        echo "<td><b>Economy Seats:</b><br>" . $flight_row['eco_seats'] . "</td>";
        echo "<td><b>Economy Price:</b><br>$" . $flight_row['eco_price'] . "</td>";
        echo "<td><b>Business Seats:</b><br>" . $flight_row['bus_seats'] . "</td>";
        echo "<td><b>Business Price:</b><br>$" . $flight_row['bus_price'] . "</td>";
        echo "</tr>";
        
        echo "<tr class='booking-details'>";
        echo "<td colspan='11'><b>Your Booking Details:</b><br>";
        echo "<b>Ticket ID:</b> " . $row['ticket_id'] . " | ";
        echo "<b>Ticket Type:</b> " . $row['ticket_type'] . " | ";
        echo "<b>Passenger Name:</b> " . $row['name'] . " | ";
        echo "<b>Payment:</b> $" . $row['payment'] . "</td>";
        echo "</tr>";
    }
}

echo "</table>";
mysqli_close($conn);
?>  
        </div>
    </section>

    <footer style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #333; color: #FFFFF0; text-align: center; padding: 10px;">
        <p>&copy; <?php echo date("Y"); ?> CR7 Airlines</p>
    </footer>
</body>
</html>