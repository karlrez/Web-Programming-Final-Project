<?php require_once('dao/customerDAO.php');

#so we can call $_SESSION['AdminID'] later on
require_once('dao/userAdminDAO.php');
session_start();
include 'header.php';

$customerDAO = new customerDAO;
$customers = $customerDAO->getCustomers();
$customerIDs = $customerDAO->getID();

// Associative array of customer and id
$customerAndID = array();
if ($customers) {
    $i = 0;
    foreach ($customers as $customer) {
        $customerAndID[$customer->getName()] = $customerIDs[$i];
        $i++;
    }
}

echo "<div align = 'center'>";
if ($customers) {

    echo "<h3>Click on a name to remove from mailing list</h3>";
    //userAdmin info
    echo "<div align = 'left' border = 1px>";
    echo "<p>Session Admin ID: " . $_SESSION['AdminID']->getAdminId() . "</p>";
    echo "<p>Last Login Date: " . $_SESSION['AdminID']->getLastLoginDate() . "</p>";
    echo "<p>Session ID: " . session_id() . "</p>";
    echo "</div>";
    //table headings
    echo "<table border = 1px><tr><td>Customer Name</td><td>Phone</td><td>Email (Encrypted for privacy)</td><td>Referrer</td></tr>";
    //row and values
    foreach ($customers as $customer) {
        //CustomerName is the key in the array so it will return customerID
        echo '<tr><td><a href=\'edit_Customer.php?customerID=' . $customerAndID[$customer->getName()] . '\'>' . $customer->getName() . "</a></td>";
        echo "<td>" . $customer->getPhone() . "</td>";
        echo "<td>" . $customer->getEmail() . "</td>";
        echo "<td>" . $customer->getReferrer() . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "You can be the first on the mailing list!";
}
echo "</div>";
?>
<br>
<?php include 'footer.php' ?>