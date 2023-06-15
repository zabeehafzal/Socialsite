<?php
session_start();
include('db.php');

// Check if the user is logged in
// if(!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }$_SESSION['username']

// Retrieve the user's profile information from the database
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM user WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// If the user submitted an update to their profile information, process it
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Update the user's profile information in the database
    $stmt = $conn->prepare("UPDATE user SET first_name = ?, last_name = ?, email = ? WHERE username = ?");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();

    // Update the profile information in the session
    $_SESSION['first_name'] = $firstname;
    $_SESSION['last_name'] = $lastname;
    $_SESSION['email'] = $email;

    // Display a success message
    $success_message = "Profile updated successfully.";
}
?>

<head>
    <title>Update User Information</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css">
    <style>
        body{
            .form{
            border:2px solid #20b2aa;
            border-radius: 10px;
            padding: 15px;
        }
        .btn-primary{
            background-color: #20b2aa ;
        }
        }
    </style>

</head>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="text-center mb-4 profile">Profile Information</h2>
            <form method="post" class="form">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" class="form-control"
                        value="<?php echo htmlspecialchars($_SESSION['username']); ?>" >
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" id="firstname" class="form-control" name="firstname"
                        value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" id="lastname" class="form-control" name="lastname"
                        value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" class="form-control" name="email"
                        value="<?php echo htmlspecialchars($row['email']); ?>" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <a href="password.php" class="btn btn-danger">Reset Password</a>
                <a href="index.php" class="btn btn-secondary">Back to index page</a>
                <?php
                if (isset($success_message)) {
                    echo "<p>" . htmlspecialchars($success_message) . "</p>";
                }
                ?>
            </form>
        </div>
    </div>
</div>