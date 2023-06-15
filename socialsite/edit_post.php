<?php
session_start();
include('db.php');
$userid = $_GET['user_id'];

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Retrieve the post data from the database
$post_id = intval($_GET['post_id']);
$sql = "SELECT * FROM post WHERE post_id = '$post_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Populate form fields with retrieved data
$title = $row['post_title'];
$content = $row['post_text'];
$image = $row['post_picture'];
$tags = $row['tags'];
$success_message = NULL;
// If the user submitted an updated post, process it
if (isset($_POST['submit'])) {
    $title = $_POST['post_title'];
    $content = $_POST['post_text'];
    $image = $_FILES['image']['name'];
    $tags = $_POST['tags'];

    if (empty($title) || empty($content) || empty($tags)) {
        // $error_message = "Please fill in all title, content, and tags fields.";
    }

    // If an image was uploaded, move it to the images directory and save the path in the database
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image = basename($_FILES['image']['name']);
    } else {
        $image = $row['post_picture'];
    }


    // Update the post in the database
    $sql = "UPDATE post SET post_title='$title', post_text='$content', post_picture='$image', tags='$tags' WHERE post_id='$post_id'";

    if ($conn->query($sql) === TRUE) {
        // Display a success message
        $success_message = "Post updated successfully. Click the Back Button to go back to the main page.";
    } else {
        // Display an error message
        echo "Error updating post: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<html lang="en">

<head>
    <!-- Head content goes here -->
</head>

<body>


    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Post</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./styles/style.css">

    </head>

    <div class="container my-5">
        <div class="row justify-content-center">
           <?php
           if($success_message != NULL){

            ?>
<center><span style="color:green;background-color:white;padding-left:30px;padding-right:30px;padding:5px;">
<?php echo $success_message; ?>
</span></center> <br> <br>
            <?php
           }
           ?>
            <div class="col-lg-8">
                <h2 class="mb-3 text-center profile">Edit Post</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" class="form-control" id="title" name="post_title"
                            value="<?php echo isset($title) ? $title : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea class="form-control" id="content"
                            name="post_text"><?php echo isset($content) ? $content : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="col-md-4">
                        <label for="tags" class="form-label">Tags:</label>
                        <input type="text" class="form-control" id="tags" name="tags"
                            value="<?php echo isset($tags) ? $tags : ''; ?>">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mt-3">Update
                        Post</button>
                    <a href="index.php" class="btn btn-secondary mt-3 ms-3">Back to Home</a>
                </form>
            </div>
        </div>
    </div>