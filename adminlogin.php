<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Admin Login</title>
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

        /* Additional styles */
        header, nav, section, footer {
            padding: 15px;
        }
        
        .login-container {
            width: 300px;
            margin: auto;
            margin-top: 100px;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 60px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            background-color: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid #FFFFF0;
            color: #FFFFF0;
        }

        .login-form button {
            background-color: #FFFFF0;
            color: #333;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #333;
            color: #FFFFF0;
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

        footer {
            background-color: #333;
            color: #FFFFF0;
            text-align: center;
        }

        input[type="text"]::placeholder {
            color: #FFFFF0;
        }

        input[type="password"]::placeholder {
            color: #FFFFF0;
        }


    </style>
</head>
<body>
    <header>
        <div class="logo-option">
            <a href="https://www.cristianoronaldo.com/brands"><img src="cr7logo.png" alt="Logo" class="logo-img"></a>
            <div class="logo">CR7 Airlines</div>
        </div>
    </header>
    <div class="login-container">
        <h2 style="color: #FFFFF0; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Admin Login</h2>
        <form class="login-form" method="post">
            <input type="text" name="username" placeholder="Username" required style="color: #FFFFF0;">
            <input type="password" name="password" placeholder="Password" required style="color: #FFFFF0;">
            <br><br>
            <button type="submit">Login</button>
            <?php 
            require_once('db_connect.php');
            if(isset($_POST['username'])){
    
                $uname=$_POST['username'];
                $password=$_POST['password'];
    
                $sql="SELECT * FROM loginform WHERE USER='".$uname."' AND Pass='".$password."' LIMIT 1";
    
                $result=mysqli_query($conn, $sql);
    
                if(mysqli_num_rows($result)==1){
                    $_SESSION['USER'] = $uname;
                    header("Location: admindashboard.php");
                    exit();
                }else{
                    echo "<p style='color:#FFFFF0;'>Invalid Information</p>";
                    exit();
                }
        
            }
            ?>
        </form>
    </div>
    <footer style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #333; color: #FFFFF0; text-align: center; padding: 10px;">
        <p>&copy; <?php echo date("Y"); ?> CR7 Airlines</p>
    </footer>
</body>
</html>


