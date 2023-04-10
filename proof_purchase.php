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
	$bookList = $_SESSION["books_list"];

	if(isset($_POST["new_creditcard"]))
	{
		$user["credit_card"] =				check_input($_POST["cctype"]);								
		$user["credit_card_number"] =		check_input($_POST["ccnumber"]);
		$user["credit_card_exp_date"] =		check_input($_POST["ccexpdate"]);

		$query = "Update customer SET credit_card = ?, credit_card_number = ?, credit_card_exp_date = ? WHERE id = ?";

		$stmt= $db->getPDO()->prepare($query);
		$stmt->execute([$user["credit_card"], $user["credit_card_number"], $user["credit_card_exp_date"], $user["id"]]);

		$_SESSION["user_logged_in"] = $user;
	}

	function getBookQtyPrice($item) {
		$book = json_decode($item);
		return $book->price * $book->qty;
	}

	$subtotal = number_format((float)array_sum(array_map('getBookQtyPrice',$bookList)), 2, '.', '');
	$shipping = number_format((float)5.00, 2, '.', '');
	$total = number_format((float)($subtotal + $shipping), 2, '.', '');

	$db->getPDO()->beginTransaction();

	$query = "INSERT INTO Purchase (Date, Time, Sub_total, Total, Customer_id) VALUES (now(), now(), ?, ?, ?)";

	$stmt = $db->getPDO()->prepare($query);
	$stmt->execute([$subtotal, $total, $user["id"]]);
	$order_num = $db->getPDO()->lastInsertId();

	foreach($bookList as $bookitem)
	{
		$book = json_decode($bookitem);
		$query = "INSERT into Purchased_Books (book_id, order_number, quantity) VALUES (?, ?, ?)";

		$stmt= $db->getPDO()->prepare($query);
		$stmt->execute([$book->id, $order_num, $book->qty]);
	}

	$db->getPDO()->commit();

	$query = "Select * from Purchase where order_number = {$order_num}";
	$purchased = $db->getQuery($query);
	
	$checkout_books = array();

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

	function check_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	unset($_SESSION["cart"]);
	unset($_SESSION["searchquery"]);
?>
<!-- Proof Purchase: -->
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
					<div class="card-header bg-dark text-white text-center h2">Proof of Purchase</div>
					<div class="card-body confirm-body">
						<div class="row p-3">
							<div class="col-6">
								<h5>Shipping Address:</h5>
								<p class="fs-5">
									<?= $user["firstname"] ?> <?= $user["lastname"] ?> <br>
									<?= $user["address"] ?> <br>
									<?= $user["city"] ?> <?= $user["state"] ?>, <?= $user["zip"] ?>
								</p>
							</div>
							<div class="col-6 bg-dark-subtle p-3 rounded-3 ">
								<h5>Purchased Info:</h5>
								<hr>
								<span class="fw-bold">Username:</span> <?= $user["username"] ?> <br>
								<span class="fw-bold">Date:</span> <?= $purchased[0]["Date"] ?> <br> 
								<span class="fw-bold">Time:</span> <?= $purchased[0]["Time"] ?> <br> 
								<span class="fw-bold">Card Info:</span> <?= $user["credit_card"] ?> <br> 
								<span class="fw-bold">Card Num:</span>  <?= $user["credit_card_number"] ?> <br> 
								<span class="fw-bold">Card Date:</span> <?= $user["credit_card_exp_date"] ?>
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
						<button type="button" class="btn btn-warning px-5" onclick="document.location.href='screen2.php'">New Search</button>
						<button type="button" class="btn btn-secondary px-5" onclick="document.location.href='index.php'">Exit 3-B.com</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>