<?php

require_once 'DB.php';

	$db = new DB();

	$show_alert = false;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = 	check_input($_POST["username"]);
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

		//echo("Data: {$username} {$pin} {$firstname} {$lastname} {$address} {$city} {$state} {$zip} {$cctype} {$ccnumber} {$ccexpdate}");

		$query = "INSERT INTO customer (username,pin,firstname,lastname,address,city,state,zip,credit_card,credit_card_number,credit_card_exp_date) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

		$stmt= $db->getPDO()->prepare($query);
		$stmt->execute([$username, $pin, $firstname, $lastname, $address, $city, $state, $zip, $cctype, $ccnumber, $ccexpdate]);

		$show_alert = true;
	}

	function check_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

?>

<html>
	<head>
	<title> CUSTOMER REGISTRATION </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	</head>
<body>

	<div class="container p-2">
		<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-6 col-md-12">
				<div class="card">
					<div class="card-header p-3 bg-dark text-white">
						<h3>New Customer Registration</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col msg-col">
								<?php if($show_alert) : ?>
									<div class='alert alert-success' role='alert'>Customer Registration Saved!!!</div>
								<?php endif; ?>
							</div>
						</div>
						<form id="cus-form" class="row g-3" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" >
							<div class="col-md-6">
								<label for="Username" class="form-label">Username<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="username" placeholder="Enter Username" aria-label="Username">
							</div>
							<div class="col-md-3">
								<label for="Pin" class="form-label">Pin<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="pin" placeholder="Enter Pin" aria-label="Pin">
							</div>
							<div class="col-md-3">
								<label for="Retype Pin" class="form-label">Retype Pin<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="retype-pin" placeholder="Retype Pin" aria-label="Retype Pin">
							</div>
							<div class="col-md-6">
								<label for="First Name" class="form-label">First Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="firstname" placeholder="Enter First Name" aria-label="First Name">
							</div>
							<div class="col-md-6">
								<label for="Last Name" class="form-label">Last Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="lastname" placeholder="Enter Last Name" aria-label="Last Name">
							</div>
							<div class="col-md-12">
								<label for="Address" class="form-label">Address<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="address" placeholder="Enter Address" aria-label="Address">
							</div>
							<div class="col-md-6">
								<label for="City" class="form-label">City<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="city" placeholder="Enter City" aria-label="City">
							</div>
							<div class="col-md-3">
								<label for="State" class="form-label">State<span class="text-danger">*</span></label>
								<select class="form-select form-select-sm" aria-label="State" name="state">
									<option selected>Select State</option>
									<option value="MI">Michigan</option>
									<option value="TN">Tennessee</option>
									<option value="CA">California</option>
								</select>
							</div>
							<div class="col-md-3">
								<label for="Zip" class="form-label">Zip<span class="text-danger">*</span></label>
								<input type="number" class="form-control form-control-sm" name="zip" placeholder="Enter Zip" aria-label="Zip">
							</div>
							<div class="col-md-4">
								<label for="Credit Card" class="form-label">Credit Card<span class="text-danger">*</span></label>
								<select class="form-select form-select-sm" aria-label="Credit Card" name="cctype">
									<option selected>Select</option>
									<option value="Visa">Visa</option>
									<option value="Master">Master</option>
									<option value="Discover">Discover</option>
									<option value="American Express">American Express</option>
								</select>
							</div>
							<div class="col-md-5">
								<label for="Credit Card Number" class="form-label">Credit Card Number<span class="text-danger">*</span></label>
								<input type="number" class="form-control form-control-sm" name="ccnumber" placeholder="Enter Credit Card Number" aria-label="Credit Card Number" max="9999999999999999">
							</div>
							<div class="col-md-3">
								<label for="Exp Date" class="form-label">Exp Date<span class="text-danger">*</span></label>
								<input type="number" class="form-control form-control-sm" name="ccexpdate" placeholder="Enter Exp Date" aria-label="Exp Date" max="9999">
							</div>
						</form>
					</div>
					<div class="card-footer">
						<input type="button" class="btn btn-success" onclick="submitRegistration()" id="register_submit" name="register_submit" value="Register">
						<input type="submit" class="btn btn-danger" onclick="window.location.href='index.php'" id="donotregister" name="donotregister" value="Cancel Register">
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
</HTML>