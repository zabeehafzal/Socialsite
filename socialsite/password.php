<?php
include('db.php');


if (isset($_POST['submit'])) {
    // Retrieve the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the form data
    $errors = array();

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // If there are no validation errors, proceed with updating the password
    if (empty($errors)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update the password in the user table
        $sql = "UPDATE user SET password = '$hashedPassword' WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Password updated successfully
            $errmsg = "<p class='profile'>Password updated successfully.</p>";
        } else {
            // Error occurred while updating the password
            $errmsg = "<p class='profile'>Error updating password: </p>" . mysqli_error($conn);
        }
    } else {
        // Display the validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}


?>


<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css">

    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: whitesmoke;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #055a11;
        }

        h2 {
            text-align: center;
            color: white;
        }

        label,
        input {
            display: block;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Password Reset</h2>
        <form action="#" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Reset Password" name="submit">

        </form>

        <button class="btn btn-primary"><a href="update_user.php">Back to Profile</a></button>
        <br>
        <p>
            <?php
            if(@$result){
            echo  $errmsg;
        }
            ?>

        </p>
    </div>
</body>

</html>