<?php

require_once('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['username'];
    $pass = $_POST['password'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $add = $_POST['add'];
    $phone = $_POST['phone'];
    $formattedDate = date("Y-m-d", strtotime($dob));

    $sql = "SELECT * FROM registration WHERE USER ='$uname' OR email = '$email' or PASS = '$pass'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $num = mysqli_num_rows($result);
    if ($num > 0) {
        echo "User already exists";
        
    
        } else {
            $stmt = $conn->prepare("INSERT INTO registration(USER, Pass, name, dob, email, address, phone_no) VALUES(?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssi", $uname, $pass, $name, $formattedDate, $email, $add, $phone);
            $stmt->execute();
            // Successful signup
            header("Location: user_login.php");
            exit();
            $stmt->close();
        }
    }
}

?>
