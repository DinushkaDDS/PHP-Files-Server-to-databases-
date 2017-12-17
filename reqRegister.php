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
if (isset($data["patient_nic"]) && isset($data["firstName"]) && isset($data["middleName"]) && isset($data["lastName"]) && isset($data["gender"]) && isset($data["birthday"]) && isset($data["houseNo"]) && isset($data["age"]) && isset($data["street"]) && isset($data["town"]) && isset($data["city"]) && isset($data["province"]) && isset($data["contactNo"]) && isset($data["hint"]) && isset($data["password"])) {
	
    $patient_nic = $data["patient_nic"];
    $first_name = $data["firstName"];
    $middle_name = $data["middleName"];
    $last_name = $data["lastName"];
    $gender = $data['gender'];
    $birthday = $data['birthday'];
    $houseNo = $data['houseNo'];
    $age = $data['age'];
    $street = $data['street'];
    $town = $data['town'];
    $city = $data['city'];
    $province = $data['province'];
    $contactNo = $data['contactNo'];
    $hint = $data['hint'];
    $password = $data['password'];
    
    $text = "INSERT INTO `patient` (`patient_nic`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `age`, `house_number`, `street`, `town`, `city`, `province`, `contact_no`) VALUES ('".$patient_nic."', '".$first_name."', '".$middle_name."', '".$last_name."', '".$gender."', '".$birthday."', '".$age."','".$houseNo."', '".$street."', '".$town."', '".$city."', '".$province."', '".$contactNo."')";
    $result = mysqli_query($con, $text);
    
    if($result === true){
		
		$text = "INSERT INTO `patient_login` (`patient_nic`, `password`, `password_hint`) VALUES ('".$patient_nic."', '".$password."', '".$hint."')";
		$result = mysqli_query($con, $text);
		
		// success
        $response["success"] = "1";
        $response["message"] = "User Successfully registered.";
 
        // echoing JSON response
        echo json_encode($response);
	}
	
	else{
		// unsuccess
        $response["success"] = "0";
        $response["message"] = "Patient already registered";
 
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

