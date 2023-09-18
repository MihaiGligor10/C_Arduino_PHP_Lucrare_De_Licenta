
<?php
session_start();


if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
   
    header("Location: index.php");
    exit;
}

include("database_connect.php"); 

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}   

$result = mysqli_query($con,"SELECT * FROM ESPtable2");

while($row = mysqli_fetch_array($result)) {
            $user = $row['NAME'];	
            $pass = $row['PASS'];
}


if (isset($_POST['login'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo 'invalid username and/or password';
    

    if ($username == $user && $password == $pass) {
       
        $_SESSION['loggedIn'] = true;
        header("Location: index.php");
        exit;
    } else {
       
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333333;
        }
        .form {
            margin-bottom: 20px;
        }
        .form label {
            display: block;
            margin-bottom: 5px;
            color: #666666;
        }
        .form input[type="text"],
        .form input[type="password"] {
            width: 90%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .form input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post" action="login.php">
            <div class="form">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="form">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="form">
                <input type="submit" name="login" value="Log In">
            </div>
        </form>
    </div>
</body>
</html>