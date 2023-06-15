<?php
session_start();
include('db.php');
$userid = $_GET['user_id'];

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    // exit();
}

// If the user submitted a new post, process it
if (isset($_POST['submit'])) {
    $user_id = $userid;
    $title = $_POST['post_title'];
    $content = $_POST['post_text'];
    $image = $_FILES['image']['name'];
    $tags = $_POST['tags'];

    if (empty($title) || empty($content) || empty($tags)) {
        // $error_message = "Please fill in all title, content and tags fields.";
    }

    // If an image was uploaded, move it to the images directory and save the path in the database
    if ($image != "") {
        $target_dir = "images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $image = "noimage.jpg";
    }

    // Insert the new post into the database
    $sql = "INSERT INTO post (user_id, post_title, post_text, post_picture, tags) 
VALUES ('$user_id', '$title', '$content', '$image', '$tags')";

    if ($conn->query($sql) === TRUE) {
        // Display a success message
        $success_message = "Post created successfully. Click Back Button to go on main page.";
    } else {
        // Display an error message
        echo "Error: " . $sql;
    }

    // Close the database connection
    $conn->close();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
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
            <h2 class="mb-3 text-center profile">New Post</h2>
            <form method="post" enctype="multipart/form-data" class="form">
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control" id="title" name="post_title">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content:</label>
                    <textarea class="form-control" id="content" name="post_text"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="col-md-4">
                    <label for="tags" class="form-label">Tags:</label>
                    <input type="text" class="form-control" id="tags" name="tags">

                </div>

                <button type="submit" name="submit" class="btn btn-primary mt-3">Create Post</button>
                <a href="index.php" class="btn btn-secondary mt-3 ms-3">Back to Home</a>




        </div>

        <?php
        if (isset($success_message)) {
            echo "<p class='mt-3 profile'>$success_message</p>";
        }
        ?>
        </form>
    </div>
</div>
</div>

</form>
<script>
    const form = document.querySelector('form');
    const titleInput = document.querySelector('#title');
    const contentInput = document.querySelector('#content');

    form.addEventListener('submit', (event) => {
        if (titleInput.value.trim() === '' || contentInput.value.trim() === '') {
            event.preventDefault();
            alert('Please fill in all title and content fields.');
        }
    });


</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</html>