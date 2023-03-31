<?php
	session_start();

	if(!isset($_SESSION["cart"])) {
		$_SESSION["cart"] = array();
	}

	unset($_SESSION["searchquery"]);
?>
<!-- Figure 2: -->
<!-- 
	COSC 471/571
	Britton_Maddala
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<title>SEARCH - 3-B.com</title>
</head>
<body>
	<div class="container p-4">
		<div class="row justify-content-center">
			<div class="col-xl-8 col-lg-12">
				<div class="card shadow">
					<div class="card-header bg-dark text-white">
						<h1 class="text-center">Search Books</h1>
					</div>
					<div class="card-body bg-secondary-subtle">
						<form id="bookSearch" action="screen3.php" method="post">
							<div class="row m-2 justify-content-evenly p-0">
								<div class="col-auto">
									<label for="searchkeyword" class="col-form-label my-2">Search For:</label>
								</div>
								<div class="col-xl-6 col-lg-12">
									<input type="text" id="searchkeyword" name="keywords" class="form-control my-2 keyword-search-input" aria-labelledby="searchKeywordInput">
								</div>
								<div class="col-auto ">
									<button type="button" class="btn btn-success my-2 px-5 w-100 search-books-btn">Search</button>
								</div>
							</div>
							<div class="row g-3 m-2">
								<div class="col-auto">
									<label for="searchin" class="col-form-label">Search In:</label>
								</div>
								<div class="col-xl-6 col-lg-12">
									<select class="form-select" multiple aria-label="multiple select example" name="searchin[]">
										<option value="anywhere" selected>Keyword anywhere</option>
										<option value="title">Title</option>
										<option value="author">Author</option>
										<option value="publisher">Publisher</option>
										<option value="isbn">ISBN</option>
									</select>
								</div> 
							</div>
							<div class="row g-3 m-2">
								<div class="col-auto">
									<label for="category" class="col-form-label">Category:</label>
								</div>
								<div class="col-xl-6 col-lg-12">
									<select class="form-select" aria-label="Default select example" name="category">
										<option value="all" selected>All Categories</option>
										<option value="Fantasy">Fantasy</option>
										<option value="Adventure">Adventure</option>
										<option value="Fiction">Fiction</option>
										<option value="Horror">Horror</option>
										<option value="Non Fiction">Non Fiction</option>
										<option value="Classic">Classic</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer p-3 d-flex justify-content-evenly">
						<button class="btn btn-primary" onclick="document.location.href='shopping_cart.php'">Manage Shopping Cart</button>
						<button class="btn btn-secondary" onclick="document.location.href='index.php'">EXIT 3-B.com</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		$(document).ready(function() { 

			$('.search-books-btn').click(function() {
				if($('.keyword-search-input').val() == '') {
					console.log('empty');
				} else {
					$("#bookSearch").submit();
				}
			})
		});
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
