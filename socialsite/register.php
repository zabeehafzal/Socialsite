<?php
include('db.php');


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];

    $image_name = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_folder = "images/"; // folder to store images

    // move the uploaded image to the folder
    move_uploaded_file($image_temp, $image_folder . $image_name);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      
    // Insert the user information into the database
    $sql = "INSERT INTO user (username, password, email, first_name, last_name, profile_picture) 
            VALUES ('$username', '$hashed_password', '$email', '$firstname', '$lastname', '$image_name')";

    if (mysqli_query($conn, $sql)) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css">
    <style>
        h1{
            color:white;
        }
        a{
            color:#fff;
        }
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

<body>
    <div class="container my-5">
        <div class="row justify-content-center ">
            <div class="col-lg-8">
                <h1>Register New User</h1>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <label for="image">Upload Image:</label>
                    <input type="file" name="image" id="image" class="same"><br> <br>
                    <button type="submit" name="submit" class="btn btn-primary">Register</button> 
                    <button class="btn btn-primary"><a href="index.php">Home</a></button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>