<?php
	
class DB_Functions{
	
	//Database connection string
	private $db;

	function __construct(){
		require_once 'config.php';
	}

	//destructor
	function __destruct() {
		 
	}

	public function storeTaskDetails($name, $details='', $deadLine){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "INSERT INTO table_name(field1, field2, field3, field4, date) values (:field1, :field2, 0, 0, NOW())";
			$response = $db->prepare($sql);
			$response->execute(array(':field1' => $name, ':field2' => $details));
			$db = null;
			return 1;
		}
		catch(Exception $e){
			return $e;
		}
	}
}
?>