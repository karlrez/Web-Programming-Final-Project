<?php


require_once('./dao/userAdminDAO.php');
session_start();
if(isset($_SESSION['AdminID'])){
	if($_SESSION['AdminID']->isAuthenticated()){
		//session_write_close();
		header('Location:mailing_list.php');
	}
}else{
	$missingFields = false;
	if(isset($_POST['submit'])){
		if(isset($_POST['username']) && isset($_POST['password'])){
			if($_POST['username'] == "" || $_POST['password'] == ""){
				$missingFields = true;
			} else {
				//All fields set, fields have a value
				$userAdmindao = new userAdminDAO();
				//if(!$userAdmindao->hasDbError()){
				$username = $_POST['username'];
				$password = $_POST['password'];
				$userAdmindao->authenticate($username, $password);
				if($userAdmindao->isAuthenticated()){
					$_SESSION['AdminID'] = $userAdmindao;
					header('Location: mailing_list.php');
				}
			}
		}
	}else{
		include 'header.php';
		?>
		<div id="content" class="clearfix">
	        <form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"><br><br>
	        <table align = 'center'>
	            <tr> <!-- leaving credentials in so people can view  -->
	                <td>Username:</td>
	                <td><input type="text" name="username" id="username" value="admin"></td>
	            </tr>
	            <tr>
	                <td>Password:</td>
	                <td><input type="password" name="password" id="password" value="admin"></td>
	            </tr>
	            <tr align = 'right'>
					<td></td>
	                <td><input type="reset" name="reset" id="reset" value="Reset" style="margin-right:10px; margin-top:5px;"><input type="submit" name="submit" id="submit" value="Login"></td>
	            </tr>
	        </table>  
			</form><br><br>
		</div>
	<?php
	}
}
include 'footer.php';
?>