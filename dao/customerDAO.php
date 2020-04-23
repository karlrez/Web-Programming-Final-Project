<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employeeDAO
 *
 * @author Matt
 */
class customerDAO extends abstractDAO {

    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    /*
     * This is an example of how to use the query() method of a mysqli object.
     *
     * Returns an array of <code>Employee</code> objects. If no employees exist, returns false.
     */
    public function getCustomers(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM mailingList');
        $customers = Array();

        if(!$result) {
            return false;
        }

        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new employee object, and add it to the array.
                $customer = new Customer($row['customerName'], $row['phoneNumber'], $row['emailAddress'], $row['referrer']);
                $customers[] = $customer;
            }
            $result->free();
            return $customers;
        }
        $result->free();
        return false;
    }

    /*
     * This is an example of how to use a prepared statement
     * with a select query.
     */
    public function getID(){
        $result = $this->mysqli->query('SELECT * FROM mailingList');
        $ID = array();

        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['_id'];
                $ID[] = $id;
            }
            $result->free();
            return $ID;
        }
        $result->free();
        return false;
    }

    public function getCustomer($_id)
    {
        $query = 'SELECT * FROM mailingList WHERE _id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $temp = $result->fetch_assoc();
            $customer = new customer($temp['customerName'], $temp['phoneNumber'], $temp['emailAddress'], $temp['referrer']);
            $result->free();
            return $customer;
        }
        $result->free();
        return false;
    }

    public function addCustomer($customer){
        //if(!is_numeric($employee->getEmployeeId())){
            //return 'EmployeeId must be a number.';
        //}
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            $query = 'INSERT INTO mailingList(customerName,phoneNumber,emailAddress,referrer) VALUES (?,?,?,?)';
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized
            //query as a parameter.
            $stmt = $this->mysqli->prepare($query);
            //The first parameter of bind_param takes a string
            //describing the data. In this case, we are passing
            //three variables: an integer(employeeId), and two
            //strings (firstName and lastName).
            //
            // To make the "Notice" message go away passing in variables to bind_param
            $name = $customer->getName();
            $phone = $customer->getPhone();
            $email = $customer->getEmail();
            $referrer = $customer->getReferrer();
            //The string contains a one-letter datatype description
            //for each parameter. 'i' is used for integers, and 's'
            //is used for strings.
            $stmt->bind_param('ssss',
                    $name,
                    $phone,
                    $email,
                    $referrer);
            //Execute the statement
            $stmt->execute();
            //If there are errors, they will be in the error property of the
            //mysqli_stmt object.
            if($stmt->error){
                return $stmt->error;
            } else {
                return $customer->getName(). ' added successfully!';
            }
        } else {
            return 'Could not connect to Database.';
        }
    }

    public function deleteCustomer($id){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM mailingList WHERE _id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function editCustomer($customerName, $phoneNumber, $emailAddress, $id){
        if(!$this->mysqli->connect_errno){
            $query = 'UPDATE mailingList SET customerName = ?, phoneNumber = ?, emailAddress = ? WHERE _id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('sssi', $customerName, $phoneNumber, $emailAddress, $id);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}

?>
