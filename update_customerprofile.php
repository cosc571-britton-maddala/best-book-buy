<?php

require_once 'DB.php';
session_start();

	$db = new DB();

	$show_alert = false;

	if(!isset($_SESSION["user_logged_in"]))
	{
		echo("<script type='text/javascript'> document.location.href='customer_registration.php'</script>");
		return;
	}

	$user = $_SESSION["user_logged_in"];

	$username = 	$user["username"];
	$pin =			$user["pin"];
	$firstname = 	$user["firstname"];
	$lastname =		$user["lastname"];
	$address = 		$user["address"];
	$city =			$user["city"];
	$state =		$user["state"];
	$zip =			$user["zip"];
	$cctype =		$user["credit_card"];
	$ccnumber =		$user["credit_card_number"];
	$ccexpdate =	$user["credit_card_exp_date"];


	if (isset($_POST["update-user"])) {
		
		$pin =			check_input($_POST["pin"]);
		$firstname = 	check_input($_POST["firstname"]);
		$lastname =		check_input($_POST["lastname"]);
		$address = 		check_input($_POST["address"]);
		$city =			check_input($_POST["city"]);
		$state =		check_input($_POST["state"]);
		$zip =			check_input($_POST["zip"]);
		$cctype =		check_input($_POST["cctype"]);
		$ccnumber =		check_input($_POST["ccnumber"]);
		$ccexpdate =	check_input($_POST["ccexpdate"]);

		$query = "Update customer SET pin = ?,firstname = ?,lastname = ?,address = ?,city = ?,state = ?,zip = ?, credit_card = ?, credit_card_number = ?, credit_card_exp_date = ? WHERE id = ?";

		$stmt= $db->getPDO()->prepare($query);
		$stmt->execute([$pin, $firstname, $lastname, $address, $city, $state, $zip, $cctype, $ccnumber, $ccexpdate, $user["id"]]);

		$show_alert = true;

		//success than put user in session
		$query = "Select * from customer where username = '{$username}' and pin = {$pin}";
		$rows = $db->getQuery($query);
		$_SESSION["user_logged_in"] = $rows[0];
	}

	function check_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

?>
<!-- Update Customer Registration Figure 6: -->
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
	<title> UPDATE CUSTOMER PROFILE </title>
