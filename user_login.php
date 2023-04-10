<?php

require_once 'DB.php';
session_start();

$db = new DB();

$_SESSION["user_logged_in"] = array();

$error = false;

if(isset($_POST["login"]) && !empty($_POST["username"])) {
	$login = $_POST["login"];
	$username = $_POST["username"];
	$pin = (!empty($_POST["pin"])) ? $_POST["pin"] : 0;

	$query = "Select * from customer where username = '{$username}' and pin = {$pin}";
	$rows = $db->getQuery($query);

	if(isset($rows[0])) 
	{
		$_SESSION["user_logged_in"] = $rows[0];
		echo("<script type='text/javascript'> document.location.href='screen2.php'</script>");
	} else 
	{
		$error = true;
	}
}


?>
<!-- user login -->
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
	<title>User Login</title>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center p-5">
			<div class="col-xl-8 col-lg-12">
				<div class="card shadow bg-secondary-subtle">
					<div class="card-header h2 text-center bg-dark text-white"> User Login</div>
					<div class="card-body">
						<?php if($error) : ?>
							<div class="row">
								<div class="col"> 
									<div class="alert alert-danger" role="alert">User Login was not correct for: <?php echo($username) ?> </div> 
								</div>
							</div>
						<?php endif ?>
						<form action="" method="post" class="row g-3">
							<div class="col-md-6">
								<label for="Username" class="form-label">Username<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="username" placeholder="Enter Username" aria-label="Username">
							</div>
							<div class="col-md-6">
								<label for="Pin" class="form-label">Pin<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="pin" placeholder="Enter Pin" aria-label="Pin">
							</div>
							<div class="col">
								<div class="row">
									<div class="col d-flex justify-content-center border-top p-4">
										<button type="submit" class="btn btn-success m-2 px-4" name="login">Login</button>
										<button type="button" class="btn btn-secondary m-2" onclick="document.location.href='index.php'">Cancel Login</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
