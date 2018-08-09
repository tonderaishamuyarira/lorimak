<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$project_type = $json->result->parameters->project_type;
    $professionalism = $json->result->parameters->professionalism;
	$know_how = $json->result->parameters->know_how;
    $timely_completion = $json->result->parameters->timely_completion;
	$value_for_money = $json->result->parameters->value_for_money;
	$recommend = $json->result->parameters->recommend;
	$satisfaction = $json->result->parameters->satisfaction;
	$recommendations = $json->result->parameters->recommendations;
	
	
	// Connect to Database

$server = "us-cdbr-iron-east-01.cleardb.net";
$username = "bace85d0f40589";
$password = "8a300288";
$db = "heroku_86cdb196b426113";
$connection = new mysqli($server, $username, $password, $db);

$sql2 = "insert into feedback(project_type,professionalism,know_how,timely_completion,value_for_money,recommend,satisfaction,recommendations) VALUES ($project_type,$professionalism,$know_how,$timely_completion,$value_for_money,$recommend,$satisfaction,$recommendations)";
$result2 = $connection->query($sql2);
$speech = "Thank you for your valued feedback. This will help us in improving the services we offer. If you have any additional feedback or questions we'd love to hear from you. You can email us on info@lorimak.co.zw.";


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
