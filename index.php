<?php
	session_start();
	
	//unset($_SESSION["cartCount"]);
	unset($_SESSION["cart"]);
	unset($_SESSION["searchquery"]);

	session_destroy();
?>
<!-- Figure 1:  -->
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
    <title>Welcome to Best Book Buy Online Bookstore!</title>
</head>
<body>
	<div class="container p-4">
		<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-12">
				<div class="card shadow">
					<div class="card-header bg-dark text-white h1 p-4 text-center">Best Book Buy (3-B.com)</div>
					<div class="card-body ">
						<h3 class="text-center">Online Bookstore</h3>
						<div class="row justify-content-center">
							<div class="col-xl-9 col-lg-12 justify-content-center">
								<button class="btn btn-lg btn-secondary my-2 w-100" onclick="document.location.href='screen2.php'">Search Only</button><br>
								<button class="btn btn-lg btn-secondary my-2 w-100" onclick="document.location.href='customer_registration.php'">New Customer</button><br>
								<button class="btn btn-lg btn-secondary my-2 w-100" onclick="document.location.href='user_login.php'">Returning Customer</button><br>
								<button class="btn btn-lg btn-secondary my-2 w-100" onclick="document.location.href='admin_login.php'">Administrator</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>