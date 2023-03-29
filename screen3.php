<?php
	session_start();

	require_once 'DB.php';

	$db = new DB();

	if(isset($_POST["addid"])) {
		array_push($_SESSION["cart"],$_POST["addid"]);
	}

	$cartItems = (isset($_SESSION["cart"])) ? count($_SESSION["cart"]) : 0;

	if(isset($_POST["searchin"]))
	{	
		$keywords = explode(",", $_POST["keywords"]);

		$in = "Select id FROM books WHERE ";
		
		$in_where = null;
		
		$categoryClause = ($_POST["category"] == "all") ? "" : " Category = '" . $_POST["category"] . "' AND";

		foreach($_POST["searchin"] as $search) {
			if($search == "anywhere") 
			{
				foreach($keywords as $key)
				{
					$in_where .= (isset($in_where)) ? "OR " : "";
					$in_where .= "title like '%{$key}%' OR author like '%{$key}%' OR isbn like '%{$key}%' OR publisher like '%{$key}%'";
				}
				break;
			} 
			else if($search == "title") 
			{
				foreach($keywords as $key)
				{
					$in_where .= (isset($in_where)) ? "OR title like '%{$key}%' " : "title like '%{$key}%' ";
				}
			} 
			else if($search == "author")
			{
				foreach($keywords as $key)
				{
					$in_where .= (isset($in_where)) ? "OR author like '%{$key}%' " : "author like '%{$key}%' ";
				}
			}
			else if($search == "isbn")
			{
				foreach($keywords as $key)
				{
					$in_where .= (isset($in_where)) ? "OR isbn like '%{$key}%' " : "isbn like '%{$key}%' ";
				}
			}
			else if($search == "publisher")
			{
				foreach($keywords as $key)
				{
					$in_where .= (isset($in_where)) ? "OR publisher like '%{$key}%' " : "publisher like '%{$key}%' ";
				}
			}
		}

		// SELECT * FROM books WHERE Category = 'Classic' and id in (select id from books where title like '%067%' OR author like '%067%' OR isbn like '%067%' OR publisher like '%067%')

		$query = "SELECT * FROM books WHERE " . $categoryClause . " id IN (" . $in . $in_where . ")";

		$_SESSION["searchquery"] =  $query; 
		
		$rows = $db->getQuery($query);
	}
	
	if(isset($_SESSION["searchquery"]))
	{
		$rows = $db->getQuery($_SESSION["searchquery"]);
	}
?>
<!-- Figure 3: -->
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
	<title> Search Results - 3-B.com </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
	<div class="container p-4">
		<div class="row ">
			<div class="col ">
				<div class="card shadow">
					<div class="card-header d-flex justify-content-between p-3 bg-dark">
						<div>
							<button type="button" class="btn btn-warning">
								Your Shopping Cart has <span class="badge text-bg-secondary"><?php echo($cartItems); ?></span> items
							</button>
						</div>
						<div>
							<h2 class="text-white">Book Buy Search Results</h2>
						</div>
						<div>
							<input type="button" class="btn btn-light" value="Manage Shopping Cart" onclick="document.location.href='shopping_cart.php'">
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
									if(isset($rows))
									{
										foreach($rows as $book) 
										{
											$disabled = (in_array($book["id"],$_SESSION["cart"])) ? "disabled" : "" ;	
											echo "<tr>"
												."<td>"
													. "<form id='form-{$book["id"]}' action='screen3.php' method='post' class='p-0 m-0'> <input type='text' name='addid' value='{$book["id"]}' style='display:none;'> </form>"
													. "<button name='btnCart' class='btn btn-sm btn-success add-to-cart' data-id={$book["id"]} id='btnCart' onClick='cart(&#39;{$book["isbn"]}&#39;, &#39;&#39;, &#39;Array&#39;, &#39;all&#39;)' {$disabled}>Add to Cart</button>"
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
									}

									if(count($rows) == 0) {
										echo "<div class='alert alert-warning text-center' role='alert'>No Results for your Search!!</div>";
									}
								?>	
							</tbody>
						</table>
					</div>
					<div class="card-footer p-3 d-flex justify-content-evenly">
						<div>
							<input type="submit" class="btn btn-secondary" value="Proceed To Checkout" onclick="document.location.href='confirm_order.php'">
						</div>
						<div>
							<input type="button" class="btn btn-secondary" value="New Search" onclick="document.location.href='screen2.php'">
						</div>
						<div>
							<input type="button" class="btn btn-secondary" value="EXIT 3-B.com" onclick="document.location.href='index.php'">
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('.add-to-cart').click(function() {
				console.log($(this).data('id'));
				$("#form-" + $(this).data('id')).submit();
			});
		});

		//redirect to reviews page
		function review(isbn, title, id, auth) {
			window.location.href = "screen4.php?isbn=" + isbn + "&title=" + title + "&id=" + id + "&auth=" + auth;
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>