</head>
<body>

	<div class="container p-4">
		<div class="row justify-content-center">
			<div class="col-xl-8 col-lg-12 col-md-12">
				<div class="card shadow">
					<div class="card-header p-3 bg-dark text-white text-center">
						<h2>Update Customer Registration</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col msg-col">
								<?php if($show_alert) : ?>
									<div class='alert alert-success' role='alert'>Customer Registration Updated!!!</div>
									<script> 
										setTimeout(() => {
											window.location.href='confirm_order.php';
										}, "1000");
									</script>
								<?php endif; ?>
							</div>
						</div>
						<form id="cus-form" class="row g-3" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" >
							<div class="col-md-6">
								<label for="Username" class="form-label">Username<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="username" placeholder="Enter Username" aria-label="Username" disabled value="<?php echo($username); ?>">
								<input type="text" class="d-none" name="update-user" value="1">
							</div>
							<div class="col-md-3">
								<label for="Pin" class="form-label">Pin<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="pin" placeholder="Enter Pin" aria-label="Pin" value="<?php echo($pin); ?>">
							</div>
							<div class="col-md-3">
								<label for="Retype Pin" class="form-label">Retype Pin<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="retype-pin" placeholder="Retype Pin" aria-label="Retype Pin" value="<?php echo($pin); ?>">
							</div>
							<div class="col-md-6">
								<label for="First Name" class="form-label">First Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="firstname" placeholder="Enter First Name" aria-label="First Name" value="<?php echo($firstname); ?>">
							</div>
							<div class="col-md-6">
								<label for="Last Name" class="form-label">Last Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="lastname" placeholder="Enter Last Name" aria-label="Last Name" value="<?php echo($lastname); ?>">
							</div>
							<div class="col-md-12">
								<label for="Address" class="form-label">Address<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="address" placeholder="Enter Address" aria-label="Address" value="<?php echo($address); ?>">
							</div>
							<div class="col-md-6">
								<label for="City" class="form-label">City<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="city" placeholder="Enter City" aria-label="City" value="<?php echo($city); ?>">
							</div>
							<div class="col-md-3">
								<label for="State" class="form-label">State<span class="text-danger">*</span></label>
								<select class="form-select" aria-label="State" name="state">
									<option>Select State</option>
									<option value="MI" <?= $state == 'MI' ? ' selected="selected"' : '';?>>Michigan</option>
									<option value="TN" <?= $state == 'TN' ? ' selected="selected"' : '';?>>Tennessee</option>
									<option value="CA" <?= $state == 'CA' ? ' selected="selected"' : '';?>>California</option>
								</select>
							</div>
							<div class="col-md-3">
								<label for="Zip" class="form-label">Zip<span class="text-danger">*</span></label>
								<input type="number" class="form-control" name="zip" placeholder="Enter Zip" aria-label="Zip" value="<?php echo($zip); ?>">
							</div>
							<div class="col-md-4">
								<label for="Credit Card" class="form-label">Credit Card<span class="text-danger">*</span></label>
								<select class="form-select" aria-label="Credit Card" name="cctype">
									<option >Select</option>
									<option value="Visa" <?= $cctype == 'Visa' ? ' selected="selected"' : '';?>>Visa</option>
									<option value="Master" <?= $cctype == 'Master' ? ' selected="selected"' : '';?>>Master</option>
									<option value="Discover" <?= $cctype == 'Discover' ? ' selected="selected"' : '';?>>Discover</option>
									<option value="American Express" <?= $cctype == 'American Express' ? ' selected="selected"' : '';?>>American Express</option>
								</select>
							</div>
							<div class="col-md-5">
								<label for="Credit Card Number" class="form-label">Credit Card Number<span class="text-danger">*</span></label>
								<input type="number" class="form-control" name="ccnumber" placeholder="Enter Credit Card Number" aria-label="Credit Card Number" max="9999999999999999" value="<?php echo($ccnumber); ?>">
							</div>
							<div class="col-md-3">
								<label for="Exp Date" class="form-label">Exp Date<span class="text-danger">*</span></label>
								<input type="month" class="form-control" name="ccexpdate" placeholder="Enter Exp Date" aria-label="Exp Date" value="<?php echo($ccexpdate); ?>">
							</div>
						</form>
					</div>
					<div class="card-footer d-flex justify-content-between">
						<div>
							<input type="button" class="btn btn-success" onclick="submitRegistration()" id="register_submit" name="update_submit" value="Update">
						</div>
						<input type="button" class="btn btn-danger" onclick="window.location.href='confirm_order.php'" id="donotregister" name="donotregister" value="Cancel Update">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script>
		function submitRegistration() 
		{
			// clear Alert
			document.querySelector('.msg-col').innerHTML = "";

			// get all inputs & selects
			var inputs = document.querySelectorAll("#cus-form input,#cus-form select");

			try {
				
				// Loop through inputs
				Array.from(inputs).forEach(input => {
					if(input.value == "") {
						document.querySelector('.msg-col').innerHTML = "<div class='alert alert-danger' role='alert'>All Fields are Required!!!</div>";
						throw BreakException;
					}
				});

				// get pin numbers
				var pin1 = document.querySelector("[name='pin']").value;
				var pin2 = document.querySelector("[name='retype-pin']").value;

				if(pin1 !== pin2) {
					document.querySelector('.msg-col').innerHTML = "<div class='alert alert-danger' role='alert'>PIN Number Must Be the Same!!</div>";
					throw BreakException;
				}

			} catch(e) {
				return;
			}

			// submit form
			document.getElementById("cus-form").submit();
		}
	</script>
</body>
</html>