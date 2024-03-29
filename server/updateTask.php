<?php

	//Allow for CORS 
	//Activate only if required
	/*header('Access-Control-Allow-Origin: '. $_SERVER['HTTP_ORIGIN'] );
    header('Access-Control-Allow-Credentials: true' );
    header('Access-Control-Request-Method: *');
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: *,x-requested-with,Content-Type');
    header('X-Frame-Options: DENY');*/

	//Decode received JSON data
	$data = file_get_contents("php://input");
	$receivedData = json_decode($data);

	include_once 'db_function.php';

	$db 					= new DB_Functions();

	if(isset($receivedData->{"type"})){
		$response = '';
		switch ($receivedData->{"type"}) {
		    case 'newTask':
		        if(isset($receivedData->{"taskName"})){
		        	$taskName 	= $receivedData->{"taskName"};
		        	$taskDetail = $receivedData->{"taskDetail"};
		        	$taskDeadLine = $receivedData->{"deadLine"};
		        	$res = $db->storeTaskDetails($taskName, $taskDetail, $taskDeadLine);

		        	if($res)
		        	    $response = array("status" => 0,
		        	                      "message"=> "Success");
		        	else
		        	    $response = array("status" => 1,
		        	                      "message"=> "Error updating to DB");
		        }
		        else{
		        	$response = array("status" => 1,
	                      "message"=> "All fields needs to be set");
		        }
		        echo json_encode($response);
		    break;
		}
	}
	else {

	    $response = array("status" => 1,
	                      "message"=> "All fields needs to be set");
	    echo json_encode($response);
	}
?>