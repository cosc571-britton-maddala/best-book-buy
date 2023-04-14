
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
	                           <div class="form-group">
			                       <form action="manage_bookstorecatalog.php" method="post" id="catalog">
			
				                      <input type="submit" name="bookstore_catalog" id="bookstore_catalog" value="Manage Bookstore Catalog" style="width:400px;">
			                       </form>
                               </div>
							   <div class="form-group">
			                        <form action=" " method="post" id="orders">
				                      <input type="submit" name="place_orders" id="place_orders" value="Place Orders" style="width:400px;">
			
			                        </form>
                               </div>
							   <div class="form-group">	
			                        <form action="reports.php" method="post" id="reports">
				                       <input type="submit" name="gen_reports" id="gen_reports" value="Generate Reports" style="width:400px;">
			                        </form>
								</div>
								<div class="form-group">
			                        <form action="update_adminprofile.php" method="post" id="update">
				                       <input type="submit" name="update_profile" id="update_profile" value="Update Admin Profile" style="width:400px;">
			
			                        </form>
								</div>
		                         &nbsp
								 <div class="form-group">
			                        <form action="index.php" method="post" id="exit">
				                        <input type="submit" name="cancel" id="cancel" value="EXIT 3-B.com[Admin]" style="width:400px;">
			                        </form>
								</div>
			                </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>



</html>