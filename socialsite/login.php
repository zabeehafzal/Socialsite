<?php
include('db.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully!";
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT password, user_id, profile_picture FROM user WHERE username = '" . $username . "'";
    $result = mysqli_query($conn, $sql);

    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];
    $user_id = $row['user_id'];
    $profile = $row['profile_picture'];

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Password is correct, log the user in
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['profile_picture'] = $profile;

        // Redirect to the index page with the user_id parameter
        header("Location: index.php?user_id=" . $user_id . "?username=" . $username . "?profile_picture=" . $profile);
        exit();
    } else {
        // Password is incorrect, show an error message
        $error_message = "Invalid username or password.";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-4YDi9txV+Q8QnpBnB9pVYlfTbf5XDUBp5c6dILqxRPeD6A3YvUJlMjBRJ&" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
    <!-- Custom CSS -->
    <style>
         form{
            border:2px solid #20b2aa;
            border-radius: 10px;
            padding: 15px;
        }
        .btn-primary{
            background-color: #20b2aa;
        }
    </style>
</head>
<div class="container  align-items-center">
    <h1 class="mainHeading text-center profile">Welcome to Friend-o-Nautica </h1>
    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Log In</button>

        <?php
        if (isset($error_message)) {
            echo "<p>$error_message</p>";
        }
        ?>
    </form>
</div>


</html>