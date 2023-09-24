<?php
require_once('db_connect.php');

$success = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flight_no = $_POST["flight_no"];
    $passport_no = $_POST["passport_no"]; // Added Passport Number
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $ticket_type = $_POST["ticket_type"];
    $payment = $_POST["payment"];

    // Validate flight number
    $flight_query = "SELECT * FROM flight_details WHERE flight_no = '$flight_no'";
    $flight_result = mysqli_query($conn, $flight_query);

    if (mysqli_num_rows($flight_result) == 0) {
        $error_message = "Flight number $flight_no doesn't exist";
    } else {
        $flight_row = mysqli_fetch_assoc($flight_result);
        $flight_eco_seats = $flight_row['eco_seats'];
        $flight_eco_price = $flight_row['eco_price'];
        $flight_bus_seats = $flight_row['bus_seats'];
        $flight_bus_price = $flight_row['bus_price'];

        // Check if ticket type and payment match flight details
        if ($ticket_type == "children" && $payment != 0) {
            $error_message = "For children's ticket, payment should be 0";
        } elseif ($ticket_type == "economy" && ($payment != $flight_eco_price || $flight_eco_seats <= 0)) {
            $error_message = "Invalid Payment Given / Ticket Unavailable";
        } elseif ($ticket_type == "business" && ($payment != $flight_bus_price || $flight_bus_seats <= 0)) {
            $error_message = "Invalid Payment Given / Ticket Unavailable";
        } else {
            // Check if flight and passport combination already exists in bookings
            $existing_booking_query = "SELECT * FROM bookings WHERE flight_no = '$flight_no' AND passport_no = '$passport_no'";
            $existing_booking_result = mysqli_query($conn, $existing_booking_query);

            if (mysqli_num_rows($existing_booking_result) > 0) {
                $error_message = "This flight and passport combination is already booked";
            } else {
                // Subtract seats if booking is successful
                if ($ticket_type == "economy") {
                    $updated_eco_seats = $flight_eco_seats - 1;
                    $update_seats_query = "UPDATE flight_details SET eco_seats = '$updated_eco_seats' WHERE flight_no = '$flight_no'";
                    mysqli_query($conn, $update_seats_query);
                } elseif ($ticket_type == "business") {
                    $updated_bus_seats = $flight_bus_seats - 1;
                    $update_seats_query = "UPDATE flight_details SET bus_seats = '$updated_bus_seats' WHERE flight_no = '$flight_no'";
                    mysqli_query($conn, $update_seats_query);
                }

                // Insert booking data
                $insert_query = "INSERT INTO bookings (flight_no, passport_no, name, ticket_type, payment, email, phone, username) 
                                VALUES ('$flight_no', '$passport_no', '$name', '$ticket_type', '$payment', '$email', '$phone', '{$_SESSION['USER']}')";

                if (mysqli_query($conn, $insert_query)) {
                    $success = "Flight Successfully Booked";
                } else {
                    $error_message = "Booking failed. Please try again";
                }
            }
        }
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
    <title>Book a Ticket</title>
    <style>
        /* Your updated CSS styles here */
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

        .content {
            padding: 0px;
            text-align: center;
            border-radius: 10px;
        }

        .content h2 {
            color: #FFFFF0;
            margin-bottom: 20px;
        }

        .submit-button {
            background-color: #333;
            color: #FFFFF0;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.5s ease, color 0.5s ease;
        }

        .submit-button:hover {
            background: linear-gradient(45deg, #ee7752, #e73c7e);
            color: #FFFFF0;
        }

        .login-container {
            background-color: #FFFFF0;
            width: 550px;
            height: 350px;
            margin: auto;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            max-height: 400px;
            overflow-y: auto;
        }

        .login-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form button {
            background-color: #333;
            color: #FFFFF0;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.5s ease, color 0.5s ease;
        }

        .login-form button:hover {
            background: linear-gradient(45deg, #23a6d5, #23d5ab);
            color: #FFFFF0;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
            justify-content: center; /* Center the radio buttons horizontally */
        }

        .radio-label {
            display: flex;
            align-items: center;
        }

        .radio-label input[type="radio"] {
            margin-left: 3px;
        }


        footer {
            background-color: #333;
            color: #FFFFF0;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

</style>
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
            <a href="https://www.cristianoronaldo.com/brands">
                <img src="cr7logo.png" alt="Logo" class="logo-img">
            </a>
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
        <h2><u>Book Your Flight</u></h2>
    <div class="login-container">
      <?php
        if (isset($success)) {
            echo "<p style='color:#333;'>$success</p>";
        }


        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }

        ?>
    <br>
    <form method="post" action="" class="login-form">

        <label for="flight_no">Desired Flight Number:</label>
        <input type="number" name="flight_no" required><br>
        <label for="passport_no">Passport Number:</label>
        <input type="text" name="passport_no" required><br>
        <label for="name">Passenger Name:</label>
        <input type="text" name="name" required><br>
        <label for="email">Passenger Email:</label>
        <input type="email" name="email" required><br>
        <label for="phone">Passenger Phone:</label>
        <input type="text" name="phone" required><br>
        <br><hr><br>
        <label for="phone">Ticket Type:</label><br>
        <div class="radio-group">
            <label class="radio-label">
                <input type="radio" name="ticket_type" value="economy" required>
                Economy
            </label>
            <label class="radio-label">
                <input type="radio" name="ticket_type" value="business">
                Business
            </label>
            <label class="radio-label">
                <input type="radio" name="ticket_type" value="children">
                Children
            </label>
        </div><br><hr><br>

        <label for="payment">Payment:</label>
        <input type="number" name="payment" required><br>

        <button class="submit-button" type="submit">Book A Ticket</button>
      
    <br><br>
    </form>
    <form action="book_tickets2.php" method="get">
        <button type="submit" class="submit-button"><b>Go Back To Flight Searching</b></button>
    </form>
    </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> CR7 Airlines</p>
    </footer>
</body>
</html>
