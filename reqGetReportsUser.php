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
if (isset($data["userNIC"])) {
    $nic = $data['userNIC'];
    $text = "SELECT * FROM patient_report WHERE patient_nic = '".$nic."'";

    // get a patient from patient table
    
    $result = mysqli_query($con, $text);
    $count = 1;
    $users = array();
    $numRow = 0;

    if ($result) {
        // check for empty result
        $numRow = mysqli_num_rows($result);
        if ( $numRow > 0) {
			
			while($temp = mysqli_fetch_array($result)){
				$users[$count] = $temp;
				$count = $count +1;
			}

            // success
            $response["success"] = "1";
            $response["message"] = "User Successfully logged in.";
            $response["userReports"] = $users;
            $response["numRows"] = $numRow;
            
            // echoing JSON response
            echo json_encode($response);
        }	
		else 
		{
            // no patient found
            $response["success"] = "0";
            $response["message"] = "No Reports found";
 
            // echo no users JSON
            echo json_encode($response);
        }
    } 
    else {
        // no users found
        $response["success"] = "0";
        $response["message"] = "Error Occured";
 
        // echo no users JSON
        echo json_encode($response);
    }
} 
else {
    // required field is missing
    $response["success"] = "0";
    $response["message"] = ("Error Occured. Please Logout and Login again");
 
    // echoing JSON response
    echo json_encode($response);
}
?>


