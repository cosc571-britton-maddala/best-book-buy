<?php
 require_once 'DB.php';
 $db = new DB();
 $query = "SELECT count(id) as Customercount FROM customer";
 $customercount = $db->getQuery($query);
 $query1 = "select t.titlecount,t.category from (SELECT count(id) as titlecount,category FROM books group by category) t order by t.titlecount desc";
 $titlecount = $db->getQuery($query1);
 $query2 = "SELECT round(avg(Purchase.Total),2) as averagetotal,monthname(Purchase.Date)as purchasemonth FROM Purchase GROUP BY monthname(Purchase.Date)";
 $averagetotal = $db->getQuery($query2);
 $query3 = "SELECT books.title,(SELECT count(id) FROM book_reviews WHERE book_reviews.bookid= books.id) as reviewcount FROM books";
 $reviewcount = $db->getQuery($query3);
?>
<!DOCTYPE HTML>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<title>ADMIN TASKS</title>
</head>
<body>
<div class="container p-4">
		<div class="row justify-content-center">
			<div class="col-xl-8 col-lg-12">
				<div class="card shadow">
					<div class="card-body ">
					    <h3 class="text-center">Online Bookstore</h3>
					    <div class="row justify-content-center">
							<div class="mx-auto col-10 col-md-8 col-lg-6 justify-content-center">
	                          <div class="row text-center"> 
								<h3> Customer Count </h3>
								<h4> <?= $customercount[0]["Customercount"] ?> </h4>
                              </div>
							  <div class="row text-center">
								<h3>Book title count by Category </h3> 
								<p class="text-center">
								<?php  foreach ($titlecount as $book):?>
                                    <?= $book["category"] ?> <?= $book["titlecount"] ?> <br>
                                   <?php  endforeach;?>
								</p>
                              </div>
							  <div class="row text-center">
								<h3>Average Sales by Month in Dollars</h3> 
								<p class="text-center">
								<?php  foreach ($averagetotal as $month):?>
                                    <?= $month["purchasemonth"] ?> $<?= $month["averagetotal"] ?> <br>
                                   <?php  endforeach;?>
								</p>
                              </div>
							  <div class="row text-center">
								<h3>Book review count by Title </h3> 
								<p class="text-center">
								<?php  foreach ($reviewcount as $book):?>
                                    <?= $book["title"] ?> <?= $book["reviewcount"] ?> <br>
                                   <?php  endforeach;?>
								</p>
                              </div>
			                </div>
						</div>
					</div>
					<div class="card-footer d-flex justify-content-center" >
					<button class="btn btn-secondary" onclick="document.location.href='index.php'">EXIT 3-B.com</button>	
</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>



</html>