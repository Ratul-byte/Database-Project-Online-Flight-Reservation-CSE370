<?php
require_once('db_connect.php');
$success = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_flight'])) {
        $flight_no = $_POST['flight_no'];
        $ticket_id = $_POST['ticket_id'];

        // Check if both flight_no and ticket_id are provided
        if (!empty($flight_no) && !empty($ticket_id)) {
            // Check if the provided flight_no and ticket_id match a booking
            $check_booking_query = "SELECT ticket_type FROM bookings WHERE username = '{$_SESSION['USER']}' 
                                    AND flight_no = '$flight_no' AND ticket_id = '$ticket_id'";
            $result = mysqli_query($conn, $check_booking_query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $ticket_type = $row['ticket_type'];

                // Delete the booking
                $delete_booking_query = "DELETE FROM bookings WHERE username = '{$_SESSION['USER']}' 
                                         AND flight_no = '$flight_no' AND ticket_id = '$ticket_id'";

                if (mysqli_query($conn, $delete_booking_query)) {
                    $success = "Booking Deleted Successfully.";

                    // Update seat availability based on ticket type
                    if ($ticket_type === 'economy') {
                        mysqli_query($conn, "UPDATE flight_details SET eco_seats = eco_seats + 1 WHERE flight_no = '$flight_no'");
                    } elseif ($ticket_type === 'business') {
                        mysqli_query($conn, "UPDATE flight_details SET bus_seats = bus_seats + 1 WHERE flight_no = '$flight_no'");
                    }
                } else {
                    $error_message = "Error deleting booking: " . mysqli_error($conn);
                }
            } else {
                $error_message = "No matching booking found for the provided flight number and ticket ID.";
            }
        } else {
            $error_message = "Please provide both Flight Number and Ticket ID for the delete operation.";
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Cancel Booked Flights</title>
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
            color: #333; /* Dark gray color */
            margin-right: 10px;
            font-weight: bold;
            transition: color 0.3s ease, background-color 0.3s ease;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .top-right-options a:hover {
            color: #FFFFF0; /* Change to text color */
            background-color: #333; /* Dark gray color */
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

        .content {
            background-image: url('cancel.jpg');
            background-size: cover;
            background-position: center;
            padding: 170px;
            color: #333;
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

        .submit-button {
            background-color: #333;
            color: #FFFFF0;
            border: none;
            padding: 11px 30px;
            border-radius: 5px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .submit-button:hover {
            background: linear-gradient(45deg, #23a6d5, #23d5ab);
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
    <h2 style="color: #FFFFF0; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Cancel Flight Bookings</h2>
    <form action="" method="post" style="background-color: rgba(255, 255, 255, 0.788); padding: 50px; border-radius: 10px; width: 400px;">
        <label for="flight_no" style="color: #333;"><b>Flight Number</b><br></label>
        <input type="text" id="flight_no" name="flight_no"><br><br>

        <label for="ticket_id" style="color: #333;"><b>Passenger Ticket ID</b><br></label>
        <input type="text" id="ticket_id" name="ticket_id"><br><br>
        
        <button type="submit" class="submit-button" name="delete_flight"><b>Cancel Booking(s)</b></button>
    <?php
    // Include the modified PHP code here
    
    // Display success message
    if (!empty($success)) {
        echo '<div style="color: green;">' . $success . '</div>';
    }

    // Display error message
    if (!empty($error_message)) {
        echo '<div style="color: red;">' . $error_message . '</div>';
    }
    ?>
    </form>

</section>

    <footer style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #333; color: #FFFFF0; text-align: center; padding: 10px;">
        <p>&copy; <?php echo date("Y"); ?> CR7 Airlines</p>
    </footer>
</body>
</html>


