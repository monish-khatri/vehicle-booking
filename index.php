<?php
session_start();
if ($_SESSION['user']){
    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Booking</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- Css for login and registration -->
    <link href="assets/css/index.css" rel="stylesheet">
    <!-- js for login and registration -->
    <script src="assets/js/index.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<style>
		body {
			padding-top: 90px;
		}
	</style>
</head>
<body>
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<h1>Vehicle Booking System</h1>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
                                <span class="error d-none invalid-credentials"></span>
								<form id="login-form" method="post" role="form" style="display: block;">
                                    <input type="hidden" name="action" value="login">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="username form-control" placeholder="Username" value="">
                                        <span class="error d-none"></span>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="password form-control" placeholder="Password">
                                        <span class="error d-none"></span>
									</div>
									<div class="form-group text-center">
										<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
										<label for="remember"> Remember Me</label>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="https://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" method="post" role="form" style="display: none;">
                                    <input type="hidden" name="action" value="register">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="username form-control" placeholder="Username" value="">
                                        <span class="error d-none"></span>
									</div>
									<div class="form-group">
										<input type="text" name="first_name" id="first_name" tabindex="1" class="first_name form-control" placeholder="First Name" value="">
                                        <span class="error d-none"></span>
                                    </div>
									<div class="form-group">
										<input type="text" name="last_name" id="last_name" tabindex="1" class="last_name form-control" placeholder="First Name" value="">
                                        <span class="error d-none"></span>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="password form-control" placeholder="Password">
                                        <span class="error d-none"></span>
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="confirm-password form-control" placeholder="Confirm Password">
                                        <span class="error d-none"></span>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>
</html>