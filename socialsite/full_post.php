<?php
session_start();
if (isset($_SESSION['username'])) {
    // User is logged in, show the content
    // echo "Welcome, " . $_SESSION['username'] . "!";
} else {
    header('Location:login.php');
}

$user_id = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Full Post</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Update User Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
    <nav class="navbar navbar-expand-lg">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php">Friend-o-Nautica</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
					aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<?php if (isset($_SESSION['username'])): ?>
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="index.php">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="update_user.php">Profile</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="post.php?user_id=<?php echo $user_id; ?>">Add Post</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Logout</a>
							</li>
							<li class="nav-item ms-auto">
								<img src="images/<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture"
									class="rounded-circle" width="30">
							</li>
						<?php else: ?>
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="index.php">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="login.php">Login</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="register.php">Register</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

    </header>

    <main>
        <div class="post container my-5">
            <?php
            // Connect to database
            include('db.php');
            $user_id = $_SESSION['user_id'];
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Get post details
            $post_id = $_GET['post_id'];
            $sql = "SELECT * FROM post WHERE post_id=$post_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo '<h2 class="profile">' . $row['post_title'] . '</h2>';
                echo '<p class="profile">' . $row['post_text'] . '</p>';
                echo '<img src="images/' . $row['post_picture'] . '" class="img-thumbnail" />';
            } else {
                echo 'Post not found.';
            }

            // Get comments for this post
            $sql = "SELECT comment_text FROM comment WHERE post_id = '$post_id' ";

            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result)) {
                echo '<h3 class="mt-5 profile">Comments</h3>';
                echo "<hr style='color:yellow; width:400px; height:2px'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    echo '<div class="comment my-4 profile">';
                    echo $row['comment_text'];
                    echo '</div>';
                    echo "<hr style='color:white; width:300px'>";
                    
                }
            } else {
                echo '<h3 class="mt-5">No comments yet</h3>';
            }


            ?>

        </div>

        <div class="comment-form container my-5">
            <?php
            if (isset($_POST['submit'])) {

                $comment = $_POST['comment'];
                $post_id = intval($_POST['post_id']);
                $user_id = intval($_SESSION['user_id']);
                $comment_date = date('Y-m-d H:i:s'); // assuming comment_date is current date time
                $insert_query = "INSERT INTO comment (`user_id`,`post_id`, `comment_text`, `comment_date`) VALUES ('$user_id', '$post_id', '$comment', '$comment_date')";
                mysqli_query($conn, $insert_query);
            }
            ?>
            <h3 class="text-center mb-4 profile">Add Comment</h3>
            <form method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea name="comment" id="comment" class="form-control" required></textarea>
                </div>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>



        </div>
    </main>

    <footer>
        <p>&copy; 2023 Social Media Website</p>
    </footer>
</body>

</html>