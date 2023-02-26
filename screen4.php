<?php

require_once 'DB.php';

	$db = new DB();

	if(isset($_GET["id"]))
	{
		$bookid = $_GET["id"];

		$rows = $db->getQuery("SELECT * FROM book_reviews where bookid = {$bookid}");
	}	
?>
<!-- screen 4: -->
<!DOCTYPE html>
<html>
	<head>
		<title>Book Reviews - 3-B.com</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	</head>
<body>
	<div class="container">
		<div class="row justify-content-center p-4">
			<div class="col-xl-8 col-lg-8 col-md-12">
				<div class="card">
					<div class="card-header text-bg-dark d-flex justify-content-between">
						<h4>Reviews For: <?= $_GET["title"] ?> (ISBN: <?= $_GET["isbn"] ?>) </h4>
						<h5><?php echo $_GET["auth"] ?></h5>	
					</div>
					<div class="card-body">
						<?php 
							if(count($rows) == 0) {
								echo "<div class='alert alert-warning' role='alert'>There are no reviews for this title!</div>";
							} else {
								foreach($rows as $review) {

									echo "<div class='card m-4'>"
											. "<div class='card-body'>"
												. "<figure>"
													. "<blockquote class='blockquote'>"
														. "<p>{$review["review"]}"
													. "</blockquote>"
													. "<figcaption class='blockquote-footer'>"
														. $review["created_by"]
													. "</figcaption>"
												. "</figure>"	
											. "</div>"
										 . "</div>";
								}
							} 
						?>
					</div>
					<div class="card-footer">
						<form action="screen2.php" method="post">
							<input type="submit" class="btn btn-primary" value="Done">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>				
</body>

</html>
