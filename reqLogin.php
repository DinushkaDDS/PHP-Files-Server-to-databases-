<?php
 
/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();

$data = json_decode(file_get_contents('php://input'), true);

// include db connect class
require __DIR__ . '/db_connect.php';


// connecting to db
$db = new DB_CONNECT();
$con = $db->connect("root", "", "Epidemic Data");

// check for post data
if (isset($data["nic"]) && isset($data["password"])) {
    $nic = $data['nic'];
    $password = $data['password'];
    $text = "SELECT * FROM patient_login WHERE patient_nic = '".$nic."' && password = '".$password."'";

    // get a patient from patient table
    
    $result = mysqli_query($con, $text);

    if ($result) {
        // check for empty result
        if (mysqli_num_rows($result) > 0) {
 
            $result = mysqli_fetch_array($result);

            // success
            $response["success"] = "1";
            $response["message"] = "User Successfully logged in.";
            $response["user"] = $result;
            
            // echoing JSON response
            echo json_encode($response);
        } 
		else 
		{
            // no patient found
            $response["success"] = "0";
            $response["message"] = "No User found";
 
            // echo no users JSON
            echo json_encode($response);
        }
    } 
    else {
        // no users found
        $response["success"] = "0";
        $response["message"] = "No User found";
 
        // echo no users JSON
        echo json_encode($response);
    }
} 
else {
    // required field is missing
    $response["success"] = "0";
    $response["message"] = ("Fields are missing");
 
    // echoing JSON response
    echo json_encode($response);
}
?>


