<?php
 require_once("Rest.inc.php");
 
 class API extends REST {
 
 public $data = "";
 
 const DB_SERVER = "127.0.0.1";
 const DB_USER = "root";
 const DB_PASSWORD = "1234";
 const DB = "testAPI";
 
private $db = NULL;
 private $mysqli = NULL;
 public function __construct(){
 parent::__construct(); // Init parent contructor
 $this->dbConnect(); // Initiate Database connection
 }
 
 /*
 * Connect to Database
 */
 private function dbConnect(){
 $this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
 }
 
 /*
 * Dynmically call the method based on the query string
 */
 public function processApi(){
 $func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
 if((int)method_exists($this,$func) > 0)
 $this->$func();
 else
 $this->response('',404); // If the method not exist with in this class "Page not found".
 }

 private function checkConn(){
 	if (mysqli_connect_errno())
    {
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else
	{
		if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

		$query="SELECT * FROM members";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status

	}
 // 	if($this->get_request_method() != "GET"){
				// $this->response('',406);
	// }
	// if(!$result = $this->mysqli->query("SELECT *FROM members ")){
	// 		    die('There was an error running the query [' . $this->mysqli->error . ']');
	// }
	// while($row = $result->fetch_assoc()){
 //    echo $row['userName'] . '<br />';
	// }
 //    $this->response($this->json($row), 200); // send user details
 //    $this->response('',204);  
    
 }
 
 
 private function login(){
 }
 
 private function customers(){
 }
 
 private function insertUser(){
	 	$customer = json_decode(file_get_contents("php://input"),true);	
		$query = "INSERT INTO members(userName,Phone) VALUES('".$customer['params']['username']."','".$customer['params']['password']."')";
		if(!empty($customer)){
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			$this->response($this->json($customer),200);
		}else
			$this->response('',204);	//"No Content" status

 }
 
 private function Edituser(){

 	$member = json_decode(file_get_contents("php://input"),true);
 	$query = "UPDATE members SET userName='".$member['params']['user']."', Phone='".$member['params']['phone']."'
	WHERE ID='".$member['params']['id']."' " ;

	$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
 	if ($r) {
 		$this->response('Edit success',200);
 	}
 	else{
 		$this->response('',204);
 	}

 }
 
 private function deleteUser(){
 	$id = (int)$this->_request['id'];
 	$query = "DELETE FROM members WHERE ID = $id ";
 	$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
 	if ($r) {
 		$this->response('success',200);
 	}
 	else{
 		$this->response('',204);
 	}
	
 	
 }

 /*
 * Encode array into JSON
 */
 private function json($data){
 if(is_array($data)){
 return json_encode($data);
 }
 }
 }
 
 // Initiiate Library
 
 $api = new API;
 $api->processApi();
?>