<?php
session_start();

if (isset($_SESSION['username'])) {
	$user_id = $_SESSION['user_id'];
	$user_name = $_SESSION['username'];
	$profile = $_SESSION['profile_picture'];
} else {
	$user_id = " ";
	$user_name = " ";
	$profile = " ";
}
$user_id = 0;
if(isset($_SESSION["user_id"])){
	$user_id = $_SESSION["user_id"];
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>My Website</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		function myFunction(x) {
			x.classList.toggle("fa-thumbs-down");
		}
	</script>

</head>

<body>
	<header>
		<nav class="navbar navbar-expand-lg">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">Friend-o-Nautica</a>
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
		</nav>

	</header>
	<main class="container-fluid d-flex justify-content-center">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<section id="sidebar">
					<h2>Latest Posts</h2>

					<?php
					include('db.php');
					// Retrieve the post details from the database
					$sql = "SELECT * FROM post WHERE post_title IS NOT NULL ORDER BY post_date DESC";
					$result = mysqli_query($conn, $sql);


					// Loop through each row of the result set and print the post title for each post.
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<ul><li><h5><a href="full_post.php?post_id=' . $row['post_id'] . '">' . $row['post_title'] . '</a></h5></li></ul>';
					}
					?>

				</section>
				<div>
				</div>

				<div class="row justify-content-center">
					<div class="col-lg-12">
						<section id="posts">
							<h2>All Posts</h2>
							<?php
							// Display all posts from the database
							include('db.php');

							if (isset($_POST['like'])) {
								$post_id = @$_POST['like'];
								$user_id = @$_SESSION['user_id'];
								// Update the likes count in the database
								$query = "UPDATE post SET likes = likes + 1 WHERE post_id = $post_id";
								mysqli_query($conn, $query);

							}

							if (isset($_POST['delete'])) {
								$post_id = $_POST['delete'];
								$user_id = @$_SESSION['user_id'];

								// Validate that the user is signed in
								if ($user_id > 0) {
									// Delete the post from the database
									$query = "DELETE FROM post WHERE post_id = $post_id AND user_id = $user_id";
									mysqli_query($conn, $query);
								}
							}



							// Display posts and like button
							$sql = "SELECT post_id, user_id, post_title, post_text, post_picture, likes, comments, tags FROM `post` WHERE post_title IS NOT NULL ORDER BY post_date DESC";
							$result = mysqli_query($conn, $sql);
							$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
							foreach ($rows as $row) {
								?>

								<div class="card">
									<div class="card-body">
										<?php if (!empty($row['post_picture'])) { ?>
											<img src="images/<?php echo $row['post_picture']; ?>" class="card-img-top img-fluid"
												alt="Post image" style="max-width: 500px; max-height: 500px;">
										<?php } ?>
										<h5 class="card-title mt-2">
											<?php echo $row['post_title']; ?>
										</h5>
										<p class="card-text">
											<?php echo $row['post_text']; ?>
										</p>
										<br>
									</div>
								</div>


								<div class="row">
									<div class="col-md-3">
										<?php
										if (isset($_SESSION['user_id'])) {
											echo '<form method="post">';
											if ($user_id == $_SESSION['user_id']) {
												echo '<button type="submit" class="like btn-sm" name="like" value="' . $row['post_id'] . '"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> (' . $row['likes'] . ')</button>';
											} else {
												echo '<button type="submit" class="like btn-sm" disabled name="like" value="' . $row['post_id'] . '"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> (' . $row['likes'] . ')</button>';
											}
											echo '</form>';
										} else {
											echo '<button type="button" class="like btn-sm" disabled><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> (' . $row['likes'] . ')</button>';
										}
										?>

									</div>

									<div class="col-md-3">
									<?php
										$post_id = $row['post_id'];
										$query1 = "SELECT COUNT(*) AS total_comments FROM comment WHERE post_id = '$post_id'";
										$result1 = mysqli_query($conn, $query1);
										// Fetch the result
										$row_count = mysqli_fetch_assoc($result1);
										?>

										<a class="like btn-sm" href="full_post.php?post_id=<?php echo $post_id; ?>">

										<i class="fa fa-commenting-o" aria-hidden="true"></i>
										<?php echo $row_count['total_comments']; ?>
										</a>
									</div>

									<div class="col-md-3">
										<?php
										$pst = intval($post_id);
										$delQ = "SELECT * from post where post_id = '$pst' and user_id = '$user_id'";
										$resQ = mysqli_query($conn, $delQ);
										if(mysqli_num_rows($resQ)>0){
											echo '<form method="post">';
											echo '<button type="submit" class="btn like btn-sm" name="delete" value="' . $row['post_id'] . '"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
											echo '</form>';
										}else{
											echo '<button type="button" class="like btn-sm" disabled><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
										}
										?>
									</div>
									<div class="col-md-3">
										<?php foreach (explode(',', $row['tags']) as $tag) { ?>
											<span class="badge same">
												<?php echo $tag; ?>
											</span>
										<?php } ?>
									</div>
									
									<div class="col-md-3">
										<!-- Edit Post -->
										<?php
										$post_id = $row["post_id"];
										$sql = "SELECT * FROM post WHERE  post_id = '$post_id' AND user_id = '$user_id'";
										$result = mysqli_query($conn, $sql);
										$post_id = $row['post_id'];
										if(mysqli_num_rows($result)>0){
											while ($row = mysqli_fetch_assoc($result)) {
													echo '<a href="edit_post.php?user_id=' . $user_id . '&post_id=' . $post_id . '" class="btn editpost btn-sm">Edit Post</a>';
												}
											}else{
												echo '<a href="edit_post.php?user_id=' . $user_id . '&post_id=' . $post_id . '" class="btn editpost btn-sm disabled" >Edit Post</a>';
											}

										?>

									</div>
									<form method="post" class="form">
										<input type="hidden" name="post_id">
										<div class="form-group">
											<label for="comment">Comment:</label>
											<?php
											// Add delete button with user_id validation
											if (@$user_id = $_SESSION['user_id']) {
												echo '<textarea name="comment" id="comment" class="form-control" required></textarea>';
												echo '<input type="hidden" name="post_id" value="'.$post_id.'">';
											} else {
												echo '<textarea name="comment" id="comment" class="form-control" required disabled></textarea>';

											}

											?>
										</div>
										<br>

										<button type="submit" name="submit" value="submit" class="btn form">Submit</button>
									</form>
								</div>
							<?php } ?>
							<?php
									
									if (isset($_POST['submit'])) {
										$comment = $_POST['comment'];
										$post_id = intval($_POST['post_id']);
										$user_id = intval($_SESSION['user_id']);
										$comment_date = date('Y-m-d H:i:s'); // assuming comment_date is current date time
										$insert_query = "INSERT INTO comment (`user_id`,`post_id`, `comment_text`, `comment_date`) VALUES ('$user_id', '$post_id', '$comment', '$comment_date')";
										mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
									}
									?>

							<div>
								
							</div>
						</section>
					</div>
				</div>

	</main>
	<script>
		function disableButton(form) {
			var btn = form.querySelector("button[type='submit']");
			btn.disabled = true;
			btn.innerHTML = "Liking...";
			return true;
		}
	</script>
	<footer>
		<p>All Rights Reserved. &copy; 2023 Friend-o-nautica</p>
	</footer>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
		crossorigin="anonymous"></script>

</body>

</html>