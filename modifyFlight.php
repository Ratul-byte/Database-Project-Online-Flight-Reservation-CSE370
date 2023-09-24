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
    <title>Modify Flight | Admin</title>
    <style>
        /* Inline CSS for demonstration */

        body {
            margin: 0;
            overflow: hidden;
            background: linear-gradient(45deg, #BCC6CC, #98AFC7, #E8ADAA, #F2D4D7);
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
            background-image: url('addJet.jpg');
            background-size: cover;
            background-position: center;
            padding: 170px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
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
            background: linear-gradient(45deg, #E8ADAA, #98AFC7);
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
        <a href="#">
            <?php
        
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
            <li><a href="admindashboard.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
    <section class="content">
        <h2 style="color: #FFFFF0; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Modify Flight Schedule</h2>
        <form action="" method="post" style="background-color: rgba(255, 255, 255, 0.788); padding: 50px; border-radius: 10px; width: 400px;">
            <label for="flight_no" style="color: #333;"><b>Flight Number<b><br></label>
            <input type="text" id="flight_no" name="flight_no" required><br><br>
            <button type="submit" class="submit-button"><b>Modify Flight</b></button>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['flight_no'])) {
                        $flight_no = $_POST['flight_no'];
                        $query = "SELECT * FROM flight_details WHERE flight_no = '$flight_no'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $flight_data = mysqli_fetch_assoc($result);
                        } else {
                            echo "<br><br><b style='color:red'>Flight Number Does Not Exist.</b>";
                        }
                    }
                    if (isset($_POST['update_flight'])) {
                    // Handle form submission to update flight details in the database
                        if (isset($_POST['flight_no'])) {
                            $flight_no = $_POST['flight_no'];
                            $new_aircraft_id = $_POST['new_aircraft_id'];
                            $new_arrival_city = $_POST['new_arrival_city'];
                            $new_arrival_datetime = $_POST['new_arrival_datetime'];
                            $new_departure_city = $_POST['new_departure_city'];
                            $new_departure_datetime = $_POST['new_departure_datetime'];
                            $new_eco_seats = $_POST['new_eco_seats'];
                            $new_eco_price = $_POST['new_eco_price'];
                            $new_bus_seats = $_POST['new_bus_seats'];
                            $new_bus_price = $_POST['new_bus_price'];

                            // Update query
                            $update_query = "UPDATE flight_details SET 
                                            aircraft_id = '$new_aircraft_id',
                                            arrival_city = '$new_arrival_city',
                                            arrival_datetime = '$new_arrival_datetime',
                                            departure_city = '$new_departure_city',
                                            departure_datetime = '$new_departure_datetime',
                                            eco_seats = '$new_eco_seats',
                                            eco_price = '$new_eco_price',
                                            bus_seats = '$new_bus_seats',
                                            bus_price = '$new_bus_price'
                                            WHERE flight_no = '$flight_no'";
    
                            $update_result = mysqli_query($conn, $update_query);

                            if ($update_result) {
                                $success_message = "Flight details updated successfully.";
                            } else {
                                $error_message = "Error updating flight details: " . mysqli_error($conn);
                            }
                        } else {
                            $error_message = "Flight number is missing.";
                        }
                    }
                }
                ?>
        </form>
        <?php if (isset($flight_data)): ?>
        <form action="" method="post" style="background-color: rgba(255, 255, 255, 0.788); padding: 30px; border-radius: 10px; width: 400px; position: absolute; right: 50px; top: 250px; height: 50vh; overflow-y: auto;">

            <label for="flight_no"><b>Flight Number</b></label>
            <input type="text" id="flight_no" name="flight_no" value="<?php echo $flight_data['flight_no']; ?>" required><br><br>
            
            <label for="new_aircraft_id"><b>New Aircraft ID</b></label>
            <input type="text" id="new_aircraft_id" name="new_aircraft_id" min="2001" max="9999" value="<?php echo $flight_data['aircraft_id']; ?>" required><br><br>

            <label for="new_arrival_city"><b>New Arrival City</b></label>
            <input type="text" id="new_arrival_city" name="new_arrival_city" value="<?php echo $flight_data['arrival_city']; ?>" required><br><br>

            <label for="new_arrival_datetime"><b>New Arrival Date and Time</b></label>
            <input type="datetime-local" id="new_arrival_datetime" name="new_arrival_datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($flight_data['arrival_datetime'])); ?>" required><br><br>

            <label for="new_departure_city"><b>New Departure City</b></label>
            <input type="text" id="new_departure_city" name="new_departure_city" value="<?php echo $flight_data['departure_city']; ?>" required><br><br>

            <label for="new_departure_datetime"><b>New Departure Date and Time</b></label>
            <input type="datetime-local" id="new_departure_datetime" name="new_departure_datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($flight_data['departure_datetime'])); ?>" required><br><br>

            <label for="new_eco_seats"><b>New Economy Seats</b></label>
            <input type="number" id="new_eco_seats" name="new_eco_seats" min="0" max="400" value="<?php echo $flight_data['eco_seats']; ?>" required><br><br>

            <label for="new_eco_price"><b>New Economy Price</b></label>
            <input type="number" id="new_eco_price" name="new_eco_price" min="100" max="1000" value="<?php echo $flight_data['eco_price']; ?>" required><br><br>

            <label for="new_bus_seats"><b>New Business Seats</b></label>
            <input type="number" id="new_bus_seats" name="new_bus_seats" min="0" max="200" value="<?php echo $flight_data['bus_seats']; ?>" required><br><br>

            <label for="new_bus_price"><b>New Business Price</b></label>
            <input type="number" id="new_bus_price" name="new_bus_price" min="1000" max="10000" value="<?php echo $flight_data['bus_price']; ?>" required><br><br>

            <button type="submit" name="update_flight" class="submit-button"><b>Update Flight Details</b></button>
        </form>
        <?php elseif (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p style="color: black;"><?php echo $success_message; ?></p>
        <?php endif; ?>
        </section>

    </section>
    <footer style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #333; color: #FFFFF0; text-align: center; padding: 10px;">
    <p>&copy; <?php echo date("Y"); ?> CR7 Airlines</p>
    </footer>
</body>
</html>


