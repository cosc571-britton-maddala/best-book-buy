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

		$query = "SELECT * FROM books where id in ({$bookids})";
		$rows = $db->getQuery($query);
	}
?>
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
					<div class="card-header bg-dark d-flex justify-content-between text-white">
						<button type="button" class="btn btn-success px-3" onclick="document.location.href='confirm_order.php'">Proceed To Checkout</button>
						<h2>Shopping Cart</h2>
						<button type="button" class="btn btn-warning px-3" onclick="document.location.href='screen2.php'">New Search</button>
						
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
										."<td class='w-25'><form action='shopping_cart.php' method='post'><input type='text' name='removeid' value={$row["id"]} style='display:none;'><button type='submit' class='btn btn-danger btn-small remove-item' data-id={$row["id"]}>Remove Item</button></form></td>"
										."<td class='w-50'><span class='fw-bold'>{$row["title"]}</span> <br> <span class='fw-bold'>By</span> {$row["author"]} <br> <span class='fw-bold'>Publisher:</span> {$row["publisher"]} </td>"
										."<td class='w-25'><input type='text' value='1' class='w-50'></td>"
										."<td class='w-25 px-1'>\${$row["price"]}</td>"
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
					<div class="card-footer">
						<button type="button" type="button" class="btn btn-secondary px-3" onclick="document.location.href='index.php'">Exit 3-B.com</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('.remove-item').click(function() {
				console.log($(this).data('id'));
			});
		});

	</script>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="center">
				<form id="checkout" action="confirm_order.php" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit" value="Proceed to Checkout">
				</form>
			</td>
			<td align="center">
				<form id="new_search" action="screen2.php" method="post">
					<input type="submit" name="search" id="search" value="New Search">
				</form>								
			</td>
			<td align="center">
				<form id="exit" action="index.php" method="post">
					<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
				</form>					
			</td>
		</tr>
		<tr>
				<form id="recalculate" name="recalculate" action="" method="post">
			<td  colspan="3">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th width='10%'>Remove</th><th width='60%'>Book Description</th><th width='10%'>Qty</th><th width='10%'>Price</th>
						<tr><td><button name='delete' id='delete' onClick='del("123441");return false;'>Delete Item</button></td><td>iuhdf</br><b>By</b> Avi Silberschatz</br><b>Publisher:</b> McGraw-Hill</td><td><input id='txt123441' name='txt123441' value='1' size='1' /></td><td>12.99</td></tr>					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">				
					<input type="submit" name="recalculate_payment" id="recalculate_payment" value="Recalculate Payment">
				</form>
			</td>
			<td align="center">
				&nbsp;
			</td>
			<td align="center">			
				Subtotal:  $12.99			</td>
		</tr>
	</table>
</body>
