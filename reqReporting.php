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
if (isset($data["patient_nic"]) && isset($data["symptoms"]) && isset($data["created_date"])) {
	
    $patient_nic = $data["patient_nic"];
    $symptoms = $data["symptoms"];
    $created_date = $data["created_date"];
    
    
    $stmt = $con->prepare("INSERT INTO `patient_report` (`report_id`, `patient_nic`, `created_date`, `symptoms`, `doctor_nic`, `approved_status`, `approval_date`, `disease_id`) VALUES (NULL, ?, ?, ?, NULL, NULL, NULL, NULL)");
	$stmt->bind_param("sss", $patient_nic, $created_date, $symptoms);
	$stmt->execute();
	if($stmt->affected_rows !== 0){
		$result = true;
	}
	else{
		$result = false;
	}
	$stmt->close();
    
    //$text = "INSERT INTO `patient_report` (`report_id`, `patient_nic`, `created_date`, `symptoms`, `doctor_nic`, `approved_status`, `approval_date`, `disease_id`) VALUES (NULL, '".$patient_nic."', '".$created_date."', '".$symptoms."', NULL, NULL, NULL, NULL);";
    //$result = mysqli_query($con, $text);
    
    if($result === true){
		
		// success
        $response["success"] = "1";
        $response["message"] = "User report successfully submitted.";
 
        // echoing JSON response
        echo json_encode($response);
	}
	
	else{
		// unsuccess
        $response["success"] = "0";
        $response["message"] = "Problem occured. Please try again later";
 
        // echoing JSON response
        echo json_encode($response);
	}
    
}
else{
	
	// unsuccess
    $response["success"] = "0";
    $response["message"] = "Required fields are missing";
 
    // echoing JSON response
    echo json_encode($response);
}

?>

