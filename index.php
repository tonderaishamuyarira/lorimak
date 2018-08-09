<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$employeeid = $json->result->parameters->employeeid;
    $nationalid = $json->result->parameters->national_id;
	$nationalid = str_replace(' ', '', $nationalid);
	
	// Connect to Database

$server = "us-cdbr-iron-east-05.cleardb.net";
$username = "b45dbf5cc85b62";
$password = "0025448a";
$db = "heroku_be2c1e3f2f85390";
$connection = new mysqli($server, $username, $password, $db);

$sql = "SELECT * from staff where code = $employeeid and national_id = '$nationalid'";
$result = $connection->query($sql);
$emp = $result->fetch_assoc(); 
if ($result->num_rows === 0) {
	$speech = "Sorry we could not find a match for the details provided.Please ensure you have entered the correct Employee Code and National ID number.";
	 }
else {
	$token = sha1(uniqid($employeeid, true));
$tym = $_SERVER['REQUEST_TIME'];
$mnth = date("m");
$yr = date("Y");
	$sql2 = "insert into pending_payslips(employee_id,token,tstamp,month,year) VALUES ($employeeid,'$token',$tym,$mnth,$yr)";
	$result2 = $connection->query($sql2);
$speech = "Thank You ". $emp['first_name']. ". Click on the following link to download your payslip. Please note that this link can only be used once and you will require your password to open the pdf file. \r\n 

http://quriousconsulting.com/payslip.php?token=$token";

}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
	//Close Database Connection
$connection->close();
	
}
else
{
	echo "Method not allowed";
}

?>
