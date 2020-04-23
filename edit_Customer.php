<?php
require_once('./dao/customerDAO.php');

try {
	$customerDAO = new customerDAO();
	$abstractDAO = new abstractDAO();
	$customer = $customerDAO->getCustomer($_GET['customerID']);
	//Tracks errors with the form fields
	$hasError = false;
	//Array for our error messages
	$errorMessages = array();

	//delete an entry from mail list
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteCustomer"])) {
		$customer = $customerDAO;
		$customerID = $_GET['customerID'];
		$deleteSuccess = $customerDAO->deleteCustomer($customerID);
		if ($deleteSuccess) {
			//Send the user back to the main page
			header("Location: mailing_list.php");
		} else {
			echo "An error occured";
		}
	}

	// Check values of form after submit
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["customerName"])) {
			$hasError = true;
			$errorMessages['name'] = "Please enter a name";
		} else {
			$name = ($_POST["customerName"]);
		}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["phoneNumber"])) {
			$hasError = true;
			$errorMessages['phone'] = "Please enter a phone number";
		} else {
			$phone = ($_POST["phoneNumber"]);
		}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST["phoneNumber"])) {
			$hasError = true;
			$errorMessages['phone'] = "Phone number format is \"888-888-888\"";
		} else {
			$phone = ($_POST["phoneNumber"]);
		}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["emailAddress"])) {
			$hasError = true;
			$errorMessages['email'] = "Please enter an email";
		} else {
			$email = ($_POST["emailAddress"]);
		}
	}

	//check duplicate email
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$_email = $_POST["emailAddress"];
		$sql = "SELECT * FROM mailingList where emailAddress = '$_email'";
		$email = $abstractDAO->getMysqli()->query($sql);
		$count = $abstractDAO->getMysqli()->affected_rows;
		if ($count > 0) {
			$hasError = true;
			$errorMessages['emailDupe'] = "Email already on the list!";
		}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (!filter_var($_POST["emailAddress"], FILTER_VALIDATE_EMAIL)) {
			$hasError = true;
			$errorMessages['email'] = "Please enter a valid email";
		} else {
			$email = ($_POST["emailAddress"]);
		}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["referral"])) {
			$hasError = true;
			$errorMessages['referral'] = "Please check how you heard about us";
		} else {
			$referrer = ($_POST["referral"]);
		}
	}
} catch (Exception $e) {
	//If there were any database connection/sql issues,
	//an error message will be displayed to the user.
	//echo '<h3>Error on page.</h3>';
	//echo '<p>' . $e->getMessage() . '</p>';
}
include 'header.php';
?>
<div id="content" class="clearfix">
	<aside>
		<h2>Delete Customer?</h2>
		<form name="deleteCustomer" id="deleteCustomer" method="post" action="">
			<input type='submit' name='deleteCustomer' id='deleteCustomer' value='Yes, I want to delete'>
		</form>

	</aside>
	<div class="main">
		<?php echo '<h1>Edit ' . $customer->getName() . '</h1>'; ?>
		<p>Please fill out the following form to update Customer</p>
		<form name="frmNewsletter" id="frmNewsletter" method="post" action="">
			<table>
				<tr>
					<td>Name:</td>
					<td><input type="text" name="customerName" id="customerName" size='40'></td>
					<?php
					if (isset($errorMessages['name'])) {
						echo '<td style="color:red;">' . $errorMessages['name'] . '</td>';
					}
					?>
				</tr>
				<tr>
					<td>Phone Number:</td>
					<td><input type="text" name="phoneNumber" id="phoneNumber" size='40'></td>
					<?php
					if (isset($errorMessages['phone'])) {
						echo '<td style="color:red;">' . $errorMessages['phone'] . '</td>';
					}
					?>
				</tr>
				<tr>
					<td>Email Address:</td>
					<td><input type="text" name="emailAddress" id="emailAddress" size='40'></td>
					<?php
					if (isset($errorMessages['email'])) {
						echo '<td style="color:red;">' . $errorMessages['email'] . '</td>';
					}
					if (isset($errorMessages['emailDupe'])) {
						echo '<td style="color:red;">' . $errorMessages['emailDupe'] . '</td>';
					}
					?>
				</tr>
				<tr>
					<td>How did you hear<br> about us?</td>
					<td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value="newspaper">
						Radio<input type="radio" name='referral' id='referralRadio' value='radio'>
						TV<input type='radio' name='referral' id='referralTV' value='TV'>
						Other<input type='radio' name='referral' id='referralOther' value='other'></td>
					<?php
					if (isset($errorMessages['referral'])) {
						echo '<td style="color:red;">' . $errorMessages['referral'] . '</td>';
					}
					?>

				</tr>
				<tr>
					<td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Update'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
				</tr>
			</table>
		</form>

		<?php
		if (!$hasError && $_SERVER["REQUEST_METHOD"] == "POST") {
			$customerName = $_POST['customerName'];
			$phoneNumber = $_POST['phoneNumber'];
			$emailAddress = $_POST['emailAddress'];
			$id = $_GET['customerID'];
			$updateSuccess = $customerDAO->editCustomer($customerName, $phoneNumber, $emailAddress, $id);
			if ($updateSuccess) {
				echo "Customer updated!";
			} else {
				echo "An error occured";
			}
		}

		?>

	</div><!-- End Main -->
</div><!-- End Content -->
<?php include 'footer.php'; ?>