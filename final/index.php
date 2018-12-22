<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>CIS5512 Final Project</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
	<div class="container">
<?php
    session_start();
    if (empty($_SESSION["RegState"]) || $_SESSION["RegState"] == 0) {
        
	    if(!empty($_SESSION["Error"]))
	        echo $_SESSION["Error"];
?>
        <form  class="col form-signin" method="post" action="php/login.php">
            <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">CIS5512 Final Project (**Enter group id**)</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            <div class="checkbox mb-3">
            <label>
          		<input type="checkbox" name="remember" value="remember-me"> Remember me
            </label>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block" type="button">Sign in</button>
            <a data-toggle="modal" href="#register">Register</a> | <a data-toggle="modal" href="#resetPassword">Forget?</a>
            <?php
                if(!empty($_SESSION["Message"])) {
            ?>
            	<div id="messageLogin" class="alert alert-info mt-2" role="alert"><?php echo $_SESSION["Message"]; ?></div>
            <?php 
                }
            ?>
        </form>
		<div class="modal fade" id="register" role="dialog">
			<div class="modal-dialog">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h4 class="modal-title">Register</h4>
                      	<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                		<form action="php/register.php" method="post" class="col form-signin">
                            <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                            <h1 class="h3 mb-3 font-weight-normal">CIS5512 Final Project Registration</h1>
                            <label for="inputFirstName" class="sr-only">First Name</label>
                            <input type="text" id="inputFirstName" name="inputFirstName" class="form-control" placeholder="First Name" required autofocus>
                            <label for="inputLastName" class="sr-only">Last Name</label>
                            <input type="text" id="inputLastName" name="inputLastName" class="form-control" placeholder="Last Name" required>
                            <label for="inputEmail" class="sr-only">Email address</label>
                            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            <button type="submit" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
                            
                		</form>
            		</div>
            		<div class="modal-footer">
                    </div>
        		</div>
    		</div>
		</div>
		
		<div class="modal fade" id="resetPassword" role="dialog">
			<div class="modal-dialog">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h4 class="modal-title">Reset Password</h4>
                      	<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                		<form action="php/resetPassword.php" method="post" class="col form-signin">
                		  <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                		  <h1 class="h3 mb-3 font-weight-normal">CIS5512 Final Project Reset Password</h1>
                		  <label for="inputEmail" class="sr-only">Registered Email address</label>
                		  <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Registered email address" required autofocus>
                		  <button type="submit" class="btn btn-lg btn-primary btn-block" type="submit">Authenticate</button>
                		  <div id="messageResetPassword" class="alert alert-info mt-2" role="alert"></div>
                		  <a href="php/clearAll.php"><button type="button" class="mt-2">Return</button></a>
                		</form>
            		</div>
            		<div class="modal-footer">
                    </div>
        		</div>
    		</div>
		</div>
<?php
	}
	if ($_SESSION["RegState"] == 1) { // after email is authenticated
?>
    		
<?php
	}
	if ($_SESSION["RegState"] == 2) { // after email is authenticated
?>
		<form action="php/setPassword.php" method="post" class="col form-signin">
		  <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
		  <h1 class="h3 mb-3 font-weight-normal">CIS5512 Final Project Set Password</h1>
		  <input type="hidden" id="inputEmail" class="form-control" value="<?php echo $_SESSION["inputEmail"]; ?>" name="email">
		  <label for="inputPassword" class="sr-only">Enter a password</label>
		  <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
		  <button type="submit" class="btn btn-lg btn-primary btn-block" type="submit">Set Password</button>
		  <?php
                if(!empty($_SESSION["Error"])) {
            ?>
            	<div id="messageLogin" class="alert alert-info mt-2" role="alert"><?php echo $_SESSION["Error"]; ?></div>
            <?php 
                }
            ?>
		  <a href="#"><button type="button" class="mt-2">Login</button></a>
		</form>
<?php
	}
?>
	</div>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>