<?php

require_once 'DB.php';

	session_start();

	$db = new DB();

	if(isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0)
	{
		$bookids = null;

		if(isset($_POST["removeid"])) {
			unset($_SESSION["cart"][array_search($_POST["removeid"],$_SESSION["cart"])]);
		}

		foreach($_SESSION["cart"] as $item)
		{
			$bookids .= ($bookids == null) ? "{$item}" : ",{$item}";
		}

		if($bookids != null)
		{
			$query = "SELECT * FROM books where id in ({$bookids})";
			$rows = $db->getQuery($query);
		}
	}
?>
<!-- shopping_cart -->
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
	<title>Shopping Cart - 3-B.com</title>
	<script>
	//remove from cart
	function del(isbn){
		window.location.href="shopping_cart.php?delIsbn="+ isbn;
	}
	</script>
</head>
<body>
	<div class="container p-4">
		<div class="row justify-content-center">
			<div class="col-xl-8 col-lg-12">
				<div class="card shadow">
					<div class="card-header bg-dark d-flex justify-content-between text-white p-3">
						<button type="button" class="btn btn-secondary" onclick="document.location.href='index.php'">Exit 3-B.com</button>
						<h2>Shopping Cart</h2>
						<button type="button" class="btn btn-warning" onclick="document.location.href='screen2.php'">New Search</button>
					</div>
					<div class="card-body">
						<?php
							if(isset($rows) && count($rows) > 0) {

								foreach($rows as $row)
								{
									echo "<div class='card-body border my-2'>"
										."<table class='w-100'>"
										."<thead><th></th><th>Book Description</th><th>Qty</th><th class='w-25 px-1'>Price</th></thead>"
										."<tbody>"
										."<tr>"
										."<td class='w-25'><form action='shopping_cart.php' method='post'><input type='text' name='removeid' value={$row["id"]} style='display:none;'><button type='submit' class='btn btn-danger btn-small' data-id={$row["id"]}>Remove Item</button></form></td>"
										."<td class='w-50'><span class='fw-bold'>{$row["title"]}</span> <br> <span class='fw-bold'>By</span> {$row["author"]} <br> <span class='fw-bold'>Publisher:</span> {$row["publisher"]} </td>"
										."<td class='w-25'><input type='text' value='1' class='w-50 item-qty'></td>"
										."<td class='w-25 px-1'>\$<span class='item-price'>{$row["price"]}</span></td>"
										."</tr>"
										."</tbody>"
										."</table>"
										."</div>";
								}

							} else {
								echo "<div class='alert alert-warning text-center' role='alert'>No Items Added to Cart!!</div>";
							}
						?>
					</div>
					<div class="card-footer d-flex justify-content-between p-3">
						<div>
							<button type="button" class="btn btn-warning px-3 recalculate-subtotal-btn">Recalculate Total</button>
							<button type="button" class="btn btn-success px-3" onclick="document.location.href='confirm_order.php'">Proceed To Checkout</button>
						</div>
						<div>
							<span class="fw-bold fs-5">SubTotal: $</span><span class="subtotal fs-5"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {

			calculatePrice();

			$('.recalculate-subtotal-btn').click(function() {
				calculatePrice();
			});

			function calculatePrice() 
			{
				total = 0;
				$('.item-price').each(function() {
					var bookprice = $(this).html();
					console.log(bookprice);
					var qty = $(this).parent().prev().children('.item-qty').val();
					console.log(qty);
					total += qty * bookprice;
				})
				$('.subtotal').html(total.toFixed(2));
			}
		})
	</script>
</body>
</html>
