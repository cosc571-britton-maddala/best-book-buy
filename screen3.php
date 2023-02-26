<!-- Figure 3: -->
<?php

require_once 'DB.php';

	$db = new DB();

	if(isset($_GET["searchfor"]))
	{
		$rows = $db->getQuery("SELECT * FROM books");
	}	
?>
<html>

<head>
	<title> Search Result - 3-B.com </title>
	<script>
		//redirect to reviews page
		function review(isbn, title, id, auth) {
			window.location.href = "screen4.php?isbn=" + isbn + "&title=" + title + "&id=" + id + "&auth=" + auth;
		}
		//add to cart
		function cart(isbn, searchfor, searchon, category) {
			window.location.href = "screen3.php?cartisbn=" + isbn + "&searchfor=" + searchfor + "&searchon=" + searchon + "&category=" + category;
		}
	</script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
	<div class="container p-2">
		<div class="row ">
			<div class="col ">
				<div class="card">
					<div class="card-header d-flex justify-content-between p-3 bg-dark">
						<div>
							<button type="button" class="btn btn-primary">
								Your Shopping Cart has <span class="badge text-bg-secondary">0</span> items
							</button>
						</div>
						<div>
							<h3 class="text-white">Book Buy Search Results</h3>
						</div>
						<div>
							<form action="shopping_cart.php" method="post">
								<input type="submit" class="btn btn-light" value="Manage Shopping Cart">
							</form>
						</div>
					</div>
					<div class="card-body p-0 m-0">
						<table class="table table-light table-hover mb-0">
							<thead>
								<th></th>
								<th>Title</th>
								<th>Author</th>
								<th>Publisher</th>
								<th>ISBN</th>
								<th>Price</th>
							</thead>
							<tbody>
								<?php
									foreach($rows as $book) {
										
										echo "<tr>"
											."<td>"
												. "<button name='btnCart' class='btn btn-sm btn-success' id='btnCart' onClick='cart(&#39;{$book["isbn"]}&#39;, &#39;&#39;, &#39;Array&#39;, &#39;all&#39;)'>Add to Cart</button>"
												. "&nbsp;&nbsp;"
												. "<button name='review' class='btn btn-sm btn-warning' id='review' onClick='review(&#39;{$book["isbn"]}&#39;, &#39;{$book["title"]}&#39;,{$book["id"]},&#39;{$book["author"]}&#39;)'>Reviews</button>"
											."</td>"
											."<td>{$book["title"]}</td>"
											."<td>{$book["author"]}</td>"
											."<td>{$book["publisher"]}</td>"
											."<td>{$book["isbn"]}</td>"
											."<td>&#36;{$book["price"]}</td>"
											."</tr>";
									}
								?>	
							</tbody>
						</table>
					</div>
					<div class="card-footer p-3 d-flex justify-content-evenly">
						<div>
							<form action="confirm_order.php" method="get">
								<input type="submit" class="btn btn-secondary" value="Proceed To Checkout" id="checkout" name="checkout">
							</form>
						</div>
						<div>
							<form action="screen2.php" method="post">
								<input type="submit" class="btn btn-secondary" value="New Search">
							</form>							
						</div>
						<div>
							<form action="index.php" method="post">
								<input type="submit" class="btn btn-secondary" name="exit" value="EXIT 3-B.com">
							</form>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>