<?php include('server.php') ?>

<!DOCTYPE html>
<html>

	<head>
		<title>Presence service application</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600">
		<link rel="stylesheet" href="style/style.css">
	</head>

	<body id="body" class="background">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-10 col-md-11 col-lg-6 mt-5 pt-5">
					<h2>Register</h2>
					<form class="form-example" method="post" action="register.php">
						<?php include('errors.php'); ?>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control username" name="username" value="<?php echo $username; ?>"/>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control email" name="email" value="<?php echo $email; ?>"/>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control password" name="password_1"/>
						</div>
						<div class="form-group">
							<label for="password">Confirm password</label>
							<input type="password" class="form-control password" name="password_2"/>
						</div>
							<button type="submit" class="btn btn-primary btn-customized" name="reg_user">Register</button>
						<p class="description">Already a member? <a href="login.php">Sign in</a></p>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>