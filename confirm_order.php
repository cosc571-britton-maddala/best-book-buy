<?php
	require_once 'DB.php';
	session_start();

	$db = new DB();

	if(!isset($_SESSION["user_logged_in"])) 
	{
		echo("<script type='text/javascript'> document.location.href='customer_registration.php'</script>");
		return;
	}

	$user = $_SESSION["user_logged_in"];

	$bookList = array();
	$checkout_books = array();

	if(isset($_POST["books"]))
	{
		$bookList = $_POST["books"];
		$_SESSION["books_list"] = $_POST["books"];
	}

	if(isset($_SESSION["books_list"]))
	{
		$bookList = $_SESSION["books_list"];
	}

	foreach($bookList as $bookitem)
	{
		$book = json_decode($bookitem);
		$query = "SELECT * FROM books where id in ({$book->id})";
		$rows = $db->getQuery($query);

		$book->title = $rows[0]["title"];
		$book->author = $rows[0]["author"];
		$book->publisher = $rows[0]["publisher"];
		$book->price = $rows[0]["price"];
		$book->book_total = $book->price * $book->qty;

		array_push($checkout_books,$book);
	}

	$subtotal = (empty($checkout_books)) ? 0 : number_format((float)array_sum(array_column($checkout_books, 'book_total')), 2, '.', '');
	$shipping = number_format((float)5.00, 2, '.', '');
	$total = $subtotal + $shipping;	
	$total = number_format((float)$total, 2, '.', '');
?>
<!-- Confirm Order: -->
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
	<title> Confirm Order </title>
</head>
<body>
	<div class="container p-4">
		<div class="row justify-content-center">
			<div class="col-xl-9 col-lg-12">
				<div class="card shadow">
					<div class="card-header bg-dark text-white text-center h2">Confirm Your Order</div>
					<div class="card-body confirm-body">
						<div class="row p-2">
							<div class="col-6">
								<h5>Shipping Address:</h5>
								<p class="fs-5">
									<?= $user["firstname"] ?> <?= $user["lastname"] ?> <br>
									<?= $user["address"] ?> <br>
									<?= $user["city"] ?> <br>
									<?= $user["state"] ?>, <?= $user["zip"] ?>
								</p>
							</div>
							<div class="col-6 bg-dark-subtle p-3 rounded-3 ">
								<div class="row p-1">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="creditradio" checked value="existingcc">
										<label class="form-check-label" for="flexRadioDefault1">
											<h5>Use Credit Card on File:</h5>
											<p class="fs-6">
												<?= $user["credit_card"] ?> - <?= $user["credit_card_number"] ?> - <?= $user["credit_card_exp_date"] ?>
											</p>
										</label>
									</div>
								</div>
								<div class="row p-1">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="creditradio" value="newcc">
										<label class="form-check-label" for="flexRadioDefault1"> <h5>New Credit Card:</h5> </label>
										<form action="proof_purchase.php" id="newccform" method="post" class="row">
											<div class="col-md-6">
												<label for="Credit Card" class="form-label">Credit Card<span class="text-danger">*</span></label>
												<select class="form-select form-select-sm" aria-label="Credit Card" name="cctype">
													<option selected>Select</option>
													<option value="Visa">Visa</option>
													<option value="Master">Master</option>
													<option value="Discover">Discover</option>
													<option value="American Express">American Express</option>
												</select>
											</div>
											<div class="col-md-6">
												<label for="Exp Date" class="form-label">Exp Date<span class="text-danger">*</span></label>
												<input type="month" class="form-control form-control-sm expdate" name="ccexpdate" placeholder="Enter Exp Date" aria-label="Exp Date">
											</div>
											<div class="col">
												<label for="Credit Card Number" class="form-label">Credit Card Number<span class="text-danger">*</span></label>
												<input type="number" class="form-control form-control-sm" name="ccnumber" placeholder="Enter Credit Card Number" aria-label="Credit Card Number" max="9999999999999999">
												<input type="hidden" name="new_creditcard" value="1">
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="row p-3">
							<div class="col">
								<div class="card-body border">
									<div class="row">
										<div class="col-5 fw-bold">Title</div>
										<div class="col-2 fw-bold">Author</div>
										<div class="col-3 fw-bold">Publisher</div>
										<div class="col-1 fw-bold">Qty</div>
										<div class="col-1 fw-bold">Price</div>
									</div>
									<?php foreach($checkout_books as $buy): ?>
										<div class="row my-2">
											<div class="col-5"><?= $buy->title ?></div>
											<div class="col-2"><?= $buy->author ?></div>
											<div class="col-3"><?= $buy->publisher ?></div>
											<div class="col-1"><?= $buy->qty ?></div>
											<div class="col-1"><?= $buy->price ?></div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<div class="row p-3">
							<div class="col-6">
								<div class="card-body bg-warning-subtle">
									<h5>Shipping Note:</h5>
									<p>Please allow your order to be delivered within 5 business days. <br><br> Thank You!</p>
								</div>
							</div>
							<div class="col-6">
								<div class="card-body bg-info-subtle text-end h-100">
									<div class="m-2"><span class="fw-bold">SubTotal:</span> $<?= $subtotal ?> </div>
									<div class="m-2"><span class="fw-bold">Shipping & Handling: </span> $<?= $shipping ?></div>
									<hr>
									<div class="m-2"><span class="fw-bold">Total:</span> $<?= $total ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer d-flex justify-content-between">
						<button type="button" class="btn btn-success px-5 buy-btn">BUY!</button>
						<button type="button" class="btn btn-warning" onclick="document.location.href='update_customerprofile.php'">Update Customer Profile</button>
						<button type="button" class="btn btn-secondary" onclick="document.location.href='screen2.php'">Cancel Order</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
		$('.buy-btn').click(function() {

			var radio_btn = $('input[name="creditradio"]:checked').val();
			if(radio_btn == "newcc") {
				
				var inputs = document.querySelectorAll("#newccform input,#newccform select");
				var err = false;
				// Loop through inputs
				Array.from(inputs).forEach(input => {
					if(input.value == "") err = true;
				});

				if(err) {
					$('<div>').attr('class','row p-2').html($('<div>').attr('class','col').html("<div class='alert alert-danger' role='alert'>New Credit Card Fields are Required!!!</div>")).prependTo('.confirm-body');
				} else {
					$('#newccform').submit();
				}
			} else {
				document.location.href='proof_purchase.php';
			}

		});
	</script>
</body>
</html>