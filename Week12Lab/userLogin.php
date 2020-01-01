<?php
include 'header.php';
require_once('./dao/userAdminDAO.php');
session_start();
//if user logged in redirect to mailing_list page
if(isset($_SESSION['AdminID'])){
	if($_SESSION['AdminID']->isAuthenticated()){
		header('Location:mailing_list.php');
	}
}
//variables for error checking
$hasError = false;
$errorMessages = Array();

//checking for null values after post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if ($_POST['username'] == '') {
  $hasError = true;
  $errorMessages['username'] = "Please enter a username";
}

if ($_POST['password'] == '') {
  $hasError = true;
  $errorMessages['password'] = "Please enter a password";
}
}

		?>
	<!DOCTYPE html>
	<html>
	    <head>
	        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	        <title>Week 12</title>
	    </head>
	    <body>
	        <!-- MESSAGES -->

	        <form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	        <table>
	            <tr>
	                <td>Username:</td>
	                <td><input type="text" name="username" id="username"></td>
                  <?php
                  if (isset($errorMessages['username'])) {
                    echo '<td style="color:red;">'.$errorMessages["username"].'</td>';
                  }
                   ?>
	            </tr>
	            <tr>
	                <td>Password:</td>
	                <td><input type="password" name="password" id="password"></td>
                  <?php
                  if (isset($errorMessages['password'])) {
                    echo '<td style="color:red;">'.$errorMessages["password"].'</td>';
                  }
                   ?>
	            </tr>
	            <tr>
	                <td><input type="submit" name="submit" id="submit" value="Login"></td>
	                <td><input type="reset" name="reset" id="reset" value="Reset"></td>
	            </tr>
	        </table>

	        </form>
	    </body>
	</html>
	<?php
  if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']) && $hasError == false){
  				$userAdmindao = new userAdminDAO();

          //protection against sql injection
  				$username = strip_tags($_POST['username']);
  				$password = strip_tags($_POST['password']);
          $username = stripslashes($username);
  				$password = stripslashes($password);

          //encrypt password
          //$password = md5($password);

  				$userAdmindao->authenticate($username, $password);
  				if($userAdmindao->isAuthenticated()){
  					$_SESSION['AdminID'] = $userAdmindao;
  					header('Location: mailing_list.php');
  				} else {
            echo '<p>Invalid username or password<p>';
          }
  			}


include 'footer.php';
?>
