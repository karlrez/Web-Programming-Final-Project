 <?php include 'header.php';
  require_once('./dao/customerDAO.php');

try{
            $customerDAO = new customerDAO();
            $abstractDAO = new abstractDAO();
            //Tracks errors with the form fields
            $hasError = false;
            //Array for our error messages
            $errorMessages = Array();


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
            if($count > 0){
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

        } catch(Exception $e){
            //If there were any database connection/sql issues,
            //an error message will be displayed to the user.
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';
        }
        ?>
            <div id="content" class="clearfix">
                        <aside>
                                <h2>Mailing Address</h2>
                                <h3>1385 Woodroffe Ave<br>
                                    Ottawa, ON K4C1A4</h3>
                                <h2>Phone Number</h2>
                                <h3>(613)727-4723</h3>
                                <h2>Fax Number</h2>
                                <h3>(613)555-1212</h3>
                                <h2>Email Address</h2>
                                <h3>info@wpeatery.com</h3>
                        </aside>
                        <div class="main">
                            <h1>Sign up for our newsletter</h1>
                            <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                            <form name="frmNewsletter" id="frmNewsletter" method="post" enctype="multipart/form-data" action="">
                                <table>
                                    <tr>
                                        <td>Name:</td>
                                        <td><input type="text" name="customerName" id="customerName" size='40'></td>
                                        <?php
                                        if (isset($errorMessages['name'])) {
                                            echo '<td style="color:red;">'.$errorMessages['name'].'</td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Phone Number:</td>
                                        <td><input type="text" name="phoneNumber" id="phoneNumber" size='40'></td>
                                        <?php
                                        if (isset($errorMessages['phone'])) {
                                            echo '<td style="color:red;">'.$errorMessages['phone'].'</td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Email Address:</td>
                                        <td><input type="text" name="emailAddress" id="emailAddress" size='40'></td>
                                        <?php
                                        if (isset($errorMessages['email'])) {
                                            echo '<td style="color:red;">'.$errorMessages['email'].'</td>';
                                        }
                                        if (isset($errorMessages['emailDupe'])) {
                                            echo '<td style="color:red;">'.$errorMessages['emailDupe'].'</td>';
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
                                            echo '<td style="color:red;">'.$errorMessages['referral'].'</td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                      <td>Choose a file to upload.</td>
                                    </tr>
                                    <tr>
                                        <td><input type="file" name="fileUpload" id="fileUpload" value="FileUpload"></td>
                                      </tr>
                                    <tr>
                                        <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                                    </tr>
                                </table>
                                </form>

            <?php
            if (!$hasError && $_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['emailAddress'];
            $customer = new Customer($_POST['customerName'], $_POST['phoneNumber'], $email, $_POST['referral']);
            $addSuccess = $customerDAO->addCustomer($customer);
            echo "<h3>".$addSuccess."</h3>";

            // file upload if file was uploaded to form
            if(isset($_FILES['fileUpload'])) {
              //target folder
              $target_dir = "files/";
              //path for the file
              $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
              //stores the extension of the file
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              //checking for duplicate upload
              if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                //uploading the file
              } else if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                  echo "<h3>The file ". basename( $_FILES["fileUpload"]["name"]). " uploaded!</h3>";
                } else {
                  echo "There was an error with the file upload";
      }
    }
}

              ?>
                    </div><!-- End Main -->
                    </div><!-- End Content -->
<?php include 'footer.php';?>
